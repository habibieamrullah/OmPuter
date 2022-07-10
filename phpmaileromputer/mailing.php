<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//require("vendor/phpmailer/phpmailer/class.phpmailer.php");
//require("vendor/phpmailer/phpmailer/class.smtp.php");
require("phpmailer.php");
require("smtp.php");




function sendmail($recipient, $subject, $message){
	
	$emailhost = "mail.xxx.com";
	$emailusername = "noreply@xxx.com";
	$emailpassword = "orqIFQ#c4hPq";
	$emailfrom = "noreply@xxx.com";
	$websitetitle = "Situs Saya";
	
	
	$emailtemplatepre = "<!DOCTYPE html><html><head></head><body style='padding: 40px; margin: 0px; background-color: white;'><div style='margin: 40px; background-color: #fdf8ff; padding: 20px; border-radius: 5px; box-sizing: border-box;'>";
	$emailtemplatepost = "</div></body></html>";
	
	
    $message = str_replace("\\r\\n", "", $message);
    $message = stripslashes($message);
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $emailhost;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = 'true';                               // Enable SMTP authentication
        $mail->Username = $emailusername;       // SMTP username
        $mail->Password = $emailpassword;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; 
		// TCP port to connect to
    
        $mail->setFrom($emailfrom, $websitetitle);
        //$mail->AddReplyTo($emailfrom, $websitetitle); //ini buat alamat reply
        //$mail->From = $emailfrom;
        
    	//Recipients
		if(strpos($recipient, ',') !== false ){
			$recipients = explode(',', $recipient);
			foreach($recipients as $r){
				if($r != ""){
					$mail->addAddress($r);     // Add a recipient
				}
			}
		}else{
			$mail->addAddress($recipient);     // Add a recipient
		}
    	
    
        $mailbody = $emailtemplatepre . $message . $emailtemplatepost;
     
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $mailbody;
        $mail->AltBody = strip_tags($mailbody);
    
        $mail->send();
        //echo 'ok';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
