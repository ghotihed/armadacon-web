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

        <div id="jonny-nexus" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://jonnynexus.com/" target="_blank">
                            Jonny Nexus<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Jonny Nexus" src="johnny-nexus.jpg"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        Jonny Nexus has been writing SF and fantasy in various forms since creating a cult RPG humour
                        webzine, <em>Critical Miss</em>, in the late '90s. Having since self-published four novels
                        (<em>Game Night</em>, his tale of dysfunctional role-playing gods, <em>If Pigs Could Fly</em>
                        and <em>Sticks and Stones</em> of the <em>West Kensington Paranormal Detective Agency Series</em>,
                        and <em>The Sleeping Dragon</em>), he now has an agent, John Jarrold, but not yet a publishing
                        contract. He’s been attending various SF conventions since the 2008 Eastercon, Odyssey. (You
                        might well have bought a book from him.) He’s long stated that his ambition in writing is
                        neither fame nor fortune, but simply being able to describe himself as a writer without
                        feeling the need to deploy either quotes or a footnote.
                    </td>
                </tr>
            </table>
        </div>

        <?php if (false) { ?>
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
        <?php } ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
