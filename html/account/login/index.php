<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

$uniqueCode = $_SERVER['QUERY_STRING'];
$result = login_by_unique_code($uniqueCode);
if ($result === "") {
    header("location: /");
}
?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "login";
    $page_title = "ArmadaCon Login";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Login Failure</h1>
        <p><?=$result?> Unable to log you in using that link.</p>
        <a href="/login.php">Click here to try again.</a>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
