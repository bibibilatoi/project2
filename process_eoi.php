<?php
require_once("settings.php");
session_start();

// Prevent direct access
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php");
    exit();
}

// Function to clean input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get and clean data safely
$jobRef = clean_input($_POST["jobRef"] ?? "");
$firstName = clean_input($_POST["firstname"] ?? "");
$lastName = clean_input($_POST["lastName"] ?? "");
$dob = clean_input($_POST["dob"] ?? "");
$gender = clean_input($_POST["gender"] ?? "");
$street = clean_input($_POST["street"] ?? "");
$suburb = clean_input($_POST["suburb"] ?? "");
$state = clean_input($_POST["state"] ?? "");
$postcode = clean_input($_POST["postcode"] ?? "");
$email = clean_input($_POST["email"] ?? "");
$phone = clean_input($_POST["phone"] ?? "");
$skills = $_POST["skills"] ?? [];
$otherSkills = clean_input($_POST["otherSkills"] ?? "");

$errors = [];

// Basic validation
if ($jobRef == "") $errors[] = "Please select a job reference.";
if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/u", $firstName)) $errors[] = "Invalid first name.";
if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/u", $lastName)) $errors[] = "Invalid last name.";
if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) $errors[] = "Date of birth must be in dd/mm/yyyy format.";
if (empty($gender)) $errors[] = "Please select gender.";
if (strlen($street) > 40) $errors[] = "Street address too long.";
if (strlen($suburb) > 40) $errors[] = "Suburb too long.";
if (!in_array($state, ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"])) $errors[] = "Please select a valid state.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Phone must be 8–12 digits.";
if (empty($skills)) $errors[] = "Please select at least one technical skill.";

// If errors exist, display them
if (count($errors) > 0) {
    echo "<h2>Form Error</h2><ul>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul><p><a href='apply.php'>Go back</a></p>";
    exit();
}

if (!$conn) {
    echo "<p>Database connection failed.</p>";
    exit();
}

// Create table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    jobRef VARCHAR(5),
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    dob VARCHAR(10),
    gender VARCHAR(10),
    street VARCHAR(40),
    suburb VARCHAR(40),
    state VARCHAR(10),
    postcode VARCHAR(4),
    email VARCHAR(50),
    phone VARCHAR(20),
    skills VARCHAR(255),
    otherSkills TEXT,
    status VARCHAR(20) DEFAULT 'New'
)";
mysqli_query($conn, $createTable);

// Prepare skill list
$skillsList = is_array($skills) ? implode(", ", $skills) : $skills;

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO eoi 
(jobRef, firstName, lastName, dob, gender, street, suburb, state, postcode, email, phone, skills, otherSkills)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "sssssssssssss",
    $jobRef, $firstName, $lastName, $dob, $gender, $street, $suburb,
    $state, $postcode, $email, $phone, $skillsList, $otherSkills
);

if ($stmt->execute()) {
    $eoiNumber = $stmt->insert_id;

    echo "<h2>Thank you for your application!</h2>";
    echo "<p>Your EOI number is <strong>$eoiNumber</strong></p>";

    // Display summary table
    echo "<table border='1' cellpadding='5'>";
    foreach ($_POST as $key => $value) {
        if (is_array($value)) $value = implode(", ", $value);
        echo "<tr><th>" . htmlspecialchars($key) . "</th><td>" . htmlspecialchars($value) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>There was a problem saving your application.</p>";
}

$stmt->close();
mysqli_close($conn);
?>
