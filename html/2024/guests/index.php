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
                <tr id="david-giron">
                    <td class="guest-image">
                        <a href="https://zerply.com/davidf3d" target="_blank">
                            David Fern&aacute;ndez Gir&oacute;n<br/>
                            <img alt="David Fernândez Girôn" src="david-giron.jpg"/>
                        </a>
                    </td>
                    <td class="guest-info">
                        David is a matte painter and concept artist who is locally based in Plymouth. He is known for
                        his work on <em>Man of Steel</em> (2013), <em>Solo: A Star Wars Story</em> (2018),
                        and <em>John Carter</em> (2012).
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
                        Charlotte is locally based in Plymouth who works visual effects. She is known for
                        <em>Cloverfield</em> (2008), <em>V for Vendetta</em> (2005), and <em>Ex Machina</em> (2014).
                    </td>
                </tr>
            </table>
        </div>

        <div class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        Guest Four<br/>
                        <img alt="Guest #4" src="/Images/guest.jpg"/>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
