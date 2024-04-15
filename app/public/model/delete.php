<?php

session_start();
include_once __DIR__ . '/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    subscriberDelete($_GET['id']);

    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/model/subscribers.php");
    exit;
}
