<?php
session_start();



// Allow access if it's a POST request with the token (from login.php's "link"),
// OR if there is an error set in the session (indicating a redirect from manage_process_register.php)
if (
    ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['access_via_login'], $_SESSION['reg_token']) ||
    $_POST['access_via_login'] !== $_SESSION['reg_token']) &&
    !isset($_SESSION['register_error'])
){
    unset($_SESSION['reg_token']);
    die("Access Denied!");
}

// Add a new token for CSRF protection on the form submission
// This is different from 'reg_token', which is just for page access
if (empty($_SESSION['error_check_token'])) {
    $_SESSION['error_check_token'] = bin2hex(random_bytes(16));
}

$errors = [
    'register' => $_SESSION['register_error'] ?? '',
];

unset($_SESSION['register_error']);

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
                <div id="logo">
                    <img src="images/speedx_logo.png" height="50" width="50" alt="SpeedX logo">
                    <p>SpeedX</p>
                </div>
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
                    <input type="hidden" name="error_token" value="<?php echo $_SESSION['error_check_token']; ?>">    
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