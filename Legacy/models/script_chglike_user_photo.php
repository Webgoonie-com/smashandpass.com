<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');




//print_r($_POST);

if(!$_POST){ exit(); }
if(!$_POST['photoid']){ exit(); }


if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['photoid'])){



	
	
	
	
	

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$photoid = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['photoid']));



$find_user_photoquery = "SELECT * FROM `smashan_smashandpass`.`likes_collection`, `smashan_smashandpass`.`users` WHERE `likes_collection`.`like_user_id`  = `likes_collection`.`like_user_id` AND `user_id`  = '$user_id' AND `like_blob_id` = '$photoid'  ORDER BY `like_id` DESC LIMIT 1";
$result_photoofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_photoquery);
$row_photoofuser = mysqli_fetch_assoc($result_photoofuser);
$totalRows_photoofuser = mysqli_num_rows($result_photoofuser);	

$like_id = $row_photoofuser['like_id'];

			$userblob_profilepic_timelist = date('Y-m-d h:i:s');

	$like_user_photo_sql = "
		DELETE FROM `smashan_smashandpass`.`likes_collection`			
			WHERE
			 `like_id` = '$like_id'
			 ";

	
			$run_like_user_photo_sql =  mysqli_query($webgoneGlobal_mysqli, $like_user_photo_sql) or die(mysqli_connect_errno());
	
	
	//echo 'DELETED FILENAME: '.$_POST['id'];


}else{

	exit();

}



?>