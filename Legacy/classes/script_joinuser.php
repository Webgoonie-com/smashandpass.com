<?php




ini_set("include_path", '/home/smashan/php:' . ini_get("include_path") );

include("Mail.php");


require_once("db_connect.php");



if(isset($_POST)){ 

	//print_r($_POST);
	
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$user_fname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_fname']));
			$user_lname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_lname']));
			$user_email = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_email']));
			if(!$user_email){
				exit();
			};
			
			$user_password = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_pass']));
			$user_zipcode = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_zipcode']));
			$user_bdaymonth = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['birth_month']));
			$user_bdayday = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['birth_day']));
			$user_bdayyear = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['birth_year']));
			$user_ethnicity = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['ethnicity']));
			$user_sex = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_sex']));
			$user_orientation = '';
			$user_pointsvalue = '20';

$find_user_query = "SELECT `user_email` FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$user_email'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
//$result_ofuser = $webgoneGlobal_mysqli->query("SELECT `user_email` FROM `smashan_smashandpass` WHERE `user_email` = '$user_email'");
//$row_ofuser = $result_ofuser->fetch_assoc();
$row_ofusercount = mysqli_num_rows($result_ofuser);	





	
 $insert_join_user_sql = "
		INSERT INTO `smashan_smashandpass`.`users` SET
			`user_token` = '$user_token',
			`user_emailverify` = '0',
			`user_fname` = '$user_fname',
			`user_lname` = '$user_lname',
			`user_email` = '$user_email',
			`user_password` = '$user_password',
			`user_zipcode` = '$user_zipcode',
			`user_bdaymonth` = '$user_bdaymonth',
			`user_bdayday` = '$user_bdayday',
			`user_bdayyear` = '$user_bdayyear',
			`user_ethnicity` = '$user_ethnicity',
			`user_sex` = '$user_sex',
			`user_orientation` = '$user_orientation',
			`user_pointsvalue` = '$user_pointsvalue'
	";

if($row_ofusercount == 0){

include("smtp_email_verify.php");

}
	
	if($row_ofusercount == 0){
		
	
			$run_query_join_user_sql =  mysqli_query($webgoneGlobal_mysqli, $insert_join_user_sql) or die(mysqli_connect_errno());
			$new_join_user_id = mysqli_insert_id($webgoneGlobal_mysqli);
			
			    //declare two session variables and assign them
    $_SESSION['MM_UsernameAgent'] = $_POST['join_email'];
    $_SESSION['MM_UserGroupAgent'] = 1;

	//print_r($_SESSION);


			echo "
			<script>
				console.log('No User Exist!');
				run_userjoin_script();
			</script>
			";


	}else{
	
			echo "
			<script>
				console.log('User already Exist!');
				run_useralreadyexist_script();
			</script>
			";
	
	}



	
	
}

?>