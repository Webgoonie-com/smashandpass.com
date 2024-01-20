<?php
include("classes/db_connect.php");


include("classes/restrict_login.php");


$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";



$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];
echo '<br />';

echo '<pre>';
print_r($_SESSION);
echo '</pre>';
echo 'Printed Session';
echo '<br />';
$MM_UsernameAgent = "-1";
if (isset($_SESSION['MM_UsernameAgent'])) {
  $MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];
}
echo '<br />';
echo $query_user = "SELECT  * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$result_query_user = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_array($result_query_user);
$totalRows_user = mysqli_num_rows($result_query_user);
echo '<br />'.$totalRows_user.'<br />';

echo '<br />';
echo 'ID <br />';
echo $userblob_users_id = $row_this_user['user_id'];
echo '<br />';
$user_profile_blob = $row_user['user_profile_blob'];


echo $query_userblob_image_sql = "SELECT  * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `user_imgblobs`.`userblob_users_id` = '$userblob_users_id'";
$userblob_image = mysqli_query($webgoneGlobal_mysqli, $query_userblob_image_sql);
$row_userblob_image = mysqli_fetch_assoc($userblob_image);
$totalRows_userblob_image = mysqli_num_rows($userblob_image);


$userblob_image = $row_userblob_image['userblob_image'];


/// Check if button name "Submit" is active, do this 
if(isset($_POST['user_id'])){

	for($i=0;$i<$count;$i++){
		
		$sql1="UPDATE $tbl_name SET name='$name[$i]', lastname='$lastname[$i]', email='$email[$i]' WHERE id='$id[$i]'";
		
		$result1=mysql_query($sql1);
	}

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Testing Blob</title>
</head>
<body>
<p> <a href="assets/sweetalert/sweetalert.min.js">sweetalert.min.js</a> </p>
<p> <a href="https://unpkg.com/sweetalert/dist/sweetalert.min.js">sweetalert.min.js</a> </p>

<?php echo $row_user['user_fname']; ?> "@<?php echo $row_user['user_nickname']; ?>" <?php echo $row_user['user_lname']; ?>

    <div>
    
        <?php echo 'user_profile_blob: '.$user_profile_blob; ?>
    
    </div>

	<div>

    	<img src="<?php echo 'data:image/png;base64,'.base64_encode($user_profile_blob); ?>" class="img-responsive" alt="">
	</div>



    <div>
    
        <?php echo 'user_profile_blob: '.$user_profile_blob; ?>
    
    </div>

	<div>

    	<img src="<?php echo 'data:image/png;base64,'.base64_encode($user_profile_blob); ?>" class="img-responsive" alt="">
	</div>




<p>
  <button id="seeme" class="btn" onClick="run_swap_deom()" type="button">Click Swap</button>
</p>
<script src="assets/sweetalert/sweetalert.min.js"></script> 
<script>

//swal("Here's the title!", "...and here's the text!");




function run_swap_deom(){



					swal("A wild Pikachu appeared! What do you want to do?", {
				  buttons: {
					cancel: "Run away!",
					catch: {
					  text: "Throw Pokéball!",
					  value: "catch",
					},
					defeat: true,
				  },
				})
				.then(function(value){
				  switch (value) {
				 
					case "defeat":
					  swal("Pikachu fainted! You gained 500 XP!");
					  break;
				 
					case "catch":
					  swal("Gotcha!", "Pikachu was caught!", "success");
					  break;
				 
					default:
					  swal("Got away safely!");
				  }
				});

}
	

</script>
</body>
</html>