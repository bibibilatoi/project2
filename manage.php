

<?php include 'header.inc'; ?>
    <link rel="stylesheet" href="styles/manage_style.css">
    <title>Manager Page</title>
    <style>
        .List_manage{
            background-color: #1b1b1a;       /* deep gray background */
            color: #f8fcfc;                  /* soft white text */
            padding: 30px;
            margin: 10px auto;
            width: 60%;
            border-radius: 8px;              /* rounded corners */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            size: 50px;
        }
        .Manage_Buttons{
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 6px;
            border: none;
            cursor: pointer;
            outline: none;
            font-size: 16px;
            color:#c5c4c4;
            margin-bottom: 20px;
            transition: 0.5s;
        }
        .Manage_Buttons:hover{
            background: rgba(28, 99, 242, 0.267);
        }
        .select_typing_fields{
            width: 100%;
            padding: 20px;
            margin-top: 12px;
            margin-bottom: 12px;
            background: rgba(0, 0, 0, 0.4);
            color: black;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            outline: none;
            font-size: 16px;
            color:#c5c4c4;
            transition: 0.5s;
        }
        .select_typing_name::placeholder{
            color: #d7cdcdff;        
            opacity: 1;         /* ensures consistent visibility across browsers */
            font-style: italic;
        }
        .select_typing_name:focus {
            border-color: #1c63f2;
            box-shadow: 0 0 8px rgba(28, 99, 242, 0.4);
            background-color: rgba(30, 30, 30, 0.9);
        }
        .select_typing_name{
            width: 100%;
            padding: 20px;
            margin-top: 12px;
            margin-bottom: 12px;
            background: rgba(0, 0, 0, 0.4);
            color: black;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            outline: none;
            font-size: 16px;
            color:#c5c4c4;
            transition: 0.5s;
        }
        .select_typing_fields option {
            background-color: #1b1b1a;
            color: #f0f0f0;
            padding: 8px;
        }
        .select_typing_fields optgroup {
            color: #a4fc0cff;
            font-weight: bold;
            background-color: #111;
        }
        #eoi_num_select{
            margin-bottom: 10px;
        }
    </style>
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
