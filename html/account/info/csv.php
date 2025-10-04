<?php
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'member_csv') {
        $csv_list = json_decode(base64_decode($_POST["csv_list"]));
        $content = $csv_list->content;
        $header = implode(",", $csv_list->header);
        $has_badge_name = str_contains($header, "badge-name");
        usort($content, function($a, $b) {
            global $has_badge_name;
            if ($has_badge_name) {
                $aDisplayName = $a[0] . ' ' . $a[1] . ' &lt;' . $a[3] . '&gt;';
                $bDisplayName = $b[0] . ' ' . $b[1] . ' &lt;' . $b[3] . '&gt;';
            } else {
                $aDisplayName = $a[0] . ' ' . $a[1] . ' &lt;' . $a[2] . '&gt;';
                $bDisplayName = $b[0] . ' ' . $b[1] . ' &lt;' . $b[2] . '&gt;';
            }
            if (!$has_badge_name) {
                return strcasecmp($aDisplayName, $bDisplayName);
            } elseif ($a[2] !== "" && $b[2] != "") {
                return strcasecmp($a[2], $b[2]);
            } elseif ($a[2] !== "") {
                return strcasecmp($a[2], $bDisplayName);
            } elseif ($b[2] != "") {
                return strcasecmp($aDisplayName, $b[2]);
            } else {
                return strcasecmp($aDisplayName, $bDisplayName);
            }
        });
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=$csv_list->filename");
        echo $header . PHP_EOL;
        foreach ($content as $csv_row) {
            echo safe_implode($csv_row) . PHP_EOL;
        }
    }
}

function safe_implode(array $array): string {
    foreach ($array as $key => $value) {
        $array[$key] = '"' . $value . '"';
    }
    return implode(",", $array);
}
