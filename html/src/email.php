<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/Exception.php';
require __DIR__ . '/../phpmailer/PHPMailer.php';
require __DIR__ . '/../phpmailer/SMTP.php';

// TODO Switch to ArmadaCon server
//const HOST_SERVER = 'smtp.armadacon.org';
const HOST_SERVER = 'ghoti.net';

// TODO Figure out how to store the password(s) securely!!!!!

function make_name(array $data) : string {
    $first_name = $data['first-name'] ?? '';
    $last_name = $data['last-name'] ?? '';
    if ($first_name && $last_name) {
        return $first_name . ' ' . $last_name;
    } else if ($first_name) {
        return $first_name;
    } else if ($last_name) {
        return $last_name;
    } else {
        return '';
    }
}

function html_table_row(string $label, array $data, string $key) : string {
    return "<tr><td><b>$label</b></td><td>" . ($data[$key] ?? '') . "</td></tr>";
}

function plain_table_row(string $label, array $data, string $key) : string {
    return "$label: " . ($data[$key] ?? '') . PHP_EOL;
}

function build_table(callable $build_row, array $data) : string {
    $reg_table  = $build_row("Email", $data, 'email');
    $reg_table .= $build_row("First name", $data, 'first-name');
    $reg_table .= $build_row("Last name", $data, 'last-name-name');
    $reg_table .= $build_row("Badge name", $data, 'badge-name');
    $reg_table .= $build_row("Address 1<sup>st</sup> line", $data, 'address-first-line');
    $reg_table .= $build_row("Address 2<sup>nd</sup> line", $data, 'address-second-line');
    $reg_table .= $build_row("Post code", $data, 'address-post-code');
    $reg_table .= $build_row("Membership type", $data, 'membership-type');
    $reg_table .= $build_row("Agreed to code of conduct", $data, 'code-of-conduct-agreement');
    $reg_table .= $build_row("GDPR data storage understanding", $data, 'detail-understanding');
    return $reg_table;
}

function build_html(array $data) : string {
    $email_body  = '<html lang="en">';
    $email_body .= "<head><title>ArmadaCon Registration</title>";
    $email_body .= '<meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>';
    $email_body .= "<h1>Registration successful</h1>";
    $email_body .= "<p>" . make_name($data) . ", thank you for registering for ArmadaCon. Here are the details we've recorded for you:</p>";
    $email_body .= "<table style='margin-left: 20px'>";
    $email_body .= build_table('html_table_row', $data);
    $email_body .= "</table>";
    $email_body .= "</body></html>";
    return $email_body;
}

function build_plain_text(array $data) : string {
    $email_body  = make_name($data) . ',' . PHP_EOL . PHP_EOL;
    $email_body .= "Thank you for registering for ArmadaCon. Here are the details we've recorded for you:" . PHP_EOL . PHP_EOL;
    $email_body .= build_table('plain_table_row', $data);
    return $email_body;
}

function send_email(array $data) : string {
    if ($data['email']) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = HOST_SERVER;
            if (HOST_SERVER === 'ghoti.net') {
                $mail->SMTPAuth = true;
                $mail->Username = 'craiga';
                $mail->Password = 'Gh0t1Hed';                   // TODO Password must be stored securely!!!!!
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('craiga@ghoti.net', 'Craig Arnush');
            } elseif (HOST_SERVER === 'armadacon.org') {
                $mail->Host = 'smtp.armadacon.org';
                $mail->SMTPAuth = true;
                $mail->Username = 'enquiries@armadacon.org';                          // TODO Change to membership email account
                $mail->Password = '0vX5ws3PhrbL';               // TODO Password must be stored securely!!!!!
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('enquiries@armadacon.org', 'ArmadaCon'); // TODO Change to membership email account
            }
            $mail->addAddress($data['email'], make_name($data));
            $mail->addBCC('enquiries@armadacon.org');       // TODO Change to membership email account
            $mail->Subject = 'Welcome to ArmadaCon';
            $mail->Body = build_html($data);
            $mail->AltBody = build_plain_text($data);

            return $mail->send() ? '' : $mail->ErrorInfo;
        } catch (Exception $e) {
            return "Mailer error: {$mail->ErrorInfo}";
        }
    }

    return "Unknown error";
}