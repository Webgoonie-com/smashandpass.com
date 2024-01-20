<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_UsernameAgent'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_UsernameAgent'], $_SESSION['MM_UserGroupAgent'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}



$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

//$user_sql = "SELECT `user_id`, `user_owner_id`, `user_token`, `user_emailverify`, `user_nickname`, `user_fname`, `user_lname`, `user_email`, `user_pointsvalue` FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$user_sql = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$query_user_sql = mysqli_query($webgoneGlobal_mysqli, $user_sql);
$row_this_user = mysqli_fetch_assoc($query_user_sql);
$totalRows_this_user = mysqli_num_rows($query_user_sql);

$user_id = $row_this_user['user_id'];
$user_emailverify = $row_this_user['user_emailverify'];
$userledger_log_ownerid = $row_this_user['user_owner_id'];

$user_networth_ply = $row_this_user['user_networth_ply'];
$user_liquidcash_ply = $row_this_user['user_liquidcash_ply'];
$user_properties_ply = $row_this_user['user_properties_ply'];
$user_assets_ply = $row_this_user['user_assets_ply'];
$user_wishers_ply = $row_this_user['user_wishers_ply'];
$user_growthrate_ply = $row_this_user['user_growthrate_ply'];





/*
$user_income_sql = "SELECT *
	FROM 
	`smashan_smashandpass`.`users`, `smashan_smashandpass`.`users_ledger_log`
	WHERE 
	`users`.`user_email` = '$MM_UsernameAgent'
	AND
	`users`.`user_ledger_price` = '$MM_UsernameAgent'
	";
$query_user_income_sql = mysqli_query($webgoneGlobal_mysqli, $user_income_sql);
$row_found_user_income = mysqli_fetch_assoc($query_user_income_sql);
$totalRows_found_user_income_sql = mysqli_num_rows($query_user_income_sql);

*/



$user_income_sql = "SELECT COUNT(*) AS total_record,
					(SELECT COUNT(*) 
						FROM `smashan_smashandpass`.`users_ledger_log` 
							WHERE `users_ledger_log`.`userledger_log_typtransc` = '-' 
								AND 
								`users_ledger_log`.`userledger_user_id` = '$user_id'
					) AS subtract 
					
					FROM 
						`smashan_smashandpass`.`users_ledger_log` 
					WHERE 
						`users_ledger_log`.`userledger_log_typtransc` = '+'
					";
$query_user_income_sql = mysqli_query($webgoneGlobal_mysqli, $user_income_sql);
$row_found_user_income = mysqli_fetch_assoc($query_user_income_sql);
$totalRows_found_user_income_sql = mysqli_num_rows($query_user_income_sql);



$lastest_members_advert_sql = "
	SELECT 
`users`.`user_id` AS theusr_id ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as CountMyOwnNetworth, 
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM `smashan_smashandpass`.`users` 
WHERE 
	`user_profile_blob` IS NOT NULL
	GROUP BY `users`.`user_id`
	ORDER BY  RAND() ASC
	LIMIT 15
";
$query_lastest_members_advert_sql = mysqli_query($webgoneGlobal_mysqli, $lastest_members_advert_sql);
$row_lastest_members_advert = mysqli_fetch_assoc($query_lastest_members_advert_sql);
$totalRows_lastest_members_advert = mysqli_num_rows($query_lastest_members_advert_sql);



$lastest_members_transactions_sql = "
	SELECT 
`users_ledger_log`.* ,
`users`.`user_id` AS `theusr_id` ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_blob_file_path`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as `CountMyOwnNetworth`, 
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM  `smashan_smashandpass`.`users_ledger_log`
LEFT JOIN `smashan_smashandpass`.`users` ON
`users_ledger_log`.`userledger_user_id` = `users`.`user_id`
WHERE 
	`user_profile_blob` IS NOT NULL
	OR
	`user_blob_file_path` IS NOT NULL
	GROUP BY `users`.`user_id`
	ORDER BY `users_ledger_log`.`userledger_log_id` DESC
	LIMIT 15
";
$query_lastest_members_transactions_sql = mysqli_query($webgoneGlobal_mysqli, $lastest_members_transactions_sql);
$row_lastest_members_transactions = mysqli_fetch_assoc($query_lastest_members_transactions_sql);
$totalRows_lastest_members_transactions = mysqli_num_rows($query_lastest_members_transactions_sql);



/* check connection */




?>