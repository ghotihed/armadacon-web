<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

use db\Member;
use db\MembersTable;

ensure_logged_in();

$member_id = logged_in_member_id();
$member = null;
$edit_mode = false;

if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
    if ($_POST['submit'] === 'edit_member') {
        $member_id = $_POST['member_id'];
        if ($member_id === logged_in_member_id() || has_permission(Permission::EDIT_MEMBER)) {
            // We're good to go.
            $edit_mode = true;
        }
    }
}

if ($member_id > 0) {
    $membersTable = new MembersTable();
    $member = $membersTable->getMember($member_id);
}

function buildPermssionsOptions(string $permissions) {
    $result = "";
    foreach (Permission::cases() as $permission) {
        $selected = str_contains($permissions, $permission->value) ? " selected" : "";
        $result .= "<option value='" . $permission->value . "'" . $selected . ">" . $permission->description() . "</option>";
    }
    return $result;
}

function buildMemberRow(string $label, string $value, string $input_type = "text") : string {
    global $edit_mode;
    $row = "<tr>";
    $row .= "<td>" . $label . "</td><td>";
    if ($edit_mode) {
        if ($input_type === "text") {
            $row .= "<input type='text' name='$label' value='$value'>";
        } elseif ($input_type === "bool") {
            $row .= "<input type='checkbox' name='$label'" . ($value ? " checked" : "") . ">";
        } elseif ($input_type === "password") {
            // TODO Implement this as a popup password changer.
            $row .= "<input type='password' name='$label' value='$value'>";
        } elseif ($input_type === "email") {
            $row .= "<input type='email' name='$label' value='$value'>";
        } elseif ($input_type === "permissions") {
            $row .= "<select name='$label' form='memberData' multiple>";
            $row .= buildPermssionsOptions($value);
            $row .= "</select>";
        }
    } else {
        if ($input_type === "password") {
            $value = "********";
        }
        $row .= $value;
    }
    $row .= "</td></tr>";
    return $row;
}

function buildMemberDisplay(?Member $member) : string {
    if ($member === null) {
        return "No member data available";
    }
    $result = "<table id='memberData'>";
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
    $result .= buildMemberRow("Past Guest", $member->past_guest, "bool");
    $result .= buildMemberRow("Agree to Public Listing", $member->agree_to_public_listing, "bool");
    $result .= buildMemberRow("Is Admin", $member->is_admin, "bool");
    $result .= buildMemberRow("Permissions", $member->permissions, "permissions");
    $result .= buildMemberRow("Password", $member->password, "password");
    $result .= "</table>";
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

    <!-- Main content section -->
    <div class="content">
        <!-- TODO Display $member information. If $edit_mode is true, enable editing. -->
        <?php echo buildMemberDisplay($member); ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>
</body>
</html>
