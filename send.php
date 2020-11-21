<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$mail = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Формирование самого письма
$title = "Новое обращение - Best Tour Plan";
$body = "
<h2>Новое обращение</h2>
<b>Имя:</b> $name<br>
<b>Телефон:</b> $phone<br>
<b>Сообщение:</b><br>$message<br>
<b>Почта:</b> $mail
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host       = 'smtp.yandex.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'rudbog01@gmail.com'; // Логин на почте
    $mail->Password   = 'Bohdan1993'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('rudbog01@gmail.com', 'Rudenko Bohdan'); // Адрес самой почты и имя отправителя


    // Получатель письма
    $mail->addAddress('rudbog01@gmail.com');
    // $mail->addAddress('goncharovnikita713@gmail.com');

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отравленность сообщения
    if ($mail->send()) {
        $result = "success";
        header('Location: thankyou.html');
    } else {
        $result = "error";
        header('Location: error.html');
    }
} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
