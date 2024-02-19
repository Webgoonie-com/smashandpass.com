<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
session_start();
$hostname_webgoonSmash = "localhost";
$hostname_webgoneGlobal  = "localhost";
$database_webgoonSmash = "webgoon_smashandpass";
$webgoonSmash = "webgoon_smashandpass";
$username_webgoonSmash = "smashan_webgoon";
$username_webgoneGlobal = "smashan_webgoon";
$password_webgoonSmash =  "5^M+cD7P)+#?";
$password_webgoneGlobal = "5^M+cD7P)+#?";
$webgoonSmashli = mysqli_connect($hostname_webgoneGlobal, $username_webgoneGlobal, $password_webgoneGlobal, $database_webgoonSmash) or trigger_error(mysqli_connect_errno(),E_USER_ERROR); 
$webgoneGlobal_mysqli = mysqli_connect($hostname_webgoneGlobal, $username_webgoneGlobal, $password_webgoneGlobal, $database_webgoonSmash) or trigger_error(mysqli_connect_errno(),E_USER_ERROR); 

?>