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



$find_user_photoquery = "SELECT * FROM `smashan_smashandpass`.`user_profile_photoblobs`, `smashan_smashandpass`.`users` WHERE `profile_photoblob_user_id` AND `user_id`  = '$user_id' AND `profile_photoblob_id` = '$photoid'  ORDER BY `profile_photoblob_id` DESC LIMIT 1";
$result_photoofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_photoquery);
$row_photoofuser = mysqli_fetch_assoc($result_photoofuser);
$totalRows_photoofuser = mysqli_num_rows($result_photoofuser);	

$userblob_id = $row_photoofuser['profile_photoblob_id'];

			$userblob_profilepic_timelist = date('Y-m-d h:i:s');

	$delete_user_photo_sql = "
		DELETE FROM `smashan_smashandpass`.`user_profile_photoblobs`			
			WHERE
			 `profile_photoblob_id` = '$userblob_id'
			 ";

	if($totalRows_photoofuser != 0){

		$run_update_user_photo_sql =  mysqli_query($webgoneGlobal_mysqli, $delete_user_photo_sql) or die(mysqli_connect_errno());

	}	
		
	
	
	//echo 'DELETED FILENAME: '.$_POST['id'];


}else{

	exit();

}



?>
