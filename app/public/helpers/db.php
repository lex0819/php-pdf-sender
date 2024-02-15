<?php

function dbInstance(): PDO
{
    static $db;

    if ($db === null) {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $db->exec('SET NAMES UTF8');
    }

    return $db;
}

function dbQuery(string $sql, array $params = []): PDOStatement
{
    $db = dbInstance();
    $query = $db->prepare($sql);
    $query->execute($params);
    dbCheckError($query);
    return $query;
}

function dbCheckError(PDOStatement $query): bool
{
    $errInfo = $query->errorInfo();

    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }

    return true;
}

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
