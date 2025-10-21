<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/db/bootstrap.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

    $error = '';
    $sending_email = false;
    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if ($_POST['submit'] === 'cancel') {
            go_to_referer();
        } elseif ($_POST['submit'] === 'login') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $error = login($email, $password);
        } elseif ($_POST['submit'] === 'no_password') {
            // Generate a reset ID and send a reset email.
            if ($_POST['email'] === "") {
                $error = "Please enter your email address";
            } else {
                $sending_email = true;
                $error = generate_unique_code($_POST['email'], "/account/login");
            }
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
        <?php if ($sending_email) { ?>
            <h1 class="page-title">ArmadaCon Login</h1>
            <p>
                Thank you for attempting to log in. If the email was valid, you
                will receive an email with a link to log into your account. You can then
                view your member information, set a password, register for a convention, etc.
            </p>
        <?php } else { ?>
            <h1 class="page-title">ArmadaCon Account Login</h1>
            <?php
                if (isset($error)) {
                    echo "<div class='alert-error'>$error</div>";
                }
            ?>
            <form style="width: 400px; margin-left: auto; margin-right: auto;" action="" method="post">
                <div><label for="email">Email</label><input type="email" name="email" id="email" placeholder="Enter your email address" required"></div>
                <button class="submit" type="submit" id="reset" name="submit" value="no_password" formnovalidate>Get Login Link</button>
                <hr/>
                <div><label for="password">Password</label><input type="password" name="password" id="password" placeholder="Enter your password"></div>
                <button class="submit" type="submit" id="login" name="submit" value="login">Use Password</button>
                <hr/>
                <button class="cancel" type="submit" id="cancel" name="submit" value="cancel" formnovalidate>Cancel</button>
            </form>
        <?php } ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
