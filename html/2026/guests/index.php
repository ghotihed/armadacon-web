<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    $year = 2026;
    $page_name = "guests";
    $page_title = "Guests for $year";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php $convention = new Convention($year); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Guests for <?=$year?></h1>

        <?php if (!$convention->hasPreviousStarted()) { ?>
            <div class="content-box">
                <h3>Not Ready Yet</h3>
                <p>
                    The <?=$year?> convention's guests haven't been announced yet. Please come back once the <?=$year - 1?>
                    convention has begun.
                </p>
            </div>
        <?php } else { ?>
        <div id="mike-collins" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://www.freakhousegraphics.com/" target="_blank">
                            Mike Collins<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Mike Collins" src="mike-collins.png"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        <p>
                            Celebrating 40 years working in comics, Mike has drawn pretty much every major character at the
                            big companies&mdash;X-Men, Batman, JLA, Spider-Man, Superman, Wonder Woman, The Flash,
                            Judge Dredd, Slaine, and Rogue Trooper amongst them.
                        </p>
                        <p>
                            Best known for drawing <em>Doctor Who</em> since the show's triumphant return twenty years back for
                            <em>Doctor Who Magazine</em>, <em>IDW</em>, <em>Titan</em> and two Dalek graphic novels for BBC Books,
                            as well as writing and drawing <em>Doctor Who</em> online games for <em>Tiny Rebel</em>.
                        </p>
                        <p>
                            In animation, he's worked on shows as diverse as <em>Warhammer 40k</em>, <em>Horrid
                            Henry</em>, and many Welsh language pre-school shows.
                        </p>
                        <p>
                            He's drawn two well-regarded and successful original Graphic Novels&mdash;an adaptation of Dickens'
                            <a href="https://www.amazon.co.uk/Christmas-Carol-Graphic-Novel-Original/dp/1906332177/ref=sr_1_2" target="_blank"><em>A Christmas Carol</em></a>
                            and the docudrama about the first moon landing,
                            <a href="https://www.amazon.co.uk/Apollo-Matt-Fitch/dp/1910593508/ref=sr_1_1" target="_blank"><em>Apollo</em></a>.
                        </p>
                        <p>
                            Last year he was artist on the Mike Batt / David Quantick
                            <a href="https://www.amazon.co.uk/Croix-Noire-1-Whole-New-Day-ebook/dp/B0BNXZ43RX/ref=sr_1_1" target="_blank"><em>La Croix Noire</em></a>
                            comic tied into a concept album.
                        </p>
                        <p>
                            In recent times he's worked on several <em>How To Draw</em> books and part-works: a 100 issue run on
                            <em>How To Draw Marvel</em> magazine; 3 volumes of <em>How To Draw Fortnite</em>;
                            <em>How To Draw Five Nights at Freddies</em>; he currently illustrates the
                            <em>D&D Adventurer</em> part-work magazine.
                        </p>
                        <p>
                            In TV he works as a storyboard artist on many genre shows: <em>Doctor Who</em>, <em>Fool Me
                            Once</em>, <em>His Dark Materials</em>, <em>Good Omens</em>, <em>The Witcher</em>,
                            <em>Midwich Cuckoos</em>, <em>Lazarus Project</em>, <em>The Famous Five</em> and many more
                            with less genre cred (<em>Silent Witness</em>, <em>Grace</em>, and <em>Industry</em> to name three).
                        </p>
                        <p>
                            He is also an artist on the recent <a href="https://www.amazon.co.uk/Official-Doctor-Who-Colouring-Book/dp/1785949675/ref=asc_df_1785949675" target="_blank"><em>Official Doctor Who Adult Colouring Book</em></a>.
                        </p>
                        <p>
                            In addition to <a href="https://www.freakhousegraphics.com/" target="_blank">his web page</a>,
                            you can find him on
                            <a href="https://www.amazon.co.uk/stores/Mike-Collins/author/B0034NVYLY" target="_blank">Amazon.co.uk</a>,
                            <a href="https://www.instagram.com/mikecollinsfreakhousegraphics" target="_blank">Instagram</a>,
                            and <a href="https://www.facebook.com/MikeCollinsArt/" target="_blank">Facebook</a>.
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <div id="andy-lane" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://slowdecay.co.uk/andrewlane/" target="_blank">
                            Andy Lane<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Andy Lane" src="andy-lane.png"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        <p>
                            Andy Lane is a British author and journalist best known for the <em>Young Sherlock Holmes</em> series of Young Adult novels.
                        </p>
                        <p>
                            He has written novels in the Virgin New Adventures range and audio dramas for Big Finish based on the BBC science fiction
                            television series <em>Doctor Who</em>.
                        </p>
                        <p>
                            His Young Adult books are generally published under the name Andrew Lane, while media spin-offs are Andy Lane.
                        </p>
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
        <?php } // copied guests waiting for a rewrite ?>
        <?php } // hasPreviousStarted()?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
