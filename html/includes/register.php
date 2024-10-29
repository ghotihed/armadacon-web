<?php
    require_once __DIR__ . "/../libs/MemberRegInfo.php";
    require_once __DIR__ . "/../db/bootstrap.php";
    require_once __DIR__ . "/../libs/Convention.php";

    use db\MembersTable;
    use db\Member;
    use db\Registration;
    use db\RegistrationsTable;
    use libs\Convention;
    use libs\MemberRegInfo;

    global $reg_year;

    $debug_no_save = false;

    function displayMembers(array $members, Convention $reg_convention) : void {
        $total = 0.0;
        foreach ($members as $key => $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            echo "<div class='member-info'>";
            echo "<table class='member-table'>";
            echo "<tr><td>First Name</td><td>$reg_info->first_name</td></tr>";
            echo "<tr><td>Last Name</td><td>$reg_info->surname</td></tr>";
            echo "<tr><td>Badge Name</td><td>$reg_info->badge_name</td></tr>";
            echo "<tr><td>Email</td><td>$reg_info->email</td></tr>";
            echo "<tr><td>Phone</td><td>$reg_info->phone</td></tr>";
            echo "<tr><td>Address #1</td><td>$reg_info->address1</td></tr>";
            echo "<tr><td>Address #2</td><td>$reg_info->address2</td></tr>";
            echo "<tr><td>City</td><td>$reg_info->city</td></tr>";
            echo "<tr><td>Postcode</td><td>$reg_info->post_code</td></tr>";
            echo "<tr><td>List publicly?</td><td>" . ($reg_info->agree_to_public_listing ? "Yes" : "No") . "</td></tr>";
            echo "<tr><td>Membership</td><td>$membership_type->name (£$membership_type->price)</td></tr>";
            echo "<tr><td colspan='2' style='text-align: center'><button type='submit' name='edit' value='$key'>Edit</button></td></tr>";
            echo "<tr><td colspan='2' style='text-align: center'><button type='submit' name='delete' value='$key'>Delete</button></td>";
            echo "</table>";
            echo "</div>";
            $total += $membership_type->price;
        }
        echo "<div><b>Total Owed:</b> £$total</div>";
    }

    function listMembers(array $members, Convention $reg_convention, array $reg_uid_list) : void {
        $total = 0.0;
        $member_display = "";
        foreach ($members as $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            $display_name = mb_strtoupper($reg_info->displayName());
            $member_display .= "<div class='multipass'><img src='/Images/multipass-template.png' alt='MULTI PASS'/><div class='multipass-name'>$display_name</div></div>";
            $total += $membership_type->price;
        }
        echo "<div class='grand-total'>Please Pay £$total</div>";
        echo "<div class='uid-list'><ul>";
        echo "<p>Please provide the following code" . (count($reg_uid_list) > 1 ? "s" : "") . " when providing payment:</p>";
        foreach ($reg_uid_list as $uid) {
            echo "<li>$uid</li>";
        }
        echo "</ul></div>";
        echo "<h1>Members registered:</h1>";
        echo "<ul>$member_display</ul>";
        echo "<form class='home-form' action='/' method='get'><button class='final-home-button'>Home</button></form>";
    }

    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if (isset($_POST['edit'])) {
            $_SESSION['reg_action'] = "edit_member";
            $_SESSION['reg_member_key'] = $_POST['edit'];
            header('Location: /' . $reg_year . '/register');
        } elseif ($_POST['submit'] == "finished") {
            $membersTable = new MembersTable();
            $registrationsTable = new RegistrationsTable();
            $reg_members = $_SESSION["reg_members"];
            $uid_list = array();
            foreach ($reg_members as $reg_member) {
                $reg_convention = new Convention($reg_year);
                $reg_info = MemberRegInfo::createFromArray($reg_member);
                $member = Member::createFromMemberRegInfo($reg_info);
                $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);

                $id = $debug_no_save ? rand(1, 500) :  $membersTable->addMember($member);
                $member->id = $id;

                $registration = Registration::createFromRegInfo($member, $reg_info, $membership_type);
                $id = $debug_no_save ? rand(1, 500) :  $registrationsTable->addRegistration($registration);
                $registration->id = $id;

                $uid = "M$member->id-E$registration->event_id-R$registration->id-P$membership_type->price";
                $uid_list[] = $uid;

                // TODO Send an email confirmation
            }
            $_SESSION["reg_uid_list"] = $uid_list;
            $_SESSION["reg_action"] = "finished";
            header("Location: /" . $reg_year . "/register");
        } elseif ($_POST['submit'] === "register") {
            // The user has filled in the form for a member and wished to see the member list page.
            $reg_info = MemberRegInfo::createFromArray($_POST);
            $reg_info->sanitize();
            if (isset($_SESSION['reg_member_key'])) {
                $reg_member_key = $_SESSION['reg_member_key'];
                unset($_SESSION['reg_member_key']);
                $_SESSION['reg_members'][$reg_member_key] = $reg_info->saveToArray();
            } else {
                $_SESSION["reg_members"][] = $reg_info->saveToArray();
            }
            $_SESSION['reg_action'] = "show_members";
            header("Location: /" . $reg_year . "/register");
        } elseif ($_POST['submit'] === "add") {
            // The user has clicked the ADD button. This means they're not done, and they want
            // to add another member.
            if (isset($_POST["prefill_info"]) && isset($_SESSION["reg_members"])) {
                $reg_info = MemberRegInfo::createFromArray($_SESSION["reg_members"][0]);
                $_SESSION['reg_prefill'] = $reg_info->saveToArray();
            }
            $_SESSION['reg_action'] = "add_member";
            header("Location: /" . $reg_year . "/register");
        } elseif ($_POST['submit'] === "cancel") {
            if (isset($_SESSION["reg_members"])) {
                $_SESSION['reg_action'] = "show_members";
                header("Location: /" . $reg_year . "/register");
            } else {
                unset($_SESSION['reg_members']);
                header("Location: /registration.php");
            }
        } elseif ($_POST['submit'] === "abandon") {
            unset($_SESSION['reg_members']);
            header("Location: /registration.php");
        }
    } else {
?>
<!doctype html>
<html lang="en">

<?php

    $page_name = "register";
    $page_title = "ArmadaCon " . $reg_year . " Registration";
    include(__DIR__ . "/../includes/html-header.php");

    $reg_convention = new Convention($reg_year);

    if (isset($_SESSION['reg_action'])) {
        $reg_action = $_SESSION['reg_action'];
    } elseif (isset($_SESSION['reg_members']) && count($_SESSION['reg_members']) > 0) {
        $reg_action = "show_members";
    } else {
        $reg_action = "add_member";
    }
    unset($_SESSION["reg_action"]);

?>

<body>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <main>
        <?php
        if ($reg_action == 'edit_member' || $reg_action == 'add_member') {
            if ($reg_action == 'edit_member') {
                $reg_member_key = $_SESSION["reg_member_key"];
                $reg_info = MemberRegInfo::createFromArray($_SESSION["reg_members"][$reg_member_key]);
            } else {
                if (isset($_SESSION['reg_prefill'])) {
                    $reg_info = MemberRegInfo::prefillFromArray($_SESSION['reg_prefill']);
                    unset($_SESSION["reg_prefill"]);
                } else {
                    $reg_info = new MemberRegInfo();
                }
            }
        ?>
            <form action="/<?=$reg_year?>/register/index.php" method="post">
                <h1>Register for ArmadaCon <?=$reg_year?></h1>
                <?php $reg_info->generateInputs($reg_convention); ?>
                <button class="submit" type="submit" name="submit" value="register">Register</button>
                <button class="cancel" type="submit" name="submit" value="cancel" formnovalidate>Cancel</button>
            </form>
        <?php } elseif ($reg_action === "show_members") { ?>
            <form action="/<?=$reg_year?>/register/index.php" method="post">
                <?php
                    $reg_members = $_SESSION["reg_members"];
                    displayMembers($reg_members, $reg_convention);
                ?>
                <div style="margin-top: 5px; margin-bottom: 0;"><label for="prefill_info"><input type="checkbox" name="prefill_info" id="prefill_info" value="true"/> Use address information for additional member.</label></div>
                <button style="margin-top: 0;" type="submit" name="submit" value="add">Add Another Member</button>
                <button class="cancel" style="margin-top: 25px" type="submit" name="submit" value="abandon">Cancel</button>
                <button class="submit" type="submit" name="submit" value="finished">All Done</button>
            </form>
        <?php } elseif ($reg_action === "finished") { ?>
            <?php
                $reg_members = $_SESSION["reg_members"];
                $reg_uid_list = $_SESSION["reg_uid_list"];
                listMembers($reg_members, $reg_convention, $reg_uid_list);
                unset($_SESSION['reg_members']);
                unset($_SESSION["reg_uid_list"]);
            ?>
        <?php } ?>
    </main>

</body>
</html>
<?php
    }
?>