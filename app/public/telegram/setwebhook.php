<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/credentials/cred_telegram.php";

$bot_token = BOT_TOKEN;
$webHookURL = WEBHOOK_URL;
$apiURL = "https://api.telegram.org/bot$bot_toke/setwebhook?url=$webHookURL";
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
var_dump($data);
echo "</pre>";
