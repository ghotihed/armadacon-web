<?php

namespace libs;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\Member;

class MailLogin implements MailData {
    private Member $member;
    private string $url;

    public function __construct(Member $member, string $url) {
        $this->member = $member;
        $this->url = $url;
    }

    public function getEmail(): string
    {
        return $this->member->email;
    }

    public function getName(): string
    {
        return "";
    }

    public function getSubject(): string
    {
        return "ArmadaCon Login";
    }

    public function getHtmlBody(): string
    {
        $email_body = '<html lang="en">';
        $email_body .= '<head><title>ArmadaCon Login Request</title>';
        $email_body .= '<meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>';
        $email_body .= '<h1>ArmadaCon Login Request</h1>';
        $email_body .= '<p>Hello,</p>';
        $email_body .= '<p>A request to log in to the ArmadaCon website has been made. The URL to use for logging in is as follows:</p>';
        $email_body .= '<p style="margin-left: 20px"><a href="' . $this->url . '">Click here to log in to ArmadaCon</a></p>';
        $email_body .= "<p>Note that this link will only be valid for the next <b>1 hour</b>. If it's been too long, you will need to regenerate the link.</p>";
        $email_body .= "<p style='margin-top: 20px'>Thanks,<br/>ArmadaCon Logins</p>";
        $email_body .= "<p style='margin-top: 20px; font-size: small'>This email originates from an unmonitored mailbox. Replies will be ignored.</p>";
        $email_body .= '</body></html>';
        return $email_body;
    }

    public function getTextBody(): string
    {
        $email_body = "Hello,\n\n";
        $email_body .= "A request to log in to the ArmadaCon website has been made. The URL to use for logging in is as follows:\n\n";
        $email_body .= "    $this->url\n\n";
        $email_body .= "Note that this link will only be valid for the next 1 hour. If it's been too long, you will need to regenerate the link.\n\n";
        $email_body .= "Thanks,\nArmadaCon Logins\n\n";
        $email_body .= "NOTE: This email originates from an unmonitored mailbox. Replies will be ignored.";
        return $email_body;
    }
}