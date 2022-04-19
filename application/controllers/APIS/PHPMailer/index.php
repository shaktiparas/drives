<?php

require("class.PHPMailer.php");

$mail = new PHPMailer();
//echo phpinfo();


if($mail->IsSMTP())
{
    echo"is smtp";
}
else
{
    echo"not smtp";
}
                                      // set mailer to use SMTP
$mail->Host = "mail.juniper.arvixe.com";  // specify main and backup server
$mail->Port = 25; 
$mail->SMTPDebug  = 1; 
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "noreply@eufory.org";  // SMTP username
$mail->Password = "12345"; // SMTP password

$mail->From = "noreply@eufory.org";
$mail->FromName = "Mailer";
$mail->AddAddress("shakticool75@gmail.com");                 // name is optional

                                 // set email format to HTML

$mail->Subject = "Here is the subject";
$mail->Body    = "This is the HTML message body";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   
}
else
{
echo "Message has been sent";
}
?>