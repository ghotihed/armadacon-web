<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "registration";
    $page_title = "ArmadaCon Registration";
    include("includes/html-header.php");

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
            Family/Group Rates and Single Day memberships are available. We can also accommodate paying
            either by cheque or in instalments.
            <a href="mailto:enquiries@armadacon.org?subject=Registration Enquiry">Please email</a> to discuss
            your specific requirements.
        </p>

        <?php if ($is_running || $convention->isPreregAvailable()) { ?>
            <?php if ($is_running) { ?>
                <p>You can register for the convention that's currently running, or you can pre-register for next year's convention:</p>
                <div class="form-open-button"><a href="/<?=$convention->year()?>/register">Register for ArmadaCon <?=$convention->year()?></a></div>
                <div class="form-open-button"><a href="/<?=$reg_convention->year()?>/register">Register for ArmadaCon <?=$reg_convention->year()?></a></div>
            <?php } else { ?>
                <div class="form-open-button"><a href="/<?=$reg_convention->year()?>/register">Register for ArmadaCon <?=$reg_convention->year()?></a></div>
            <?php } ?>
        <?php } else { ?>
            <p>
                Pre-registration for ArmadaCon <?=$convention->year()?> is now closed. You are still welcome
                to register at the door. Just turn up, and we'll be happy to have you!
            </p>
            <p>
                Registration for next year's ArmadaCon <?=$convention->year() + 1?> convention will open during this year's convention.
            </p>
        <?php } ?>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
