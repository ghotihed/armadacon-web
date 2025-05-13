<?php
    require_once __DIR__ . "/../includes/register-utils.php";
    require_once __DIR__ . "/../includes/stripe-processing.php";

    use config\CreditCardConfig;
    use Stripe\Exception\ApiErrorException;
    use Stripe\StripeClient;

    session_start();
    $provider_session_id = validate_stripe_session_id();
//    $stripe = new StripeClient(CreditCardConfig::STRIPE_SECRET_KEY);
//    try {
//        $session = $stripe->checkout->sessions->retrieve($provider_session_id);
//        $payment_intent = $stripe->paymentIntents->retrieve($session->payment_intent);
//
//    } catch (ApiErrorException $e) {
//        http_response_code(500);
//        echo json_encode(['error' => $e->getMessage()]);
//    }
    $reg_members = $_SESSION["reg_members"];
    $reg_year = $_SESSION['reg_year'];
    unset($_SESSION['reg_year']);
    $_SESSION["reg_uid_list"] = saveRegistrationDetails($reg_members, $reg_year);
    $_SESSION["reg_action"] = "finished";
    header("Location: /" . $reg_year . "/register");
