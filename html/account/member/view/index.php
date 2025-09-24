<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

use db\EventsTable;
use db\Member;
use db\MembershipTypesTable;
use db\MembersTable;
use db\PaymentsTable;
use db\RegistrationsTable;

ensure_logged_in();

$member_id = logged_in_member_id();
$member = null;
$edit_mode = false;

if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
    if ($_POST['submit'] === 'get_info') {
        $member_id = $_POST['member_id'];
//        if ($member_id === logged_in_member_id() || has_permission(Permission::EDIT_MEMBER)) {
//            // We're good to go.
//            $edit_mode = true;
//        }
    } elseif (is_numeric($_POST['submit'])) {
        $member_id = $_POST['submit'];
    }
}

if ($member_id > 0) {
    $membersTable = new MembersTable();
    $member = $membersTable->getMember($member_id);
}

//function buildPermssionsOptions(string $permissions) {
//    $result = "";
//    foreach (Permission::cases() as $permission) {
//        $selected = str_contains($permissions, $permission->value) ? " selected" : "";
//        $result .= "<option value='" . $permission->value . "'" . $selected . ">" . $permission->description() . "</option>";
//    }
//    return $result;
//}

function buildMemberRow(string $label, string $value, string $input_type = "text") : string {
    global $edit_mode;
    $row = "<tr>";
    $row .= "<td>" . $label . "</td><td>";
//    if ($edit_mode) {
//        if ($input_type === "text") {
//            $row .= "<input type='text' name='$label' value='$value'>";
//        } elseif ($input_type === "bool") {
//            $row .= "<input type='checkbox' name='$label'" . ($value ? " checked" : "") . ">";
//        } elseif ($input_type === "password") {
//            $row .= "<input type='password' name='$label' value='$value'>";
//        } elseif ($input_type === "email") {
//            $row .= "<input type='email' name='$label' value='$value'>";
//        } elseif ($input_type === "permissions") {
//            $row .= "<select name='$label' form='memberData' multiple>";
//            $row .= buildPermssionsOptions($value);
//            $row .= "</select>";
//        }
//    } else {
        if ($input_type === "bool") {
            $row .= $value ? "True" : "False";
        } elseif ($input_type === "password") {
            $row .= $value === "" ? "" : "********";
        } else {
            $row .= $value;
        }
//    }
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
            if ($dupMember->id === $member->id) {
                $selected = "selected-member";
            }
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
        if (logged_in_member_id() === $member->id || has_permission(Permission::SET_PASSWORD)) {
            $result .= buildMemberRow("Password", $member->password, "password");
        }
        $result .= "</table>";
    }

    // Figure out where they're registered and what they've paid.
    $registrationTable = new RegistrationsTable();
    $registrations = $registrationTable->getRegistrationsForMember($member->id);
    if (count($registrations) > 0) {
        $result .= "<h2>This member is registered for the following:</h2>";
        foreach ($registrations as $registration) {
            $eventsTable = new EventsTable();
            $event = $eventsTable->getEvent($registration->event_id);

            $membershipTypesTable = new MembershipTypesTable();
            $membershipType = $membershipTypesTable->getMembershipType($registration->membership_type);

            $paymentsTable = new PaymentsTable();
            $payments = $paymentsTable->getPayments($registration->id);

//            $uid = "M$registration->for_member-E$registration->event_id-$registration->id-P$$membershipType->price";

            $result .= "<b>$event->name</b>";
            if ($registration->badge_name !== "") {
                $result .= " as \"$registration->badge_name\"";
            }
            $result .= " - $membershipType->name [£$membershipType->price]";
            $result .= "<ul>";
            if (count($payments) > 0) {
                foreach ($payments as $payment) {
                    $dt = $payment->payment_date->format('Y-m-d H:i:s');
                    $result .= "<li>$dt - Paid £$payment->amount</li>";
                }
            } else {
                $result .= "<li>No payments recorded</li>";
            }
            $result .= "</ul>";
        }
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
