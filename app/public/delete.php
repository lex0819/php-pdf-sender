<?php

session_start();
include_once(__DIR__ . '/init.php');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    subscriberDelete($_GET['id']);

    header("Location: " . BASE_URL . "subscribers.php");
    exit;
}
