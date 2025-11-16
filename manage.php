<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
}

require_once "settings.php";
$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$eoi_query = "SELECT eoi_number, first_name, last_name, status FROM eoi ORDER BY eoi_number ASC";

$stmt = $conn->prepare($eoi_query);

if ($stmt === false) {
    $conn->close();
    die("Prepare failed: " . $conn->error);
}

$stmt->execute();
$eoi_result = $stmt->get_result();

if ($eoi_result === false) {
    echo "<h1>Database Error: Could not retrieve EOI list.</h1>";
    $stmt->close();
    $conn->close();
    exit();
}

// NOTE: do not close $stmt or $conn here yet because database is still used below.
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/manage_styles.css" rel="stylesheet">
        <title>Management Page</title>
    </head>
<body>
    <!--List all eois -->
    <div class="background"></div>
    <div class="container">
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h2>List All EOIs</h2>
            <button name="action" value="list_all" class="Manage_Buttons">List All</button>
        </form>
        <!--List EOIs by Job Reference -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h2>List EOIs by Job Reference</h2>
            <label for="reference_number">Select Job Reference:</label>
            <select class="select_typing_fields" name="reference_number" id="reference_number" required>
                <option value="">-- Select a Job Reference --</option>
                <optgroup label="Propulsion and Aerospace Engineering">
                    <option value="PA01">PA01 - Head of Propulsion Engineering</option>
                    <option value="PA02">PA02 - Senior Thermal Systems Engineer</option>
                    <option value="PA03">PA03 - Propulsion Test Manager</option>
                </optgroup>
                <optgroup label="AI, Automation and Mission Systems">
                    <option value="AI01">AI01 - Head of AI and Orbital Systems</option>
                    <option value="AI02">AI02 - Robotics Team Lead</option>
                    <option value="AI03">AI03 - Mission Systems Director</option>
                </optgroup>
                <optgroup label="Manufacturing and IT Operations">
                    <option value="MO01">MO01 - Manufacturing Manager</option>
                    <option value="MO02">MO02 - QA Department Lead</option>
                    <option value="MO03">MO03 - Supply Chain Manager</option>
                    <option value="MO04">MO04 - Chief Information Security Officer (CISO)</option>
                </optgroup>
                <optgroup label="Business, IT and Communications">
                    <option value="BC01">BC01 - Director of Business Strategy</option>
                    <option value="BC02">BC02 - Chief Marketing Officer</option>
                    <option value="BC03">BC03 - Director of Human Resources</option>
                </optgroup>
            </select>
            <button name="action" value="list_by_job" class="Manage_Buttons">Search</button>
        </form>
        <!--List EOIs by Applicant name -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h2>List EOIs by Applicant Name</h2>
            <div class="select_typing_fields" id="name-field">
                <input class="select_typing_name" type="text" name="first_name" placeholder="First Name">
                <input class="select_typing_name" type="text" name="last_name" placeholder="Last Name">
            </div>
            <button name="action" value="list_by_name" class="Manage_Buttons">Search</button>
        </form>
        <!--Delete EOIs by Job Reference -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h2 id="Delete_Job_h3">Delete EOIs by Job Reference</h2>
            <label for="reference_number">Select Job Reference:</label>
            <select name="reference_number" id="reference_number" class = "select_typing_fields" required>
                <option value="">-- Select a Job Reference --</option>
                <optgroup label="Propulsion and Aerospace Engineering">
                    <option value="PA01">PA01 - Head of Propulsion Engineering</option>
                    <option value="PA02">PA02 - Senior Thermal Systems Engineer</option>
                    <option value="PA03">PA03 - Propulsion Test Manager</option>
                </optgroup>
                <optgroup label="AI, Automation and Mission Systems">
                    <option value="AI01">AI01 - Head of AI and Orbital Systems</option>
                    <option value="AI02">AI02 - Robotics Team Lead</option>
                    <option value="AI03">AI03 - Mission Systems Director</option>
                </optgroup>
                <optgroup label="Manufacturing and IT Operations">
                    <option value="MO01">MO01 - Manufacturing Manager</option>
                    <option value="MO02">MO02 - QA Department Lead</option>
                    <option value="MO03">MO03 - Supply Chain Manager</option>
                    <option value="MO04">MO04 - Chief Information Security Officer (CISO)</option>
                </optgroup>
                <optgroup label="Business, IT and Communications">
                    <option value="BC01">BC01 - Director of Business Strategy</option>
                    <option value="BC02">BC02 - Chief Marketing Officer</option>
                    <option value="BC03">BC03 - Director of Human Resources</option>
                </optgroup>
            </select>
            <button name="action" value="delete_by_job" class="Manage_Buttons" id="Delete_Button">Delete</button>
        </form>
        <!--Change EOI status -->
        <form action="views_eoi.php" method="post" class="List_manage">
            <h2>Change EOI Status</h2>

            <select class="select_typing_fields" name="eoi_number" id="EOI_num_select" required>
                <option value="">Select Applicant</option>

                <?php
                while ($row = mysqli_fetch_assoc($eoi_result)) {
                    $id = $row["eoi_number"];
                    $name = $row["first_name"] . " " . $row["last_name"];
                    $status = $row["status"];

                    echo "<option value='{$id}'>#{$id} – {$name} – ({$status})</option>";
                }
                ?>
            </select>

            <!-- Status options -->
            <select class="select_typing_fields" name="status">
                <option value="New">New</option>
                <option value="Current">Current</option>
                <option value="Final">Final</option>
            </select>

            <button name="action" value="change_status" class="Manage_Buttons">Update Status</button>
        </form>
        <!--Log out-->
        <button class="select_typing_name" id="logout_button"onclick="window.location.href='logout.php'">Logout</button>
    </div>
    
    <?php
        // Clean up resources (CRITICAL)
        $eoi_result->free(); 
        $stmt->close();
        $conn->close(); 
    ?>
</body>
</html>