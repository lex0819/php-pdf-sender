<?php

/**
 *   Very simple chat bot @verysimple_bot by Novelsite.ru
 *   05.07.2021
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/model/init.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/credentials/cred_telegram.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/telegram/functions.php';

header('Content-Type: text/html; charset=utf-8'); // на всякий случай сообщим PHP, что все в кодировке UTF-8

$bot_token = BOT_TOKEN; // токен вашего бота
$owner_chat_id = OWNER_CHAT_ID; // owner's chat_id with own bot
/**
 * php://input
 * is a special stream 
 * raw POST request 
 */

$response = json_decode(file_get_contents('php://input'), true); // весь ввод перенаправляем в $response, декодируем json-закодированные-текстовые данные в PHP-массив

$order_chat_id = GROUP_CHAT_ID;  //chat_id менеджера компании для заявок
$bot_state = ''; // состояние бота, по-умолчанию пустое

setLogs("\n\n");
setLogs($response);

// Основной код: получаем сообщение, что юзер отправил боту и 
// заполняем переменные для дальнейшего использования
if (!empty($response['message']['text'])) {
    $chat_id = $response['message']['from']['id'];
    $user_name = isset($response['message']['from']['username']) ? $response['message']['from']['username'] : '';
    $first_name = $response['message']['from']['first_name'];
    $last_name = isset($response['message']['from']['last_name']) ? $response['message']['from']['last_name'] : '';
    $text = trim($response['message']['text']);
    $text_array = explode(" ", $text);

    $temp_log = "$chat_id, $user_name, $first_name, $last_name, $text";
    setLogs("\n");
    setLogs($temp_log);

    //Check new chat_id to bot
    $is_new = setNewUserBot($chat_id, $user_name, $first_name, $last_name);
    if($is_new ){
        $owner_text = strval($chat_id) . ", " . $user_name . ", " . $first_name . ", " . $last_name . ", " . $text . " \n\n";

        echo '<pre>$owner_text';
        var_dump($owner_text);
        echo '</pre>';
        // send me issue about new user who've linked to my bot
        message_to_telegram($bot_token, $owner_chat_id, $owner_text);
    }

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

        setLogs('/order');
    } else {
        // если состояние бота пустое -- то обычные запросы
        setLogs($text);
        if ($text === '/help') {
            // вывод информации Помощь
            $text_return = "Привет, $first_name $last_name, вот команды, что я понимаю: 
    /help - список команд
    /about - о нас
    /order - оставить заявку
    ";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/help');
        } elseif ($text === '/about') {
            // вывод информации о нас
            $text_return = "pdfsender_bot:
    Я пример простого бота для телеграм, написанного на простом PHP.";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/about');
        } elseif ($text === '/start') {
            // enter start. It's start of communication
            $text_return = "Hi $first_name $last_name! 
    I'm glad to see you! 
    You've connected to me!
    Welcome!
";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/start');
        } elseif ($text === '/order') {
            // переход в режим Заявки
            $text_return = "$first_name $last_name, для подтверждения Заявки введите текст вашей заявки и нажмите отправить. 
Наши специалисты свяжутся с вами в ближайшее время!
";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state($chat_id, '/order');
        } else {
            // if user wrote to bot something another
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
