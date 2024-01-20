<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');



print_r($_POST);


if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['member_id'], $_POST['purchase_amount'])){


				
			//	echo 'Made It!'.$_POST['user_id'].' <-user_id  ';
					

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['member_id']));
			$purchase_amount = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['purchase_amount']));
			
			if($_POST['purchase_amount'] == 0){ $purchase_amount = 100;  }

			if(!$found_user['user_nickname']){  $user_nickname = $found_user['user_fname'].' '.$found_user['user_lname']; }else{  $user_nickname =  $found_user['user_nickname']; }

			$user_nickname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($user_nickname));
			
			$query_purchase_player_myowner_sql = "
				INSERT INTO `smashan_smashandpass`.`users_ledger_log` SET
				`userledger_user_id` = '$member_id',
				`userledger_log_token` = '$user_token',
				`userledger_log_descrp` = 'New ownership purchase New Owner:  $user_nickname',
				`userledger_log_ownerid` = '$userledger_log_ownerid',
				`userledger_log_buyerid` = '$user_id',
				`userledger_log_usr_playerid` = '$member_id',
				`userledger_log_typtransc` = '+',
				`userledger_log_price` = '$purchase_amount',
				`userledger_log_qty` = '1',
				`userledger_log_amount` = '$purchase_amount'
			";
			
		$ran_purchase_player_myowner_sql = mysqli_query($webgoneGlobal_mysqli, $query_purchase_player_myowner_sql);


			$purchase_amount++;
			echo $update_usernewowner_sql = "
			 UPDATE `smashan_smashandpass`.`users` SET
				`user_owner_id` = '$user_id',
				`user_networth_ply` = '$purchase_amount'
						WHERE
						 `user_id` = '$member_id'
						 ";
					
			
			$ran_usernewowner_sql = mysqli_query($webgoneGlobal_mysqli, $update_usernewowner_sql);
	
			


}else{

	exit();

}



?>