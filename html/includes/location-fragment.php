<?php

global $convention;

if ($convention->location() == "Future Inn Plymouth") {
    include("future-inns-plymouth-fragment.php");
} elseif ($convention->location() == "Leonardo Hotel Plymouth") {
    include("leonardo-hotel-plymouth-fragment.php");
}