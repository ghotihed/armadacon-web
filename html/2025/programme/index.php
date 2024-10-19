<!doctype html>
<html lang="en">

<?php
global $convention;
$page_name = "home";
$page_title = "ArmadaCon Programme";
include(__DIR__ . "/../../includes/html-header.php");
?>

<body>
<?php include(__DIR__ . "/../../includes/header-banner.php"); ?>

<!-- Main content section -->
<div class="content">
    <h1 class="page-title">ArmadaCon 2025 Programme</h1>

    <?php
        $json_data = false;
        if (file_exists(__DIR__ . "/programme.json")) {
            $json = file_get_contents(__DIR__ . "/programme.json");
            if ($json === false) {
                $json_data = false;
            } else {
                $json_data = json_decode($json, true);
            }
            if ($json_data !== false) {
                foreach ($json_data['days'] as $day) {
                    $day_title = $day['title'];
                    $day_note = $day['note'];
                    echo '<div class="content-box">';
                    echo '<div class="programme-day-title">' . $day_title . '</div>';
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

<?php include(__DIR__ . "/../../includes/footer.php")?>
</body>
</html>
