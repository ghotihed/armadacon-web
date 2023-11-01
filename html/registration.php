<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include("includes/html-header.php");
    include_once("includes/pricing.php");
?>

<body>
    <?php
        include("includes/header-banner.php");

        $is_running = $convention->isRunning();
        $reg_convention = $is_running ? new Convention($convention->year() + 1) : $convention;
    ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">
            Register for ArmadaCon <?=$reg_convention->year()?><br/>
            <?=$reg_convention->longBanner()?>
        </h1>


        <p>If you've seen enough and want to join in the fun.</p>

        <!-- Ticket table -->
        <div class="table-title">ArmadaCon <?=$reg_convention->year()?> Price List</div>
        <?php
            if ($is_running) {
                echo '<div class="price-list-change-text">Note that prices for next year are discounted while the current convention is running. At the end of the convention, some prices may change.</div>';
            }
        ?>
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
                <td>£<?=get_price($reg_convention->year(), PRICE_WEEKEND, false, $is_running)?></td>
                <td>£<?=get_price($reg_convention->year(), PRICE_WEEKEND, true, $is_running)?></td>
            </tr>
            <tr>
                <td>Single Day (Sat or Sun)</td>
                <td>£<?=get_price($reg_convention->year(), PRICE_SINGLE, false, $is_running)?></td>
                <td>£<?=get_price($reg_convention->year(), PRICE_SINGLE, true, $is_running)?></td>
            </tr>
            <tr>
                <td>Evening Only (Fri and Sat) from 6PM</td>
                <td>£<?=get_price($reg_convention->year(), PRICE_EVENING, false, $is_running)?></td>
                <td>£<?=get_price($reg_convention->year(), PRICE_EVENING, true, $is_running)?></td>
            </tr>
            <tr>
                <td>Dealers and Gamers</td>
                <td>£<?=get_price($reg_convention->year(), PRICE_DEALERS_ROOM, false, $is_running)?></td>
                <td>£<?=get_price($reg_convention->year(), PRICE_DEALERS_ROOM, true, $is_running)?></td>
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
                    Note there is a Sunday buffet that is a separate cost added on top of the cost of the membership to the
                    convention. This must be paid on-site.
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
        <?php
            if ($is_running || $convention->isPreregAvailable()) {
                include('registration-open-fragment.php');
            } else {
                include('registration-closed-fragment.php');
            }
        ?>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
