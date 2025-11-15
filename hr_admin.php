<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: hr_login.php");
    exit();
}

//check if user is admin
if (!isset($_SESSION['position']) || $_SESSION['position'] != 'admin') {
    header("Location: manage.php");
    exit();
}
?>

<?php 
require_once "settings.php"; //connect to settings.php

// Handle form submission to update positiones
// Handle form submission to update positions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['position'])) {
    foreach ($_POST['position'] as $email => $position) {

        //Prevent admin from modifying their own account
        if ($email === $_SESSION['email']) {
            continue;
        }

        if ($position === 'Remove') {
            mysqli_query($conn, "DELETE FROM users WHERE email='$email'");
        } else {
            $position = mysqli_real_escape_string($conn, $position);
            mysqli_query($conn, "UPDATE users SET position='$position' WHERE email='$email'");
        }
    }
}


//filter function
// Get filter values
$position     = $_GET['position'] ?? '';
$firstName  = $_GET['first_name'] ?? '';
$lastName   = $_GET['last_name'] ?? '';
$email   = $_GET['email'] ?? '';


//query
$query = "SELECT * FROM users";
$conditions = [];

if ($position != '') { $conditions[] = "position = '$position'"; }
if ($firstName != '') { $conditions[] = "firstName LIKE '%$firstName%'"; }
if ($lastName != '') { $conditions[] = "lastName LIKE '%$lastName%'"; }
if ($email != '') { $conditions[] = "email LIKE '%$email%'"; }

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
    <title>HR MANAGEMENT</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header_hr.php"; ?>

    <!-- FILTER FORM -->
    <form action="hr_admin.php" method="GET" class="filter">
        <div class="filter-option">
            <h3>Filter Option:</h3>
            <div class="form-group">
                <label for="position">Staff Position</label>
                <select name="position" id="position">
                    <option value="">-- All Position --</option>
                    <option value="user" <?= $position=='user'?'selected':'' ?>>User</option>
                    <option value="staff" <?= $position=='staff'?'selected':'' ?>>Staff</option>
                    <option value="admin" <?= $position=='admin'?'selected':'' ?>>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter first name" >
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter last name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Enter email">
            </div>
            <button type="submit" class="btn" name="filter">Filter</button>
        </div>
    </form>

    <!-- EOI TABLE -->
    <form method="POST" action="hr_admin.php"> <!-- Form for save and cancelling -->
        <!-- Keeps the filtered on-->
        <input type="hidden" name="position" value="<?= ($position) ?>">
        <input type="hidden" name="first_name" value="<?= ($firstName) ?>">
        <input type="hidden" name="last_name" value="<?= ($lastName) ?>">
        <div class="eoi" id="hr_eoi">
            <table>
                <tr>
                    <th>Position</th>
                    <th class="sticky-col sticky-head">First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>

            <?php
            while($row = mysqli_fetch_assoc($result)) {

                $isSelf = ($row['email'] == $_SESSION['email']); // check if it's your own account

                echo "<tr>";

                echo "<td class='sticky-col'>";

                if ($isSelf) {
                    // Locked dropdown
                    echo "<select class='position-dropdown' disabled>";
                    echo "<option selected>{$row['position']}</option>";
                    echo "</select>";

                    // Hidden field so value stays the same when saving
                    echo "<input type='hidden' name='position[{$row['email']}]' value='{$row['position']}'>";
                } else {
                    // Normal dropdown for other users
                    echo "<select class='position-dropdown' name='position[{$row['email']}]'>
                            <option value='user' ".($row['position']=='user'?'selected':'').">user</option>
                            <option value='admin' ".($row['position']=='admin'?'selected':'').">admin</option>
                            <option value='staff' ".($row['position']=='staff'?'selected':'').">staff</option>
                            <option value='Remove'>Remove</option>
                        </select>";
                }

                echo "</td>";

                echo "<td class='sticky-col'>{$row['firstName']}</td>";
                echo "<td>{$row['lastName']}</td>";
                echo "<td>{$row['email']}</td>";

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
