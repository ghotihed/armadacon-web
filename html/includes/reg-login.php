<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/MemberRegInfo.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/bootstrap.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/Convention.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/MailConfig.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/Mailer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/MailRegConfirmation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/stripe-processing.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/register-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

//use config\MailConfigRegistration;
//use db\MembersTable;
//use db\Member;
//use db\Registration;
//use db\RegistrationsTable;
//use libs\Convention;
//use libs\Mailer;
//use libs\MailRegConfirmation;
//use libs\MemberRegInfo;

global $reg_year;

$login_result = "";
$email_sent = false;

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST["submit"] === "get_link") {
        $login_result = generate_unique_code($_POST['email'], "/$reg_year/register");
        $email_sent = $login_result === "";
    } elseif ($_POST["submit"] === "new_reg") {
        header("Location: /$reg_year/register/new");
    } elseif ($_POST["submit"] === "cancel") {
        go_to_referer();
    }
} else {
    save_referer();
    $uniqueCode = $_SERVER['QUERY_STRING'];
    if ($uniqueCode !== "") {
        $login_result = login_by_unique_code($uniqueCode);
        if ($login_result === "") {
            // Reload the page, now in logged-in mode.
            header("Location: /$reg_year/register");
            exit;
        }
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

    <!--<link rel="stylesheet" href="/css/register.css" type="text/css">-->
    <link rel="stylesheet" href="/css/login.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <?php if ($email_sent) { ?>
            <div class="login-instructions">
                Thank you for asking for the login link. If your email is in our system, you will
                receive a link at that email address. Click the link in that email to complete
                your login.
            </div>
        <?php } else { ?>
            <?php if ($login_result !== "") { ?>
                <div class="login-error"><?=$login_result?></div>
            <?php } ?>
            <div class="login-instructions">
                If you have registered in the past, you need to log in using your email address. You will be
                sent an email with a link to continue registering.
            </div>

            <form class="login-form" action="" method="post">
                <div>
                    <label class="email-label" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required">
                    <button class="submit" type="submit" id="login" name="submit" value="get_link" formnovalidate>Get Login Link</button>
                    <button class="cancel" type="submit" id="cancel" name="submit" value="cancel" formnovalidate>Cancel</button>
                </div>
                <hr>
                <div class="login-instructions">
                    If you have never registered for ArmadaCon online in the past, you will need to
                    start from scratch as a new member.
                </div>
                <button class="submit widebutton" type="submit" id="new_reg" name="submit" value="new_reg" formnovalidate>New Member</button>
            </form>
        <?php } ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
