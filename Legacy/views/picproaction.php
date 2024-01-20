<?php

include("classes/restrict_login.php");

$pic_id  = $url->segment(2);

$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);

$find_user_query = "SELECT * FROM  `smashan_smashandpass`.`users`, `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = `user_id`  AND `userblob_id` = '$pic_id'  ORDER BY `userblob_id` DESC LIMIT 1";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	

$userblob_users_id = $row_ofuser['userblob_users_id'];
$picthread_userblob_id = $row_ofuser['userblob_id'];

$find_user_picthreads_query = "SELECT * FROM `smashan_smashandpass`.`user_picthreads`, `smashan_smashandpass`.`users` WHERE `picthread_userblob_id` = '$pic_id' AND `picthread_fromuserid` = `user_id` ORDER BY `picthread_id` DESC ";
$result_picthread = mysqli_query($webgoneGlobal_mysqli, $find_user_picthreads_query);
$row_picthread = mysqli_fetch_assoc($result_picthread);
$totalRows_picthread = mysqli_num_rows($result_picthread);	


$query_user_piclike = "SELECT * FROM `smashan_smashandpass`.`likes_collection` WHERE `like_blob_id` = '$pic_id' AND `like_user_id` = '$user_id' ORDER BY `like_id` DESC ";
$user_piclike = mysqli_query($webgoneGlobal_mysqli, $query_user_piclike);
$row_user_piclike = mysqli_fetch_assoc($user_piclike);
$totalRows_user_piclike = mysqli_num_rows($user_piclike);	



$find_piclikes_query = "SELECT * FROM `smashan_smashandpass`.`likes_collection` WHERE `like_blob_id` = '$pic_id' ORDER BY `like_id` DESC";
$result_piclikes = mysqli_query($webgoneGlobal_mysqli, $find_piclikes_query);
$row_piclikes = mysqli_fetch_assoc($result_piclikes);
$totalRows_piclikes = mysqli_num_rows($result_piclikes);	


$userblob_image_type = $row_ofuser['userblob_image_type'];

$userblob = 'data:'.$userblob_image_type.';base64,';



$server_time = date("Y-m-d H:i:s");

$converted_time_1 = date("M d Y h:i a D", strtotime($row_ofuser['userblob_image_created_at']));

$date = new DateTime("2019-01-09 16:43:21", new DateTimeZone('Europe/Paris')); 
$thedate = date("Y-m-d h:iA", $date->format('U'));







?>
<div class="container">
	<div class="row justify-content-md-center">


                <div class="col-10-md" align="center" style="margin-left:100px; margin-right:100px;">



                    <div class="col-sm-8 box box" align="right" style=" background-color:#000; padding:16px;">
                    
                        <div class="pull-right" style="color:#999; z-index:10;">
                            <span class="close popup-modal-dismiss pull-right" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>                        
                        </div>

                    <div class="col-sm-10" align="center" style="background-color:#000; padding:5px;">

                        <div class="wrap-pic">
                        <img id="big_pication" src="<?php echo $userblob.base64_encode($row_ofuser['userblob_image'] ); ?>" class="img-responsive" alt="">
                        </div>
                    
					                    
                    
                    <div id="pic_action_likebox" class="row">
		                    <ul id="li-actions" rel="<?php echo $row_ofuser['userblob_id']; ?>" class="like <?php if($totalRows_user_piclike == 0){ echo ''; }else{ echo 'unlike'; } ?>">
                                <li>
                                    <i class="fa fa-thumbs-up fa-3x"></i>
                                </li>
                                <li class="likecount fa fa-2x"> 
                                    <?php echo $totalRows_piclikes;  ?>
                                </li>
                                <li class="comment pull-right">
	                                <i class="fa fa-comments-o fa-3x" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </div>

						</div>
                    </div>

                    </div>
                    <div id="pic_comment_box" class="col-sm-4 box" align="left">
                    	
                        
                        <div class="row">
                        
                        <div class="ibox-title">
                                    <span class="close popup-modal-dismiss pull-right" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                    
                                </div>


       
                        
                        
                        <h5><a id="window_member_view" target="_parent" href="member/<?php echo $row_ofuser['user_id']; ?>"><span style="color:#00F; text-decoration:underline;"><?php if(!$row_ofuser['user_nickname']){ echo $row_ofuser['user_fname'].' '.$row_ofuser['user_lname']; }else{ echo $row_ofuser['user_nickname']; } ?></span></a></h5>
                        <h6 title="<?php echo $row_ofuser['userblob_image_created_at']; ?>"><strong>Published:</strong> <?php echo date("M d Y h:i a D", strtotime($row_ofuser['userblob_image_created_at'])); ?></h6>
                        
                        <hr />
<?php //echo $find_user_query; ?>


                <!-- COMMENT WRAPPER - START -->
                <div class="comments">
                    <ol class="commentlist">

							<?php if($totalRows_picthread != 0): do{ ?>
                            
                                        
                            
                    
                        <!-- COMMENT - START -->
                        <li id="<?php echo $row_picthread['picthread_id']; ?>" class="comment picthread">
                            <div class="avatar"><img src="<?php echo $row_picthread['user_blob_file_path']; ?>" alt=""></div>
                            <div class="comment-body">
                                <div class="author">
                                    <h3><?php echo $row_picthread['user_nickname']; ?></h3>
                                    <div class="meta"><span class="date" title="<?php echo date("M d Y h:i a D", strtotime($row_picthread['picthread_created_at'])); ?>"><?php echo date("M d Y h:i a D", strtotime($row_picthread['picthread_created_at'])); ?></span></div>
                                </div>      
                                <p class="message comtext"><?php echo $row_picthread['picthread_comtext']; ?></p>
                                <div class="reply"><a id="<?php echo $row_picthread['picthread_id']; ?>"><i class="fa fa-reply"></i>Reply</a></div>
                            </div>
                        </li>
                        <!-- COMMENT - END -->

                            <?php } while ($row_picthread = mysqli_fetch_array($result_picthread)); endif; ?>
                        
                        
                        
                    </ol>    
                </div>
                <!-- COMMENT WRAPPER - START -->
                
                        
                            
                        </div>
                        <div class="row">
                        	<div>

                                        <!-- COMMENT FORM - END --> 
                                        <div id="respond" class="box comment-respond">
                                            <form method="post" id="commentform" class="comment-form">
                                                <div id="<?php echo $userblob_users_id;  ?>" class="form-group comment-form-comment">
                                                  <label id="<?php echo	$picthread_userblob_id; ?>" for="comment">Comment on this pic<span class="required">*</span></label>
                                                    <textarea name="pic_comment" rows="2" class="form-control" id="pic_comment" placeholder='Comment...' aria-required="true"></textarea>
                                                </div>												
                                                <button id="submit_pubcomment" class="btn btn-primary" type="button">Submit</button>
                                                
                                               				
                                            </form>
                                        </div>
                                        <!-- COMMENT FORM - END -->  

					 
                            </div>
                                                   

                        </div>
                        
                        
                    </div>

						<div class="clearfix"></div>
                </div>
	
    
    </div>
</div>
<script>

	$('button#submit_pubcomment').on('click', function(){

		var tz = jstz();
		
		var fromuser_timzone = tz.timezone_name;
		console.log('Timezone: '+fromuser_timzone);


		var touser_id = $(this).parent().find('.form-group').attr('id');
		
		console.log('userblob_users_id: '+touser_id);

		var userblob_id = $(this).parent().find('label').attr('id');
		
		console.log('userblob_id: '+userblob_id);

















	
		var pic_comm = $('textarea#pic_comment').val();
		
		$.post('classes/script_pic_comment.php', {pic_comm: pic_comm, touser_id: touser_id, userblob_id: userblob_id, fromuser_timzone: fromuser_timzone}, function(data){
			
			console.log('Data: '+data);
			
			$('ol.commentlist').prepend(data);
			$('textarea#pic_comment').val('');
		});
		
		
	
	});
	
	



</script>
<?php require('_end.mysql.php'); ?>