<?php


include("db_connect.php");

include("restrict_login.php");



//print_r($_POST);


if(isset($_POST['my_displayname'], $_POST['join_fname'], $_POST['join_lname'], $_POST['my_zipcode'], $_POST['show_fullname'], $_POST['my_gender'], $_POST['my_birth_month'], $_POST['my_birth_day'], $_POST['my_birth_year'], $_POST['my_country'], $_POST['show_mylocation'], $_POST['show_ethnicity'], $_POST['ethnicity_select'], $_POST['my_religion'], $_POST['show_religion'], $_POST['sexualorientation'], $_POST['show_orientation'], $_POST['my_relstatus'], $_POST['show_my_relstatus'])){ 


			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$my_displayname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_displayname']));
			$user_fname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_fname']));
			$user_lname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['join_lname']));
			$show_fullname = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_fullname']));
			$my_gender = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_gender']));
			$user_bdaymonth = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_birth_month']));
			$user_bdayday = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_birth_day']));
			$user_bdayyear = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_birth_year']));
			$user_zipcode = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_zipcode']));
			$user_country = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_country']));
			$show_mylocation = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_mylocation']));
			$show_ethnicity = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_ethnicity']));
			$user_ethnicity = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['ethnicity_select']));
			$user_religion = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_religion']));
			$user_showreligion = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_religion']));
			$user_orientation = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['sexualorientation']));
			$show_orientation =  mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_orientation']));
			$user_relstatus = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['my_relstatus']));
			$show_user_relstatus = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['show_my_relstatus']));
			
	
	$update_user_settings_sql = "
		UPDATE `smashan_smashandpass`.`users` SET
			`user_nickname` = '$my_displayname',
			`user_fname` = '$user_fname',
			`user_lname` = '$user_lname',
			`show_fullname` = '$show_fullname',
			`user_zipcode` = '$user_zipcode',
			`show_mylocation` = '$show_mylocation',
			`user_country` = '$user_country',
			`user_bdaymonth` = '$user_bdaymonth',
			`user_bdayday` = '$user_bdayday',
			`user_bdayyear` = '$user_bdayyear',
			`show_ethnicity` = '$show_ethnicity',
			`user_ethnicity` = '$user_ethnicity',
			`user_religion` = '$user_religion',
			`user_showreligion` = '$user_showreligion',
			`user_sex` = '$my_gender',
			`user_orientation` = '$user_orientation',
			`show_orientation` = '$show_orientation',
			`user_relstatus` = '$user_relstatus',
			`show_user_relstatus` = '$show_user_relstatus',
			`user_sex` = '$my_gender'			
			WHERE
			 `user_id` = '$user_id'
			 ";

	
			$run_update_user_settings_sql =  mysqli_query($webgoneGlobal_mysqli, $update_user_settings_sql) or die(mysqli_connect_errno());
			 

}





?>