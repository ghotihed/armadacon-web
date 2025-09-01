<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/member-utils.php';

use db\Payment;
use db\PaymentsTable;

ensure_logged_in();

$member = null;
$event = null;
$registration = null;
$membership_type = null;
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'cancel_payment') {
        unset($_SESSION['payment_info']);
    } elseif ($_POST['submit'] === 'lookup_uid') {
        [$member, $event, $registration, $membership_type, $payment] = get_reg_info($_POST['reg_uid']);

        $payment_info = array();
        $payment_info["member_id"] = $member->id;
        $payment_info["registration_id"] = $registration->id;
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