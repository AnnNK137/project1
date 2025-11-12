<?php
require_once "settings.php";

// Connect to the database
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $job       = mysqli_real_escape_string($conn, trim($_POST['job']));
    $fname     = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    $lname     = mysqli_real_escape_string($conn, trim($_POST['lastname'] ?? ''));
    $dob       = mysqli_real_escape_string($conn, trim($_POST['birth']));
    $gender    = mysqli_real_escape_string($conn, trim($_POST['sex']));
    $address   = mysqli_real_escape_string($conn, trim($_POST['address']));
    $suburb    = mysqli_real_escape_string($conn, trim($_POST['suburb'] ?? ''));
    $state     = mysqli_real_escape_string($conn, trim($_POST['state'] ?? ''));
    $postcode  = mysqli_real_escape_string($conn, trim($_POST['postcode'] ?? ''));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phonenumber1']));
    $skills    = $_POST['skills'] ?? [];
    $other     = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));

    // Basic validation
    $errors = [];

    if (empty($fname) || !preg_match("/^[\p{L}\s]{1,20}$/u", $fname)) $errors[] = "First name invalid";
    if (empty($lname) || !preg_match("/^[\p{L}\s]{1,20}$/u", $lname)) $errors[] = "Last name invalid";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalid";
    
    $phone_clean = preg_replace("/[^\d]/", "", $phone);
    if (!preg_match("/^\d{8,12}$/", $phone_clean)) $errors[] = "Phone invalid";

    if (empty($job)) $errors[] = "Job must be selected";
    if (empty($gender)) $errors[] = "Gender must be selected";
    if (empty($address)) $errors[] = "Address required";
    if (!isset($_POST['responsibility'])) $errors[] = "You must accept responsibility";

    if (count($errors) > 0) {
        echo "<h2>Form errors:</h2><ul>";
        foreach ($errors as $err) echo "<li>$err</li>";
        echo "</ul><a href='apply.php'>Go Back</a>";
        exit;
    }

    // Map skills
    $skill1 = $skills[0] ?? '';
    $skill2 = $skills[1] ?? '';
    $skill3 = $skills[2] ?? '';

    // Insert data into eoi table
    $insertSQL = "INSERT INTO eoi
        (JobReference, FirstName, LastName, DateOfBirth, Gender, StreetAddress, SuburbTown, State, Postcode, Email, Phone, Skill1, Skill2, Skill3, OtherSkills)
        VALUES
        ('$job', '$fname', '$lname', '$dob', '$gender', '$address', '$suburb', '$state', '$postcode', '$email', '$phone', '$skill1', '$skill2', '$skill3', '$other')";

    if (mysqli_query($conn, $insertSQL)) {
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
    <title>Job Application Form</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include "header.inc"; ?>
    <?php include "nav.inc"; ?>

    <!-- FORM -->
    <form action="apply.php" method="POST" novalidate>
        <fieldset>
            <legend>Personal Information</legend>
            <label>Full Name: <input type="text" name="fullname" required></label>
            <label>Last Name: <input type="text" name="lastname" required></label>
            <label>Date of Birth: <input type="date" name="birth" required></label>
            <label>Gender:
                <select name="sex" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </label>
            <label>Address: <input type="text" name="address" required></label>
            <label>Suburb/Town: <input type="text" name="suburb"></label>
            <label>State: <input type="text" name="state"></label>
            <label>Postcode: <input type="text" name="postcode"></label>
            <label>Email: <input type="email" name="email" required></label>
            <label>Phone: <input type="text" name="phonenumber1" required></label>
        </fieldset>

        <fieldset>
            <legend>Skills</legend>
            <label><input type="checkbox" name="skills[]" value="HTML"> HTML</label>
            <label><input type="checkbox" name="skills[]" value="CSS"> CSS</label>
            <label><input type="checkbox" name="skills[]" value="JS"> JavaScript</label>
            <label><input type="checkbox" name="skills[]" value="PHP"> PHP</label>
            <label>Other: <textarea name="description"></textarea></label>
        </fieldset>

        <fieldset>
            <legend>Job Application</legend>
            <label>Job: 
                <select name="job" required>
                    <option value="">Select</option>
                    <option value="software">Software Developer</option>
                    <option value="net">Network Administrator</option>
                    <option value="cloud">Cloud Engineer</option>
                </select>
            </label>
        </fieldset>

        <p>
            <input type="checkbox" name="responsibility" required> I certify the information is correct.
        </p>
        <p>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </p>
    </form>

    <?php include "footer.inc"; ?>
</body>
</html>
