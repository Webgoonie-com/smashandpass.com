<?php


include("db_connect.php");

include("restrict_login.php");



//print_r($_POST);


if(isset($_POST['pic_comm'], $_POST['touser_id'], $_POST['fromuser_timzone'], $_POST['userblob_id'])){ 

			
			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
			$picthread_touser_id = mysqli_real_escape_string($webgoneGlobal_mysqli, trim($_POST['touser_id']));
			$fromuser_timzone = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['fromuser_timzone']));
			$picthread_userblob_id  = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['userblob_id']));
			$usr_thread_user_html = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['pic_comm']));
	
	$insert_user_publiccomment_sql = "
		INSERT INTO `smashan_smashandpass`.`user_picthreads` SET
			`picthread_touser_id` = '$picthread_touser_id',
			`picthread_fromuserid` = '$user_id',
			`picthread_fromuser_timzone` = '$fromuser_timzone',
			`picthread_userblob_id` = '$picthread_userblob_id',
			`picthread_token` = '$user_token',
			`picthread_comtext` = '$usr_thread_user_html'
			 ";

	
			$run_insert_user_publiccomment_sql =  mysqli_query($webgoneGlobal_mysqli, $insert_user_publiccomment_sql) or die(mysqli_connect_errno());
			 

}else{ exit(); }




//$date = new DateTime("Y-m-d h:iA", new DateTimeZone("$fromuser_timzone")); 

$server_time = date("Y-m-d H:i:s");


$thedate = date("M d Y h:i a D", strtotime($server_time));



$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);






?>


                    
                        <!-- COMMENT - START -->
                        <li id="<?php echo $row_picthread['picthread_id']; ?>" class="comment picthread">
                            <div class="avatar"><img src="<?php echo $row_user['user_blob_file_path']; ?>" alt=""></div>
                            <div class="comment-body">
                                <div class="author">
                                <?php if(!$row_user['user_nickname']){ ?>

                                    <h3><?php echo $row_user['user_fname']; ?> <?php echo $row_user['user_lname']; ?></h3>
                                    
                                <?php }else{ ?>
                                
                               		<h3><?php echo $row_user['user_nickname']; ?></h3>
                                    
                                <?php } ?>
                                    <div class="meta"><span class="date" title="<?php echo $thedate; ?>"><?php echo $thedate; ?></span></div>
                                </div>      
                                <p class="message comtext"><?php echo $_POST['pic_comm']; ?></p>
                                <div class="reply"><a id="<?php echo $row_picthread['picthread_id']; ?>"><i class="fa fa-reply"></i>Reply</a></div>
                            </div>
                        </li>
                        <!-- COMMENT - END -->

<?php require('_end.mysql.php'); ?>