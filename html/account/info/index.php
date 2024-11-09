<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\EventsTable;
use db\Member;
use db\MembersTable;
use db\MembershipType;
use db\MembershipTypesTable;
use db\RegistrationsTable;

session_start();
if (!isset($_SESSION['email'])) {
    header('location: /login.php');
}

$eventsTable = new EventsTable();
$events = $eventsTable->getConventionEvents();
$info = "Information will appear here after you press a button.";

function getMemberName(array $members, int $id) : string {
    foreach ($members as $member) {
        if ($member->id == $id) {
            return $member->displayName();
        }
    }
    return "ERROR: Unknown member ID $id";
}

function getMembershipTypeAndPrice(array $membershipTypes, int $id) : array {
    foreach ($membershipTypes as $membershipType) {
        if ($membershipType->id == $id) {
            return [$membershipType->name, $membershipType->price];
        }
    }
    return ["ERROR: Unknown membership type ID $id", 0];
}

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $event_id = $_POST['event_id'];
    if ($_POST['submit'] === 'show_members') {
        $membersTable = new MembersTable();
        $members = $membersTable->getAllMembers();
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
            $displayName = $member->displayName();
            if (array_key_exists($displayName, $member_list)) {
                $duplicates++;
                $member_list[$displayName][] = $member->id;
            } else {
                $member_list[$displayName] = [$member->id];
                $print_list .= "<li>" . $displayName . "</li>";
                $member_count++;
            }
            if (array_key_exists($member->email, $email_list)) {
                $email_list[$member->email][] = $member->id;
            } else {
                $email_list[$member->email] = [$member->id];
                $email_count++;
            }
        }
        $info = "Member List ($member_count members, $duplicates duplicates, and $email_count unique emails)<ul>";
        $info .= $print_list;
        $info .= "</ul>";
    } elseif ($_POST['submit'] === 'show_registrations') {
        $membersTable = new MembersTable();
        $members = $membersTable->getAllMembers();
        $registrationsTable = new RegistrationsTable();
        $registrations = $registrationsTable->getRegistrationsForEvent($event_id);
        $membershipTypesTable = new MembershipTypesTable();
        $membershipTypes = $membershipTypesTable->getMembershipTypes($event_id);
        $member_count = 0;
        $duplicates = 0;
        $member_list = array();
        foreach ($registrations as $registration) {
            $displayName = getMemberName($members, $registration->for_member);
            [$membershipTypeName, $price] = getMembershipTypeAndPrice($membershipTypes, $registration->membership_type);
            $uid = "M$registration->for_member-E$event_id-R$registration->id-P$price";
            if (array_key_exists($displayName, $member_list)) {
                $member_list[$displayName]["uid"] = $uid;   // Replace UID with later version
                $duplicates++;
            } else {
                $member_list[$displayName]["uid"] = $uid;
                $member_list[$displayName]["member_name"] = $displayName;
                $member_list[$displayName]["membership_type"] = $membershipTypeName;
                $member_count++;
            }
        }
        $print_list = "";
        foreach ($member_list as $member) {
            $print_list .= "<li>" . $member["uid"] . " - " . $member["member_name"] . " - " . $member["membership_type"] . "</li>";
        }
        $info = "Registrations List ($member_count members, $duplicates duplicates)<ul>";
        $info .= $print_list;
        $info .= "</ul>";
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

        <table>
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="event_id">Choose a convention</label>
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
                        <button type="submit" name="submit" id="submit" value="show_members">Members</button>
                        <button type="submit" name="submit" id="submit" value="member_csv" formaction="/account/info/csv.php" formtarget="save_file">Member List CSV</button>
                        <button type="submit" name="submit" id="submit" value="show_registrations">Registrations</button>
                    </form>
                </td>
                <td>
                    <?=$info?>
                </td>
            </tr>
        </table>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>
</body>
</html>
