<?php
<<<<<<< HEAD
// process_eoi.php
include 'settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Collect main EOI data
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $suburb = mysqli_real_escape_string($conn, $_POST['suburb']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $other_skills = mysqli_real_escape_string($conn, $_POST['other_skills'] ?? '');

    $address = $street . ', ' . $suburb . ', ' . $state . '. Postcode:' . $postcode;

    // 2. Insert into eoi table
    $insert_eoi = "INSERT INTO eoi (reference_number, first_name, last_name, date_of_birth, gender, email, phone, other_skills)
                   VALUES ('$reference_number', '$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone', '$other_skills')";

    if (mysqli_query($conn, $insert_eoi)) {
        $eoi_number = mysqli_insert_id($conn);

        // 3. Insert selected skills (array of skill_ids)
        if (!empty($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill_id) {
                $skill_id = mysqli_real_escape_string($conn, $skill_id);
                mysqli_query($conn, "INSERT INTO eoi_skills (eoi_number, skill_id) VALUES ('$eoi_number', '$skill_id')");
            }
        }

        echo "<h2>Thank you! Your application has been submitted.</h2>";

        // 4. Display submitted data
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>EOI Number</th><td>" . htmlspecialchars($eoi_number) . "</td></tr>";
        echo "<tr><th>Job Reference</th><td>" . htmlspecialchars($reference_number) . "</td></tr>";
        echo "<tr><th>Name</th><td>" . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "</td></tr>";
        echo "<tr><th>Date of Birth</th><td>" . htmlspecialchars($date_of_birth) . "</td></tr>";
        echo "<tr><th>Gender</th><td>" . htmlspecialchars($gender) . "</td></tr>";
        echo "<tr><th>Address</th><td>" . htmlspecialchars($address) . "</td></tr>";
        echo "<tr><th>Email</th><td>" . htmlspecialchars($email) . "</td></tr>";
        echo "<tr><th>Phone</th><td>" . htmlspecialchars($phone) . "</td></tr>";
        echo "<tr><th>Other Skills / Notes</th><td>" . nl2br(htmlspecialchars($other_skills)) . "</td></tr>";

        // 5. Fetch and display skill names
        if (!empty($_POST['skills'])) {
            $skill_ids = implode(",", array_map('intval', $_POST['skills']));
            $skill_query = "SELECT skill_name FROM skills WHERE skill_id IN ($skill_ids)";
            $skill_result = mysqli_query($conn, $skill_query);

            echo "<tr><th>Selected Skills</th><td><ul>";
            while ($s = mysqli_fetch_assoc($skill_result)) {
                echo "<li>" . htmlspecialchars($s['skill_name']) . "</li>";
            }
            echo "</ul></td></tr>";
        }

        echo "</table>";

    } else {
        echo "<p>Error submitting EOI: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);
=======

// --- PREVENT DIRECT ACCESS ---
if (!isset($_POST['firstname'])) {   //-- if the value of firstname does not exist,
    header('Location: apply.php');  // redirect if someone lands here manually
    exit();
}

// --- INPUT CLEANUP FUNCTION ---
function cleanStuff($stuff) {
    $stuff = trim($stuff);
    $stuff = stripslashes($stuff);
    $stuff = htmlspecialchars($stuff);
    return $stuff;
}

// --- TAKE AND CLEAN INPUTS ---

//- JobRef
if (isset($_POST['jobRef'])) {    //-- if there is value input of 'jobRef' and isn't null, take and clean it through cleanStuff function
    $job_ref = cleanStuff($_POST['jobRef']);
} else {                    // -- if not, put $job_ref value as an empty string 
    $job_ref = "";              //-- the "" helps to intepret the value 
}

//- FirstName
if (isset($_POST['firstName'])) {
    $fname = cleanStuff($_POST['firstName']);
} else {
    $fname = "";
}

//- LastName
if (isset($_POST['lastName'])) {
    $lname = cleanStuff($_POST['lastName']);
} else {
    $lname = "";
}

//- Dob
if (isset($_POST['dob'])) {
    $dob = cleanStuff($_POST['dob']);
} else {
    $dob = "";
}

//- Gender
if (isset($_POST['gender'])) {
    $gender = cleanStuff($_POST['gender']);
} else {
    $gender = "";
}

//- Street
if (isset($_POST['street'])) {
    $street = cleanStuff($_POST['street']);
} else {
    $street = "";
}

//- Suburb
if (isset($_POST['suburb'])) {
    $suburb = cleanStuff($_POST['suburb']);
} else {
    $suburb = "";
}

//- State
if (isset($_POST['state'])) {
    $state = cleanStuff($_POST['state']);
} else {
    $state = "";
}

//- Postcode
if (isset($_POST['postcode'])) {
    $postcode = cleanStuff($_POST['postcode']);
} else {
    $postcode = "";
}

//- Email
if (isset($_POST['email'])) {
    $email = cleanStuff($_POST['email']);
} else {
    $email = "";
}

//- Phone
if (isset($_POST['phone'])) {
    $phone = cleanStuff($_POST['phone']);
} else {
    $phone = "";
}


//- OtherSkills
if (isset($_POST['otherSkills'])) {        // optional text area
    $other = cleanStuff($_POST['otherSkills']);
} else {
    $other = "";  
}


// --- VALIDATION ---



//- jobRef

$numerror = 0;

if (empty($job_ref)) {
    echo " Job reference is missing!<br>";
    $numerror++;
} else {
    echo "Job reference is valid.<br>";
}

//-- checkng first name
if (empty($fname)) {
    echo "First name is missing!";
    $numerror++;
} else if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/", $fname )) {   // If the fname value doesnt match the pattern and length, echo the following
    echo "Invalid first name format<br>";
    $numerror++;
} else {
    echo "Valid first name format<br>";
}

//-- checking last name
if (empty($lname)) {
    echo "Last name is missing!<br>";
    $numerror++;
} else if (!preg_match("/^[A-Za-zÀ-ỹà-ỹ\s]{1,20}$/", $lname)) {  //similar
    echo "Invalid last name format<br>";
    $numerror++;
} else {
    echo "Valid last name format<br>";
}

//-- checking dob

if (empty($dob)) {
    echo "Please enter your date of birth<br>";
    $numerror++;
} else if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
    echo "Invalid DOB format<br>";
    $numerror++;
} else {
    echo "Valid DOB format<br>";
}

//-- checking gender
if (empty($gender)) {
    echo "Gender is not selected<br>";
    $numerror++;
} else {
    echo "Gender is selected<br>";
}

//-- checking street (by length)
if (strlen ($street) > 40) {          //check whether string length is more than 40
    echo "Street name is too long";
    $numerror++;
} else {
    echo "Valid street name";
}

//-- checking suburb 
if (strlen($suburb) > 40) {
    echo "Suburb name is too long";
    $numerror++;
} else {
    echo "Valid suburb name";
}

//-- checking state
$valid_states = ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"];   // array of states 
if (empty($state)) {
    echo "No state is selected";
    $numerror++;
} else if (!in_array($state, $valid_states)) {      //to check if the state selected is among the array above
    echo "Invalid state option";
    $numerror++;
} else {
    echo "Valid state option";
}

//-- checking postcode
if (empty($postcode)) {
    echo "No postcode is entered<br>";
    $numerror++;
} else if (!preg_match("/^\d{4}$/", $postcode)) {         //to check if the post code value entered match the pattern
    echo "Invalid postcode number<br>";
    $numerror++;
} else {
    echo "Valid postcode number<br>";
}

//-- Checking email
if (empty($email)) {
    echo "Email address is missing<br>";
    $numerror++;
} else if (!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i" , $email)) {      //checking if email input match the pattern
    echo "Invalid email format";
    $numerror++;
} else {
    echo "Valid email format<br>";
}

//-- Checking phone 
if (empty($phone)) {
    echo "Phone number is missing<br>";
    $numerror++;
} else if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) {   //similar to above
    echo "Invalid phone number format";
    $numerror++;
} else {
    echo "Valid phone number format<br>";
}

//-- checking skills
if (empty($skills)) {
    echo "No skills are selected<br>";
    $numerror++;
} else {
    echo "Skills are selected<br>";
}



///--- ERROR CHECK ---

if ($numerror > 0) {
    echo "<strong>❌ Form is not submitted. Please fix the errors</strong>";
    exit(); // to not insert into the database
} else {
    echo "<strong> ✅ The inputs are valid. The form is submitted </strong> ";  
}



/// --- DATABASE ---   (copy theo trong phan setting.php)

$host = "localhost";        
$user = "root";         
$pwd = "";              
$sql_db = "project2_db";
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

// --- TABLE ---
$create_table = "CREATE TABLE IF NOT EXISTS eoi (          
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,       
    jobRef VARCHAR(5),
    firstName VARCHAR(20),                      --Table Structure--
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

$skillsStr = is_array($skills) ? implode(', ', $skills) : $skills; //to combine skills checkboxes into string

mysqli_query($conn, $create_table);

///--- BUILD AND RUN INSERT QUERY ---

$sql = "INSERT INTO eoi 
(jobRef, firstName, lastName, dob, gender, street, suburb, state, postcode, email, phone, skills, otherSkills)
VALUES (
'$job_ref', '$fname', '$lname', '$dob', '$gender',
'$street', '$suburb', '$state', '$postcode', '$email', '$phone', '$skillsStr', '$other'
)";

$formresult = mysqli_query($conn, $sql);


///--- USER FEEDBACK ---
if ($formresult) { 
    $Id = mysqli_insert_id($conn);        // store the generated id by php in the $Id variable
    echo "<h1> ✅Your application have been received!";
    echo "<p> Thank you, <strong>$fname</strong>! Your EOI number is <b>$Id</b></p>";
    echo "<p> We will hopefully be in touch with you soon</p>";
} else {
    echo "<p> Something had went wrong";
}


/// --- CLOSING CONNECTION ---
mysqli_close($conn); 


//--- ACKNOWLEDGEMENTS: The patterns are created by AI ---
>>>>>>> processeoi
?>
