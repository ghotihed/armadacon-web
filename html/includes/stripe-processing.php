<?php

require_once __DIR__ . '/../config/CreditCardConfig.php';
require_once __DIR__ . '/../libs/Stripe/init.php';

use config\CreditCardConfig;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

/**
 * Does the grunt work of actually calling the STRIPE processing URL. This function will terminate
 * processing the current script. Processing will be returned to either of the `/register/success.php`
 * or `/register/cancel.php` scripts.
 * @param string $email The email of the customer initiating the STRIPE session.
 * @param array $line_items The STRIPE-formatted line items for the bill.
 * @param string $success_uri The URI to go to when a payment is successful. This can be a simple path.
 * @param string $cancel_uri The URI to go to when a payment is cancelled / has failed. This can be a simple path.
 * @return void This function stops PHP processing and does not return.
 */
function process_payment(string $email, array $line_items, string $success_uri, string $cancel_uri) : void {
    $protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    $stripe = new StripeClient(CreditCardConfig::STRIPE_SECRET_KEY);
    try {
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . '/register/success.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . '/register/cancel.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'customer_email' => $email,
        ]);
    } catch (ApiErrorException $e) {
        $_SESSION['payment_result'] = "Error: " . $e->getMessage();
        header("Location: " . $cancel_uri);
        exit;
    }
    $_SESSION['payment_session_id'] = $checkout_session->id;
    $_SESSION['payment_success_path'] = $success_uri;
    $_SESSION['payment_cancel_path'] = $cancel_uri;

    header('Content-Type: application/json');
    header('HTTP/1.1 303 See Other');
    header('Location: ' . $checkout_session->url);
    exit;
}

/**
 * Creates a STRIP-friendly line item. Collect these into an array to pass to {@see process_payment()}.
 * @param string $description The name to be used for the line item. This should be readable by the end user.
 * @param float $amount The monetary amount of the line item.
 * @return array A STRIPE array that constitutes a line item.
 */
function create_line_item(string $description, float $amount) : array {
    return [
        'price_data' => [
            'currency' => 'gbp',
            'product_data' => [
                'name' => $description
            ],
            'unit_amount' => $amount * 100,
        ],
        'quantity' => 1
    ];
}

/** Validates the payment session ID. Called by the success and cancel response pages. If there
 * was a failure, this function will not return, but will load the root path of the website.
 * @return string If the payment session was successful, this returns the provider's session ID.
 */
function validate_stripe_session_id() : string {
    if (!isset($_REQUEST['provider_session_id']) || !isset($_SESSION['payment_session_id'])) {
        header('Location: /');
        exit;
    }

    $provider_session_id = $_REQUEST['provider_session_id'];
    $payment_session_id = $_SESSION['payment_session_id'];
    if ($provider_session_id !== $payment_session_id) {
        header('Location: /');
        exit;
    }
    return $provider_session_id;
}
