<?php
    require_once __DIR__ . "/includes/login-utils.php";

    session_start();
    $error = '';
    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if ($_POST['submit'] === 'cancel') {
            go_to_referer();
        } elseif ($_POST['submit'] === 'login') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $error = login($email, $password);
        }
    } else {
        save_referer();
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

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Account Login</h1>
        <?php
            if (isset($error)) {
                echo "<div class='alert-error'>$error</div>";
            }
        ?>
        <form style="margin-left: auto; margin-right: auto;" action="" method="post">
            <div><label for="email">Email</label><input type="email" name="email" id="email" placeholder="Enter your email address" required></div>
            <div><label for="password">Password</label><input type="password" name="password" id="password" placeholder="Enter your password" required></div>
            <button class="submit" type="submit" name="submit" id="submit" value="login">Log In</button>
            <button class="cancel" type="submit" name="submit" id="submit" value="cancel" formnovalidate>Cancel</button>
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
