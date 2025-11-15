<?php
session_start();
require_once "settings.php";

// --- Prevent direct access ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['form_token'], $_SESSION['apply_form_token']) ||
    $_POST['form_token'] !== $_SESSION['apply_form_token']
) {
    unset($_SESSION['apply_form_token']);
    die("<div class='error-msg'>Access denied. Please submit the form from the Apply page.</div>");
}

// Valid submission -> delete the token -> avoid persistence with same token
// Only infos stored is confirm eoi which is only displayed info and not fetching/inserting anything
unset($_SESSION['apply_form_token']);

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// --- Collect main EOI data ---
$reference_number = $conn->real_escape_string($_POST['reference_number']);
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
$gender = $conn->real_escape_string($_POST['gender']);
$street = $conn->real_escape_string($_POST['street']);
$suburb = $conn->real_escape_string($_POST['suburb']);
$state = $conn->real_escape_string($_POST['state']);
$postcode = $conn->real_escape_string($_POST['postcode']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$other_skills = $conn->real_escape_string($_POST['other_skills'] ?? '');

// --- Insert EOI ---
$stmt = $conn->prepare("INSERT INTO eoi 
    (reference_number, first_name, last_name, date_of_birth, gender, street, suburb, `state`, postcode, email, phone, other_skills)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "ssssssssssss", 
    $reference_number, $first_name, $last_name, $date_of_birth, $gender, 
    $street, $suburb, $state, $postcode, $email, $phone, $other_skills
);

if (!$stmt->execute()) {
    die("<div class='error-msg'>Error submitting EOI: " . $stmt->error . "</div>");
}

$eoi_number = $stmt->insert_id;
$stmt->close();


if (!empty($_POST['skills']) && is_array($_POST['skills'])) {
    $stmt_skill = $conn->prepare("INSERT INTO user_skills (eoi_number, skill_id) VALUES (?, ?)");
    if (!$stmt_skill) {
        die("Prepare failed for skills: " . $conn->error);
    }
    foreach ($_POST['skills'] as $skill_id) {
        $skill_id = (int)$skill_id; // cast to int for safety
        $stmt_skill->bind_param("ii", $eoi_number, $skill_id);
        if (!$stmt_skill->execute()) {
            error_log("Skill insert failed: " . $stmt_skill->error);
        }
    }
    $stmt_skill->close();
}

// Save EOI number in session for confirmation page
$_SESSION['eoi_confirm'] = $eoi_number;

header("Location: confirm_eoi.php");
exit;
?>
