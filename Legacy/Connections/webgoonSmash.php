<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
session_start();
$hostname_webgoonSmash = "localhost";
$hostname_webgoneGlobal  = "localhost";
$database_webgoonSmash = "smashan_smashandpass";
$webgoonSmash = "smashan_smashandpass";
$username_webgoonSmash = "smashan_webgoon";
$username_webgoneGlobal = "smashan_webgoon";
$password_webgoonSmash = "caution357!!!";
$password_webgoneGlobal = "caution357!!!";
$webgoonSmashli = mysqli_connect($hostname_webgoneGlobal, $username_webgoneGlobal, $password_webgoneGlobal) or trigger_error(mysqli_connect_errno(),E_USER_ERROR); 
$webgoneGlobal_mysqli = mysqli_connect($hostname_webgoneGlobal, $username_webgoneGlobal, $password_webgoneGlobal) or trigger_error(mysqli_connect_errno(),E_USER_ERROR); 

?>