<!doctype html>
<html lang="en">

<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$year = intval(explode("/", $uri)[1]);
$page_name = "events";
$page_title = "ArmadaCon $year Menu";
include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php")
?>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

    <link rel="stylesheet" href="/css/food-menu.css" type="text/css">

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">ArmadaCon <?=$year?> Menu</h1>

        <p>
            In addition to the standard fare available at the Fishbone restaurant, there is a special menu that
            is designed to make things faster for the ArmadaCon attendees to get their food during our short breaks.
        </p>

        <div class="food-menu">
            <div class="food-menu-heading">Friday 31<sup>st</sup> October Dinner</div>
            <div class="food-menu-sub-heading">(£13.00 per person)</div>
            <ul>
                <li>Sweet and sour pork with rice</li>
                <li>Fish pie</li>
                <li>Vegan meatballs and pasta in tomato sauce</li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Saturday 1<sup>st</sup> November Lunch</div>
            <div class="food-menu-sub-heading">(£11.00 per person)</div>
            <ul>
                <li>Southern fried chicken goujons</li>
                <li>Vegan sausage roll</li>
                <li>Vegetable stir fry & noodles</li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Saturday 1<sup>st</sup> November Dinner</div>
            <div class="food-menu-sub-heading">(£13.00 per person)</div>
            <ul>
                <li>Pork and leek sausages & mash</li>
                <li>Cod goujons</li>
                <li>Moroccan tagine</li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Sunday 2<sup>nd</sup> November Lunch</div>
            <div class="food-menu-sub-heading">(£11.00 per person)</div>
            <ul>
                <li>Vegetable cottage pie</li>
                <li>Chicken curry & Bombay potatoes</li>
                <li>Mini fish cakes</li>
            </ul>
        </div>

        <div class="food-menu">
            <div class="food-menu-heading">Sunday 2<sup>nd</sup> November Evening Buffet</div>
            <div class="food-menu-sub-heading">(£20.00 per person)</div>
            <ul>
                <li>Beef chilli</li>
                <li>Cajun salmon</li>
                <li>Med veg & tomato pasta (gluten free)</li>
                <li>With rice, new potatoes and selection of vegetables</li>
                <li>Selection of cold meats</li>
                <li>Steak pasties</li>
                <li>Spring rolls</li>
                <li>Bbq chicken drumsticks</li>
                <li>Bread rolls</li>
                <li>Selection of salads, i.e., coleslaw, couscous, potato salad, etc.</li>
                <li>Sweet potato falafel</li>
                <li>Moroccan style cauliflower bites</li>
                <li>Fruit platter</li>
                <li>Vegan lemon meringue pie</li>
                <li>Gluten free profiteroles</li>
                <li>Toffee and honeycomb cheesecake</li>
            </ul>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
