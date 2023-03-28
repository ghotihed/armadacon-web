<!doctype html>
<html lang="en">
<head>
    <?php include("includes/html-header.php")?>
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
