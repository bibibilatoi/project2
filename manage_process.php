<?php

session_start();
require_once 'settings.php';

if(isset($_POST['login'])){
    $name = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM managers WHERE username = '$name'");
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if($password == $user["password"]){
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            header("Location: manage.php");
            exit();
        }
    }
    $_SESSION['login_error'] = 'Incorrect username or password';
    header("Location: login.php");
    exit();
}