<?php


include("db_connect.php");

include("restrict_login.php");






if(isset($_POST['user_id'],  $_POST['usr_cookie'], $_POST['comment'], $_POST['member_id'] )){ 


			$usr_cookie = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['usr_cookie']));
			$thisuser_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['user_id']));
			$member_id = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($_POST['member_id']));

			$user_token = mysqli_real_escape_string($webgoneGlobal_mysqli,trim($tkey));
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







	
	$insert_user_publiccomment_sql = "
		INSERT INTO `smashan_smashandpass`.`user_threads` SET
			`usr_thread_user_id` = '$user_id',
			`usr_thread_tomember_id` = '$member_id',
			`usr_thread_token` = '$user_token',
			`usr_thread_user_html` = '$usr_thread_user_html'
			 ";

	
			$run_insert_user_publiccomment_sql =  mysqli_query($webgoneGlobal_mysqli, $insert_user_publiccomment_sql) or die(mysqli_connect_errno());
			 

}else{ exit(); }




$server_time = date("Y-m-d H:i:s");


$converted_time_1 = date("M d Y h:i a D", strtotime($server_time));



// SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` AND `users`.`user_id` = '$member_id' ORDER BY `usr_thread_id` DESC 
$find_user_threadquery = "SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` = `users`.`user_id` AND `usr_thread_tomember_id` = '$user_id' ORDER BY `usr_thread_id` DESC ";
$result_userthread = mysqli_query($webgoneGlobal_mysqli, $find_user_threadquery);
$row_userthread = mysqli_fetch_assoc($result_userthread);
$totalRows_userthread = mysqli_num_rows($result_userthread);	







?>


<?php do{ ?>
                    <div id="thread_box" class="box">
                                        <div class="forum-post-wrapper">

                                                        <div class="row">
                                                        <hr />
                                                <div class="col-xs-3 col-sm-3">
                                                    <div class="author-detail">

                                                      <h5><a href="#">@<?php echo $row_userthread['user_nickname']; ?></a></h5>
                                    
                                    <?php if($row_userthread['user_profile_blob']){ ?>
                                    <!-- a href="/member/<?php //echo $row_userthread['user_id']; ?>/" -->
                                    <a href="#">
                                     <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row_userthread['user_profile_blob']); ?>" class="img-responsive center-block img-circle" alt="">
                                    </a>
									<?php }else{ ?>
                                    <img src="assets/images/loading.gif" class="img-responsive center-block img-circle" alt="">
                                    <?php } ?>
                                    				</div>
                                    			</div>



                                                            <div class="col-sm-9">
                                                                <article class="forum-post">
                                                                <?php $usr_thread_created_at = $row_userthread['usr_thread_created_at']; ?>
                                                                    <div class="date"><?php echo date( "M d Y h:i a D", strtotime("$usr_thread_created_at") ); ?></div>
                                                                    <p><?php echo $row_userthread['usr_thread_user_html']; ?></p>
                                                                    <a name="like/admin/" class="btn btn-primary">Like <i class="fa fa-heart"></i></a>
                                                                </article>
                                                            </div>
                                                        </div>

                                        </div>
                   </div>

<?php } while ($row_userthread = mysqli_fetch_array($result_userthread)); ?>



<?php require('_end.mysql.php'); ?>