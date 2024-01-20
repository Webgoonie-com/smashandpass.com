<?php


include("classes/restrict_login.php");



$message_pageurl  = $url->segment(2);

$member_id  = $url->segment(2);

//
$found_user_owner_id = '-1';



if(!is_numeric($message_pageurl)){

	//exit();
	
		$val = 'NOT';
	
}else{
	//return;
	$val = 'IS';
}


if(is_numeric($member_id)){
	
$member_sql = "SELECT
 	`users`.`user_id` AS theusr_id ,
	`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,
	`users`.`user_networth_ply` as MyLiquidCash, 
	
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			 FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$member_id'";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$row_found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);

	$found_user_id = $row_found_user['user_id'];
	
	if($row_found_user['user_owner_id']){$found_user_owner_id = $row_found_user['user_owner_id'];	}
	//return;
	
}else{

	

$member_sql = "SELECT
	`users`.`user_id` AS theusr_id ,
	`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,
	`users`.`user_networth_ply` as MyLiquidCash, 
	
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			 FROM `smashan_smashandpass`.`users` WHERE `user_nickname` = '$member_id' ORDER BY `user_id` ASC LIMIT 1";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$row_found_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);

 	$found_user_id = $row_found_user['user_id'];
	if($row_found_user['user_owner_id']){$found_user_owner_id = $row_found_user['user_owner_id'];	}



	
}
// if not integer redirect and then exit.



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




$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	

$query_loop_messages = "SELECT * 
	FROM 
		`smashan_smashandpass`.`user_messages`
	LEFT JOIN 
		`smashan_smashandpass`.`users` ON  
		`users`.`user_id` =  `user_messages`.`usr_message_touser_id` 
	 WHERE 
	 	`user_messages`.`usr_message_touser_id` = '$user_id' 
				AND 
		`user_messages`.`usr_message_touser_id` != `user_messages`.`usr_message_frmuser_id`
		
	OR
		`user_messages`.`usr_message_frmuser_id` = '$user_id' 
				AND 
		`user_messages`.`usr_message_touser_id` != `user_messages`.`usr_message_frmuser_id`

	 GROUP BY
	 `users`.`user_id`
	ORDER BY 
	`user_messages`.`usr_message_id` DESC";
$loop_messages = mysqli_query($webgoneGlobal_mysqli, $query_loop_messages);
$row_loop_messages = mysqli_fetch_assoc($loop_messages);
$totalRows_loop_messages = mysqli_num_rows($loop_messages);


$query_loop_message = "
SELECT 
`fromFriend`.`usr_message_id` AS `fromFriend_user_message_id`,
`fromFriend`.`usr_message_frmuser_id`  AS `fromFriend_usr_message_frmuser_id`,
`fromFriend`.`usr_message_read` AS `fromFriend_user_message_read`,
`fromFriend`.`usr_message_touser_id` AS `fromFriend_usr_message_touser_id`,
`fromFriend`.`usr_message_html` AS `fromFriend_user_message_html`,
`fromFriend`.`usr_message_created_at` AS `fromFriend_user_message_created_at`,
`toFriend`.`usr_message_id` AS `toFriend_user_message_id`,
`toFriend`.`usr_message_frmuser_id`  AS `toFriend_usr_message_frmuser_id`,
`toFriend`.`usr_message_read` AS `toFriend_user_message_read`,
`toFriend`.`usr_message_touser_id` AS `toFriend_usr_message_touser_id`,
`toFriend`.`usr_message_html` AS `toFriend_user_message_html`,
`toFriend`.`usr_message_created_at` AS `toFriend_user_message_created_at`,
`u`.`user_emailverify`,
`u`.`user_owner_id`,
`u`.`user_nickname`,
`u`.`user_fname`,
`u`.`user_lname`,
`u`.`show_fullname`,
`u`.`user_token`,
`u`.`user_profile_blob`,
`u`.`user_blob_file_path`,
`u`.`user_pointsvalue`,
`u`.`user_networth_ply`,
`u`.`user_liquidcash_ply`,
`uf`.`user_properties_ply`,
`uf`.`user_assets_ply`,
`uf`.`user_wishers_ply`,
`uf`.`user_growthrate_ply`,
`uf`.`user_view_zipcode`,
`uf`.`user_emailverify`,
`uf`.`user_owner_id`,
`uf`.`user_nickname`,
`uf`.`user_fname`,
`uf`.`user_lname`,
`uf`.`show_fullname`,
`uf`.`user_token`,
`uf`.`user_profile_blob`,
`uf`.`user_blob_file_path`,
`uf`.`user_pointsvalue`,
`uf`.`user_networth_ply`,
`uf`.`user_liquidcash_ply`,
`uf`.`user_properties_ply`,
`uf`.`user_assets_ply`,
`uf`.`user_wishers_ply`,
`uf`.`user_growthrate_ply`,
`uf`.`user_view_zipcode`
	FROM 
		`smashan_smashandpass`.`user_messages` AS `fromFriend`
	LEFT JOIN `smashan_smashandpass`.`user_messages` AS `toFriend` ON
			   `toFriend`.`usr_message_touser_id` = `fromFriend`.`usr_message_touser_id`
	LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `fromFriend`.`usr_message_touser_id`
		   
		   
	LEFT JOIN 
		`smashan_smashandpass`.`users` AS `uf` ON  
		`uf`.`user_id` =  `toFriend`.`usr_message_frmuser_id` 
	 WHERE 
	 	`toFriend`.`usr_message_touser_id` = '$user_id' 
		AND
		`toFriend`.`usr_message_touser_id` = '$found_user_id'
	  OR
        `fromFriend`.`usr_message_touser_id` = '$found_user_id'
		AND
		`fromFriend`.`usr_message_frmuser_id` = '$user_id'

	  OR
        `fromFriend`.`usr_message_frmuser_id` = '$found_user_id'
		AND
		`fromFriend`.`usr_message_touser_id` = '$user_id'
		
		
	 GROUP BY
	 `fromFriend`.`usr_message_id`
	ORDER BY 
	`fromFriend`.`usr_message_id` ASC";
$loop_message = mysqli_query($webgoneGlobal_mysqli, $query_loop_message);
$row_loop_message = mysqli_fetch_assoc($loop_message);
$totalRows_loop_message = mysqli_num_rows($loop_message);



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
    <title>Message Log</title>

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
    <?php include("views/navbar_loggedin.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container hidden-xs">
    	<div class="header-title">
        	<div class="pull-left">
        		<h2><a href="index.html"><span class="text-primary">Mes</span>sages</a></h2>
                <p>View your latest private messages here.</p>
            </div>
        </div>
    </div>
    <!-- ==========================
    	TITLE - END 
    =========================== -->
            
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container">
			<section class="content-wrapper">
        		<div class="row">
            
                    <!-- SIDEBAR - START -->
                    <div class="col-sm-4 hidden-xs">
                        
                        <!-- SIDEBAR BOX - START -->
                        <div class="box sidebar-box widget-wrapper">
                            <h3>Messages</h3>
                            <ul class="nav nav-sidebar">
                                <li><a href="/messages">All <span>Conversations With <?php echo $totalRows_loop_messages; ?> Members</span></a></li>
  <?php if($totalRows_loop_messages != 0){ do {
	  $usr_message_html = trim(strip_tags($row_loop_messages['usr_message_html']));
 ?>
                                
                                <li>
                                    <div class="avatar">
                                    	<a href="message/<?php echo $row_loop_messages['usr_message_touser_id']; ?>">
                                     		<img src="<?php echo $row_loop_messages['user_blob_file_path']; ?>" alt="">
												
												<?php if($row_loop_messages['show_fullname'] == 1){ echo $row_loop_messages['user_fname'].' '.$row_loop_messages['user_lname']; }else if($row_loop_messages['user_nickname']){ echo $row_loop_messages['user_nickname']; }else{ echo $row_loop_messages['user_fname']; } ?>
                                                
                                        </a>
                                    </div>
                                </li>
  <?php } while ($row_loop_messages = mysqli_fetch_array($loop_messages)); }else{ ?>

                                <li><a href="#">Messages<span>0</span></a></li>

<?php } ?>
                            </ul>
                        </div>
                        <!-- SIDEBAR BOX - END -->
                        
                        
                    </div>
                    <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                    <div class="col-sm-8">
    
                        <div class="box">
                            
                         
                         <div class="comments">
                            <h2><?php echo $totalRows_loop_message; ?> Response<?php if ($totalRows_loop_message > 1){ echo 's'; } ?></h2>
                            <input id="fromFriend" type="hidden" value="<?php echo $row_this_user['user_id']; ?>">
                            <input id="toFriend" type="hidden" value="<?php echo $found_user_id; ?>">
                            <input id="viewing_member_id" type="hidden" value="<?php echo $member_id; ?>">
                            <input id="usr_cookie" type="hidden" value="<?php echo $cookie; ?>">
                            <ol class="commentlist">
                                

                                  <!-- COMMENT - START -->
                                <li class="comment">

  <?php if($totalRows_loop_message != 0){ do {
	  $user_message_html = trim(strip_tags($row_loop_message['fromFriend_user_message_html']));
	  
	  $frmuser_id =$row_loop_message['fromFriend_usr_message_frmuser_id'];
	  $tomuser_id =$row_loop_message['fromFriend_usr_message_touser_id'];
	   
 ?>
   
   <?php if($frmuser_id == $member_id){ ?>
                                    <div class="avatar m-t-10">
                                    	<a href="<?php if($row_loop_message['user_nickname']){ echo '/@/'.$row_loop_message['user_nickname']; }else if(!$row_loop_message['user_nickname']){ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; }else{ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; } ?>"><img src="<?php echo $row_loop_message['user_blob_file_path']; ?>" alt=""></a>
                                    </div>
                                    <div class="comment-body">
                                        <div class="author" id="<?php echo $frmuser_id; ?> & <?php echo $tomuser_id; ?> & <?php echo $member_id; ?>">
                                            <h3><a href='#'><?php if($row_loop_message['show_fullname'] == 1){ echo $row_loop_message['user_fname'].' '.$row_loop_message['user_lname']; }else if($row_loop_message['user_nickname']){ echo $row_loop_message['user_nickname']; }else{ echo $row_loop_message['user_fname']; } ?></a></h3>
                                            <div class="meta"><span class="date" title="<?php echo $row_loop_message['fromFriend_user_message_created_at']; ?>"><?php echo $row_loop_message['fromFriend_user_message_created_at']; ?></span></div>
                                        </div>      
                                        <p class="message"><?php echo  $user_message_html; ?></p>
                                       
                                    </div>
                                  
                                    
   <?php }else if($frmuser_id != $tomuser_id){ ?>  

                                    <ul class="children" id="<?php echo $frmuser_id; ?> & <?php echo $tomuser_id; ?> & <?php echo $member_id; ?>">

                                        <!-- COMMENT - START -->
                                        <li class="comment">
                                           <div class="avatar"><a href="<?php if($row_loop_message['user_nickname']){ echo '/@/'.$row_loop_message['user_nickname']; }else if(!$row_loop_message['user_nickname']){ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; }else{ echo 'member/'.$row_loop_message['fromFriend_usr_message_frmuser_id']; } ?>"><img src="<?php echo $row_loop_message['user_blob_file_path']; ?>" alt=""></a></div>
                                            <div class="comment-body">
                                                <div class="author">
                                                    <h3><a href='message/<?php echo $row_loop_message['user_message_id']; ?>'><?php if($row_loop_message['show_fullname'] == 1){ echo $row_loop_message['user_fname'].' '.$row_loop_message['user_lname']; }else if($row_loop_message['user_nickname']){ echo $row_loop_message['user_nickname']; }else{ echo $row_loop_message['user_fname']; } ?></a></h3>
                                                    <div class="meta"><span class="date" title="<?php echo $row_loop_message['fromFriend_user_message_created_at']; ?>"><?php echo $row_loop_message['fromFriend_user_message_created_at']; ?></span></div>
                                                </div>      
                                        <p class="message"><?php echo  $user_message_html; ?></p>
                                               
                                               
                                            </div>
                                        </li>
                                        <!-- COMMENT - END -->
   </ul>
   <?php } ?>   
                                        

                                 
                        
  <?php } while ($row_loop_message = mysqli_fetch_array($loop_message)); } ?>
                                 </li>
                               
                                <!-- COMMENT - END -->
                                
                            </ol>    
                        </div>



                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">Write a comment</h3>
                                <form method="post" id="commentform" class="comment-form">
                                    <div class="form-group comment-form-comment">
                                        <label for="private_messageto_member_html">Comment<span class="required">*</span></label>
                                        <textarea id="private_messageto_member_html" class="form-control" name="private_messageto_member_html" aria-required="true"></textarea>
                                    </div>												
                                    <button id="send_private_message" class="btn btn-primary" type="button">Submit</button>					
                                </form>
                            </div>



						 </div><!-- endview -->




                
                    </div>
                
			</div>
     	</section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   
	<?php include("views/footer_loggedin.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    
    <script src="assets/js/dropzone.js"></script>
   <script src="assets/js/message.js"></script>

</body>
</html>
