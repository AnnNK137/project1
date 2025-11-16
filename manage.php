<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

//only allow admin and staff
if (!isset($_SESSION['position']) || 
    ($_SESSION['position'] != 'admin' && $_SESSION['position'] != 'staff')) {
    header("Location: index.php");
    exit();
}
?>

<?php 
require_once "settings.php"; //connect to settings.php

// Handle form submission to update statuses
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    foreach ($_POST['status'] as $eoi => $status) {
        $eoi = (int)$eoi; // sanitize

        if ($status === 'Remove') { //Delete applicant function
            // Delete the record from the database
            mysqli_query($conn, "DELETE FROM eoi WHERE id=$eoi");
        } else {
            // Escape status for safe SQL query
            $status = mysqli_real_escape_string($conn, $status);
            // Update the status in the database
            mysqli_query($conn, "UPDATE eoi SET status='$status' WHERE id=$eoi");
        }
    }
}

//filter function
// Get filter values
$jobRef     = $_GET['job_ref'] ?? '';
$firstName  = $_GET['first_name'] ?? '';
$lastName   = $_GET['last_name'] ?? '';

//query
$query = "SELECT * FROM eoi";
$conditions = [];

if ($jobRef != '') { $conditions[] = "job = '$jobRef'"; }
if ($firstName != '') { $conditions[] = "fullname LIKE '%$firstName%'"; }
if ($lastName != '') { $conditions[] = "lastname LIKE '%$lastName%'"; }

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPLICANT MANAGEMENT</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header_hr.php"; ?>

    <!-- FILTER FORM -->
    <form action="manage.php" method="GET" class="filter">
        <div class="filter-option">
            <h3>Filter Option:</h3>
            <div class="form-group">
                <label for="job_ref">Job Reference</label>
                <select name="job_ref" id="job_ref">
                    <option value="">-- All Jobs --</option>
                    <option value="G01" <?= $jobRef=='G01'?'selected':'' ?>>G01 - Software Developer</option>
                    <option value="G02" <?= $jobRef=='G02'?'selected':'' ?>>G02 - Network Administrator</option>
                    <option value="G03" <?= $jobRef=='G03'?'selected':'' ?>>G03 - Data Analyst</option>
                    <option value="G04" <?= $jobRef=='G04'?'selected':'' ?>>G04 - Cyber Security Specialist</option>
                    <option value="G05" <?= $jobRef=='G05'?'selected':'' ?>>G05 - IT Support Technician</option>
                    <option value="G06" <?= $jobRef=='G06'?'selected':'' ?>>G06 - Cloud Engineering</option>
                    <option value="G07" <?= $jobRef=='G07'?'selected':'' ?>>G07 - AI/ML Engineering</option>
                    <option value="G08" <?= $jobRef=='G08'?'selected':'' ?>>G08 - Data Scientist</option>
                    <option value="G09" <?= $jobRef=='G09'?'selected':'' ?>>G09 - Data Engineer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter first name" value="<?= ($firstName) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter last name" value="<?= ($lastName) ?>">
            </div>
            <button type="submit" class="btn">Filter</button>
        </div>
    </form>

    <!-- EOI TABLE -->
    <form method="POST" action="manage.php"> <!-- Form for save and cancelling -->
        <!-- Keeps the filtered on-->
        <input type="hidden" name="job_ref" value="<?= ($jobRef) ?>">
        <input type="hidden" name="first_name" value="<?= ($firstName) ?>">
        <input type="hidden" name="last_name" value="<?= ($lastName) ?>">

        <div class="eoi">
            <table>
                <tr>
                    <th class="sticky-col sticky-head">status</th>
                    <th class="sticky-col sticky-head">ID</th>
                    <th class="sticky-col sticky-head">First Name</th>
                    <th>Last Name</th>
                    <th>Job</th>
                    <th>Date Of Birth</th>
                    <th>gender</th>
                    <th>Street Address</th>
                    <th>Suburb Town</th>
                    <th>state</th>
                    <th>Post Code</th>
                    <th>email</th>
                    <th>Phone number</th>
                    <th>University</th>
                    <th>Degree/Certificate</th>
                    <th>Skills</th>
                    <th>Other Skills</th>
                    <th>Applicants time of create</th>
                </tr>

                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // status dropdown
                    echo "<td class='sticky-col'>
                            <select class='status-dropdown' name='status[{$row['id']}]'>
                                <option value='New' ".($row['status']=='New'?'selected':'').">New</option>
                                <option value='Current' ".($row['status']=='Current'?'selected':'').">Current</option>
                                <option value='Final' ".($row['status']=='Final'?'selected':'').">Final</option>
                                <option value='Remove' ".($row['status']=='Remove'?'selected':'').">Remove</option>
                            </select>
                        </td>";
                    echo "<td class='sticky-col'>{$row['id']}</td>";
                    echo "<td class='sticky-col'>{$row['fullname']}</td>";
                    echo "<td>{$row['lastname']}</td>";
                    echo "<td>{$row['job']}</td>";
                    echo "<td>{$row['birth']}</td>";
                    echo "<td>{$row['gender']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['suburb']}</td>";
                    echo "<td>{$row['state']}</td>";
                    echo "<td>{$row['postcode']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phonenumber1']}</td>";
                    echo "<td>{$row['university']}</td>";
                    echo "<td>{$row['degree']}</td>";
                    echo "<td>{$row['skills']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['created_at']}</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <!-- SAVE / CANCEL buttons -->
        <div class="footer">
            <button type="submit" class="btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
            <button type="reset" class="btn"><i class="fa-solid fa-xmark"></i> Cancel</button>
        </div>
    </form>
</body>
</html>
