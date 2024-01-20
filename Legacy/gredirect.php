<?php 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";


require_once("vendor/autoload.php"); 

require_once("classes/db_connect.php");

// https://www.smashandpass.com/googlelogin

// Your Client ID
// 377736456690-as14catdfcvq9aipnaqkbaaqfjjttlgm.apps.googleusercontent.com


// Your Client Secret
// OxfghhuEWVzzQj416ln1lopJ

//session_start();

//$gClient = new Google_Client();
//$gClient->



$gclientId = "377736456690-as14catdfcvq9aipnaqkbaaqfjjttlgm.apps.googleusercontent.com";
$gclientSecret = "OxfghhuEWVzzQj416ln1lopJ";
$gredirectUri = "https://www.smashandpass.com/gredirect.php";



// Creating 
$gclient = new Google_Client();

$gclient->setClientId($gclientId);

$gclient->setClientSecret($gclientSecret);

$gclient->setRedirectUri($gredirectUri);

// https://developers.google.com/+/scopes-shutdown
// Now we must add some scopes
// $gclient->addScope(scope_or_scopes: "https://www.googleapis.com/auth/profile.emails.read ");

$gclient->addScope('email');
$gclient->addScope('profile');
//$gclient->addScope('gender');


$gloginURL = $gclient->createAuthUrl();

if(isset($_GET['code'])){
	
	$gtoken = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
	$_SESSION['access_token'] = $gtoken;
	
	$gclient->setAccessToken($gtoken['access_token']);
	// get profile info
	
	$google_oauth = new Google_Service_Oauth2($gclient);
	//$google_userData = $google_oauth->userinfo_v2_me->get();
	
	$google_account_info = $google_oauth->userinfo->get();
	
	$user_email = $google_account_info->email;
	
	$gname = $google_account_info->name;
	
	$user_password = $google_account_info->id;
	
	$givenName = $google_account_info->givenName;
	
	$familyName = $google_account_info->familyName;
	
	$ggender = $google_account_info->gender;
	
	$gpicture = $google_account_info->picture;
	$gpicture_raw = $gpicture;
	
	$thisraw_image = file_get_contents($gpicture_raw);

	
	
	$_SESSION['MM_UsernameAgent'] = $user_email;
	$_SESSION['MM_UserGroupAgent'] = 1;

	
	//echo "<h1>Profile</h1>";
	
	//echo "<h1>$gemail</h1>";
	
	//echo "<h1>$gname</h1>";

	//echo "<h1>Tkey: $tkey</h1>";

	//echo "<h1>$givenName</h1>";

	//echo "<h1>$familyName</h1>";

	//echo "<img src='$gpicture'>";
	
	//echo "<pre>";
	//var_dump($google_userData);

	//var_dump($google_account_info);
	
	
	
	$find_user_query = "SELECT `user_email`, `user_id`, `user_emailverify`  FROM `smashan_smashandpass`.`users` WHERE `users`.`user_email` = '$user_email' LIMIT 1";
	$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
	$row_ofuser = mysqli_fetch_assoc($result_ofuser);
	$totalRows_ofuser = mysqli_num_rows($result_ofuser);
	
	if($totalRows_ofuser == 0){
		// Prepare data statements user mysqli
		$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($tkey));
		$thisraw_image = file_get_contents($gpicture_raw);
		
		$thisraw_image = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($thisraw_image));
		$givenName = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($givenName));
		
		if(!empty($familyName)){
		$familyName = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($familyName));
		}
		$user_email = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($user_email));
		$user_password = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($user_password));
		
		$gpicture = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($gpicture));
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
		
		file_put_contents($target_filepath, $thisraw_image);


		
		
				
		
		$photodata = getimagesize($gpicture_raw);

		
		$uphotowidth = $photodata[0];
		
		$uphotoheight = $photodata[1];
		
        $image_size = $photodata['bits'];
		
   		$image_type = $photodata['mime'];		
		
		
		$insert_userimage_blob_sql = "
		INSERT INTO `smashan_smashandpass`.`user_imgblobs` SET
		`userblob_users_id` = '$new_join_user_id',
		`userblob_image` = '$thisraw_image',
		`userblob_image_name` = '$image_name',
		`userblob_image_profilepic` = 'Y',
		`userblob_image_size` = '$image_size',
		`userblob_image_type` = '$image_type',
		`userblob_image_width` = '$uphotowidth',
		`userblob_image_height` = '$uphotoheight',
		`userblob_profilepic_timelist` = '$server_time',
		`userblob_profilepic_caption` = 'G-Profile'
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
		`usr_thread_user_html` = 'Recently Changed Profile Photo'
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
		// header("Location: /uphoto"); 
		
		header("Location: /forceset"); 
	
	}else if($totalRows_ofuser != 0){
		
		
			if($row_ofuser['user_profile_blob']){
				
				
				header("Location: /profile"); 
				//echo 'Willl Head to profile';
			
			}else{
				
				//Force or prompt user to upload photo of themselves
				header("Location: /profile"); 
				//header("Location: /uphoto"); 
				//echo 'Will head to uphoto';
			
			}
	}
	
	
		
	}else{
		echo "<a class='btn btn-block btn-social btn-google col-6-sm' href=" . $gloginURL . "><span class='fa fa-google'></span> Google Login</a>";
	}




?>
