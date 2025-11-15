<?php
session_start();
require_once "settings.php"; 

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$_SESSION['apply_form_token'] = bin2hex(random_bytes(16)); 

$skills_query = "SELECT skill_id, skill_name FROM skills ORDER BY skill_name ASC";
$skills_result = $conn->query($skills_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Apply for a position at SpeedX">
    <meta name="keywords" content="job application, SpeedX, IT, AI, tech">
    <meta name="author" content="SpeedX Team">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">
    <link href="styles/common_styles.css" rel="stylesheet">
    <link href="styles/apply_styles.css" rel="stylesheet">
    <title>Job Application</title>
</head>

<body id="apply-body">
    <?php include("header.inc"); ?>

    <main class="jobs-main">
        <h1 id="h1-apply">Job Application Form</h1>

        <form id="jobApplicationForm" method="post" action="process_eoi.php" novalidate="novalidate">
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['apply_form_token']; ?>">
            <!-- Job Reference -->
            <label for="reference_number">Job Reference Number:</label>
            <select id="reference_number" name="reference_number" required>
                <option value="">--Select Job--</option>
                <option value="AI01">AI01</option>
                <option value="MO04">MO04</option>
            </select>

            <!-- Names -->
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="50" required pattern="[A-Za-zÀ-ỹà-ỹ\s]+">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="50" required pattern="[A-Za-zÀ-ỹà-ỹ\s]+">

            <!-- DOB -->
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="date_of_birth" required>

            <!-- Gender -->
            <fieldset id="gender-field">
                <legend>Gender</legend>
                <input type="radio" name="gender" value="Male"  id="male" required>
                <label for="male"> Male</label>
                
                <input type="radio" name="gender" value="Female"  id="female">
                <label for="female">Female</label>

                <input type="radio" name="gender" value="Other"  id="other"> 
                <label for="other">Other</label>
            </fieldset>

            <!-- Address -->
            <label for="street">Street Address:</label>
            <input type="text" id="street" name="street" maxlength="100" required>

            <label for="suburb">Suburb/Town:</label>
            <input type="text" id="suburb" name="suburb" maxlength="50" required>

            <label for="state">State:</label>
            <select id="state" name="state" required>
                <option value="">--Select--</option>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="TAS">TAS</option>
                <option value="SA">SA</option>
                <option value="WA">WA</option>
                <option value="NT">NT</option>
            </select>

            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" maxlength="10" pattern="\d{4,10}" required>

            <!-- Contact -->
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" maxlength="100" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" maxlength="20" pattern="[0-9+\s-]+" required>

            <!-- Skills -->
            <fieldset>
                <legend>Select Your Skills</legend>

                <?php if ($skills_result && $skills_result->num_rows > 0): ?>
                    <?php while ($row = $skills_result->fetch_assoc()): ?>
                        <div class="fieldset-container">
                            <input type="checkbox" id="skill_<?php echo $row['skill_id']; ?>" name="skills[]" value="<?php echo $row['skill_id']; ?>">
                            <label for="skill_<?php echo $row['skill_id']; ?>"><?php echo htmlspecialchars($row['skill_name']); ?></label>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No skills found. Please contact admin.</p>
                <?php endif; ?>

                <!-- Optional extra skill -->
                <div class="fieldset-container">
                    <input type="checkbox" id="Oas" name="skills[]" value="0">
                    <label for="Oas">Other Advanced Skills (for higher roles)</label>
                </div>
            </fieldset>

            <!-- Other Skills -->
            <label for="otherSkills">Other Skills / Notes:</label>
            <textarea id="otherSkills" name="other_skills" rows="4" cols="40"></textarea>

            <!-- Submit -->
            <button id="apply-button" type="submit">Apply</button>
            
        </form>
    </main>

    <?php include("footer.inc"); ?>
</body>
</html>
