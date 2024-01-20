<?php
if(!$_POST) exit();
if(isset($_POST['image'])){



include("db_connect.php");

include("restrict_login.php");

$croped_image = $_POST['image'];
	//$thisraw_image = $_POST['image'];
	$thisraw_image = file_get_contents($_POST['image']);

$type = $_POST['type'];

list($type, $croped_image) = explode(';', $croped_image);
list($type, $croped_image) = explode(',', $croped_image);

$croped_image = base64_decode($croped_image);
$image_name = time().'.png';
// upload cropped image to server 

$user_profile_blob_time = date('Y-m-d h:i:s');



	if(!file_exists("../uploads/$user_id")){
		mkdir("../uploads/$user_id", 0777, true);
	}


$target_filepath = "uploads/$user_id/".$image_name;

file_put_contents("../uploads/$user_id/".$image_name, $croped_image);
//echo 'Cropped image uploaded successfully.';

	$thisraw_image = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($thisraw_image));

$update_userimage_blob_sql = "
 UPDATE `smashan_smashandpass`.`users` SET
	`user_profile_blob` = '$thisraw_image',
	`user_profile_type` = '$type',
	`user_profile_blob_time` = '$user_profile_blob_time',
	`user_blob_file_path` = '$target_filepath'
			WHERE
			 `user_id` = '$user_id'
			 ";
		

$ran_userimage_blob_sql = mysqli_query($webgoneGlobal_mysqli, $update_userimage_blob_sql);

$profile_photoblob_realblob_id= mysqli_insert_id($webgoneGlobal_mysqli);



$insert_user_profile_photoblobs_sql = "
 INSERT INTO `smashan_smashandpass`.`user_profile_photoblobs` SET
	`profile_photoblob_user_id` = '$user_id',
	`profile_photoblob_filepath` = '$target_filepath',
	`profile_photoblob_realblob_id` = '$profile_photoblob_realblob_id'
			 ";
		

$ran_insert_user_profile_photoblobs_sql = mysqli_query($webgoneGlobal_mysqli, $insert_user_profile_photoblobs_sql);



mysqli_close($webgoneGlobal_mysqli);



}
?>