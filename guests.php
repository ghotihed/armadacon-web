<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <link rel="stylesheet" href="ArmadaCon.css" type="text/css">
    <title>Guests</title>
</head>

<body>
    <table class="GuestsTable">
        <?php include("includes/social-media-icons.php")?>
    </table>

    <?php include("includes/countdown.php")?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Guests</h1>
        <p>
            We have yet to announce our guests. When we are ready, we'll put information here.
        </p>
        <table class="guest-table">
            <tr>
                <td>
                    <a href="#">
                        Guest1<br/>
                        <img alt="Guest #1" src="Images/guest.jpg"/>
                    </a>
                </td>
                <td>
                    <a href="#">
                        Guest2<br/>
                        <img alt="Guest #2" src="Images/guest.jpg"/>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="#">
                        Guest3<br/>
                        <img alt="Guest #3" src="Images/guest.jpg"/>
                    </a>
                </td>
                <td>
                    <a href="#">
                        Guest4<br/>
                        <img alt="Guest #4" src="Images/guest.jpg"/>
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
