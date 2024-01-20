<?php


include("classes/restrict_login.php");



?>
<?php


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



$find_user_query = "SELECT * 
    FROM `smashan_smashandpass`.`user_profile_photoblobs` 
    WHERE `profile_photoblob_user_id` = '$user_id'  
    ORDER BY `profile_photoblob_id` DESC ";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	


$find_user_pic = "SELECT * 
	FROM 
			`smashan_smashandpass`.`users`
	 WHERE 
	 		`users`.`user_id` = '$user_id'
		GROUP BY
			`users`.`user_id`
		ORDER BY 
			`users`.`user_id` ASC
";
$result_ofuser_pic = mysqli_query($webgoneGlobal_mysqli, $find_user_pic);
$row_ofuser_pic = mysqli_fetch_assoc($result_ofuser_pic);
$totalRows_ofuser_pic = mysqli_num_rows($result_ofuser_pic);	



$find_recent_sold = "SELECT * 
	FROM 
			`smashan_smashandpass`.`users`
			LEFT JOIN `smashan_smashandpass`.`users_ledger_log` ON
			`users`.`user_id` = `users_ledger_log`.`userledger_log_usr_playerid`
	 WHERE 
	 		`userledger_log_ownerid` = '$user_id'
			AND
			`users`.`user_blob_file_path` IS NOT NULL
			or
	 		`userledger_log_ownerid` = '$user_id'
			AND
			`users`.`user_profile_blob` IS NOT NULL
			
			GROUP BY
			`users`.`user_id`
		ORDER BY 
			`users_ledger_log`.`userledger_log_id` DESC";
$result_recent_sold = mysqli_query($webgoneGlobal_mysqli, $find_recent_sold);
$row_recent_sold = mysqli_fetch_assoc($result_recent_sold);
$totalRows_recent_sold = mysqli_num_rows($result_recent_sold);	


// SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` AND `users`.`user_id` = '$member_id' ORDER BY `usr_thread_id` DESC 
$find_user_threadquery = "SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` = `users`.`user_id` AND `usr_thread_tomember_id` = '$user_id' ORDER BY `usr_thread_id` DESC ";
$result_userthread = mysqli_query($webgoneGlobal_mysqli, $find_user_threadquery);
$row_userthread = mysqli_fetch_assoc($result_userthread);
$totalRows_userthread = mysqli_num_rows($result_userthread);	




	//https://stackoverflow.com/questions/3776682/php-calculate-age
	//date in mm/dd/yyyy format; or it can be in other formats as well
	if(isset($row_user['user_bdayday'], $row_user['user_bdaymonth'], $row_user['user_bdayyear'])){
	$birthDate = $row_user['user_bdayday'].'/'.$row_user['user_bdaymonth'].'/'.$row_user['user_bdayyear'];
	//explode the date to get month, day and year
	$birthDate = explode("/", $birthDate);
	//get age from date or birthdate
	@$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
	? ((date("Y") - $birthDate[2]) - 1)
	: (date("Y") - $birthDate[2]));
	
	}else{
	
	
	$age = 'Not Set';
	
	}






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
    <title>My Profile View</title>

    <base href="/">    
    <!-- ==========================
    	Fonts 
    =========================== -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png"/>

	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- ==========================
    	CSS 
    =========================== -->
    <!-- Plugins css-->
    <link href="assets/css/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        
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
    <link rel="stylesheet" type="text/css" href="assets/css/dropzone.css">
    <link rel="stylesheet" href="assets/css/app.css">

    <link rel="stylesheet" href="test/Croppie/Croppie-master/Croppie-master/croppie.css">
    
    <link rel="stylesheet" href="test/Croppie/Croppie-master/Croppie-master/demo.css">
    
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
    	JUMBOTRON - START 
    =========================== -->
    <div class="container">
    	<div class="jumbotron">
        	<div class="jumbotron-panel">
            	<div class="panel panel-primary collapse-horizontal">
                    <a data-toggle="collapse" class="btn btn-primary collapsed" data-target="#toggle-collapse">Check Your Performance <i class="fa fa-caret-down"></i></a>
                    <div class="jumbotron-brands">
                    	<ul class="brands brands-sm brands-inline brands-circle">
                    		<li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-twitch"></i></a></li>
                            <li><a href="/ledger"><i class="fa fa-steam"></i></a></li>
                        </ul>
                    </div>
                    <div id="toggle-collapse" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table table-bordered table-header">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>IP Address</th>
                                        <th>Map</th>
                                        <th>Players</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="assets/icons/csgo.jpg" alt=""></td>
                                        <td>[EU] CS:GO #1 | pixelized.cz</td>
                                        <td>123.221.45.12:29999</td>
                                        <td>de_dust2</td>
                                        <td>18/18</td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/icons/csgo.jpg" alt=""></td>
                                        <td>[CZ/SK] CS:GO Public | pixelized.cz</td>
                                        <td>45.184.170.200:27851</td>
                                        <td>de_inferno</td>
                                        <td>24/32</td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/icons/lol.png" alt=""></td>
                                        <td>[EU] League of Legends</td>
                                        <td>50.243.180.246:25429</td>
                                        <td>normal</td>
                                        <td>10/30</td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/icons/gta.png" alt=""></td>
                                        <td>[EU] GTA Server</td>
                                        <td>132.24.45.83:27852</td>
                                        <td>classic</td>
                                        <td>22/60</td>
                                    </tr>                               
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
            	<div id="thin_long_block" class="col-sm-4">
					
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
                         
                         
                       		<h3><?php 
										if($row_user['user_nickname']){ 
												echo "<a href='/@/".$row_user['user_nickname']."'>@".$row_user['user_nickname']."</a>"; 
												}else{
											
												echo "<a href='/member/".$row_user['user_id']."'>@".$row_user['user_fname']."</a>"; 
											}
							 ?></h3>
                            
                         <?php } ?>
                        </div> 
                                          
                        <div class="tournament">
                        
                        <div id="profile_pic_block" align="center">
                        <?php if(!$row_user['user_profile_blob']): ?>

                    
                        	<a><img id="profile_bpic" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
                        
                            
                       <?php else: ?>

                        	<a rel="clearbox[gallery=Gallery,,width=600,,height=400]" href="<?php echo $row_user['user_blob_file_path']; ?>">
                            <img id="profile_bpic" src="<?php echo 'data:image/png;base64,'.base64_encode($row_user['user_profile_blob']); ?>" class="img-responsive"  alt="">
                            </a>


                       
                       <?php endif; ?>
                        
                        </div>
                        
                        <div class="row m-b-10" align="center">
                        	<a id="top_btn_photoupload" class="btn btn-primary btn-sm"><i class="fa fa-camera"></i> Upload Photo</a>
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


                    
                    <!-- SIDEBAR BOX OWNED BY - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">
                                <?php if($totalRows_userown != 0){ ?>

                    	<h3>Currently Owned By <a target="_parent" href="/member/<?php if($row_userown['user_nickname']){ echo $row_userown['user_nickname']; }else{ echo $row_userown['user_id']; } ?>" class="btn btn-primary pull-right btn-sm">View Owner</a></h3>
                        
								<?php }else{ ?>
                                            <h3>No Owner <a href="#" class="btn btn-primary pull-right btn-block btn-sm block-me-from-being-bought">Block From Being Bought </a></h3>                                               	
                                <?php } ?>   
                                                  
                            <table class="table match-wrapper">
                                <tbody>

                                <?php if($totalRows_userown != 0){ ?>
                                    <tr>
                                        <td class="game">
                                        <?php if($row_userown['user_nickname'] && $row_userown['user_profile_blob']){ ?>
                                        <a href="/member/<?php if($row_userown['user_nickname']){ echo $row_userown['user_nickname']; }else{ echo $row_userown['user_id']; } ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_userown['user_profile_blob']); ?>" class="img-circle" alt="image">
                                        </a>
                                        <a href="/member/<?php if($row_userown['user_nickname']){ echo $row_userown['user_nickname']; }else{ echo $row_userown['user_id']; } ?>">

                                            <span>@<? echo $row_userown['user_nickname']; ?></span>
										</a> 
                                        <?php }else{ ?>

                                        <a href="/member/<?php echo $row_userown['user_id']; ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_userown['user_profile_blob']); ?>" class="img-circle" alt="image">
                                        </a>
                                        <a href="/member/<?php echo $row_userown['user_id']; ?>">

                                            <span><? echo $row_userown['user_fname']; ?></span>
										</a>                                       
                                        
                                        
                                        <?php } ?>
                                                                              
                                        </td>
                                        <td class="game-date">
                                            <span>$<? echo $row_userown['user_networth_ply']; ?></span>
                                        </td>
                                    </tr>
<?php }else{ ?>
                                    
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/usa.png" alt=""><a href="/buyassets">Buy Assets</a></td>
                                        <td class="team-score">Play Smash And Pass</td>
                                    </tr>
<?php } ?>                     
                                </tbody>
                            </table>

                        
                        
                    </div>
                    <!-- SIDEBAR BOX TOP ASSETS - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">
                    	<h3>Top Assets <a target="_parent" href="myassets" class="btn btn-primary pull-right btn-sm">All Assets</a></h3>
                        
                       
                            <table class="table match-wrapper">
                                <tbody>
                                <?php if($totalRows_plyrassets != 0){ ?>
<?php do{ ?>
                                    <tr>
                                        <td class="game">
                                        <a href="/member/<?php if($row_plyrassets['user_nickname']){ echo $row_plyrassets['user_nickname']; }else{ echo $row_plyrassets['user_id'];} ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_plyrassets['user_profile_blob']); ?>" class="img-circle" alt="">
                                            <span>@<? echo $row_plyrassets['user_nickname']; ?></span>
                                        </a>
                                       
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
                        <h3>Recently Sold <a name="/topassets" class="btn btn-primary pull-right btn-sm">See All</a></h3>
                        
                        <a name="/topassets">
                            <table class="table match-wrapper">
                                <tbody>

<?php if($totalRows_recent_sold !== 0): do{ ?>


                              
                                    <tr>
                                        <td class="game">
                                        <?php if($row_recent_sold['user_profile_blob']){ ?>
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_ofuser_pic['user_profile_blob']); ?>" class="img-circle" alt="">
                                        <?php } ?>
                                        </td>
                                        <td class="game">
                                          <?php $userledger_log_created_at = $row_recent_sold['userledger_log_created_at']; ?>

                                        	<span><?php echo date( "M  Y D", strtotime($row_recent_sold['userledger_log_created_at']) ); ?></span>
                                            
                                        </td>
                                    </tr>

  <?php } while ($row_recent_sold = mysqli_fetch_array($result_recent_sold)); else: ?>
                                    <tr>
                                        <td class="game">
                                        No Sales
                                        </td>
                                        <td class="game">
                                          At This Time
                                            
                                        </td>
                                    </tr>
  
  
  <?php endif; ?>

                                </tbody>
                            </table>
                        </a>
                        
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div id="main_long_block" class="col-sm-8">
                	

                    
                    <div class="box colored config">
                    	<p>Here you can gain more buying power. <a href="" class="btn btn-simple">Buy Gold</a></p>
                    </div>




                    
                    




                    <div class="blank-panel">

                        <div class="panel-heading">
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a role="tab" data-toggle="tab" name="#tab-1">News Feed</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-2">My Photos</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-3">About Me</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-4">Achievements</a></li>

                                    <li class="last-nav-match"><a id="dropzone-top-btn" role="tab" data-toggle="tab" name="#dropzone-tab">Upload Photo &nbsp;&nbsp;  <i class="fa fa-photo" aria-hidden="true"></i></a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="panel-body clearfix">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">


                                        <div class="box">
                                
                                            <!-- TEAM MEMBER - START -->   
                                            <div class="team-member single">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-3">
                                                        <img src="assets/images/member-01.jpg" class="img-responsive img-circle center-block" alt="">
                                                        <ul class="brands brands-tn brands-circle brands-colored brands-inline text-center">
                                                            <li><a target="_blank" class="brands-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                            <li><a target="_blank" class="brands-twitter"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                                            <li><a target="_blank" class="brands-google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-8 col-md-9">
                                                        <h2>Name<small><?php echo $row_user['user_fname']; ?> "@<?php echo $row_user['user_nickname']; ?>" <?php echo $row_user['user_lname']; ?></small></h2>
                                                        <ul class="list-unstyled">
                                                            <?php $user_last_loggedin = $row_user['user_last_loggedin']; ?>
                                                            <li><strong>Last Online:</strong><?php echo date( "M Y D", strtotime("$user_last_loggedin") ); ?></li>                                        
                                                            <li><strong>Gender:</strong><?php echo $row_user['user_sex']; ?></li>
                                                            <li><strong>Age:</strong><?php echo $age; ?></li>
                                                            <li><strong>Relationship Status:</strong><?php if($row_user['show_user_relstatus'] == 1){  echo $row_user['user_relstatus']; }else{ echo 'Private'; } ?></li>
                                                            <li><strong>Ethnicity:</strong><?php if($row_user['show_ethnicity'] == 1){ echo $row_user['user_ethnicity']; }else{ echo 'Private'; } ?></li>
                                                            <li><strong>Orientation:</strong><?php if($row_user['show_orientation'] == 1){  echo $row_user['user_orientation']; }else{ echo 'Private'; } ?></li>
                    
                                                            <li><strong>Religion:</strong><?php if($row_user['user_showreligion'] == 1){ echo $row_user['user_religion']; }else{ echo 'Private'; } ?></li>
                                                            <li><strong>Country:</strong><?php if($row_user['show_mylocation'] == 1){ echo $row_user['user_country']; }else{ echo 'Private'; } ?></li>
                                                            <li><strong>Postal Code:</strong><?php if($row_user['show_mylocation'] == 1){ echo $row_user['user_zipcode']; }else{ echo 'Private'; } ?></li>
                                                            <?php $user_created_at = $row_user['user_created_at']; ?>
                                                            <li><strong>Member Since:</strong><?php echo date( "M Y D", strtotime("$user_created_at") ); ?></li>
                                                        </ul>
                                                        <p>&nbsp;</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- TEAM MEMBER - END --> 
                                        </div>
                                         <!-- FRIENDS BOX - START --> 
                                         <div>
                                             <div class="row">
                                                <div class="col-sm-12 m-t-10">
                                                
                                                	<h2><a href="/friends" target="_parent">Friends</a></h2>
                                                    



									 
                                    
                                    
                                    <!-- GALLERY POST - START -->
                        <article class="post gallery-post box m-b-15">
                            <div class="row gallery-page p-10  m-b-15">
                                <div class="col-sm-12">
                                    <h2>Latest Friends</h2>
                                </div>

						<?php if($totalRows_friends != 0): do{
                            if($row_friends['user_nickname']){ $USERNAME = $row_friends['user_nickname']; }else{  $USERNAME = $row_friends['user_fname']; }
                            if($row_friends['user_blob_file_path']){$FRIENDPHOTO = $row_friends['user_blob_file_path']; }else if($row_friends['user_profile_blob']){ $FRIENDPHOTO =  'data:image/png;base64,'.base64_encode($row_friends['user_profile_blob']); }else{  $FRIENDPHOTO = 'assets/images/blank_profileimg.png'; }
                        ?>

                               	<div class="col-md-4 col-xs-6">
                                    	<a href="<?php echo $FRIENDPHOTO; ?>">
                                        	<img src="<?php echo $FRIENDPHOTO; ?>" class="img-responsive center-block img-circle" alt="">
                                            </a>
                                 </div>	
                                 <?php } while ($row_friends = mysqli_fetch_array($result_friends)); else: ?>
									                                                
                            </div>
                            <a href="/friends" class="btn btn-inverse">View More</a>
                        </article>
                        <!-- GALLERY POST - END -->

                       		
											<p>No Friends At This Time</p>
          <?php endif; ?>                                      
                                                </div>
                                             </div>
                                         <!-- FRIENDS BOX - END --> 
                                		</div>

                                        <!-- COMMENT FORM - END --> 
                                        <div id="respond" class="box comment-respond">
                                            <form method="post" id="commentform" class="comment-form">
                                                <div class="form-group comment-form-comment">
                                                    <label for="comment">Say Something Good...<span class="required">*</span></label>
                                                    <textarea id="profile_comment" class="form-control" name="profile_comment" placeholder='Say Something Good...' aria-required="true"></textarea>
                                                </div>												
                                                <button id="submit_pubcomment" class="btn btn-primary" type="button">Submit</button>					
                                            </form>
                                        </div>
                                        <!-- COMMENT FORM - END -->  
                                

                                        <div class="clearfix"></div>
                                        
                                        

                    			<div id="big_thread_box">

                                        
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

										<?php do{ ?>
                                            <div id="thread_box" class="box">
                    
                                                <div class="forum-post-wrapper">
        
                                                                <div class="row">
                                                                <hr />
                                                        <div class="col-xs-3 col-sm-3">
                                                            <div class="author-detail">
        
                                                                <h5><a href="#"><?php if(!$row_userthread['user_nickname']){ echo $row_userthread['user_fname'] .' '.$row_userthread['user_lname']; }else{ echo '@'.$row_userthread['user_nickname']; } ?></a></h5>
                                            
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
                                        <?php endif; ?>
                                        

                    			</div>  
                                        
                                        
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">



                                    <div class="box">
                            
    
                        
                                            <div class="profile-gallery">
                                                <h2>Profile Gallery</h2>
                                                <div class="gallery-ajax">
                                                    <div class="row">
                                                        
                        
                                                        <?php do { ?>
                                                        
                                                        <div class="col-md-4 col-xs-6">
                                                            <div class="ibox-title">
                                                        
                                                                <ul class="ibox-tools">
                                                                    <li class="dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </li>
                                                                    <ul class="dropdown-menu dropdown-user">
                                                                        <li>
                                                                            <span id="add_photo_caption" class="<?php echo $row_ofuser['profile_photoblob_id']; ?>">Add Caption</span>
                                                                        </li>                                            
                                                                        <li>
                                                                            <span id="del_photo" class="<?php echo $row_ofuser['profile_photoblob_id']; ?>">Delete Photo</span>
                                                                        </li>                                            
                                                                    </ul>
                                                                </ul>
                                                                
                                                                
                                                            </div>
                                                            <?php // 'data:image/jpeg;base64,'.base64_encode($row_ofuser['userblob_image'] ); ?>
                                                            <a rel="<?php echo $row_ofuser['profile_photoblob_id']; ?>" href="/picaction/<?php echo $row_ofuser['profile_photoblob_id']; ?>/" title="<?php echo $row_ofuser['profile_photoblob_created_at']; ?>" class="gallery-photos"><img src="<?php echo $row_ofuser['profile_photoblob_filepath']; ?>" class="img-responsive" alt=""></a>
                                                        </div>
                        
                                                            <?php } while ($row_ofuser = mysqli_fetch_array($result_ofuser)); 
                                                            $row_ofuser = mysqli_num_rows($result_ofuser);
                                                            if($rows > 0) {
                                                                mysqli_data_seek($result_ofuser, 0);
                                                                $row_ofuser  = mysqli_fetch_assoc($result_ofuser);
                                                            }

                                                            ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
    
                                    
                            
                                    </div>


                                        <div class="clearfix"></div>

                                </div>

                                <div id="tab-3" class="tab-pane">


                                    <div class="box">
                
                                        <strong>View About Me</strong>
                                                    
                                    <div id="edit_profile_aboutme" class="pull-right">
                                        <button id="open_aboutme_modal" class="btn btn-primary pull-right btn-sm" type="button"><i class="fa fa-pencil"></i> Edit About Me</button>
                                    </div>
                
                
                
                                    <div class="row">
                                        <div class="col-sm">
                
                                                <div id="profile_aboutme">
                                                <?php echo $row_user['user_aboutme']; ?>
                                                </div>
                                    
                                                                    
                                        </div>
                                    </div>

                                    
                
                                   
                                    </div>
                                    
                                    <div class="box">
                                        <div class="row">
                                            <div class="col-sm-12">
                    
                                                    <div id="profile_tagme">
                                                         <strong>Enter/Edit - Tag/Key Words <small><u><em>Use enter key or space bar to sperate keywords</em></u></small></strong>

                                                         <div class="tags-default">
                                                            <input class="form-control" type="text" value="<?php echo $row_user['user_tagskeyword']; ?>" data-role="tagsinput" placeholder="type key words"/>
                                                        </div>
                                                    </div>
                                        
                                                                        
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-12">
                                            	<button id="save_keywords" class="btn btn-block btn-primary btn-lg" type="button"><i class="fa fa-floppy-o"></i> Save Key Words</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="tab-4" class="tab-pane">
                                    <strong>Lastest Achievements</strong>

                                    <div class="box">
                                    
                                            <p>Achievements </p>
                                    
                                            
                                    
                                    
                                        
                                    
                                    </div>

                                </div>
                            

                                <div id="dropzone-tab" class="tab-pane">
                                
                                
                                
                                
								<!-- Drop Zone -->                                
                                <div>
                                
                                
                                <div class="dropzone dropzone-previews" id="my-dropzone">
                                   <div class="fallback">
                                       <input id="files" multiple="true" name="files" type="file">
                                    </div>
                                </div>

                                </div>
                                
								<!-- End Drop Zone -->
                                
                                
								</div>
                            
                            </div>

                        </div>

                    </div>



                    
                    
                    
                    
                    <div class="box">
                        

                                
                        
                	</div>


                    <div class="row">
                    	<div class="col-md-6">
                            <div class="box sidebar-box widget-wrapper">
                                <h3>Last comments</h3>
                                <ul class="nav nav-sidebar">
                                    <li><a href="#">Lorem ipsum dolor sit<span>3/2/2015</span></a></li>
                                    <li><a href="#">consectetur adipiscing<span>3/2/2015</span></a></li>
                                    <li><a href="#">Nam auctor dictum<span>3/2/2015</span></a></li>
                                </ul>
                            </div>
                    	</div>
                        
                        <div class="col-md-6">
                            <div class="box sidebar-box widget-wrapper">
                                <h3>Last forum posts</h3>
                                <ul class="nav nav-sidebar">
                                    <li><a href="#">Lorem ipsum dolor sit<span>3/2/2015</span></a></li>
                                    <li><a href="#">consectetur adipiscing<span>3/2/2015</span></a></li>
                                    <li><a href="#">Nam auctor dictum<span>3/2/2015</span></a></li>
                                </ul>
                            </div>
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
   <script src="assets/js/tz/jstz.js"></script>   
   <script src="assets/js/clearbox/clearbox.js"></script>
	<script src="test/Croppie/Croppie-master/Croppie-master/croppie.js"></script>
	<script src="assets/js/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
   
   <script src="assets/js/dropzone.js"></script>
    
   <script src="assets/js/profile.js"></script>
   <script src="assets/js/_profile.js"></script>

</body>
</html>
<?php 
mysqli_free_result($user_sql);
mysqli_free_result($query_userown);
mysqli_free_result($plyrassets);
mysqli_free_result($result_ofuser);
mysqli_free_result($result_ofuser_pic);
mysqli_free_result($result_recent_sold);
mysqli_free_result($result_userthread);

include("_end.mysql.php");
 ?>
