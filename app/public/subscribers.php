<?php
session_start();

include_once(__DIR__ . '/init.php');
check_session_pdf();
$file_pdf = get_file_name();
// var_dump($file_pdf);

$list = listOfSubscribers();
// var_dump($list);
include_once(__DIR__ . '/view/subscribers.php');
