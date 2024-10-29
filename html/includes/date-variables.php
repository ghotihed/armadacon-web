<?php

use libs\Convention;

require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/Convention.php';

    // NOTE: This array must have the conventions in ascending order.
    $con_dates = [
        2023 => [
            'start' => '11/03/2023 6:00 PM',
            'end' => '11/05/2023 5:00 PM',
            'prereg_cutoff_days' => 14,

            'banner-short' => 'Fri 3<sup>rd</sup> - Sun 5<sup>th</sup> November',
            'banner-long' => 'Friday 3<sup>rd</sup> - Sunday 5<sup>th</sup> November',
         ],
        2024 => [
            'start' => '11/01/2024 6:00 PM',
            'end' => '11/03/2024 5:00 PM',
            'prereg_cutoff_days' => 14,

            'banner-short' => 'Fri 1<sup>st</sup> - Sun 3<sup>rd</sup> November',
            'banner-long' => 'Friday 1<sup>st</sup> - Sunday 3<sup>rd</sup> November',
        ]
    ];

    $convention = new Convention();

