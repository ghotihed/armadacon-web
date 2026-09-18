<!doctype html>
<html lang="en">

<?php
    $page_name = "location";
    $page_title = "Where is ArmadaCon?";
    include("includes/html-header.php");

    global $convention;
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <?php
        if ($convention->location() == "Future Inn Plymouth") {
            include("includes/future-inns-plymouth.php");
        } elseif ($convention->location() == "Leonardo Hotel Plymouth") {
            include("includes/leonardo-hotel-plymouth.php");
        }
        ?>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
