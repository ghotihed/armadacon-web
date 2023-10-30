<?php
require __DIR__ . '/../src/bootstrap.php';
include __DIR__ . '/../includes/date-variables.php';
require __DIR__ . '/../src/register.php';

global $errors;
global $inputs;
global $current_year;
global $price_full;
global $price_full_concession;
?>

<?php //view('header', ['title' => 'Register']) ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ArmadaCon.css">
    <link rel="stylesheet" href="/phptutorial.css">
    <title>Register</title>
</head>
<body>
<main>
<?php flash() ?>

<!--
Fields to collect:
    - Email
    - Forename
    - Surname
    - Badge Name
    - Address Line 1
    - Address Line 2
    - Post Code
    - Membership Type
        - Full weekend membership £40
        - Full weekend concession membership £35
        - Membership deposit £10 - Balance paid upon arrival
        - Previous guest
    - Tick box for 'I have read and agree to abide by the convention code of conduct and policies.'
    - Tick box for 'I understand my details will be kept in a computerised database. My information will not be shared with outside organisations.'
    --------------
    - Tick box for future communications.
    - Add membership type: Interested in future cons, but not right now
-->

<form action="/register/index.php" method="post">
<!--<form action="mailto:craiga@ghoti.net" method="post" enctype="text/plain">-->
    <h1>Register for ArmadaCon <?= $current_year ?></h1>

    <?= create_registration_form(); ?>

    <button type="submit">Register</button>

    <footer>Already a member? <a href="login.php">Login here</a></footer>

</form>

<?php view('footer') ?>

</main>
</body>
</html>