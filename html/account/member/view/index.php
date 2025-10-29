<?php

@require_once $_SERVER['DOCUMENT_ROOT'] . "/config/debug.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/Convention.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/register-utils.php";

use config\MailConfigRegistration;
use db\EventsTable;
use db\Member;
use db\MembershipTypesTable;
use db\MembersTable;
use db\PaymentsTable;
use db\Registration;
use db\RegistrationsTable;
use libs\Convention;
use libs\Mailer;
use libs\MailRegConfirmation;

global $debug_no_save;

ensure_logged_in();

$member_id = logged_in_member_id();
$member = null;
$edit_mode = false;

if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
    if ($_POST['submit'] === 'get_info') {
        $member_id = $_POST['member_id'];
    } elseif (is_numeric($_POST['submit'])) {
        $member_id = $_POST['submit'];
    } elseif (str_starts_with($_POST['submit'], 'register-')) {
        $event_id = explode('-', $_POST['submit'])[1];
        $membership_type_id = $_POST["membership-" . $event_id];
        $badge_name = $_POST["badge-" . $event_id];
        $member_id = $_POST['member_id'];
        $eventsTable = new EventsTable();
        $event = $eventsTable->getEvent($event_id);
        $year = $event->start->format('Y');

        $membershipTypesTable = new MembershipTypesTable();
        $membershipType = $membershipTypesTable->getMembershipType($membership_type_id);
        $membersTable = new MembersTable();
        $member = $membersTable->getMember($member_id);
        $registration = Registration::create($member, $badge_name, $membershipType);
        $registration->registered_by = logged_in_member_id();

        $registrationsTable = new RegistrationsTable();
        $id = ($debug_no_save ?? false) ? rand(1, 500) :  $registrationsTable->addRegistration($registration);

        // Send an email confirmation
        if (!($debug_no_save ?? false)) {
            $mail_confirmation = new MailRegConfirmation($year, $member, $registration, $membershipType);
            $mailer = new Mailer(new MailConfigRegistration);
            $mailer->send_email($mail_confirmation);
        }
        header("Location: " . myCalledPath() . '?id=' . $member_id);
        exit;
    }
} else {
    $params = array();
    parse_str($_SERVER['QUERY_STRING'], $params);
    if (key_exists('id', $params)) {
        $query_id = $params['id'];
        if (is_admin() || has_permission(Permission::VIEW_MEMBER)) {
            $member_id = $query_id;
        }
    }
}

if ($member_id > 0) {
    $membersTable = new MembersTable();
    $member = $membersTable->getMember($member_id);
}

function buildMemberRow(string $label, string $value, string $input_type = "text") : string {
    $row = "<tr>";
    $row .= "<td>" . $label . "</td><td>";
    if ($input_type === "bool") {
        $row .= $value ? "True" : "False";
    } elseif ($input_type === "password") {
        $row .= $value === "" ? "" : "********";
    } elseif ($input_type === "permissions") {
        if ($value !== "") {
            $row .= "<ul>";
            foreach (Permission::cases() as $permission) {
                if (str_contains($value, $permission->value)) {
                    $row .= "<li>" . $permission->description() . "</li>";
                }
            }
            $row .= "</ul>";
        }
    } else {
        $row .= $value;
    }
    $row .= "</td></tr>";
    return $row;
}

function buildMemberDisplay(?Member $member) : string
{
    if ($member === null) {
        return "No member data available";
    }

    $result = "";

    // Gather a list of members with the same email address.
    $membersTable = new MembersTable();
    $memberList = $membersTable->findMemberByEmail($member->email);
    if (count($memberList) > 1) {
        $result .= "<h2>Found multiple members with the same email address</h2>";
        $result .= "<form class='member-switch' action='/account/member/view/index.php' method='post'>";
        foreach ($memberList as $dupMember) {
            $displayName = $dupMember->displayName();
            $result .= "<button";
            if ($dupMember->id === $member->id) {
                $result .= " class='selected-member'";
            }
            $result .= " type='submit' id='member$dupMember->id' name='submit' value='$dupMember->id'>[$dupMember->id] $displayName</button>";
        }
        $result .= "</form>";
        $result .= "<br/><p>The following information is for the one with id <b>$member->id</b>.</p>";
    }

    $result .= "<h2>General Member Information</h2>";
    $result .= "<table class='member-data' id='memberData'>";
    $result .= buildMemberRow("First Name", $member->first_name);
    $result .= buildMemberRow("Last Name", $member->surname);
    $result .= buildMemberRow("Email", $member->email, "email");
    $result .= buildMemberRow("Address First Line", $member->address1);
    $result .= buildMemberRow("Address Second Line", $member->address2);
    $result .= buildMemberRow("City", $member->city);
    $result .= buildMemberRow("Post Code", $member->post_code);
    $result .= buildMemberRow("Country", $member->country);
    $result .= buildMemberRow("Phone", $member->phone);
    $result .= buildMemberRow("Notes", $member->notes);
    $result .= buildMemberRow("Agree to Public Listing", $member->agree_to_public_listing, "bool");
    $result .= buildMemberRow("Password", $member->password, "password");
    $result .= "</table>";

    if (has_permission(Permission::VIEW_MEMBER_EXT)) {
        $result .= "<h2>Extended Member Information</h2>";
        $result .= "<table class='member-ext-data' id='memberExtData'>";
        $result .= buildMemberRow("Created On", $member->created_on->format("Y-m-d H:i:s"));
        $result .= buildMemberRow("Modified On", $member->modified_on->format("Y-m-d H:i:s"));
        $result .= buildMemberRow("Past Guest", $member->past_guest, "bool");
        $result .= buildMemberRow("Is Admin", $member->is_admin, "bool");
        if (has_permission(Permission::VIEW_PERMISSIONS)) {
            $result .= buildMemberRow("Permissions", $member->permissions, "permissions");
        }
        $result .= "</table>";
    }

    // Figure out where they're registered and what they've paid.
    $registrationTable = new RegistrationsTable();
    $eventsTable = new EventsTable();
    $membershipTypesTable = new MembershipTypesTable();
    $paymentsTable = new PaymentsTable();

    $registrations = $registrationTable->getRegistrationsForMember($member->id);
    $reg_event_ids = array();
    if (count($registrations) > 0) {
        $result .= "<h2>This member is registered for the following:</h2>";
        foreach ($registrations as $registration) {
            $reg_event_ids[] = $registration->event_id;
            $event = $eventsTable->getEvent($registration->event_id);
            $membershipType = $membershipTypesTable->getMembershipType($registration->membership_type);
            $payments = $paymentsTable->getPayments($registration->id);
            $uid = generateRegUid($member, $registration, $membershipType);

            $result .= "<table><tr><td>";
            $result .= "<b>$event->name</b>";
            if ($registration->badge_name !== "") {
                $result .= " as \"$registration->badge_name\"";
            }
            $result .= " - $membershipType->name [£$membershipType->price]";
            $result .= "<ul class='payment-list'>";
            if (count($payments) > 0) {
                foreach ($payments as $payment) {
                    $dt = $payment->payment_date->format('Y-m-d H:i:s');
                    $result .= "<li>$dt - Paid £$payment->amount</li>";
                }
            } else {
                $result .= "<li>No payments recorded</li>";
            }
            $result .= "</ul>";
            $result .= "</td><td>";
            $result .= "<form class='add-payment' action='/account/payment/index.php' target='_blank' method='post'>";
            $result .= "<input type='hidden' name='reg_uid' value='$uid'>";
            if (has_permission(Permission::ADD_PAYMENT)) {
                $result .= "<button type='submit' name='submit' value='lookup_uid'>Record Payment</button>";
            }
            $result .= "</form>";
            $result .= "<form class='member-edit' action='/account/member/view/index.php' method='post'>";
            $result .= "<input type='hidden' name='reg_id' value='$registration->id'>";
            $result .= "<button type='submit' name='submit' value='badge_name' disabled>Change Badge Name</button>";
            $result .= "<button type='submit' name='submit' value='make_payment' disabled>Make Payment</button>";
            $result .= "</form>";
            $result .= "</td></tr></table>";
        }
    }

    if (has_permission(Permission::EDIT_MEMBER)) {
        // Allow user to Register for a convention. After pushing the button, show a popup with different
        // conventions, allow the user to select the one they want, and then run to registration with
        // pre-filled entries.
        $result .= "<form class='member-edit' action='/account/member/view/index.php' method='post'>";
        $result .= "<input type='hidden' name='member_id' value='$member->id'>";
        $result .= "<table>";
        $now = Convention::now();
        $events = $eventsTable->getConventionEvents();
        foreach ($events as $event) {
            if ($event->end > $now && !in_array($event->id, $reg_event_ids)) {
                $membershipTypes = $membershipTypesTable->getMembershipTypes($event->id);
                $result .= "<tr>";
                $result .= "<td><label for='membership-$event->id'>$event->name</label></td>";
                $result .= "<td><select name='membership-$event->id' id='membership-$event->id'>";
                foreach ($membershipTypes as $membershipType) {
                    if ($membershipType->start <= $now && $membershipType->end >= $now) {
                        $result .= "<option value='$membershipType->id'>$membershipType->name £$membershipType->price</option>";
                    }
                }
                $result .= "</select></td>";
                $result .= "<td><input type='text' name='badge-$event->id' placeholder='Badge name'>";
                $result .= "<td><button type='submit' name='submit' value='register-$event->id'>Register</button></td>";
                $result .= "</tr>";
            }
        }
        $result .= "</table></form>";
    }

    if (logged_in_member_id() === $member->id || has_permission(Permission::EDIT_MEMBER)) {
        $result .= "<form class='member-edit' action='/account/member/edit/index.php' method='post'>";
        $result .= "<input type='hidden' name='member_id' value='$member->id'>";
        $result .= "<button type='submit' name='submit' value='edit'>Edit Member Info</button>";
        if (has_permission(Permission::SET_PASSWORD)) {
            $result .= "<button type='submit' name='submit' value='change_password' disabled>Change Password</button>";
        }

        $result .= "</form>";
    }

    return $result;
}
?>

<!doctype html>
<html lang="en">

<?php
    $page_name = "member";
    $page_title = "ArmadaCon Member";
include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <link rel="stylesheet" href="/css/member-form.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <?php echo buildMemberDisplay($member); ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>
</body>
</html>
