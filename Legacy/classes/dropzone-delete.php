<?php


include("db_connect.php");

include("restrict_login.php");

//print_r($_POST['id']);

//print_r($_POST);
if(!$_POST){ exit(); }
if(!$_POST['id']){ exit(); }

if(isset($_POST['id'])){
	
	
	
	
	


			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$pic_filename = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['id']));



$find_user_photoquery = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs`, `smashan_smashandpass`.`users` WHERE `userblob_users_id` AND `user_id`  = '$user_id' AND `userblob_image_name` = '$pic_filename'  ORDER BY `userblob_id` DESC LIMIT 1";
$result_photoofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_photoquery);
$row_photoofuser = mysqli_fetch_assoc($result_photoofuser);
$totalRows_photoofuser = mysqli_num_rows($result_photoofuser);	

$userblob_id = $row_photoofuser['userblob_id'];

			$userblob_profilepic_timelist = date('Y-m-d h:i:s');

	$update_user_photo_sql = "
		DELETE FROM `smashan_smashandpass`.`user_imgblobs`			
			WHERE
			 `userblob_id` = '$userblob_id'
			 ";

	
			$run_update_user_photo_sql =  mysqli_query($webgoneGlobal_mysqli, $update_user_photo_sql) or die(mysqli_connect_errno());
	
	
	echo 'DELETED FILENAME: '.$_POST['id'];
	
	
}


?>