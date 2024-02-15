<?php
session_start();

include_once(__DIR__ . '/init.php');
check_session_pdf();
$file_pdf = get_file_name();

$list = listOfSubscribers();
include_once(__DIR__ . '/view/subscribers.php');
