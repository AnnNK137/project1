<?php
require_once "settings.php";

// --- Connect to database ---
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

session_start();

// --- Configuration Variables (Matching your CSS/Theme) ---
$black = '#030303';
$blue_highlight = '#3c4da4';
$light_beige = '#f1efec';
$font_base = "'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif";
$error_color = '#d9534f'; 

// --- 1. Form Submission Check ---
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Redirect if the page is accessed directly without POST data
    header("Location: apply.html"); 
    exit;
}

// --- 2. Data Cleaning/Sanitization Function ---
// Cleans input data for display purposes (prevents XSS)
function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// --- 3. Basic Validation Check ---
$errors = [];
$required_fields = ['job', 'fullname', 'lastname', 'birth', 'gender', 'address', 'suburb', 'state', 'postcode', 'phonenumber1', 'email', 'university', 'degree', 'year', 'company1', 'position1', 'emdate1', 'reference', 'relationship', 'phonenumber2', 'responsibility'];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        // Since 'responsibility' is a required checkbox, it will be missing if unchecked.
        if ($field === 'responsibility') {
            $errors[] = "You must certify that the information is accurate.";
        } else {
            // For simplicity, we just check if the field is present/non-empty.
            $errors[] = ucfirst(str_replace(['1', '2', '3'], '', $field)) . " is required.";
        }
    }
}

// If there are validation errors, you would typically redirect back to the form
// with an error message. For this example, we'll just display the errors.
if (!empty($errors)) {
    // In a real application, you'd save $errors to a session and redirect.
    // For now, we'll stop execution and display errors.
    display_error_page($errors, $black, $light_beige, $font_base, $error_color);
    exit;
}


// --- 4. Data Collection (Only executed if validation passes) ---
$eoi_data = [];

// Personal Info
$eoi_data['job'] = clean_input($_POST['job']);
$eoi_data['fullname'] = clean_input($_POST['fullname']);
$eoi_data['lastname'] = clean_input($_POST['lastname']);
$eoi_data['birth'] = clean_input($_POST['birth']);
$eoi_data['gender'] = clean_input($_POST['gender']);
$eoi_data['address'] = clean_input($_POST['address']);
$eoi_data['suburb'] = clean_input($_POST['suburb']);
$eoi_data['state'] = clean_input($_POST['state']);
$eoi_data['postcode'] = clean_input($_POST['postcode']);
$eoi_data['phonenumber1'] = clean_input($_POST['phonenumber1']);
$eoi_data['email'] = clean_input($_POST['email']);

// Education
$eoi_data['university'] = clean_input($_POST['university']);
$eoi_data['degree'] = clean_input($_POST['degree']);
$eoi_data['year'] = clean_input($_POST['year']);

// Skills (Checkbox Array & Description)
if (isset($_POST['skills']) && is_array($_POST['skills'])) {
    $eoi_data['skills_selected'] = clean_input($_POST['skills']);
    $eoi_data['skills_list'] = implode(", ", $eoi_data['skills_selected']);
} else {
    $eoi_data['skills_list'] = "None Selected";
}
$eoi_data['description'] = clean_input($_POST['description'] ?? '');

// Employment History (1 required, plus optional 2 and 3 if included in HTML)
for ($i = 1; $i <= 3; $i++) {
    $eoi_data["company{$i}"] = clean_input($_POST["company{$i}"] ?? 'N/A');
    $eoi_data["position{$i}"] = clean_input($_POST["position{$i}"] ?? 'N/A');
    $eoi_data["emdate{$i}"] = clean_input($_POST["emdate{$i}"] ?? 'N/A');
}

// References
$eoi_data['reference'] = clean_input($_POST['reference']);
$eoi_data['relationship'] = clean_input($_POST['relationship']);
$eoi_data['phonenumber2'] = clean_input($_POST['phonenumber2']);

// Certification
$eoi_data['responsibility'] = "Certified (Information is accurate)"; 

// --- 5. Data Processing (Simulate Database Save) ---
// In a real application, this is where you would connect to the database 
// and execute the INSERT query using the $eoi_data array.

// Placeholder for database logic:
// save_eoi_data_to_db($eoi_data); 
// --- 5.1 Insert data into database ---
// --- 6. Display Confirmation Page ---
display_confirmation_page($eoi_data, $black, $blue_highlight, $light_beige, $font_base);

// --- Functions to Display Pages ---

function display_error_page($errors, $black, $light_beige, $font_base, $error_color) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Submission Error</title>
        <style>
            body { background-color: <?php echo $black; ?>; color: <?php echo $light_beige; ?>; font-family: <?php echo $font_base; ?>; text-align: center; padding: 50px; }
            .error-box { max-width: 600px; margin: 0 auto; padding: 20px; border: 2px solid <?php echo $error_color; ?>; border-radius: 10px; background-color: rgba(50, 0, 0, 0.7); }
            h1 { color: <?php echo $error_color; ?>; }
            ul { list-style: none; padding: 0; text-align: left; }
            li { margin-bottom: 10px; color: <?php echo $light_beige; ?>; }
            a { color: <?php echo $blue_highlight; ?>; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1> Submission Failed</h1>
            <p>The following errors occurred during validation:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li>- <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Please <a href="apply.html">go back</a> and correct the required fields.</p>
        </div>
    </body>
    </html>
    <?php
}

function display_confirmation_page($eoi_data, $black, $blue_highlight, $light_beige, $font_base) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Application Confirmation</title>
        <link rel="stylesheet" href="styles/apply.css"> <style>
            /* Custom CSS for the confirmation page layout */
            body {
                background-color: <?php echo $black; ?>;
                color: <?php echo $light_beige; ?>;
                font-family: <?php echo $font_base; ?>;
                line-height: 1.6;
            }
            .container {
                width: 90%;
                max-width: 1300px; 
                margin: 50px auto;
                padding: 30px;
                background-color: rgba(0,0,0,0.85);
                border-radius: 15px;
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            }
            h1 {
                color: <?php echo $blue_highlight; ?>;
                text-align: center;
                margin-bottom: 20px;
                font-size: 2.5rem;
            }
            h2 {
                border-bottom: 2px solid <?php echo $blue_highlight; ?>;
                padding-bottom: 10px;
                margin-top: 30px;
                margin-bottom: 15px;
                color: <?php echo $light_beige; ?>;
                font-size: 1.8rem;
            }
            h3 {
                 margin-top: 20px;
                 color: #ccc;
                 font-size: 1.2rem;
                 padding-left: 15px;
            }
            .data-group {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 20px;
            }
            .data-item {
                flex: 1 1 300px; 
                background-color: #1a1a1a;
                padding: 15px;
                border-left: 5px solid <?php echo $blue_highlight; ?>;
                border-radius: 5px;
            }
            .data-item strong {
                display: block;
                color: <?php echo $blue_highlight; ?>;
                margin-bottom: 5px;
                font-size: 1.1rem;
            }
            .data-item p {
                margin: 0;
                word-wrap: break-word; 
            }
            .data-full {
                flex-basis: 100%;
            }
        </style>
    </head>
    <body>

    <?php 
    // Include navigation bar (assuming nav.inc exists)
    // include "nav.inc"; 
    ?>

    <div class="container">
        <h1> JOB APPLICATION CONFIRMATION</h1>
        <p style="text-align: center; font-size: 1.2rem; margin-bottom: 30px;">
            Thank you, **<?php echo $eoi_data['fullname'] . ' ' . $eoi_data['lastname']; ?>**, your application for job **<?php echo $eoi_data['job']; ?>** has been received. 
            We will contact you via email at **<?php echo $eoi_data['email']; ?>** shortly.
        </p>

        <h2>1. Personal Information</h2>
        <div class="data-group">
            <div class="data-item"><strong>Job Reference:</strong> <p><?php echo $eoi_data['job']; ?></p></div>
            <div class="data-item"><strong>Full Name:</strong> <p><?php echo $eoi_data['fullname'] . ' ' . $eoi_data['lastname']; ?></p></div>
            <div class="data-item"><strong>Date of Birth:</strong> <p><?php echo $eoi_data['birth']; ?></p></div>
            <div class="data-item"><strong>Gender:</strong> <p><?php echo ucfirst($eoi_data['gender']); ?></p></div>
            <div class="data-item data-full"><strong>Address:</strong> <p><?php echo $eoi_data['address'] . ', ' . $eoi_data['suburb'] . ', ' . $eoi_data['state'] . ', ' . $eoi_data['postcode']; ?></p></div>
            <div class="data-item"><strong>Phone Number:</strong> <p><?php echo $eoi_data['phonenumber1']; ?></p></div>
            <div class="data-item"><strong>Email Address:</strong> <p><?php echo $eoi_data['email']; ?></p></div>
        </div>

        <h2>2. Education</h2>
        <div class="data-group">
            <div class="data-item"><strong>University/Institution:</strong> <p><?php echo $eoi_data['university']; ?></p></div>
            <div class="data-item"><strong>Degree/Certification:</strong> <p><?php echo $eoi_data['degree']; ?></p></div>
            <div class="data-item"><strong>Year Completed:</strong> <p><?php echo $eoi_data['year']; ?></p></div>
        </div>

        <h2>3. Skills & Qualifications</h2>
        <div class="data-group">
            <div class="data-item data-full"><strong>Selected Skills:</strong> <p><?php echo $eoi_data['skills_list']; ?></p></div>
            <div class="data-item data-full"><strong>Other Relevant Skills:</strong> <p><?php echo empty($eoi_data['description']) ? 'No additional description provided.' : nl2br($eoi_data['description']); ?></p></div>
        </div>

        <h2>4. Recent Employment History</h2>
        <?php 
        $employment_found = false;
        for ($i = 1; $i <= 3; $i++): 
            // Only display records if the company name was filled in (using the required company1 as the check)
            if ($i == 1 || (!empty($_POST["company{$i}"]) && $_POST["company{$i}"] !== 'N/A')): 
                $employment_found = true;
                ?>
                <h3>Employment Record #<?php echo $i; ?></h3>
                <div class="data-group">
                    <div class="data-item"><strong>Company Name:</strong> <p><?php echo $eoi_data["company{$i}"]; ?></p></div>
                    <div class="data-item"><strong>Position Held:</strong> <p><?php echo $eoi_data["position{$i}"]; ?></p></div>
                    <div class="data-item"><strong>Employment Dates:</strong> <p><?php echo $eoi_data["emdate{$i}"]; ?></p></div>
                </div>
            <?php endif; 
        endfor; 
        if (!$employment_found): ?>
            <p style="padding-left: 15px;">No recent employment history provided (or required fields missing).</p>
        <?php endif; ?>

        <h2>5. References</h2>
        <div class="data-group">
            <div class="data-item"><strong>Reference Name:</strong> <p><?php echo $eoi_data['reference']; ?></p></div>
            <div class="data-item"><strong>Relationship:</strong> <p><?php echo $eoi_data['relationship']; ?></p></div>
            <div class="data-item"><strong>Phone Number:</strong> <p><?php echo $eoi_data['phonenumber2']; ?></p></div>
        </div>
        
        <h2>6. Certification</h2>
        <div class="data-group">
            <div class="data-item data-full" style="border-left-color: #00cc66;">
                <p style="color: #00cc66; font-weight: bold;"><?php echo $eoi_data['responsibility']; ?></p>
            </div>
        </div>

    </div>

    <?php 
    // Include footer (assuming footer.inc exists)
    // include "footer.inc"; 
    ?>

    </body>
    </html>
    <?php
}
?>