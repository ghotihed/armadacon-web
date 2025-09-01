<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/member-utils.php';

if (!is_logged_in()) {
    http_response_code(401);
    exit;
}

$json_params = file_get_contents('php://input');
if (strlen($json_params) > 0 && json_validate($json_params)) {
    $member = null;
    $event = null;
    $registration = null;
    $membership_type = null;

    $json = json_decode($json_params, true);
    $uid = $json['uid'];
    [$member, $event, $registration, $membership_type, $payment] = get_reg_info($uid);

    if ($member->id === 0) {
        http_response_code(404);
    }

    $result = json_encode([
        "uid" => $uid,
        "member_id" => $member->id,
        "registration_id" => $registration->id,
        "display_name" => $member->displayName(),
        "badge_name" => $registration->badge_name,
        "event_id" => $event->id,
        "event_name" => $event->name,
        "membership_type_name" => $membership_type->name,
        "price" => $membership_type->price,
        "payment_id" => $payment->id,
        "payment_date" => $payment->payment_date,
        "payment_amount" => $payment->amount,
        "payment_type" => $payment->payment_type,
    ]);

    if ($result === false) {
        $result  = json_encode(["jsonError" => json_last_error_msg()]);
        if ($result === false) {
            $result = '{"jsonError": "unknown error"}';
        }
        http_response_code(500);
    }
    echo $result;
    http_response_code(200);
} else {
    http_response_code(400);
}