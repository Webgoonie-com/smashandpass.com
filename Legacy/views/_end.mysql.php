<?php
//$webgoneGlobal_mysqli->close();


/* 
*	Freeing Up Mysqli Connections From restrict_login.php
*/
mysqli_free_result($query_lastest_members_transactions_sql);

mysqli_free_result($query_lastest_members_advert_sql);
/* 
*	Closing Database Connection from db_connect.php
*/


/* 
*	Freeing Up Mysqli Connections From restrict_login.php
*/
mysqli_free_result($query_user_sql);

mysqli_free_result($query_user_income_sql);
/* 
*	Closing Database Connection from db_connect.php
*/

//mysqli_close($webgoneGlobal_mysqli);
$webgoneGlobal_mysqli->close();
?>