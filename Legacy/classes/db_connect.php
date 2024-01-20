<?php


# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_webgoneGlobal = "localhost";
$database_webgoneGlobal = "smashan_smashandpass";
$username_webgoneGlobal = "smashan_webgoon";
$password_webgoneGlobal = "caution357!!!";

$webgoneGlobal_mysqli = mysqli_connect($hostname_webgoneGlobal, $username_webgoneGlobal, $password_webgoneGlobal) or trigger_error(mysqli_connect_errno(),E_USER_ERROR); 


@$rsession = session_id();

if(empty($rsession)) session_start();

@$sessioncookie = "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];


@$PHPSESSID = session_id();


@$cookie = $_COOKIE["PHPSESSID"];

//Visitor Credentials Save With Visitor Information

@$ip = $_SERVER['REMOTE_ADDR'];

@$query_string = $_SERVER['QUERY_STRING'];

@$http_referer = $_SERVER['HTTP_REFERER'];

@$http_user_agent = $_SERVER['HTTP_USER_AGENT'];

$mobileuserjs = "var ismobile=navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)";

$mobiledevice = "None";
$browser = 'Unknown';

//http://www.htmlgoodies.com/beyond/webmaster/toolbox/article.php/3888106/How-Can-I-Detect-the-iPhone--iPads-User-Agent.htm
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))
 {
  //header('Location: http://yoursite.com/iphone');
  //exit();
  $mobiledevice = "iPhone/Ipod";
}

if(strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'android'))
 {
  //header('Location: http://yoursite.com/iphone');
  //exit();
  $mobiledevice = "Android";
}

?>
<?php
//http://echopx.com/notes/browser-detection-ie-firefox-safari-chrome
if(strstr($_SERVER["HTTP_USER_AGENT"], 'MSIE'))
 {

	//$msie = strstr($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
	$browser = "Internet Explorer";
 }

if(strstr($_SERVER["HTTP_USER_AGENT"], 'Firefox'))
 {

	//$msie = strstr($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
	$browser = "Firefox";
 }


if(strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') || strstr($_SERVER['HTTP_USER_AGENT'],'Safari'))
 {

	//$msie = strstr($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
	$browser = "Safari/Chrome";
 }


		$tkey = bin2hex(openssl_random_pseudo_bytes(10));
		
		$pin = mt_rand(1000, 9999);

		$page = $_SERVER['DOCUMENT_ROOT'].'/'.$_SERVER['REQUEST_URI'];
		
		
		
		$customserver_file = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']; // '/js/custom/'.$page;
		
		
		
		
		
		
		
		
		//Start Your Time Preperation
		$server_time = date("Y-m-d H:i:s");
		
		$converted_time_1 = date("M d Y h:i a D", strtotime($server_time));

?>