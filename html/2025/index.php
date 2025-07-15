<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "events";
    $page_title = "ArmadaCon 2025";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php $convention = new Convention(2025); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for 2025?</h1>

        <div class="content-box">
            <h3 id="guests">Who</h3>
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $convention->year() . "/guests/guest-fragment.php")?>
        </div>

        <div class="content-box">
            <h3 id="programme">Convention Programme</h3>
            The programme for this year's convention can be found <a href="programme">here</a>.
        </div>

        <!--<div class="content-box">-->
        <!--    <h3 id="cosplay">Cosplay</h3>-->
        <!--    We haven't worked out a theme for this year's convention. Do you have any ideas?-->
        <!--</div>-->

        <div class="content-box">
            <h3 id="show-and-tell">Show &amp; Tell</h3>
            Our poet in residence, Dawn Abigail, is having a special exhibition of <em>Show & Tell</em> micro-fiction
            developed in partnership with calligrapher and illustrator Gwyneth Hibbett. Find out more
            <a href="show-and-tell">here</a>.
        </div>

        <div class="content-box">
            <h3 id="book-launch">Books</h3>
            No books have been announced for this year, yet.
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
