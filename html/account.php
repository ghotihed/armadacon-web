<?php
    session_start();
    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if ($_POST['submit'] === 'logout') {
            session_destroy();
            header('Location: /');
        }
    }

?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "account";
    $page_title = "ArmadaCon Account";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Account Activities</h1>

        <form method="post" action=""><button type="submit" name="submit" id="submit" value="logout">Log Out</button></form>
        <!--<button type="submit" formmethod="post" formaction="" name="submit" id="submit" value="logout">Log Out</button>-->
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
