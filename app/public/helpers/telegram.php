<?php

function serchChatId(int $chat_id): array
{
    $sql = "SELECT * FROM freinds_of_bot WHERE chat_id = :chat_id";
    $query = dbQuery($sql, ['chat_id' => $chat_id]);
    $res = $query->fetch();
    $res = is_array($res) ? $res : [];
    return $res;
}

function addChatId(array $fields): int
{
    $db = dbInstance();
    $sql = "INSERT INTO freinds_of_bot (chat_id, user_telegram, first_name, last_name) VALUES (:chat_id, :user_telegram, :first_name, :last_name)";
    $query = dbQuery($sql, $fields);

    $id = $db->LastInsertId();
    return $id;
}

function serchUserTelegram(string $user_telegram): array
{
    $sql = "SELECT * FROM freinds_of_bot WHERE user_telegram = :user_telegram";
    $query = dbQuery($sql, ['user_telegram' => $user_telegram]);
    $res = $query->fetch();
    $res = is_array($res) ? $res : [];
    return $res;
}
