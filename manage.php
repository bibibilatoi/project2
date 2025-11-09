
<!DOCTYPE html>
<html lang="en"></html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/manage_styles.css" rel="stylesheet">

        <title>Manage Page</title>
    </head>

    <body>
        <!--List all eois -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h3>List All EOIs</h3>
            <button name="action" value="list_all" class="Manage_Buttons">List All</button>
        </form>
        <!--List EOIs by Job Reference -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h3>List EOIs by Job Reference</h3>
            <label for="job_ref">Select Job Reference:</label>
            <select class="select_typing_fields" name="job_ref" id="job_ref" required>
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
            <h3>List EOIs by Applicant Name</h3>
            <div class="select_typing_fields">
                <input class="select_typing_name" type="text" name="First_name" placeholder="First Name">
                <input class="select_typing_name" type="text" name="Last_name" placeholder="Last Name">
            </div>
            <button name="action" value="list_by_name" class="Manage_Buttons">Search</button>
        </form>
        <!--Delete EOIs by Job Reference -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h3>Delete EOIs by Job Reference</h3>
            <label for="job_ref">Select Job Reference:</label>
            <select name="job_ref" id="job_ref" class = "select_typing_fields" required>
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
            <button name="action" value="delete_by_job" style="color:red;" class="Manage_Buttons">Delete</button>
        </form>
        <!--Change EOI status -->
        <form action = "views_eoi.php" method="post" class = "List_manage">
            <h3>Change EOI Status</h3>
            <input class="select_typing_name" id="EOI_num_select" class="select_typing_fields" type="number" name="eoi_number" placeholder="EOI Number" required>
            <select class="select_typing_fields" name="status">
                <option value="New">New</option>
                <option value="Current">Current</option>
                <option value="Final">Final</option>
            </select>
            <button name="action" value="change_status" class="Manage_Buttons">Update Status</button>
        </form>

    </body>
</html>