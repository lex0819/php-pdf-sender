<?php

// функция отправки сообщения от бота в диалог с юзером
function message_to_telegram($bot_token, $chat_id, $text, $reply_markup = '')
{
    $ch = curl_init();
    $ch_post = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $bot_token . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup,
        ]
    ];

    curl_setopt_array($ch, $ch_post);
    curl_exec($ch);
}

// сохранить состояние бота для пользователя
function set_bot_state($chat_id, $data)
{
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/users/' . $chat_id . '.txt', $data);
}

// получить текущее состояние бота для пользователя
function get_bot_state($chat_id)
{
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/users/' . $chat_id . '.txt')) {
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/users/' . $chat_id . '.txt');
        return $data;
    } else {
        return '';
    }
}
