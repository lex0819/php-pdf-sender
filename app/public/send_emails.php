<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';


$emails = getAllEmails();
$send_mail_ok = '';
$where_is_server = __DIR__; //test

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->CharSet = 'utf-8';
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = HOST;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = USER;                     //SMTP username
    $mail->Password   = PASS;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(USER, 'Mailer');
    foreach ($emails as $email) {
        $mail->addAddress($email['email'], $email['subscribe_name']);

        $mail->addAttachment($_SESSION['file_pdf']);         //Add attachments

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Our new price from {$where_is_server}";
        $mail->Body    = "Hi, {$email['subscribe_name']}! \r\n See our <b>new price</b> in the attachment";
        $mail->AltBody = "Hi, gay! \r\n See our new price in the attachment";

        $mail->send();
        $send_mail_ok .= "Message for {$email['email']} was sent \r\n";
    }
} catch (Exception $e) {
    $send_mail_ok .= $mail->ErrorInfo . "\r\n";
}
