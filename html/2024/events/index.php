<!doctype html>
<html lang="en">

<?php
    $page_name = "events";
    $page_title = "ArmadaCon Events";
    include(__DIR__ . "/../../includes/html-header.php")
?>

<body>
    <?php include(__DIR__ . "/../../includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for 2024?</h1>

        <div class="content-box">
            <h3 id="programme">Convention Programme</h3>
            There's a whole of <em>To Be Determined</em> here.
        </div>

        <div class="content-box">
            <h3 id="cosplay">Cosplay</h3>
            We haven't worked out a theme for this year's convention. Do you have any ideas?
        </div>

        <div class="content-box">
            <h3 id="book-launch">Book Launches</h3>
            No book launches have yet been announced.
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
