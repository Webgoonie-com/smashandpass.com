<?php

// https://developers.facebook.com/docs/php/howto/example_facebook_login/5.0.0
// https://stackoverflow.com/questions/33867590/facebook-php-sdk-graph-returned-an-error-invalid-oauth-access-token

// App ID
// 907422053027508

// App Secret
// 516897654c1ad90fa2c2043c0502dc5e
require_once("classes/db_connect.php");

require_once('Facebook/vendor/autoload.php'); // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '907422053027508',
  'app_secret' => '516897654c1ad90fa2c2043c0502dc5e',
  'default_graph_version' => 'v2.10',
  'default_access_token' => '$tkey', // optional
]);

$helper = $fb->getRedirectLoginHelper();


//$permissions = ['email']; // Optional permissions
$permissions = ['email','public_profile']; // optional
$callbackUrl = htmlspecialchars('https://www.smashandpass.com/fb-callback.php');
$loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);

//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

echo "<a class='btn btn-block btn-social btn-facebook col-6-sm' href=" . $loginUrl . "><span class='fa fa-facebook'></span> Facebook Login</a>";
?>

