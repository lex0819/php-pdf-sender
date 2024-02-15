<?php

// $name = $_POST['name'];
// $phone = $_POST['phone'];
// $email = $_POST['email'];
// var_dump($_POST);
//var_dump(__DIR__);
extract($_POST, EXTR_SKIP,);
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//подключение без композера
require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';

// Проверка того, что есть данные из <div> капчи, user checked box
if (!$_POST["g-recaptcha-response"]) {
    // Если данных нет, то программа останавливается и выводит ошибку
    echo json_encode(['mes01' => 'Error', 'mes02' => 'recaptcha was not chosen']);
    exit('recaptcha is not valid');
} else {
    // create a request to google to verify the authenticity of the recaptcha
    // URL куда отправлять запрос для проверки
    $url = "https://www.google.com/recaptcha/api/siteverify";
    // Ключ для сервера
    $key = "6Lc701weAAAAAGS6hvRWqThh0S-OfmgRJG3CuNeK";
    // Данные для запроса
    $query = [
        "secret" => $key, // Ключ для сервера
        "response" => $_POST["g-recaptcha-response"], // Данные от капчи
        "remoteip" => $_SERVER['REMOTE_ADDR'] // Адрес сервера
    ];

    // Создаём запрос для отправки 
    $ch = curl_init();
    // Настраиваем запрос 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    // отправляет и возвращает данные
    $data = json_decode(curl_exec($ch), $assoc = true);
    // Закрытие соединения
    curl_close($ch);

    // Если нет success то
    if (!$data['success']) {
        // Останавливает программу и выводит "ВЫ РОБОТ"
        echo json_encode(['mes01' => 'Error', 'mes02' => "recaptcha isn't authentic"]);
        exit('Yor are bot');
        // exit("ВЫ РОБОТ");
    } else {
        // Иначе отправляем письма менеджерам

        $where_is_server = __DIR__;

        $email_body = (isset($modal__descr)) ?
            "{$where_is_server}<br>Hi<br>User sended his some information<br> Message from {$name}<br> phone is {$phone}<br> email is {$email}<br> product name is {$modal__descr} " :
            "{$where_is_server}<br>Hi<br>User sended his some information<br> Message from {$name}<br> phone is {$phone}<br> email is {$email} ";

        $email_subject = (isset($modal__descr)) ? "{$modal__descr} request from {$name}" : "Puls request from {$name}";

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->CharSet = 'utf-8';
            $mail->SMTPDebug = 0; //debag Off, 2 or 3 is debug On
            $mail->isSMTP();  //Send using SMTP
            $mail->Host = 'smtp.mail.ru'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'lex0819@bk.ru'; //SMTP username
            $mail->Password = 'DCZneubJLLc0q5AFR6vH'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $mail->Port = 465; //TCP port was provided your SMTP server
            //$mail->SMTPKeepAlive = true; //for gmail.com

            //Recipients
            $mail->setFrom('lex0819@bk.ru', 'Mailer'); //It must be equal SMTP username
            $mail->addAddress('lex0819@yandex.ru'); //Add a first recipient
            $mail->addAddress('lexmolnar@gmail.com');  //Add a second recipient
            //$mail->addAddress('third@some-mail.com');  //Add a third recipient etc

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);  //Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body = $email_body;
            // $mail->AltBody = `Hi Message from {$name} phone is {$phone} email is {$email}`;

            $mail->send();

            // echo 'Message has been sent';
            echo json_encode([
                'mes01' => 'Спасибо за вашу заявку!',
                'mes02' => 'Наш менеджер свяжется с вами<br>в ближайшее время!',
            ]);
            return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $error_mail = 'Mailer Error: ' . $mail->ErrorInfo;
            echo json_encode([
                'mes01' => 'Message could not be sent',
                'mes02' => $error_mail,
            ]);
            return false;
        }
    }
}
