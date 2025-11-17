<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="job, application, IT">
    <title>IT Job Recruitment - Application Form</title>
    <link rel="stylesheet" href="styles/apply.css"> 
</head>
<body>
<?php include "nav.inc"; ?>

<section id="app_herosection" class="center colum flex_center">
    <img id="hp_hs_logo" src="images/logo.png" alt="3Ners">
    <h2 class="ap_title">JOB APPLICATION FORM</h2>
    <section class="ap_desc">
        <h3 class="ap_subtitle">
            Fill out our IT Job Application Form to share your skills, experience, and qualifications.
            Start your journey with us today and take the first step towards an exciting career in IT!
        </h3>
    </section>
</section>

<form id="app_form" class="colum flex_center center" action="process_eoi.php" method="POST" novalidate>

    <fieldset>
        <legend>Personal Information</legend>
        
        <div class="form-group grid-3-col">
            <div>
                <label for="job">Job Reference</label>
                <select id="job" name="job" required>
                    <option value="">Select a job</option>
                    <option value="G01">G01 - Software Developer</option>
                    <option value="G02">G02 - Network Administrator</option>
                    <option value="G03">G03 - Data Analyst</option>
                    <option value="G04">G04 - Cybersecurity Specialist</option>
                    <option value="G05">G05 - IT Support Technician</option>
                    <option value="G06">G06 - Cloud Engineer</option>
                    <option value="G07">G07 - AI/ML Engineer</option>
                    <option value="G08">G08 - Data Scientist</option>
                    <option value="G09">G09 - Data Engineer</option>
                </select>
            </div>
            <div>
                <label for="fullname">First Name</label>
                <input type="text" id="fullname" name="fullname" required maxlength="20">
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" required maxlength="20">
            </div>
        </div>

        <div class="form-group grid-2-col">
            <div>
                <label for="birth">Date of Birth (dd/mm/yyyy)</label>
                <input type="date" id="birth" name="birth" required>
            </div>
          <div>
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="undecided">Undecided</option>
                </select>
            </div>
        <div class="form-group grid-3-col">
            <div>
                <label for="address">Street Address</label>
                <input type="text" id="address" name="address" required maxlength="40">
            </div>
            <div>
                <label for="suburb">Suburb/Town</label>
                <input type="text" id="suburb" name="suburb" required maxlength="40">
            </div>
            <div>
                <label for="state">State</label>
                <select id="state" name="state" required>
                    <option value="">Select a State</option>
                    <option value="VIC">VIC</option>
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="NT">NT</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>
                </select>
            </div>
        </div>

        <div class="form-group grid-3-col">
            <div>
                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" required maxlength="4">
            </div>
            <div>
                <label for="phonenumber1">Phone Number</label>
                <input type="tel" id="phonenumber1" name="phonenumber1" pattern="[\d\s]{8,12}" required>
            </div>
            <div>
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Education</legend>
        <div class="form-group grid-3-col">
            <div>
                <label for="university">University/Institution</label>
                <input type="text" id="university" name="university" required>
            </div>
            <div>
                <label for="degree">Degree/Certification</label>
                <input type="text" id="degree" name="degree" required>
            </div>
            <div>
                <label for="year">Year Completed</label>
                <input type="date" id="year" name="year" required>
            </div>
        </div>
    </fieldset>

    <fieldset>
      <div class="form-group grid-3-col">
        <legend>Skills & Qualifications</legend>
      </div>
      <div>
        <label>Required Technical Skill List:</label>
      </div>
        <div>
            <label><input type="checkbox" name="skills[]" value="HTML"> HTML</label>
            <label><input type="checkbox" name="skills[]" value="CSS"> CSS</label>
            <label><input type="checkbox" name="skills[]" value="JavaScript"> JavaScript</label>
            <label><input type="checkbox" name="skills[]" value="PHP"> PHP</label>
            <label><input type="checkbox" name="skills[]" value="MySQL"> MySQL</label>
            <label><input type="checkbox" name="skills[]" value="Others"> Others</label>
        </div>
        <label for="description">List relevant skills (Other skills):</label>
        <div class="form-group">
            <textarea id="description" name="description" placeholder="Your skills..."></textarea>
        </div>
    </fieldset>

    <fieldset>
        <legend>Recent Employment History</legend>
        
        <div class="form-group grid-3-col">
            <label for="company1">Company Name</label>
            <input type="text" id="company1" name="company1" required>

            <label for="position1">Position Held</label>
            <input type="text" id="position1" name="position1" required>

            <label for="emdate1">Employment Dates</label>
            <input type="date" id="emdate1" name="emdate1" required>
        </div>
    </fieldset>

    <fieldset>
        <legend>References</legend>

        <div class="form-group grid-3-col">
            <div>
                <label for="reference">Reference Name</label>
                <input type="text" id="reference" name="reference" required>
            </div>
            <div>
                <label for="relationship">Relationship</label>
                <input type="text" id="relationship" name="relationship" required>
            </div>
            <div>
                <label for="phonenumber2">Phone Number</label>
                <input type="tel" id="phonenumber2" name="phonenumber2" required pattern="[\d\s]{8,12}">
            </div>
        </div>
    </fieldset>

    <div id="app_certified" class="center colum flex_center">
        <p id="submit_reset">
            <input type="checkbox" id="responsibility" name="responsibility" required>
            <label for="responsibility"><strong>I certify the information is accurate.</strong></label>
        </p>

        <p class="submit-buttons">
            <input class="btn" type="submit" value="Submit">
            <input class="btn" type="reset" value="Reset">
        </p>
    </div>
</form>
</body>
</html>
<?php include "footer.inc"; ?>