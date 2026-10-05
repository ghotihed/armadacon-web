<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/init-convention.php";
global $convention;
if ($convention->feedbackWanted()) {
    $uri = "https://docs.google.com/forms/d/e/1FAIpQLSf26ql7I1VFv34MMTlQjhGuusCxZKMfL6m0vbZO1UNLMykGuA/viewform?usp=header";
    header("Location: " . $uri);
}
?>

<!doctype html>
<html lang="en">

<?php
$page_name = "home";
$page_title = "ArmadaCon Feedback";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php";
?>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"; ?>
    <div class="content">
        <div class="content-box">
            <h3><?=$convention->feedbackYear()?> Feedback</h3>
            <p>
            Feedback has already been collected for ArmadaCon <?=$convention->feedbackYear()?>. Feedback for
            ArmadaCon <?=$convention->year()?> will be available as soon as the convention starts and for 90
            days afterwards. We encourage you to return here during that time to provide feedback on the
            convention. Thanks.
            </p>
            <div style="text-align: center">
                <a class="feedback-button" href="/">Go to Homepage</a>
            </div>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>
</body>
</html>
