<?php
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'member_csv') {
        $csv_list = json_decode(base64_decode($_POST["csv_list"]));
        $content = $csv_list->content;
        $header = implode(",", $csv_list->header);

        if ($csv_list->sort) {
            // Collect indices
            $first_name = "";
            $last_name = "";
            $email = "";
            $badge_name = "";
            $index = 0;
            foreach ($csv_list->header as $key => $value) {
                if ($value === 'first-name') {
                    $first_name = $index;
                } elseif ($value === 'last-name') {
                    $last_name = $index;
                } elseif ($value === 'email') {
                    $email = $index;
                } elseif ($value === 'badge-name') {
                    $badge_name = $index;
                }
                ++$index;
            }

            // Sort the names
            usort($content, function ($a, $b) {
                global $first_name, $last_name, $badge_name, $email;
                $aCmpName = $badge_name != "" && $a[$badge_name] != "" ? $a[$badge_name] : $a[$first_name] . ' ' . $a[$last_name] . ' &lt;' . $a[$email] . '&gt;';
                $bCmpName = $badge_name != "" && $b[$badge_name] != "" ? $b[$badge_name] : $b[$first_name] . ' ' . $b[$last_name] . ' &lt;' . $b[$email] . '&gt;';
                return strcasecmp($aCmpName, $bCmpName);
            });
        }

        // Output CSV file
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
