<!doctype html>
<html lang="en">
<head>
    <?php include("includes/html-header.php")?>
    <title>Guests</title>
</head>
<body>
    <?php
        $page_name = "Guests";
        include("includes/header-banner.php");
    ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Guests</h1>

        <div class="content-box">
            <table class="guest-table">
                <tr id="marc-burrows">
                    <td class="guest-image">
                        <a href="https://www.marcburrows.co.uk/" target="_blank">
                            Marc Burrows<br/>
                            <img alt="Marc Burrows" src="Images/guests/marc-burrows.jpeg"/>
                        </a>
                    </td>
                    <td class="guest-info">
                        Marc Burrows is a music critic, author and occasional comedian. His biography <em>The Magic of
                        Terry Pratchett</em> won the 2021 Locus Award for Best Non-Fiction, and he writes regularly for
                        <em>New Statesman</em>, <em>The Big Issue</em>, <em>The Guardian</em>, <em>Observer</em>,
                        <em>Quietus</em> and <em>Hey U Guys</em> about music, film and pop culture. He plays bass in the
                        cult Victorian punk band The Men That Will Not Be Blamed For Nothing, and lives in North London
                        with his two cats called Zaphod & Trillian.
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
                            <img alt="Dominic Glynn" src="Images/guests/dominic-glynn.jpg"/>
                        </a>
                    </td>
                    <td class="guest-info">
                        Dominic Glynn is a composer whose career began back in 1986 when he became one of the few people
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
                <tr id="beth-webb">
                    <td class="guest-image">
                        <a href="https://bethwebb.co.uk/" target="_blank">
                            Beth Webb<br/>
                            <figure>
                                <img alt="Beth Webb" src="Images/guests/beth-webb.jpg"/>
                                <figcaption>Photograph by Vik Martin</figcaption>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        Beth Webb is an author, storyteller, and illustrator. Her <em>Star Dancer</em> quartet is about
                        the Roman invasion of Britain and the magic that prevented disaster.
                        She's performed her stories from Cameroon to Orkney, via Glastonbury Festival, and she's
                        prone to wander off to strange places to 'research new ideas.' She lives in Somerset with two
                        cats and likes drawing dragons.
                </tr>
            </table>
        </div>

        <div class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        Guest Four<br/>
                        <img alt="Guest #4" src="Images/guest.jpg"/>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
