

<!--***************************************************-->
<!--***************************************************-->
<!--Document for register.php and manage_process_register.php: 
This is just a note showing what happens in register feature
-->
<!--***************************************************-->
<!--***************************************************-->




<?php 
session_start();  

$errors = [
    'register' => $_SESSION['register_error'] ?? '',    
];


session_unset();

function showError($error){
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';  /*=> show error if there is; otherwise not.*/
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
        <link href='https://cdn.boxicons.com/3.0.3/fonts/basic/boxicons.min.css' rel='stylesheet'>     <!--bloxicon - a website for web icons--> 
        <link href='https://cdn.boxicons.com/3.0.3/fonts/brands/boxicons-brands.min.css' rel='stylesheet'> <!--bloxicon - a website for web icons--> 
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
                <div class="social-icons">                                => social icons by bloxicons
                    <a href="#"><i class='bxl  bx-facebook'></i> </a>    
                    <a href="#"><i class='bxl  bx-linkedin'></i> </a>     
                    <a href="#"><i class='bxl  bx-instagram'></i> </a>
                    <a href="#"><i class='bxl  bx-youtube' ></i> </a>
                </div>
            </div>

            <div class="register_container">
                <div class ="register_form_box" id="register_form"> <!--Create a form-->
                    <form action="manage_process_register.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false"> <!--disable autocomplete, autocorret, autocapitalize, and spellcheck on all inputs-->
                        <h2>Register</h2>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-user'></i> </span> 
                            <input class="register_input" type ="text" name="username" required> <!--Username input-->
                            <label>Username</label>
                        </div>
                        <div class="input_box">
                            <span class="icon"><i class='bx  bx-lock'></i></span>
                            <input class="register_input" type ="password" name="password" required> <!--Password input-->
                            <label>Password</label> 
                        </div>
                        <div class="input_box">
                            <span class="icon"><i class='bxr  bx-envelope-open'></i> </span>
                            <input class="register_input" type ="email" name="email" required> <!--Email input-->
                            <label>Email</label>
                        </div>
                        <?= showError($errors['register']); ?>        <!--Show error message (function is on the line 24)-->
                        <div class="buttons">
                            <a class="back_button" href="login.php">&larr;</a>
                            <button class="register_button" type="submit" name="Register">Register</button> <!--Register button-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>



<!--manage_process_register-->

<?php

session_start();
require_once 'settings.php'; /*Get user setting and database information */
if(isset($_POST['Register'])){
    /*Get inputs from users and use trim to remove whitespace and other unwanted characters */
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? ''); 
    /*check if there is a same email or username in the database */
    $stmt = $conn ->prepare("SELECT email, username from managers WHERE email=? OR username = ?");
    $stmt ->bind_param("ss", $email, $username);
    $stmt -> execute();
    $stmt -> store_result();
     /*If yes, then print the error message*/
    if($stmt->num_rows != 0){
        $_SESSION['register_error'] = 'Email or username Already exist';
        header("Location: register.php");
        exit();
    }
    $stmt ->close();
     /*making a set of rule for the password and hashing password*/
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/";
    if (!preg_match($pattern, $password)) {
        $_SESSION['register_error'] = 'Password must be at least 9 characters long and include uppercase, lowercase, number, and special character.';
        header("Location: register.php");
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
     /*If all conditions are followed, then inserting information into the managers database*/
    $stmt = $conn->prepare("INSERT INTO managers (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    if($stmt->execute()){
        header("Location: login.php");
    }
    /*Print error if the command was not executed */
    else{
        $_SESSION['register_error'] = 'An error occurred. Please try again later.';
        header("Location: register.php");
    }
    $stmt ->close();
}




?>




?>
