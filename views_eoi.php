<?php
require_once "settings.php";

$action = $_POST['action'] ?? '';
$result = null;

// Helper function to display "None" for null or empty values
function display_field($value) {
    return $value === null || $value === '' ? 'None' : htmlspecialchars($value);
}

// Build the query dynamically with LEFT JOIN for skills
if ($action == "list_all") {
    $query = "
        SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
        FROM eoi e
        LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
        LEFT JOIN skills s ON us.skill_id = s.skill_id
        GROUP BY e.eoi_number
    ";
    $result = mysqli_query($conn, $query);

} elseif ($action == "list_by_job") {
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $query = "
        SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
        FROM eoi e
        LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
        LEFT JOIN skills s ON us.skill_id = s.skill_id
        WHERE reference_number = '$reference_number'
        GROUP BY e.eoi_number
    ";
    $result = mysqli_query($conn, $query);

} elseif ($action == "list_by_name") {
    $first = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last  = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $query = "
        SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
        FROM eoi e
        LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
        LEFT JOIN skills s ON us.skill_id = s.skill_id
        WHERE (first_name LIKE '%$first%' OR '$first' = '') 
          AND (last_name LIKE '%$last%' OR '$last' = '')
        GROUP BY e.eoi_number
    ";
    $result = mysqli_query($conn, $query);

} elseif ($action == "delete_by_job") {
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $query = "DELETE FROM eoi WHERE reference_number = '$reference_number'";
    if (mysqli_query($conn, $query)) {
        echo "<p class='Announcement'>EOIs for job ref '$reference_number' have been deleted.</p>";
        $query = "
            SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
            FROM eoi e
            LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
            LEFT JOIN skills s ON us.skill_id = s.skill_id
            GROUP BY e.eoi_number
        ";
        $result = mysqli_query($conn, $query);
    } else {
        echo "<p class='Announcement'>Error deleting records.</p>";
    }

} elseif ($action == "change_status") {
    $eoi_number = $_POST['eoi_number'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $query = "UPDATE eoi SET status = '$status' WHERE eoi_number = $eoi_number";
    if (mysqli_query($conn, $query)) {
        echo "<p class='Announcement'>Status updated successfully.</p>";
        $query = "
            SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
            FROM eoi e
            LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
            LEFT JOIN skills s ON us.skill_id = s.skill_id
            GROUP BY e.eoi_number
        ";
        $result = mysqli_query($conn, $query);
    } else {
        echo "<p class='Announcement'>Error updating status.</p>";
        $query = "
            SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
            FROM eoi e
            LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
            LEFT JOIN skills s ON us.skill_id = s.skill_id
            GROUP BY e.eoi_number
        ";
        $result = mysqli_query($conn, $query);
    }
} elseif ($action == "bulk_update_status") {
    // NEW BULK UPDATE ACTION
    $eoi_numbers = $_POST['eoi_number'];
    $statuses    = $_POST['status'];

    for ($i = 0; $i < count($eoi_numbers); $i++) {
        $id = mysqli_real_escape_string($conn, $eoi_numbers[$i]);
        $status = mysqli_real_escape_string($conn, $statuses[$i]);

        $query = "UPDATE eoi SET status = '$status' WHERE eoi_number = '$id'";
        mysqli_query($conn, $query);
    }

    echo "<p class='Announcement'>All statuses updated successfully.</p>";
    $query = "
        SELECT e.*, GROUP_CONCAT(s.skill_name SEPARATOR ', ') AS skills_list
        FROM eoi e
        LEFT JOIN user_skills us ON e.eoi_number = us.eoi_number
        LEFT JOIN skills s ON us.skill_id = s.skill_id
        GROUP BY e.eoi_number
    ";
    $result = mysqli_query($conn, $query);
}
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
    <a id="back_to_Manage_Page_icon" href="manage.php"><i class='bx bx-reply-stroke'></i> Back to Manage Page</a>
    <div class="container">
        <h1 id="EOI_Query_Results_title">EOI Query Results</h1>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
         <!--FORM FOR BULK STATUS UPDATE -->
        <form method="POST" action="">
            <input type="hidden" name="action" value="bulk_update_status">

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

                    <!-- Editable dropdown for bulk status update -->
                    <td>
                        <input type="hidden" name="eoi_number[]" value="<?= $row['eoi_number'] ?>">

                        <select name="status[]" class="status_select">
                            <option value="New"        <?= ($row['status']=='New' ? 'selected' : '') ?>>New</option>
                            <option value="Current"<?= ($row['status']=='Current' ? 'selected' : '') ?>>Current</option>
                            <option value="Final"   <?= ($row['status']=='Final' ? 'selected' : '') ?>>Final</option>
                        </select>
                    </td>
                </tr>
                <?php endwhile; ?>

            </table>

            <!-- BULK UPDATE BUTTON -->
            <button type="submit" class="save_button">Save All Changes</button>

        </form>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
