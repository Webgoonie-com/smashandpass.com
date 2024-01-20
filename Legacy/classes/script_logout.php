<?php
// *** Logout the current user.
$logoutGoTo = "../../";
//$logoutGoTo = "index.php";
//$logoutGoTo = $_SERVER['DOCUMENT_ROOT'];

if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_UsernameAgent'] = NULL;
$_SESSION['MM_UserGroupAgent'] = NULL;
unset($_SESSION['MM_UsernameAgent']);
unset($_SESSION['MM_UserGroupAgent']);
unset($_SESSION['PrevUrl']);
$_SESSION = array();
$params = session_get_cookie_params();
setcookie(session_name(), '', time() -42000,
  $params["path"], $params["domain"],
  $params["secure"], $params["httponly"]);
session_destroy();
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>