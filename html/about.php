<!doctype html>
<html lang="en">

<?php
    global $convention;
    $page_name = "about";
    $page_title = "About ArmadaCon";
    include("includes/html-header.php")
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">What is ArmadaCon?</h1>

        <p>ArmadaCon is a sci-fi and fantasy multimedia convention that's been running in Plymouth since 1988.</p>

        <h3>Why Multimedia?</h3>
        <p>
            Other conventions tend to be focused one medium or one subject within that medium. We've found that
            fans find this format restrictive as most fans like more than one type of medium irrespective of subject.
        </p>

        <h3>Why do you describe yourselves as 'unconventional'?</h3>
        <p>
            Many modern conventions have become very commercialised. They're slickly presented and well polished
            events. This type of convention is now considered the norm. Fans go to these conventions to be
            entertained by the guests. ArmadaCon is completely different; most attendees come to entertain each
            other!
        </p>

        <h2>What Happens at ArmadaCon</h2>

        <p>
            There are a number of activities that have come to be regular occurrences at ArmadaCon. However,
            they tend to come and go. Not every ArmadaCon is the same! The following lists various items that
            you may encounter.
        </p>

        <!-- TODO Add a link to the programme when it's available. -->
        <!--<p align="center" class="BodyText"><a href="downloads/ArmadaCon2022ProgrammeWeb.rtf">For a copy of this-->
        <!--    years program, Click Here.</a></p>-->

        <h3>Auction</h3>
        <p>
            ArmadaCon has been supporting blind-related charities for many years. The first of these was Guide
            Dogs for the Blind; where the money we raised helped to pay for the training of two guide dogs.
            In more recent years our chosen charity has been the RNIB Talking Books service. The money we have
            raised to date has paid for the transcription of more than twelve books.
        </p>
        <p>
            We are now supporting <a href="https://www.stlukes-hospice.org.uk/home">St Luke's Hospice</a>;
            a local palliative care hospice.
        </p>
        <p>
            Unlike some other auctions, ArmadaCon's is a source of entertainment as well as a means of raising
            money! You have to experience it to understand. Just imagine the idea of people bidding to make sure
            someone else has to take home a particular item!
        </p>

        <h3>Guest Panels</h3>
        <p>
            Held throughout the weekend, guests will be holding panels where they make a presentation on a particular
            subject, then participate in a question and answer session. This is your
            opportunity to get to know the guests a little better, and the guests chance to find out what makes
            fans tick!
        </p>

        <h3>Cosplay</h3>
        <p>
            One of the great things about a con is the chance for a little sartorial showing off and seeing the
            wonderful outfits that people have created, so we will be having a hall costume competition and
            everyone is invited to take part.
        </p>

        <p>
            If you've already got something in mind, that's fantastic! But, if you're not sure, how about letting
            <a href="<?=$convention->year()?>/events/#cosplay">this year's theme</a> give you some inspiration?
        </p>

        <h3>Book Launches</h3>
        <p>
            ArmadaCon usually has an author or two in attendance, and it is not uncommon for them to have a brand-new
            book being released near the dates of the convention. To that end, they sometimes do their UK
            book launches at the convention. Any book launches will be announced on <a href="<?=$convention->year()?>/events/#book-launch">
            this year's events page</a>.
        </p>

        <h3>Quizzes and Games</h3>
        <p>
            What would a convention be without the odd quiz or game? Throughout the weekend there are
            opportunities to join in and pit your wits against the other attendees. There are team games as
            well as quizzes where you can take part as an individual.
        </p>

        <h3>Radio Plays</h3>
        <p>
            Often with a comedy element, the radio play is a relaxed introduction to the ArmadaCon
            experience! The cast members are all attendees (and often guests!); so why not get involved and
            provide a voice!
        </p>

        <h3>Table Top Gaming and RPG</h3>
        <p>
            If gaming is more your thing, then ArmadaCon has its own games room. RPG and tabletop wargames are
            run throughout the weekend.
        </p>

        <h3>Turkey Readings</h3>
        <p>
            The Turkey Readings involve the reading aloud some of the worst
            sci-fi and fantasy ever written. Attendees then bid for the reader to stop; while others bid for the
            torture to continue. All money raised goes to our charity.
        </p>
        <p>
            If you have a book or story that you think is worthy of being included in the Turkey Readings; please feel
            free to bring it. Provided it passes the strict criteria (!) it stands a good chance of being included!
        </p>

        <h3>Post Con Meal</h3>
        <p>
            The Post Con Meal rounds off the weekend in our venue's dining hall. Diners get dressed up (this is
            not obligatory, though nudity is discouraged!) and avail themselves of the menu provided. It's an
            opportunity to relax from the frantic pace of the previous 48 hours!
        </p>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
