<?php

session_start();
require_once 'settings.php';
$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    $_SESSION['login_error'] = 'Database connection failed.';
    header("Location: login.php");
    exit();
}
// Check Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $conn->close();
    header("Location: login.php");
    exit();
}
if(isset($_POST['login'])){
    $name = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $success = false; // Flag to track success/failure for unified cleanup


    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = 0;
    }

    // Check if user needs to wait before trying again
    if ($_SESSION['login_attempts'] >= 3) {
        $delay = min(5 * $_SESSION['login_attempts'], 30); // 5s, 10s, 15s, capped at 30s
        $time_since_last = time() - $_SESSION['last_attempt_time'];
        if ($time_since_last < $delay) {
            $wait = $delay - $time_since_last;
            $_SESSION['login_error'] = "Too many failed attempts. Please wait {$wait} seconds before trying again.";
            $conn->close();
            header("Location: login.php");
            exit();
        }
    }

    $stmt = $conn->prepare("SELECT username, email, password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $success = true;
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_attempt_time'] = time();
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
        }
    }

    if (isset($result) && $result instanceof mysqli_result) {
        $result->close();
    }
    if (isset($stmt)) {
        $stmt->close();
    }
    
    $conn->close();

    if ($success) {
        header("Location: manage.php");
    } else {
        // Increment attempts and set error on failure
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        $_SESSION['login_error'] = 'Incorrect username or password!';
        header("Location: login.php");
    }
    exit();
}
?>