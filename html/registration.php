<!doctype html>
<html lang="en">

<?php
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include("includes/html-header.php")
?>

<body>
    <?php
        include("includes/header-banner.php");

        $con_date = strtotime($start_date);
        $now = strtotime("now");
        $diff = floor(($con_date - $now) / (60 * 60 * 24));
        if ($diff < 0) {
            include('includes/date-variables-' . ($current_year + 1) . '.php');
        }
    ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Register for ArmadaCon <?=$current_year?></h1>

        <p>If you've seen enough and want to join in the fun.</p>

        <!-- Ticket table -->
        <div class="table-title">ArmadaCon <?=$current_year?> Price List</div>
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
                <td>£<?=$price_full?></td>
                <td>£<?=$price_full_concession?></td>
            </tr>
            <tr>
                <td>Single Day (Sat or Sun)</td>
                <td>£<?=$price_single?></td>
                <td>£<?=$price_single_concession?></td>
            </tr>
            <tr>
                <td>Evening Only (Fri and Sat) from 6PM</td>
                <td>£<?=$price_evening?></td>
                <td>£<?=$price_evening_concession?></td>
            </tr>
            <tr>
                <td>Dealers and Gamers</td>
                <td>£<?=$price_dealers?></td>
                <td>£<?=$price_dealers_concession?></td>
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
        <?php
            if ($diff < $prereg_cutoff_days) {
                include('registration-closed-fragment.php');
            } else {
                include('registration-open-fragment.php');
            }
        ?>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
