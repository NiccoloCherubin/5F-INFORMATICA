<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;

        // Configurazione SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'niccolo.cherubin@iisviolamarchesini.edu.it';
        $mail->Password = 'mzuy wesy jjtp uqbo';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Mittente e destinatario
        $mail->setFrom('niccolo.cherubin@iisviolamarchesini.edu.it', 'FastRoute');
        $mail->addAddress($to);

        // Contenuto email
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(false); // Imposta a `true` se vuoi usare HTML nel corpo dell'email

        // Invia email
        return $mail->send();
    } catch (Exception $e) {
        error_log("Errore nell'invio della mail: " . $mail->ErrorInfo);
        return false;
    }
}
