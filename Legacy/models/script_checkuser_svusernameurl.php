<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');






if(isset($_POST['user_id'], $_POST['usr_cookie'])){


				
				//echo 'Made It!'.$_POST['user_id'].' <-user_id  ';
					

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			
			$user_nicknameurl = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_nicknameurl']));


$find_user_usernamequery = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_nickname` = '$user_nicknameurl' LIMIT 1";
$result_usernameofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_usernamequery);
$row_usernameofuser = mysqli_fetch_assoc($result_usernameofuser);
$totalRows_usernameofuser = mysqli_num_rows($result_usernameofuser);	

$founduser_id = $row_usernameofuser['user_id'];

			$update_usernickname_sql = "
			 UPDATE `smashan_smashandpass`.`users` SET
				`user_nickname` = '$user_nicknameurl'
						WHERE
						 `user_id` = '$user_id'
						 ";
					
			
		
if(!$founduser_id){
	
			echo "
			Available
			<script>
				console.log('Username Can Be Saved');
				$('button#check_usernameurl').hide();
				$('button#save_usernameurl').show();
				
				if($('span#username_htmlresults').hasClass('has-error')){
					$('span#username_htmlresults').removeClass('has-error');
					$('span#username_htmlresults').addClass('has-success');
					}else{
						$('span#username_htmlresults').addClass('has-success');
						$('input#user_nicknameurl').attr('disabled', true);
					}

			</script>
			";

			$ran_usernickname_sql = mysqli_query($webgoneGlobal_mysqli, $update_usernickname_sql);
			
		}else{

			echo "
			Unavailable
			<script>
				console.log('Username Cannot Be Saved');
				$('button#check_usernameurl').show();
				$('button#save_usernameurl').hide();
				if($('span#username_htmlresults').hasClass('has-success')){
					$('span#username_htmlresults').removeClass('has-success');
					$('span#username_htmlresults').addClass('has-error');
					}else{
						$('span#username_htmlresults').addClass('has-error');
						$('input#user_nicknameurl').attr('disabled', false);
					}
				
			</script>
			";
		}




}else{

	exit();

}



?>