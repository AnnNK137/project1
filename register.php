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
include_once('settings.php');

$error = ""; // store error flash message

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

    //get input
    $position = 'staff';
    $firstName  = $_POST['firstName'] ?? '';
    $lastName   = $_POST['lastName'] ?? '';
    $email   = $_POST['email'] ?? '';
    $password = password_hash($_POST['email'], PASSWORD_DEFAULT); //default password is email and is encrypted

    //query
    $query = "SELECT * FROM users WHERE email='$email'"; //to check if duplicated
    $result = mysqli_query($conn, $query);

    //check if user already exist 
    if(mysqli_num_rows($result) == 0) {
        // Register user
        $register = "INSERT INTO users (position, firstName, lastName, email, password) 
                     VALUES ('$position', '$firstName', '$lastName', '$email', '$password')";
        if(mysqli_query($conn, $register)) {
            header("Location: hr_admin.php");
            exit();
        } else {
            $error = "❌ Signup failed: " . mysqli_error($conn);
        }
    } else {
        $error = "❌ User with this email already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header_hr.php"; ?>
    <div class="container">
        <form class="form" method="post" action="register.php">
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align:center; margin-bottom:10px;">
                    <?= $error ?>
                </p>
            <?php endif; ?>
            <p class="form-title">Sign Up for Staff</p>
                <div class="input-container" id="name-input">
                    <input type="text" name="firstName" placeholder="First name" required>
                    <input type="text" name="lastName" placeholder="Last name" required>
                </div>
                <div class="input-container">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="submit" name="register">
                Register New Staff
                </button>
        </form>
    </div>

</body>
</html>