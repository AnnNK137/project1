<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//User = can see homepage tab, about tab, apply tab,...
//admin and staff cam only see managing tab site
//only admin see staff managing site
?>


<header id="header">
    <nav>
        <a href="index.php" class="brand_logo">
            <img src="images/logo.png" alt="3Ners">             
        </a>
        <ul class="nav_items">  
            <?php 
            if (isset($_SESSION['position']) && $_SESSION['position'] == 'user') {
                echo '<li><a href="index.php">Home</a></li>';
                echo '<li><a href="jobs.php">Job</a></li>';
                echo '<li><a href="apply.php">Applying</a></li>';
                echo '<li><a href="about.php">About</a></li>';
            }
            ?>
            <?php 
            if (isset($_SESSION['position']) && $_SESSION['position'] == 'admin'
                || isset($_SESSION['position']) && $_SESSION['position'] == 'staff') {
                echo '<li><a href="manage.php">Applicants</a></li>';
            }
            ?>
            <?php 
            if (isset($_SESSION['position']) && $_SESSION['position'] == 'admin') {
                echo '<li><a href="hr_admin.php">Staff Management</a></li>';
            }
            ?>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
</header>
