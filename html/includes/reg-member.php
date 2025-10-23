<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/register-utils.php";

use db\MembershipTypesTable;
use db\MembersTable;
use db\Registration;
use db\RegistrationsTable;
use libs\Convention;

global $reg_year;
$reg_email = logged_in_email();

//$reg_email = "AliDave@aol.com";     // FIXME Change this to logged_in_email().
//$reg_email = "Davidwake6@gmail.com";     // FIXME Change this to logged_in_email().
//$reg_email = "ca_armadacon@ghoti.net";     // FIXME Change this to logged_in_email().
//$reg_year = 2025;                   // FIXME Delete this hard-coded line.

$paymentResult = $_SESSION['payment_result'] ?? "";      // Just in case there was an error that returned to here.

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if ($_POST['submit'] == 'pay' || $_POST['submit'] == 'front-desk') {
        $memberIds = array();
        $membershipTypes = array();
        $badgeNames = array();
        foreach ($_POST as $key => $value) {
            if ($key !== 'submit') {
                [$keyName, $id] = explode('-', $key);
                switch ($keyName) {
                    case 'member': $memberIds[$id] = $value; break;
                    case 'membership_type': $membershipTypes[$id] = $value; break;
                    case 'badge_name': $badgeNames[$id] = htmlspecialchars(trim($value)); break;
                }
            }
        }

        // They forgot to tick any of the boxes.
        if (count($memberIds) === 0) {
            $_SESSION['payment_result'] = "You must select a member to continue.";
            header("Location: " . myCalledPath());
            exit;
        }

        $total = 0.0;
        $line_items = array();
        $_SESSION['registrations'] = array();
        $membersTable = new MembersTable();
        $membershipTypesTable = new MembershipTypesTable();

        $registeredBy = logged_in_member_id();
        foreach ($memberIds as $id => $value) {
            // This takes care of a special case if the root admin is logged in.
            if ($registeredBy === 0) {
                $registeredBy = $id;
            }

            // They forgot to select a membership type.
            if ($membershipTypes[$id] === "") {
                $_SESSION['payment_result'] = "You must select a membership type.";
                header("Location: " . myCalledPath());
                exit;
            }
            $membershipType = $membershipTypesTable->getMembershipType($membershipTypes[$id]);
            $member = $membersTable->getMember($id);
            $badgeName = $badgeNames[$id];
            $total += $membershipType->price;

            $name = $badgeName ?: $member->displayName(false);
            $line_items[] = create_line_item($name . ' - ' . $reg_year . ' ' . $membershipType->name, $membershipType->price);
            $registration = Registration::create($member, $badgeName, $membershipType);
            $registration->registered_by = $registeredBy;
            $_SESSION['registrations'][] = $registration;
        }
        $_SESSION["total"] = $total;

        if ($total == 0.0) {
            // Move directly to success.
            $_SESSION["payment_result"] = "";
            header("Location: " . myCalledPath());
            exit;
        }
        if ($_POST['submit'] == 'front-desk') {
            $_SESSION["payment_result"] = "";
            $_SESSION["front-desk"] = true;
            header("Location: " . myCalledPath());
            exit;
        }
        process_payment($reg_email, $line_items, myCalledPath(), myCalledPath());
        exit;
    } elseif ($_POST['submit'] == 'cancel') {
        unset($_SESSION['total']);
        unset($_SESSION['payment_result']);
        unset($_SESSION['front-desk']);
        unset($_SESSION['registrations']);
        header("Location: /registration.php");
    }
}

function createMemberList(string $email, int $year) : array {
    $membersTable = new MembersTable();
    $memberList = $membersTable->findMemberByEmail($email);
    $convention = new Convention($year);
    $membershipTypes = $convention->membershipTypes();
    $memberCount = count($memberList);
    $pastGuest = true;

    $memberIDs = array();
    foreach ($memberList as $member) {
        $memberIDs[] = $member->id;
    }

    // Find all members who were registered by all the members associated with the email.
    $registrationsTable = new RegistrationsTable();
    $regForList = array();
    foreach ($memberList as $member) {
        $regList = $registrationsTable->getRegistrationsByMember($member->id);
        foreach ($regList as $reg) {
            if (!in_array($reg->for_member, $memberIDs)) {
                $regForList[] = $membersTable->getMember($reg->for_member);
            }
        }
    }
    $memberList = array_merge($memberList, $regForList);

    $result = "";
    foreach ($memberList as $member) {
        $result .= "<div>";
        if ($memberCount > 1) {
            $result .= "<div><input type='checkbox' name='member-$member->id' id='member-$member->id'>";
            $result .= "<label for='member-$member->id'>" . $member->displayName() . "</label></div>";
        } else {
            $result .= "<div>";
            $result .= $member->displayName();
            $result .= "<input type='hidden' name='member-$member->id' id='member-$member->id' value='on'>";
            $result .= "</div>";
        }
        $result .= "<div>";
        $result .= "<select name='membership_type-$member->id' id='select-$member->id' onchange='onSelectChange(this.id)'>";
        if (!$member->past_guest) {
            $result .= '<option value="" disabled selected>Select a membership</option>';
        }
        $now = $convention->now();
        foreach ($membershipTypes as $membershipType) {
            if ($membershipType->start <= $now && $membershipType->end >= $now) {
                if ($member->past_guest) {
                    $is_valid = $membershipType->price === 0.0;
                } else {
                    $pastGuest = false;
                    $is_valid = $membershipType->price !== 0.0;
                }
                if ($is_valid) {
                    $result .= "<option value='$membershipType->id'>$membershipType->name £$membershipType->price</option>";
                }
            }
        }
        $result .= "</select>";
        $result .= "<input type='text' name='badge_name-$member->id' id='badge_name-$member->id' placeholder='Badge Name' onchange='onSelectChange(this.id)'>";
        $result .= "</div>";
        $result .= "</div>";
    }
    return [$pastGuest, $memberCount, $result];
}

?>
<!doctype html>
<html lang="en">

<?php
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<style>
    .member-form select {
        width: fit-content;
    }
    .member-form input[type=text] {
        width: 350px;
        margin-bottom: 20px;
    }]
</style>

<script type="text/javascript">
    function onSelectChange(selectId) {
        const myArray = selectId.split('-');
        const element = document.getElementById('member-' + myArray[1]);
        if (element) {
            element.checked = true;
        }
    }

    // TODO How about some more validation: dim the Pay buttons while enough data isn't there.
</script>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/login.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1>Registration for ArmadaCon <?=$reg_year?></h1>
        <p>
        <?php
        if ($paymentResult !== "") {
            echo '<div class="payment-error">' . $paymentResult . '</div>';
            unset($_SESSION['payment_result']);
        }

        [$pastGuest, $memberCount, $result] = createMemberList($reg_email, $reg_year);
        if ($memberCount > 1) {
            echo "There are $memberCount members associated with the email address $reg_email.";
        ?>
            Please tick each member you wish to register. For each of those, select the type of registration. Optionally, add a badge name.
        <?php } else if ($memberCount < 1) { ?>
            No members were found for this email address.
        <?php } else { ?>
            Please select the type of registration for the member. Optionally, add a badge name.
        <?php } ?>
        </p>
        <form class="member-form" method="post" action="">
            <?php if ($memberCount > 0) { ?>
                <?=$result?>
                <?php if ($pastGuest) { ?>
                    <button class="submit" name="submit" value="pay">Finish</button>
                <?php } else { ?>
                    <button class="submit" name="submit" value="pay">Finish and Pay</button>
                    <?php
                        $convention = new Convention();
                        if ($convention->isRunning()) {
                            echo '<button class="submit" name="submit" value="front-desk">Pay at Front Desk</button>';
                        }
                    ?>
                <?php } ?>
            <?php } ?>
            <button class="cancel" name="submit" value="cancel">Cancel</button>
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
