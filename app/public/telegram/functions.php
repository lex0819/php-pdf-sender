<?php

// функция отправки сообщения от бота в диалог с юзером
function message_to_telegram(string $bot_token, int $chat_id, string $text, string $reply_markup = '')
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
function set_bot_state(int $chat_id, string $data)
{
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/users/' . strval($chat_id) . '.txt', $data);
}

// получить текущее состояние бота для пользователя
function get_bot_state(int $chat_id): string
{
    $chat_id_str = strval($chat_id);
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/users/' . $chat_id_str . '.txt')) {
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/users/' . $chat_id_str . '.txt');
        return $data;
    } else {
        return '';
    }
}

// проверить, что пришел новый юзер и записать его chat_id в базу friends_of_bot
function setNewUserBot(int $chat_id, string $user_name, string $first_name, string $last_name): bool
{
    echo '<pre>$chat_id';
    var_dump($chat_id);
    echo '</pre>';
    echo '<pre>serchChatId($chat_id)';
    var_dump(serchChatId($chat_id));
    echo '</pre>';

    // Check new chat_id to bot
    if (empty(serchChatId($chat_id))) {
        # put new chat_id to database
        $fields = [
            'chat_id' => $chat_id,
            'user_telegram' => $user_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];
        addChatId($fields);
        return true;
    }else{
        return false;
    }
}

function pdf_to_telegram(string $bot_token, int $chat_id, string $file_name)
{
    // Create CURL object
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $bot_token . "/sendDocument");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);


    // Create CURLFile
    $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_name);
    $cFile = new CURLFile($file_name, $finfo);

    // Add CURLFile to CURL request
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "chat_id" => $chat_id,
        "document" => $cFile,
    ]);

    // Call
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

function multi_curl_pdf_to_telegram(string $bot_token, array $array_chat_id, string $file_name): array
{
    // Create MULTI_CURL object
    $multi_curl_handle = curl_multi_init();
    $array_curls = array();

    foreach ($array_chat_id as $chat_id) {
        // Create CURL object
        $curl_handle = curl_init();
        $array_curls[] = $curl_handle; //add to curls array

        curl_setopt($curl_handle, CURLOPT_URL, "https://api.telegram.org/bot" . $bot_token . "/sendDocument");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        // Timeout in seconds
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);


        // Create CURLFile
        $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_name);
        $cFile = new CURLFile($file_name, $finfo);

        // Add CURLFile to CURL request
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, [
            "chat_id" => $chat_id,
            "document" => $cFile,
        ]);

        // add curl to multi_curl array
        curl_multi_add_handle($multi_curl_handle, $curl_handle);
    }

    // Call multi_curl executing 
    $running = null;
    do {
        curl_multi_exec($multi_curl_handle, $running);
    } while ($running);

    $result = [];
    // echo '<pre>';
    // var_dump($array_curls);
    // echo '</pre>';
    foreach ($array_curls as $ch) {
        $response = curl_multi_getcontent($ch);

        $dd = json_decode($response, true);
        // echo '<pre>';
        // var_dump($dd);
        // echo '</pre>';

        $index_of_name = '';
        if (!empty($dd['result']['chat']['username'])) {
            $index_of_name = $dd['result']['chat']['username'];
        } elseif (!empty($dd['result']['chat']['first_name'])) {
            $index_of_name = $dd['result']['chat']['first_name'];
        } else {
            $index_of_name = 'noname';
        }
        $result[$index_of_name] = $dd['ok'];

        curl_multi_remove_handle($multi_curl_handle, $ch);
        curl_close($ch);
    }
    curl_multi_close($multi_curl_handle);
    return $result;
}

function setLogs(mixed $data)
{
    // Для отладки, добавим запись полученных декодированных данных в файл message.txt, 
    // который можно смотреть и понимать, что происходит при запросе к боту
    // Позже, когда все будет работать закомментируйте эту строку:
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logs/message.txt', var_export($data, true), FILE_APPEND | LOCK_EX);
}
