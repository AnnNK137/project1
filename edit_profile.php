<?php
session_start();
include_once('settings.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Not logged in, redirect to login page
    header("Location: hr_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //canceling
    if(isset($_POST['cancel'])){
        header("Location: hr_profile.php");
        exit();
    };

    // Update button
    if (isset($_POST['update'])) {
        //get input
        $new_email = mysqli_real_escape_string($conn, $_POST['new_email']); //sanitized

        //query
        $current_email = $_SESSION['email'];
        $query = "SELECT * FROM hr WHERE email='$current_email'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        //update email
        $update = "UPDATE hr SET email='$new_email' WHERE email='$current_email'";
        mysqli_query($conn, $update);
        $_SESSION['email'] = $new_email; // update session as well

        //returm to profile
        header("Location: hr_profile.php");
        exit();
    };
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
                <form action="edit_profile.php" method="post">
                    <div class="basic-info">
                            <h3 class="HR-name">Name: 
                                <?php echo ($_SESSION['firstName']) . " " . ($_SESSION['lastName']); ?>
                            </h3>
                            
                            <p class="HR-position">Position: 
                                <?php echo ($_SESSION['position']); ?></p>

                            <p class="HR-email">Email: 
                                    <input type="email" name="new_email" placeholder="Insert new email" 
                                    value="<?php echo ($_SESSION['email']); ?>">
                                </p>
                                <p class="HR-password">Password: Hidden</p>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn" name="update">Update Profile</button>
                        <button type="submit" class="btn" name="cancel">Cancel</button>
                    </div>
                </form>
        </div>
    </div>


</body>
</html>