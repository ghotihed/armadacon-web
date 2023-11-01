<?php

const PRICE_FULL = 'full';
const PRICE_CONCESSION = 'concession';
const PRICE_AT_CON_FULL = 'at-con';
const PRICE_AT_CON_CONCESSION = 'at-con-concession';

const PRICE_WEEKEND = 'weekend';
const PRICE_SINGLE = 'single';
const PRICE_EVENING = 'evening';
const PRICE_DEALERS_ROOM = 'dealers-room';

$prices = [
    2023 => [
        PRICE_FULL => [
            PRICE_WEEKEND => 40,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_CONCESSION => [
            PRICE_WEEKEND => 35,
            PRICE_SINGLE => 20,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_AT_CON_FULL => [
            PRICE_WEEKEND => 35,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_AT_CON_CONCESSION => [
            PRICE_WEEKEND => 35,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
    ],
    2024 => [
        PRICE_FULL => [
            PRICE_WEEKEND => 45,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_CONCESSION => [
            PRICE_WEEKEND => 35,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_AT_CON_FULL => [
            PRICE_WEEKEND => 40,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ],
        PRICE_AT_CON_CONCESSION => [
            PRICE_WEEKEND => 35,
            PRICE_SINGLE => 25,
            PRICE_EVENING => 5,
            PRICE_DEALERS_ROOM => 5
        ]
    ]
];

function get_price(int $year, string $type, bool $concession = false, bool $at_con = false) : int {
    global $prices;

    if (array_key_exists($year, $prices)) {
        if ($at_con) {
            return $prices[$year][$concession ? PRICE_AT_CON_CONCESSION : PRICE_AT_CON_FULL][$type];
        } else {
            return $prices[$year][$concession ? PRICE_CONCESSION : PRICE_FULL][$type];
        }
    }
    return 0;
}