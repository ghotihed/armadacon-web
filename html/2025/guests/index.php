<!doctype html>
<html lang="en">

<?php
    $page_name = "guests";
    $page_title = "Guests for 2024";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Guests for 2025</h1>

        <div id="james-steel" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        James Steel<br/>
                        <figure style="margin-top: 0;">
                            <img style="display: block;" alt="James Steel" src="james-steel.jpg"/>
                        </figure>
                    </td>
                    <td class="guest-info">
                        James Steel has been involved in SF and Fantasy fandom since 1984. He is a keen
                        costumer, mostly in the late 20<sup>th</sup> and early 21<sup>st</sup> Century, and has been engaged
                        for some time in that dream of many fans: writing a book. This will be his
                        first convention for some time. Be gentle.
                    </td>
                </tr>
            </table>
        </div>

        <div id="guest2" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        Guest 2<br/>
                        <figure style="margin-top: 0;">
                            <img style="display: block;" alt="Guest 2" src="/Images/guest.jpg"/>
                        </figure>
                    </td>
                    <td class="guest-info">
                        This guest has yet to be announced.
                    </td>
                </tr>
            </table>
        </div>

        <div id="guest3" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        Guest 3<br/>
                        <figure style="margin-top: 0;">
                            <img style="display: block;" alt="Guest 3" src="/Images/guest.jpg"/>
                        </figure>
                    </td>
                    <td class="guest-info">
                        This guest has yet to be announced.
                    </td>
                </tr>
            </table>
        </div>

        <div id="guest4" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        Charlotte Merrill<br/>
                        <figure style="margin-top: 0;">
                            <img style="display: block;" alt="Guest 4" src="/Images/guest.jpg"/>
                        </figure>
                    </td>
                    <td class="guest-info">
                        This guest has yet to be announced.
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
