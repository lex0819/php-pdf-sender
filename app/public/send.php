<?php
session_start();
include_once(__DIR__ . '/init.php');
include_once(__DIR__ . '/credentials/cred-email.php');
include_once(__DIR__ . '/send_emails.php');
include_once(__DIR__ . '/credentials/cred_telegram.php');
include_once(__DIR__ . '/send_telegram.php');

include_once(__DIR__ . '/view/send.php');

unlink($_SESSION['file_pdf']);
unset($_SESSION['file_pdf']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['telegram']);
