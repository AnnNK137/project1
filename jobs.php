<!DOCTYPE html>
<html lang="en">
<head>
<!-- LINK TO LIVE GITHUB PAGE: https://annnk137.github.io/project1/ -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Jobs Position Description</title>

     <link rel="stylesheet" href="styles/styles.css">
    <!-- <link rel="stylesheet" href="/styles/jobspage.css"> -->
</head>
<body>
    <!-- navigation bar (same on all pages) -->
    <?php include "nav.inc" ?>

     <!-- MAIN CONTENTS -->
    <div class="job_intro center colum flex_center">
        <img id="hp_hs_logo" src="images/logo.png" alt="3ners">
        <p class="job_intro_text">Code the future with us</p> <br>
        <p class="">
            <a href="#jobs_title" class="job_sub_menu">Job positions</a> <br><br>
            <a href="#jobs_evp" class="job_sub_menu">Employee value proposition (EVP)</a>
        </p>
    </div>
    <main>
        <!-- JOBS -->
        <section id="job_main_1">
            <p class="main_title">JOB POSITIONS</p>
            <hr class="main_line">
            <?php
            require_once "settings.php";   

            if (!$conn) {
                die("<p>Database connection failed</p>");
            }

            $query = "SELECT * FROM jobs ORDER BY jobRef ASC";
            $result = mysqli_query($conn, $query);

            while ($job = mysqli_fetch_assoc($result)) :
            ?>
                <div class="job_list">
                    <h2><?= htmlspecialchars($job["jobRef"]) ?> - <?= htmlspecialchars($job["title"]) ?></h2>
                    <aside class="job_hiring_btn">
                        <a href="apply.php?jobRef=<?= urlencode($job["jobRef"]) ?>">Hiring for this role?</a>
                    </aside>
                </div>

                <div class="job_info">
                    <?php
                    function renderSection($label, $content) {
                        echo '<div class="job_card_container">';
                        echo '<div class="job_slide job_slide_1"><p class="job_card">'.$label.'</p></div>';
                        echo '<div class="job_slide job_slide_2"><ul class="job_details">';

                        foreach (explode("\n", $content) as $line) {
                            echo '<li>'.htmlspecialchars($line).'</li>';
                        }

                        echo '</ul></div></div>';
                    }

                    renderSection("Role", $job["role"]);
                    renderSection("Responsibilities", $job["responsibilities"]);
                    renderSection("Job brief", $job["job_brief"]);
                    renderSection("Requirements and skills", $job["requirements"]);
                    ?>
                </div>

                <br><br><br>
            <?php endwhile; ?>

            <?php mysqli_close($conn); ?>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </section>

        <!-- EVP -->
        <div id="job_main_2">
            <p class="main_title_evp">Employee value proposition (EVP)</p>
            <hr class="main_line_evp">
        </div>
        <div id="jov_evp">
            <!-- 1st -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_1.svg" alt="Flexible hours">
                </div>
                <p>Flexible hours</p>
            </div>
            <!-- 2nd -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_2.svg" alt="Payment guaranteed">
                </div>
                <p>Payment guaranteed</p>
            </div>        
            <!-- 3rd -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_3.svg" alt="Choose your projects">
                </div>
                <p>Choose your projects</p>
            </div>
            <!-- 4th -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_4.svg" alt="No AI experience required">
                </div>
                <p>No AI experience required</p>
            </div>
            <!-- 5th -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_5.svg" alt="Free training">
                </div>
                <p>Free training</p>
            </div>
            <!-- 6th -->
            <div class="job_evp_card">
                <div class="icon">
                    <img src="images/job_images/job_EVP_6.svg" alt="Easy withdrawals">
                </div>
                <p>Easy withdrawals</p>
            </div>
        </div>

        <!-- QUOTE -->
        <div id="job_quote">
            <div class="job_quote_part">
                <img src="images/job_images/job_quote_icon.png" alt="Quote icon" class="job_quote_icon"> 
                <h2 class="job_quote_title">Match. Build. Succeed.</h2>
                <p class="job_quote_p1">
                    A career breakthrough for IT professionals — better pay, exciting projects, and companies that actually value your technical skills.
                </p>
                <p class="job_quote_p2">Community Member</p>
            </div>
            <img src="images/job_images/job_quote_pic.jpg" alt="Quote Image" class="job_quote_img">
            <!-- Orignal img taken from https://www.pexels.com/ -->
        </div>

        <!-- APPLY BUTTON -->
        <section class="job_apply_section">
            <div>
                <div class="job_apply_content">
                    <h3 id="job_apply_heading" class="job_apply_title">Apply now</h3> <br>
                    <p class="job_apply_desc">Join our company — submit your application today and take the next step.</p>
                </div>
                    <br>
                <div class="job_apply_btn_sec">
                    <a href="./apply.php" class="btn">&#10140; View more</a>
                </div>
            </div>
        </section>
    </main>

  <!-- FOOTER USE FOR ALL PAGES -->
    <?php include "footer.inc" ?>
</body>
</html>