<?php
session_start();
require_once "settings.php";

$error = ""; // store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = mysqli_real_escape_string($conn, $_POST['firstName']);
    $last  = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $raw_pass = $_POST['password'];

    $hashed_pass = password_hash($raw_pass, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered.";
    } else {

        // Insert new user
        $query = "
            INSERT INTO users (firstName, lastName, email, password) 
            VALUES ('$first', '$last', '$email', '$hashed_pass')
        ";

        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <form class="form" method="post" action="signup.php">
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align:center; margin-bottom:10px;">
                    <?= $error ?>
                </p>
            <?php endif; ?>
            <p class="form-title">Sign Up</p>
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
                <button type="submit" class="submit">
                Sign Up
                </button>
            <p>Already have an account? <a class="redirect-link" href="login.php">Login</a></p>
        </form>
    </div>

</body>
</html>