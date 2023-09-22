<?php $header_class = $page_name . 'Table'; ?>
<!--<table class="<?php echo $header_class?>">-->
<!--</table>-->

<table class="headerFrame">
<!--<table style="width: 100%">-->
    <tr>
        <td><img id="shieldImg" src="/Images/armadacon-shield.png" alt="ArmadaCon shield"></td>
        <td>
            <div id="bannerContainer">
                <img id="bannerImg" src="/Images/armadacon-banner-588x75.png" alt="ArmadaCon banner"/>
                <div id="conventionDates"><?=$banner_dates_short?>, <?=$current_year?></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="social-media-icons">
            <!--<p class="social-media-icons">-->
            <p>
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
            </p>
        </td>
        <td/>
    </tr>
</table>

<div class="countdown">
    <script type="text/javascript">
        TargetDate = "<?=$start_date?>";
        BackColor = "transparent";
        ForeColor = "#000000";
        CountActive = true;
        CountStepper = -1;
        LeadingZero = true;
        DisplayFormat = "ArmadaCon <?=$current_year?> starts in %%D%% days, %%H%% hours, %%M%% minutes, %%S%% seconds.";
        FinishMessage = "ArmadaCon <?=$current_year?> is happening!";
    </script>
    <script type="text/javascript" src="/java/countdown.js"></script>
</div>
