<?php


include("db_connect.php");

include("restrict_login.php");



//print_r($_POST);


if(isset($_POST['user_id'],  $_POST['usr_cookie'], $_POST['thread_token'], $_POST['comment'], $_POST['member_id'], $_POST['fromuser_timzone'] )){ 

			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$thisuser_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['member_id']));

			$thread_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['thread_token']));
			$usr_thread_user_html = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['comment']));
			
// $_POST['fromuser_timzone'];

$find_user_query = "SELECT * FROM 
								`smashan_smashandpass`.`users` 
								WHERE 
								`users`.`user_id`  = '$thisuser_id'
								 LIMIT 1";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	


$find_userthread_query = "SELECT * FROM 
			`smashan_smashandpass`.`user_threads`
			LEFT JOIN `smashan_smashandpass`.`users` 
			ON `user_threads`.`usr_thread_user_id` = `users`.`user_id`
			LEFT JOIN `smashan_smashandpass`.`user_friends` 
			ON `user_threads`.`usr_thread_tomember_id` = `user_friends`.`friend_userid`
			
				WHERE 
				`user_threads`.`usr_thread_user_html` IS NOT NULL
				AND
				 `usr_thread_token` = '$thread_token'
				
					
	ORDER BY `usr_thread_id` DESC 

 ";
$result_userthread = mysqli_query($webgoneGlobal_mysqli, $find_userthread_query);
$row_userthread = mysqli_fetch_assoc($result_userthread);
$totalRows_userthread = mysqli_num_rows($result_userthread);	

$usr_thread_id = $row_userthread['usr_thread_id'];




	// Insesrt reply to public thread.
	$insert_user_publiccomment_sql = "
		INSERT INTO `smashan_smashandpass`.`user_threads_replys` SET
			`rply_usr_thread_id` = '$usr_thread_id',
			`rply_usr_thread_user_id` = '$thisuser_id',
			`rply_usr_thread_tomember_id` = '$member_id',
			`rply_usr_thread_token` = '$thread_token',
			`rply_usr_thread_user_html` = '$usr_thread_user_html'
			 ";

	
			$run_insert_user_publiccomment_sql =  mysqli_query($webgoneGlobal_mysqli, $insert_user_publiccomment_sql) or die(mysqli_connect_errno());

// Run the final replys for updated result after the insert has completed.
$find_userthread_reply_query = "SELECT * FROM 
			`smashan_smashandpass`.`user_threads_replys`
			LEFT JOIN `smashan_smashandpass`.`users` 
			ON `user_threads_replys`.`rply_usr_thread_user_id` = `users`.`user_id`
			LEFT JOIN `smashan_smashandpass`.`user_friends` 
			ON `user_threads_replys`.`rply_usr_thread_tomember_id` = `user_friends`.`friend_userid`
			
				WHERE 
				`user_threads_replys`.`rply_usr_thread_user_html` IS NOT NULL
				AND
				 `rply_usr_thread_token` = '$thread_token'
				
					
	ORDER BY `rply_usr_thread_id` DESC 

 ";
$result_userthread_reply = mysqli_query($webgoneGlobal_mysqli, $find_userthread_reply_query);
$row_userthread_reply = mysqli_fetch_assoc($result_userthread_reply);
$totalRows_userthread_reply = mysqli_num_rows($result_userthread_reply);	

if($totalRows_userthread_reply != 0){ $status_ofreplys = 'active'; }else{ $status_ofreplys = ''; }


}else{ exit(); }




$server_time = date("Y-m-d H:i:s");


$converted_time_1 = date("M d Y h:i a D", strtotime($server_time));







?>

<?php if($totalRows_userthread_reply != 0) { 
do{ 
?>

                    <div class="box">

                                        <div class="forum-post-wrapper">

                                                        <div class="row">

                                                        <hr />
                                                <div class="col-xs-3 col-sm-3">
                                                    <div class="author-detail pull-left">

                                                      <h5><a href="/member/<?php echo $row_userthread_reply['user_id']; ?>/">@<?php echo $row_userthread_reply['user_nickname']; ?></a></h5>
                                    
                                    <?php if($row_userthread_reply['user_profile_blob']){ ?>
                                    <a href="/member/<?php echo $row_userthread_reply['user_id']; ?>/" class="pull-left">
                                     <img width="35%" src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row_userthread_reply['user_profile_blob']); ?>" class="img-responsive center-block img-circle pull-left" alt="">
                                    </a>
									<?php }else{ ?>
                                    <img src="assets/images/loading.gif" class="img-responsive center-block img-circle pull-left" alt="">
                                    <?php } ?>
                                    				</div>
                                    			</div>



                                                            <div class="col-sm-9">
                                                                <article class="forum-post">
                                                                <?php $rply_usr_thread_created_at = $row_userthread_reply['rply_usr_thread_created_at']; ?>
                                                                    <div class="date"><?php echo date( "M d Y h:i a D", strtotime("$rply_usr_thread_created_at") ); ?></div>
                                                                    <p><?php echo $row_userthread_reply['rply_usr_thread_user_html']; ?></p>
                                                                    <a name="like/admin/" class="btn btn-primary">Like <i class="fa fa-heart"></i></a>
                                                                </article>
                                                            </div>
                                                        </div>

                                        </div>

                    </div>                 


<?php } while ($row_userthread_reply = mysqli_fetch_array($result_userthread_reply)); }   ?>
<?php require('_end.mysql.php'); ?>