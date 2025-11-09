<?php 
require_once "settings.php"; //connect to settings.php
$conn = @mysqli_connect($host,$user,$pwd,$sql_db); //connect to 3ners_db
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR MANAGEMENT</title>

        <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css"> <!-- Main css -->
    <link rel="stylesheet" href="styles/manage.css"> <!-- Manage.php css -->
</head>
<body>
    <header>
        <a href="index.php" class="brand_logo">
            <img src="images/logo.png" alt="3Ners">              
        </a>
        <h2>3Ners HR Management</h2>
    </header>
    
    <!-- START OF FILTER FORM -->
    <form action="manage.php" method="GET" class="filter">
        <!-- START OF FILTER OPTION -->
        <div class="filter-option">
            <h3>Filter Option:</h2>
            <div class="form-group">
                <label for="job_ref">Job Reference</label>
                <select name="job_ref" id="job_ref">
                    <option value="">-- All Jobs --</option>
                    <option value="G01">G01 - Software Developer</option>
                    <option value="G02">G02 - Network Administrator</option>
                    <option value="G03">G03 - Data Analyst</option>
                    <option value="G04">G04 - Cyber Security Specialist</option>
                    <option value="G05">G05 - IT Support Technician</option>
                    <option value="G06">G06 - Cloud Engineering</option>
                    <option value="G07">G07 - AI/ML Engineering</option>
                    <option value="G08">G08 - Data Scientist</option>
                    <option value="G09">G09 - Data Engineer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter first name">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter last name">
            </div>

            <button type="submit" class="btn">Filter</button>
        </div>
        <!-- END OF FILTER OPTION -->



    </form>
    <!-- END OF FILTER FORM -->

    <!-- SHOW EOI TABLE AFTER FILTER FUNCTION-->
    <div class="eoi">
        <table>
            <!-- HEADING -->
                <tr>
                    <th class="sticky-col sticky-head first-col">Status</th>
                    <th class="sticky-col sticky-head second-col">ID</th>
                    <th class="sticky-col sticky-head third-col">First Name</th>
                    <th>Last name</th>
                    <th>Job</th>
                    <th>Date Of Birth</th>
                    <th>Gender</th>
                    <th>Street Address</th>
                    <th>Suburb Town</th>
                    <th>State</th>
                    <th>Post Code</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Skill 1</th>
                    <th>SKill 2</th>
                    <th>SKill 3</th>
                    <th>Other Skills</th>
                </tr>

            <!-- FIlter Process -->
        <?php
        // Get filter values from filter form
        $jobRef     = $_GET['job_ref'] ?? '';
        $firstName  = $_GET['first_name'] ?? '';
        $lastName   = $_GET['last_name'] ?? '';

        // Start base query
        $query = "SELECT * FROM eoi";
        $conditions = []; //default = show all


        // Add conditions depending on input
        if ($jobRef != '') {
            $conditions[] = "JobReferenceNumber = '$jobRef'";
        };
        if ($firstName != '') {
            $conditions[] = "FirstName LIKE '%$firstName%'";
        };
        if ($lastName != '') {
            $conditions[] = "LastName LIKE '%$lastName%'";
        };

        //Query wit option
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        };

        $result = mysqli_query($conn, $query);

        // Display table
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td class='sticky-col first-col'>{$row['Status']}</td>
                <td class='sticky-col second-col'>{$row['EOInumber']}</td>
                <td class='sticky-col third-col'>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['JobReferenceNumber']}</td>
                <td>{$row['DateOfBirth']}</td>
                <td>{$row['Gender']}</td>
                <td>{$row['StreetAddress']}</td>
                <td>{$row['SuburbTown']}</td>
                <td>{$row['State']}</td>
                <td>{$row['Postcode']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['Phone']}</td>
                <td>{$row['Skill1']}</td>
                <td>{$row['Skill2']}</td>
                <td>{$row['Skill3']}</td>
                <td>{$row['OtherSkills']}</td>
            </tr>";
        }
        ?>
        </table>
    </div>

    <!-- • Delete all EOIs with a specified job reference number -->
     
    <!-- • Change the Status of an EOI. -->
    <div class="footer">
        <form action="edit.php">
            <button type="submit" class="btn">Edit Status</button>
        </form>
    </div>
</body>
</html>