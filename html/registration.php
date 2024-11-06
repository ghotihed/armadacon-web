<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include("includes/html-header.php");
    include_once("includes/pricing.php");

    function createPriceListTable(array $membership_types) : string {
        $now = Convention::now();
        $result = "<table class='price-list'><thead><tr><th>Type</th><th>Rate</th></tr></thead>";
        foreach ($membership_types as $membership_type) {
            if ($now >= $membership_type->start && $now <= $membership_type->end) {
                $result .= "<tr><td>$membership_type->name</td><td>£$membership_type->price</td></tr>";
            }
        }
        $result .= "</table>";
        return $result;
    }
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
            <?php if ($is_running): ?>
            Register for ArmadaCon <?=$convention->year()?> or <?=$reg_convention->year()?>
            <?php else: ?>
            Register for ArmadaCon <?=$reg_convention->year()?>
            <br/><?=$reg_convention->longBanner()?>
            <?php endif; ?>
        </h1>

        <div class="price-list-row">
            <?php if ($is_running): ?>
                <div class="price-list-column">
                    <div class="table-title">ArmadaCon <?=$convention->year()?> Price List</div>
                    <?php echo createPriceListTable($convention->membershipTypes()); ?>
                </div>
            <?php endif; ?>
            <div class="price-list-column">
                <div class="table-title">ArmadaCon <?=$reg_convention->year()?> Price List</div>
                <?php echo createPriceListTable($reg_convention->membershipTypes()); ?>
            </div>
        </div>

        <div class="content-box" style="padding-top: 0; padding-bottom: 0; width: 80%; margin: 8px auto 8px auto">
            <ul>
                <li>
                    Note there is a Sunday buffet that is a separate cost added on top of the cost of the membership to the
                    convention. This must be paid on-site.
                </li>
                <li>
                    Concession rates are available to anyone not in employment, retired, receiving disability
                    benefits & students. <a href="mailto:enquiries@armadacon.org?subject=Concession Rates">
                    Please email if unsure of eligibility</a>.
                </li>
            </ul>
        </div>

        <p>
            We are a family friendly convention, so children are welcome. Under 16s go
            free but remain the responsibility of an accompanying, paying adult at all times.
            Family/Group Rates, and Single Day tickets are available, please
            <a href="mailto:enquiries@armadacon.org?subject=Family Rates">email</a> to discuss
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
