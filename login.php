<?php
session_start();
require_once "settings.php";

$error = ""; // store error flash message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input and sanitize
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password']; //leave raw for password_verify

    // Query user by email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($pass, $row['password'])) {
            // Password matches, store session
            $_SESSION['ID'] = $row['id'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['position'] = $row['position'];

            header("Location: manage.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/manage.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <form class="form" method="post" action="login.php">
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align:center; margin-bottom:10px;">
                    <?= $error ?>
                </p>
            <?php endif; ?>
            <p class="form-title">Login in</p>
                <div class="input-container">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="submit">
                Login
            </button>
            <p>Don't have an account yet? <a class="redirect-link" href="signup.php">Sign Up</a></p>
        </form>
    </div>

</body>
</html>