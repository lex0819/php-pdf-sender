<?php

/**
 *   Very simple chat bot @verysimple_bot by Novelsite.ru
 *   05.07.2021
 */

include_once './functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';

header('Content-Type: text/html; charset=utf-8'); // на всякий случай досообщим PHP, что все в кодировке UTF-8

$bot_token = BOT_TOKEN; // токен вашего бота
/**
 * php://input
 * is a cpesial stream 
 * raw POST request 
 */
$response = file_get_contents('php://input'); // весь ввод перенаправляем в $response
$data = json_decode($response, true); // декодируем json-закодированные-текстовые данные в PHP-массив

$order_chat_id = CHAT_ID;  //chat_id менеджера компании для заявок
$bot_state = ''; // состояние бота, по-умолчанию пустое

// Для отладки, добавим запись полученных декодированных данных в файл message.txt, 
// который можно смотреть и понимать, что происходит при запросе к боту
// Позже, когда все будет работать закомментируйте эту строку:
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logs/message.txt', print_r($data, true), FILE_APPEND | LOCK_EX);

// Основной код: получаем сообщение, что юзер отправил боту и 
// заполняем переменные для дальнейшего использования
if (!empty($data['message']['text'])) {
    $chat_id = $data['message']['from']['id'];
    $user_name = $data['message']['from']['username'];
    $first_name = $data['message']['from']['first_name'];
    $last_name = $data['message']['from']['last_name'];
    $text = trim($data['message']['text']);
    $text_array = explode(" ", $text);

    // if user wrote to bot something another
    $user_date = date('d/m/Y H:i:s', $data['message']['date']);
    $current_date = date("D M j G:i:s T Y");

    // получим текущее состояние бота, если оно есть
    $bot_state = get_bot_state($chat_id);

    // если текущее состояние бота отправка заявки, то отправим заявку менеджеру компании на $order_chat_id
    if (substr($bot_state, 0, 6) == '/order') {
        $text_return = "
Заявка от @$user_name:
Имя: $first_name $last_name 
$text
";
        message_to_telegram($bot_token, $order_chat_id, $text_return);
        set_bot_state($chat_id, ''); // не забудем почистить состояние на пустоту, после отправки заявки
    }
    // если состояние бота пустое -- то обычные запросы
    else {
        // вывод информации Помощь
        if ($text == '/help') {
            $text_return = "Привет, $first_name $last_name, вот команды, что я понимаю: 
    /help - список команд
    /about - о нас
    /order - оставить заявку
    ";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/help');
        }

        // вывод информации о нас
        elseif ($text == '/about') {
            $text_return = "pdfsender_bot:
    Я пример простого бота для телеграм, написанного на простом PHP.";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/about');
        }

        // enter start. It's start of communication
        elseif ($text == '/start') {
            $text_return = "Hi $first_name $last_name! 
    I'm glad to see you! 
    You've connected to me!
    Welcome!
";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/start');
        }

        // переход в режим Заявки
        elseif ($text == '/order') {
            $text_return = "$first_name $last_name, для подтверждения Заявки введите текст вашей заявки и нажмите отправить. 
Наши специалисты свяжутся с вами в ближайшее время!
";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/order');
        }

        // if user wrote to bot something another
        else {
            $text_return = "Hi $first_name $last_name!
            You wrote $text to me 
            at $user_date.
            
            I'm very glad to see you.
            
            Now $current_date";

            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '');
        }
    }
}
