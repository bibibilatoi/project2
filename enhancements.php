<?php
session_start();

// Initialize error variable from session
$error = $_SESSION['register_error'] ?? '';
$old_data = $_SESSION['register_data'] ?? [];

// Clear the session errors and old data after retrieving it
unset($_SESSION['register_error']);
unset($_SESSION['register_data']);

/**
 * Renders an error message securely.
 * @param string $error The error message content (may contain <br> tags).
 * @return string HTML paragraph tag with the escaped error.
 */
function showError($error){
    // Allow <br> tags for multi-line errors but escape other HTML
    $safe_error = str_replace('<br>', '[[BR]]', $error);
    $safe_error = htmlspecialchars($safe_error, ENT_QUOTES, 'UTF-8'); 
    $safe_error = str_replace('[[BR]]', '<br>', $safe_error);
    return !empty($safe_error) ? "<p class='error-message'>$safe_error</p>" : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manager Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">
    <!-- Load Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Exo 2', sans-serif; background-color: #f4f7f9; }
        .error-message { padding: 10px; border-radius: 4px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; margin-bottom: 1rem; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <main class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800">Register Manager</h1>

        <!-- Display Error Message -->
        <?php if (!empty($error)): ?>
            <?= showError($error); ?>
        <?php endif; ?>

        <form method="post" action="manage_process_register.php" class="space-y-6">
            <div class="space-y-4">
                
                <!-- Username -->
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <div class="relative">
                    <span class='bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></span>
                    <input type="text" name="username" id="username" required 
                           value="<?= htmlspecialchars($old_data['username'] ?? '', ENT_QUOTES); ?>"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                           placeholder="Choose a username">
                </div>

                <!-- Email -->
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <span class='bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></span>
                    <input type="email" name="email" id="email" required
                           value="<?= htmlspecialchars($old_data['email'] ?? '', ENT_QUOTES); ?>"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                           placeholder="Enter your email">
                </div>

                <!-- Password -->
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <span class='bx bx-lock-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></span>
                    <input type="password" name="password" id="password" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                           placeholder="Create a password (min 8 chars)">
                </div>
                
                <!-- Confirm Password -->
                <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="relative">
                    <span class='bx bx-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></span>
                    <input type="password" name="password_confirm" id="password_confirm" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                           placeholder="Confirm your password">
                </div>
            </div>

            <button type="submit" name="register" 
                    class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Register
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Already have an account? 
            <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">Login here</a>
        </p>
    </main>
</body>
</html>