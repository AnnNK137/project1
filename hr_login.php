<?php
session_start();
require_once "settings.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input and sanitize it
    $hr_id = mysqli_real_escape_string($conn, $_POST['hr_id']);
    $pass = mysqli_real_escape_string($conn, $_POST['hr_password']);

    // Query checking
    $query = "SELECT * FROM hr WHERE hr_ID='$hr_id' AND password='$pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the row
        $row = mysqli_fetch_assoc($result);

        //storing session
        $_SESSION['ID'] = $row['hr_ID'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['position'] = $row['position'];

        header("Location: manage.php");
        exit();
    } else {
        echo "Invalid ID or password.";
    }
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
    <div class="container">
        <form class="form" method="post" action="hr_login.php">
            <p class="form-title">Login in to Management Site</p>
                <div class="input-container">
                <input type="text" name="hr_id" placeholder="Enter your ID" required>
            </div>
            <div class="input-container">
                <input type="password" name="hr_password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="submit">
                Login
            </button>
        </form>
    </div>

</body>
</html>