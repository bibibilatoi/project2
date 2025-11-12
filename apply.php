
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/apply_styles.css" rel="stylesheet">

        <title>Applications</title>
    </head>
    <body id="apply-body">
        <?php include("header.inc") ?>

        
        <main class="jobs-main">
                <h1 id="h1-apply">Job Application Form ssss</h1>
                <form id="jobApplicationForm" method="post" action="process_eoi.php">
                    
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
                            <input type="checkbox" id="Pg" name="skills" value="Programming">
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
        <?php include("footer.inc") ?>
    </body>
</html>

<!-- ACKNOWLEDGEMENT -->
 <!-- ALL patterns are created with the help of Gen-AI -->

