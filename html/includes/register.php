<?php
    require_once __DIR__ . "/../libs/MemberRegInfo.php";

    use libs\Convention;
    use libs\MemberRegInfo;

    global $reg_year;

    function showDebugPage() : void {
        global $reg_year;
        echo "<html lang='en'><head><title>POST Processing</title></head><body>";
        echo '<a href="/' . $reg_year . '/register">Restart</a><br/><br/>';
        echo "_POST = ";
        var_dump($_POST);
        echo "<br/><br/>";

        echo "reg_info = ";
        $reg_info = MemberRegInfo::createFromArray($_POST);
        var_dump($reg_info);
        echo "</body></html>";
    }

    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        showDebugPage();
        if ($_POST['submit'] === "add") {
            // TODO
            // Add $_POST data to a session variable array
            // GET this page again
        } elseif ($_POST['submit'] === "register") {
            // TODO
            // Collect any session-saved members
            // Include the current $_POST member to the collection
            // Add them all to the database
            // Show confirmation with total amount owed
            // Send an email confirmation
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

    if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
        $reg_info = MemberRegInfo::createFromArray($_POST);
    } else {
        $reg_info = new MemberRegInfo();
    }
?>

<body>

    <link rel="stylesheet" href="/css/register.css" type="text/css">

    <main>
        <?php
            // TODO
            // Read the session variables to display the number of members 'in the basket'.
            // Include a button to submit saved members, skipping the one on this page.
        ?>
        <form action="/<?=$reg_year?>/register/index.php" method="post">
            <h1>Register for ArmadaCon <?=$reg_year?></h1>
            <?php
                $reg_info->generateInputs($reg_convention->membershipTypes());
            ?>
            <!--<button type="submit">Register</button>-->
            <button type="submit" name="submit" value="register">Register</button>
            <button type="submit" name="submit" value="add">Add Another Member</button>
        </form>
    </main>

</body>
</html>
<?php
    }
?>