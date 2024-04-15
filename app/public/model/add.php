<?php
session_start();
require_once __DIR__ . '/init.php';

if (empty($_POST)) {
    require_once('../view/add.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $check_name = false;
    $check_email = false;
    $check_telegram = false;

    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telegram = htmlspecialchars(trim($_POST['telegram']));

    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['errors_email'] = '';
    $_SESSION['telegram'] = $telegram;
    $_SESSION['errors_telegram'] = '';

    if (mb_strlen($name, 'UTF-8') < 3) {
        $_SESSION['errors_name'] = 'Name is not valid!';
    } else {
        unset($_SESSION['errors_name']);
        $check_name = true;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors_email'] = 'Email address is not valid!';
    } else {
        unset($_SESSION['errors_email']);
        $check_email = true;
    }

    $pattern_telegram = "/.*\B@(?=\w{5,32}\b)[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)*.*/";
    if (empty($telegram) || !preg_match($pattern_telegram, $telegram)) {
        $_SESSION['errors_telegram'] = "Telegram is not valid! \r\n";
    } elseif (empty(serchUserTelegram(substr(trim($telegram), 1)))) {
        $_SESSION['errors_telegram'] .= "User is not a friend with the bot! \r\n";
    } else {
        unset($_SESSION['errors_telegram']);
        $check_telegram = true;
    }

    if ($check_name && ($check_email || $check_telegram)) {
        $fields = [
            'name' => $name,
            'email' => $email,
            'telegram' => $telegram
        ];
        $id = subscriberAdd($fields);
        // var_dump($_SERVER['HTTP_HOST']);
        header("Location: https://" . $_SERVER['HTTP_HOST'] . "/model/subscribers.php");
        exit;
    } else {
        include_once('../view/add_post.php');
    }
}
