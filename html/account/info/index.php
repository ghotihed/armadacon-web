<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

use db\EventsTable;
use db\Member;
use db\MembersTable;
use db\MembershipTypesTable;
use db\PaymentsTable;
use db\RegistrationsTable;

ensure_logged_in();

$eventsTable = new EventsTable();
$events = $eventsTable->getConventionEvents();
$event_id = -1;
$info_type = "";
$info = "";
$csv_list = array();

//function getMemberName(array $members, int $id) : string {
//    foreach ($members as $member) {
//        if ($member->id == $id) {
//            return $member->displayName();
//        }
//    }
//    return "ERROR: Unknown member ID $id";
//}

function findMember(array $members, int $id) : false|Member {
    foreach ($members as $member) {
        if ($member->id == $id) {
            return $member;
        }
    }
    return false;
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

function buildRegistrationList(int $event_id, string $filter = '') : array {
    [$members, $registrations, $membershipTypes] = getLists($event_id);
    $member_count = 0;
    $duplicates = 0;
    $duplicate_list = array();
    $member_list = array();
    $csv_list = array();
    $csv_list["filename"] = "registration_list.csv";
    $csv_list["header"] = ["uid","first-name", "last-name", "badge-name", "email", "membership-type", "price", "total-paid", "has-paid"];
    $csv_list["content"] = array();
    $csv_list["sort"] = false;
    foreach ($registrations as $registration) {
        $member = findMember($members, $registration->for_member);
        if ($member) {
            $displayName = $member->displayName();
        } else {
            $displayName = "";
        }

        [$membershipTypeName, $price] = getMembershipTypeAndPrice($membershipTypes, $registration->membership_type);
        $uid = "M$registration->for_member-E$event_id-R$registration->id-P$price";

        $total_paid = 0.0;
        $paymentsTable = new PaymentsTable();
        $payments = $paymentsTable->getPayments($registration->id);
        foreach ($payments as $payment) {
            $total_paid += $payment->amount;
        }

        $keyName = $displayName;
        if (array_key_exists($keyName, $member_list)) {
            $duplicates++;
            if (!key_exists($keyName, $duplicate_list)) {
                $duplicate_list[$keyName] = 1;
            } else {
                $duplicate_list[$keyName]++;
            }
            $keyName = '[' . $duplicate_list[$keyName] . '] ' . $displayName;
        }
        $displayName = $keyName;
        $member_list[$keyName]["uid"] = $uid;
        $member_list[$keyName]["id"] = $registration->for_member;
        $member_list[$keyName]["member_name"] = $displayName;
        $member_list[$keyName]["membership_type"] = $membershipTypeName;
        $member_list[$keyName]["price"] = $price;
        $member_list[$keyName]["total_paid"] = $total_paid;
        $member_count++;

        if ($filter === '' || ($filter === 'unpaid' && $total_paid < $price)) {
            $csv_list["content"][] = [$uid, $member->first_name, $member->surname, $registration->badge_name, $member->email, $membershipTypeName, $price, $total_paid, $total_paid >= $price ? 'paid' : 'unpaid'];
        }
    }
    $print_list = "";
    foreach ($member_list as $member) {
        $paid = $member['total_paid'] >= $member['price'];
        if ($filter === '' || ($filter === 'unpaid' && !$paid)) {
            $print_list .= '<option value="' . $member["uid"] . '">' . $member["uid"] . " - " . $member["member_name"] . " - " . $member["membership_type"];
            if ($paid) {
                $print_list .= ' - PAID';
            }
            $print_list .= '</option>';
        }
    }
    $info = "Registrations List ($member_count members, including $duplicates duplicates)";
    $info .= '<select id="info" size="' . min(25, $member_count) . '"';
    if (has_permission(Permission::VIEW_REG)) {
        $info .= ' onclick="regLookup(this.value)"';
    }
    $info .= '>' . $print_list . '</select>';

    return [$info, $csv_list];
}

function buildMemberList(int $exclude_event_id = -1) : array {
    [$members, $registrations, ] = getLists($exclude_event_id);
    usort($members, function ($a, $b) {
        return strcasecmp($a->displayName(), $b->displayName());
    });
    $member_list = array();
    $email_list = array();
    $csv_list = array();
    $csv_list["filename"] = "member_list.csv";
    $csv_list["header"] = ["first-name", "last-name", "email"];
    $csv_list["content"] = array();
    $csv_list["sort"] = true;
    $print_list = "";
    $member_count = 0;
    $email_count = 0;
    $duplicates = 0;
    foreach ($members as $member) {
        if ($exclude_event_id === -1 || !isMemberRegistered($registrations, $exclude_event_id, $member->id)) {
            $displayName = $member->displayName();
            if (array_key_exists($displayName, $member_list)) {
                $duplicates++;
            }
            $member_list[$displayName] = [$member->id];
            $print_list .= '<option value="' . $member->id . '">[' . $member->id . '] ' . $displayName . '</option>';
            $member_count++;
            $csv_list["content"][] = [$member->first_name, $member->surname, $member->email];
            if (array_key_exists($member->email, $email_list)) {
                $email_list[$member->email][] = $member->id;
            } else {
                $email_list[$member->email] = [$member->id];
                $email_count++;
            }
        }
    }
    $info = "Member List ($member_count members, $duplicates duplicates, and $email_count unique emails)";
    $info .= '<select id="info" size="' . min(25, $member_count) . '"';
    if (has_permission(Permission::VIEW_MEMBER)) {
        $info .= ' onclick="memberLookup(this.value)"';
    }
    $info .= '>' . $print_list . '</select>';
    return [$info, $csv_list];
}

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $event_id = $_POST['event_id'];
    if ($_POST['submit'] === 'show_members') {
        $info_type = "members";
        [$info, $csv_list] = buildMemberList(-1);
    } elseif ($_POST['submit'] === 'show_registrations') {
        $info_type = "registrations";
        [$info, $csv_list] = buildRegistrationList($event_id);
    } elseif ($_POST['submit'] === 'show_not_registered') {
        $info_type = "members";
        [$info, $csv_list] = buildMemberList($event_id);
    } elseif ($_POST['submit'] === 'show_unpaid') {
        $info_type = "registrations";
        [$info, $csv_list] = buildRegistrationList($event_id, 'unpaid');
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
    <link rel="stylesheet" href="/css/popup.css" type="text/css">
    <script src="/java/popup.js"></script>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon Database Information</h1>

        <table style="width: 100%;">
            <tr>
                <td>
                    <form method="post" action="">
                        <?php if (has_permission(Permission::VIEW_REG_LIST)) { ?>
                            <label for="event_id">Choose a convention</label>
                            <table style="width: 600px;">
                                <tr>
                                    <td>
                                        <select name='event_id' id='event_id'>
                                            <?php
                                            usort($events, function ($a, $b) {return $a->start < $b->start;});
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
                                        <button type="submit" name="submit" id="submit" value="show_unpaid">Unpaid</button>
                                    </td>
                                    <td>
                                        <button type="submit" name="submit" id="submit" value="show_not_registered">Unregistered</button>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                        <?php if (has_permission(Permission::VIEW_MEMBER_LIST)) {?>
                            <button style="width: 600px" type="submit" name="submit" id="submit" value="show_members">Members</button>
                        <?php } ?>
                        <button style="width: 600px"  type="submit" name="submit" id="submit" value="member_csv" formaction="/account/info/csv.php" formtarget="save_file"
                                <?php if ($info === "") { echo "disabled"; } ?>>Export CSV</button>
                        <input type="hidden" id="csv_list" name="csv_list" value=<?=base64_encode(json_encode($csv_list))?> />
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

    <div class="popup-overlay" id="popupOverlay">
        <div class="popup" id="popup">
            <span class="close" id="closePopup">&times;</span>
            <div class="popup-content" id="popupContent">
                <!-- Content goes here dynamically -->
            </div>
            <?php if ($info_type === "members" && has_permission(Permission::VIEW_MEMBER)) { ?>
                <form action="/account/member/view/index.php" method="post" target="_blank">
                    <input type="hidden" id="id" name="member_id">
                    <div>
                        <button type="submit" id="actionButton" name="submit" value="get_info">Detailed Info</button>
                    </div>
                </form>
            <?php } elseif ($info_type === "registrations" && has_permission(Permission::ADD_PAYMENT)) { ?>
                <form action="/account/payment/index.php" method="post" target="_blank">
                    <input type="hidden" id="id" name="reg_uid">
                    <div>
                        <button type="submit" id="actionButton" name="submit" value="lookup_uid">Record Payment</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php") ?>

    <style>
        .data-table td {
            padding: 0 5px;
        }
    </style>

<script>
    function decodePayment(payment) {
        let result = '| ';
        for (const key in payment) {
            if (key === 'payment_date') {
                result += decodeDate(payment[key]) + ' | '
            } else {
                result += payment[key] + ' | ';
            }
        }
        return result;
    }

    function decodePayments(payments) {
        let result = ''
        for (const key in payments) {
            if (result !== '') {
                result += '<br/>';
            }
            result += decodePayment(payments[key]);
        }
        return result;
    }

    function decodeDate(date) {
        return date['date'];
    }

    function jsonToTable(json) {
        const table = document.createElement('table');
        table.className = 'data-table';
        for (const key in json) {
            const tr = document.createElement('tr');
            const tdKey = document.createElement('td');
            tdKey.appendChild(document.createTextNode(key));
            tr.appendChild(tdKey);
            const tdValue = document.createElement('td');
            if (key === 'payments') {
                tdValue.innerHTML = decodePayments(json[key]);
            } else if (key === 'created_on' || key === 'modified_on' || key === 'registration_date') {
                tdValue.innerHTML = decodeDate(json[key]);
            } else {
                tdValue.innerHTML = json[key];
            }
            tr.appendChild(tdValue);
            table.appendChild(tr);
        }
        return table;
    }

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
            // Fill in the popup member info and display it.
            const popupContent = document.getElementById('popupContent');
            popupContent.replaceChildren(jsonToTable(json));
            const idInput = document.getElementById('id');
            idInput.value = id;
            openPopup();
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
            console.log("regLookup");
            // Fill in the popup registration info and display it.
            const popupContent = document.getElementById('popupContent');
            popupContent.replaceChildren(jsonToTable(json));
            const idInput = document.getElementById('id');
            idInput.value = uid;
            openPopup();
        })
        .catch(error => console.error(error));
    }
</script>

</body>
</html>
