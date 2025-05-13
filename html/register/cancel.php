<?php
    require_once __DIR__ . "/../includes/register-utils.php";
    require_once __DIR__ . "/../includes/stripe-processing.php";

    session_start();
    $provider_session_id = validate_stripe_session_id();
    $reg_year = $_SESSION['reg_year'];
    unset($_SESSION['reg_year']);

    $_SESSION['reg_message'] = "Payment transaction cancelled";
    header("Location: /" . $reg_year . "/register");
