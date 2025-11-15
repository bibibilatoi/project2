<?php
session_start();
require_once 'settings.php'; 

// Retrieve and clear session messages
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
];
$success_message = $_SESSION['success_message'] ?? ''; 

unset($_SESSION['login_error']);
unset($_SESSION['success_message']);

/**
 * Renders an error message securely.
 * @param string $error The error message content.
 * @return string HTML paragraph tag with the escaped error.
 */
function showError($error){
    // Security Fix: Escape content before outputting (XSS prevention)
    $safe_error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); 
    return !empty($safe_error) ? "<p class='error-message'>$safe_error</p>" : '';
}

/**
 * Renders a success message securely.
 * @param string $message The success message content.
 * @return string HTML paragraph tag with the escaped success message.
 */
function showSuccess($message){
    $safe_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); 
    return !empty($safe_message) ? "<p class='success-message'>$safe_message</p>" : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Apply for a position at SpeedX">
    <meta name="keywords" content="job application, SpeedX, IT, AI, tech">
    <meta name="author" content="SpeedX Team">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">
    <link href="styles/common_styles.css" rel="stylesheet">
    <link href="styles/login_styles.css" rel="stylesheet">
    
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <title>Job Application</title>
</head>
<body>
    <main id="login-main">
        <div id="main-container">
            <h1>Login</h1>

            <!-- Display Success Message (e.g., after successful registration) -->
            <?php if (!empty($success_message)): ?>
                <?= showSuccess($success_message); ?>
            <?php endif; ?>

            <!-- Display Error Message -->
            <?php if (!empty($errors['login'])): ?>
                <?= showError($errors['login']); ?>
            <?php endif; ?>

            <form method="post" action="manage_process_login.php">
                <div class="input-group">
                    <label>Username:</label>
                    <div class="input-with-icon">
                        <span class='bx bx-user field-icon'></span>
                        <input type="text" name="username" id="username" placeholder="Enter your username" required >
                    </div>
                </div>

                <div class="input-group">
                    <label>Password:</label>
                    <div class="input-with-icon password-wrapper">
                        <span class='bx bx-lock-alt field-icon'></span>
                        <input type="password" name="password" id="password-field" placeholder="Enter your password" required>
                    </div>
                </div>



                <button type="submit" name="login">Login</button>


            </form>

            <p class="text-center text-sm text-gray-600">
                New Manager? 
                <a href="enhancements.php" class="font-medium text-blue-600 hover:text-blue-500">Register here</a>
            </p>
        </div>
    </main>

</body>
</html>



abcdef
Long-12345


abcdef
Long-12345

abcdef
Long-12345