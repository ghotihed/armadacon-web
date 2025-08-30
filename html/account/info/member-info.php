<?php

use db\MembersTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/login-utils.php";

if (!is_logged_in()) {
    http_response_code(401);
    exit;
}

$json_params = file_get_contents('php://input');
if (strlen($json_params) > 0 && json_validate($json_params)) {
    $json = json_decode($json_params, true);
    $membersTable = new MembersTable();
    $member = $membersTable->getMember($json['id']);
    if ($member->id === 0) {
        http_response_code(404);
    }
    $result = $member->toJson();
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