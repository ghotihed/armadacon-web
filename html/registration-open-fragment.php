<?php
    global $convention;
    global $reg_convention;
    global $is_running;
    include_once "includes/pricing.php";
?>
        <p>
            At the moment, registration is a two-part process. At some point in the future, we hope to be able to
            combine the registration form with an integrated payment platform.
        </p>

        <h3>Step 1: Fill Out a Form</h3>

        <?php if ($is_running) { ?>
            <p>You can register for the convention that's currently running, or you can pre-register for next year's convention:</p>
            <div class="form-open-button" style="margin-left: 50px;"><a href="/<?=$convention->year()?>/register">Register for <?=$convention->year()?></a></div>
            <div class="form-open-button" style="margin-left: 50px;"><a href="/<?=$reg_convention->year()?>/register">Register for <?=$reg_convention->year()?></a></div>
        <?php } else { ?>
            <p>Click the button to fill out the membership registration form:</p>
            <div class="form-open-button" style="margin-left: 50px;"><a href="/<?=$reg_convention->year()?>/register">Register for <?=$reg_convention->year()?></a></div>
        <?php } ?>

        <h3>Step 2: Payment</h3>
            <ul>
            <?php if ($is_running) { ?>
            <li><strong>If You're At the Convention</strong>
                <p>
                    Please show the registration code displayed at the end of the registration process to the registration desk.
                </p>
            </li>
            <?php } ?>
            <li><strong>Credit or Debit Card</strong>
                <p>
                    Please <a href="https://www.paypal.me/DavidAHarvey">click here</a>
                    to send payment to David A. Harvey. In the <strong>What's this payment for</strong> field,
                    be sure to include:
                </p>
                <ul style="padding-bottom: 8px">
                    <li><strong>ArmadaCon Registration</strong></li>
                    <li>The names of the people you're paying for, as they appear on the registration forms</li>
                    <li>The registration codes displayed at the end of the registration process</li>
                </ul>
                <p>
                    Note that membership applications that have not been supported by a payment within 7 days may be deleted.
                </p>
            </li>
            <li><strong>Cheques</strong>
                <p>
                    Please make cheques payable to "ArmadaCon." Send it, along
                    with your name, email address, number/type of tickets required to:
                </p>
                    <ul style="list-style-type: none; margin-bottom: 8px">
                        <li>ArmadaCon <?=$reg_convention->year()?></li>
                        <li>23 The Square</li>
                        <li>Stonehouse</li>
                        <li>Plymouth</li>
                        <li>PL1 3JX</li>
                    </ul>
                <p>
                    Please note that we may not be able to cash your cheque immediately; there may
                    be a delay before we can get to a bank, so please take this into account for your
                    finances and when waiting for confirmation.
                </p>
                <p>
                    Once the cheque has cleared, we will email you purchase confirmation.
                </p>
            </li>
            <li><strong>Instalments</strong>
                <p>
                    Payment by instalments is <em>by prior agreement only</em>.
                    A non-refundable deposit of &pound;10 will secure tickets. The balance can be
                    paid in advance or on the door.
                    <a href="mailto:registration@armadacon.org?subject=Pay by Instalments">please email</a>
                    to discuss options.
                </p>
            </li>
        </ul>

        <!-- TODO Copy the below links to the About page when it's completed. -->
        <!--<h2>Miscellaneous</h2>-->
        <!--<p>-->
        <!--    ArmadaCon has several outlets for donating and selling various items. More information can be-->
        <!--    found on the <a href="donations.php">donations page</a>.-->
        <!--</p>-->
        <!--&lt;!&ndash;<p><a href="downloads/auction_sheet.rtf">Auction Sheet</a> Form for items&ndash;&gt;-->
        <!--&lt;!&ndash;    for the Auction</p>&ndash;&gt;-->
        <!--<p>-->
        <!--    ArmadaCon occasionally has a Masquerade. Anybody who might be interested in participating should-->
        <!--    take a look at the <a href="masquerade.php">masquerade page</a>.-->
        <!--</p>-->
