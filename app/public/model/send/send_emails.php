<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/Exception.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/PHPMailer.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/SMTP.php');

$list_of_persons = getAllEmails();
$where_is_server = __DIR__; //test

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->CharSet = 'utf-8';
    $mail->SMTPDebug = 0; //Enable verbose debug output
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = HOST; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = USER; //SMTP username
    $mail->Password = PASS;  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //Recipients
    $mail->setFrom(USER, 'Mailer');
    $success = [];
    $errors = [];

    // Loop by list of emails
    foreach ($list_of_persons as $person) {
        $mail->addAddress($person['email'], $person['subscribe_name']);
        $mail->addAttachment($_SESSION['file_pdf']); //Add attachments
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = "Our new price from {$where_is_server}";
        $mail->Body    = "Hi, {$person['subscribe_name']}! \r\n See our <b>new price</b> in the attachment";
        $mail->AltBody = "Hi, gay! \r\n See our new price in the attachment";
        $ok = $mail->send(); // send address
        if(!$ok) {
            $errors[] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
        $mail->clearAddresses(); //remote address which was sending from loop
        $success[] = "{$person['email']}";
    }
    if(empty($errors)) {
        $success[] = "All emails were sent";
    } else {
        $errors[] = "Too many errors";
    }
} catch (Exception $e) {
    $errors[] = $mail->ErrorInfo;
}
