<?php
    //$header_class = $page_name . 'Table';
    //$background_image = '/Images/header-graphic-1000x682-transparency.png';
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
        <td id="shieldImg"><img src="/Images/armadacon-shield.png" alt="ArmadaCon shield"></td>
        <td rowspan="2">
            <div id="bannerContainer">
                <img id="bannerImg" src="/Images/armadacon-banner-shadow.png" alt="ArmadaCon banner"/>
                <div id="conventionDates"><?=$banner_dates_short?>, <?=$current_year?></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="social-media-icons">
            <a href="https://www.facebook.com/pages/ArmadaCon/575505719147884?hc_location=stream" target="new">
                <img src="/Images/social-media-icon-facebook.png" alt="ArmadaCon Facebook Page"/>
            </a>
            <a href="https://x.com/ArmadaCon" target="new">
                <img src="/Images/social-media-icon-x.png" alt="ArmadaCon X Page"/>
            </a>
            <a href="https://instagram.com/armadacon" target="new">
                <img src="/Images/social-media-icon-instagram.png" alt="ArmadaCon Instagram Page"/>
            </a>
            <a href="mailto:armadacon@ghoti.net?subject=ArmadaCon Enquiry">
                <img src="/Images/social-media-icon-email.png" alt="Contact Us"/>
            </a>
        </td>
    </tr>
</table>

<div class="countdown">
    <script type="text/javascript">
        TargetDate = "<?=$start_date?>";
        BackColor = "transparent";
        ForeColor = "#d6dee1";
        CountActive = true;
        CountStepper = -1;
        LeadingZero = true;
        DisplayFormat = "ArmadaCon <?=$current_year?> starts in %%D%% days, %%H%% hours, %%M%% minutes, %%S%% seconds.";
        FinishMessage = "ArmadaCon <?=$current_year?> is happening!";
    </script>
    <script type="text/javascript" src="/java/countdown.js"></script>
</div>
