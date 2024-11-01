<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: /login.php');
    }
    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if ($_POST['submit'] === 'logout') {
            session_destroy();
            header('Location: /');
        } elseif ($_POST['submit'] === 'add_payment') {
            header('Location: /account/payment');
        } elseif ($_POST['submit'] === 'get_info') {
            header('Location: /account/info');
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

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Account Activities</h1>

        <form method="post" action="">
            <button type="submit" name="submit" id="submit" value="add_payment">Add Payment</button>
            <button type="submit" name="submit" id="submit" value="get_info">View Information</button>
            <button type="submit" name="submit" id="submit" value="logout">Log Out</button>
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>
</body>
</html>
