<?php
session_start();
require_once "settings.php"; 

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$general_error = $_SESSION['apply_error'] ?? '';
unset($_SESSION['apply_error']);

// Retrieve validation errors (list of field-specific errors)
$validation_errors = $_SESSION['apply_errors'] ?? [];
unset($_SESSION['apply_errors']);
// Retrieve old form data to re-populate the form
$old_input = $_SESSION['apply_form_data'] ?? [];
unset($_SESSION['apply_form_data']);

// --- Database Setup ---
// Generate a new token for the current page load
$_SESSION['apply_form_token'] = bin2hex(random_bytes(16)); 

$skills_array = [];
$skills_query = "SELECT skill_id, skill_name FROM skills ORDER BY skill_name ASC";
$stmt = $conn->prepare($skills_query);
$stmt->execute();
$skills_result = $stmt->get_result();

if ($skills_result && $skills_result->num_rows > 0) {
    // Fetch all rows into the array
    while ($row = $skills_result->fetch_assoc()) {
        $skills_array[] = $row;
    }
}

// Clean up database resources
if (isset($skills_result)) {
    $skills_result->free();
}
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();

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
        <?php if (!empty($general_error)): ?>
            <div class="error-box general-error-msg">
                <p>Server Error: <?php echo htmlspecialchars($general_error); ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($validation_errors)): ?>
            <div class="error-box validation-errors-msg">
                <p>User Error: Please fix the following errors:</p>
                <ul>
                    <?php foreach ($validation_errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form id="jobApplicationForm" method="post" action="process_eoi.php" novalidate="novalidate">
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['apply_form_token']; ?>">
            
            <label for="reference_number">Job Reference Number:</label>
            <select id="reference_number" name="reference_number" required>
                <option value="">--Select Job--</option>
                <option value="AI01" <?php echo ($old_input['reference_number'] ?? '') == 'AI01' ? 'selected' : ''; ?>>AI01</option>
                <option value="MO04" <?php echo ($old_input['reference_number'] ?? '') == 'MO04' ? 'selected' : ''; ?>>MO04</option>
            </select>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="50" required pattern="[A-Za-zÀ-ỹà-ỹ\s]+" 
                   value="<?php echo htmlspecialchars($old_input['first_name'] ?? ''); ?>">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="50" required pattern="[A-Za-zÀ-ỹà-ỹ\s]+"
                   value="<?php echo htmlspecialchars($old_input['last_name'] ?? ''); ?>">

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="date_of_birth" required
                   value="<?php echo htmlspecialchars($old_input['date_of_birth'] ?? ''); ?>">

            <fieldset id="gender-field">
                <legend>Gender</legend>
                <?php $old_gender = $old_input['gender'] ?? ''; ?>
                <input type="radio" name="gender" value="Male" id="male" required <?php echo $old_gender == 'Male' ? 'checked' : ''; ?>>
                <label for="male"> Male</label>
                
                <input type="radio" name="gender" value="Female" id="female" <?php echo $old_gender == 'Female' ? 'checked' : ''; ?>>
                <label for="female">Female</label>

                <input type="radio" name="gender" value="Other" id="other" <?php echo $old_gender == 'Other' ? 'checked' : ''; ?>> 
                <label for="other">Other</label>
            </fieldset>

            <label for="street">Street Address:</label>
            <input type="text" id="street" name="street" maxlength="100" required
                   value="<?php echo htmlspecialchars($old_input['street'] ?? ''); ?>">

            <label for="suburb">Suburb/Town:</label>
            <input type="text" id="suburb" name="suburb" maxlength="50" required
                   value="<?php echo htmlspecialchars($old_input['suburb'] ?? ''); ?>">

            <label for="state">State:</label>
            <select id="state" name="state" required>
                <option value="">--Select--</option>
                <?php $old_state = $old_input['state'] ?? ''; ?>
                <option value="VIC" <?php echo $old_state == 'VIC' ? 'selected' : ''; ?>>VIC</option>
                <option value="NSW" <?php echo $old_state == 'NSW' ? 'selected' : ''; ?>>NSW</option>
                <option value="QLD" <?php echo $old_state == 'QLD' ? 'selected' : ''; ?>>QLD</option>
                <option value="TAS" <?php echo $old_state == 'TAS' ? 'selected' : ''; ?>>TAS</option>
                <option value="SA" <?php echo $old_state == 'SA' ? 'selected' : ''; ?>>SA</option>
                <option value="WA" <?php echo $old_state == 'WA' ? 'selected' : ''; ?>>WA</option>
                <option value="NT" <?php echo $old_state == 'NT' ? 'selected' : ''; ?>>NT</option>
            </select>

            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" maxlength="10" pattern="\d{4,10}" required
                   value="<?php echo htmlspecialchars($old_input['postcode'] ?? ''); ?>">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" maxlength="100" required
                   value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>">

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" maxlength="20" pattern="[0-9+\s-]+" required
                   value="<?php echo htmlspecialchars($old_input['phone'] ?? ''); ?>">

            <fieldset>
                <legend>Select Your Skills</legend>

                <?php 
                // $old_skills will be an array of selected skill_id if submission failed
                $old_skills = is_array($old_input['skills'] ?? null) ? $old_input['skills'] : []; 
                ?>

                <?php if (!empty($skills_array)): ?>
                    <?php 
                    foreach ($skills_array as $row): 
                    $skill_id = $row['skill_id'];
                    $checked = in_array($skill_id, $old_skills) ? 'checked' : '';
                    ?>
                        <div class="fieldset-container skills-container">
                            <input type="checkbox" id="skill_<?php echo $skill_id; ?>" name="skills[]" value="<?php echo $skill_id; ?>" <?php echo $checked; ?>>
                            <label for="skill_<?php echo $skill_id; ?>"><?php echo htmlspecialchars($row['skill_name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No skills found. Please contact admin.</p>
                <?php endif; ?>
            </fieldset>

            <label for="otherSkills">Other Skills / Notes:</label>
            <textarea id="otherSkills" name="other_skills" rows="4" cols="40"><?php echo htmlspecialchars($old_input['other_skills'] ?? ''); ?></textarea>

            <button id="apply-button" type="submit">Apply</button>
            
        </form>
    </main>

    <?php include("footer.inc"); ?>
</body>
</html>