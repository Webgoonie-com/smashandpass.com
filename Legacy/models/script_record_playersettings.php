<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');




print_r($_POST);
if(!$_POST){ exit(); }
if(!$_POST['view_letmeview']){ exit(); }



if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['view_iama'], $_POST['view_letmeview'], $_POST['view_agerange'], $_POST['view_zipcode'])){


				
				



			

	

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$user_view_iama = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['view_iama']));
			$user_view_letmeview = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['view_letmeview']));
			$user_view_agerange = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['view_agerange']));
			$user_view_zipcode = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['view_zipcode']));



			$user_last_loggedin = date('Y-m-d h:i:s');






// Update User With Logged In Time
	$user_last_loggedin = date('Y-m-d h:i:s');
	$Logviewchange_query="UPDATE `smashan_smashandpass`.`users` SET 	
	`user_view_iama` = '$user_view_iama',
	`user_view_letmeview` = '$user_view_letmeview',
	`user_view_agerange` = '$user_view_agerange',
	`user_view_zipcode` = '$user_view_zipcode',
	`user_last_loggedin` = '$user_last_loggedin' WHERE `user_id` = '$user_id'";
	$run_Logviewchange_query = mysqli_query($webgoneGlobal_mysqli, $Logviewchange_query);

echo "
<script>
	window.location = 'news'
</script>
";



}else{

	exit();

}
