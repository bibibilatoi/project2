<?php


// Stop direct access
if (!isset($_POST["firstname"])) {
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

// Get and clean data
$jobRef = clean_input($_POST["jobRef"]);
$firstName = clean_input($_POST["firstname"]);
$lastName = clean_input($_POST["lastName"]);
$dob = clean_input($_POST["dob"]);
$gender = clean_input($_POST["gender"]);
$street = clean_input($_POST["street"]);
$suburb = clean_input($_POST["suburb"]);
$state = clean_input($_POST["state"]);
$postcode = clean_input($_POST["postcode"]);
$email = clean_input($_POST["email"]);
$phone = clean_input($_POST["phone"]);
$skills = isset($_POST["skills"]) ? $_POST["skills"] : "";
$otherSkills = clean_input($_POST["otherSkills"]);

$errors = array();

// Basic validation
if ($jobRef == "") $errors[] = "Please select a job reference.";
if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/", $firstName)) $errors[] = "Invalid first name.";
if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/", $lastName)) $errors[] = "Invalid last name.";
if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) $errors[] = "Date of birth must be in dd/mm/yyyy format.";
if ($gender == "") $errors[] = "Please select gender.";
if (strlen($street) > 40) $errors[] = "Street address too long.";
if (strlen($suburb) > 40) $errors[] = "Suburb too long.";
if (!in_array($state, ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"])) $errors[] = "Please select a valid state.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Phone must be 8–12 digits.";
if ($skills == "") $errors[] = "Please select at least one technical skill.";

// If there are errors, show them
if (count($errors) > 0) {
    echo "<h2>Form Error</h2>";
    echo "<ul>";
    foreach ($errors as $e) {
        echo "<li>$e</li>";
    }
    echo "</ul>";
    echo "<p><a href='apply.php'>Go back</a></p>";
    exit();
}

// Database connection
$host = "localhost";
$user = "root";  
$pwd = "";       
$dbname = "jobs";

$conn = @mysqli_connect($host, $user, $pwd, $dbname);

if (!$conn) {
    echo "<p>Database connection failed.</p>";
    exit();
}

// Create table 
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
    skills VARCHAR(100),
    otherSkills TEXT,
    status VARCHAR(20) DEFAULT 'New'
)";
mysqli_query($conn, $createTable);

// Prepare skill list
if (is_array($skills)) {
    $skillsList = implode(", ", $skills);
} else {
    $skillsList = $skills;
}

// Insert data
$query = "INSERT INTO eoi (jobRef, firstName, lastName, dob, gender, street, suburb, state, postcode, email, phone, skills, otherSkills)
VALUES ('$jobRef', '$firstName', '$lastName', '$dob', '$gender', '$street', '$suburb', '$state', '$postcode', '$email', '$phone', '$skillsList', '$otherSkills')";

$result = mysqli_query($conn, $query);

if ($result) {
    $eoiNumber = mysqli_insert_id($conn);
    echo "<h2>Thank you for your application!</h2>";
    echo "<p>Your EOI number is <strong>$eoiNumber</strong></p>";
} else {
    echo "<p>There was a problem saving your application.</p>";
}

mysqli_close($conn);
?>