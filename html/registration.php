<!doctype html>
<html lang="en">

<?php
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include("includes/html-header.php")
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Tickets / Register / Downloads</h1>

        <p>If you've seen enough and want to join in the fun.</p>

        <!-- Ticket table -->
        <div class="table-title">ArmadaCon Price List</div>
        <table class="price-list">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Full</th>
                    <th title="Concession rates are available to anyone not in employment, retired, receiving disability benefits & students.">
                        Concession Rate
                    </th>
                </tr>
            </thead>
            <tr>
                <td>Full Weekend</td>
                <td>£40</td>
                <td>£35</td>
            </tr>
            <tr>
                <td>Single Day (Sat or Sun)</td>
                <td>£25</td>
                <td>£20</td>
            </tr>
            <tr>
                <td>Evening Only (Fri and Sat) from 6PM</td>
                <td>£5</td>
                <td>£5</td>
            </tr>
            <tr>
                <td>Dealers and Gamers</td>
                <td>£5</td>
                <td>£5</td>
            </tr>
<!--            <tr>-->
<!--                <td title="The Sunday buffet is a separate cost in addition to the membership cost.">Sunday Buffet</td>-->
<!--                <td>£17.50</td>-->
<!--                <td>£17.50</td>-->
<!--            </tr>-->

        </table>

        <div class="content-box" style="padding-top: 0; padding-bottom: 0; width: 80%; margin: 8px auto 8px auto">
            <ul>
                <li>
                    Note that the Sunday buffet is a separate cost added on top of the cost of the membership to the convention.
                </li>
                <li>
                    Concession rates are available to anyone not in employment, retired, receiving disability
                    benefits & students. <a href="mailto:armadacon@ghoti.net?subject=Concession Rates">
                    Please email if unsure of eligibility</a>.
                </li>
            </ul>
        </div>

        <p>
            We are a family friendly convention, so children are welcome. Under 16s go
            free but remain the responsibility of an accompanying, paying adult at all times.
            Family/Group Rates, and Single Day tickets are available, please
            <a href="mailto:armadacon@ghoti.net?subject=Family Rates">email</a> to discuss
            your specific requirements.
        </p>

        <h2>Registration</h2>
        <p>
            At the moment, registration is a two-part process. At some point in the future, we hope to be able to
            combine the registration form with an integrated payment platform.
        </p>

        <h3>Step One: Fill Out a Form</h3>

        <p>Click the button to fill out the membership registration:</p>
        <button class="form-open-button" style="margin-left: 50px" onclick="openForm()">Open Registration Form</button>
        <p>
            If you're registering more than one person, you will need to fill in the form and submit it once for
            each person. When it comes time to pay, make sure to list the names of all the people for whom you're paying.
        </p>

        <!-- The Form! -->
        <!--<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" class="form-container">-->
        <!--    <input type="hidden" name="cmd" value="_s-xclick">-->
        <!--    <input type="hidden" name="hosted_button_id" value="92XRZ7WVZNTZN">-->
        <!--    <table>-->
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <input type="hidden" name="on0" value="ArmadaCon tickets 2023">ArmadaCon tickets 2023-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <select name="os0">-->
        <!--                    <option value="Full weekend ticket">Full weekend ticket &pound;35.00 GBP</option>-->
        <!--                    <option value="Concession ticket">Concession ticket &pound;30.00 GBP</option>-->
        <!--                </select>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--    </table>-->
        <!--    <input type="hidden" name="currency_code" value="GBP">-->
        <!--    <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">-->
        <!--    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">-->
        <!--</form>-->
        <script>
            function openForm() {
                document.getElementById("registrationForm").style.display = "block";
                document.body.classList.add("no-scroll")
            }
            function closeForm() {
                document.getElementById("registrationForm").style.display = "none";
                document.body.classList.remove("no-scroll")
            }
            function validateAndCloseForm(form) {
                if (form.checkValidity()) {
                    form.submit();
                    closeForm();
                } else {
                    form.checkValidity();
                }
            }
        </script>
        <div class="screen-container" id="registrationForm">
            <div class="form-popup">
                <!--
                TODO This form should NOT be sending an email directly. Either set up PHP to handle it, or set
                 up some proper card payment processing.
                -->
                <!--<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" class="form-container">-->
                <form action="mailto:armadacon@ghoti.net?subject=ArmadaCon Registration" method="post" enctype="text/plain" class="form-container">
                    <!--<input type="hidden" name="cmd" value="_s-xclick">-->
                    <!--<input type="hidden" name="hosted_button_id" value="92XRZ7WVZNTZN">-->

                    <label for="email">Email<span class="req">*</span></label>
                    <input type="email" placeholder="Your email address" name="email" id="email" required>

                    <label for="first-name">First Name<span class="req">*</span></label>
                    <input type="text" placeholder="Your given name" name="first-name" id="first-name" required>

                    <label for="last-name">Last Name<span class="req">*</span></label>
                    <input type="text" placeholder="Your surname" name="last-name" id="last-name" required>

                    <label for="badge-name">Badge Name (if different)</label>
                    <input type="text" placeholder="Badge name" name="badge-name" id="badge-name">

                    <label for="address-first-line">First Line of Address<span class="req">*</span></label>
                    <input type="text" placeholder="First line of address" name="address-first-line" id="address-first-line" required>

                    <label for="address-second-line">Second Line of Address</label>
                    <input type="text" name="address-second-line" id="address-second-line">

                    <label for="address-post-code">Post Code<span class="req">*</span></label>
                    <input type="text" placeholder="Post code" name="address-post-code" id="address-post-code" required>

                    <label for="membership-type">Membership Type<span class="req">*</span></label>
                    <select name="membership-type" id="membership-type" required>
                        <option value="Full weekend membership">Full weekend membership £40</option>
                        <option value="Full weekend concession membership">Full weekend concession membership £35</option>
                        <option value="Membership deposit">Membership deposit £10 - Balance paid upon arrival</option>
                    </select>

                    <table style="font-size: small">
                        <tr>
                            <td style="vertical-align: center"><input type="checkbox" name="code-of-conduct-agreement" id="code-of-conduct-agreement" required></td>
                            <td style="vertical-align: center"><label for="code-of-conduct-agreement" style="font-size: small">I have read and agree to abide by <a href="policies.php" target="_new">the convention code of conduct and policies</a>.<span class="req">*</span></label></td>
                        </tr>
                    </table>

                    <table style="font-size: small">
                        <tr>
                            <td style="vertical-align: center">
                                <input type="checkbox" name="detail-understanding" id="detail-understanding" required>
                            </td>
                            <td style="vertical-align: center">
                                <label for="detail-understanding">
                                    I understand my details will be kept in a computerised database. My information will
                                    not be shared with outside organisations.<span class="req">*</span>
                                </label>
                            </td>
                        </tr>
                    </table>

                    <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
                    <button type="submit" value="Submit" class="btn" onclick="validateAndCloseForm(this.form)">Submit</button>
                </form>
            </div>
        </div>

        <h3>Step 2: Payment</h3>
        <!--<ul>-->
            <!--
            <li><p>Paypal - the quickest and easiest way is to just click on the PayPal button above. <br><br>
            As it's all a bit new, just in case you need it, here's a step by step guide:</li>
            <ul>
            <li>Log in to PayPal with your username and password</li>
            <li>Click on "My PayPal" and select the "Pay or Send Money" option</li>
            <li>Choose "Pay for Goods or Services"</li>
            <li>Add ArmadaConTickets@gmail.com into the email address box & click "next"
            (Might be easier to copy and paste that from above to be sure!)</li>
            <li>Type in the amount you want to pay, e.g. &pound;35.00 (make sure its in GBP)</li>
            <li>Click "Continue"</li>
            <li>Double check all the information is correct, then click "send money now"</li>
            <li>Whoosh! All done, tickets are purchased. Thank you. We'll email a confirmation shortly.</li>
            </ul>
            -->

            <ul>
            <li><strong>Credit or Debit Card</strong>
                <p>
                    Please <a href="https://www.paypal.me/DavidAHarvey">click here</a>
                    to send payment to David A. Harvey. In the <strong>What's this payment for</strong> field,
                    be sure to include:
                </p>
                <ul style="padding-bottom: 8px">
                    <li><strong>ArmadaCon <?=$current_year?></strong></li>
                    <li>The names of the people you're paying for, as they appear on the registration forms</li>
                    <li>Type of memberships selected on the registration forms</li>
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
                        <li>ArmadaCon <?=$current_year?></li>
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
                    <a href="mailto:armadacon@ghoti.net?subject=Pay by Instalments">please email</a>
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
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
