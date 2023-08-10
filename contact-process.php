<?php
// require 'vendor/autoload.php';

// # [START gae_slim_front_controller]
// $app = new Slim\App();
// $app->get('/', function ($request, $response) {
//     // Use the Null Coalesce Operator in PHP7
//     // http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.coalesce
//     $name = $request->getQueryParams()['name'] ?? 'World';
//     return $response->getBody()->write("Hello, $name!");
// });
// $app->run();

	// FIRST: 
	// Instead of test@test.com put the email address of the mailing list
  use \google\appengine\api\mail\Message;
  use google\appengine\api\users\User;
  use google\appengine\api\users\UserService;
  

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$emailTo = 'ranarajesh495@gmail.com'; // Change with your Email address
	$contactSubject = 'Contact Form Website'; // Change Subject

  
  

	// SECOND:
	// save this file, and close it. Thank you!
  

	$contactName = $contactEmail = $contactMessage = "";

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

	$contactSubject = test_input($_POST["contactSubject"]);

	$contactMessage = isset( $_POST["contactMessage"] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", test_input($_POST['contactMessage']) ) : "";

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
// echo $contactEmail;
// echo $contactMessage;
// echo $contactName;
// echo $contactSubject;
$body_form=" 'Name: '$contactName '\n ' 'Email:'$Email=$contactEmail  ' \n''Subject:' $subject= $contactSubject ' \n''Message:' $message= $contactMessage";
	// if(!isset($hasError)) {
	// 	mail($emailTo, $contactSubject, $contactMessage, "From: " . $contactName . " <" . $contactEmail . ">");
	// }

  try {

    $message = new Message();
    $message->setSender('360digitran@gmail.com');
    $message->addTo('vikas@360digitaltransformation.com');
    $message->setSubject('360DT- Contact form');
    $message->setTextBody($body_form);
    $message->send();

    // header("Location: /mail_sent");

} catch (InvalidArgumentException $e) {

    $error = "Unable to send mail. $e";
}
?>