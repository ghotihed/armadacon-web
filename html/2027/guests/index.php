<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    $year = 2027;
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
        <div id="fd-lee" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://www.fdlee.co.uk/" target="_blank">
                            F.D. Lee<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="F.D. Lee" src="fd-lee-stylish-hat.png"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        <p>
                            F.D. Lee is the author of the internationally bestselling fantasy series <em>The Pathways Tree</em>
                            and the award-winning SF novel <em>In the Slip</em>.
                        </p>
                        <p>
                            A life-long fantasy and science fiction fan, F.D. Lee is an advocate of self- and
                            indie-publishing and has a PhD in English Literature and Creative Writing. She has been
                            featured in <em>The Independent</em>, appeared on Radio 4 to talk about her research
                            in genre fiction, and has given a mini-TED talk on why stories matter.
                        </p>
                        <p>
                            F.D. Lee is online and always happy to chat! You can find her on various socials with
                            the handle <b>@fdleeauthor</b>. She can also be found on <a href="https://linktr.ee/fdlee" target="_blank">LinkTree</a>.
                            Visit <a href="https://www.fdlee.co.uk/" target="_blank">her web page</a> to learn more
                            and read free sample chapters of her novels.
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <div id="chris-oshea" class="content-box">
            <table class="guest-table">
                <tr>
                    <td class="guest-image">
                        <a href="https://fancyclopedia.org/wiki/Chris_O%27Shea" target="_blank">
                            Chris O'Shea<br/>
                            <figure style="margin-top: 0;">
                                <img style="display: block;" alt="Chris O'Shea" src="chris-oshea-bunny-ears.png"/>
                            </figure>
                        </a>
                    </td>
                    <td class="guest-info">
                        <p>
                            Singer, musician, <del>brain surgeon</del>, <del>comic book superhero</del>,
                            owner of an immense collection of guitars, and irrepressible punster, Chris O'Shea has been
                            an active and enthusiastic member of science fiction and filk fandom since discovering it
                            in the '80's (the 1980's he assures us) both on the organising side and performing sides.
                        </p>
                        <p>
                            We've managed to tempt him back to ArmadaCon as our performance guest to share his
                            enthusiasm for music, in general, and science fiction song, in particular. As well as that,
                            while he's with us, we may also be able to persuade him to explain why he's known as
                            The Magician, and share some of his counter-hoarding secrets garnered leading a
                            decluttering support group. But we probably won't be able to get him to contain his
                            irrepressible good humour and fondness for word play.
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
