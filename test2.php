<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/PHPMailer-master/PHPMailerAutoload.php');

$mail = new PHPMailer;

// Настройка SMTP
$mail->isSMTP();
$mail->Host = 'smtp.mail.ru';
$mail->SMTPAuth = true;
$mail->Username = 'robot2@r97.ru';
$mail->Password = 'G3ZbuLtpCYWcahLRJaar';
$mail->SMTPSecure = 'tls';                  
$mail->Port = 587;

// Настройки письма
$mail->setFrom('robot2@r97.ru', 'R97.RU');
$mail->addAddress('test45_45@mail.ru', 'Получатель');
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = 'Тестовое письмо';
$mail->Body    = '<h1>Привет!</h1><p>Это тестовое письмо с помощью PHPMailer.</p>';
$mail->AltBody = 'Привет! Это тестовое письмо с помощью PHPMailer.';

// Отправка письма
if($mail->send()) {
    echo 'Письмо успешно отправлено!';
} else {
    echo 'Ошибка отправки письма: ' . $mail->ErrorInfo;
}
?>