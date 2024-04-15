<?php
session_start();
require_once __DIR__ . '/init.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/credentials/cred-email.php');
require_once __DIR__ . '/send/send_emails.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php');
require_once __DIR__ . '/send/send_telegram.php';

require_once('../view/send.php');

unlink($_SESSION['file_pdf']);
unset($_SESSION['file_pdf']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['telegram']);
