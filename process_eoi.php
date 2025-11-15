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

// Valid submission -> delete the token -> avoid reuse
unset($_SESSION['apply_form_token']);

// --- Initialize DB connection ---
$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// --- Helper function for sanitization ---
function clean_input($conn, $data) {
    return $conn->real_escape_string(trim($data));
}

// --- Collect and sanitize input ---
$reference_number = clean_input($conn, $_POST['reference_number'] ?? '');
$first_name = clean_input($conn, $_POST['first_name'] ?? '');
$last_name = clean_input($conn, $_POST['last_name'] ?? '');
$date_of_birth = clean_input($conn, $_POST['date_of_birth'] ?? '');
$gender = clean_input($conn, $_POST['gender'] ?? '');
$street = clean_input($conn, $_POST['street'] ?? '');
$suburb = clean_input($conn, $_POST['suburb'] ?? '');
$state = clean_input($conn, $_POST['state'] ?? '');
$postcode = clean_input($conn, $_POST['postcode'] ?? '');
$email = clean_input($conn, $_POST['email'] ?? '');
$phone = clean_input($conn, $_POST['phone'] ?? '');
$other_skills = clean_input($conn, $_POST['other_skills'] ?? '');

// --- Server-side validation ---
$errors = [];

// Required fields
$required = [
    'Reference Number' => $reference_number,
    'First Name' => $first_name,
    'Last Name' => $last_name,
    'Date of Birth' => $date_of_birth,
    'Gender' => $gender,
    'Street' => $street,
    'Suburb' => $suburb,
    'State' => $state,
    'Postcode' => $postcode,
    'Email' => $email,
    'Phone' => $phone
];

foreach ($required as $field => $value) {
    if (empty($value)) $errors[] = "$field is required.";
}

// Validate email
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// Validate date of birth (YYYY-MM-DD)
if (!empty($date_of_birth) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth)) {
    $errors[] = "Date of Birth must be in YYYY-MM-DD format.";
}

// Validate postcode (numbers only, 4-6 digits)
if (!empty($postcode) && !preg_match('/^\d{4,6}$/', $postcode)) {
    $errors[] = "Postcode must be 4-6 digits.";
}

// Validate phone (numbers, spaces, +, -)
if (!empty($phone) && !preg_match('/^[\d\+\-\s]{8,20}$/', $phone)) {
    $errors[] = "Phone number contains invalid characters.";
}

// Validate gender
$valid_genders = ['Male', 'Female', 'Other'];
if (!empty($gender) && !in_array($gender, $valid_genders)) {
    $errors[] = "Invalid gender selected.";
}

// Validate skills
$skills_selected = !empty($_POST['skills']) && is_array($_POST['skills']) && count($_POST['skills']) > 0;
$other_skills_filled = !empty(trim($_POST['other_skills'] ?? ''));

if (!$skills_selected && !$other_skills_filled) {
    $errors[] = "You must select at least one skill or enter other skills.";
}

// --- If errors exist, display and stop ---
if (!empty($errors)) {
    echo "<div class='error-msg'><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul></div>";
    exit;
}

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

// --- Insert skills ---
if (!empty($_POST['skills'])) {
    $stmt_skill = $conn->prepare("INSERT INTO user_skills (eoi_number, skill_id) VALUES (?, ?)");
    if (!$stmt_skill) {
        die("Prepare failed for skills: " . $conn->error);
    }
    foreach ($_POST['skills'] as $skill_id) {
        $skill_id = (int)$skill_id;
        $stmt_skill->bind_param("ii", $eoi_number, $skill_id);
        if (!$stmt_skill->execute()) {
            error_log("Skill insert failed: " . $stmt_skill->error);
        }
    }
    $stmt_skill->close();
}

// --- Save EOI number in session for confirmation ---
$_SESSION['eoi_confirm'] = $eoi_number;

header("Location: confirm_eoi.php");
exit;
?>
