<?php
require_once 'settings.php';

$sql = "SELECT * FROM jobs ORDER BY department, reference_number";
$result = $conn->query($sql);

$departments = [];
$jobs_data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[$row['department']][] = $row;
        $jobs_data[$row['job_id']] = $row;
    }
}


$job_ids = array_keys($jobs_data);
if (!empty($job_ids)) {
    $ids_string = implode(',', $job_ids);

    // Key Responsibilities
    $key_responsibilities = [];
    $res = $conn->query("SELECT * FROM key_responsibilities WHERE job_id IN ($ids_string)");
    while ($row = $res->fetch_assoc()) {
        $key_responsibilities[$row['job_id']][] = $row['responsibility'];
    }

    // Basic Qualifications
    $basic_qualifications = [];
    $res = $conn->query("SELECT * FROM basic_qualifications WHERE job_id IN ($ids_string)");
    while ($row = $res->fetch_assoc()) {
        $basic_qualifications[$row['job_id']][] = $row['qualification'];
    }

    // Preferred Skills
    $preferred_skills = [];
    $res = $conn->query("SELECT * FROM preferred_skills WHERE job_id IN ($ids_string)");
    while ($row = $res->fetch_assoc()) {
        $preferred_skills[$row['job_id']][] = $row['skill'];
    }

    // Additional Requirements
    $additional_requirements = [];
    $res = $conn->query("SELECT * FROM additional_requirements WHERE job_id IN ($ids_string)");
    while ($row = $res->fetch_assoc()) {
        $additional_requirements[$row['job_id']][] = $row['additional_requirement'];
    }
}


$currently_hiring_jobs = [];
foreach ($departments as $jobs) {
    foreach ($jobs as $job) {
        if ($job['is_hiring']) {
            $currently_hiring_jobs[] = $job;
        }
    }
}


$hiring_departments = [];

foreach ($departments as $deptName => $jobs) {
    foreach ($jobs as $job) {
        if ($job['is_hiring']) {
            $hiring_departments[$deptName] = true;
            break; // one hiring job is enough
        }
    }
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
    <link href="styles/jobs_styles.css" rel="stylesheet">
    <title>Job Positions</title>
</head>
<body class="jobs-body">
    <?php include("header.inc") ?>

    <main class="jobs-main">
        <section id="forewords">
            <h1>Job Listing</h1>
            <p>
                SpeedX was founded under the belief that a future where humanity is out exploring the stars is 
                fundamentally more exciting than one where we are not. Today SpeedX is actively developing the 
                technologies to make this possible, with the ultimate goal of enabling human life beyond Earth.
            </p>
        </section>



        <input type="checkbox" id="toggle-jobs-menu" checked>
        <div class="main-buttons">
            <label for="toggle-jobs-menu" class="jobs-menu-button">Jobs</label>
            <a  class="go-apply-btn" href="apply.php">Go to apply page</a>
        </div>

        <section class="job-menu">
            <ul>
                <?php foreach ($departments as $deptIndex => $jobs): 
                    $deptId = "dept-" . strtolower(str_replace(' ', '-', $deptIndex)) . "-select";
                ?>
                    <li>
                        <input type="checkbox" id="<?= $deptId ?>" name="department-select">
                        <section class="department-content">
                            <label for="<?= $deptId ?>"  class="<?= isset($hiring_departments[$deptIndex]) ? 'dept-hiring' : '' ?>" >    
                                <?= htmlspecialchars($deptIndex) ?>
                            </label>

                            <div class="job-listing-container">
                            <?php foreach ($jobs as $job): 
                                $jobId = "job-" . strtolower(str_replace(' ', '-', $job['reference_number']));
                            ?>
                                <section class="job-positions">
                                    <input type="checkbox" id="<?= $jobId ?>" name="<?= $jobId ?>-checkbox">
                                    <label for="<?= $jobId ?>" class="<?= $job['is_hiring'] ? 'is-hiring' : '' ?>">
                                        <?= htmlspecialchars($job['job_title']) ?>
                                    </label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <section class="pair-data">
                                                <dt>Reference Number:</dt><dd><?= htmlspecialchars($job['reference_number']) ?></dd>
                                            </section>
                                            <section class="pair-data">
                                                <dt>Reports To:</dt><dd><?= htmlspecialchars($job['reports_to']) ?></dd>
                                            </section>
                                            <section class="pair-data">
                                                <dt>Salary Range:</dt><dd><?= htmlspecialchars($job['salary_range']) ?></dd>
                                            </section>
                                        </dl>

                                        <?php if (!empty($job['brief_description'])): ?>
                                            <h3>Brief Description</h3>
                                            <p><?= htmlspecialchars($job['brief_description']) ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($key_responsibilities[$job['job_id']])): ?>
                                            <h3>Key Responsibilities</h3>
                                            <ul>
                                                <?php foreach ($key_responsibilities[$job['job_id']] as $resp): ?>
                                                    <li><?= htmlspecialchars($resp) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($basic_qualifications[$job['job_id']])): ?>
                                            <h3>Basic Qualifications</h3>
                                            <ul>
                                                <?php foreach ($basic_qualifications[$job['job_id']] as $qual): ?>
                                                    <li><?= htmlspecialchars($qual) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($preferred_skills[$job['job_id']])): ?>
                                            <h3>Preferred Skills</h3>
                                            <ul>
                                                <?php foreach ($preferred_skills[$job['job_id']] as $skill): ?>
                                                    <li><?= htmlspecialchars($skill) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($additional_requirements[$job['job_id']])): ?>
                                            <h3>Additional Requirements</h3>
                                            <ul>
                                                <?php foreach ($additional_requirements[$job['job_id']] as $req): ?>
                                                    <li><?= htmlspecialchars($req) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!$job['is_hiring']): ?>
                                            <h3 class="not-hiring">Currently Not Hiring</h3>
                                        <?php endif; ?>
                                    </div>
                                </section>
                            <?php endforeach; ?>
                            </div>
                        </section>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        

        <section id="bottom-section">
            <section class="jobs-benefits">
                <h2>Employee Benefits</h2>
                <ul>
                    <li><strong>Flexible Working Options: </strong>Hybrid remote and office opportunities</li>
                    <li><strong>Stock and Equity Grants: </strong>Long-term incentives tied to mission success</li>
                    <li><strong>Health and Wellness: </strong>Comprehensive medical, dental, and mental health support</li>
                    <li><strong>Professional Growth: </strong>Training, conferences, and career development programs</li>
                    <li><strong>Education Assistance: </strong>Tuition reimbursement for continued learning</li>
                </ul>
            </section>

            <aside class="jobs-aside">
                <h2>Hiring Process Timeline</h2>
                <ol>
                    <li><strong>Submit Application:</strong> Complete the application form.</li>
                    <li><strong>Initial Screening:</strong> Our HR team reviews your qualifications against the essential criteria.</li>
                    <li><strong>Technical Interview:</strong> A specialist from the department will test your core skills.</li>
                    <li><strong>Team Interview:</strong> Meet with the hiring manager and future team members for cultural fit.</li>
                    <li><strong>Offer Extended:</strong> Successful candidates receive a formal offer letter.</li>
                </ol>
            </aside>
        </section>


    </main>

    <?php include("footer.inc") ?>
</body>
</html>
