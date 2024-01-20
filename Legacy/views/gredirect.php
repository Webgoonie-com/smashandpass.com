<?php require_once("../api/google/src/vendor/autoload.php"); ?>
<?php


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
$gredirectUri = "https://www.smashandpass.com/googlelogin";



// Creating 
$gclient = new Google_Client();

$gclient->setClientId($gclientId);

$gclient->setClientSecret($gclientSecret);

$gclient->setRedirectUri($gredirectUri);

// Now we must add some scopes

$gclient->addScope('email');
$gclient->addScope('profile');


if(isset($_GET['code'])){
	
	$gtoken = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
	
	$gclient->setAccessToken($gtoken['access_token']);
	// get profile info
	
	$google_oauth = new Google_Service_Oauth2($gclient);
	
	$google_account_info = $google_oauth->userinfo->get();
	
	$gemail = $google_account_info->email;
	
	$gname = $google_account_info->name;
	
	$gpicture = $google_account_info->picture;
	
	echo "<h1>Profile</h1>";
	
	echo "<h1>$gemail</h1>";
	
	echo "<h1>$gname</h1>";

	echo "<img src='$gpicture'>";
		
	}else{
		echo "<a href=" . $gclient->createAuthUrl() . ">Google Login</a>";
	}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google Redirect</title>
</head>

<body>
</body>
</html>