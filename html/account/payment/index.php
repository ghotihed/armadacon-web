<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\EventsTable;
use db\MembershipTypesTable;
use db\MembersTable;
use db\Payment;
use db\PaymentsTable;
use db\RegistrationsTable;

session_start();
if (!isset($_SESSION['email'])) {
    header('location: /login.php');
}

/**
 * Decodes the UID generated when a member registers. The resulting array will contain
 * the following data.
 *
 *  - Member ID
 *  - Event ID
 *  - Registration ID
 *  - Price
 * @param string $uid The UID generated when a member registers.
 * @return array A breakdown of the individual IDs in the UID.
 */
function decode_uid(string $uid) : array {
    // $uid = "M$member->id-E$registration->event_id-R$registration->id-P$membership_type->price";
    $result = array();
    $ids = explode('-', $uid);
    foreach ($ids as $id) {
        $id = substr($id, 1);
        $result[] = $id;
    }
    return $result;
}

$member = null;
$event = null;
$registration = null;
$membership_type = null;
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'cancel_payment') {
        unset($_SESSION['payment_info']);
    } elseif ($_POST['submit'] === 'lookup_uid') {
        [$member_id, $event_id, $reg_id, $price] = decode_uid($_POST['reg_uid']);

        $membersTable = new MembersTable();
        $member = $membersTable->getMember($member_id);

        $eventsTable = new EventsTable();
        $event = $eventsTable->getEvent($event_id);

        $registrationsTable = new RegistrationsTable();
        $registration = $registrationsTable->getRegistration($reg_id);

        if ($registration) {
            $membershipTypesTable =  new MembershipTypesTable();
            $membership_type = $membershipTypesTable->getMembershipType($registration->membership_type);
        }

        $payment_info = array();
        $payment_info["member_id"] = $member_id;
        $payment_info["registration_id"] = $reg_id;
        $payment_info["display_name"] = $member->displayName();
        $payment_info["badge_name"] = $registration->badge_name;
        $payment_info["event_name"] = $event->name;
        $payment_info["membership_type_name"] = $membership_type->name;
        $payment_info["amount"] = $membership_type->price;
        $_SESSION["payment_info"] = $payment_info;
    } elseif ($_POST['submit'] === 'add_payment') {
        $payment_info = $_SESSION["payment_info"];
        unset($_SESSION["payment_info"]);

        $amount = $_POST['amount'];
        $payment_type = $_POST['payment_type'];
        $member_id = $payment_info['member_id'];
        $reg_id = $payment_info['registration_id'];
        $payment = new Payment();
        $payment->payer = $member_id;
        $payment->registration_id = $reg_id;
        $payment->amount = $amount;
        $payment->payment_type = $payment_type;
        $paymentsTable = new PaymentsTable();
        $success = $paymentsTable->addPayment($payment) != 0;
        $_SESSION['payment_success'] = $success;
    }
    header('location: /account/payment');
} else {
?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "account";
    $page_title = "ArmadaCon Payment";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Account Activities</h1>

        <?php
        if (isset($_SESSION['payment_info'])) {
            $payment_info = $_SESSION['payment_info'];
        ?>
            <form method="post" action="">
                <ul>
                    <li>Member: <?=$payment_info['display_name']?></li>
                    <li>Badge Name: <?=$payment_info['badge_name']?></li>
                    <li>Event: <?=$payment_info['event_name']?></li>
                    <li>Registration: <?=$payment_info['membership_type_name']?></li>
                    <li>Amount: £<?=$payment_info['amount']?></li>
                </ul>
            <div>
                <label for="amount">Amount (£)</label>
                <input type="number" name="amount" id="amount" min="0.01" step="0.01" placeholder="Enter the amount paid">
            </div>
            <div>
                <label for="payment_type">Payment Type</label>
                <input type="text" name="payment_type" id="payment_type" placeholder="Enter the type of payment (e.g., credit card, cash, etc.)">
            </div>
            <button class="submit" type="submit" name="submit" id="submit" value="add_payment">Add Payment</button>
            <button class="cancel" type="submit" name="submit" id="submit" value="cancel_payment">Cancel</button>
            </form>
        <?php
        } else {
            if (isset($_SESSION['payment_success'])) {
                $success = $_SESSION['payment_success'];
                unset($_SESSION['payment_success']);
                if ($success) {
                    echo "<div class='alert-success'>Payment registered</div>";
                } else {
                    echo "<div class='alert-error'>Unknown error registering payment</div>";
                }
            }
        ?>
        <form method="post" action="">
            <div>
                <label for="reg_uid">Reg UID</label>
                <input type="text" name="reg_uid" id="reg_uid" placeholder="Enter a registration UID">
            </div>
            <button type="submit" name="submit" id="submit" value="lookup_uid">Add Payment</button>
        </form>
        <?php
        }
        ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>
</body>
</html>
<?php } ?>