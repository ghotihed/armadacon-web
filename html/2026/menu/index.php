<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $year = 2026;
    $page_name = "events";
    $page_title = "ArmadaCon $year Menu";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/food-menu.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon <?=$year?> Menu</h1>

        <p>
            There's no word yet on what sort of custom menu may be available for this convention. Stay tuned
            for more information.
        </p>

    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
