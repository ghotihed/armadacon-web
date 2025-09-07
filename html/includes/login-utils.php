<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/DBConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use config\DBConfig;
use db\MembersTable;

session_start();

//function url_origin(array $s, bool $use_forwarded_host = false) : string {
//    $ssl      = !empty($s['HTTPS']) && $s['HTTPS'] == 'on';
//    $sp       = strtolower($s['SERVER_PROTOCOL']);
//    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
//    $port     = $s['SERVER_PORT'];
//    $port     = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
//    $host     = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : ($s['HTTP_HOST'] ?? null);
//    $host     = $host ?? $s['SERVER_NAME'] . $port;
//    return $protocol . '://' . $host;
//}
//
//function full_url(array $s, bool $use_forwarded_host = false) : string {
//    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
//}

/**
 * Saves the URL for the current page as a referer so the user can be
 * returned here after logging in.
 */
function save_referer() : void {
    if (!isset($_SESSION['referer'])) {
//        $_SESSION['referer'] = full_url($_SERVER);
        $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
    }
}

function go_to_referer() : never {
    $referer = $_SESSION['referer'];
    unset($_SESSION['referer']);
    header("Location: $referer");
    exit;
}

function go_to_login() : never {
    header('Location: /login.php');
    exit;
}

function ensure_logged_in() : void {
    if (!is_logged_in()) {
        go_to_login();
    }
}

function login(string $email, string $password) : string {
    $result = "";
    if ($email === "admin@armadacon.org" && $password === DBConfig::PASSWORD) {
        session_regenerate_id();
        $_SESSION['email'] = $email;
        $_SESSION['member_id'] = 0;
        $_SESSION['is_admin'] = true;
        $_SESSION['permissions'] = "";
        go_to_referer();
    } else {
        $membersTable = new MembersTable();
        $members = $membersTable->findMemberByEmail($email);
        foreach ($members as $member) {
            if (password_verify($password, $member->password)) {
                $_SESSION['email'] = $email;
                $_SESSION['member_id'] = $member->id;
                $_SESSION['is_admin'] = $member->is_admin;
                $_SESSION['permissions'] = $member->permissions;
                go_to_referer();
            }
        }
        // Try to find the user in the member database.
        $result = "Invalid email or password";
    }
    return $result;
}

function logout() : never {
    session_destroy();
    header('Location: /');
    exit;
}

function is_logged_in() : bool {
    return isset($_SESSION['email']);
}

function logged_in_email() : string {
    return is_logged_in() ? $_SESSION['email'] : '';
}

function logged_in_member_id() : int {
    return is_logged_in() ? $_SESSION['member_id'] : -1;
}

function is_admin() : bool {
    return is_logged_in() && ($_SESSION['member_id'] === 0 || $_SESSION['is_admin']);
}

/**
 * Possible permissions to check for:
 *  - view_member_list
 *  - view_reg_list
 *  - view_reg
 *  - view_member
 *  - view_member_ext
 *  - add_payment
 *  - edit_member
 *  - edit_reg
 *  - edit_permissions
 *  - set_password
 * @param string $permission
 * @return bool
 */
function has_permission(string $permission) : bool {
    return is_logged_in() && (is_admin() || str_contains($_SESSION['permissions'], $permission));
}