<?php
require_once 'settings.php';

$sql = "SELECT * FROM jobs ORDER BY department, reference_no";
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

        <section id="currently-hiring">
            <h2>Currently Hiring for:</h2>
            
            <?php if (empty($currently_hiring_jobs)): ?>
                <h2>We are not currently hiring for any positions, but please check back soon!</h2>
            <?php else: ?>
                <ol>
                    <?php foreach ($currently_hiring_jobs as $job): ?>
                        <li>
                            <strong><?= htmlspecialchars($job['job_title']) ?></strong>
                            (<?= htmlspecialchars($job['department']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </section>

        <input type="checkbox" id="toggle-jobs-menu" checked>
        <label for="toggle-jobs-menu" class="jobs-menu-label">Jobs</label>
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
                                $jobId = "job-" . strtolower(str_replace(' ', '-', $job['reference_no']));
                            ?>
                                <section class="job-positions">
                                    <input type="checkbox" id="<?= $jobId ?>" name="<?= $jobId ?>-checkbox">
                                    <label for="<?= $jobId ?>" class="<?= $job['is_hiring'] ? 'is-hiring' : '' ?>">
                                        <?= htmlspecialchars($job['job_title']) ?>
                                    </label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd><?= htmlspecialchars($job['reference_no']) ?></dd>
                                            <dt>Reports To:</dt><dd><?= htmlspecialchars($job['reports_to']) ?></dd>
                                            <dt>Salary Range:</dt><dd><?= htmlspecialchars($job['salary_range']) ?></dd>
                                        </dl>

                                        <?php if (!empty($job['brief_description'])): ?>
                                            <h4>Brief Description</h4>
                                            <p><?= htmlspecialchars($job['brief_description']) ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($key_responsibilities[$job['job_id']])): ?>
                                            <h4>Key Responsibilities</h4>
                                            <ul>
                                                <?php foreach ($key_responsibilities[$job['job_id']] as $resp): ?>
                                                    <li><?= htmlspecialchars($resp) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($basic_qualifications[$job['job_id']])): ?>
                                            <h4>Basic Qualifications</h4>
                                            <ul>
                                                <?php foreach ($basic_qualifications[$job['job_id']] as $qual): ?>
                                                    <li><?= htmlspecialchars($qual) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($preferred_skills[$job['job_id']])): ?>
                                            <h4>Preferred Skills</h4>
                                            <ul>
                                                <?php foreach ($preferred_skills[$job['job_id']] as $skill): ?>
                                                    <li><?= htmlspecialchars($skill) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!empty($additional_requirements[$job['job_id']])): ?>
                                            <h4>Additional Requirements</h4>
                                            <ul>
                                                <?php foreach ($additional_requirements[$job['job_id']] as $req): ?>
                                                    <li><?= htmlspecialchars($req) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!$job['is_hiring']): ?>
                                            <h4 class="not-hiring">Currently Not Hiring</h4>
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

        <aside class="jobs-aside">
            <h3>Hiring Process Timeline</h3>
            <ol>
                <li><strong>Submit Application:</strong> Complete the application form.</li>
                <li><strong>Initial Screening:</strong> Our HR team reviews your qualifications against the essential criteria.</li>
                <li><strong>Technical Interview:</strong> A specialist from the department will test your core skills.</li>
                <li><strong>Team Interview:</strong> Meet with the hiring manager and future team members for cultural fit.</li>
                <li><strong>Offer Extended:</strong> Successful candidates receive a formal offer letter.</li>
            </ol>
        </aside>

        <section class="jobs-benefits">
            <h2>Employee Benefits</h2>
            <ul>
                <li>Flexible Working Options: Hybrid remote and office opportunities</li>
                <li>Stock and Equity Grants: Long-term incentives tied to mission success</li>
                <li>Health and Wellness: Comprehensive medical, dental, and mental health support</li>
                <li>Professional Growth: Training, conferences, and career development programs</li>
                <li>Education Assistance: Tuition reimbursement for continued learning</li>
            </ul>
        </section>

        <div class="go-apply-btn"><a href="apply.php">Go to apply page</a></div>
    </main>

    <?php include("footer.inc") ?>
</body>
</html>
