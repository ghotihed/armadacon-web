<?php
    global $convention;
    if (false) {
        echo <<<FULL_GUESTS
            <p>
                This year we will have <a href="<?={$convention->year()}?>/guests#jaine-fenn">Jaine Fenn</a>,
                <a href="<?={$convention->year()}?>/guests#david-giron">David Fern&aacute;ndez Gir&oacute;n</a>,
                and <a href="<?={$convention->year()}?>/guests#charlotte-merrill">Charlotte Merrill</a>. Full details of
                all our guests are available on the <a href="<?={$convention->year()}?>/guests">guests page</a>.
            </p>
        FULL_GUESTS;
    } else {
        echo <<<ONE_GUEST
            <p>
                This year we have already booked a number of guests. The first one is
                <a href="{$convention->year()}/guests#jaine-fenn">Jaine Fenn</a>. The others will be announced
                at later dates, so stay tuned!
                Full details of all our announced guests are available on the <a href="{$convention->year()}/guests">guests page</a>.
            </p>
        ONE_GUEST;
    }
?>
