<?php
    require_once __DIR__ . "/../libs/MemberRegInfo.php";

    use libs\Convention;
    use libs\MemberRegInfo;
    use libs\MembershipType;

global $reg_year;

    function showDebugPage() : void {
        global $reg_year;
        echo "<html lang='en'><head><title>POST Processing</title></head><body>";
        echo '<a href="/' . $reg_year . '/register">Restart</a><br/><br/>';
        echo "_POST = ";
        var_dump($_POST);

        echo "reg_info = ";
        $reg_info = MemberRegInfo::createFromArray($_POST);
        $reg_info->sanitize();
        var_dump($reg_info);

        echo "_SESSION = ";
        var_dump($_SESSION);
        echo "</body></html>";
    }

    function findMembershipType(array $membership_types, int $type_id) : MembershipType {
        foreach ($membership_types as $membership_type) {
            if ($membership_type->id == $type_id) {
                return $membership_type;
            }
        }
        // TODO What if we have an error here, as unlikely as that may be.
        return $membership_types[0];
    }

    function displayMembers(array $members, Convention $reg_convention) : void {
        $total = 0.0;
        foreach ($members as $member) {
            // TODO Use stylesheet to improve display.
            $reg_info = MemberRegInfo::createFromArray($member);
            echo "<b>Name:</b> {$reg_info->first_name} {$reg_info->surname}";
            if ($reg_info->badge_name != '') {
                echo " ({$reg_info->badge_name})";
            }
            echo " &lt;{$reg_info->email}&gt;<br/>";
            if ($reg_info->phone != '') {
                echo "<b>Telephone:</b> {$reg_info->phone}<br/>";
            }
            if ($reg_info->address1 != '') {
                echo "{$reg_info->address1}<br/>";
            }
            if ($reg_info->address2 != '') {
                echo "{$reg_info->address2}<br/>";
            }
            if ($reg_info->city != '') {
                echo "{$reg_info->city}<br/>";
            }
            if ($reg_info->post_code != '') {
                echo "{$reg_info->post_code}<br/>";
            }
            $membership_type = findMembershipType($reg_convention->membershipTypes(), $reg_info->membership_type_id);
            $total += $membership_type->price;
            echo "<b>Membership Type:</b> {$membership_type->name}<br/>";
        }
        echo "<br/><br/><b>Total Owed:</b> {$total}";
    }

    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
//        showDebugPage();
        if ($_POST['submit'] == "finished") {
            // TODO
            // Add the session-saved members to the database.
            // Send an email confirmation
            $_SESSION["reg_action"] = "finished";
            header("Location: /" . $reg_year . "/register");
        } elseif ($_POST['submit'] === "register") {
            // The user has filled in the form for a member and wished to see the member list page.
            $reg_info = MemberRegInfo::createFromArray($_POST);
            $reg_info->sanitize();
            $_SESSION["reg_members"][] = $reg_info->saveToArray();
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

    $reg_action = $_SESSION['reg_action'] ?? "add_member";
    unset($_SESSION["reg_action"]);

?>

<body>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <main>
        <?php if ($reg_action === "add_member") { ?>
            <form action="/<?=$reg_year?>/register/index.php" method="post">
                <h1>Register for ArmadaCon <?=$reg_year?></h1>
                <?php
                    if (isset($_SESSION['reg_prefill'])) {
                        $reg_info = MemberRegInfo::prefillFromArray($_SESSION['reg_prefill']);
                        unset($_SESSION["reg_prefill"]);
                    } else {
                        $reg_info = new MemberRegInfo();
                    }
                    $reg_info->generateInputs($reg_convention->membershipTypes());
                ?>
                <button type="submit" name="submit" value="register">Register</button>
            </form>
        <?php } elseif ($reg_action === "show_members") { ?>
            <!-- TODO Show all the members -->
            <?php
                $reg_members = $_SESSION["reg_members"];
                displayMembers($reg_members, $reg_convention);
            ?>
            <form action="/<?=$reg_year?>/register/index.php" method="post">
                <div><label for="prefill_info"><input type="checkbox" name="prefill_info" id="prefill_info" value="true"/>Use address information for additional member.</label></div>
                <button type="submit" name="submit" value="finished">All Done</button>
                <button type="submit" name="submit" value="add">Add Another Member</button>
            </form>
        <?php } elseif ($reg_action === "finished") { ?>
            <!-- TODO Show final page with final total to pay.
                    Display a short summary with the total amount owed
            -->
            <?php
                $reg_members = $_SESSION["reg_members"];
                displayMembers($reg_members, $reg_convention);
                unset($_SESSION['reg_members']);
            ?>
        <?php } ?>
    </main>

</body>
</html>
<?php
    }
?>