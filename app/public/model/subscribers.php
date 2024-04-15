<?php
session_start();

require_once __DIR__ . '/init.php';
check_session_pdf();
$file_pdf = get_file_name();
// var_dump($file_pdf);

$list = listOfSubscribers();
// var_dump($list);
require_once('../view/subscribers.php');
