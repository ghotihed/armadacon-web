<!doctype html>
<html lang="en">

<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$year = intval(explode("/", $uri)[1]);
$page_name = "home";
$page_title = "ArmadaCon $year Programme";
include($_SERVER['DOCUMENT_ROOT'] . "/includes/html-header.php");
?>

<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header-banner.php"); ?>

<!-- Main content section -->
<div class="content">
    <h1 class="page-title">ArmadaCon <?=$year?> Programme</h1>

    <?php
        $json_data = false;
        $json_file = $_SERVER['DOCUMENT_ROOT'] . $uri . "programme.json";
        if (file_exists($json_file)) {
            $json = file_get_contents($json_file);
            if ($json === false) {
                $json_data = false;
            } else {
                $json_data = json_decode($json, true);
            }
            if ($json_data !== false) {
                foreach ($json_data['days'] as $day) {
                    $day_title = $day['title'];
                    $day_theme = $day['theme'];
                    $day_note = $day['note'];
                    echo '<div class="content-box">';
                    echo '<div class="programme-day-title">' . $day_title . '</div>';
                    if (trim($day_theme) !== '') {
                        echo '<div class="programme-day-theme"><b>Theme:</b> ' . $day_theme . '</div>';
                    }
                    foreach ($day['items'] as $item) {
                        $item_title = $item['title'];
                        $item_description = $item['description'];
                        $item_start = $item['start'];
                        $item_end = $item['end'];
                        echo '<div class="programme-slot-title">' . $item_start . ' - ' . $item_end . ' ' . $item_title . '</div>';
                        echo '<div class="programme-slot-description">' . $item_description . '</div>';
                    }
                    if (trim($day_note) !== '') {
                        echo '<div class="programme-note"><b>Please note:</b> ' . $day_note . '</div>';
                    }
                    echo '</div>';
                }
            }
        }
        if ($json_data === false) {
            echo "<div class='content-box'>The programme for any convention usually doesn't get finalised until very soon before the convention itself. ArmadaCon is no different. Expect to see things here about a month before the convention.</div>";
        }
    ?>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php")?>
</body>
</html>
