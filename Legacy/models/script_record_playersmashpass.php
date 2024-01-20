<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');




print_r($_POST);
if(!$_POST){ exit(); }
if(!$_POST['player_smashpassaction']){ exit(); }


$smashandpass_id = '';

if(isset($_POST['user_id'], $_POST['usr_cookie'], $_POST['player_id'], $_POST['player_smashpassaction'])){


				
				echo 'I made it';


			

	

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$player_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['player_id']));
			$player_smashpassaction = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['player_smashpassaction']));

			// Pull exisiting player info being smashed or passed
			$member_sql = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$player_id'";
			$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
			$row_found_user = mysqli_fetch_assoc($member_user_sql);
			$totalRows_found_user = mysqli_num_rows($member_user_sql);
			
			$found_user_id = $row_found_user['user_id'];
			
			
			$old_user_networth_ply  = $row_found_user['user_networth_ply'];
			if(!$old_user_networth_ply){ $old_user_networth_ply = '10'; }


			// Find An Existing Smash or pass action of this user being played
			$find_user_photoquery = "SELECT * FROM 
								`smashan_smashandpass`.`users_smashandpass` 
								WHERE 
								`smashandpass_user_idone`  = '$player_id'
								AND
								`smashandpass_user_idone_action`  = 'smash'
								AND
								`smashandpass_user_idtwo`  = '$user_id'
								  ORDER BY `smashandpass_id` DESC LIMIT 1";
			$result_photoofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_photoquery);
			$row_photoofuser = mysqli_fetch_assoc($result_photoofuser);
			$totalRows_photoofuser = mysqli_num_rows($result_photoofuser);	
			
			$found_smashandpass_id = $row_photoofuser['smashandpass_user_idone'];
			

			if($found_smashandpass_id == $_POST['player_id'])
						{ 
							$smashandpass_user_idtwo_time = $row_photoofuser['smashandpass_created_at'];  
							$smashandpass_user_idtwo_time_sql = ",`smashandpass_user_idtwo_time` = '$smashandpass_user_idtwo_time'";
						}else{ 
							$smashandpass_user_idtwo_time_sql = "";
						}

			$userblob_profilepic_timelist = date('Y-m-d h:i:s');


				
			$query_smashandpass_user_action_sql = "
				INSERT INTO `smashan_smashandpass`.`users_smashandpass` SET
				`smashandpass_user_idone` = '$user_id',
				`smashandpass_user_idone_time` = '$userblob_profilepic_timelist',
				`smashandpass_user_idone_action` = '$player_smashpassaction',
				`smashandpass_user_idtwo` = '$player_id'$smashandpass_user_idtwo_time_sql
				
				";

	
			$run_smashandpass_user_action_sql =  mysqli_query($webgoneGlobal_mysqli, $query_smashandpass_user_action_sql) or die(mysqli_connect_errno());
			$smashandpass_id = mysqli_insert_id($webgoneGlobal_mysqli);


// Pay User For Smashing And Passing
$userledger_log_descrp = 'Playing Smash And Pass';

$userledger_log_typtransc = '+';
$user_ledger_price = '10';

$user_ledger_qty = "1";

$userledger_log_amount =  ($user_ledger_price * $user_ledger_qty);  // "10";

$user_networth_ply = ($old_user_networth_ply + $userledger_log_amount);

$userledger_log_usr_playerid = $player_id;

	$user_last_loggedin = date('Y-m-d h:i:s');
	$payuserforsmashanspassuserplay_query="INSERT INTO `smashan_smashandpass`.`users_ledger_log` SET 
						`userledger_user_id` = '$user_id',
						`userledger_log_token` = '$user_token',
						`userledger_log_descrp` = '$userledger_log_descrp',
						`userledger_log_ownerid` = '$userledger_log_ownerid',
						`userledger_log_usr_playerid` = '$userledger_log_usr_playerid',
						`userledger_log_typtransc` = '$userledger_log_typtransc',
						`userledger_log_price` = '$user_ledger_price',
						`userledger_log_qty` = '$user_ledger_qty',
						`userledger_log_amount` = '$userledger_log_amount'
						";

	$run_Payuserforsmashanspassuserplay = mysqli_query($webgoneGlobal_mysqli, $payuserforsmashanspassuserplay_query);




	// Update User With Logged In Time
	$user_last_loggedin = date('Y-m-d h:i:s');
	$Logintimemember_query="UPDATE `smashan_smashandpass`.`users` SET 
						`user_last_loggedin` = '$user_last_loggedin',
						`user_networth_ply` = '$user_networth_ply'
						WHERE 
						`user_id` = '$user_id'
					";
	$run_Logintimemember_query = mysqli_query($webgoneGlobal_mysqli, $Logintimemember_query);

	// Update player credientials from pass or smash action
	$Logintimeplayer_query="UPDATE `smashan_smashandpass`.`users` SET 
						`user_networth_ply` = '$user_networth_ply'
						WHERE 
						`user_id` = '$player_id'
					";
	$run_Logintimeplayer_query = mysqli_query($webgoneGlobal_mysqli, $Logintimeplayer_query);


					
					// This will hook a java script function in goonie.js to run a module to show user smash and pass responses.
					if($found_smashandpass_id == $_POST['player_id']){ 
								echo "
									<script>
									console.log('Testing Delete From Else bracket on server!');
									//run_smashalert_script($user_id, $userledger_log_usr_playerid, $player_smashpassaction);
									
									var load_smashalert_script = 'splashaction/?user_id=$user_id&usr_playerid=$userledger_log_usr_playerid&smashpassaction=$player_smashpassaction';
									
								$('div#signalSplashModal').modal({
									backdrop: 'static',
									keyboard: false,
									show: true
								});
								
								$('div#spalsh_body_view').load('splashaction/?user_id=$user_id&usr_playerid=$userledger_log_usr_playerid&smashpassaction=$player_smashpassaction');
									
									
									
									
								</script>
								"; 
					}else {
					
					/*echo "
									<script>
									console.log('Testing Delete From Else bracket on server!');
									//run_smashalert_script($user_id, $userledger_log_usr_playerid, $player_smashpassaction);
									
									var load_smashalert_script = 'splashaction/?user_id=$user_id&usr_playerid=$userledger_log_usr_playerid&smashpassaction=$player_smashpassaction';
									
								$('div#signalSplashModal').modal({
									backdrop: 'static',
									keyboard: false,
									show: true
								});
								
								$('div#spalsh_body_view').load('splashaction/?user_id=$user_id&usr_playerid=$userledger_log_usr_playerid&smashpassaction=$player_smashpassaction');
									
									
									
									
								</script>
								"; */

					}


}else{

	exit();

}
?>
<?php include("../views/_end.mysql.php"); ?>