<?php
require_once "settings.php";

$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'] ?? '';
$result = null;
$message = ''; // For success/error messages

// Helper function to display "None" for null or empty values
function display_field($value) {
    return $value === null || $value === '' ? 'None' : htmlspecialchars($value);
}

// Base query for SELECT operations (always includes JOINS)
$base_select_query = "
    SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
    FROM eoi e
    LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
    LEFT JOIN skills s ON us.skill_id = s.skill_id
";


if ($action == "list_all") {
    $query = $base_select_query . " GROUP BY e.eoi_number";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

} elseif ($action == "list_by_job") {
    $reference_number = $_POST['reference_number'] ?? '';
    $query = $base_select_query . " WHERE reference_number = ? GROUP BY e.eoi_number";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $result = $stmt->get_result();

} elseif ($action == "list_by_name") {
    $first = "%" . trim($_POST['first_name'] ?? '') . "%"; // Add wildcards here
    $last  = "%" . trim($_POST['last_name'] ?? '') . "%";

    // Use placeholder logic for optional search fields
    $query = $base_select_query . " 
        WHERE first_name LIKE ? AND last_name LIKE ?
        GROUP BY e.eoi_number
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $first, $last);
    $stmt->execute();
    $result = $stmt->get_result();

} elseif ($action == "delete_by_job") {
    $reference_number = $_POST['reference_number'] ?? '';

    // A. Delete records from EOI table
    $stmt_delete = $conn->prepare("DELETE FROM eoi WHERE reference_number = ?");
    $stmt_delete->bind_param("s", $reference_number);

    if ($stmt_delete->execute()) {
        $message = "Deleted all EOI in department: " . htmlspecialchars($reference_number) . ".";
        // Optionally show the remaining records after deletion
        $query = $base_select_query . " GROUP BY e.eoi_number";
        $stmt_list = $conn->prepare($query);
        $stmt_list->execute();
        $result = $stmt_list->get_result();
        $stmt_list->close();
    } else {
        $message = "Error deleting records: " . $stmt_delete->error;
    }
    $stmt_delete->close();

} elseif ($action == "change_status") {
    $eoi_number = (int) $_POST['eoi_number'];
    $status = $_POST['status'] ?? '';

    // A. Update Status
    $stmt_update = $conn->prepare("UPDATE eoi SET status = ? WHERE eoi_number = ?");
    $stmt_update->bind_param("si", $status, $eoi_number);

    if ($stmt_update->execute()) {
        $message = "Status updated successfully!";
        
        // B. Get ONLY the updated record to display
        $query = $base_select_query . " WHERE e.eoi_number = ? GROUP BY e.eoi_number";
        $stmt_select = $conn->prepare($query);
        $stmt_select->bind_param("i", $eoi_number);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $stmt_select->close();

    } else {
        $message = "Error updating status: " . $stmt_update->error;
    }
    $stmt_update->close();
}

// --- 4. Database Cleanup (CRITICAL: Must run regardless of path) ---
if (isset($result) && $result instanceof mysqli_result) {
    // Only free if we have a result object that was used in the HTML below
}
$conn->close();

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
    <link href="styles/views_eoi_styles.css" rel="stylesheet">
    <title>EOI Query Results</title>
    <link href='https://cdn.boxicons.com/3.0.3/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <a id="back_to_Manage_Page_icon" href="manage.php"><i class='bx bx-reply-stroke'></i> Back to Manage Page</a>
        <h1 id="EOI_Query_Results_title">EOI Query Results</h1>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>EOI number</th>
                <th>Job Ref</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of birth</th>
                <th>Gender</th>
                <th>Street address</th>
                <th>Suburb/Town</th>
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
                <td><?= display_field($row['eoi_number']) ?></td>
                <td><?= display_field($row['reference_number']) ?></td>
                <td><?= display_field($row['first_name']) ?></td>
                <td><?= display_field($row['last_name']) ?></td>
                <td><?= display_field($row['date_of_birth']) ?></td>
                <td><?= display_field($row['gender']) ?></td>
                <td><?= display_field($row['street']) ?></td>
                <td><?= display_field($row['suburb']) ?></td>
                <td><?= display_field($row['state']) ?></td>
                <td><?= display_field($row['postcode']) ?></td>
                <td><?= display_field($row['email']) ?></td>
                <td><?= display_field($row['phone']) ?></td>
                <td><?= display_field($row['skills_list']) ?></td>
                <td><?= display_field($row['other_skills']) ?></td>
                <td><?= display_field($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// FINAL CLEANUP: Ensure result is freed after display
if (isset($result) && $result instanceof mysqli_result) {
    $result->free(); 
}
?>