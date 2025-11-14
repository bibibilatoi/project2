<?php

session_start();
require_once 'settings.php';
if(isset($_POST['Register'])){
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? ''); 
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/";
    if (!preg_match($pattern, $password)) {
        $_SESSION['register_error'] = 'Password must be at least 9 characters long and include uppercase, lowercase, number, and special character.';
        header("Location: register.php");
        exit();
    }
    $stmt = $conn ->prepare("SELECT email from managers WHERE email=?");
    $stmt ->bind_param("s", $email);
    $stmt -> execute();
    $stmt -> store_result();
    if($stmt->num_rows != 0){
        $_SESSION['register_error'] = 'This email is used, Try another One';
        header("Location: register.php");
        exit();
    }
    $stmt ->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO managers (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    if($stmt->execute()){
        header("Location: login.php");
    }
    else{
        $_SESSION['register_error'] = 'An error occurred. Please try again later.';
        header("Location: register.php");
    }
    $stmt ->close();
}




?>