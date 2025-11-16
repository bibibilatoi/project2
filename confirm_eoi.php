<?php
session_start();
require_once "settings.php";

// Define the maximum viewing time (seconds) 
// After the time expire, if refresh the page or change the url then the page cant be accessed
$MAX_VIEW_TIME = 60; 

//Check for explicit finish
if (isset($_POST['finish'])) {
    unset($_SESSION['eoi_confirm']);
    unset($_SESSION['eoi_confirm_time']); 
    header("Location: apply.php");
    exit;
}

//Check remaining time left
$is_expired = false;
if (isset($_SESSION['eoi_confirm_time']) && (time() - $_SESSION['eoi_confirm_time']) > $MAX_VIEW_TIME) {
    $is_expired = true;
}
// If access is denied or time out -> clear any lingering session keys
if (!isset($_SESSION['eoi_confirm']) || $is_expired) {
    unset($_SESSION['eoi_confirm']);
    unset($_SESSION['eoi_confirm_time']); 
    header("Location: apply.php");
    exit;
}

$eoi_number = (int)$_SESSION['eoi_confirm'];

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    // If the database connection fails, clear the session and die to prevent re-attempts/loops.
    unset($_SESSION['eoi_confirm']); 
    die("<p>Database connection failed: " . $conn->connect_error . "</p>");
}


$stmt = $conn->prepare("SELECT * FROM eoi WHERE eoi_number = ?");
if (!$stmt) {
    unset($_SESSION['eoi_confirm']); 
    $conn->close();
    die("Prepare failed for EOI: " . $conn->error);
}
$stmt->bind_param("i", $eoi_number);
$stmt->execute();
$result = $stmt->get_result();
$eoi = $result->fetch_assoc();
$stmt->close();


$stmt_skills = $conn->prepare("
    SELECT s.skill_name 
    FROM skills s
    JOIN user_skills us ON s.skill_id = us.skill_id
    WHERE us.eoi_number = ?
");
if (!$stmt_skills) die("Prepare failed for skills: " . $conn->error);
$stmt_skills->bind_param("i", $eoi_number);
$stmt_skills->execute();
$skill_result = $stmt_skills->get_result();

$skills_html = '';
if ($skill_result && $skill_result->num_rows > 0) {
    $skills_html = '<ul class="skill-list">';
    while ($s = $skill_result->fetch_assoc()) {
        $skills_html .= '<li>' . htmlspecialchars($s['skill_name']) . '</li>';
    }
    $skills_html .= '</ul>';
}
$stmt_skills->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/common_styles.css">
    <link rel="stylesheet" href="styles/process_eoi_styles.css">
    <title>EOI Confirmation</title>
</head>
<body>
<main class="eoi-main">
    <div class="eoi-wrapper">
        <h2 class="eoi-title">Thank you! Your application has been submitted.</h2>
        <table class="eoi-table">
            <tr><th>EOI Number</th><td><?= htmlspecialchars($eoi['eoi_number']) ?></td></tr>
            <tr><th>Job Reference</th><td><?= htmlspecialchars($eoi['reference_number']) ?></td></tr>
            <tr><th>Name</th><td><?= htmlspecialchars($eoi['first_name'] . ' ' . $eoi['last_name']) ?></td></tr>
            <tr><th>Date of Birth</th><td><?= htmlspecialchars($eoi['date_of_birth']) ?></td></tr>
            <tr><th>Gender</th><td><?= htmlspecialchars($eoi['gender']) ?></td></tr>
            <tr><th>Address</th><td><?= htmlspecialchars($eoi['street'] . ', ' . $eoi['suburb'] . ', ' . $eoi['state'] . '. Postcode:' . $eoi['postcode']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($eoi['email']) ?></td></tr>
            <tr><th>Phone</th><td><?= htmlspecialchars($eoi['phone']) ?></td></tr>
            <tr><th>Other Skills / Notes</th><td><?= nl2br(htmlspecialchars($eoi['other_skills'])) ?></td></tr>
            <?php if ($skills_html): ?>
                <tr><th>Selected Skills</th><td><?= $skills_html ?></td></tr>
            <?php endif; ?>
        </table>
    </div>
    <!-- Finish button -->
    <form method="post" id="finish-form">
        <button type="submit" name="finish" id="finish-button">Finish</button>
    </form>
</main>
</body>
</html>
