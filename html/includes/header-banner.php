<?php
    session_start();
    $isLoggedIn = isset($_SESSION['email']);
    $email = $_SESSION['email'] ?? '';
    global $convention;
    global $page_name;
    $background_image = '/Images/header-graphic-' . strtolower($page_name) . '.png';
    if (!file_exists(__DIR__ . $background_image)) {
        $background_image = '/Images/header-graphic-home.png';
    }
?>

<style>
    body {
        /*noinspection CssUnknownTarget*/
        background-image: url(<?=$background_image?>);
    }
</style>

<table class="headerFrame">
    <tr>
        <td id="shieldImg"><a href="/"><img src="/Images/armadacon-shield.png" alt="ArmadaCon shield"></a></td>
        <td rowspan="2">
            <a  href="/<?=$convention->year()?>" >
                <div id="bannerContainer">
                    <img id="bannerImg" src="/Images/armadacon-banner-shadow.png" alt="ArmadaCon banner"/>
                    <div id="conventionDates"><?=$convention->shortBanner()?>, <?=$convention->year()?></div>
                </div>
            </a>
        </td>
    </tr>
    <tr>
        <td class="social-media-icons">
            <a href="https://www.facebook.com/pages/ArmadaCon/575505719147884?hc_location=stream" target="new">
                <img src="/Images/social-media-icon-facebook.png" alt="ArmadaCon Facebook Page" title="Facebook"/>
            </a>
            <!--<a href="https://x.com/ArmadaCon" target="new">-->
            <!--    <img src="/Images/social-media-icon-x.png" alt="ArmadaCon X Page" title="&#120143; (formerly Twitter)"/>-->
            <!--</a>-->
            <a href="https://instagram.com/armadacon" target="new">
                <img src="/Images/social-media-icon-instagram.png" alt="ArmadaCon Instagram Page" title="Instagram"/>
            </a>
            <a href="mailto:enquiries@armadacon.org?subject=ArmadaCon Enquiry">
                <img src="/Images/social-media-icon-email.png" alt="Contact Us" title="Email"/>
            </a>
        </td>
    </tr>
</table>

<div class="countdown">
    <script type="text/javascript">
        TargetDate = "<?=$convention->startString()?>";
        Now = "<?=$convention->nowString()?>";
        BackColor = "transparent";
        ForeColor = "#d6dee1";
        CountActive = true;
        CountStepper = -1;
        LeadingZero = true;
        DisplayFormat = "ArmadaCon <?=$convention->year()?> starts in %%D%% days, %%H%% hours, %%M%% minutes, %%S%% seconds.";
        FinishMessage = "ArmadaCon <?=$convention->year()?> is happening!";
    </script>
    <script type="text/javascript" src="/java/countdown.js"></script>
</div>

<!-- TODO Figure out how to make the current page have class="active". -->
<link rel="stylesheet" href="/css/menu.css"/>
<nav class="sticky-bar">
    <div class="menubar" id="top-menu">
        <a href="/">Home</a>
        <div class="dropdown">
            <button class="drop-button">Convention &#x25be;</button>
            <div class="dropdown-content">
                <a href="/<?=$convention->year()?>">About</a>
                <a href="/<?=$convention->year()?>/guests">Guests</a>
                <a href="/<?=$convention->year()?>/programme">Programme</a>
                <a href="/location.php">Location</a>
                <a href="/registration.php">Registration</a>
            </div>
        </div>
        <a href="/charity.php">Charity</a>
        <a href="/faq.php">FAQ</a>
        <a href="/policies.php">Policies</a>
        <a href="/contacts.php">Contacts</a>
        <?php
            if ($isLoggedIn) {
                echo "<a id='login' href='/account'>$email</a>";
            } else {
                echo '<a id="login" href="/login.php">Login</a>';
            }
        ?>
        <a href="javascript:void(0);" style="font-size:15px;" class="menubar-icon" onclick="myFunction()">&#9776;</a>
    </div>
</nav>
<script>
    function myFunction() {
        let x = document.getElementById("top-menu");
        if (x.className === "menubar") {
            x.className += " responsive";
        } else {
            x.className = "menubar";
        }
    }
</script>
