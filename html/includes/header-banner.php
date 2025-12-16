<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

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

<?php if ($convention::now() < new DateTime('2025-12-19 01:30 UTC')) { ?>
    <div style="width: auto; padding: 5px; margin-top: 0; text-align: center; font-weight: bold; background-color:red; color: white">This site will experience scheduled maintenance on 19<sup>th</sup> December 2025 between 00:00-01:30 UTC</div>
<?php } ?>
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
                <a href="/<?=$convention->year()?>"><?=$convention->year()?> Information</a>
                <a href="/<?=$convention->year()?>/guests"><?=$convention->year()?> Guests</a>
                <?php
                if ($convention->isRunning()) {
                    echo '<a href="/' . ($convention->year() + 1) . '/guests">' . ($convention->year() + 1) . ' Guests</a>';
                }
                ?>
                <a href="/<?=$convention->year()?>/programme"><?=$convention->year()?> Programme</a>
                <a href="/<?=$convention->year()?>/menu"><?=$convention->year()?> Menu</a>
                <a href="/location.php">Location</a>
                <a href="/registration.php">Registration</a>
            </div>
        </div>
        <a href="/charity.php">Charity</a>
        <a href="/faq.php">FAQ</a>
        <a href="/policies.php">Policies</a>
        <a href="/contacts.php">Contacts</a>
        <?php if (is_logged_in()) { ?>
                <div class="dropdown" id="login">
                    <button class="drop-button"><?=logged_in_email()?> &#x25be;</button>
                    <div class="dropdown-content">
                        <?php if (logged_in_member_id() > 0) { ?>
                            <a href="/account/member/view">My Information</a>
                        <?php } ?>
                        <?php if (has_permission(Permission::ADD_PAYMENT)) { ?>
                            <a href="/account/payment">Record Payment</a>
                        <?php } ?>
                        <?php if (has_permission(Permission::VIEW_MEMBER_LIST) || has_permission(Permission::VIEW_REG_LIST)) { ?>
                            <a href="/account/info">View Information</a>
                        <?php } ?>
                        <a href="/account/logout.php">Logout</a>
                    </div>
                </div>
        <?php } else { ?>
            <a id="login" href="/login.php">Login</a>
        <?php } ?>
        <a href="javascript:void(0);" style="font-size:15px;" class="menubar-icon" onclick="toggleMenu()">&#9776;</a>
    </div>
</nav>
<script>
    function toggleMenu() {
        let x = document.getElementById("top-menu");
        if (x.className === "menubar") {
            x.className += " responsive";
        } else {
            x.className = "menubar";
        }
    }
</script>
