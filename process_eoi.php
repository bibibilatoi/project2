<?php
// process_eoi.php
include 'settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Collect main EOI data
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $suburb = mysqli_real_escape_string($conn, $_POST['suburb']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $other_skills = mysqli_real_escape_string($conn, $_POST['other_skills'] ?? '');

    $address = $street . ', ' . $suburb . ', ' . $state . '. Postcode:' . $postcode;

    // 2. Insert into eoi table
    $insert_eoi = "INSERT INTO eoi (reference_number, first_name, last_name, date_of_birth, gender, email, phone, other_skills)
                   VALUES ('$reference_number', '$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone', '$other_skills')";

    if (mysqli_query($conn, $insert_eoi)) {
        $skill_id = mysqli_insert_id($conn);

        // 3. Insert selected skills (array of skill_ids)
        if (!empty($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill_name) {
                $skill_name = mysqli_real_escape_string($conn, $skill_name);
                mysqli_query($conn, "INSERT INTO skills (skill_name, skill_id) VALUES ('$skill_name', '$skill_id')");
            }
        }

        echo "<h2>Thank you! Your application has been submitted.</h2>";

        // 4. Display submitted data
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>EOI Number</th><td>" . htmlspecialchars($eoi_number) . "</td></tr>";
        echo "<tr><th>Job Reference</th><td>" . htmlspecialchars($reference_number) . "</td></tr>";
        echo "<tr><th>Name</th><td>" . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "</td></tr>";
        echo "<tr><th>Date of Birth</th><td>" . htmlspecialchars($date_of_birth) . "</td></tr>";
        echo "<tr><th>Gender</th><td>" . htmlspecialchars($gender) . "</td></tr>";
        echo "<tr><th>Address</th><td>" . htmlspecialchars($address) . "</td></tr>";
        echo "<tr><th>Email</th><td>" . htmlspecialchars($email) . "</td></tr>";
        echo "<tr><th>Phone</th><td>" . htmlspecialchars($phone) . "</td></tr>";
        echo "<tr><th>Other Skills / Notes</th><td>" . nl2br(htmlspecialchars($other_skills)) . "</td></tr>";

        // 5. Fetch and display skill names
        if (!empty($_POST['skills'])) {
            $skill_ids = implode(",", array_map('intval', $_POST['skills']));
            $skill_query = "SELECT skill_name FROM skills WHERE skill_id IN ($skill_ids)";
            $skill_result = mysqli_query($conn, $skill_query);

            echo "<tr><th>Selected Skills</th><td><ul>";
            while ($s = mysqli_fetch_assoc($skill_result)) {
                echo "<li>" . htmlspecialchars($s['skill_name']) . "</li>";
            }
            echo "</ul></td></tr>";
        }

        echo "</table>";

    } else {
        echo "<p>Error submitting EOI: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);
?>
