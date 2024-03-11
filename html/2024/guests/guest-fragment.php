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
        echo <<<TWO_GUESTS
            <p>
                This year we have booked a number of guests. Our first two are
                <a href="{$convention->year()}/guests#jaine-fenn">Jaine Fenn</a> and
                <a href="{$convention->year()}/guests#dominic-glynn">Dominic Glynn</a>.
                Others will be announced at later dates, so stay tuned!
                Full details of all our announced guests are available on the <a href="{$convention->year()}/guests">guests page</a>.
            </p>
        TWO_GUESTS;
    }
?>
