<?php


if(!$_POST) exit();




// print_r($_POST);

if(isset($_POST['join_fname'], $_POST['join_lname'], $_POST['join_email'])){
			

			
			$join_email = $_POST['join_email'];


			$name = "Smash And Pass";



			 ini_set ("SMTP", "mail.smashandpass.com");
			 
			 $SendToEmail = $_POST['join_email'];
			 
			 $from = "SmashAndPass <info@smashandpass.com>";
			 
			 //$to = "Email Recipient <webgoonie@gmail.com>";
			 $To = $SendToEmail;
			 $bcc = "webgoonie@gmail.com";
			 $recipients = $To.",".$bcc;
			
			 $subject = "Please Verify Your Email At SmashAndPass.com";

			
$body = "
<div>
<p></p>
<p>$name,</p>
<p>Before you can fully take advantage of the community at Smash And Pass.  We need for you to verify you email address.</p>
<p>Email: $join_email</p><br /></p>
<p>Sent From <a href='https://smashandpass.com/verify/$user_token' target='_blank'>Click Here To Verify</a>.</p>
</div>
";
 

	$host = "mail.smashandpass.com";
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