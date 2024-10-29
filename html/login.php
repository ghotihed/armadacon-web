<?php
    require_once __DIR__ . "/config/DBConfig.php";

    session_start();
    $error = '';
    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($email === "admin@armadacon.org" && $password === \config\DBConfig::PASSWORD) {
            session_regenerate_id();
            $_SESSION['email'] = $email;
            $_SESSION['member_id'] = 0;
            $referrer = $_SESSION['referrer'];
            unset($_SESSION['referrer']);
            header("Location: $referrer");
        } else {
            // Try to find the user in the member database.
            $error = 'Invalid email or password';
        }
    } else {
        if (!isset($_SESSION['referrer'])) {
            $_SESSION['referrer'] = $_SERVER['HTTP_REFERER'];
        }
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
            <button class="submit" type="submit" name="submit" value="login">Log In</button>
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
