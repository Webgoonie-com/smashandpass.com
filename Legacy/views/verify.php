<?php


//include("classes/restrict_login.php");



?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($webgoneGlobal_mysqli, $theValue) : mysqli_escape_string($webgoneGlobal_mysqli,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



?>
<?php

$user_token  = $url->segment(2);


$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($user_token));


$member_sql = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_token` = '$user_token'";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);

$member_id_token  = $found_user['user_token'];
$member_id  = $found_user['user_id'];

$user_emailverify = $found_user['user_emailverify'];

$email_alreadyverified = '0';

if($totalRows_found_user == '1' && $user_emailverify == '0'){

	$find_user_query = "UPDATE `smashan_smashandpass`.`users` SET `user_emailverify` = '1' WHERE `user_id` = '$member_id'";
	$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);

}elseif($user_emailverify == 1){


$email_alreadyverified = '1';
	
}else{

$email_alreadyverified = '0';

}


?>
<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
    	Meta Tags 
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ==========================
    	Title 
    =========================== -->
    <title>Verify</title>

    <base href="/">
    <!-- ==========================
    	Favicons 
    =========================== -->
    <link rel="shortcut icon" href="icons/favicon.ico">
	<link rel="apple-touch-icon" href="icons/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="icons/apple-touch-icon-114x114.png">
    
    <!-- ==========================
    	Fonts 
    =========================== -->
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- ==========================
    	CSS 
    =========================== -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.transitions.css" rel="stylesheet" type="text/css">
    <link href="assets/css/creative-brands.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery.vegas.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
    
    <!-- ==========================
    	JS 
    =========================== -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<?php include_once("analyticstracking_private.php") ?>

    <h1>&nbsp;</h1>
	
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("views/navbar_blank.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    <?php if($email_alreadyverified == 0): ?>
    <div class="container">
        <section class="content-wrapper">
        	<div class="box">
                <h2>Verification Process</h2>
                
                                <!-- ERROR - START -->
                <div class="error">
                	<h2>Your Account Has Now Been Verified</h2>
                	<p>Thank you for verifying your account you may now enjoy access.  We hope you enjoy Smash And Pass.</p>
                	<a href="/forceset/" class="btn btn-primary btn-lg">Visit / Set Up Profile</a>
                </div>
                <!-- ERROR - END -->
                
            </div>
        </section>
    </div>

    <?php elseif($email_alreadyverified == 1): ?>
    <div class="container">
        <section class="content-wrapper">
        	<div class="box">
                <h2>Verification Process</h2>
                
                                <!-- ERROR - START -->
                <div class="error">
                	<h2>Your Account Has Already Been Verified</h2>
                	<p> We hope you enjoy Smash And Pass.</p>
                	<a href="/forceset/" class="btn btn-primary btn-lg">Set Up Profile</a>
                </div>
                <!-- ERROR - END -->
                
            </div>
        </section>
    </div>

    
    <?php endif; ?>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   
	<?php include("views/footer.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    
    <script src="assets/js/dropzone.js"></script>


</body>
</html>