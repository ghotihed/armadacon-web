<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/register-utils.php';

use config\MailConfigRegistration;
use db\MembersTable;
use db\MembershipTypesTable;
use db\RegistrationsTable;
use libs\Mailer;
use libs\MailRegConfirmation;

global $reg_year;
global $debug_no_save;

$total = $_SESSION['total'] ?? 0.0;
$frontDesk = $_SESSION['front-desk'] ?? false;
$registrations = array();
$uidList = array();
$registrationsTable = new RegistrationsTable();
$membersTable = new MembersTable();
$membershipTypesTable = new MembershipTypesTable();

foreach ($_SESSION['registrations'] as $registration) {
    $id = ($debug_no_save ?? false) ? rand(1, 500) :  $registrationsTable->addRegistration($registration);
    $registration->id = $id;

    // Collect some information about the registration.
    $membershipType = $membershipTypesTable->getMembershipType($registration->membership_type);
    $member = $membersTable->getMember($registration->for_member);
    $uid = generateRegUid($member, $registration, $membershipType);
    $uidList[] = $uid;
    $registrations[$uid] = $registration;

    // Send an email confirmation
    if (!($debug_no_save ?? false)) {
        $mail_confirmation = new MailRegConfirmation($reg_year, $member, $registration, $membershipType);
        $mailer = new Mailer(new MailConfigRegistration);
        $mailer->send_email($mail_confirmation);
    }
}
unset($_SESSION['total']);
unset($_SESSION['payment_result']);
unset($_SESSION['front-desk']);
unset($_SESSION['registrations']);
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
        <h1 class="page-title">Registration Success</h1>

        <div class="registration-success">
        Thank you for registering for ArmadaCon <?=$reg_year?>! You should receive
        <?php echo (count($uidList) > 1) ? " emails" : " an email"; ?>
        with your registration information. Your registration ID
        <?php
            if (count($uidList) > 1) {
                echo "s are:<ul>";
                foreach ($uidList as $uid) {
                    echo "<li><span class='registration-uid'>$uid</span></li>";
                }
                echo "</ul>";
            } else {
                echo " is: <span class='registration-uid'>" . $uidList[0] . "</span>";
            }
        ?>
        </div>
        <?php if ($frontDesk) { ?>
            <div class="visit-front-desk">Please visit the front desk to arrange for payment.</div>
        <?php } ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
