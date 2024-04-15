<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/telegram/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';

$bot_token = BOT_TOKEN;

$file_name = $_SESSION['file_pdf'];

$telegrams = getAllTelegrams();

$send_telegram_ok = [];

$array_chat_id = array();
foreach ($telegrams as $telegram) {
    $user = str_replace('@', '', $telegram["telegram"]);
    $user_bot_link = serchUserTelegram($user);
    if ($user_bot_link) {
        $array_chat_id[$telegram["telegram"]] = $user_bot_link['chat_id'];
    }
}
// echo '<pre>$array_chat_id';
// var_dump($array_chat_id);
// echo '</pre>';
$send_telegram_ok = multi_curl_pdf_to_telegram($bot_token, $array_chat_id, $file_name);

// echo '<pre>$send_telegram_ok;
// var_dump($send_telegram_ok);
// echo '</pre>';