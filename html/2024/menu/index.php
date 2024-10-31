<!doctype html>
<html lang="en">

<?php
    use libs\Convention;

    global $convention;
    $page_name = "events";
    $page_title = "ArmadaCon 2024 Menu";
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/food-menu.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon 2024 Menu</h1>

        <p>
            In addition to the standard fare available at the Fishbone restaurant, there is a special menu that
            is designed to make things faster for the ArmadaCon attendees to get their food during our short breaks.
        </p>

        <div class="food-menu">
            <div class="food-menu-heading">Saturday 2<sup>nd</sup> November Lunch</div>
            <div class="food-menu-sub-heading">(£10.00 per person)</div>
            <ul>
                <li>Hunters Chicken</li>
                <li>Vegetable Curry</li>
                <li>Cod Goujons</li>
                <li><em>Served with a choice of rice or chips</em></li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Saturday 2<sup>nd</sup> November Evening</div>
            <div class="food-menu-sub-heading">(£12.00 per person)</div>
            <ul>
                <li>Beef Chilli</li>
                <li>Vegetable Lasagne</li>
                <li>Fish Pie</li>
                <li><em>Served with rice, new potatoes, garlic bread and a selection of vegetables</em></li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Sunday 3<sup>rd</sup> November Lunch</div>
            <div class="food-menu-sub-heading">(£16.00 per person)</div>
            <ul>
                <li>Carvery</li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Sunday 3<sup>rd</sup> November Evening</div>
            <div class="food-menu-sub-heading">(£19.00 per person)</div>
            <ul>
                <li>Sandwiches and Wraps</li>
                <li>Salad Selection</li>
                <li>Pasties</li>
                <li>Spring Rolls</li>
                <li>Samosas</li>
                <li>Mini Tartlets</li>
                <li>&nbsp;</li>
                <li>Cottage Pie</li>
                <li>Moroccan Tagine</li>
                <li>Cous Cous</li>
                <li>New Potatoes</li>
                <li>Vegetables</li>
                <li>&nbsp;</li>
                <li>Selection of Desserts</li>
            </ul>
        </div>

    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
