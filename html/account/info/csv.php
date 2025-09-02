<?php
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'member_csv') {
        $csv_list = json_decode(base64_decode($_POST["csv_list"]));
        usort($csv_list, function($a, $b) {
            $aDisplayName = $a[0] . ' ' . $a[1] . ' &lt;' . $a[3] . '&gt;';
            $bDisplayName = $b[0] . ' ' . $b[1] . ' &lt;' . $b[3] . '&gt;';
            if ($a[2] !== "" && $b[2] != "") {
                return strcmp($a[2], $b[2]);
            } else if ($a[2] !== "") {
                return strcmp($a[2], $bDisplayName);
            } else if ($b[2] != "") {
                return strcmp($aDisplayName, $b[2]);
            } else {
                return strcmp($aDisplayName, $bDisplayName);
            }
        });
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=member_list.csv");
        echo "first_name,last_name,badge_name,email" . PHP_EOL;
        foreach ($csv_list as $csv_row) {
            echo "$csv_row[0],$csv_row[1],$csv_row[2],$csv_row[3]" . PHP_EOL;
        }
    }
}
