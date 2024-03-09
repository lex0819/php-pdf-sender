<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';

$bot_token = BOT_TOKEN;
$apiUrl = "https://api.telegram.org/bot{$bot_token}/getWebhookInfo";
$response = file_get_contents($apiUrl);
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
