<?php

// https://developers.facebook.com/docs/php/howto/example_facebook_login/5.0.0
// https://stackoverflow.com/questions/33867590/facebook-php-sdk-graph-returned-an-error-invalid-oauth-access-token

// App ID
// 907422053027508

// App Secret
// 516897654c1ad90fa2c2043c0502dc5e
require_once("classes/db_connect.php");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

require_once('Facebook/vendor/autoload.php'); // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '907422053027508',
  'app_secret' => '516897654c1ad90fa2c2043c0502dc5e',
  'default_graph_version' => 'v2.10',
  'default_access_token' => '$cookie', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
   //$helper = $fb->getPageTabHelper();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $accessToken = $helper->getAccessToken();
  
  $response = $fb->get('/me?fields=id,name,first_name,last_name,email', $accessToken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}


if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}



if(isset($_GET['code'])){

$me = $response->getGraphUser();

$fbprofileid = $me['id'];
$fb_picture  = "https://graph.facebook.com/$fbprofileid/picture?type=large";


	
	$_SESSION['access_token'] = $$cookie;
	
	// get profile info
		
	
	$user_email = $me['email'];
	
	$gname = $me['name'];

	$fb_user_id = $me['id'];
	
	$user_password = $me['id'];
	
	$givenName = $me['first_name'];
	
	$familyName = $me['last_name'];
	
	

	
	$thisraw_image = file_get_contents($fb_picture);

	
	
	$_SESSION['MM_UsernameAgent'] = $me['email'];
	$_SESSION['MM_UserGroupAgent'] = 1;

	
	//echo "<h1>Profile</h1>";
	
	//echo "<h1>$user_email</h1>";
	
	//echo "<h1>$gname</h1>";

	//echo "<h1>Tkey: $tkey</h1>";

	//echo "<h1>$givenName</h1>";

	//echo "<h1>$familyName</h1>";

	//echo "<img src='$fb_picture'>";
	
	//echo "<pre>";
	//var_dump($google_userData);

	//var_dump($google_account_info);
	
	
	
	/*
	* Begin A Mysqli Transaction to commit to only user and imgblobs before continuting
	* This his higly important as this will be the procudure also to start purchasing other players as asseets.
	*/
	
	
	//mysqli_begin_transaction($webgoneGlobal_mysqli, MYSQLI_TRANS_START_READ_ONLY);
	
	$find_user_query = "SELECT `user_email`, `user_id`, `user_emailverify`  FROM `smashan_smashandpass`.`users` WHERE `users`.`user_email` = '$user_email' LIMIT 1";
	$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
	$row_ofuser = mysqli_fetch_assoc($result_ofuser);
	$totalRows_ofuser = mysqli_num_rows($result_ofuser);
	
	if($totalRows_ofuser == 0){
		// Prepare data statements user mysqli
		$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($tkey));
		
		$thisraw_image = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($thisraw_image));
		$givenName = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($givenName));
		
		if(!empty($familyName)){
		$familyName = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($familyName));
		}
		$user_email = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($user_email));
		$user_password = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($user_password));
		
		$fbicture = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($fb_picture));
		$server_time = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($server_time));

		
		// Create New User
		$insert_join_user_sql = "
		INSERT INTO `smashan_smashandpass`.`users` SET
			`user_token` = '$user_token',
			`user_emailverify` = '1',
			`user_fname` = '$givenName',
			`user_lname` = '$familyName',
			`user_email` = '$user_email',
			`user_password` = '$user_password',
			`user_blob_file_path` = '$gpicture',
			`user_pointsvalue` = '100',
			`user_profile_blob` = '$thisraw_image',
			`user_profile_blob_time` = '$server_time'
		";
		$run_query_join_user =  mysqli_query($webgoneGlobal_mysqli, $insert_join_user_sql) or die(mysqli_connect_errno());
		$new_join_user_id = mysqli_insert_id($webgoneGlobal_mysqli);


		// Go ahead and make a file directory for the user since now you have the user id

		if(!file_exists("uploads/$new_join_user_id")){
			mkdir("uploads/$new_join_user_id", 0777, true);
		}
	
		$image_name = time().'.png';
	
		$target_filepath = "uploads/$new_join_user_id/".$image_name;
		
		file_put_contents($target_filepath, $$fb_picture);


		
		
				
		
		$photodata = getimagesize($fb_picture);

		
		$uphotowidth = $photodata[0];
		
		$uphotoheight = $photodata[1];
		
        $image_size = $photodata['bits'];
		
   		$image_type = $photodata['mime'];		
		
		$insert_userimage_blob_sql = "
		INSERT INTO `smashan_smashandpass`.`user_imgblobs` SET
		`userblob_users_id` = '$new_join_user_id',
		`userblob_image` = '$thisraw_image',
		`userblob_image_name` = '$fb_picture',
		`userblob_image_profilepic` = 'Y',
		`userblob_image_size` = '$image_size',
		`userblob_image_type` = '$image_type',
		`userblob_image_width` = '$uphotowidth',
		`userblob_image_height` = '$uphotoheight',
		`userblob_profilepic_timelist` = '$server_time',
		`userblob_profilepic_caption` = 'FB-Profile'
		";
		
		
		
		$ran_userimage_blob_sql = mysqli_query($webgoneGlobal_mysqli, $insert_userimage_blob_sql);
		$sys_userimage_blob_id = mysqli_insert_id($webgoneGlobal_mysqli);
		
		
		$insert_new_user_blob_sql = "
		INSERT INTO `smashan_smashandpass`.`user_profile_photoblobs` SET
		`profile_photoblob_user_id` = '$new_join_user_id',
		`profile_photoblob_filepath` = '$target_filepath',
		`profile_photoblob_realblob_id` = '$sys_userimage_blob_id'
		
		";
		$run_new_user_blob =  mysqli_query($webgoneGlobal_mysqli, $insert_new_user_blob_sql) or die(mysqli_connect_errno());
		$new_user_profile_photoblobs_id = mysqli_insert_id($webgoneGlobal_mysqli);



	$paythis = (int)100;
	
	$user_networth_ply = ($paythis) + ((int)$row_ofuser['user_networth_ply']);
	$user_liquidcash_ply = ($paythis) + ((int)$row_ofuser['user_liquidcash_ply']);		

	// `userledger_log_ownerid` = '$user_owner_id', 
	// Removed this because there is no owner for a new registered user.
	$userledger_log_token = bin2hex(openssl_random_pseudo_bytes(10));
	$userledger_log_token = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($userledger_log_token));
	
	$LoginCredit_query="INSERT INTO `smashan_smashandpass`.`users_ledger_log` SET `userledger_log_token` = '$userledger_log_token', `userledger_user_id` = '$new_join_user_id', `userledger_log_descrp` = 'Sign In Bonus Networth $user_networth_ply Liquid: $user_liquidcash_ply', `userledger_log_typtransc` = '+', `userledger_log_qty` = '1', `userledger_log_amount` = '$paythis'";

	$run_LoginCredit_query = mysqli_query($webgoneGlobal_mysqli, $LoginCredit_query);

		$insert_user_threads_sql = "
		INSERT INTO `smashan_smashandpass`.`user_threads` SET
		`usr_thread_user_id` = '$new_join_user_id',
		`usr_thread_tomember_id` = '$new_join_user_id',
		`usr_thread_token` = '$userledger_log_token',
		`usr_thread_userblob_id` = '$new_join_user_id',
		`usr_thread_user_html` = 'Added A New Photo'
		";

	$run_insert_user_threads = mysqli_query($webgoneGlobal_mysqli, $insert_user_threads_sql);
	
	
	

	

	//Update User Last Logged In Time
	$user_last_loggedin = date('Y-m-d h:i:s');
	
	$Logintime_query="UPDATE `smashan_smashandpass`.`users` SET 
							 `user_networth_ply` = '$user_networth_ply',
							 `user_liquidcash_ply` = '$user_liquidcash_ply', 
							 `user_last_loggedin` = '$user_last_loggedin' 
					  WHERE 
					  		  `user_id` = '$new_join_user_id'
					 ";
	$run_Logintime_query = mysqli_query($webgoneGlobal_mysqli, $Logintime_query);



		
		$insert_user_profile_photoblobs_sql = "
		INSERT INTO `smashan_smashandpass`.`user_profile_photoblobs` SET
		`profile_photoblob_user_id` = '$new_join_user_id',
		`profile_photoblob_filepath` = '$target_filepath',
		`profile_photoblob_realblob_id` = '$sys_userimage_blob_id'
		";

		$run_insert_user_profile_photoblobs_sql = mysqli_query($webgoneGlobal_mysqli, $insert_user_profile_photoblobs_sql);




		//header("Location: /profile"); 
		header("Location: /uphoto"); 
		
		//header("Location: /forceset"); 
	
	}else if($totalRows_ofuser != 0){
		
		
			if($row_ofuser['user_profile_blob']){
				
				
				header("Location: /profile"); 
				//echo 'Willl Head to profile';
			
			}else{
				
				//Force or prompt user to upload photo of themselves
				header("Location: /uphoto"); 
				//echo 'Will head to uphoto';
			
			}
	}
	
	
		
	}else{
		
	}


?>


