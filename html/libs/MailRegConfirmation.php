<?php

namespace libs;

require_once __DIR__ . "/../db/bootstrap.php";

use db\Member;
use db\MembershipType;
use db\Registration;
use libs\MailData;

class MailRegConfirmation implements MailData
{
    private int $year;
    private Member $member;
    private Registration $registration;
    private MembershipType $membership_type;

    public function __construct($year, Member $member, Registration $registration, MembershipType $membership_type) {
        $this->year = $year;
        $this->member = $member;
        $this->registration = $registration;
        $this->membership_type = $membership_type;
    }


    public function getEmail(): string
    {
        return $this->member->email;
    }

    public function getName(): string
    {
        if (!empty($this->registration->badge_name)) {
            return $this->registration->badge_name;
        } else {
            return $this->member->displayName();
        }
    }

    public function getSubject(): string
    {
        return "ArmadaCon {$this->year} Registration Confirmation";
    }

    public function getHtmlBody(): string
    {
        $email_body  = '<html lang="en">';
        $email_body .= "<head><title>ArmadaCon {$this->year} Registration</title>";
        $email_body .= '<meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>';
        $email_body .= "<h1>Registration successful</h1>";
        $email_body .= "<p>" . $this->getName() . ", thank you for registering for ArmadaCon {$this->year}. Here are the details we've recorded for you:</p>";
        $email_body .= "<table style='margin-left: 20px'>";
        $email_body .= $this->build_table(array($this, 'html_table_row'));
        $email_body .= "</table>";
        $email_body .= "</body></html>";
        return $email_body;
    }

    public function getTextBody(): string
    {
        $email_body  = $this->getName() . ',' . PHP_EOL . PHP_EOL;
        $email_body .= "Thank you for registering for ArmadaCon {$this->year}. Here are the details we've recorded for you:" . PHP_EOL . PHP_EOL;
        $email_body .= $this->build_table(array($this, 'plain_table_row'));
        return $email_body;
    }

    private function build_table(callable $build_row) : string {
        $reg_table  = $build_row("Email", $this->member->email);
        $reg_table .= $build_row("First name", $this->member->first_name);
        $reg_table .= $build_row("Last name", $this->member->surname);
        $reg_table .= $build_row("Badge name", $this->registration->badge_name);
        $reg_table .= $build_row("Address 1", $this->member->address1);
        $reg_table .= $build_row("Address 2", $this->member->address2);
        $reg_table .= $build_row("City", $this->member->city);
        $reg_table .= $build_row("Post code", $this->member->post_code);
        $reg_table .= $build_row("Country", $this->member->country);
        $reg_table .= $build_row("Phone", $this->member->phone);
        $reg_table .= $build_row("List publicly?", $this->member->agree_to_public_listing ? "Yes" : "No");
        $reg_table .= $build_row("Membership type", $this->membership_type->name . " (£" . $this->membership_type->price . ")");
        return $reg_table;
    }

    private function html_table_row(string $label, string $value) : string {
        return "<tr><td><b>$label</b></td><td>$value</td></tr>";
    }

    private function plain_table_row(string $label, string $value) : string {
       return "$label: $value" . PHP_EOL;
    }
}