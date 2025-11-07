<?php
require_once("settings.php"); // Your database connection

// Helper function
function displayEOIs($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>EOI number</th><th>Job Reference num</th><th>First name</th><th>Last name</th><th>Street address
        </th><th>Suburb/town</th><th>State</th><th>Post code</th><th>Email address</th><th>Phone number</th><th>Skills</th>
        <th>Other skills</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['EOI number']}</td>
                    <td>{$row['Job Reference number']}</td>
                    <td>{$row['First name']}</td>
                    <td>{$row['Last name']}</td>
                    <td>{$row['Street address']}</td>
                    <td>{$row['Suburb/town']}</td>
                    <td>{$row['State']}</td>
                    <td>{$row['Postcode']}</td>
                    <td>{$row['Email address']}</td>
                    <td>{$row['Phone number']}</td>
                    <td>{$row['Skills']}</td>
                    <td>{$row['Other skills']}</td>
                    <td>{$row['Status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == "list_all") {
        $query = "SELECT * FROM eoi";
        $result = mysqli_query($conn, $query);
        displayEOIs($result);

    } elseif ($action == "list_by_job") {
        $job_ref = $_POST['job_ref'];
        $query = "SELECT * FROM eoi WHERE job_ref_number = '$job_ref'";
        $result = mysqli_query($conn, $query);
        displayEOIs($result);

    } elseif ($action == "list_by_name") {
        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $query = "SELECT * FROM eoi WHERE 
                 (first_name LIKE '%$first%' OR '$first' = '') 
                 AND (last_name LIKE '%$last%' OR '$last' = '')";
        $result = mysqli_query($conn, $query);
        displayEOIs($result);

    } elseif ($action == "delete_by_job") {
        $job_ref = $_POST['job_ref'];
        $query = "DELETE FROM eoi WHERE job_ref_number = '$job_ref'";
        if (mysqli_query($conn, $query)) {
            echo "<p>EOIs for job ref '$job_ref' have been deleted.</p>";
        } else {
            echo "<p>Error deleting records.</p>";
        }

    } elseif ($action == "change_status") {
        $eoi_id = $_POST['eoi_id'];
        $status = $_POST['status'];
        $query = "UPDATE eoi SET status = '$status' WHERE eoi_id = $eoi_id";
        if (mysqli_query($conn, $query)) {
            echo "<p>Status updated successfully.</p>";
        } else {
            echo "<p>Error updating status.</p>";
        }
    }
}
?>

<?php include 'header.inc'; ?>
    <link href="styles/manage_style.css" rel="stylesheet">

<form method="post" class = "List_manage">
    <h3>List All EOIs</h3>
    <button name="action" value="list_all">List All</button>
</form>

<form method="post" class = "List_manage">
    <h3>List EOIs by Job Reference</h3>
    <input type="text" name="job_ref" placeholder="Job Reference" required>
    <button name="action" value="list_by_job">Search</button>
</form>

<form method="post" class = "List_manage">
    <h3>List EOIs by Applicant Name</h3>
    <input type="text" name="first_name" placeholder="First Name">
    <input type="text" name="last_name" placeholder="Last Name">
    <button name="action" value="list_by_name">Search</button>
</form>

<form method="post" class = "List_manage">
    <h3>Delete EOIs by Job Reference</h3>
    <input type="text" name="job_ref" placeholder="Job Reference" required>
    <button name="action" value="delete_by_job" style="color:red;">Delete</button>
</form>

<form method="post" class = "List_manage">
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
