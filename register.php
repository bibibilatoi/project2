<?php
session_start();

$errors = [
    'register' => $_SESSION['register_error'] ?? '',
];


session_unset();

function showError($error){
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
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
        <link href="styles/register_styles.css" rel="stylesheet">
        <link href='https://cdn.boxicons.com/3.0.3/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link href='https://cdn.boxicons.com/3.0.3/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
        <title>Home Page</title>
    </head>
<body id="register_body">
    <div id="all">
        <div class="background"></div>
        <div class="container">
            <div class="content">
                <h2 class="logo"><i class='bxr  bx-rocket' ></i> SpeedX</h2>
                <div class="text-sci">
                    <h2>Welcome!<br><span>To Register management page</span></h2>
                </div>
                <div class="social-icons">
                    <a href="#"><i class='bxl  bx-facebook'></i> </a>
                    <a href="#"><i class='bxl  bx-linkedin'></i> </a>
                    <a href="#"><i class='bxl  bx-instagram'></i> </a>
                    <a href="#"><i class='bxl  bx-youtube' ></i> </a>
                </div>
            </div>

            <div class="register_container">
                <div class ="register_form_box" id="register_form">
                    <form action="manage_process_register.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false">
                        <h2>Register</h2>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-user'></i> </span>
                            <input class="register_input" type ="text" name="username" required>
                            <label>Username</label>
                        </div>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-lock'></i></span>
                            <input class="register_input" type ="password" name="password" required>
                            <label>Password</label>
                        </div>
                        <div class="input_box">
                            <span class="icon"><i class='bxr  bx-envelope-open'></i> </span>
                            <input class="register_input" type ="email" name="email" required>
                            <label>Email</label>
                        </div>
                        <?= showError($errors['register']); ?>
                        <div class="buttons">
                            <a class="back_button" href="login.php">&larr;</a>
                            <button class="register_button" type="submit" name="Register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>