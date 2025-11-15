<?php
session_start();
include_once('settings.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cancel button
    if (isset($_POST['cancel'])) {
        header("Location: hr_profile.php");
        exit();
    }

    // Update button
    if (isset($_POST['update'])) {
        $hr_id = $_SESSION['ID'];
        $current_pwd = $_POST['current_pwd'];
        $new_pwd = $_POST['new_pwd'];

        // Fetch current hash from DB
        $current_email = $_SESSION['email'];
        $query = "SELECT * FROM hr WHERE email='$current_email'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($current_pwd, $row['password'])) {
            // Hash new password
            $hashed_new_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

            // Update in DB
            $update = "UPDATE hr SET password='$hashed_new_pwd' WHERE email='$current_email'";
            if (mysqli_query($conn, $update)) {
                header("Location: hr_profile.php"); // redirect after 2 sec
                exit();
            } else {
                echo "❌ Failed to update password: " . mysqli_error($conn);
            }
        } else {
            echo "❌ Wrong current password. Please try again.";
        }
    }
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT PROFILE</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header_hr.php"; ?>
    <div class="container">
        <div class="profile">
            <div class="banner"></div>
                <form action="edit_pwd.php" method="post">
                    <div class="basic-info">
                            <h3 class="HR-name">Name: <?php echo ($_SESSION['firstName']) . " " . ($_SESSION['lastName']); ?></h3>
                            <p class="HR-position">Position: <?php echo ($_SESSION['position']); ?></p>
                            <p class="HR-email">Email: <?php echo ($_SESSION['email']); ?></p>
                            <p class="HR-password">Current Password:
                                <input type="password" name="current_pwd" placeholder="Insert Current Password">
                            </p>
                            <p class="HR-password">New Password:
                                <input type="password" name="new_pwd" placeholder="Insert New Password">
                            </p>                        
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn" name="update">Update Password</button>
                        <button type="submit" class="btn" name="cancel">Cancel</button>
                    </div>
                </form>
        </div>
    </div>


</body>
</html>