<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/DBConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/MailConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/Mailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/MailLogin.php";

use config\DBConfig;
use config\MailConfigNoReply;
use db\MembersTable;
use libs\MailLogin;
use libs\Mailer;

session_start();

/**
 * Saves the URL for the current page as a referer so the user can be
 * returned here after logging in.
 */
function save_referer() : void {
    if (!isset($_SESSION['referer'])) {
        $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
    }
}

function go_to_referer() : never {
    $referer = $_SESSION['referer'];
    unset($_SESSION['referer']);
    header("Location: $referer");
    exit;
}

function clear_referer() : void {
    unset($_SESSION['referer']);
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

/**
 * Looks up a member using the given email. If one is found, a unique code is
 * generated for that member, and the email is used to send the unique code
 * to the member. The link sent to the member is a base URL plus a query string
 * with the unique code.
 * @param string $email The email of the member to look up
 * @param string $baseUrl The base URL to use in generating the link URL
 * @return string This will be empty if either no members were located with the
 * provided email address, or if there were no issues in sending the link email.
 */
function generate_unique_code(string $email, string $baseUrl) : string {
    $result = "";
    if ($email === "") {
        $result = "Please enter your email address";
    } else {
        $membersTable = new MembersTable();
        $members = $membersTable->findMemberByEmail($email);
        if (count($members) > 0) {
            $members[0]->generateUniqueCode("password_reset");
            $membersTable->updateMemberUniqueCode($members[0]);

            $protocol = $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['SERVER_NAME'];
            $targetUrl = $protocol . "://" . $host . $baseUrl . "?" . $members[0]->uniq_code;

            $mail_reset = new MailLogin($members[0], $targetUrl);
            $mailer = new Mailer(new MailConfigNoReply());
            $result = $mailer->send_email($mail_reset);
        }
    }
    return $result;
}

function login_by_unique_code(string $uniqueCode) : string {
    $result = "";
    if ($uniqueCode === "") {
        $result = "That link is empty.";
    } else {
        $membersTable = new MembersTable();
        $member = $membersTable->findMemberByUniqueCode($uniqueCode);
        if ($member->id <= 0) {
            $result = "That link is invalid.";
        } else {
            if ($member->isUniqueCodeExpired()) {
                $result = "That link has expired.";
            } else {
                $_SESSION['email'] = $member->email;
                $_SESSION['member_id'] = $member->id;
                $_SESSION['is_admin'] = $member->is_admin;
                $_SESSION['permissions'] = $member->permissions;
            }
            $member->clearUniqueCode();
            $membersTable->updateMemberUniqueCode($member);
        }
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
 * Check the logged-in member's permission list for the requested permission.
 * This will return also `true` if the logged-in member is an administrator.
 * If no member is logged in, this will return `false`.
 * @param Permission $permission
 * @return bool
 */
function has_permission(Permission $permission) : bool {
    return is_logged_in() && (is_admin() || str_contains($_SESSION['permissions'], $permission->value));
}
