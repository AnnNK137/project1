<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
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
                <h3 class="HR-name"><?php echo ($_SESSION['firstName']); ?></h3>
                <p class="HR-position">Position: <?php echo ($_SESSION['position']); ?></p>
            </div>
        </div>
        <form action="logout.php">
            <button type="submit" class="btn">Logout</button>
        </form>
    </div>


</body>
</html>