<?php
require_once "settings.php";

function insert_eoi($conn, $data) {
    // Escape all input to prevent SQL injection
    $job          = mysqli_real_escape_string($conn, $data['job']);
    $fullname     = mysqli_real_escape_string($conn, $data['fullname']);
    $lastname     = mysqli_real_escape_string($conn, $data['lastname']);
    $birth        = mysqli_real_escape_string($conn, $data['birth']);
    $gender       = mysqli_real_escape_string($conn, $data['gender']);
    $address      = mysqli_real_escape_string($conn, $data['address']);
    $suburb       = mysqli_real_escape_string($conn, $data['suburb']);
    $state        = mysqli_real_escape_string($conn, $data['state']);
    $postcode     = mysqli_real_escape_string($conn, $data['postcode']);
    $phonenumber1 = mysqli_real_escape_string($conn, $data['phonenumber1']);
    $email        = mysqli_real_escape_string($conn, $data['email']);

    $university   = mysqli_real_escape_string($conn, $data['university']);
    $degree       = mysqli_real_escape_string($conn, $data['degree']);
    $year         = mysqli_real_escape_string($conn, $data['year']);
    $skills       = mysqli_real_escape_string($conn, $data['skills_list']);
    $description  = mysqli_real_escape_string($conn, $data['description']);

    $company1     = mysqli_real_escape_string($conn, $data['company1']);
    $position1    = mysqli_real_escape_string($conn, $data['position1']);
    $emdate1      = mysqli_real_escape_string($conn, $data['emdate1']);

    $reference    = mysqli_real_escape_string($conn, $data['reference']);
    $relationship = mysqli_real_escape_string($conn, $data['relationship']);
    $phonenumber2 = mysqli_real_escape_string($conn, $data['phonenumber2']);
    $responsibility = mysqli_real_escape_string($conn, $data['responsibility']);

    // Build query
    $query = "
        INSERT INTO eoi (
            job, fullname, lastname, birth, gender, address, suburb, state, postcode, phonenumber1, email,
            university, degree, year, skills, description,
            company1, position1, emdate1,
            reference, relationship, phonenumber2, responsibility
        )
        VALUES (
            '$job', '$fullname', '$lastname', '$birth', '$gender', '$address', '$suburb', '$state', '$postcode', '$phonenumber1', '$email',
            '$university', '$degree', '$year', '$skills', '$description',
            '$company1', '$position1', '$emdate1',
            '$reference', '$relationship', '$phonenumber2', '$responsibility'
        )
    ";

    // Execute query and throw exception if failed
    if (!mysqli_query($conn, $query)) {
        throw new Exception("Insert failed: " . mysqli_error($conn) . "\nSQL Query: " . $query);
    }

    return true;
}
?>
