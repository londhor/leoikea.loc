<?php
$c = true;
$project_name = 'Moonrock.store';
$form_subject = 'Соосбщение с сайта!';    
$admin_email="moonrock.wr@gmail.com";
$from_email="outbox@moonrock.store";

foreach ( $_POST as $key => $value ) {
    if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
        $message .= "
            " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
        </tr>
        ";
    }
}
$message = "<table style='width: 100%;'>$message</table>";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$from_email.'>' . PHP_EOL .
'Reply-To: '.$from_email.'' . PHP_EOL;

mail($admin_email, adopt($form_subject), $message, $headers );

?>