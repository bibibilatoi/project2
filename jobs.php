<?php 
include 'settings.php';
$query = "SELECT * FROM jobs ORDER BY job_id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link href="styles/styles.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">
        <title>Job Positions</title>
    </head>
    <body class="jobs-body">
        <header>
            <nav id="nav-menu">
                <input type="checkbox" id="nav-menu-toggle">
                <label for="nav-menu-toggle">Menu</label>
                <ul>
                    <li><a href="index.html">Home Page</a></li>
                    <li><a id="current-page" href="#">Jobs Positions</a></li>
                    <li><a href="apply.html">Applications</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="mailto:info@speedx.com.au"><strong>Contact us:</strong> info@speedx.com.au</a></li>
                </ul>
            </nav>
            <div id="logo">
              <img  src="images/speedx_logo.png" height="80" width="80" alt="speedX logo" >
              <p>SpeedX</p>
            </div>
            
            <section id="banner">
                <p>
                  SpeedX - Bridging innovation and the infinite 
                </p>
            </section>
        </header>
    

        <main class="jobs-main">
            <section id="forewords">
                <h1>Job Listing</h1>
                <p>
                    SpeedX was founded under the belief that a future where humanity is out exploring the stars is 
                    fundamentally more exciting than one where we are not. Today SpeedX is actively developing the 
                    technologies to make this possible, with the ultimate goal of enabling human life beyond Earth.
                </p>
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
            <section id="currently-hiring">
                <h2>Currently Hiring for:</h2>
                <ol>
                    <li><strong>AI engineer </strong>(AI, Automation and Mission System Department)</li>
                    <li><strong>Network Security Engineer </strong>(Manufacturing and IT Operations Department)</li>
                </ol>
            </section>





            <input type="checkbox" id="toggle-jobs-menu" checked>
            <label for="toggle-jobs-menu" class="jobs-menu-label">Jobs</label>
            <section class="job-menu">
                <ul>

                    <!-- Propulsion and Aerospace Engineering -->
                    <!-- Propulsion and Aerospace Engineering -->
                    <!-- Propulsion and Aerospace Engineering -->

                    <li>
                        <input type="radio" id="dept-propulsion-select" name="department-select">

                        <section class="department-content">
                            <label for="dept-propulsion-select">Propulsion and Aerospace Engineering</label>

                            <div class="job-listing-container">
                                
                                <section class="job-positions">
                                    <input type="checkbox" id="job-propulsion-1" name="job-propulsion-checkbox">
                                    <label for="job-propulsion-1">Structural Engineer</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>PA01</dd>
                                            <dt>Reports To:</dt><dd>Head of Propulsion Engineering</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Develops lightweight, high-strength rocket components using advanced composites.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-propulsion-2" name="job-propulsion-checkbox">
                                    <label for="job-propulsion-2">Thermal Systems Engineer</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>PA02</dd>
                                            <dt>Reports To:</dt><dd>Senior Thermal Systems Engineer</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Creates systems to regulate heat and protect spacecraft during flight.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-propulsion-3" name="job-propulsion-checkbox">
                                    <label for="job-propulsion-3">Test Technician</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>PA03</dd>
                                            <dt>Reports To:</dt><dd>Propulsion Test Manager</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Operates test facilities and collects performance data from engine and structural tests.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>
                            </div>
                        </section>
                    </li>
                    <!-- AI, Automation and Mission Systems -->
                    <!-- AI, Automation and Mission Systems -->
                    <!-- AI, Automation and Mission Systems -->

                    <li>
                        <input type="radio" id="dept-ai-select" name="department-select">

                        <section class="department-content">
                            <label for="dept-ai-select"><span class="blink-arrow"> > </span>AI, Automation and Mission Systems</label>

                            <div class="job-listing-container">
<?php 
$job_counter = 1;
foreach ($jobs as $job) {
       $responsibilities = explode("\n", $job['key_responsibilities']);
    $qualifications = explode("\n", $job['basic_qualifications']);
    $preferred = explode("\n", $job['preferred_skills']);
    $additional = explode("\n", $job['additional_requirements']);
    ?>
        
        <section class="job-positions">
        <input type="checkbox" id="job-dynamic-<?php echo $job_counter; ?>" name="job-dynamic-checkbox">
        <label for="job-dynamic-<?php echo $job_counter; ?>"><?php echo htmlspecialchars($job['job_title']); ?></label>
        <div class="job-descriptions">
            <dl class="job-basic-info">
                <dt>Reference Number:</dt><dd><?php echo htmlspecialchars($job['job_reference']); ?></dd>
                <dt>Salary Range:</dt><dd><?php echo htmlspecialchars($job['salary_range']); ?></dd>
                <dt>Reports To:</dt><dd><?php echo htmlspecialchars($job['reports_to']); ?></dd>
            </dl>
            
            <h4>Brief Description</h4>
            <p><?php echo htmlspecialchars($job['brief_description']); ?></p>

            <h4>Key Responsibilities</h4>
            <ul>
                <?php foreach ($responsibilities as $item): 
                    $item = trim($item);
                    if (!empty($item)): ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endif;
                endforeach; ?>
            </ul>

            <h4>Basic Qualifications</h4>
            <ul>
                <?php foreach ($qualifications as $item): 
                    $item = trim($item);
                    if (!empty($item)): ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endif;
                endforeach; ?>
            </ul>

            <h4>Preferred Skills and Experience</h4>
            <ul>
                <?php foreach ($preferred as $item): 
                    $item = trim($item);
                    if (!empty($item)): ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endif;
                endforeach; ?>
            </ul>

            <h4>Additional Requirements</h4>
            <ul>
                <?php foreach ($additional as $item): 
                    $item = trim($item);
                    if (!empty($item)): ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endif;
                endforeach; ?>
            </ul>
        </div>
    </section>
    
    <?php
    $job_counter++;
}
?>

                                <!-- SOURCE/INSPIRATION: SPACEX https://job-boards.greenhouse.io/spacex/jobs/8085781002 -->
                        
                        
                                <section class="job-positions">
                                    <input type="checkbox" id="job-ai-2" name="job-ai-checkbox">
                                    <label for="job-ai-2">Robotics Developer</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>AI02</dd>
                                            <dt>Reports To:</dt><dd>Robotics Team Lead</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Designs robotic arms and systems for satellite assembly and space operations.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-ai-3" name="job-ai-checkbox">
                                    <label for="job-ai-3">Mission Planner</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>AI03</dd>
                                            <dt>Reports To:</dt><dd>Mission Systems Director</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Plans launch trajectories, mission timelines, and payload deployment paths.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                            </div>
                        </section>
                    </li>


                    <!-- Manufacturing and IT Operations -->
                    <!-- Manufacturing and IT Operations -->
                    <!-- Manufacturing and IT Operations -->

                    <li>
                        <input type="radio" id="dept-manufacturing-select" name="department-select">

                        <section class="department-content">
                            <label for="dept-manufacturing-select"><span class="blink-arrow"> > </span>Manufacturing and IT Operations</label>
                            <div class="job-listing-container">

                                <section class="job-positions">
                                    <input type="checkbox" id="job-ops-1" name="job-ops-checkbox">
                                    <label for="job-ops-1">Manufacturing Engineer</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>MO01</dd>
                                            <dt>Reports To:</dt><dd>Manufacturing Manager</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Oversees production and assembly of rocket and spacecraft components with precision and quality.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-ops-2" name="job-ops-checkbox">
                                    <label for="job-ops-2">Quality Assurance Specialist</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>MO02</dd>
                                            <dt>Reports To:</dt><dd>QA Department Lead</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Ensures all aerospace parts and systems meet performance and safety standards.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-ops-3" name="job-ops-checkbox">
                                    <label for="job-ops-3">Supply Chain Coordinator</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>MO03</dd>
                                            <dt>Reports To:</dt><dd>Supply Chain Manager</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Manages logistics and procurement for production and testing operations.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>


                                <!-- SOURCE/INSPIRATION: SPACEX https://job-boards.greenhouse.io/spacex/jobs/7926586002 -->
                               </div>
                        </section>
                    </li>


                    <!-- Business, IT and Communications -->
                    <!-- Business, IT and Communications -->
                    <!-- Business, IT and Communications -->

                    <li>
                        <input type="radio" id="dept-business-select" name="department-select">

                        <section class="department-content">
                            <label for="dept-business-select">Business, IT and Communications</label>
                            <div class="job-listing-container">

                                <section class="job-positions">
                                    <input type="checkbox" id="job-business-1" name="job-business-checkbox">
                                    <label for="job-business-1">Business Development Manager</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>BC01</dd>
                                            <dt>Reports To:</dt><dd>Director of Business Strategy</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Builds partnerships, manages contracts, and drives company growth opportunities.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>
                                
                                <section class="job-positions">
                                    <input type="checkbox" id="job-business-3" name="job-business-checkbox">
                                    <label for="job-business-3">Marketing and PR Specialist</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>BC02</dd>
                                            <dt>Reports To:</dt><dd>Chief Marketing Officer</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Manages public communications, branding campaigns, and launch event promotions.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                                <section class="job-positions">
                                    <input type="checkbox" id="job-business-4" name="job-business-checkbox">
                                    <label for="job-business-4">HR and Recruitment Officer</label>
                                    <div class="job-descriptions">
                                        <dl class="job-basic-info">
                                            <dt>Reference Number:</dt><dd>BC03</dd>
                                            <dt>Reports To:</dt><dd>Director of Human Resources</dd>
                                        </dl>
                                        
                                        <h4>Brief Description</h4>
                                        <p>
                                            Oversees recruitment and employee development to attract and retain top talent.
                                        </p>
                                        <h4 class="not-hiring">Currently Not Hiring</h4>
                                    </div>
                                </section>

                            </div>
                        </section>
                    </li>
                </ul>
            </section>



            <div class="go-apply-btn"><a href="apply.html">Go to apply page</a></div>
        </main>

        <footer>
            <p><strong>2025 SpeedX</strong> - "Bridging innovation and the infinite."</p>
            
            <div>
                <p><strong>SpeedX</strong></p>
                <img src="images/speedx_logo.png" height="80" width="80" alt="speedX logo">
            </div>
            
            <div id="contact-info">
                <a href="mailto:info@speedx.com.au"><strong>Contact us:</strong> info@speedx.com.au</a>
                <p><strong>Address:</strong> 42 Galaxy Road, Orbit City</p>
                <p><strong>Phone:</strong> +1-800-555-SpeedX</p>
                <a href="https://trinhthaianhtuan.atlassian.net/jira/software/projects/HCFPP1/boards/35/timeline?">
                    <strong>Visit our Jira project</strong>
                </a>
                
                <a href="https://github.com/bibibilatoi/project1">
                    <strong>Visit the GitHub repo of this project</strong>
                </a>
                <p>&copy; 2025 SpeedX. All rights reserved.</p>
            </div>
        </footer>
        
        


    <!-- SOURCE/INSPIRATION for AI Engineer: SPACEX https://job-boards.greenhouse.io/spacex/jobs/8085781002 -->
    <!-- SOURCE/INSPIRATION for Network Security Engineer: SPACEX https://job-boards.greenhouse.io/spacex/jobs/7926586002 -->

    <!-- GEN-AI PROMPT for other positions-->
    <!-- I have a makeup IT company name SpeedX (SpaceX inspired). The company is all about making spaceship and tools to explore spaces. 
    Help me to come up with different departments and job positions for them. (2 layers: departments and job positions). 
    I already have two positions already: Network Security Engineer and AI engineer. Also limit the number of departments to 4. 
    Go with this structure for the job positions: 1. job title 2. report to ... 3. a brief descriptiton -->
    </body>
</html>
