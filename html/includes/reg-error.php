<?php

global $reg_year;
global $reg_error;
?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <?=$reg_error?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
