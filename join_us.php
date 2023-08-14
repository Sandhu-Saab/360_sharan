<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<div style="text-align:center;">
<h1>Thank you!</h1>
<p>Your submission has been received.</p>
<span id="timer">
</span>
</div>
<script type="text/javascript">
var count = 5;
var redirect = "index.html";
 
function countDown(){
    var timer = document.getElementById("timer");
    if(count > 0){
        count--;
        timer.innerHTML = "This page will redirect in "+count+" seconds.";
        setTimeout("countDown()", 1000);
    }else{
        window.location.href = redirect;
    }
}
countDown();
</script>
</html>


<?php
use \google\appengine\api\mail\Message;
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  // require 'vendor/phpmailer/phpmailer/src/Exception.php';
  // require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
  // require 'vendor/phpmailer/phpmailer/src/SMTP.php';

  $contactName = $contactEmail = $contactlinkedin = $resume =  "";

	$contactName = test_input($_POST["contactName"]);
 
  
	if(trim($_POST['contactEmail']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['contactEmail']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$contactEmail = test_input($_POST['contactEmail']);
	}

	$contactlinkedin = test_input($_POST["contactlinkedin"]);
    $contactNumber = test_input($_POST["contactNumber"]);
    // $resume = file_get_contents($_POST["resume"]);
    $resume = 'resume/' . $_FILES["resume"]["name"];
    move_uploaded_file($_FILES["resume"]["tmp_name"], $path);


	// $contactMessage = isset( $_POST["contactMessage"] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", test_input($_POST['contactMessage']) ) : "";

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
        return $data;
    }
        $body_form=" Name: $contactName \n  Email:$contactEmail   \n''Number: $contactNumber  \n Linkedin ID: $contactlinkedin \n Resume: $resume";
	// if(!isset($hasError)) {
	// 	mail($emailTo, $contactSubject, $contactMessage, "From: " . $contactName . " <" . $contactEmail . ">");
	// }

  try {

    $message = new Message();
    $message->setSender('trainings.360.dt@gmail.com');
    $message->addTo('vikas@360digitaltransformation.com');
    $message->setSubject('360DT- Contact form');
    $message->setTextBody($body_form);
    $message->addAttachment($path);
    // $message->addStringAttachment(file_get_contents($resume), 'resume.pdf','resume.doc','resume.docx');
    $message->send();

    // header("Location: /mail_sent");
 
} catch (InvalidArgumentException $e) {

    $error = "Unable to send mail. $e";
}
?>