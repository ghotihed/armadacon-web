<?php

namespace libs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use config\MailConfig;

require __DIR__ . '/../libs/PHPMailer/Exception.php';
require __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require __DIR__ . '/../libs/PHPMailer/SMTP.php';

require_once __DIR__ . '/../config/MailConfig.php';

interface MailData {
    public function getEmail() : string;
    public function getName() : string;
    public function getSubject() : string;
    public function getHtmlBody() : string;
    public function getTextBody() : string;
}

class Mailer
{
    private array $mailer_info;

    public function __construct(MailConfig $config) {
        $this->mailer_info = $config->getMailerInfo();
    }

    function send_email(MailData $data) : string {
        if (count($this->mailer_info) === 0) {
            return "Mailer error: undefined mail host";
        }
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->mailer_info['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailer_info['MAIL_USERNAME'];
            $mail->Password = $this->mailer_info['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->setFrom($this->mailer_info['MAIL_FROM_ADDRESS'], $this->mailer_info['MAIL_FROM_NAME']);
            $mail->addBCC($this->mailer_info['MAIL_FROM_ADDRESS']);

            $mail->addAddress($data->getEmail(), $data->getName());
            $mail->Subject = $data->getSubject();
            $mail->Body = $data->getHtmlBody();
            $mail->AltBody = $data->getTextBody();

            return $mail->send() ? '' : $mail->ErrorInfo;
        } catch (Exception) {
            return "Mailer error: $mail->ErrorInfo";
        }
    }
}