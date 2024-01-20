<?php

include("../../classes/db_connect.php");

include("../../classes/restrict_login.php");






$member_id  = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_POST['member_id']));

//
$found_user_owner_id = '-1';



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

//
$found_user_owner_id = '-1';



if(!is_numeric($message_pageurl)){

	//exit();
	
		$val = 'NOT';
	
}else{
	//return;
	$val = 'IS';
}


if(is_numeric($member_id)){
	
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
			 FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$member_id'";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$row_found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);

	$found_user_id = $row_found_user['user_id'];
	
	if($row_found_user['user_owner_id']){$found_user_owner_id = $row_found_user['user_owner_id'];	}
	//return;
	
}else{

	

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
			 FROM `smashan_smashandpass`.`users` WHERE `user_nickname` = '$member_id' ORDER BY `user_id` ASC LIMIT 1";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$row_found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);

 	$found_user_id = $row_found_user['user_id'];
	if($row_found_user['user_owner_id']){$found_user_owner_id = $row_found_user['user_owner_id'];	}



	
}
// if not integer redirect and then exit.








$query_loop_message = "
SELECT 
`fromFriend`.`usr_message_id` AS `fromFriend_user_message_id`,
`fromFriend`.`usr_message_frmuser_id`  AS `fromFriend_usr_message_frmuser_id`,
`fromFriend`.`usr_message_read` AS `fromFriend_user_message_read`,
`fromFriend`.`usr_message_touser_id` AS `fromFriend_usr_message_touser_id`,
`fromFriend`.`usr_message_html` AS `fromFriend_user_message_html`,
`fromFriend`.`usr_message_created_at` AS `fromFriend_user_message_created_at`,
`toFriend`.`usr_message_id` AS `toFriend_user_message_id`,
`toFriend`.`usr_message_frmuser_id`  AS `toFriend_usr_message_frmuser_id`,
`toFriend`.`usr_message_read` AS `toFriend_user_message_read`,
`toFriend`.`usr_message_touser_id` AS `toFriend_usr_message_touser_id`,
`toFriend`.`usr_message_html` AS `toFriend_user_message_html`,
`toFriend`.`usr_message_created_at` AS `toFriend_user_message_created_at`,
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
`uf`.`user_properties_ply`,
`uf`.`user_assets_ply`,
`uf`.`user_wishers_ply`,
`uf`.`user_growthrate_ply`,
`uf`.`user_view_zipcode`,
`uf`.`user_emailverify`,
`uf`.`user_owner_id`,
`uf`.`user_nickname`,
`uf`.`user_fname`,
`uf`.`user_lname`,
`uf`.`show_fullname`,
`uf`.`user_token`,
`uf`.`user_profile_blob`,
`uf`.`user_blob_file_path`,
`uf`.`user_pointsvalue`,
`uf`.`user_networth_ply`,
`uf`.`user_liquidcash_ply`,
`uf`.`user_properties_ply`,
`uf`.`user_assets_ply`,
`uf`.`user_wishers_ply`,
`uf`.`user_growthrate_ply`,
`uf`.`user_view_zipcode`
	FROM 
		`smashan_smashandpass`.`user_messages` AS `fromFriend`
	LEFT JOIN `smashan_smashandpass`.`user_messages` AS `toFriend` ON
			   `toFriend`.`usr_message_touser_id` = `fromFriend`.`usr_message_touser_id`
	LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `fromFriend`.`usr_message_touser_id`
		   
		   
	LEFT JOIN 
		`smashan_smashandpass`.`users` AS `uf` ON  
		`uf`.`user_id` =  `toFriend`.`usr_message_frmuser_id` 
	 WHERE 
		 `toFriend`.`usr_message_touser_id` = '$user_id' 
		 AND 
		 `toFriend`.`usr_message_touser_id` = '$found_user_id'

				OR
				`fromFriend`.`usr_message_touser_id` = '$found_user_id'
				AND
				`fromFriend`.`usr_message_frmuser_id` = '$user_id'
			
				OR
        `fromFriend`.`usr_message_frmuser_id` = '$found_user_id'
				AND
				`fromFriend`.`usr_message_touser_id` = '$user_id'
		
	 GROUP BY
	 `fromFriend`.`usr_message_id`
	ORDER BY 
	`fromFriend`.`usr_message_id` ASC";
$loop_message = mysqli_query($webgoneGlobal_mysqli, $query_loop_message);
$row_loop_message = mysqli_fetch_assoc($loop_message);
$totalRows_loop_message = mysqli_num_rows($loop_message);

?>

<ol class="commentlist">
                                

                                  <!-- COMMENT - START -->
                                <li class="comment">

  <?php if($totalRows_loop_message != 0){ do {
	  $user_message_html = trim(strip_tags($row_loop_message['fromFriend_user_message_html']));
	  
	  $frmuser_id =$row_loop_message['fromFriend_usr_message_frmuser_id'];
	  $tomuser_id =$row_loop_message['fromFriend_usr_message_touser_id'];
	   
 ?>
   
   <?php if($frmuser_id == $member_id){ ?>
                                    <div class="avatar m-t-10">
                                    	<a href="<?php if($row_loop_message['user_nickname']){ echo '/@/'.$row_loop_message['user_nickname']; }else if(!$row_loop_message['user_nickname']){ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; }else{ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; } ?>"><img src="<?php echo $row_loop_message['user_blob_file_path']; ?>" alt=""></a>
                                    </div>
                                    <div class="comment-body">
                                        <div class="author" id="<?php echo $frmuser_id; ?> & <?php echo $tomuser_id; ?> & <?php echo $member_id; ?>">
                                            <h3><a href='message/<?php echo $row_loop_message['user_message_id']; ?>'><?php if($row_loop_message['show_fullname'] == 1){ echo $row_loop_message['user_fname'].' '.$row_loop_message['user_lname']; }else if($row_loop_message['user_nickname']){ echo $row_loop_message['user_nickname']; }else{ echo $row_loop_message['user_fname']; } ?></a></h3>
                                            <div class="meta"><span class="date" title="<?php echo $row_loop_message['fromFriend_user_message_created_at']; ?>"><?php echo $row_loop_message['fromFriend_user_message_created_at']; ?></span></div>
                                        </div>      
                                        <p class="message"><?php echo  $user_message_html; ?></p>
                                       
                                    </div>
                                  
                                    
   <?php }else if($frmuser_id != $tomuser_id){ ?>  

                                    <ul class="children" id="<?php echo $frmuser_id; ?> & <?php echo $tomuser_id; ?> & <?php echo $member_id; ?>">

                                        <!-- COMMENT - START -->
                                        <li class="comment">
                                           <div class="avatar"><a href="<?php if($row_loop_message['user_nickname']){ echo '/@/'.$row_loop_message['user_nickname']; }else if(!$row_loop_message['user_nickname']){ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; }else{ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; } ?>"><img src="<?php echo $row_loop_message['user_blob_file_path']; ?>" alt=""></a></div>
                                            <div class="comment-body">
                                                <div class="author">
                                                    <h3><a href='message/<?php echo $row_loop_message['user_message_id']; ?>'><?php if($row_loop_message['show_fullname'] == 1){ echo $row_loop_message['user_fname'].' '.$row_loop_message['user_lname']; }else if($row_loop_message['user_nickname']){ echo $row_loop_message['user_nickname']; }else{ echo $row_loop_message['user_fname']; } ?></a></h3>
                                                    <div class="meta"><span class="date" title="<?php echo $row_loop_message['fromFriend_user_message_created_at']; ?>"><?php echo $row_loop_message['fromFriend_user_message_created_at']; ?></span></div>
                                                </div>      
                                        <p class="message"><?php echo  $user_message_html; ?></p>
                                               
                                               
                                            </div>
                                        </li>
                                        <!-- COMMENT - END -->
   </ul>
   <?php } ?>   
                                        

                                 
                        
  <?php } while ($row_loop_message = mysqli_fetch_array($loop_message)); } ?>
                                 </li>
                               
                                <!-- COMMENT - END -->
                                
                            </ol>
<?php require('../../views/_end.mysql.php'); ?>
