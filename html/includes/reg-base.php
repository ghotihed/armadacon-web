<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/Convention.php";

use libs\Convention;

global $reg_year;
global $reg_error;

// We're going to need a session, so make sure it's started.
session_start();

// Figure out which year's registration included us.
$uri = $_SERVER['REQUEST_URI'];
$reg_year = intval(explode("/", $uri)[1]);

$reg_error = "";
$convention = new Convention();     // Gets the next or currently running convention.
if ($reg_year === $convention->year()) {
    if (!$convention->isRunning() && !$convention->isPreregAvailable()) {
        $reg_error = "Registration is not currently available for ArmadaCon $reg_year. Registrations will be available at the door when the convention starts. Just turn up, and we'll be happy to have you!";
    }
} else if ($reg_year < $convention->year()) {
    $reg_error = "ArmadaCon $reg_year is over, and registrations are no longer available.";
}

if ($reg_error !== "") {
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/reg-error.php");
    exit;
}

if (!is_logged_in()) {
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/reg-login.php");
    exit;
}

if (isset($_SESSION['payment_result'])) {
    if ($_SESSION['payment_result'] === "") {
        include($_SERVER['DOCUMENT_ROOT'] . "/includes/reg-success.php");
        exit;
    }
}

include($_SERVER['DOCUMENT_ROOT'] . "/includes/reg-member.php");