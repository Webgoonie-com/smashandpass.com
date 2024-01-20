<?php

include("db_connect.php");


include("restrict_login.php");


$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];


$query_user_sql = "SELECT `user_id`, `user_token`, `user_emailverify`, `user_nickname`, `user_fname`, `user_lname`, `user_email`, `user_pointsvalue` FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$user_query = mysqli_query($webgoneGlobal_mysqli, $query_user_sql) or die(mysql_error());
$row_user = mysqli_fetch_assoc($user_query);
$totalRows_user = mysqli_num_rows($user_query);
$user_id = $row_user['user_id'];


if(isset($_POST['submit1'])){
	
	
	$image_blob = file_get_contents($_FILES['f1']['tmp_name']);
	$image_blob = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($image_blob));


 	$photodata = getimagesize($_FILES['file']['tmp_name'][$x]);
	$uphotowidth = $photodata[0];
	$uphotoheight = $photodata[1];

	$image_size =  mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_FILES['f1']['size']));
	$image_type =  mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_FILES['f1']['type']));




$insert_userimage_blob_sql = "
INSERT INTO `smashan_smashandpass`.`user_imgblobs` SET
	`userblob_users_id` = '$user_id',
	`userblob_image` = '$image_blob',
	`userblob_image_size` = '$image_size',
	`userblob_image_type` = '$image_type'
";



$ran_userimage_blob_sql = mysqli_query($webgoneGlobal_mysqli, $insert_userimage_blob_sql);
$sys_userimage_blob_id = mysqli_insert_id($webgoneGlobal_mysqli);

mysqli_close($webgoneGlobal_mysqli);
	
	
	
}

header("Location: /profile");

?>