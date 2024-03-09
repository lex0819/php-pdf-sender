<?php

$uri_api = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendDocument?chat_id=" . CHAT_ID;

$file_name = $_SESSION['file_pdf'];

$telegrams = getAllTelegrams();

$send_telegram_ok = '';
$where_is_server = __DIR__; //test

//Simple message
// $send_tg = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$where_is_server}", "r");

// if ($send_tg) {
//     $send_telegram_ok = "File {$file_name} was sent to telegram bot";
// } else {
//     $send_telegram_ok = "Error";
// }

// Create CURL object
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri_api);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

// Create CURLFile
$finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_name);
$cFile = new CURLFile($file_name, $finfo);

// Add CURLFile to CURL request
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "document" => $cFile
]);

// Call
$result = curl_exec($ch);

// Show result and close curl
// var_dump($result);
curl_close($ch);
if ($result) {
    $send_telegram_ok = "File {$file_name} was sent to telegram bot";
} else {
    $send_telegram_ok = "Error";
}
