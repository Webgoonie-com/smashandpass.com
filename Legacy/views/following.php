<?php

include("classes/restrict_login.php");



$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "
SELECT 	`users`.`user_id` AS theusr_id ,
		`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,
	`users`.`user_networth_ply` as MyLiquidCash, 
	
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			
FROM `smashan_smashandpass`.`users`
WHERE `users`.`user_email` = '$MM_UsernameAgent'
";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);
$user_id = $row_user['user_id'];
$user_owner_id = $row_user['user_owner_id'];


// Defining MyLiquidWorth
$MyLiquidCash = $row_user['MyLiquidCash'];
$SumPlyrassets = $row_user['SumPlyrassets'];
$CountMyOwnNetworth = $MyLiquidCash + $SumPlyrassets;



// Pull Up Your Owner And Count Stats
$query_userown_sql = "SELECT 
`users`.`user_id` AS theusr_id ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as CountMyOwnNetworth, 
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM `smashan_smashandpass`.`users` 
WHERE 
	`user_id` = '$user_owner_id'
	GROUP BY `user_id`
";
$query_userown = mysqli_query($webgoneGlobal_mysqli, $query_userown_sql);
$row_userown = mysqli_fetch_assoc($query_userown);
$totalRows_userown = mysqli_num_rows($query_userown);

$CountMyOwnershipValue = $row_userown['CountMyOwn'];





//Runs the acutal query
$query_plyrassets_sql = "SELECT 
`users`.`user_id` AS theusr_id, `users`.`user_id`, `users`.`user_owner_id`, `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply` ,

			`users`.`user_networth_ply` as MyLiquidCash, 
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets

FROM 
	`smashan_smashandpass`.`users` 
WHERE 
	`users`.`user_owner_id` = '$user_id'
";
$plyrassets = mysqli_query($webgoneGlobal_mysqli, $query_plyrassets_sql);
$row_plyrassets = mysqli_fetch_assoc($plyrassets);
$totalRows_plyrassets = mysqli_num_rows($plyrassets);



$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);




$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	



$find_members_following_query = "SELECT 
* FROM 
`smashan_smashandpass`.`user_following`
LEFT JOIN `smashan_smashandpass`.`users` ON
`users`.`user_id` = `user_following`.`follow_userid`
WHERE 
`user_following`.`follow_memberid` = '$user_id'";
$result_members_following = mysqli_query($webgoneGlobal_mysqli, $find_members_following_query);
$row_members_following = mysqli_fetch_assoc($result_members_following);
$totalRows_members_following = mysqli_num_rows($result_members_following);




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
    <title>Following</title>

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
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("views/navbar_loggedin.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    <?php include("views/subfolder/_profile_modals.php"); ?>
    
    
    
        
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container">
        <section class="content-wrapper">
        	<div class="row">
            
            	<!-- SIDEBAR - START -->
            	<div id="thin_long_block" class="col-sm-4">
					
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper">
                    	<!--h3>Profile <a href="/uphoto" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a></h3 --> 
                        <div>
						<?php if(!$row_user['user_nickname']){ ?>

                        
                        <div class="form-group">
							 <label class="control-label">Create Your Username Url: <span id="username_htmlresults">&nbsp;</span></label>
	                         <div class="input-group">
                       		<input id="user_nicknameurl" type="text" class="form-control input-sm" name="user_nicknameurl" placeholder="Username" value="<?php echo $row_user['user_nickname']; ?>">
                            <span class="input-group-btn">
                                <button id="check_usernameurl" class="btn btn-primary" type="button" style="display:block;">Check</button>
                                <button id="save_usernameurl" class="btn btn-primary" type="button" style="display:none;">Save</button>
                            </span>
                             
                             </div>
                        </div>


                         <?php }else{ ?>
                       		<h3>@<?php echo $row_user['user_nickname']; ?></h3>
                         <?php } ?>
                        </div> 
                                          
                        <div class="tournament">
                        
                        <div id="profile_pic_block" align="center">
                        <?php if(!$row_user['user_profile_blob']): ?>

                    
                        	<a><img id="profile_bpic" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
                        
                            
                       <?php else: ?>

                        	<a rel="clearbox[gallery=Gallery,,width=600,,height=400]" href="/<?php echo $row_user['user_blob_file_path']; ?>">
                            <img id="profile_bpic" src="<?php echo 'data:image/png;base64,'.base64_encode($row_user['user_profile_blob']); ?>" class="img-responsive"  alt="">
                            </a>


                       
                       <?php endif; ?>
                        
                        </div>
                        
                        <div>
                        	<a id="top_btn_photoupload" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a>
                        </div>
                            

								<div class="team-member">
                                    <ul class="list-unstyled">
                                        <li><strong>NetWorth</strong>$  <?php echo $CountMyOwnNetworth; ?></li>
                                        <li><strong>Liquid Cash:</strong>$ <?php echo $row_user['MyLiquidCash']; ?></li>
                                        <li><strong>Asset(s):</strong>$  <?php echo  $row_user['SumPlyrassets']; ?></li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li><strong>Growth Rate</strong><?php echo $row_found_user['user_growthrate_ply']; ?>% Up<i class="fa fa-up"></i></li>
                                    </ul>
                                    <p><?php //echo $query_user; ?></p>

                                </div>                            
                            
                            
                            <button class="btn btn-block btn-lg btn-warning">Earn More Gold</button>
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">
                    	<h3>Top Assets <a target="_parent" href="myassets" class="btn btn-primary pull-right btn-sm">All Assets</a></h3>
                        
                       
                            <table class="table match-wrapper">
                                <tbody>
                                <?php if($totalRows_plyrassets != 0){ ?>
<?php do{ ?>
                                    <tr>
                                        <td class="game">
                                        <a href="/member/<?php echo $row_plyrassets['user_id']; ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_plyrassets['user_profile_blob']); ?>" class="img-circle" alt="">
                                        </a>
                                            <span>@<? echo $row_plyrassets['user_nickname']; ?></span>
                                       
                                        </td>
                                        <td class="game-date">
                                            <span>$<? echo $row_plyrassets['user_networth_ply']; ?></span>
                                        </td>
                                    </tr>
<?php } while ($row_plyrassets = mysqli_fetch_array($plyrassets)); ?>
<?php }else{ ?>
                                    
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/usa.png" alt=""><a href="/buyassets">Buy Assets</a></td>
                                        <td class="team-score">Play Smash And Pass</td>
                                    </tr>
<?php } ?>                     
                                </tbody>
                            </table>

                        
                        
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">
                        <h3>Recent Photos <a name="/topassets" class="btn btn-primary pull-right btn-sm">Photos</a></h3>
                        
                        <a name="/topassets">
                            <table class="table match-wrapper">
                                <tbody>

<?php do{ ?>


                              
                                    <tr>
                                        <td class="game">
                                            <img src="<?php echo  'data:image/jpeg;base64,'.base64_encode($row_ofuser_pic['userblob_image']); ?>" alt="">
                                            
                                        </td>
                                        <td class="game">
                                          <?php $userblob_image_created_at = $row_ofuser_pic['userblob_image_created_at']; ?>

                                        	<span><?php echo date( "M  Y D", strtotime( "$userblob_image_created_at" ) ); ?></span>
                                            
                                        </td>
                                    </tr>

  <?php } while ($row_ofuser_pic = mysqli_fetch_array($result_ofuser_pic)); ?>

                                </tbody>
                            </table>
                        </a>
                        
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div id="main_long_block" class="col-sm-8">
                <!-- ==========================
                    CONTENT - START 
                =========================== -->
                            <div class="box colored config">
                                <p>Here you can gain more buying power. <a href="/buycredits" class="btn btn-simple">Buy Gold</a></p>
                            </div>


							<div class="box">

                            <?php if($totalRows_members_following  != 0): do { 
							if($row_members_following['user_nickname']){ $USERNAME = $row_members_following['user_nickname'];  $USERLINK = '/@/'.$row_members_following['user_nickname']; }else{ $USERLINK = '/member/'.$row_members_following['user_id'];  $USERNAME = $row_members_following['user_fname']; }
                            if($row_members_following['user_profile_blob']){ $FRIENDPHOTO =  'data:image/png;base64,'.base64_encode($row_members_following['user_profile_blob']); }else if($row_members_following['user_blob_file_path']){$FRIENDPHOTO = $row_members_following['user_blob_file_path']; }else{  $FRIENDPHOTO = 'assets/images/blank_profileimg.png'; }
                        ?>

                                <article class="post">
                                    <div class="post-date-wrapper">
                                        <div class="post-date">
                                            <div class="day"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">25</font></font></div>
                                            <div class="month"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Jan 2014</font></font></div>
                                        </div>
                                        <div class="post-type">
                                            <i class="fa fa-video-camera"></i>
                                        </div>
                                    </div>
                                    <div class="post-body">
                                        <?php if($row_members_following['user_nickname']){ ?>
                                        <h2><a href="<?php echo $USERLINK; ?>"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">@</font><?php echo $row_members_following['user_nickname']; ?></a></h2>
                                        <?php }else{ ?>
                                        <h2><a href="<?php echo $USERLINK; ?>"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $row_members_following['user_fname']; ?></font></a></h2>
                                        <?php } ?>
                                        
                                        <h2><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Following: <?php echo $USERNAME; ?></font></font></h2>
                                        
                                        
                                        <p><img src="<?php echo $FRIENDPHOTO; ?>" class="img-responsive center-block img-circle" alt="">
                                        	<font style="vertical-align: inherit;">
                                            	<?php if($row_members_following['user_aboutme']){ echo $row_members_following['user_aboutme']; }else{ echo '<img src="assets/images/favicon.png" class="img-responsive pull-left" alt="">'; } ?>
                                            </font>
                                        </p>
                                        <div class="post-info">
                                            <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Member: </font></font></span>
                                            <a href="<?php echo $USERLINK; ?>" class="btn btn-inverse"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">View Profile</font></font></a>
                                        </div>
                                    </div>
                                </article>            
						  <?php } while ($row_members_following = mysqli_fetch_array($result_members_following)); else: ?>
                          
                           <article class="post">
                                    <div class="post-date-wrapper">
                                        <div class="post-date">
                                            <div class="day"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo date('d'); ?></font></font></div>
                                            <div class="month"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo date('M Y'); ?></font></font></div>
                                        </div>
                                        <div class="post-type">
                                            <i class="fa fa-video-camera"></i>
                                        </div>
                                    </div>
                                    <div class="post-body">
                                        <h2><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">You Currently Don't Have Anyone Following</font></font></h2>
                                        <p><img src="assets/images/favicon.png" class="img-responsive" alt="">
                                        	<font style="vertical-align: inherit;">
                                            	Playing the game smash and pass is a very good and easy way to find more members you would like to follow.  Try it today it's easy and fun.
                                            </font>
                                                </p>
                                        <div class="post-info">
                                            <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Recommendation: </font></font></span>
                                            <a href="/play" class="btn btn-inverse"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">More</font></font></a>
                                        </div>
                                    </div>
                                </article>
                                
						<?php endif ?>
							</div>
                <!-- ==========================
                    CONTENT - END 
                =========================== -->
                </div>

            </div>
        </section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
	<?php include("footer_loggedin.php"); ?>

   <script src="assets/js/tz/jstz.js"></script>   
   <script src="assets/js/clearbox/clearbox.js"></script>
	<script src="test/Croppie/Croppie-master/Croppie-master/croppie.js"></script>

    <!-- ==========================
    	DropZone 
    =========================== -->
    
    <script src="assets/js/dropzone.js"></script>

   <script src="assets/js/profile.js"></script>
   <script src="assets/js/_profile.js"></script>



</body>
</html>