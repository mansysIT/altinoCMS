<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

require '../class.phpmailer.php';

try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$body             = file_get_contents('contents.html');
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 587;                    // set the SMTP server port
	$mail->Host       = "smtp.gmail.com"; // SMTP server
	$mail->Username   = "mail.khbemiddeling";     // SMTP server username
	$mail->Password   = "dPSe7D5qzy";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("man10@poczta.fm","First Last");

	$mail->From       = "name@domain.com";
	$mail->FromName   = "First Last";

	$to = "man10@poczta.fm";

	$mail->AddAddress($to);

	$mail->Subject  = "First PHPMailer Message";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>