<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

use db\EventsTable;
use db\MembersTable;
use db\MembershipTypesTable;
use db\RegistrationsTable;

ensure_logged_in();

$eventsTable = new EventsTable();
$events = $eventsTable->getConventionEvents();
$event_id = -1;
$info = "";

function getMemberName(array $members, int $id) : string {
    foreach ($members as $member) {
        if ($member->id == $id) {
            return $member->displayName();
        }
    }
    return "ERROR: Unknown member ID $id";
}

function isMemberRegistered(array $registrations, int $event_id, int $id) : bool {
    foreach ($registrations as $registration) {
        if ($event_id === $registration->event_id && $registration->for_member === $id) {
            return true;
        }
    }
    return false;
}

function getMembershipTypeAndPrice(array $membershipTypes, int $id) : array {
    foreach ($membershipTypes as $membershipType) {
        if ($membershipType->id == $id) {
            return [$membershipType->name, $membershipType->price];
        }
    }
    return ["ERROR: Unknown membership type ID $id", 0];
}

function getLists(int $event_id) : array {
    $membersTable = new MembersTable();
    $members = $membersTable->getAllMembers();
    $registrationsTable = new RegistrationsTable();
    $registrations = $registrationsTable->getRegistrationsForEvent($event_id);
    $membershipTypesTable = new MembershipTypesTable();
    $membershipTypes = $membershipTypesTable->getMembershipTypes($event_id);
    return [$members, $registrations, $membershipTypes];
}

function buildRegistrationList(int $event_id) : string {
    [$members, $registrations, $membershipTypes] = getLists($event_id);
    $member_count = 0;
    $duplicates = 0;
    $member_list = array();
    foreach ($registrations as $registration) {
        $displayName = getMemberName($members, $registration->for_member);
        [$membershipTypeName, $price] = getMembershipTypeAndPrice($membershipTypes, $registration->membership_type);
        $uid = "M$registration->for_member-E$event_id-R$registration->id-P$price";

        $keyName = $displayName;
        $instance = 0;
        while (array_key_exists($keyName, $member_list)) {
            $duplicates++;
            $instance++;
            $keyName = '[' . $instance . '] ' . $displayName;
        }
        $displayName = $keyName;
        $member_list[$keyName]["uid"] = $uid;
        $member_list[$keyName]["id"] = $registration->for_member;
        $member_list[$keyName]["member_name"] = $displayName;
        $member_list[$keyName]["membership_type"] = $membershipTypeName;
        $member_count++;
    }
    $print_list = "";
    foreach ($member_list as $member) {
        $print_list .= '<option value="' . $member["uid"] . '">' . $member["uid"] . " - " . $member["member_name"] . " - " . $member["membership_type"] . '</option>';
    }
    $info = "Registrations List ($member_count members, including $duplicates duplicates)";
    $info .= '<select size="' . $member_count . '" onclick="regLookup(this.value)">' . $print_list . '</select>';

    return $info;
}

function buildMemberList(int $exclude_event_id = -1) : string {
    [$members, $registrations, ] = getLists($exclude_event_id);
    usort($members, function ($a, $b) {
        return strcmp($a->displayName(), $b->displayName());
    });
    $member_list = array();
    $email_list = array();
    $print_list = "";
    $member_count = 0;
    $email_count = 0;
    $duplicates = 0;
    foreach ($members as $member) {
        if ($exclude_event_id === -1 || !isMemberRegistered($registrations, $exclude_event_id, $member->id)) {
            $displayName = $member->displayName();
            if (array_key_exists($displayName, $member_list)) {
                $duplicates++;
                $member_list[$displayName][] = $member->id;
            } else {
                $member_list[$displayName] = [$member->id];
                $print_list .= '<option value="' . $member->id . '">' . $displayName . '</option>';
                $member_count++;
            }
            if (array_key_exists($member->email, $email_list)) {
                $email_list[$member->email][] = $member->id;
            } else {
                $email_list[$member->email] = [$member->id];
                $email_count++;
            }
        }
    }
    $info = "Member List ($member_count members, $duplicates duplicates, and $email_count unique emails)";
    $info .= '<select size="' . $member_count . '" onclick="memberLookup(this.value)">' . $print_list . '</select>';
    return $info;
}

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $event_id = $_POST['event_id'];
    if ($_POST['submit'] === 'show_members') {
        $info = buildMemberList(-1);
    } elseif ($_POST['submit'] === 'show_registrations') {
        $info = buildRegistrationList($event_id);
    } elseif ($_POST['submit'] === 'show_not_registered') {
        $info = buildMemberList($event_id);
    }
}

?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "info";
    $page_title = "ArmadaCon Database Information";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Database Information</h1>

        <table style="width: 100%;">
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="event_id">Choose a convention</label>
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <select name='event_id' id='event_id'>
                                        <?php
                                        foreach ($events as $event) {
                                            echo "<option value='" . $event->id . "'";
                                            if ($event->id == $event_id) {
                                                echo " selected";
                                            }
                                            echo ">" . $event->name . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" name="submit" id="submit" value="show_registrations">Registered</button>
                                </td>
                                <td>
                                    <button type="submit" name="submit" id="submit" value="show_not_registered">Unregistered</button>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" name="submit" id="submit" value="show_members">Members</button>
                        <button type="submit" name="submit" id="submit" value="member_csv" formaction="/account/info/csv.php" formtarget="save_file"
                                <?php if ($info === "") { echo "disabled"; } ?>>Export CSV</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$info?>
                </td>
            </tr>
        </table>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>

<script>
    function memberLookup(id) {
        fetch("/account/info/member-info.php", {
            method: 'POST',
            body: JSON.stringify({
                id: id
            }),
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
            }
        })
        .then(response => response.json())
        .then(json => {
            // TODO Fill in the popup member info and display it.
            console.log(json);
            alert(JSON.stringify(json, null, 2));
        })
        .catch(error => console.error(error));
    }

    function regLookup(uid) {
        fetch("/account/info/reg-info.php", {
            method: 'POST',
            body: JSON.stringify({
                uid: uid
            }),
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
            }
        })
        .then(response => response.json())
        .then(json => {
            // TODO Fill in the popup registration info and display it.
            console.log(json);
            alert(JSON.stringify(json, null, 2));
        })
        .catch(error => console.error(error));
    }
</script>

</body>
</html>
