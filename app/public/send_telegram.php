<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/telegram/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';

$bot_token = BOT_TOKEN;

$file_name = $_SESSION['file_pdf'];

$telegrams = getAllTelegrams();

$send_telegram_ok = [];

//Simple message
// $send_tg = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$where_is_server}", "r");

// if ($send_tg) {
//     $send_telegram_ok = "File {$file_name} was sent to telegram bot";
// } else {
//     $send_telegram_ok = "Error";
// }

// foreach ($telegrams as $telegram) {
//     $user = str_replace('@', '', $telegram["telegram"]);
//     var_dump($user);
//     $user_bot_link = serchUserTelegram($user);
//     var_dump($user_bot_link);
//     $chat_id = $user_bot_link['chat_id'];
//     var_dump($chat_id);
//     $result = pdf_to_telegram($bot_token, $chat_id, $file_name);
//     if ($result['ok']) {
//         $send_telegram_ok[$user] = 'OK';
//     }
// }

$array_chat_id = array();
foreach ($telegrams as $telegram) {
    $user = str_replace('@', '', $telegram["telegram"]);
    $user_bot_link = serchUserTelegram($user);
    if ($user_bot_link) {
        $array_chat_id[$telegram["telegram"]] = $user_bot_link['chat_id'];
    }
}

$send_telegram_ok = multi_curl_pdf_to_telegram($bot_token, $array_chat_id, $file_name);

// var_dump($send_telegram_ok);
