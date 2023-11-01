<!doctype html>
<html lang="en">
<head>
    <?php
        global $convention;
        include("includes/date-variables.php")
    ?>
    <!-- In case someone has an old bookmarked link, just send them on their way -->
    <meta http-equiv="refresh" content="0; url='<?=$convention->year()?>/guests'" />
    <title>Guests</title>
</head>
<body>
    Redirecting you to the current year's guests.
</body>
</html>
