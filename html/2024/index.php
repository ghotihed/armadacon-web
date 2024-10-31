<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "events";
    $page_title = "ArmadaCon 2024";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php $convention = new Convention(2024); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for 2024?</h1>

        <div class="content-box">
            <h3 id="guests">Who</h3>
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $convention->year() . "/guests/guest-fragment.php")?>
        </div>

        <div class="content-box">
            <h3 id="programme">Convention Programme</h3>
            The programme for this year's convention can be found <a href="programme">here</a>.
        </div>

        <div class="content-box">
            <h3 id="menu">Convention Menu</h3>
            A special <a href="/2024/menu">menu</a> have been crafted for ArmadaCon attendees.
        </div>

        <!--<div class="content-box">-->
        <!--    <h3 id="cosplay">Cosplay</h3>-->
        <!--    We haven't worked out a theme for this year's convention. Do you have any ideas?-->
        <!--</div>-->

        <div class="content-box">
            <h3 id="book-launch">Books</h3>
            This year we're featuring a book by Luca and Emily Carrington.
            <table class="book-launch">
                <tr>
                    <td>
                        <a href="https://www.amazon.co.uk/Castaways-Terrene-Luca-V-Carrington/dp/3591140988" target="_blank">
                            <img src="https://m.media-amazon.com/images/I/61F7-8cIvHL.jpg" alt="The Castaways of Terrene"/>
                        </a>
                    </td>
                    <td>
                        <div class="book-launch-title">The Castaways of Terrene</div>
                        <div class="book-launch-author">by Luca V Carrington and Emily L Carrington</div>
                        <div class="book-launch-description">
                            <p>
                                Three teenagers - a shy autistic boy, an immigrant jock, and the girl next door caught between them, with the unlikely company of a pet chicken (yes, really a chicken!) - are sucked into a portal and flung onto a desolate alien planet of cerise rock. Their only shelter in this barren world is a curious lonely house, if they have any hope of returning home via the alien portal that brought them here, they must survive a mysterious, and treacherous, adventure.
                            </p>

                            <p>
                                At first the teens clash but as they embark on a riveting treasure hunt filled with riddles, clues, and puzzles, they learn to trust one another and grow together. This is a tale of friendship, bravery, and determination, as our young heroes face the unknown, and discover their true selves. Welcome to their extraordinary journey across the stars, the story of: The Castaways of Terrene.
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="the-jackdaws-choice.jpg" alt="The Jackdaw's Choice book cover"/>
                    </td>
                    <td>
                        <div class="book-launch-title">The Jackdaw's Choice</div>
                        <div class="book-launch-author">by David Wake</div>
                        <div class="book-launch-description">
                            <b>Something Special<br/>Exclusive to ArmadaCon</b>
                            <p>
                                David Wake has launched many of his books at ArmadaCon starting with <em>The Derring-Do Club and the Empire of the Dead</em> back in 2013.  This year he brings a limited edition, printed specially for ArmadaCon.  The first in a new fantasy trilogy.
                            </p>
                            <p>
                                When the goblins raid her village, Mara is chosen to lead everyone to safety.  But as the struggle to escape takes its toll, she is given a centuries old ‘gift’ that comes at a terrible cost.
                            </p>
                            <p>
                                Elsewhere, an evil that hides behind a mask gathers its armies.
                            </p>
                            <p>
                                To survive, Mara is forced to make an unlikely ally&hellip;
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
