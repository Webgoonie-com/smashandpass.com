<?php

	include('../classes/db_connect.php');

	include('../classes/restrict_login.php');






if(isset($_POST['user_id'], $_POST['usr_cookie'])){


				
				echo 'Made It!'.$_POST['user_id'].' <-user_id  ';
					

			$user_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));


}else{

	exit();

}



?>