

<?php include 'header.inc'; ?>
    <link href="styles/manage_style.css" rel="stylesheet">
<!--List all eois -->
<form action = "views_eoi.php" method="post" class = "List_manage">
    <h3>List All EOIs</h3>
    <button name="action" value="list_all">List All</button>
</form>
<!--List EOIs by Job Reference -->
<form action = "views_eoi.php" method="post" class = "List_manage">
    <h3>List EOIs by Job Reference</h3>
    <input type="text" name="job_ref" placeholder="Job Reference" required>
    <button name="action" value="list_by_job">Search</button>
</form>
<!--List EOIs by Applicant name -->
<form action = "views_eoi.php" method="post" class = "List_manage">
    <h3>List EOIs by Applicant Name</h3>
    <input type="text" name="First_name" placeholder="First Name">
    <input type="text" name="Last_name" placeholder="Last Name">
    <button name="action" value="list_by_name">Search</button>
</form>
<!--Delete EOIs by Job Reference -->
<form action = "views_eoi.php" method="post" class = "List_manage">
    <h3>Delete EOIs by Job Reference</h3>
    <input type="text" name="job_ref" placeholder="Job Reference" required>
    <button name="action" value="delete_by_job" style="color:red;">Delete</button>
</form>
<!--Change EOI status -->
<form action = "views_eoi.php" method="post" class = "List_manage">
    <h3>Change EOI Status</h3>
    <input type="number" name="eoi_number" placeholder="EOI Number" required>
    <select name="status">
        <option value="New">New</option>
        <option value="Current">Current</option>
        <option value="Final">Final</option>
    </select>
    <button name="action" value="change_status">Update Status</button>
</form>

</body>
</html>
