<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <!-- TITLE ICON -->
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">


    <!-- <link rel="stylesheet" href="/styles/styles.css"> -->
     <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <!-- navigation bar (same on all pages) -->
     <?php include "nav.inc"?>

    <!-- MAIN CONTENT -->

    <!-- HERO SECTION/ INTRODUCTION -->
    <section id="ap_herosection" class="center colum flex_center">
            <img id="hp_hs_logo" src="images/logo.png" alt="3ners">
            <h2 class="ap_title">About our team</h2>
        <section class="ap_desc">
            <h2 class="ap_subtitle">
                We are "3Ners"
            </h2>
            <p class="ap_long_desc">
                Our team is part of the COS10026.2 class, which takes place every 
                Friday from 2 PM to 5 PM under the guidance of our tutor, Miss Linda. 
                We have been collaborating closely for several weeks, combining our 
                skills and efforts to successfully develop and refine this project together.
            </p>
        </section>
    </section> <!-- end of herosection -->

    <!-- MEMBER DETAILS -->
    <section class="ap_desc colum flex_center">
        <h2 class="ap_title">About our Team members</h2>
        <div class="ap_member_details row flex_center">
            
            <!-- MEMBER 1 NGUYEENX KHANH AN -->
            <section class="ap_members colum">
                <h2 class="center">NGUYEN KHANH AN</h2>
            <!-- desc -->
                <div class="ap_members_desc colum flex_center">
                    <figure>
                    <img src="images/member_potrait_example.png" alt="member_picture">
                    </figure>
                    <section class="ap_member_details">
                    <h3>Student information</h3>
                    <ul>
                        <li>Student ID: SWH03020</li>
                        <li>Major: Software Developing</li>
                    </ul>
    
                    <dl class="center row flex_center">
                        <dt>Contribution:</dt>
                        <dd><a href="index.php">Home Page</a></dd>
                        <dd><a href="about.php">About Page</a></dd>
                        <dd>UI/UX</dd>
                        <dd><a href="manage.php"></a>Management Site</dd>
                    </dl>
    
                    <br>
                    <a class="btn" href="index.php">
                        &#8594; See more of Ann's work
                    </a>
                    </section>
                </div> <!-- end of desc -->
            </section> <!-- end of member 1 -->
    
            <!-- MEMBER 2 PHAM MINH NGOC -->
            <section class="ap_members colum">
                <h2 class="center">PHAM MINH NGOC</h2>
                <div class="ap_members_desc colum flex_center">
                    <figure>
                    <img src="images/member_potrait_example.png" alt="member_picture">
                    </figure>
                    <section class="ap_member_details">
                    <h3>Student information</h3>
                    <ul>
                        <li>Student ID: SWH02971</li>
                        <li>Major: Internet of Things</li>
                    </ul>
    
                    <dl class="center row flex_center">
                        <dt>Contribution:</dt>
                        <dd><a href="jobs.php">Vacancies Page</a></dd>
                        <dd>Navbar and Footer</dd>
                    </dl>
    
                    <br>
                    <a class="btn" href="jobs.php">
                        &#8594; See more of Ngoc's work
                    </a>
                    </section>
                </div>
            </section>
    
            <!-- MEMBER 3 VUONG THI NGOC KHANH -->
            <section class="ap_members colum">
                <h2 class="center">VUONG THI NGOC KHANH</h2>
                <div class="ap_members_desc colum flex_center">
                    <figure>
                    <img src="images/member_potrait_example.png" alt="member_picture">
                    </figure>
                    <section class="ap_member_details">
                    <h3>Student information</h3>
                    <ul>
                        <li>Student ID: SWH03067</li>
                        <li>Major: Data Science</li>
                    </ul>
    
                    <dl class="center row flex_center">
                        <dt>Contribution:</dt>
                        <dd><a href="apply.php">Application Page</a></dd>
                        <dd><a href="applysuccess.php">Submission Page</a></dd>
                    </dl>
    
                    <br>
                    <a class="btn" href="apply.php">
                        &#8594; See more of Khanh's work
                    </a>
                    </section>
                </div>
            </section>
        </div>
        
    </section>


    <!-- PICTURE OF OUR TEAM -->
    <figure id="ap_team_picture" class="center">
        <figcaption>
            <h2>Our group picture</h2>
        </figcaption>
        <img src="images/picture_placeholder.png" alt="team_picture">
    </figure>

    <!-- INTEREST TABLE -->
     <section id="ap_interests" class="flex_center colum">
        <h3 class="ap_title center">Our interests</h3>
        <table>
            <tr>
                <th></th>
                <th>Interest 1</th>
                <th>Interest 2</th>
                <th>Interest 3</th>
            </tr>
            <tr>
                <td><h3>Ann</h3></td>
                <td>Coding</td>
                <td>Design UI/UX</td>
                <td>Sleeping</td>
            </tr>
            <tr>
                <td><h3>Ngoc</h3></td>
                <td>Cleaning</td>
                <td>Listening to music</td>
                <td>Reading</td>
            </tr>
            <tr>
                <td><h3>Khanh</h3></td>
                <td>Traveling</td>
                <td>Watching films</td>
                <td>Teaching</td>
            </tr>
        </table>

     </section>

  <!-- FOOTER USE FOR ALL PAGES -->
     <?php include "footer.inc"?>

</body>
</html>