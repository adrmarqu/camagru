<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function sendVerificationEmail(string $address, int $codigo): array
    {
        require_once ROOT . 'vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->Port = 2525;

            $mail->setFrom('no-reply@camagru.com', 'Camagru');
            $mail->addAddress($address);

            $mail->Subject = 'Código de verificación';
            $mail->Body = "Tu código es: $codigo";

            $mail->send();
            return ['success' => true, 'msg' => ''];

        } 
        catch (Exception $e)
        {
            return ['success' => false, 'msg' => $e->getMessage()];
        }
    }
}