<?php
session_start();
require_once "settings.php";

// --- Helper function for cleaning (TRIM ONLY) ---
function clean_input($data) {
    return trim($data);
}

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    // Critical error: Connection failed
    $_SESSION['apply_error'] = "Connection failed: Please try again later or contact support.";
    header("Location: apply.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['form_token'], $_SESSION['apply_form_token']) ||
    $_POST['form_token'] !== $_SESSION['apply_form_token']
) {
    unset($_SESSION['apply_form_token']);
    $conn->close();
    die("<div class='error-msg'>Access denied. Please submit the form from the Apply page.</div>");
}

// Valid submission -> delete the token -> avoid reuse
unset($_SESSION['apply_form_token']);

// --- Collect and clean input ---
$reference_number = clean_input($_POST['reference_number'] ?? '');
$first_name = clean_input($_POST['first_name'] ?? '');
$last_name = clean_input($_POST['last_name'] ?? '');
$date_of_birth = clean_input($_POST['date_of_birth'] ?? '');
$gender = clean_input($_POST['gender'] ?? '');
$street = clean_input($_POST['street'] ?? '');
$suburb = clean_input($_POST['suburb'] ?? '');
$state = clean_input($_POST['state'] ?? '');
$postcode = clean_input($_POST['postcode'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$other_skills = clean_input($_POST['other_skills'] ?? '');

$errors = [];

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

//If errors exist, save the inputs and errors then redirect back to apply
if (!empty($errors)) {
    // *** FIX: Save the entire submitted data for re-population ***
    $_SESSION['apply_form_data'] = $_POST;
    
    $_SESSION['apply_errors'] = $errors;
    $conn->close();
    header("Location: apply.php");
    exit;
}

// --- Insert EOI ---
$stmt = $conn->prepare("INSERT INTO eoi 
    (reference_number, first_name, last_name, date_of_birth, gender, street, suburb, `state`, postcode, email, phone, other_skills)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    // Critical error: Prepare failed
    $_SESSION['apply_error'] = "Database error (EOI): Failed to prepare statement.";
    $conn->close();
    header("Location: apply.php");
    exit;
}

$stmt->bind_param(
    "ssssssssssss", 
    $reference_number, $first_name, $last_name, $date_of_birth, $gender, 
    $street, $suburb, $state, $postcode, $email, $phone, $other_skills
);

if (!$stmt->execute()) {
    // Critical error: Execution failed
    $_SESSION['apply_error'] = "Error submitting EOI: " . $stmt->error;
    $stmt->close();
    $conn->close();
    header("Location: apply.php");
    exit;
}

$eoi_number = $stmt->insert_id;
$stmt->close();

// --- Insert skills ---
if (!empty($_POST['skills'])) {
    $stmt_skill = $conn->prepare("INSERT INTO user_skills (eoi_number, skill_id) VALUES (?, ?)");
    
    if (!$stmt_skill) {
        error_log("Prepare failed for skills: " . $conn->error); 
    } else {
        foreach ($_POST['skills'] as $skill_id) {
            if (is_numeric($skill_id) && (int)$skill_id > 0) {
                $validated_skill_id = (int)$skill_id;
                $stmt_skill->bind_param("ii", $eoi_number, $validated_skill_id);
                if (!$stmt_skill->execute()) {
                    error_log("Skill insert failed for EOI #$eoi_number: " . $stmt_skill->error);
                }
            } else {
                 error_log("Invalid skill ID submitted: $skill_id");
            }
        }
        $stmt_skill->close();
    }
}

//Clean up
$conn->close();
$_SESSION['eoi_confirm'] = $eoi_number;
// Add a timestamp to limit viewing duration
$_SESSION['eoi_confirm_time'] = time(); 
header("Location: confirm_eoi.php");
exit;
?>