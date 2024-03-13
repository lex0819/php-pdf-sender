<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php';
//all subscribers from DB
function listOfSubscribers(): array
{
    $sql = "SELECT * FROM subscrubers ORDER BY subscribe_name ASC";
    $query = dbQuery($sql);
    $res =  $query->fetchAll();
    $res = is_array($res) ? $res : [];
    return $res;
}

//add new subscriber to DB
function subscriberAdd(array $fields): int
{
    $db = dbInstance();
    $sql = "INSERT INTO subscrubers (subscribe_name, email, telegram) VALUES (:name, :email, :telegram)";
    $query = dbQuery($sql, $fields);

    $id = $db->LastInsertId();
    return $id;
}

//serch one subscriber by id
function subscriberOne(int $id): array
{
    $sql = "SELECT * FROM subscrubers WHERE id = :id";
    $query = dbQuery($sql, ['id' => $id]);
    $res = $query->fetch();
    $res = is_array($res) ? $res : [];
    return $res;
}

//searching record by email
function searchEmail(string $email): array
{
    $sql = "SELECT * FROM subscrubers WHERE email = :email";
    $query = dbQuery($sql, ['email' => $email]);
    $res = $query->fetch();
    $res = is_array($res) ? $res : [];
    return $res;
}

//searching record by telegram
function searchTelegram(string $telegram): array
{
    $sql = "SELECT * FROM subscrubers WHERE telegram = :telegram";
    $query = dbQuery($sql, ['telegram' => $telegram]);
    $res = $query->fetch();
    $res = is_array($res) ? $res : [];
    return $res;
}

//delete the subscriber by id
function subscriberDelete(int $id): bool
{
    $sql = "DELETE FROM subscrubers WHERE id = $id";
    dbQuery($sql);
    return true;
}

// get all email addresses
function getAllEmails(): array
{
    $sql = "SELECT * FROM subscrubers WHERE email <> ''";
    $query = dbQuery($sql);
    $res =  $query->fetchAll();
    $res = is_array($res) ? $res : [];
    return $res;
}

//get all telegram addresses
function getAllTelegrams(): array
{
    $sql = "SELECT * FROM subscrubers WHERE telegram <> ''";
    $query = dbQuery($sql);
    $res =  $query->fetchAll();
    $res = is_array($res) ? $res : [];
    return $res;
}
