<?php

require_once("Mail.php");


if(!$_POST) exit;

echo 'Begin';



print_r($_POST);

if(isset($_POST['join_fname'], $_POST['join_lname'], $_POST['join_email'], $_POST['msg_token'])){
			


			
			$join_email = $_POST['join_email'];


			$name = "Smash And Pass";

			$msg_token = $_POST['msg_token'];			
			$link = 'http://smashandpass.com/messages/msg/$msg_token';



			 ini_set ("SMTP", "gator4009.hostgator.com");
			 
			 $SendToEmail = $_POST['join_email'];
			 
			 $from = "SmashAndPass <info@smashandpass.com>";
			 
			 //$to = "Email Recipient <webgoonie@gmail.com>";
			 $To = $SendToEmail;
			 $bcc = "webgoonie.com@gmail.com";
			 $recipients = $To.",".$bcc;
			
			 $subject = "Message Online At SmashAndPass.com";

			
$body = "
<div>
<p></p>
<p>$name,</p>
<p>We Have A Message For You At SmashAndPass.com.  To view simply follow the instructions below.</p>
<p>Message link: <a href='http://smashandpass.com/messages/msg/$msg_token' target='_blank'>Click Here To View Online</a>.</p>
</div>
";
 

	$host = "gator4009.hostgator.com";
	$username = "info@smashandpass.com";
	$password = "hotCoaldNap99!#!";
 
	$headers = array ('From' => $from,
	'To' => $To,
	'Subject' => $subject,
	'MIME-Version' => '1.0',
	'Content-Type' => "text/html; charset=ISO-8859-1\r\n\r\n"
	);

	$smtp = Mail::factory('smtp',
	   array ('host' => $host,
		 'auth' => true,
		 'username' => $username,
		 'password' => $password));
 
	$mail = $smtp->send($recipients, $headers, $body);
	





			
			
}


?>