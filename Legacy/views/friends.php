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


$find_pending_friends_sql = "
			SELECT 
			`users`.`user_id` AS theusr_id ,
			`users`.* ,
			`uf`.* ,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned
			FROM 
				`smashan_smashandpass`.`user_friends` AS `uf`
				
				LEFT JOIN `smashan_smashandpass`.`users`  ON
				`uf`.`friend_userid` = `users`.`user_id`
				
			WHERE 
				`uf`.`friend_memberid` = '$user_id'
				AND
				`uf`.`friend_okuserid` IS NULL
				
			GROUP BY
				`users`.`user_id`
			ORDER BY
				`users`.`user_id` ASC
";


$find_pending_friends_sqll = "
SELECT 
`aFriend`.`friend_id` AS `afriend_id`,
`aFriend`.`friend_userid`  AS `afriend_userid`,
`aFriend`.`friend_memberid` AS `my_member_id`,
`aFriend`.`friend_memberid` AS `afriend_memberid`,
`aFriend`.`friend_okuserid` AS `afriend_okuserid`,
`myFriend`.`friend_id` AS `myfriend_id`,
`myFriend`.`friend_userid` AS `myfriend_userid`,
`myFriend`.`friend_memberid` AS `myfriend_memberid`,
`myFriend`.`friend_okuserid` AS `myfriend_okuserid`,
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
`u`.`user_properties_ply`,
`u`.`user_assets_ply`,
`u`.`user_wishers_ply`,
`u`.`user_growthrate_ply`,
`u`.`user_view_zipcode`
FROM 
	`smashan_smashandpass`.`user_friends` AS `aFriend`
LEFT JOIN `smashan_smashandpass`.`user_friends` AS `myFriend` ON
    	   `myFriend`.`friend_memberid` = `aFriend`.`friend_userid`
LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `aFriend`.`friend_userid`
		   WHERE
		   `aFriend`.`friend_memberid` = '$user_id'
		   AND 
		    (`aFriend`.`friend_memberid`  != '$user_id' OR `myFriend`.`friend_memberid` IS NULL)
		  
		   

		   
		   GROUP BY
				`aFriend`.`friend_id`
			ORDER BY
				`aFriend`.`friend_id` ASC
				
";
$result_pending_friends = mysqli_query($webgoneGlobal_mysqli, $find_pending_friends_sqll);
$row_pending_friends = mysqli_fetch_assoc($result_pending_friends);
$totalRows_pending_friends = mysqli_num_rows($result_pending_friends);	




$find_friends_sql = "
SELECT 
`aFriend`.`friend_id` AS `afriend_id`,
`aFriend`.`friend_userid`  AS `afriend_userid`,
`aFriend`.`friend_userid` AS `my_member_id`,
`aFriend`.`friend_memberid` AS `afriend_memberid`,
`aFriend`.`friend_okuserid` AS `afriend_okuserid`,
`myFriend`.`friend_id` AS `myfriend_id`,
`myFriend`.`friend_userid` AS `myfriend_userid`,
`myFriend`.`friend_memberid` AS `myfriend_memberid`,
`myFriend`.`friend_okuserid` AS `myfriend_okuserid`,
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
`u`.`user_properties_ply`,
`u`.`user_assets_ply`,
`u`.`user_wishers_ply`,
`u`.`user_growthrate_ply`,
`u`.`user_view_zipcode`
FROM 
	`smashan_smashandpass`.`user_friends` AS `aFriend`
INNER JOIN `smashan_smashandpass`.`user_friends` AS `myFriend` ON
    	   `myFriend`.`friend_memberid` = `aFriend`.`friend_userid`
LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `aFriend`.`friend_userid`
		   WHERE
		   `aFriend`.`friend_memberid` = '$user_id'
		  
		    
		   
		   GROUP BY
				`aFriend`.`friend_id`
			ORDER BY
				`aFriend`.`friend_id` ASC
";

$result_friends = mysqli_query($webgoneGlobal_mysqli, $find_friends_sql);
$row_friends = mysqli_fetch_assoc($result_friends);
$totalRows_friends = mysqli_num_rows($result_friends);	


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
    <title>Friends</title>
    
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
      <link href="assets/css/bootstrap-social.css" rel="stylesheet">
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
    	JUMBOTRON - START 
    =========================== -->
    <div class="container">
    	<div class="jumbotron">
        	<div class="jumbotron-panel">
            	<div class="panel panel-primary collapse-horizontal">
                    <a data-toggle="collapse" class="btn btn-primary collapsed" data-target="#toggle-collapse">Pending Friends <i class="fa fa-caret-down"></i></a>
                    <div class="jumbotron-brands">
                    	<ul class="brands brands-sm brands-inline brands-circle">
                            <li><a href="#"><i class="fa fa-steam"></i></a></li>
                        </ul>
                    </div>
                    <div id="toggle-collapse" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table table-bordered table-header">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Networth</th>
                                        <th>Assets</th>
                                        <th>Since</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                 					<?php if($totalRows_pending_friends != 0): do{
										if($row_pending_friends['user_nickname']){ $USERNAME = $row_pending_friends['user_nickname']; }else{  $USERNAME = $row_pending_friends['user_fname']; }
										if($row_pending_friends['user_profile_blob']){ $FRIENDPHOTO =  'data:image/png;base64,'.base64_encode($row_pending_friends['user_profile_blob']); }else{  $FRIENDPHOTO = $row_pending_friends['user_blob_file_path']; }
									?>
                                    <tr id="<?php echo $row_pending_friends['user_id']; ?>">
                                        <td><img src="<?php echo $FRIENDPHOTO; ?>" alt=""></td>
                                        <td><?php echo $USERNAME;  ?></td>
                                        <td><?php echo $row_pending_friends['user_networth_ply']; ?></td>
                                        <td><?php echo $row_pending_friends['CountPlyrsOwned']; ?></td>
                                        <td><?php echo $row_pending_friends['friend_created_at']; ?></td>
                                        <td><a href="<?php echo $row_pending_friends['user_id']; ?>">Remind</a> <a href="<?php echo $row_pending_friends['user_id']; ?>">Cancel</a></td>
                                    </tr>
                                    <?php } while ($row_pending_friends = mysqli_fetch_array($result_pending_friends)); else: ?>

                                    <tr>
                                        <td><img src="assets/images/blank_profileimg.png" alt=""></td>
                                        <td>-</td>
                                        <td>No Friends At This time</td>
                                        <td>N/A</td>
                                        <td>-</td>
                                         <td>-</td>
                                    </tr>
                                    
                                    <?php endif; ?>
                                                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        	
        </div>
    </div>
    <!-- ==========================
    	JUMBOTRON - END 
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
                    	<!--h3>Profile <a href="/uphoto" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a></h3 --> 
                        <div id="read_nicknameurl">
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

                    
                        	<a href="/profile"><img id="profile_bpic" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
                        
                            
                       <?php else: ?>

                        <a href="/profile">
                                <img id="profile_bpic" src="<?php echo $row_user['user_blob_file_path']; ?>" class="img-responsive"  alt="">
                            </a>


                       
                       <?php endif; ?>
                        
                        </div>
                        
                        
                        
                            
						<div class="">
								<div class="team-member">
                                    <ul class="list-unstyled">
                                        <li><strong>NetWorth</strong>$  <?php echo $CountMyOwnNetworth; ?></li>
                                        <li><strong>Cash:</strong>$ <?php echo $row_user['MyLiquidCash']; ?></li>
                                        <li><strong>Asset(s):</strong>$  <?php if($row_user['SumPlyrassets']){ echo  $row_user['SumPlyrassets']; }else{ echo '0'; } ?></li>
                                        <li><strong>Owns:</strong>#  <?php echo  $row_user['CountPlyrsOwned']; ?></li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li><strong>Growth Rate</strong><?php echo $row_userown['user_growthrate_ply']; ?>% Up<i class="fa fa-up"></i></li>
                                    </ul>
                                    <p><?php // echo $query_userown_sql; ?></p>

                                </div>                            
						</div>
                            
                            <button class="btn btn-block btn-lg btn-warning">Earn More Gold</button>
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->

                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-8">
                    
                	<div class="box">

                        
                     	<div class="team-members-wrapper">


						<?php if($totalRows_friends != 0): do{
                            if($row_friends['user_nickname']){ $USERNAME = $row_friends['user_nickname']; }else{  $USERNAME = $row_friends['user_fname']; }
                            if($row_friends['user_blob_file_path']){$FRIENDPHOTO = $row_friends['user_blob_file_path']; }else if($row_friends['user_profile_blob']){ $FRIENDPHOTO =  'data:image/png;base64,'.base64_encode($row_friends['user_profile_blob']); }else{  $FRIENDPHOTO = 'assets/images/blank_profileimg.png'; }
                        ?>
                        
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><a href="member/<?php echo $row_friends['afriend_id']; ?>"><img src="<?php echo $FRIENDPHOTO; ?>" class="img-responsive center-block img-circle" alt=""></a></div>
                                    <div class="col-xs-9">
                                        
                                        <?php if($row_friends['user_nickname']){ ?>
                                        <h2><a href="member/<?php echo $row_friends['user_id']; ?>"><small>@</small><?php echo $row_friends['user_nickname']; ?></a></h2>
                                        <?php }else{ ?>
                                        <h2><a href="member/<?php echo $row_friends['user_id']; ?>"><small><?php echo $row_friends['user_fname']; ?></small></a></h2>
                                        <?php } ?>
                                        
                                        <ul class="list-unstyled">
	                                        <li><strong>Last Seen:</strong><?php echo $row_friends['user_last_loggedin']; ?></li>
                                            <li><strong>Member since:</strong><?php echo $row_friends['user_created_at']; ?></li>
                                            <li><strong>Networth:</strong><a href="gaming-team.html"><?php echo $row_friends['user_networth_ply']; ?></a></li>
                                            <li><strong>Assets:</strong><?php if(!$row_friends['user_properties_ply']){ echo '0'; }else{ echo $row_friends['user_properties_ply']; } ?></li>
                                            <li><strong>Wishers:</strong><?php  if(!$row_friends['user_wishers_ply']){ echo '0'; }else{ echo $row_friends['user_wishers_ply']; } ?></li>
                                            <li><strong>Followers:</strong><?php  if(!$row_friends['user_wishers_ply']){ echo '0'; }else{ echo $row_friends['user_wishers_ply']; } ?></li>
                                        </ul>
                                        <?php if(!$row_friends['user_aboutme']){ echo $row_friends['user_aboutme']; } ?>
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM MEMBER - END --> 
                            
                        
                       		<?php } while ($row_friends = mysqli_fetch_array($result_friends)); else: ?>
                            
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><img src="assets/images/member-02.jpg" class="img-responsive center-block img-circle" alt=""></div>
                                    <div class="col-xs-9">
                                        <h2>No Friends<small>At This Time</small></h2>
                                        <ul class="list-unstyled">
                                            <li><strong>Member since:</strong>21.08.2014</li>
                                            <li><strong>Team:</strong><a href="gaming-team.html">Ninjas in Pyjamas</a></li>
                                            <li><strong>Position:</strong>team leader</li>
                                            <li><strong>Email:</strong>johndoe@pixelized.cz</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam auctor dictum nibh, ac gravida orci porttitor et. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam posuere magna a dapibus luctus.</p>
                                        <ul class="brands brands-tn brands-circle brands-colored brands-inline">
                                           <li><a href="https://www.facebook.com/pixelized.cz" target="_blank" class="brands-facebook"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="https://twitter.com/Pixelizedcz" target="_blank" class="brands-twitter"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="https://plus.google.com/+PixelizedCz/" target="_blank" class="brands-google-plus"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM MEMBER - END -->
                           
						   <?php endif; ?>
                           
                           
                   

                    	</div>
                	</div>
                </div>
                <!-- CONTENT BODY - END -->
                
            </div>
        </section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->

	<?php include("footer_loggedin.php"); ?>
</body>
</html>
<?php require('_end.mysql.php'); ?>
