<?php

include("db_connect.php");

if(isset($_POST)){ 

	//print_r($_POST);

			$user_email = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_POST['email1']));
			$user_password = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_POST['passme1']));

	
/*	
	$select_existing_user_sql = "
		SELECT `smashan_smashandpass`.`users` SET
			`user_email` = '$user_email',
			`user_password` = '$user_password'
	";
	$query_existing_user_sql = mysql_query($select_existing_user_sql, $webgoneGlobal) or die(mysql_error());

*/

  $loginUsername=$_POST['email1'];
  $password=$_POST['passme1'];
  $MM_fldUserAuthorization = "user_emailverify";
  $MM_redirectLoginSuccess = "play.php";
  $MM_redirectLoginFailed = "error.php";
  $MM_redirecttoReferrer = true;
  	
  $LoginRS__query = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `users`.`user_email` = '$user_email' AND `users`.`user_password` = '$user_password' ";

 
  
  
$LoginRS = mysqli_query($webgoneGlobal_mysqli, $LoginRS__query);
if (!$LoginRS) {
    //throw new Exception(mysqli_error($webgoneGlobal_mysqli)."[ $LoginRS__query]");
} 

$row_loginFoundUser=mysqli_fetch_assoc($LoginRS);
  
  $loginFoundUser = mysqli_num_rows($LoginRS);	
  
  if ($loginFoundUser) {
    
    $loginStrGroup  = $row_loginFoundUser['user_emailverify'];
    $user_id  = $row_loginFoundUser['user_id'];
    $user_owner_id  = $row_loginFoundUser['user_owner_id'];
	
	$paythis = (int)10;
	
	$user_networth_ply = ($paythis) + ((int)$row_loginFoundUser['user_networth_ply']);
	$user_liquidcash_ply = ($paythis) + ((int)$row_loginFoundUser['user_liquidcash_ply']);
	

	
	
	//  `userledger_log_ownerid` = '$user_owner_id', 

	$LoginCredit_query="INSERT INTO `smashan_smashandpass`.`users_ledger_log` SET `userledger_user_id` = '$user_id', `userledger_log_descrp` = 'Sign In Bonus Networth $user_networth_ply Liquid: $user_liquidcash_ply', `userledger_log_typtransc` = '+', `userledger_log_qty` = '1', `userledger_log_amount` = '$paythis'";

	$run_LoginCredit_query = mysqli_query($webgoneGlobal_mysqli, $LoginCredit_query);
	
	//Update User Last Logged In Time
	$user_last_loggedin = date('Y-m-d h:i:s');
	$Logintime_query="UPDATE `smashan_smashandpass`.`users` SET   `user_networth_ply` = '$user_networth_ply', `user_liquidcash_ply` = '$user_liquidcash_ply', `user_last_loggedin` = '$user_last_loggedin' WHERE `user_id` = '$user_id'";
	$run_Logintime_query = mysqli_query($webgoneGlobal_mysqli, $Logintime_query);

    
    //declare two session variables and assign them
    $_SESSION['MM_UsernameAgent'] = $loginUsername;
    $_SESSION['MM_UserGroupAgent'] = $loginStrGroup;

// Allowing Entrance because email and and password matched	

//echo $_SESSION['MM_UsernameAgent'].'<br />';
//echo $_SESSION['MM_UserGroupAgent'].'<br />';





echo "
	<script>
	
	 window.location.replace('/profile/');
	
	</script>	
";      

  }else {
	// header("Location: ". $MM_redirectLoginFailed );
	// Refreshing or reloading page because password didn't work
echo "
	<script>
	
	 location.reload();
	
	</script>	
";      
   
  }
	
	
}

?>