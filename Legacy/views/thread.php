<?php


include("classes/restrict_login.php");

$thread_token  = $url->segment(2);
$thread_usrid_belongs  = $url->segment(3);

		$tkey = bin2hex(openssl_random_pseudo_bytes(10));


?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($webgoneGlobal_mysqli, $theValue) : mysqli_escape_string($webgoneGlobal_mysqli,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "
SELECT 	`users`.`user_id` AS theusr_id ,
		`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,  
	
			SUM(`users`.`user_networth_ply`) as MyLiquidCash, 
			
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			
FROM `smashan_smashandpass`.`users`
WHERE `users`.`user_email` = '$MM_UsernameAgent'
";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);
$user_id = $row_user['user_id'];



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

$member_id = $row_userthread['user_id'];



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

?>
<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
    	Meta Tags 
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ==========================
    	Title 
    =========================== -->
    <title>Settings</title>

    <base href="/">
    
    <!-- ==========================
    	Favicons 
    =========================== -->
    <link rel="shortcut icon" href="icons/favicon.ico">
	<link rel="apple-touch-icon" href="icons/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="icons/apple-touch-icon-114x114.png">
    
    <!-- ==========================
    	Fonts 
    =========================== -->
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- ==========================
    	CSS 
    =========================== -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.transitions.css" rel="stylesheet" type="text/css">
    <link href="assets/css/creative-brands.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery.vegas.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
    
    <!-- ==========================
    	JS 
    =========================== -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<?php include_once("analyticstracking_private.php") ?>

    <h1>&nbsp;</h1>
	
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("views/navbar_blank.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->

            
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container">
        <section class="content-wrapper">
                                        
                                        

<?php  //echo $find_userthread_reply_query; ?>
                                        
                                        <?php if($totalRows_userthread == 0): ?>
                    <div id="thread_box" class="box">

                                        <div class="forum-post-wrapper">

                                                        <div class="row">

                                                        <hr />
                                                            <div class="col-sm-3">
                                                                <div class="author-detail">
                                                                  <h5><a href="#">Smash And Pass</a></h5>
                                                                  <p class="function">Moderator</p>
                                                                    <ul class="list-unstyled">
                                                                        <li><strong>Join Date</strong>10/23/2017</li>
                                                                        <li><strong>Reputation</strong>9999</li>
                                                                        <li><strong>Posts</strong>9999</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <article class="forum-post">
                                                                    <div class="date">04-12-2012, 10:18 AM</div>
                                                                    <p>Make Your First Announcement Today</p>
                                                                    <a name="like/admin/" class="btn btn-primary">Like <i class="fa fa-heart"></i></a>
                                                                </article>
                                                            </div>
                                                        </div>
                                        
                                        </div>
                   </div>                                        
                                        <?php else: ?>



                    <div id="thread_box" class="box">
                        <div class="pull-right" style="color:#999; z-index:10;">
                            <span class="close popup-modal-dismiss pull-right" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>                        
                        </div>

                                        <div class="forum-post-wrapper">

                                                        <div class="row">

                                                        <hr />
                                                <div class="col-xs-3 col-sm-3">
                                                    <div class="author-detail">

                                                      <h5><a href="#">@<?php echo $row_userthread['user_nickname']; ?></a></h5>
                                    
                                    <?php if($row_userthread['user_profile_blob']){ ?>
                                    <a href="/member/<?php echo $row_userthread['user_id']; ?>/">
                                     <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row_userthread['user_profile_blob']); ?>" class="img-responsive center-block" alt="">
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

<div id="thesethread_replys" class="<?php echo $status_ofreplys; ?>">
<?php if($totalRows_userthread_reply != 0) { 
do{ 
?>

                    <div id="thread_box" class="box">

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
</div>

                                        <?php endif; ?>
                                        

                                        
                                        
                                        
                                        <div class="clearfix"></div>
        
        
        	
                                        <!-- COMMENT FORM - END --> 
                                        <div id="respond" class="box comment-respond">
                                            <form method="post" id="commentform" class="comment-form">
                                                <div id="<?php echo $member_id;  ?>" class="form-group comment-form-comment">
                                                    <label  id="<?php echo	$picthread_userblob_id; ?>" for="comment">Make A Response Below<span class="required">*</span></label>
                                                    <textarea id="profile_comment" class="form-control" name="profile_comment" placeholder='Say Something Good...' aria-required="true"></textarea>
                                                </div>												
                                                <button id="submit_pubcomment" class="btn btn-primary" type="button">Submit</button>					
                                            </form>
                                        </div>
                                        <!-- COMMENT FORM - END -->  
                                

                                        <div class="clearfix"></div>

        </section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   
	<?php //include("footer_loggedin.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    
<script>

	$('button#submit_pubcomment').on('click', function(){

		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		
		var thread_token = '<?php echo $thread_token; ?>';
		
		console.log('thread_token: '+thread_token);



		var tz = jstz();
		
		var fromuser_timzone = tz.timezone_name;
		console.log('Timezone: '+fromuser_timzone);

		var touser_id = $(this).parent().find('.form-group').attr('id');
		
		console.log('userblob_users_id: '+touser_id);

		var userblob_id = $(this).parent().find('label').attr('id');
		
		console.log('userblob_id: '+userblob_id);

	
		var profile_comment = $('textarea#profile_comment').val();
		
		$.post('classes/scriptpost_publiccomment_reply.php', {user_id: user_id, usr_cookie: usr_cookie, thread_token: thread_token, comment: profile_comment, member_id: touser_id, fromuser_timzone: fromuser_timzone}, function(data){
			
			console.log('Data: '+data);
			
			$('#thesethread_replys').html(data);
			$('textarea#profile_comment').val('');

			
		});
		

		//Activate Reply Threads			
		 $(this).parent().parent().parent().parent().parent().find('#thesethread_replys').addClass('active');		
	
	});
	
	



</script>


</body>
</html>
<?php require('_end.mysql.php'); ?>