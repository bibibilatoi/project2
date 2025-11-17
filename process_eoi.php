<?php
session_start();
require_once "settings.php";  //just to check if the file is included or not


$conn = new mysqli($host, $user, $pwd, $sql_db);      //creates database based on settings.php
if ($conn->connect_error) {                    //if connection failed, store error mssg, redirect to apply.php(the form) then stop
    // Critical error: Connection failed
    $_SESSION['apply_error'] = "Connection failed: Please try again later or contact support.";
    header("Location: apply.php");
    exit;
}

//-Security Protocol
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||           
    !isset($_POST['form_token'], $_SESSION['apply_form_token']) ||  //CSRF, to check if it is sent by the website not others
    $_POST['form_token'] !== $_SESSION['apply_form_token']
) {
    unset($_SESSION['apply_form_token']);        //active if validation process fails, stop and show error mssg
    $conn->close();
    die("<div class='error-msg'>Access denied. Please submit the form from the Apply page.</div>");
}


// Valid submission -> delete the token -> avoid reuse
unset($_SESSION['apply_form_token']);




//Input cleanup function
function cleanStuff($stuff) {
    return trim($stuff);
}
//cleans the input, if the value on the left is good then use, otherwise use '' (empty)
$reference_number = cleanStuff($_POST['reference_number'] ?? '');     
$first_name = cleanStuff($_POST['first_name'] ?? '');
$last_name = cleanStuff($_POST['last_name'] ?? '');
$date_of_birth = cleanStuff($_POST['date_of_birth'] ?? '');
$gender = cleanStuff($_POST['gender'] ?? '');
$street = cleanStuff($_POST['street'] ?? '');
$suburb = cleanStuff($_POST['suburb'] ?? '');
$state = cleanStuff($_POST['state'] ?? '');
$postcode = cleanStuff($_POST['postcode'] ?? '');
$email = cleanStuff($_POST['email'] ?? '');
$phone = cleanStuff($_POST['phone'] ?? '');
$other_skills = cleanStuff($_POST['other_skills'] ?? '');


//Error Validation
$errors = [];

$required = [                     //to check if there are missing inputs 
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
    //Check if value is empty, if it is then send an error mssg
    if (empty($value)) $errors[] = "$field is required.";
}

//Validate email
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {  // filters and check whether format is correct or not
    $errors[] = "Invalid email format.";
}

//Validate date of birth (YYYY-MM-DD)
if (!empty($date_of_birth) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth)) {   //to check whether there is input and if it matches the pattern
    $errors[] = "Date of Birth must be in YYYY-MM-DD format.";
}

//Validate postcode (numbers only, 4-6 digits)
if (!empty($postcode) && !preg_match('/^\d{4,6}$/', $postcode)) {
    $errors[] = "Postcode must be 4-6 digits.";
}

//Validate phone (numbers, spaces, +, -)
if (!empty($phone) && !preg_match('/^[\d\+\-\s]{8,20}$/', $phone)) {
    $errors[] = "Phone number contains invalid characters.";
}

//Validate gender
$valid_genders = ['Male', 'Female', 'Other'];
if (!empty($gender) && !in_array($gender, $valid_genders)) {
    $errors[] = "Invalid gender selected.";
}

//Validate skills
$skills_selected = !empty($_POST['skills']) && is_array($_POST['skills']) && count($_POST['skills']) > 0;
$other_skills_filled = !empty(trim($_POST['other_skills'] ?? ''));

if (!$skills_selected && !$other_skills_filled) {
    $errors[] = "You must select at least one skill or enter other skills.";
}

//if error exist, save input and error and go back to apply
if (!empty($errors)) {
    //Save the entire submitted data for re-generation
    $_SESSION['apply_form_data'] = $_POST;
    
    $_SESSION['apply_errors'] = $errors;
    $conn->close();
    header("Location: apply.php");
    exit;
}

//Insert eoi
$stmt = $conn->prepare("INSERT INTO eoi 
    (reference_number, first_name, last_name, date_of_birth, gender, street, suburb, `state`, postcode, email, phone, other_skills)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");   //preparing the statement to later fill value in by bind_param

//Check if the preparation is successfull
if (!$stmt) {
    $_SESSION['apply_error'] = "Database error (EOI): Failed to prepare statement.";
    $conn->close();
    header("Location: apply.php");      //if not then close and redirect user back to apply.php
    exit;
}
$stmt->bind_param(
    "ssssssssssss", 
    $reference_number, $first_name, $last_name, $date_of_birth, $gender, 
    $street, $suburb, $state, $postcode, $email, $phone, $other_skills
);

if (!$stmt->execute()) {            //run the sql query in the data base
    // Critical error: Execution failed
    $_SESSION['apply_error'] = "Error submitting EOI: " . $stmt->error;   
    $stmt->close();
    $conn->close();
    header("Location: apply.php");
    exit;
}

$eoi_number = $stmt->insert_id;     //getting inserted record id
$stmt->close();

//Insert skills
if (!empty($_POST['skills'])) {
    $stmt_skill = $conn->prepare("INSERT INTO user_skills (eoi_number, skill_id) VALUES (?, ?)"); //prepare the query first to bind values after 
                                                                                                  // used to prevent sql injection attacks
    if (!$stmt_skill) {
        error_log("Prepare failed for skills: " . $conn->error); 
    } else {
        foreach ($_POST['skills'] as $skill_id) {
            if (is_numeric($skill_id) && (int)$skill_id > 0) {        //to ensure that skillid is a number and is a positive number
                $validated_skill_id = (int)$skill_id;
                $stmt_skill->bind_param("ii", $eoi_number, $validated_skill_id);   //to ensure the inputs are intergers and to replace ? with  the following inputs
                if (!$stmt_skill->execute()) {
                    error_log("Skill insert failed for EOI #$eoi_number: " . $stmt_skill->error); 
                }
            } else {
                 error_log("Invalid skill ID submitted: $skill_id");  //to prevent broken inputs or attacks
            }
        }
        $stmt_skill->close();
    }
}



//Clean up
$conn->close();
$_SESSION['eoi_confirm'] = $eoi_number;
//Add a timestamp to limit viewing duration
$_SESSION['eoi_confirm_time'] = time(); 
header("Location: confirm_eoi.php");
exit;

//-- ACKNOWLEDGEMENTS: Usage of AI to generate patterns and to make code cleaner than the original //
 // -- The code is inspired by the following video: https://www.youtube.com/watch?v=mgP_7_051DM //
?>