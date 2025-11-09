<?php
require_once "settings.php";

$action = $_GET['action'] ?? "";
$result = null;
if ($action == "list_all") {
    $query = "SELECT * FROM eoi";
    $result = mysqli_query($conn, $query);

} elseif ($action == "list_by_job") {
    $job_ref = mysqli_real_escape_string($conn, $_POST['job_ref']);
    $query = "SELECT * FROM eoi WHERE Job_Reference_number = '$job_ref'";
    $result = mysqli_query($conn, $query);

} elseif ($action == "list_by_name") {
    $first = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last  = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $query = "SELECT * FROM eoi WHERE 
                (First_name LIKE '%$first%' OR '$first' = '') 
                AND (Last_name LIKE '%$last%' OR '$last' = '')";
    $result = mysqli_query($conn, $query);

} elseif ($action == "delete_by_job") {
    $job_ref = mysqli_real_escape_string($conn, $_POST['job_ref']);
    $query = "DELETE FROM eoi WHERE Job_Reference_number = '$job_ref'";
    if (mysqli_query($conn, $query)) {
        echo "<p>EOIs for job ref '$job_ref' have been deleted.</p>";
    } else {
        echo "<p>Error deleting records.</p>";
    }

} elseif ($action == "change_status") {
    $eoi_number = $_POST['eoi_number'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $query = "UPDATE eoi SET status = '$status' WHERE EOI_number = $eoi_number";
    if (mysqli_query($conn, $query)) {
        echo "<p>Status updated successfully.</p>";
    } else {
        echo "<p>Error updating status.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en"></html>
<?php include 'head.inc'; ?>
<body>
    <a id="back_to_Manage_Page_icon"href="manage.php">← Back to Manage Page</a>
    <h1 id="EOI_Query_Results_title">EOI Query Results</h1>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>EOI number</th>
            <th>Job Ref</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Street address</th>
            <th>Surburb/town</th>
            <th>State</th>
            <th>Postcode</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Skills</th>
            <th>Other skills</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['EOI_number']) ?></td>
            <td><?= htmlspecialchars($row['Job_Reference_number']) ?></td>
            <td><?= htmlspecialchars($row['First_name']) ?></td>
            <td><?= htmlspecialchars($row['Last_name']) ?></td>
            <td><?= htmlspecialchars($row['Street_address']) ?></td>
            <td><?= htmlspecialchars($row['Suburb_town']) ?></td>
            <td><?= htmlspecialchars($row['State']) ?></td>
            <td><?= htmlspecialchars($row['Postcode']) ?></td>
            <td><?= htmlspecialchars($row['Email_address']) ?></td>
            <td><?= htmlspecialchars($row['Phone_number']) ?></td>
            <td><?= htmlspecialchars($row['Skills']) ?></td>
            <td><?= htmlspecialchars($row['Other_skills']) ?></td>
            <td><?= htmlspecialchars($row['Status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</body>
</html>