<?php
/**
 * Author: ahmed-dinar
 * Date: 5/30/17
 *
 */

$start = microtime(true);

require_once 'libs/SendMail.php';

$mail = new SendMail('justoj.com@gmail.com','Test sendmail class', 'Basundia school and college');
$mail->setBody("This is really a stupid body, please ignore");
if( $mail->send() ){
    echo "<br>Mail sent! Yay!!<br>";
}else{
    echo "<br>Mail sent error!!! :(<br>";
    echo $mail->getError();
}

$time_elapsed_secs = microtime(true) - $start;
echo '<br><b>Total Execution Time:</b> '.$time_elapsed_secs.' Seconds';


/*
date_default_timezone_set('Etc/UTC');

require 'libs/PHPMailer/PHPMailerAutoload.php';
$config = require('config/config.php');
$mail = new PHPMailer;

$mail->isSMTP();
$mail->SMTPDebug = 1; //set 0 for production
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission also, Gmail SMTP port (SSL): 465
$mail->Port = 587;
$mail->SMTPSecure = 'tls';

$mail->Username = $config->gmail->mail;
$mail->Password = $config->gmail->password;
$mail->SetFrom("example@gmail.com");
$mail->addAddress('justoj.com@gmail.com');
$mail->Subject = 'PHPMailer GMail SMTP test';
$mail->Body = 'Hello there! i am stupid email :)';

//send the message, check for errors
if (!$mail->send()) {
    echo "<br><br>Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}*/

