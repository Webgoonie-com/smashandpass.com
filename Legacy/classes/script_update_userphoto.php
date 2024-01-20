<?php
include("db_connect.php");

include("restrict_login.php");



//print_r($_POST);


if(isset($_POST['pic_id'])){


			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$pic_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['pic_id']));


			$userblob_profilepic_timelist = date('Y-m-d h:i:s');

	$update_user_photo_sql = "
		UPDATE `smashan_smashandpass`.`user_imgblobs` SET
			`userblob_image_profilepic` = 'Y',
			`userblob_profilepic_timelist` = '$userblob_profilepic_timelist'			
			WHERE
			 `userblob_id` = '$pic_id'
			 ";

	
			$run_update_user_photo_sql =  mysqli_query($webgoneGlobal_mysqli, $update_user_photo_sql) or die(mysqli_connect_errno());
			 


}

?>