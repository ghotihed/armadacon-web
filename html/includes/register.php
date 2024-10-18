<!doctype html>
<html lang="en">

<?php
    use libs\Convention;
    use libs\MemberRegInfo;

    require_once __DIR__ . "/../libs/MemberRegInfo.php";

    global $reg_year;
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
        <form action="/<?=$reg_year?>/register" method="POST">
            <?php
                $reg_info->generateInputs($reg_convention->membershipTypes());
            ?>
            <button type="submit">Register</button>
        </form>
    </main>

</body>
</html>
