<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR ENHANCEMENTS</title>

    <!-- STYLE SHEET LINKS -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/enhancements.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header_hr.php"; ?>

    <!-- hero section/ introduction to company -->
    <div class="hp_hero_section center flex_center colum evenly_spacing" id="hs_enhance">
        <section> <!-- Herosection title -->
            <img id="hp_hs_logo" src="images/logo.png" alt="3ners">
            <h2 id="hp_title" class="ap_title">Enhancement</h2>
        </section>  <!-- End of Herosection Desc -->
    </div> <!--  END OF HERO SECTION -->
    
    <!-- EXPLAINATION -->
    <div class="container">
        <section class="container-group" id="filter-explain">
            <h2 class="title">1. Filtering EOIs function</h2>
            <div class="description">
                <p>The Filtering Function lets Managers and Staff quickly find EOIs that match specific criteria, displaying only the relevant entries in a clear table.</p>
                <p>Available filters include: Job Reference, First Name, and Last Name.</p>
                <p>Filters can be applied individually or combined for more precise results.</p>
                <p>Access this feature in the <a href="manage.php">Applicant EOIs Table</a> or on the <a href="hr_admin.php">Staff Management Site</a>.</p>
            </div>
        </section>

        <section class="container-group" id="registration-explain">
            <h2 class="title">2. Manager registration</h2>
            <div class="description">
                <p>Manager Registration allows Managers to add new accounts or assign Staff to manage the website and the EOIs Application Table.</p>
                <p>There are two ways to register new Staff:</p>
                <p><strong>Assigning roles to existing users:</strong> If a Staff member has already registered on the website using their email, the Manager does not need to create a new account. By visiting the <a href="hr_admin.php">Staff Management Site</a>, the Manager can update the user’s role to 'Staff' or 'Admin'.</p>
                <p><strong>Manually adding a new Staff account:</strong> If the Staff member has not registered yet, the Manager can use the registration form on the <a href="register.php">Staff Register Site</a> to enter their details, such as Username, Email, and Password. Accounts created this way are automatically assigned the 'Staff' or 'Admin' role without any additional role changes.</p>
            </div>
        </section>

        <section class="container-group" id="login-explain">
            <h2 class="title">3. Login to Managing Site</h2>
            <div class="description">
                <p>All users, including Guest Visitors, can log in to access the benefits of a registered account. However, only users with 'Staff' or 'Admin' roles can access management features, such as the <a href="manage.php">Applicant EOIs Table</a>.</p>
                <p>Accounts with the 'Admin' role have additional access to the <a href="hr_admin.php">Manager Registration Site</a>, where they can add or remove Staff members.</p>
            </div>
        </section>        

        <section class="container-group" id="disable-explain">
            <h2 class="title">4. Disable Login after Invalid Attempts</h2>
        <div class="description">
            <p>If a user attempts to log in and fails more than four times, the system will detect the repeated invalid attempts and issue a warning. After the sixth failed attempt, the system will temporarily lock the user’s account for a set duration.</p>
            <p>The Manager can configure both the number of allowed failed attempts and the lockout duration in the <a href="hr_admin.php">Staff Management Site</a>.</p>
        </div>
        </section>        
    </div>

  <!-- FOOTER (same on all pages) -->
    <?php include "footer.inc" ?>

</body>
</html>