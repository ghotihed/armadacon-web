<?php
    //$header_class = $page_name . 'Table';
    //$background_image = '/Images/header-graphic-1000x682-transparency.png';
    global $convention;
    global $page_name;
    $background_image = '/Images/header-graphic-' . strtolower($page_name) . '.png';
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
            <div id="bannerContainer">
                <img id="bannerImg" src="/Images/armadacon-banner-shadow.png" alt="ArmadaCon banner"/>
                <div id="conventionDates"><?=$convention->shortBanner()?>, <?=$convention->year()?></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="social-media-icons">
            <a href="https://www.facebook.com/pages/ArmadaCon/575505719147884?hc_location=stream" target="new">
                <img src="/Images/social-media-icon-facebook.png" alt="ArmadaCon Facebook Page" title="Facebook"/>
            </a>
            <a href="https://x.com/ArmadaCon" target="new">
                <img src="/Images/social-media-icon-x.png" alt="ArmadaCon X Page" title="&#120143; (formerly Twitter)"/>
            </a>
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
