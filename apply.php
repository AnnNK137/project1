<?php
require_once "settings.php";

// Connect to database
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize form data
    $job       = mysqli_real_escape_string($conn, trim($_POST['job'] ?? ''));
    $fname     = mysqli_real_escape_string($conn, trim($_POST['fullname'] ?? ''));
    $lname     = mysqli_real_escape_string($conn, trim($_POST['lastname'] ?? ''));
    $dob       = mysqli_real_escape_string($conn, trim($_POST['birth'] ?? ''));
    $gender    = mysqli_real_escape_string($conn, trim($_POST['sex'] ?? ''));
    $address   = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $suburb    = mysqli_real_escape_string($conn, trim($_POST['suburb'] ?? ''));
    $country   = mysqli_real_escape_string($conn, trim($_POST['country'] ?? '')); // FIXED
    $postcode  = mysqli_real_escape_string($conn, trim($_POST['postcode'] ?? ''));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phonenumber1'] ?? ''));
    $skills    = $_POST['skills'] ?? [];
    $other     = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));

    // Education
    $university = mysqli_real_escape_string($conn, trim($_POST['university'] ?? ''));
    $degree     = mysqli_real_escape_string($conn, trim($_POST['degree'] ?? ''));
    $year       = mysqli_real_escape_string($conn, trim($_POST['year'] ?? NULL));

    // Employment
    $company1 = mysqli_real_escape_string($conn, trim($_POST['company1'] ?? ''));
    $position1 = mysqli_real_escape_string($conn, trim($_POST['position1'] ?? ''));
    $emdate1 = mysqli_real_escape_string($conn, trim($_POST['emdate1'] ?? NULL));

    $company2 = mysqli_real_escape_string($conn, trim($_POST['company2'] ?? ''));
    $position2 = mysqli_real_escape_string($conn, trim($_POST['position2'] ?? ''));
    $emdate2 = mysqli_real_escape_string($conn, trim($_POST['emdate2'] ?? NULL));

    $company3 = mysqli_real_escape_string($conn, trim($_POST['company3'] ?? ''));
    $position3 = mysqli_real_escape_string($conn, trim($_POST['position3'] ?? ''));
    $emdate3 = mysqli_real_escape_string($conn, trim($_POST['emdate3'] ?? NULL));

    // Reference
    $ref_name = mysqli_real_escape_string($conn, trim($_POST['reference'] ?? ''));
    $ref_rel  = mysqli_real_escape_string($conn, trim($_POST['relationship'] ?? ''));
    $ref_phone = mysqli_real_escape_string($conn, trim($_POST['phonenumber2'] ?? ''));

    // Validation
    $errors = [];
    if (empty($fname)) $errors[] = "First name required";
    if (empty($lname)) $errors[] = "Last name required";
    if (empty($job)) $errors[] = "Job required";
    if (!isset($_POST['responsibility'])) $errors[] = "You must accept responsibility";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalid";

    if (count($errors) > 0) {
        echo "<ul>";
        foreach ($errors as $err) echo "<li>$err</li>";
        echo "</ul><a href='apply.php'>Go Back</a>";
        exit;
    }

    // Map skills
    $skill1 = $skills[0] ?? '';
    $skill2 = $skills[1] ?? '';
    $skill3 = $skills[2] ?? '';

    // Insert
    $sql = "INSERT INTO eoi 
    (JobReference, FirstName, LastName, DateOfBirth, Gender, StreetAddress, SuburbTown, Country, Postcode, Email, Phone,
    Skill1, Skill2, Skill3, OtherSkills,
    University, Degree, YearCompleted,
    Company1, Position1, EmploymentDate1,
    Company2, Position2, EmploymentDate2,
    Company3, Position3, EmploymentDate3,
    ReferenceName, ReferenceRelationship, ReferencePhone)
    VALUES
    ('$job','$fname','$lname','$dob','$gender','$address','$suburb','$country','$postcode','$email','$phone',
    '$skill1','$skill2','$skill3','$other',
    '$university','$degree','$year',
    '$company1','$position1','$emdate1',
    '$company2','$position2','$emdate2',
    '$company3','$position3','$emdate3',
    '$ref_name','$ref_rel','$ref_phone')";

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        echo "<h2>Application Submitted Successfully!</h2>";
        echo "<p>Your EOInumber is: <strong>$id</strong></p>";
        echo "<a href='apply.php'>Submit another application</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="job, application, IT">
    <title>IT Job Recruitment - Application Form</title>
    <link rel="stylesheet" href="styles/styles.css">
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

<form id="app_form" class="colum flex_center center" action="apply.php" method="POST" novalidate>

<form id="app_form">
  <!-- Personal Information -->
  <fieldset>
    <legend>Personal Information</legend>
    
    <div class="form-group">
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
      <label for="fullname">First Name</label>
      <input type="text" id="fullname" name="fullname" required>
      <label for="lastname">Last Name</label>
      <input type="text" id="lastname" name="lastname" required>
    </div>
    <div class="form-group">
      <label for="birth">Date of Birth</label>
      <input type="date" id="birth" name="birth" required>
      <label for="sex">Sex</label>
      <select id="sex" name="sex" required>
        <option value="">Please select</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="undecided">Undecided</option>
      </select>
    </div>

    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" id="address" name="address" required>
      <label for="suburb">Suburb/Town</label>
      <input type="text" id="suburb" name="suburb">
      <label for="country">Country</label>
      <input type="text" id="country" name="country">
    </div>

    <div class="form-group">
      <label for="postcode">Postcode</label>
      <input type="text" id="postcode" name="postcode">
      <label for="phonenumber1">Phone Number</label>
      <input type="tel" id="phonenumber1" name="phonenumber1" pattern="\d{8,12}" required title="Enter 8-12 digits">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>
    </div>

  </fieldset>

  <!-- Education -->
  <fieldset>
    <legend>Education</legend>
    <div class="form-group">
      <label for="university">University/Institution</label>
      <input type="text" id="university" name="university" required>
      <label for="degree">Degree/Certification</label>
      <input type="text" id="degree" name="degree" required>
      <label for="year">Year Completed</label>
      <input type="date" id="year" name="year" required>
    </div>
  </fieldset>

  <!-- Skills -->
  <fieldset>
    <legend>Skills & Qualifications</legend>
    <div class="form-group">
      <label><input type="checkbox" name="skills[]" value="HTML"> HTML</label>
      <label><input type="checkbox" name="skills[]" value="CSS"> CSS</label>
      <label><input type="checkbox" name="skills[]" value="JavaScript"> JavaScript</label>
      <label><input type="checkbox" name="skills[]" value="PHP"> PHP</label>
      <label><input type="checkbox" name="skills[]" value="MySQL"> MySQL</label>
      <label><input type="checkbox" name="skills[]" value="Others"> Others</label>
    </div>
      <label for="description">List relevant skills, certifications or qualifications:</label>
    <div class="form-group"> 
      <textarea id="description" name="description" placeholder="Put down your relevant skills, certifications and qualifications here..." required></textarea>
    </div>
  </fieldset>

  <!-- Recent Employment -->
  <fieldset>
    <legend>Recent Employment History</legend>
    <div class="form-group">
      <label for="company1">Company Name</label>
      <input type="text" id="company1" name="company1" required>
      <label for="position1">Position Held</label>
      <input type="text" id="position1" name="position1" required>
      <label for="emdate1">Employment Dates</label>
      <input type="date" id="emdate1" name="emdate1" required>
    </div>

    <div class="form-group">
      <label for="company2">Company Name</label>
      <input type="text" id="company2" name="company2">
      <label for="position2">Position Held</label>
      <input type="text" id="position2" name="position2">
      <label for="emdate2">Employment Dates</label>
      <input type="date" id="emdate2" name="emdate2">
    </div>

    <div class="form-group">
      <label for="company3">Company Name</label>
      <input type="text" id="company3" name="company3">
      <label for="position3">Position Held</label>
      <input type="text" id="position3" name="position3">
      <label for="emdate3">Employment Dates</label>
      <input type="date" id="emdate3" name="emdate3">
    </div>
  </fieldset>

  <!-- References -->
  <fieldset>
    <legend>References</legend>
    <div class="form-group">
      <label for="reference">Reference Name</label>
      <input type="text" id="reference" name="reference" required>
      <label for="relationship">Relationship</label>
      <input type="text" id="relationship" name="relationship" required>
      <label for="phonenumber2">Phone Number</label>
      <input type="tel" id="phonenumber2" name="phonenumber2" required pattern="\d{8,12}" title="Enter 8-12 digits">
    </div>
  </fieldset>

  <!-- Certification & Buttons -->
  <div id="app_certified" class="center colum flex_center">
    <p id="submit_reset">
      <input type="checkbox" id="responsibility" name="responsibility" required>
      <label for="responsibility"><strong>I certify that the information provided in this application is accurate and complete. I understand that providing false information may result in disqualification from consideration for employment.</strong></label>
    </p>
    <p>
      <input class="btn" type="submit" value="Submit">
      <input class="btn" type="reset" value="Reset">
    </p>
  </div>
</form>

<?php include "footer.inc"; ?>
</body>
</html>
