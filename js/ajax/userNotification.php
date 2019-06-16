<?php
if ($_POST) {

$user_email=$_POST['email'];
$message=$_POST['msg'];

$c = true;
    $project_name = 'moonrock.store';
    $form_subject = 'Ваш заказ на сайте!';    
    $from_email="outbox@moonrock.store";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$from_email.'>' . PHP_EOL .
'Reply-To: '.$from_email.'' . PHP_EOL;

mail($user_email, adopt($form_subject), $message, $headers );

}