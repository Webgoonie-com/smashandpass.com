<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');






if(isset($_POST['_thisaboutme'], $_POST['usr_cookie'], $_POST['user_id'])){



			$thisaboutme = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['_thisaboutme']));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$thisuser_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));

$update_useraboutme_sql = "
 UPDATE `smashan_smashandpass`.`users` SET
	`user_aboutme` = '$thisaboutme'
			WHERE
			 `user_id` = '$user_id'
			 ";
		

$ran_useraboutme_sql = mysqli_query($webgoneGlobal_mysqli, $update_useraboutme_sql);






}else{

	exit();

}



?>