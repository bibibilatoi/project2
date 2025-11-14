
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link href="styles/styles.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">
        <title>Job Application</title>
    </head>
    <body id="apply-body">
        <header>
            <nav id="nav-menu">
                <input type="checkbox" id="nav-menu-toggle">
                <label for="nav-menu-toggle">Menu</label>
                <ul>
                    <li><a href="index.html">Home Page</a></li>
                    <li><a href="jobs.html">Jobs Positions</a></li>
                    <li><a id="current-page" href="#" >Applications</a></li>
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
                <h1 id="h1-apply">Job Application Form</h1>
                <form id="jobApplicationForm" method="post" action="https://mercury.swin.edu.au/it000000/formtest.php">
                    
                    <label  for="jobRef">Job Reference Number:</label>
                    <select id="jobRef" name="jobRef" required>
                        <option value="">--Select Job--</option>
                        <option value="AI01">AI01</option>
                        <option value="MO04">MO04</option>
                    </select>
                    
                    
                    <!-- First and Last name -->
                    <label  for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstname" maxlength="20" title="Max 20 alpha characters" pattern="[A-Za-zÀ-ỹà-ỹ\s]+" required>
                    

                    <label  for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" maxlength="20" title="Max 20 alpha characters" pattern="[A-Za-zÀ-ỹà-ỹ\s]+" required>
                    
                    
                    <!-- DOB -->
                    <label  for="dob">Date of Birth:</label>
                    <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" required>
                    
                    
                    <!-- Gender -->
                    <fieldset>
                        <legend>Gender</legend>
                        <div class="fieldset-container">
                            <input type="radio" id="male" name="gender" value="Male" required>
                            <label  for="male">Male</label>
                        </div>

                        <div class="fieldset-container">
                            <input type="radio" id="female" name="gender" value="Female" required>
                            <label  for="female">Female</label>
                        </div>
                        

                        <div class="fieldset-container">
                            <input type="radio" id="other" name="gender" value="Other" required>
                            <label  for="other">Other</label>
                        </div>

                    </fieldset>
                    
                    
                    <!-- Address -->
                    <label  for="street">Street Address:</label>
                    <input type="text" id="street" name="street" maxlength="40" title="Max 40 characters" required>
                    

                    <label  for="suburb">Suburb/Town:</label>
                    <input type="text" id="suburb" name="suburb" maxlength="40" title="Max 20 characters" required>
                    
                    
                    <!-- State -->
                    <label  for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="">--Select State--</option>
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                    
                    
                    <!-- Postcode -->
                    <label  for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" pattern="\d{4}" maxlength="4" title="Exactly 4 digits based on State" required>
                    
                    
                    <!-- Email -->
                    <label  for="email">Email:</label>
                    <input type="email" id="email" name="email" 
                        pattern="[a-z0-9.-%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required> 
                    
                    
                    <!-- Phone -->
                    <label  for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" pattern="[0-9 ]{8,12}" title="8 to 12 digits, or spaces" required> 
                    
                    
                    <!-- Technical Skills -->
                    <fieldset>
                        <legend>Required Technical Skills</legend>
                        <div class="fieldset-container">
                            <input type="checkbox" id="Pg" name="skills" value="Programming" required>
                            <label  for="Pg">Programming</label>
                        </div>

                        <div class="fieldset-container">
                            <input type="checkbox" id="Dh" name="skills" value="Data Handling">
                            <label  for="Dh">Data Handling</label>
                        </div>

                        <div class="fieldset-container">
                            <input type="checkbox" id="Ml" name="skills" value="Machine Learning">
                            <label  for="Ml">Machine Learning</label>
                        </div>

                        <div class="fieldset-container">
                            <input type="checkbox" id="Al" name="skills" value="Anotation and Labeling">
                            <label  for="Al">Anotation & Labeling</label>
                        </div>

                        <div class="fieldset-container">
                            <input type="checkbox" id="Oas" name="skills" value="Other Advanced Skills">
                            <label  for="Oas">Other Advanced Skills (For higher roles)</label>
                        </div>

                    </fieldset>
                    
                    
                    <!-- Other Skills -->
                    <label  for="otherSkills">Other Skills:</label>
                    
                    <textarea id="otherSkills" name="otherSkills" rows="4" cols="40"></textarea>
                    
                    
                    <!-- Submit -->
                    <button id="apply-button" type="submit">Apply</button>
                </form>
                
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
                <a href="https://trinhthaianhtuan.atlassian.net/jira/software/projects/HCFPP1/boards/35/timeline?" target="_blank">
                    <strong>Visit our Jira project</strong>
                </a>
                
                <a href="https://github.com/bibibilatoi/project1" target="_blank">
                    <strong>Visit the GitHub repo of this project</strong>
                </a>
                <p>&copy; 2025 SpeedX. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>

<!-- ACKNOWLEDGEMENT -->
 <!-- ALL patterns are created with the help of Gen-AI -->

