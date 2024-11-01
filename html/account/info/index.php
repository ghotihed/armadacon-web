<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\EventsTable;
use db\Member;
use db\MembersTable;
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

function getMembershipTypeName(array $membershipTypes, int $id) : string {
    foreach ($membershipTypes as $membershipType) {
        if ($membershipType->id == $id) {
            return $membershipType->name;
        }
    }
    return "ERROR: Unknown membership type ID $id";
}

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $event_id = $_POST['event_id'];
    if ($_POST['submit'] === 'show_members') {
        $membersTable = new MembersTable();
        $members = $membersTable->getAllMembers();
        $info = "Member List<ul>";
        foreach ($members as $member) {
            $info .= "<li>" . $member->displayName() . "</li>";
        }
        $info .= "</ul>";
    } elseif ($_POST['submit'] === 'show_registrations') {
        $membersTable = new MembersTable();
        $members = $membersTable->getAllMembers();
        $registrationsTable = new RegistrationsTable();
        $registrations = $registrationsTable->getRegistrationsForEvent($event_id);
        $membershipTypesTable = new MembershipTypesTable();
        $membershipTypes = $membershipTypesTable->getMembershipTypes($event_id);
        $info = "Registrations List<ul>";
        foreach ($registrations as $registration) {
            $uid = "M$registration->for_member-E$event_id-R$registration->id-P??";
            $info .= "<li>$uid - " . getMemberName($members, $registration->for_member) . " - " . getMembershipTypeName($membershipTypes, $registration->membership_type) . "</li>";
        }
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
