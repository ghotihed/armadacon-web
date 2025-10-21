<?php
    require_once __DIR__ . "/../includes/register-utils.php";
    require_once __DIR__ . "/../includes/stripe-processing.php";

    session_start();
    $provider_session_id = validate_stripe_session_id();

    $uri = $_SESSION['payment_cancel_path'] ?? "/";
    unset($_SESSION['payment_session_id']);
    unset($_SESSION['payment_success_path']);
    unset($_SESSION['payment_cancel_path']);
    $_SESSION['payment_result'] = "Payment transaction cancelled";
    header("Location: " . $uri);
