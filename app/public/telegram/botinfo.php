<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';

$bot_token = BOT_TOKEN;
$apiURL = "https://api.telegram.org/bot{$bot_token}/getMe";
$response = file_get_contents($apiURL);
if (!$response) {
    echo "Error getting bot info";
    exit(0);
}
$data = json_decode($response, true);
if (!$data['ok']) {
    echo "Error getting bot info";
    exit(0);
}
echo "<pre>";
var_dump($data['result']);
echo "</pre>";
echo "Bot name: {$data['result']['username']}\n";
echo "<br>";
echo "Bot id: {$data['result']['id']}\n";
echo "<br>";
echo "Bot is bot: {$data['result']['is_bot']}\n";
echo "<br>";
echo "Bot first name: {$data['result']['first_name']}\n";
echo "<br>";
echo "Bot can join groups: {$data['result']['can_join_groups']}\n";
