<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/init-convention.php";
    global $convention;
    header("Location: /" . $convention->year() . "/guests");
