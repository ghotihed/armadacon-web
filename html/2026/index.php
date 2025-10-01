<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $year = 2026;
    $page_name = "events";
    $page_title = "ArmadaCon $year";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php //$convention = new Convention($year); ?>     <!-- FIXME Enable this when the database is updated. -->

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for <?=$year?>?</h1>

        <div class="content-box">
            <h3 id="guests">Who</h3>
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $year . "/guests/guest-fragment.php")?>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
