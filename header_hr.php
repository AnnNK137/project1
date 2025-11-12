<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<header id="header">
    <nav>
        <a href="index.php" class="brand_logo">
            <img src="images/logo.png" alt="3Ners">    
            HR Management          
        </a>
        <ul class="nav_items">
            <li><a href="manage.php">Applicants</a></li>
            <?php 
            if (isset($_SESSION['position']) && $_SESSION['position'] == 'admin') {
                echo '<li><a href="hr_admin.php">Staff Control</a></li>';
            }
            ?>
            <li><a href="hr_profile.php">Profile</a></li>
        </ul>
    </nav>
</header>
