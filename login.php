<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
];


session_unset();

function showError($error){
    return !empty($error) ? "<p class='error_message'>$error</p>" : '';
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/login_styles.css" rel="stylesheet">
        <link href='https://cdn.boxicons.com/3.0.3/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link href='https://cdn.boxicons.com/3.0.3/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
        <title>Home Page</title>
    </head>
<body id="login_body">
    <div id="all">
        <div class="background"></div>
        <div class="container">
            <div class="content">
                <h2 class="logo"><i class='bxr  bx-rocket' ></i> SpeedX</h2>
                <div class="text-sci">
                    <h2>Welcome!<br><span>To login management page</span></h2>
                </div>
                <div class="social-icons">
                    <a href="#"><i class='bxl  bx-facebook'></i> </a>
                    <a href="#"><i class='bxl  bx-linkedin'></i> </a>
                    <a href="#"><i class='bxl  bx-instagram'></i> </a>
                    <a href="#"><i class='bxl  bx-youtube' ></i> </a>
                </div>
            </div>

            <div class="login_container">
                <div class ="login_form_box" id="login_form">
                    <form action="manage_process.php" method="post">
                        <h2>Login</h2>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-user'></i> </span>
                            <input class="login_input" type ="text" name="username" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false"required>
                            <label>Username</label>
                        </div>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-lock'></i></span>
                            <input class="login_input" type ="password" name="password" required>
                            <label>Password</label>
                        </div>
                        <?= showError($errors['login']); ?>
                        <div class="buttons">
                            <button class="back_button" onclick="window.location.href='index.php'" name="back"><i class='bx  bx-reply-stroke'></i></button>
                            <button class="login_button" type="submit" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>