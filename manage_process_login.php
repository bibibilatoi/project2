<?php

session_start();
require_once 'settings.php';

if(isset($_POST['login'])){
    $name = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    // Initialize attempt tracker
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
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_attempt_time'] = time();
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: manage.php");
            exit();
        }
    }
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt_time'] = time();

    $_SESSION['login_error'] = 'Incorrect username or password!';
    header("Location: login.php");
    exit();
}
