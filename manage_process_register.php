<?php

session_start();

// Ensure this script is only accessible via POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['register'])) {
    header("Location: register.php");
    exit();
}

// Include your database connection ($conn)
require_once 'settings.php'; 

// --- 1. Input Retrieval and Sanitization ---

$errors = [];

// Retrieve inputs
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// Sanitize inputs for display/use in query
$safe_username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$safe_email = filter_var($email, FILTER_SANITIZE_EMAIL);


// --- 2. Input Validation ---

if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
    $errors[] = "All fields are required.";
}

if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "The email address is not valid.";
}

if ($password !== $password_confirm) {
    $errors[] = "Passwords do not match.";
}

if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}


// --- 3. Database Check for Existing User ---

if (empty($errors)) {
    $stmt = null;
    try {
        // Check if username or email already exists using prepared statement
        $stmt = $conn->prepare("SELECT COUNT(*) FROM managers WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $safe_username, $safe_email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $errors[] = "A manager with this username or email already exists.";
        }

    } catch (Exception $e) {
        error_log("Registration check error: " . $e->getMessage());
        $errors[] = "An internal error occurred during validation.";
    }
}

// --- 4. Process Errors and Redirect ---

if (!empty($errors)) {
    // Join all errors into a single string for display, using <br> for line breaks
    $_SESSION['register_error'] = implode('<br>', $errors);
    // Store original non-sensitive POST data for sticky fields
    $_SESSION['register_data'] = ['username' => $username, 'email' => $email];
    
    header("Location: register.php");
    exit();
}


// --- 5. Secure Hashing and Database Insertion ---

$stmt = null;
try {
    // Generate a secure password hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement for insertion
    $stmt = $conn->prepare("INSERT INTO managers (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $safe_username, $safe_email, $hashed_password);
    
    if ($stmt->execute()) {
        // Success: Redirect to login page with success message
        $_SESSION['success_message'] = "Registration successful! You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        // Execution failed
        $_SESSION['register_error'] = "Registration failed. Please try again.";
        header("Location: register.php");
        exit();
    }

} catch (Exception $e) {
    // Handle critical insertion errors
    error_log("Registration insertion error: " . $e->getMessage());
    $_SESSION['register_error'] = "A critical error occurred. Please try again later.";
    header("Location: register.php");
    exit();
} finally {
    if ($stmt) {
        $stmt->close();
    }
}
?>