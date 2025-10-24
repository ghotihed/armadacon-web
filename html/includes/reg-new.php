<?php
    require_once __DIR__ . "/../libs/MemberRegInfo.php";
    require_once __DIR__ . "/../db/bootstrap.php";
    require_once __DIR__ . "/../libs/Convention.php";
    require_once __DIR__ . "/../config/MailConfig.php";
    require_once __DIR__ . "/../libs/Mailer.php";
    require_once __DIR__ . "/../libs/MailRegConfirmation.php";
    require_once __DIR__ . "/../includes/stripe-processing.php";
    require_once __DIR__ . "/../includes/register-utils.php";

//    use config\MailConfigRegistration;
//    use db\MembersTable;
//    use db\Member;
//    use db\Registration;
//    use db\RegistrationsTable;
    use libs\Convention;
//    use libs\Mailer;
//    use libs\MailRegConfirmation;
    use libs\MemberRegInfo;

    session_start();

    global $reg_year;

    if (!isset($reg_year)) {
        $uri = $_SERVER['REQUEST_URI'];
        $reg_year = intval(explode("/", $uri)[1]);
    }

    /**
     * Reads an array of new member information for STRIPE processing.
     * @param array $reg_members An array of MemberRegInfo objects representing the new members to be registered.
     * @param int $reg_year The year of the convention being registered.
     * @return void PHP processing is stopped, and this function does not return.
     */
    function process_new_member_payment(array $reg_members, int $reg_year) : void {
        $line_items = array();
        $reg_convention = new Convention($reg_year);
        $email_address = '';
        $total = 0.0;
        foreach ($reg_members as $reg_member) {
            $reg_info = MemberRegInfo::createFromArray($reg_member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            $total += $membership_type->price;
            if ($email_address === '') {
                $email_address = $reg_info->email;
            }
            $line_items[] = create_line_item($reg_info->displayName() . ' - ' . $reg_year . ' ' . $membership_type->name, $membership_type->price);
        }

        if ($total == 0.0) {
            // Move directly to success.
            $_SESSION["payment_result"] = "";
            header("Location: " . myCalledPath());
            exit;
        }

        process_payment($email_address, $line_items, myCalledPath(), myCalledPath());
    }

    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        if (isset($_POST['edit'])) {
            $_SESSION['reg_action'] = "edit_member";
            $_SESSION['reg_member_key'] = $_POST['edit'];
            header('Location: ' . myCalledPath());
        } elseif ($_POST['submit'] == "finished") {
            $reg_members = $_SESSION["reg_members"];
            process_new_member_payment($reg_members, $reg_year);
        } elseif ($_POST['submit'] == "front-desk") {
            // Simulate a successful payment and move on to successful resolution.
            $_SESSION["front-desk"] = true;
            $_SESSION["payment_result"] = "";
            header('Location: ' . myCalledPath());
            exit;
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
            header("Location: " . myCalledPath());
        } elseif ($_POST['submit'] === "add") {
            // The user has clicked the ADD button. This means they're not done, and they want
            // to add another member.
            if (isset($_POST["prefill_info"]) && isset($_SESSION["reg_members"])) {
                $reg_info = MemberRegInfo::createFromArray($_SESSION["reg_members"][0]);
                $_SESSION['reg_prefill'] = $reg_info->saveToArray();
            }
            $_SESSION['reg_action'] = "add_member";
            header("Location: " . myCalledPath());
        } elseif ($_POST['submit'] === "cancel") {
            if (isset($_SESSION["reg_members"])) {
                $_SESSION['reg_action'] = "show_members";
                header("Location: " . myCalledPath());
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

    if (isset($_SESSION['payment_result']) && $_SESSION['payment_result'] === "") {
        $reg_action = "finished";
    }
?>

<body>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <main>
        <?php
        if (!empty($_SESSION['payment_result'])) {
            echo '<div class="alert alert-error">' . $_SESSION['payment_result'] . '</div>';
        }
        unset($_SESSION['payment_result']);

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
            <form action="" method="post">
                <h1>Register for ArmadaCon <?=$reg_year?></h1>
                <h2><?=$reg_convention->longBanner()?></h2>
                <div><span class="req">*</span> Items with an asterisk are required.</div>
                <?php $reg_info->generateInputs($reg_convention); ?>
                <button class="submit" type="submit" name="submit" value="register">Register</button>
                <button class="cancel" type="submit" name="submit" value="cancel" formnovalidate>Cancel</button>
            </form>
        <?php } elseif ($reg_action === "show_members") { ?>
            <form action="" method="post">
                <?php
                    $reg_members = $_SESSION["reg_members"];
                    $total = displayMembers($reg_members, $reg_convention);
                    if ($total > 0.0) {
                        $button_label = "Finish and Pay";
                    } else {
                        $button_label = "Finish";
                    }
               ?>
                <div style="margin-top: 5px; margin-bottom: 0;"><label for="prefill_info"><input type="checkbox" name="prefill_info" id="prefill_info" value="true"/> Use address information for additional member.</label></div>
                <button style="margin-top: 0;" type="submit" name="submit" value="add">Add Another Member</button>
                <button class="cancel" style="margin-top: 25px" type="submit" name="submit" value="abandon">Cancel</button>
                <button class="submit" type="submit" name="submit" value="finished"><?=$button_label?></button>
                <?php
                $convention = new Convention();
                if ($total > 0.0 && $convention->isRunning()) {
                    echo '<button class="submit" name="submit" value="front-desk">Pay at Front Desk</button>';
                }
                ?>
            </form>
        <?php } elseif ($reg_action === "finished") { ?>
            <?php
            $frontDesk = $_SESSION['front-desk'] ?? false;
            $reg_members = $_SESSION["reg_members"];
            unset($_SESSION['front-desk']);
            unset($_SESSION['reg_members']);
            $reg_uid_list = saveRegistrationDetails($reg_members, $reg_year);
            listMembers($reg_members, $reg_convention, $reg_uid_list, $frontDesk);
            ?>
        <?php } ?>
    </main>

</body>
</html>
<?php
    }
?>