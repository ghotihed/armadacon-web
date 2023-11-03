<!doctype html>
<html lang="en">

<?php
    global $convention;
    $page_name = "home";
    $page_title = "ArmadaCon Homepage";
    include("includes/html-header.php")
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <div class="content-box">
            <h3>What</h3>
            <p>
                ArmadaCon is a sci-fi and fantasy multimedia convention that's been running in Plymouth since 1988.
                While other conventions tend to be focused on one medium or one subject within that medium, we've
                found that fans find this format restrictive, as most fans like more than one type of medium,
                irrespective of subject. You can find out more on our <a href="about.php">about page</a>.
            </p>
            <p>
                For information on specific events planned for <?=$convention->year()?>, go to
                <a href="<?=$convention->year()?>/events">this year's events page</a>.
            </p>
            <p>
                You can also view <a href="<?=$convention->year()?>/programme">this year's programme</a> to figure
                out what you'd like to do.
            </p>
        </div>

        <div class="content-box">
            <h3>Who</h3>
            <?php include(__DIR__ . "/" . $convention->year() . "/guests/guest-fragment.php")?>
        </div>

        <div class="content-box">
            <h3>Where</h3>
            <p>
                For a while now, ArmadaCon has been meeting at the Future Inns hotel in Plymouth. All rooms have either
                two Canadian double beds or one Canadian double bed and one sofa bed. They are all en-suite and non-smoking.

                ArmadaCon gets a special room rate, though this does not include breakfast, which is an additional charge.
                More information can be found on the <a href="location.php">location page</a>.
            </p>
        </div>

        <div class="content-box">
            <h3>When</h3>
            <p>
                ArmadaCon meets the first weekend in November. For <?=$convention->year()?>, this means <?=$convention->longBanner()?>
                . Programming starts around 18:00 on the Friday, runs through
                17:30 on the Sunday, and is then followed up with a post-con meal for anybody who's still around.
            </p>
        </div>

        <div class="content-box">
            <h3>How</h3>
            <p>
                You can register to attend by first visiting the <a href="registration.php">registration page</a>. Here
                you'll find information about the cost have the opportunity to fill in your details for registration.
            </p>
        </div>

        <div class="content-box">
            <h3>Why</h3>
            <p>
                Wadda ya mean, why? Because you'll have a fun time. That's why!!!
            </p>
            <p>
                Also, ArmadaCon has a history of <a href="charity.php">giving to charity</a>, which means your attendance
                and help will have a meaningful impact on the community.
            </p>
        </div>

        <div class="content-box">
            <h3>Miscellaneous</h3>
            <p>
                You can find more general information in our <a href="faq.php">FAQ</a>, and more information about
                our <a href="policies.php">code of conduct</a>. If you'd like to get in touch with us, you can
                do so from <a href="contacts.php">our contacts page</a>.
            </p>
        </div>

        <!--<br/>-->
        <!--<p style="text-align: center"><img src="Images/Masked Gary.png" style="max-width: 30%; height: auto;" alt="Gary"/></p>-->
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
