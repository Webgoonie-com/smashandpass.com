<?php

//print_r($_GET);

include("classes/restrict_login.php");



if(isset($_GET['user_id'], $_GET['usr_playerid'])){


			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_GET['user_id']));
			$playerid = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_GET['usr_playerid']));


$find_users_connections_query = "
SELECT 

`aSmash`.`smashandpass_id` AS `aSmashpass_id`,
`aSmash`.`smashandpass_user_idone` AS `aSmashpass_user_idone`,
`aSmash`.`smashandpass_user_idone_time` AS `aSmashpass_user_idone_time`,
`aSmash`.`smashandpass_user_idone_action` AS `aSmashpass_user_idone_action`,
`aSmash`.`smashandpass_user_idtwo` AS `aSmashpass_user_idtwo`,
`aSmash`.`smashandpass_user_idtwo_time` AS `aSmashpass_user_idtwo_time`,
`aSmash`.`smashandpass_user_idtwo_action` AS `aSmashpass_idtwo_action`,

`mySmash`.`smashandpass_id` AS `mySmash_idtwo_action`,
`mySmash`.`smashandpass_user_idone` AS `mySmash_user_idone`,
`mySmash`.`smashandpass_user_idone_time` AS `mySmash_user_idone_time`,
`mySmash`.`smashandpass_user_idone_action` AS `mySmash_user_idone_action`,
`mySmash`.`smashandpass_user_idtwo` AS `mySmash_user_idtwo`,
`mySmash`.`smashandpass_user_idtwo_time` AS `mySmash_user_idtwo_time`,
`mySmash`.`smashandpass_user_idtwo_action` AS `mySmash_user_idtwo_action`,
`u`.`user_emailverify`,
`u`.`user_owner_id`,
`u`.`user_nickname`,
`u`.`user_fname`,
`u`.`user_lname`,
`u`.`show_fullname`,
`u`.`user_token`,
`u`.`user_profile_blob`,
`u`.`user_blob_file_path`,
`u`.`user_pointsvalue`,
`u`.`user_networth_ply`,
`u`.`user_liquidcash_ply`,
`u`.`user_properties_ply`,
`u`.`user_assets_ply`,
`u`.`user_wishers_ply`,
`u`.`user_growthrate_ply`,
`u`.`user_view_zipcode`
 FROM 
  `smashan_smashandpass`.`users_smashandpass` AS `aSmash`
 
 INNER JOIN `smashan_smashandpass`.`users_smashandpass` AS `mySmash` ON
    	   `aSmash`.`smashandpass_user_idone` = `mySmash`.`smashandpass_user_idtwo`
LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `mySmash`.`smashandpass_user_idone`
		   
		   
 WHERE 
 `u`.`user_blob_file_path` IS NOT NULL
 	AND
	`aSmash`.`smashandpass_user_idone_action` = 'smash'
 	
	AND
	`mySmash`.`smashandpass_user_idtwo` = '$playerid'
	
	GROUP BY
	`u`.`user_id`
";
$result_ofusers_connectme = mysqli_query($webgoneGlobal_mysqli, $find_users_connections_query);
$row_ofusers_connectme = mysqli_fetch_assoc($result_ofusers_connectme);
$totalRows_ofusers_connectme = mysqli_num_rows($result_ofusers_connectme);	


$member_sql = "SELECT
 	`users`.`user_id` AS theusr_id ,
	`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,
	`users`.`user_networth_ply` as MyLiquidCash, 
	
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			 FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$playerid'";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$row_found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);


$player_sql = "SELECT
 	`users`.`user_id` AS theusr_id ,
	`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,
	`users`.`user_networth_ply` as MyLiquidCash, 
	
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			 FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$member_id'";
$member_player_sql = mysqli_query($webgoneGlobal_mysqli, $player_sql);
$row_member_player = mysqli_fetch_assoc($member_player_sql);
$totalRows_member_player = mysqli_num_rows($member_player_sql);



	$found_user_id = $row_found_user['user_id'];
	
	if($row_found_user['user_owner_id'])
	{
		$found_user_owner_id = $row_found_user['user_owner_id'];	
	}else{
		$found_user_owner_id = NULL;
	}





}else{
exit();

}
?>

<div class="row justify-content-center">
  <div id="splash_captionblock" align="center">
    <div class="row">
    <div class="col-sm-6">
        
        <h2><?php echo $row_member_player['user_fname']; ?></h2>
        <img src="<?php echo $row_member_player['user_blob_file_path']; ?>" width="200px">
    </div>
    <div class="col-sm-6">
       
        <h2><?php echo $row_found_user['user_fname']; ?></h2>
        <img src="<?php echo $row_found_user['user_blob_file_path']; ?>" width="200px">
    </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
        	<?php if($totalRows_ofusers_connectme != 0){ echo $totalRows_ofusers_connectme."x's Connected Before"; }else{ echo 'First Times You Made A Connection!!!';  } ?>
        </div>
    </div>
    <div class="row">
      <button id="message_from_splash_pane_now" onClick="sendMemberMessage(<?php echo $_GET['user_id']; ?>, <?php echo $_GET['usr_playerid']; ?>)" class="btn btn-success btn-lg">
      	<i class="fa fa-weixin" aria-hidden="true"></i> MESSAGE NOW
      </button>
    </div>
  </div>
</div>

<script>
function goToMemberPage(user_id, usr_playerid){
		
			document.location.href = 'messages/new/?usr_playerid='+usr_playerid+'&user_id='+user_id;
}
function sendMemberMessage(user_id, usr_playerid){
	
			document.location.href = 'messages/new/?usr_playerid='+usr_playerid+'&user_id='+user_id;
		
}

</script>