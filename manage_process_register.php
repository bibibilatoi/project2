<?php

session_start();
require_once 'settings.php';
//Prevent Direct URL Access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    // If connection fails, set an error and exit gracefully
    $_SESSION['register_error'] = 'Database connection failed. Please try again later.';
    header("Location: register.php");
    exit();
}



if(isset($_POST['Register'])){
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? ''); 


    $stmt = $conn ->prepare("SELECT email, username from managers WHERE email=? OR username = ?");
    $stmt ->bind_param("ss", $email, $username);
    $stmt -> execute();
    $stmt -> store_result();


    if($stmt->num_rows != 0){
        $stmt->close();
        $conn->close();
        $_SESSION['register_error'] = 'Email or username Already exist';
        header("Location: register.php");
        exit();
    }

    $stmt ->close();


    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/";
    if (!preg_match($pattern, $password)) {
        $conn->close();
        $_SESSION['register_error'] = 'Password must be at least 9 characters long and include uppercase, lowercase, number, and special character.';
        header("Location: register.php");
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Insert New User To Database
    $stmt = $conn->prepare("INSERT INTO managers (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    
    if($stmt->execute()){
        // Success -> Redirect to login
        $stmt->close();
        $conn->close();
        header("Location: login.php");
    }
    else{
        $stmt->close();
        $conn->close();
        $_SESSION['register_error'] = 'An internal error occurred. Please try again later.';
        header("Location: register.php");
    }
    exit();
}

$conn->close();
header("Location: register.php");
exit();


?>