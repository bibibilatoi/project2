<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
];


session_unset();

function showError($error){
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}


?>
<?php include 'head.inc'; ?>

<!DOCTYPE html>
<html lang="en">
<body id="login_body">
    <div id="all">
        <div>
            <img id="Manager_img" src="styles/images/Managers.jpg" alt="Manager" style="height: 800px;%" >
        </div>
        <div id="main_content">
            <div id="goBackVisibility" class="base-margin-bottom show">
                <button class="go-back">
                    <span class="arrow">←</span>
                    Go back
                </button>
            </div>
            <div class="login-pf-header">          
                <div id="kc-page-title">        
                    <h1 id="Welcome_text-Welcome">Welcome!</h1>
                    <h3 id="Welcome_text-Pleaselogintoyouraccount">Please login to your account.</h3>
                </div>
            </div>
            <div id="login_container">
                <div id ="login_form_box" id="login_form">
                    <form action="manage_process.php" method="post">
                        <h2 id="login_login">Login</h2>
                        <?= showError($errors['login']); ?>
                        <input class="login_input" type ="text" name="username" placeholder="Username" required>
                        <input class="login_input" type ="password" name="password" placeholder="Password" required>
                        <button class="login_button" type="submit" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>