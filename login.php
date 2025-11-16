<?php
session_start();
require_once "settings.php";

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // If user is disabled (6 failed attempts)
        if ($row['is_disabled'] == 1) {
            $error = "Account with email: " . $email . " will be temporally disable for privacy control. <br>
                        A mail will be sent to " . $email . " on how to reopen the account" ;
        }
        else {
            // Validate password
            if (password_verify($pass, $row['password'])) {
                // SUCCESS → reset attempts
                mysqli_query($conn, "UPDATE users SET login_attempts = 0 WHERE email='$email'");

                $_SESSION['ID'] = $row['id'];
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['position'] = $row['position'];

                header("Location: manage.php");
                exit();
            }
            else {
                // FAILED → increment attempts
                $newAttempts = $row['login_attempts'] + 1;

                // If attempts reach 6 → disable account
                if ($newAttempts >= 6) {
                    mysqli_query($conn, "UPDATE users SET login_attempts = $newAttempts, is_disabled = 1 
                                         WHERE email='$email'");
                    $error = "Too many invalid attempts. Your account has been disabled.";
                }
                else {
                    mysqli_query($conn, 
                        "UPDATE users SET login_attempts = $newAttempts WHERE email='$email'");

                    // If attempts reach 4 → show warning
                    if ($newAttempts >= 4) {
                        $error = "Warning: Multiple invalid attempts ($newAttempts) might lead to disabling account.";
                    } else {
                        $error = "Invalid email or password.";
                    }
                }
            }
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