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
        <h1 class="page-title">Guests for 2024</h1>

        <div class="content-box">
            <table class="guest-table">
                <tr id="jaine-fenn">
                    <td class="guest-image">
                        <a href="https://www.jainefenn.com/" target="_blank">
                            Jaine Fenn<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Jaine Fenn" src="jaine-fenn.jpg"/>
                                <figcaption>Photograph by James Cooke</figcaption>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        Jaine is a British Science Fiction and Fantasy writer, author of the <em>Hidden Empire</em>
                        series of space opera novels and the <em>Shadowlands</em> science fantasy duology.
                        Her short stories have appeared in numerous anthologies and magazines and been recognised with
                        the BSFA Short Fiction Award. She has also written for Warhammer (<em>Age of
                        Sigmar</em>) and <em>Dr Who</em> (Big Finish) and for video-games in the <em>Halo</em> and
                        <em>Total War</em> franchises.
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-box">
            <table class="guest-table">
                <tr id="dominic-glynn">
                    <td class="guest-image">
                        <a href="http://dominic-glynn.com/" target="_blank">
                            Dominic Glynn<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Dominic Glynn" src="dominic-glynn.jpg"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        After having to cancel in 2023, Dominic Glynn is back for 2024.
                        He is a composer whose career began back in 1986 when he became one of the few people
                        to arrange the theme tune to the classic TV series <em>Doctor Who</em>. He reworked the famous
                        theme that accompanied Colin Baker's Doctor, and composed incidental music for the series
                        throughout the late 1980s. As one of Britain's most prolific composers of production music, his
                        work can also be heard in hundreds of films and TV productions worldwide, as diverse as
                        <em>The Simpsons</em>, <em>Red Dwarf</em>, and <em>Dead Like Me</em>. He scored music for video
                        games, performed live at the London's Royal Festival Hall, collaborated with video artists, and
                        released records of electronic dance music.
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-box">
            <table class="guest-table">
                <tr id="david-giron">
                    <td class="guest-image">
                        <a href="https://davidf3d.com/" target="_blank">
                            David Fern&aacute;ndez Gir&oacute;n<br/>
                            <img alt="David Fernândez Girôn" src="david-giron.jpg"/>
                        </a>
                    </td>
                    <td class="guest-info">
                        David is an experienced artist and traditional painter with 18+ years of experience in broadcast
                        and films. He is known for his work on <em>Man of Steel</em> (2013), <em>Solo: A Star Wars
                        Story</em> (2018), and <em>John Carter</em> (2012). He is locally based in Plymouth.
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-box">
            <table class="guest-table">
                <tr id="charlotte-merrill">
                    <td class="guest-image">
                        <a href="https://www.imdb.com/name/nm2086790/?ref_=fn_al_nm_1" target="_blank">
                            Charlotte Merrill<br/>
                            <img alt="Charlotte Merrill" src="/Images/guest.jpg"/>
                        </a>
                    </td>
                    <td class="guest-info">
                        Charlotte is locally based in Plymouth and works on visual effects. She is known for
                        <em>Cloverfield</em> (2008), <em>V for Vendetta</em> (2005), and <em>Ex Machina</em> (2014).
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
