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
    if ($_POST['submit'] === 'save') {
        $member_id = $_POST['member_id'];
        if ($member_id === logged_in_member_id() || has_permission(Permission::EDIT_MEMBER)) {
            // Take care of unchecked and unselected items.
            $_POST['agree_to_public_listing'] = isset($_POST['agree_to_public_listing']);
            if (has_permission(Permission::VIEW_MEMBER_EXT)) {
                $_POST['past_guests'] = isset($_POST['past_guests']);
                $_POST['is_admin'] = isset($_POST['is_admin']);
                if (!isset($_POST['permissions'])) { $_POST['permissions'] = array(); }
            }

            $membersTable = new MembersTable();
            $member = $membersTable->getMember($member_id);
            $member->updateFromArray($_POST);
            $membersTable->updateMember($member);
            header("Location: /account/member/view?id=$member->id");
            exit;
        }
    } elseif ($_POST['submit'] === 'edit') {
        $member_id = $_POST['member_id'];
    } elseif ($_POST['submit'] === 'cancel') {
        $member_id = $_POST['member_id'];
        header("Location: /account/member/view?id=$member_id");
    }
}

if ($member_id > 0) {
    $membersTable = new MembersTable();
    $member = $membersTable->getMember($member_id);
}

function buildPermissionsOptions(string $permissions) : string {
    $result = "";
    foreach (Permission::cases() as $permission) {
        $selected = str_contains($permissions, $permission->value) ? " selected" : "";
        $result .= "<option value='" . $permission->value . "'" . $selected . ">" . $permission->description() . "</option>";
    }
    return $result;
}

function buildMemberRow(string $label, string $id, string $value, string $input_type = "text") : string {
    $row = "<tr>";
    $row .= "<td>" . $label . "</td><td>";
    if ($input_type === "text") {
        $row .= "<input type='text' name='$id' value='$value'>";
    } elseif ($input_type === "bool") {
        $row .= "<input type='checkbox' name='$id'" . ($value ? " checked" : "") . ">";
    } elseif ($input_type === "password") {
        $row .= "<input type='password' name='$id' value='$value'>";
//    } elseif ($input_type === "email") {
//        $row .= "<input type='email' name='$id' value='$value'>";
    } elseif ($input_type === "permissions") {
        $row .= "<select name='" . $id . "[]' multiple>";
        $row .= buildPermissionsOptions($value);
        $row .= "</select>";
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

    $result .= "<h2>Edit Member Information</h2>";
    $result .= "<form action='/account/member/edit/index.php' method='post'>";
    $result .= "<input type='hidden' name='member_id' value='$member->id'>";
    $result .= "<table class='member-data' id='memberData'>";
    $result .= buildMemberRow("First Name", "first_name", $member->first_name);
    $result .= buildMemberRow("Last Name", "surname", $member->surname);
//    $result .= buildMemberRow("Email", "email", $member->email, "email");
    $result .= buildMemberRow("Address First Line", "address1", $member->address1);
    $result .= buildMemberRow("Address Second Line", "address2", $member->address2);
    $result .= buildMemberRow("City", "city", $member->city);
    $result .= buildMemberRow("Post Code", "post_code", $member->post_code);
    $result .= buildMemberRow("Country", "country", $member->country);
    $result .= buildMemberRow("Phone", "phone", $member->phone);
    $result .= buildMemberRow("Notes", "notes", $member->notes);
    $result .= buildMemberRow("Agree to Public Listing", "agree_to_public_listing", $member->agree_to_public_listing, "bool");
//    $result .= buildMemberRow("Password", $member->password, "password");
    if (has_permission(Permission::VIEW_MEMBER_EXT)) {
        $result .= buildMemberRow("Past Guest", "past_guest", $member->past_guest, "bool");
        $result .= buildMemberRow("Is Admin", "is_admin", $member->is_admin, "bool");
        if (has_permission(Permission::VIEW_PERMISSIONS)) {
            $result .= buildMemberRow("Permissions", "permissions", $member->permissions, "permissions");
        }
    }
    $result .= "</table>";

    if (logged_in_member_id() === $member->id || has_permission(Permission::EDIT_MEMBER)) {
        $result .= "<button type='submit' id='save' name='submit' value='save'>Save</button>";
    }
    $result .= "<button type='button' id='cancel' name='submit' value='cancel'>Cancel</button>";
    $result .= "</form>";

    return $result;
}
?>

<!doctype html>
<html lang="en">

<?php
    $page_name = "member";
    $page_title = "Edit ArmadaCon Member";
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
