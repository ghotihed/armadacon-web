<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "events";
    $page_title = "ArmadaCon 2025";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php $convention = new Convention(2025); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for 2025?</h1>

        <div class="content-box">
            <h3 id="guests">Who</h3>
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $convention->year() . "/guests/guest-fragment.php")?>
        </div>

        <div class="content-box">
            <h3 id="programme">Convention Programme</h3>
            The programme for this year's convention can be found <a href="programme">here</a>.
        </div>

        <!--<div class="content-box">-->
        <!--    <h3 id="cosplay">Cosplay</h3>-->
        <!--    We haven't worked out a theme for this year's convention. Do you have any ideas?-->
        <!--</div>-->

        <div class="content-box">
            <h3 id="show-and-tell">Show &amp; Tell</h3>
            Our poet in residence, Dawn Abigail, is having a special exhibition of <em>Show & Tell</em> micro-fiction
            developed in partnership with calligrapher and illustrator Gwyneth Hibbett. Find out more
            <a href="show-and-tell">here</a>.
        </div>

        <div class="content-box">
            <h3 id="book-launch">Books</h3>
            This year is a bumper crop with three books being featured.
            <table class="book-launch">
                <tr>
                    <td>
                        <a href="https://www.amazon.co.uk/Devons-Forgotten-Witches-Tracey-Norman/dp/1803994215" target="_blank">
                            <img src="devons-forgotten-witches.jpg" alt="Devon's Forgotten Witches">
                        </a>
                    </td>
                    <td>
                        <div class="book-launch-title">Devon's Forgotten Witches 1860-1910</div>
                        <div class="book-launch-author">by Tracey Norman &amp; Mark Norman</div>
                        <div class="book-launch-description">
                            This book explores some of Devon's Victorian and Edwardian witchcraft cases, looking at how they were reported in the press, and showing the perpetuity of belief and tradition in an era when those in authority would have us believe such practices no longer existed. Woven in between the sincere practitioners are tales of fraud, violence and murder. What was really happening in that fifty-year period? How were the public urged to view these cases? The retelling of these stories gives a voice to those whom the historical record has silenced.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="the-crows-law.png" alt="The Crow's Law">
                    </td>
                    <td>
                        <div class="book-launch-title">The Crow's Law</div>
                        <div class="book-launch-author">by David Wake</div>
                        <div class="book-launch-description">
                            <p>
                                <em>The Crow’s Law</em> continues the spellbinding <em>Daughters of Égraine</em> trilogy launched at ArmadaCon last year.  This year’s is a limited edition too.
                            </p>
                            <p>
                                <b>Can an elven, a wise woman and a goblin save the world of men and defeat the darkness?</b>
                            </p>
                            <p>
                                As the pact between the elven and men hangs in the balance, Mara finds a man murdered and realises that they have a traitor.  She must call upon all her courage again to discover the truth before they are all betrayed.  But terrifying monsters, religious hatred and an army of goblins stand in her way.
                            </p>
                            <p>
                                Can she survive the fall before she can rise again?  Her growing powers seem more of a curse than a blessing, and her own prophecy may be her downfall.
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="a-dragon-in-the-title.png" alt="A Dragon In The Title">
                    </td>
                    <td>
                        <div class="book-launch-title">A Dragon In The Title</div>
                        <div class="book-launch-author">by J. R. Steel and David Wake</div>
                        <div class="book-launch-description">
                            <p>
                                Guest J. R. Steel and former guest David Wake’s epic tale 42 years in the writing!
                            </p>
                            <p>
                                The trilogy is launched this year at ArmadaCon in a limited first printing edition.
                            </p>
                            <p>
                                <b>The Hero’s Journey beckons&hellip;</b>
                            </p>
                            <p>
                                Martin Ravenhead is the world’s leading expert on the greatest unfinished fantasy epic of all time (according to Martin).  But can he find the last book in the series?
                            </p>
                            <p>
                                Meanwhile, Milo leads the forces of good against the evil Baron Yargpitt. Can he find his mentor and win the heart of the beautiful princess?
                            </p>
                            <p>
                                The odds stacked against him and his Merry Men, there is literally no happy ending&hellip;
                            </p>
                            <p style="float: right;">
                                &hellip;or ending of any literary kind!
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
