<?php

include("../classes/db_connect.php");

include("../classes/restrict_login.php");



if(!empty($_FILES)){

//print_r($_FILES);
	
/*	
	$temp = $_FILES['file']['tmp_name'];
	
	$ds = DIRECTORY_SEPARATOR;
	
	$folder = "uploads";


	$destination_path = dir(__FILE__).$ds.$folder.$ds;
	
	$target_path = $ds.$_FILES['file']['name'];

*/

	$count_files = count($_FILES['file']['name']);

	//echo 'Count  Files: '.$count_files;

	for ($x = 0; $x <= (int)$count_files; $x++) {
	
	$x = (int)$x;

	if($x == $count_files) exit();
	
	
	$image_blob = addslashes(file_get_contents($_FILES['file']['tmp_name'][$x]));
	$image_name = $_FILES['file']['name'][$x];
	$image_size = $_FILES['file']['size'][$x];
	$image_type = $_FILES['file']['type'][$x];

	//list($uphotowidth, $uphotoheight) = getimagesize($image_blob);
    //echo $uphotowidth; 
    //echo $uphotoheight;
	
 	$photodata = getimagesize($_FILES['file']['tmp_name'][$x]);
	$uphotowidth = $photodata[0];
	$uphotoheight = $photodata[1];





$insert_userimage_blob_sql = "
INSERT INTO `smashan_smashandpass`.`user_imgblobs` SET
	`userblob_users_id` = '$user_id',
	`userblob_image` = '$image_blob',
	`userblob_image_name` = '$image_name',
	`userblob_image_profilepic` = 'N',
	`userblob_image_size` = '$image_size',
	`userblob_image_type` = '$image_type',
	`userblob_image_width` = '$uphotowidth',
	`userblob_image_height` = '$uphotoheight'

";



$ran_userimage_blob_sql = mysqli_query($webgoneGlobal_mysqli, $insert_userimage_blob_sql);
//$sys_userimage_blob_id = mysqli_insert_id($webgoneGlobal_mysqli);
	


}
	
	
	
	
	
	
	
}





?>