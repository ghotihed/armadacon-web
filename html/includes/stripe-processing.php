<?php

require_once __DIR__ . '/../config/CreditCardConfig.php';
require_once __DIR__ . "/../libs/Convention.php";
require_once __DIR__ . "/../libs/MemberRegInfo.php";
require_once __DIR__ . '/../libs/Stripe/init.php';

use config\CreditCardConfig;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use libs\Convention;
use libs\MemberRegInfo;

function process_payment($reg_members, $reg_year) : void {
    $stripe = new StripeClient(CreditCardConfig::STRIPE_SECRET_KEY);

    $line_items = array();
    $reg_convention = new Convention($reg_year);
    $email_address = '';
    foreach ($reg_members as $reg_member) {
        $reg_info = MemberRegInfo::createFromArray($reg_member);
        $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);

        if ($email_address === '') {
            $email_address = $reg_info->email;
        }

        $line_items[] = [
            'price_data' => [
                'currency' => 'gbp',
                'product_data' => [
                    'name' => $reg_info->displayName() . ' - ' . $reg_year . ' ' . $membership_type->name
                ],
                'unit_amount' => $membership_type->price * 100,
            ],
            'quantity' => 1
        ];
    }

    $protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    try {
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . '/register/success.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . '/register/cancel.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'customer_email' => $email_address,
        ]);
    } catch (ApiErrorException $e) {
        // TODO Do better error handling here.
        echo "Error: " . $e->getMessage() . "<br/>";
        exit;
    }
//    $checkout_session->payment_intent->receipt_email = $email_address;
//    $checkout_session->payment_intent->description = "Thanks for registering. We can't wait to see you at the convention!";

    $_SESSION['check-out-session-id'] = $checkout_session->id;
    $_SESSION['reg_year'] = $reg_year;

    header('Content-Type: application/json');
    header('HTTP/1.1 303 See Other');
    header('Location: ' . $checkout_session->url);
}

function validate_stripe_session_id() : string {
    if (!isset($_REQUEST['provider_session_id']) || !isset($_SESSION['check-out-session-id'])) {
        header('Location: /');
        exit;
    }

    $provider_session_id = $_REQUEST['provider_session_id'];
    $session_checkout_id = $_SESSION['check-out-session-id'];
    if ($provider_session_id !== $session_checkout_id) {
        header('Location: /');
        exit;
    }
    return $provider_session_id;
}
