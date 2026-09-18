<!doctype html>
<html lang="en">

<?php
    global $convention;
    $page_name = "home";
    $page_title = "ArmadaCon Homepage";
    include("includes/html-header.php");

    use libs\Convention;
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <div class="content-box" style="background-color: #CC6666; color: white;">
            <div style="text-align: center; font-weight: bold; font-size: x-large; padding-bottom: 10px">Notice</div>
            <h3>Friday, 18<sup>th</sup> September 2026</h3>
            <p>
                In the immortal words of Professor Farnsworth, 'Good news, everyone!' We have a convention!
                The key points to know, going forward are:
            </p>
            <ul>
                <li>The convention will be held at the <a href="location.php" style="color: #0a6288;">Leonardo Hotel</a> in downtown Plymouth.</li>
                <li>The convention will only be on the Saturday and Sunday.</li>
            </ul>
            <p>
                There will
                be an official notice featured on our <a href="https://www.facebook.com/pages/ArmadaCon/575505719147884?hc_location=stream" target="new">
                    <span style="display: inline-block; font-family: 'Facebook Sans', 'Helvetica Neue', Arial, sans-serif; color: #1877F2; font-weight: bold;">
                        facebook
                    </span>
                </a> page.
            </p>
            <hr/>
            <h3>Friday, 21<sup>st</sup> August 2026</h3>
            <p>
                It's a good thing to keep in mind that the website may well lag behind the latest information
                available concerning the current situation regarding the venue for this year's convention. People
                are advised to follow our <a href="https://www.facebook.com/pages/ArmadaCon/575505719147884?hc_location=stream" target="new">
                    <span style="display: inline-block; font-family: 'Facebook Sans', 'Helvetica Neue', Arial, sans-serif; color: #1877F2; font-weight: bold;">
                        facebook
                    </span>
                </a> page.
            </p>
            <hr/>
            <h3>Tuesday, 18<sup>th</sup> August 2026</h3>
            <p>
                We now have confirmation that people who have already booked a room at the hotel are receiving emails
                cancelling their bookings. If you have booked a room, and you haven't yet heard from Future Inns
                Plymouth by the end of the week, it might be worth getting in touch with them.
            </p>
            <hr/>
            <h3>Monday, 17<sup>th</sup> August 2026</h3>
            <p>
                We have recently been informed that the venue for ArmadaCon 2026 (the Future Inn Plymouth) will be
                closing on 25<sup>th</sup> September and changing to a Premier Inn. The committee is taking a page from Mark
                Watney, and they are currently working the problem.</p>
            <p>
                In the meantime, we should all take a lesson from Douglas Adams and
                <a href="https://en.wikipedia.org/wiki/Phrases_from_The_Hitchhiker%27s_Guide_to_the_Galaxy#Don't_Panic" target="new"><span style="display: inline-block; font-weight: bold; color: #0a6288; padding-right: 0; margin-right: 0;">Don't Panic</span></a>.
            </p>
        </div>



        <?php
        $prevConvention = new Convention($convention->year() - 1);
        $daysSincePrev = $convention::now()->diff(DateTime::createFromFormat('m/d/Y h:i A', $prevConvention->endString()))->days;
        if ($daysSincePrev < 90) {
        ?>
        <div class="content-box" style="background-color: #c6e1c6">
            <h3><?=$prevConvention->year()?> Feedback</h3>
            <p>
                The ArmadaCon <?=$prevConvention->year()?> convention has concluded, and we hope you had a good time. But since nobody’s
                perfect, we’d love to hear from you about what you enjoyed and what problems you may have encountered,
                so we can work to fix anything that didn't go well for you.
            </p>
            <p>
                To that end, we've created a feedback form for you to fill out.  All questions are optional, so feel
                free to skip any you don’t want to answer. However, the more you tell us the better we’ll be equipped
                for next year.
            </p>
            <div style="text-align: center">
                <a class="feedback-button" href="https://forms.gle/W58KVdhiUJ3SdkSaA" target="_new">Send Us Feedback</a>
            </div>
        </div>
        <?php } ?>

        <div class="content-box">
            <h3>What</h3>
            <p>
                ArmadaCon is a sci-fi and fantasy multimedia convention that's been running in Plymouth since 1988.
                While other conventions tend to be focused on one medium or one subject within that medium, we've
                found that fans find this format restrictive, as most fans like more than one type of medium,
                irrespective of subject. You can find out more on our <a href="about.php">about page</a>.
            </p>
            <p>
                For information on specific items planned for <?=$convention->year()?>, go to
                <a href="<?=$convention->year()?>">this year's page</a>.
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
                This year, ArmadaCon is being held at the Leonardo Hotel in downtown Plymouth. There are a number of
                different room configurations to meet people's needs. They are all en-suite and non-smoking.

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
