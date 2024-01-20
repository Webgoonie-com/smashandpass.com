<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');






if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['member_id'])){


			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['member_id']));
	
	
	$check_friendship_request_query_sql = "SELECT * FROM `smashan_smashandpass`.`user_following` WHERE `follow_userid` = '$member_id' AND `follow_memberid` = '$user_id' LIMIT 1";
	$friendship_request_query = mysqli_query($webgoneGlobal_mysqli, $check_friendship_request_query_sql);
	$row_friendship_request = mysqli_fetch_assoc($friendship_request_query);
	$totalRows_friendship_request = mysqli_num_rows($friendship_request_query);	

	
	
	$insert_friendship_req_sql = "
		INSERT INTO `smashan_smashandpass`.`user_following` SET
						`follow_userid` = '$member_id',
						`follow_memberid` = '$user_id'
	";

	if($totalRows_friendship_request == 0){
	$ran_friendship_req_sql = mysqli_query($webgoneGlobal_mysqli, $insert_friendship_req_sql);
	}

	
}
?>