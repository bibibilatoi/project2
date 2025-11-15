<?php

session_start();

// Ensure this script is only accessible via POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['login'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection ($conn)
require_once 'settings.php'; 

// Initialize attempt tracker
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0;
}

// --- Input Handling and Validation ---

$name = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Basic Input Validation
if (empty($name) || empty($password)) {
    $_SESSION['login_error'] = 'Both username and password are required.';
    header("Location: login.php");
    exit();
}

// Sanitize username (important if username is ever echoed in the UI unescaped)
$safe_name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// --- Brute-Force Protection Logic ---

const MAX_ATTEMPTS = 5; 
const DELAY_INCREMENT = 10; 
const MAX_DELAY = 60; 

// 1. Increment the counter for the current attempt
$_SESSION['login_attempts']++; 
$_SESSION['last_attempt_time'] = time();

if ($_SESSION['login_attempts'] > MAX_ATTEMPTS) {
    // Calculate required delay time
    $delay_time = min(
        DELAY_INCREMENT * ($_SESSION['login_attempts'] - (MAX_ATTEMPTS - 1)), 
        MAX_DELAY
    );
    
    $time_since_last = time() - $_SESSION['last_attempt_time'];

    if ($time_since_last < $delay_time) {
        $wait = $delay_time - $time_since_last;
        
        // Use sleep() to counter time-based enumeration.
        if ($wait > 0) {
            sleep($wait); 
        }
        
        $_SESSION['login_error'] = "Too many failed attempts. Please wait for the delay to pass.";
        header("Location: login.php");
        exit();
    }
}
// Optionally reset the counter if a long time has passed since the last fail
if ($_SESSION['last_attempt_time'] < (time() - 3600)) { 
     $_SESSION['login_attempts'] = 1; 
}


// --- Database Interaction ---

$stmt = null;
$user = null;
$login_success = false;
$error_message = 'Incorrect username or password!';

try {
    // Select user details using prepared statements
    $stmt = $conn->prepare("SELECT username, email, password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $safe_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Secure password verification
        if (password_verify($password, $user['password'])) {
            $login_success = true;
        }
    }

} catch (Exception $e) {
    error_log("Login database error: " . $e->getMessage());
    $error_message = 'An internal error occurred. Please try again later.';
} finally {
    if ($stmt) {
        $stmt->close();
    }
}


// --- Final Result Handling ---

if ($login_success) {
    // Success: Reset counter and set session variables
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0; 

    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    
    // Crucial: Regenerate the session ID after successful login to prevent Session Fixation
    session_regenerate_id(true);

    // Redirect to the protected area (e.g., manager dashboard)
    header("Location: manage.php");
    exit();
} else {
    // Failed Login: Error message is already set above
    $_SESSION['login_error'] = $error_message;
    header("Location: login.php");
    exit();
}
?>