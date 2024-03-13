<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/init.php';

$chat_id = 615239835;
$user_name = 'lex0820';
$first_name = 'Елена';
$last_name = '';

// Check new chat_id to bot
if (empty(serchChatId($chat_id))) {
    # put new chat_id to database
    $fields = [
        'chat_id' => $chat_id,
        'user_telegram' => $user_name,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ];
    $id = addChatId($fields);
}
