<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $year = 2026;
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

        <?php if (!$convention->hasPreviousStarted()) { ?>
            <div class="content-box">
                <h3>Not Ready Yet</h3>
                <p>
                    The <?=$year?> convention is not yet ready for visitors. Please come back once the <?=$year - 1?>
                    convention has begun.
                </p>
            </div>
        <?php } else { ?>
            <div class="content-box">
                <img src="david-harvey.jpg" alt="David A Harvey" style="width: 200px; float:right; margin-left: 5px; margin-bottom: 5px"/>
                <h3 id="welcome">Hello Friends,</h3>
                <p>
                    It is my very great pleasure to welcome you to ArmadaCon 2026. As you know, it's been an
                    interesting journey, and I hope you'll forgive us if things aren't quite how you're
                    used to, and bear with us if we have to adjust things to suit the reality of being in a new hotel.
                </p>
                <p>
                    That said, we still have a fantastic line-up of stuff, both serious and silly, but always
                    interesting, which we hope you will join in with and enjoy, as well as taking time to relax and
                    catch up with friends old and new.
                </p>
                <p>
                    I'd like, if I may, to pay tribute to the committee and other volunteers who have worked
                    enormously hard and given up their free time over the last year, and especially over the last
                    couple of months, to make this weekend possible. If you could take time out to express your
                    gratitude and, when the opportunity arises, make things easier for them, I'd appreciate it.
                    Maybe you could even buy them a drink, because gosh they've earned it.
                </p>
                <p>
                    Please do take a few minutes to read through and remind yourself of our
                    <a href="/policies.php">code of conduct</a> and other
                    policies, always be excellent to one another and yourself, and dive into ArmadaCon because:
                    "Today will be an awfully big adventure, and tomorrow is a great big fish!"
                </p>
                <p>
                    All the very, very best,<br/>
                    David A Harvey<br/>
                    (ArmadaCon ChairBeing)
                </p>
            </div>
            <div class="content-box">
                <h3 id="guests">Who</h3>
                <?php include($_SERVER['DOCUMENT_ROOT'] . "/" . $year . "/guests/guest-fragment.php")?>
            </div>
            <div class="content-box">
                <h3 id="cosplay">Costume and Cosplay Competition</h3>
                <img src="cabaret.jpg" alt="Cabaret" style="float:right; display:inline; height:100px; margin-right:10px;">
                <p>
                    ArmadaCon goers <em>love</em> costumes &mdash; wearing them or seeing others in them.
                    We love costumes so much that we have <span style="font-weight: bold">two floor costume
                    competitions</span> running over Saturday and Sunday for the costumes we see wandering around the Con.
                </p>

                <h4 style="margin-bottom: 0;">Saturday</h4>
                <p>
                    There will be two different themes running on Saturday and Sunday.
                    Saturday's theme is <em>Looking Back</em>, so think historical, or perhaps costumes from old movies
                    or TV shows, or anything you interpret as fitting that theme.
                </p>

                <h4 style="margin-bottom: 0;">Sunday</h4>
                <p>
                    You can probably guess what Sunday's theme is! Yes, that's right; <em>Looking Forward</em>!
                    Costumes set in the future, perhaps from a TV show no one has seen yet, or the 28th Doctor's costume,
                    or future fashion. We've intentionally kept these themes open to allow your creativity to flow.
                </p>
                <p>
                    We're really looking forward to seeing what you create!
                </p>
            </div>
            <div class="content-box">
                <h3 id="cabaret">Masquerade and Cabaret</h3>
                <a href="/resources/armadacon-2026-masquerade-entry-form.pdf" target="_blank"><img src="/Images/application-form-icon.png" alt="form icon" style="float:left; height:75px;"></a>
                <p>
                    In addition to the hall costumes, we will also be having a cabaret/masquerade on Saturday night. There's
                    no set theme to this one. Just show up with your unique entry and any extras that might be required for
                    that entry.
                </p>
                <p>
                    Please provide us with an entry form for your entry. You can download the form here,
                    <a href="https://forms.gle/eCS5jLSN3m6J9giYA" target="_blank">fill it out online</a>, or forms
                    will be available on-site.
                </p>
                <h4 style="margin-bottom: 0;">Introduction or Voice Over</h4>
                <p>
                    If you have any specific script for the MC to announce your entry or for use during your entry,
                    please bring two (2) copies to the convention. Please bear in mind our MC will have little warning
                    of what's coming, so try and keep wording simple &mdash; the person who gave us an entry with a
                    thirteen-word name (not in English) didn't get the pronunciation they were expecting.
                </p>
                <h4 style="margin-bottom: 0;">Music Lighting Requirements</h4>
                <p>
                    Please bear in mind we are in a new venue and have no idea regarding the hotel lighting capabilities
                    &mdash; so basically you can have the lights on or the lights off when entering. Also, if you want
                    anything projected on a screen or some music, it is your responsibility to provide it in suitable
                    formats (JPEG, MP3, or MP4 files &mdash; no PowerPoint presentations).
                </p>
                <h4 style="margin-bottom: 0;">Important Information</h4>
                <p>
                    There are some important things to keep in mind:
                </p>
                <ul>
                    <li>Please keep entries reasonably short and sweet. A two-hour monologue is not going to win you
                        any friends. A maximum of two minutes is probably a good, safe limit.</li>
                    <li><b>No real weapons can be included in any entry.</b></li>
                    <li><b>No throwing of objects in any entry.</b></li>
                    <li>Bear in mind that our audience is family orientated, so costumes or dialogue should be
                        suitable for anybody to see.</li>
                </ul>
                <h4 style="margin-bottom: 0;">Masquerade Judging</h4>
                <p>
                    ArmadaCon has its own style of judging. There are typically only three regular awards. Everybody is
                    judged on <em>Style</em> and <em>Presentation</em>.
                </p>
                <ul>
                    <li><em>Style</em> &mdash; How good the costume looks.</li>
                    <li><em>Presentation</em> &mdash; How you 'sell' your costume or act.</li>
                </ul>
                <p>
                    Additionally, if this is your first time in an ArmadaCon Masquerade, you are entered into the Newbies
                    category. This is a special award to encourage people to get involved. Judges will also make
                    'special awards' for entries that strike them as needing something unique to distinguish them.
                </p>
                <h4 style="margin-bottom: 0;">Rehearsal</h4>
                <ul style="margin-top: 0;">
                    <li>There is a rehearsal on Saturday Lunchtime. Please attend, as it's our last chance to make
                        sure everybody knows what you need for your entry.</li>
                    <li>You do not need to be in costume for the rehearsal, but if you have any props, it might be
                        wise to bring them to check how they work in the room.</li>
                    <li>If you have any pictures or video or music or scripts, we will need them handed over during
                        the rehearsal so we can have everything pre-cued for you.</li>
                    <li>The running order is sorted at the rehearsal, so even if you are first at rehearsal, you might
                    not be first in the evening.</li>
                </ul>
            </div>
        <?php } ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
