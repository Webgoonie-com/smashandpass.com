<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');






if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['member_id'], $_POST['private_comment_messsage'])){


			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['member_id']));
			$private_comment_messsage = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['private_comment_messsage']));
	
	

	
	
	$insert_friendship_req_sql = "
		INSERT INTO `smashan_smashandpass`.`user_messages` SET
						`usr_message_touser_id` = '$member_id',
						`usr_message_read` = '0',
						`usr_message_frmuser_id` = '$user_id',
						`usr_message_html` = '$private_comment_messsage'
	";

	$ran_friendship_req_sql = mysqli_query($webgoneGlobal_mysqli, $insert_friendship_req_sql);

	
}
?>