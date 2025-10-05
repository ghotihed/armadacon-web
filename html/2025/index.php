<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $year = 2025;
    $page_name = "events";
    $page_title = "ArmadaCon $year";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>
    <?php $convention = new Convention($year); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What's On for <?=$year?>?</h1>

        <div class="content-box">
            <img src="david-harvey.jpg" alt="David A Harvey" style="width: 200px; float:right; margin-left: 5px; margin-bottom: 5px"/>
            <h3 id="welcome">Hello Folks,</h3>
            <p>
                It is my very great pleasure to welcome and say thank you for coming to ArmadaCon.
                We really hope that you're going to have a great weekend. We've worked quite hard to try and bring you a
                good selection of things to do and see, whether you are interested in the comic, the informative, the
                thought-provoking, or the practical, as well as a chance to chill with like-minded folk in the bar or
                games room.
            </p>

            <p>
                We're proud to have GoH <a href="/2025/guests/#james-steel">James Steel</a> with
                us leading our exploration and celebration of performance and costume and GoH author
                <a href="/2025/guests/#jonny-nexus">Jonny Nexus</a>, who I can't believe we're
                the first to persuade into being a con guest, to talk games, humour, and his many books.
            </p>

            <p>
                We're privileged to have Dawn Abigail as our Poet in Residence and a special viewing of
                <a href="/2025/show-and-tell">Show and Tell</a>, a fantastic exhibition of micro-fiction from Dawn and
                calligrapher / illustrator Gwyneth Hibbett, who will also be joining us on Saturday.
            </p>

            <p>
                We're also looking forward to seeing what wonderful things our amazing members are going to share with us
                in our Saturday night <span title="Cabernet?">Cabaret</span>. If you want to get involved, even if you
                don't have an act in mind, but haven't signed up yet it may still not be too late.
            </p>

            <p>
                One last thing before I sign off. Whether this is your first or your eleventy-first ArmadaCon, please may
                I ask that over the weekend you make, and take, time to:
            </p>

            <ul>
                <li>Invite and welcome people you don't know, or don't know as well as you might, into your circle of friends.</li>
                <li>Challenge yourself to do something that you haven't done before.</li>
                <li>And, most of all, please be considerate and kind to both yourself and others.</li>
            </ul>

            <p>
                Love and best wishes,<br/>
                David A Harvey (ArmadaCon Chairbeing)
            </p>
        </div>

        <div class="content-box">
            <h3 id="guests">Who</h3>
            <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $convention->year() . "/guests/guest-fragment.php")?>
        </div>

        <div class="content-box">
            <h3 id="programme">Convention Programme</h3>
            The programme for this year's convention can be found <a href="programme">here</a>.
        </div>

        <div class="content-box">
            <img src="armadacraft.jpg" alt="ArmadaCraft" style="float:right; display:inline; height:200px; margin-left:10px;">
            <h3 id="armada-craft">ArmadaCraft</h3>
            <p>
                Would you like to help make a Doctor Who blanket for Armadacon?
                It will go in the auction to raise money for the hospice.
                We need squares 8" x 8" in any colour you like.
                Double-knit thickness with 47 stitches cast on or adjust for your tension.
            </p>
            <p>
                If you would like a pattern with a TARDIS, weeping angel, Dalek or question mark, we have them available.
                Just <a href="mailto:enquiries@armadacon.org">email us</a>, and we will have it sent.
            </p>
            <p>
                No neon colours please.
            </p>
            <p>
                I hope to be inundated with requests!! You know you want to!
            </p>
        </div>

        <div class="content-box">
            <img src="cabaret.jpg" alt="Cabaret" style="float:left; display:inline; height:100px; margin-right:10px;">
            <h3 id="cabaret">Saturday Night is Cabaret Night</h3>
            One of the pillars of ArmadaCon is giving people a chance to contribute and come together to have fun.
            After a few years away, as part of our celebration of costume and performance, we're really pleased to
            announce the return of the Saturday night ArmadaCon Masquerade and Cabaret.
            We'll share more details and advice closer to the time, but if you've got a costume, sketch, short
            reading, or party piece we'd love to give you a couple of minutes in the spotlight to share it.
        </div>

        <div class="content-box">
            <img src="cosplay-1.jpg" alt="Cosplay" style="display: inline; float: left; height:175px; margin-right:10px;">
            <img src="cosplay-2.jpg" alt="Cosplay" style="display: inline; float: right; height:175px; margin-left:10px;">
            <h3 id="cosplay">Costume and Cosplay Competition</h3>
            One of the things we always enjoy&mdash;and want to celebrate and highlight this year&mdash;is our
            costumers and cosplayers. But if you want to join in, where do you start?
            How about with your take on our daily costume themes:
            <ul style="padding-left:20px;">
                <li style="position: relative; left: 20px;"><b>Friday</b>: <em>Something Scary</em> &mdash; It's Halloween so perhaps something supernatural?</li>
                <li style="position: relative; left: 20px;"><b>Saturday</b>: <em>Heroes and Villains</em> &mdash; We know whatever you do will be super&hellip;</li>
                <li style="position: relative; left: 20px;"><b>Sunday</b>: <em>Original and Reimagined</em> &mdash; Lots of shows have had a second, or third life. Go on share your favourite take with us.</li>
            </ul>
            There will be prizes!
        </div>

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
