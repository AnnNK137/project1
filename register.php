<?php
include_once('settings.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

    //get input
    $position = $_POST['position'] ?? '';
    $firstName  = $_POST['firstName'] ?? '';
    $lastName   = $_POST['lastName'] ?? '';
    $email   = $_POST['email'] ?? '';
    $password = password_hash($_POST['email'], PASSWORD_DEFAULT); //default password is email and is encrypted

    //query
    $query = "SELECT * FROM hr WHERE email='$email'"; //to check if duplicated
    $result = mysqli_query($conn, $query);

    //check if user already exist 
    if(mysqli_num_rows($result) == 0) {
        // Register user
        $register = "INSERT INTO hr (position, firstName, lastName, email, password) 
                     VALUES ('$position', '$firstName', '$lastName', '$email', '$password')";
        if(mysqli_query($conn, $register)) {
            header("Location: hr_admin.php");
            exit();
        } else {
            echo "❌ Signup failed: " . mysqli_error($conn);
        }
    } else {
        echo "❌ User with this email already exists!";
    }
}
?>