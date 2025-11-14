<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Not logged in, redirect to login page
    header("Location: hr_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR LOGIN</title>

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
            <div class="banner">
            </div>
            <div class="basic-info">
                <h3 class="HR-name">Name: <?php echo ($_SESSION['firstName']) . " " . ($_SESSION['lastName']); ?></h3>
                <p class="HR-position">Position: <?php echo ($_SESSION['position']); ?></p>
                <p class="HR-email">Email: <?php echo ($_SESSION['email']); ?></p>
                <p class="HR-password">Password: Hidden</p>
            </div>
        </div>
        <div class="btn-group">
            <form action="edit_profile.php">
                <button type="submit" class="btn">Edit email</button>
            </form>
            <form action="edit_pwd.php">
                <button type="submit" class="btn">Edit password</button>
            </form>
            <form action="logout.php">
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    </div>


</body>
</html>