<?php
if(isset($_POST["sendmail"])){
	include("mailing.php");
	$recipient = $_POST["sendmail"];
	$subject = $_POST["subject"];
	$message = $_POST["message"];
	sendmail($recipient, $subject, $message);
	echo "Email has been sent!";
}