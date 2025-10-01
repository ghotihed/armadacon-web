<!doctype html>
<html lang="en">

<?php
    $year = 2026;
    $page_name = "guests";
    $page_title = "Guests for $year";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Guests for <?=$year?></h1>

        <div id="mike-collins" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://www.freakhousegraphics.com/" target="_blank">
                            Mike Collins<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Mike Collins" src="mike-collins.webp"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        <p>
                        Mike Collins is an English comic book artist and writer who has worked in the comics industry
                        since the mid-1980s. He's worked on projects by major comic book studios such as Marvel Comics
                        and DC Comics. He has also worked as a storyboard artist for TV and film. He is best known
                        for his work on <em>Doctor Who</em>, <em>Good Omens</em>, and His <em>Dark Materials</em>.
                        </p>
                        <p>
                            In addition to <a href="https://www.freakhousegraphics.com/" target="_blank">his web page</a>,
                            you can also find him on
                            <a href="https://www.instagram.com/mikecollinsfreakhousegraphics" target="_blank">Instagram</a>
                            and <a href="https://www.facebook.com/MikeCollinsArt/" target="_blank">Facebook</a>.
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <?php if (false) { ?>
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
