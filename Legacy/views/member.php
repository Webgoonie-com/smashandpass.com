<?php


include("classes/restrict_login.php");

$member_id  = $url->segment(2);

//
$found_user_owner_id = '-1';

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

if(!$found_user_id){ exit(); }


$query_userown_sql = "SELECT `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply`, `users`.`user_id`, SUM(`users`.`user_networth_ply`) as CountMyOwnNetworth, count(`users`.`user_id`) as CountMyOwn FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$found_user_owner_id'";
$query_userown = mysqli_query($webgoneGlobal_mysqli, $query_userown_sql);
$row_userown = mysqli_fetch_assoc($query_userown);
$totalRows_userown = mysqli_num_rows($query_userown);

// Pull Up Your Owner And Count Stats
$query_userown_sql = "SELECT 
`users`.`user_id` AS theusr_id ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as CountMyOwnNetworth, 
			SUM(`users`.`user_networth_ply`) as CountMyOwnNetworth, 
			count(`users`.`user_id`) as CountMyOwn,
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM `smashan_smashandpass`.`users` 
WHERE 
	`user_id` = '$found_user_owner_id'
	
	GROUP BY `user_id`
";
$query_userown = mysqli_query($webgoneGlobal_mysqli, $query_userown_sql);
$row_userown = mysqli_fetch_assoc($query_userown);
$totalRows_userown = mysqli_num_rows($query_userown);

$CountMyOwnershipValue = $row_userown['CountMyOwn'];


// Defining MyLiquidWorth
$MyOwnerLiquidCash = $row_userown['MyLiquidCash'];
$SumOwnerPlyrassets = $row_userown['SumPlyrassets'];
$CountMyOwnerNetworth = $MyOwnerLiquidCash + $SumOwnerPlyrassets;


// Defining MyLiquidWorth
$MyLiquidCash = $row_found_user['MyLiquidCash'];
$SumPlyrassets = $row_found_user['SumPlyrassets'];
$CountMyOwnNetworth = $MyLiquidCash + $SumPlyrassets;




$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];


	
  // NET WORTH is Liquid + value of Property Assets
  $CountMyOwnershipValue = $row_userown['CountMyOwn'];





// Defining MyLiquidWorth
$MyLiquidCash = $row_userown['MyLiquidCash'];
$SumPlyrassets = $row_userown['SumPlyrassets'];
$CountMyOwnerNetworth = $MyLiquidCash + $SumPlyrassets;


// Simply to count only
$query_plyrassetscount_sql = "SELECT `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply`, `users`.`user_id`, SUM(`users`.`user_networth_ply` + `users`.`user_liquidcash_ply`) as CountMyOwnNetworth, count(`users`.`user_id`) as CountMyPlyrassets FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '$found_user_id'";
$plyrassets_counts = mysqli_query($webgoneGlobal_mysqli, $query_plyrassetscount_sql);
$row_plyrassets_counts = mysqli_fetch_assoc($plyrassets_counts);
$totalRows_plyrassets_counts = mysqli_num_rows($plyrassets_counts);


//Runs the acutal query
$query_plyrassets_sql = "SELECT `users`.`user_id`, `users`.`user_owner_id`, `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply` FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '$found_user_id'";
$plyrassets = mysqli_query($webgoneGlobal_mysqli, $query_plyrassets_sql);
$row_plyrassets = mysqli_fetch_assoc($plyrassets);
$totalRows_plyrassets = mysqli_num_rows($plyrassets);


$find_user_member = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$member_id' ORDER BY `userblob_id` ASC LIMIT 1";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_member);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	


$find_user_pic = "SELECT * FROM `smashan_smashandpass`.`user_profile_photoblobs` WHERE `profile_photoblob_user_id` = '$member_id' ORDER BY `profile_photoblob_id` ASC";
$result_ofuser_pic = mysqli_query($webgoneGlobal_mysqli, $find_user_pic);
$row_ofuser_pic = mysqli_fetch_assoc($result_ofuser_pic);
$totalRows_ofuser_pic = mysqli_num_rows($result_ofuser_pic);	

$find_user_pic2 = "SELECT * FROM `smashan_smashandpass`.`user_profile_photoblobs` WHERE `profile_photoblob_user_id` = '$member_id' ORDER BY `profile_photoblob_id` ASC LIMIT 6";
$result_ofuser_pic2 = mysqli_query($webgoneGlobal_mysqli, $find_user_pic2);
$row_ofuser_pic2 = mysqli_fetch_assoc($result_ofuser_pic2);
$totalRows_ofuser_pic2 = mysqli_num_rows($result_ofuser_pic2);	

// SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` AND `users`.`user_id` = '$member_id' ORDER BY `usr_thread_id` DESC 
$find_user_threadquery = "SELECT * FROM `smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`users` WHERE `user_threads`.`usr_thread_user_id` = `users`.`user_id` AND `usr_thread_tomember_id` = '$member_id' ORDER BY `usr_thread_id` DESC ";
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
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[2]) - 1)
			: (date("Y") - $birthDate[2]));
		
		}else{
		
		
		$age = 'Private';
		
		}




$user_networth_ply = $row_found_user['user_networth_ply'];



$find_friends_sql = "
			SELECT 
			`users`.`user_id` AS theusr_id ,
			`users`.* ,
			`user_friends`.* ,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned
			FROM 
				`smashan_smashandpass`.`user_friends` 
				LEFT JOIN `smashan_smashandpass`.`users`  ON
				`user_friends`.`friend_userid` = `users`.`user_id`
			WHERE 
				`user_friends`.`friend_memberid` = '$found_user_id'
			GROUP BY
				`users`.`user_id`
			ORDER BY
				`users`.`user_id` ASC
";
$result_friends = mysqli_query($webgoneGlobal_mysqli, $find_friends_sql);
$row_friends = mysqli_fetch_assoc($result_friends);
$totalRows_friends = mysqli_num_rows($result_friends);	


$lastest_member_sold_sql = "
	SELECT 
`users_ledger_log`.* ,
`users`.`user_id` AS `theusr_id` ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_blob_file_path`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as `CountMyOwnNetworth`, 
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$found_user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM  `smashan_smashandpass`.`users_ledger_log`
LEFT JOIN `smashan_smashandpass`.`users` ON
`users_ledger_log`.`userledger_user_id` = `users`.`user_id`
WHERE 
	`user_profile_blob` IS NOT NULL
	AND
		`users_ledger_log`.`userledger_log_ownerid` = '$found_user_id'
				
	GROUP BY 
		`users`.`user_id`
	ORDER BY RAND()
	LIMIT 15
";
$query_lastest_member_sold = mysqli_query($webgoneGlobal_mysqli, $lastest_member_sold_sql);
$row_lastest_member_sold = mysqli_fetch_assoc($query_lastest_member_sold);
$totalRows_lastest_member_sold = mysqli_num_rows($query_lastest_member_sold);



$lastest_member_transactions_sql = "
	SELECT 
`users_ledger_log`.* ,
`users`.`user_id` AS `theusr_id` ,
`users`.* ,
`users`.`user_nickname`,
`users`.`user_blob_file_path`,
`users`.`user_profile_blob`,
`users`.`user_networth_ply`, 
`users`.`user_networth_ply` as `CountMyOwnNetworth`, 
			(SELECT `user_owner_id` FROM  `smashan_smashandpass`.`users` WHERE  `users`.`user_id` = '$found_user_id') AS tuser_owner_id,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
FROM  `smashan_smashandpass`.`users_ledger_log`
LEFT JOIN `smashan_smashandpass`.`users` ON
`users_ledger_log`.`userledger_user_id` = `users`.`user_id`
WHERE 
	`user_profile_blob` IS NOT NULL
	AND
		`users_ledger_log`.`userledger_log_usr_playerid` = '$found_user_id'
				
	GROUP BY 
		`users`.`user_id`
	ORDER BY RAND()
	LIMIT 15
";
$query_lastest_member_transactions = mysqli_query($webgoneGlobal_mysqli, $lastest_member_transactions_sql);
$row_lastest_member_transactions = mysqli_fetch_assoc($query_lastest_member_transactions);
$totalRows_lastest_member_transactions = mysqli_num_rows($query_lastest_member_transactions);

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
    <title>Member View</title>

    <base href="/">

    <!-- ==========================
    	Favicons 
    =========================== -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png"/>

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


   <?php include("views/subfolder/_buy.member_modals.php"); ?>
    
    
    <!-- ==========================
    	JUMBOTRON - START 
    =========================== -->
    <!-- div class="container">
    	<div class="jumbotron">
        	<div class="jumbotron-panel">
            	<div class="panel panel-primary collapse-horizontal">
                    <a data-toggle="collapse" class="btn btn-primary collapsed" data-target="#toggle-collapse">Check our Servers <i class="fa fa-caret-down"></i></a>
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
    </div -->
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
					<input id="member_id" type="hidden" value="<?php echo $row_found_user['user_id']; ?>">
                    
                    

                    
                    <!-- SIDEBAR BOX OWNED BY - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">

                                <?php if($row_userown['CountMyOwn'] != 0){ ?>
											<h3>Currently Owned  By <a href="member/<?php if(!$row_userown['user_nickname']){ echo $row_userown['user_id']; }else{ echo $row_userown['user_nickname']; } ?>" class="btn btn-primary btn-block pull-right btn-sm">View Owner</a></h3>

								<?php }else{ ?>
                                            <h3>No Owner <a href="#" class="btn btn-primary pull-right btn-block btn-sm">Buy <?php if(!$row_found_user['user_nickname']){ echo $row_found_user['user_fname'].' '.$row_found_user['user_lname']; }else{ echo '@'.$row_found_user['user_nickname']; } ?></a></h3>                                               	
                                <?php } ?>                     
                                <br>
                                <br>

                        
                       
                            <table class="table match-wrapper m-t-10">
                                <tbody>
                                <?php if($row_userown['CountMyOwn'] != 0){ ?>
                                    <tr>
                                        <td class="game">
                                        <a href="member/<?php if(!$row_userown['user_nickname']){ echo $row_userown['user_id']; }else{ echo $row_userown['user_nickname']; } ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_userown['user_profile_blob']); ?>" class="img-circle" alt="">
                                        </a>
                                        
                                        <a href="member/<?php if(!$row_userown['user_nickname']){ echo $row_userown['user_id']; }else{ echo $row_userown['user_nickname']; } ?>">
                                            <span>@<? echo $row_userown['user_nickname']; ?></span>
                                        </a>
                                        
                                       
                                        </td>
                                        <td class="game-date">
                                            <span>$<? echo $CountMyOwnerNetworth; ?></span>
                                        </td>
                                    </tr>
<?php }else{ ?>
                                    
                                    <tr>
                                        <td class="team-name"><a href="/buyassets"><img src="assets/icons/usa.png" alt="">Buy Assets</a></td>
                                        <td class="team-score"><a href="/play">Play Smash And Pass</a></td>
                                    </tr>
<?php } ?>                     
                                </tbody>
                            </table>

                        
                        
                    </div>
                    <!-- SIDEBAR BOX TOP ASSETS - END -->

                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper">
                    	<!--h3>Profile <a href="/uphoto" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a></h3 --> 
                        
                        <h3><?php if(!$row_found_user['user_nickname']){ echo $row_found_user['user_fname'].' '.$row_found_user['user_lname']; }else{ echo '@'.$row_found_user['user_nickname']; } ?></h3> 
                                          
                        <div class="tournament">

                        
                            <div id="profile_pic_block" align="center">
                            <?php if(!$row_found_user['user_profile_blob']){ ?>
    
                        
                                <a><img id="profile_bpic" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
                            
                                
                           <?php }else{ ?>
    
                                <a rel="clearbox[gallery=Gallery,,width=600,,height=400]" href="/<?php echo $row_found_user['user_blob_file_path']; ?>">
                                <img id="profile_bpic" src="<?php echo 'data:image/jpg;base64,'.base64_encode($row_found_user['user_profile_blob']); ?>" class="img-responsive"  alt="">
                                </a>
    
    
                           
                           <?php } ?>
                            
                            </div>                        
                            	
                                <div id="member_actions_box" class="">
                                

                                	<ul class="brands brands-tn brands-circle brands-colored brands-inline text-center">
                                        <li><a target="_blank" data-toggle="tooltip" title="Add Friend" class="brands-tumblr  u-friend-player"><i class="fa fa-user-plus" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" data-toggle="tooltip" title="Private Message" class="brands-android u-message-player"><i class="fa fa-inbox" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" data-toggle="tooltip" title="Add To Favorites List" class="brands-google-plus u-like-player"><i class="fa fa-heart" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" data-toggle="tooltip" title="Follow" class="brands-renren u-follow-player"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a></li>
                                    </ul>




                                </div>

								<div class="team-member">
                                    <ul class="list-unstyled">
                                        <li><strong>NetWorth</strong>$  <?php echo $CountMyOwnNetworth; ?></li>
                                        <li><strong>Cash:</strong>$ <?php echo $row_found_user['MyLiquidCash']; ?></li>
                                        <li><strong>Asset(s):</strong>$ <?php if($row_found_user['SumPlyrassets']){ echo  $row_found_user['SumPlyrassets']; }else{ echo '0'; }  ?></li>
                                        <li><strong>Owns:</strong>#  <?php echo  $row_found_user['CountPlyrsOwned']; ?></li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li><strong>Growth Rate</strong><?php echo $row_found_user['user_growthrate_ply']; ?>% Up<i class="fa fa-up"></i></li>
                                    </ul>

                                </div>                            
                            
                            <?php if($found_user_id != $member_id){   // This stops the actual user from purchasing him or herself.  ?>
                            <button id="buy_player" name="<?php echo $row_found_user['user_networth_ply']; ?>" data-toggle="tooltip" title="Buy For $<?php echo $row_found_user['user_networth_ply']; ?>" class="btn btn-block btn-lg btn-green">Buy Now</button>
                            <?php } ?>
                            
                            <p><?php 	// echo ' $query_userown_sql: '. $query_userown_sql; ?></p>
                            <h4>&nbsp;</h4>
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
<?php if($totalRows_plyrassets != 0){ ?>
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches hidden-xs">
                    	<h3>Top Assets <a href="/assets" class="btn btn-primary pull-right btn-sm">All Assets</a></h3>
                        
                       
                            <table class="table match-wrapper">
                                <tbody>
								<?php do{ ?>
                                    <tr>
                                        <td class="game">
                                        <a href="/member/<?php echo $row_plyrassets['user_id']; ?>">
                                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_plyrassets['user_profile_blob']); ?>" class="img-circle" alt="">
                                        </a>
                                            <span><? echo $row_plyrassets['user_nickname']; ?></span>
                                       
                                        </td>
                                        <td class="game-date">
                                            <span>$<? echo $row_plyrassets['user_networth_ply']; ?></span>
                                        </td>
                                    </tr>
								<?php } while ($row_plyrassets = mysqli_fetch_array($plyrassets)); ?>
                                    
                                </tbody>
                            </table>
			
                        
                        
                    </div>
                    <!-- SIDEBAR BOX - END -->
	<?php } ?>
                    



                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-8">
                	

                    
                    <?php
					if($found_user_id != $user_id){
					?>
                    <div class="box config col-sm-12">
                    
                    	<p><button class="btn has-success">Smash</button> 
                        <span class="text-center">OR</span>
                        <button class="btn has-danger">Pass</button></p>
                        
                        <div class="clearfix"></div>
                        
                    </div>
                    
                    <?php } ?>




                    
                    




                    <div class="blank-panel">

                        <div class="panel-heading">
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                              		<li class="active"><a role="tab" data-toggle="tab" name="#tab-1">News Feed</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-2">Photos</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-3">About Me</a></li>
                                    <!-- li class=""><a role="tab" data-toggle="tab" name="#tab-4">Achievements</a></li -->

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
                                    <h2>Name<small><?php echo $row_found_user['user_fname']; ?> "<?php echo $row_found_user['user_nickname']; ?>" <?php echo $row_found_user['user_lname']; ?></small></h2>
                                    
                                    <ul class="list-unstyled">
                                        <?php $user_last_loggedin = $row_found_user['user_last_loggedin']; ?>
                                        <li><strong>Last Online:</strong><?php echo date( "M Y D", strtotime("$user_last_loggedin") ); ?></li>                                        
                                        <li><strong>Gender:</strong><?php echo $row_found_user['user_sex']; ?></li>
                                        <li><strong>Age:</strong><?php echo $age; ?></li>
                                        <li><strong>Relationship Status:</strong><?php if($row_found_user['show_user_relstatus'] == 1){  echo $row_found_user['user_relstatus']; }else{ echo 'Private'; } ?></li>
                                        <li><strong>Ethnicity:</strong><?php if($row_found_user['show_ethnicity'] == 1){ echo $row_found_user['user_ethnicity']; }else{ echo 'Private'; } ?></li>
                                        <li><strong>Orientation:</strong><?php if($row_found_user['show_orientation'] == 1){  echo $row_found_user['user_orientation']; }else{ echo 'Private'; } ?></li>

                                        <li><strong>Religion:</strong><?php if($row_found_user['user_showreligion'] == 1){ echo $row_found_user['user_religion']; }else{ echo 'Private'; } ?></li>
                                        <li><strong>Country:</strong><?php if($row_found_user['show_mylocation'] == 1){ echo $row_found_user['user_country']; }else{ echo 'Private'; } ?></li>
                                        <li><strong>Postal Code:</strong><?php if($row_found_user['show_mylocation'] == 1){ echo $row_found_user['user_zipcode']; }else{ echo 'Private'; } ?></li>
                                        <li><strong>Member Since:</strong><?php echo date( "M Y D", strtotime($row_found_user['user_created_at']) ); ?></li>
                                    </ul>
                                    <p>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <!-- TEAM MEMBER - END --> 
                    </div>

                                

                                        <!-- COMMENT FORM - END --> 
                                        <div id="respond" class="box comment-respond">
                                            <form method="post" id="commentform" class="comment-form">
                                                <div class="form-group comment-form-comment">
                                                    <label for="comment">Say Something<span class="required">*</span></label>
                                                    <textarea id="profile_comment" class="form-control" name="profile_comment" placeholder='Say Something Good...' aria-required="true"></textarea>
                                                </div>												
                                                <button id="submit_pubcomment" class="btn btn-primary" type="button">Submit</button>					
                                            </form>
                                        </div>
                                        <!-- COMMENT FORM - END -->  
                                

                                        <div class="clearfix"></div>
                                        
                                        


                                        
                                        <?php if($totalRows_userthread == 0){ ?>
                    <div id="thread_box" class="box">

                                        <div class="forum-post-wrapper">

                                                        <div class="row">
                                                        <hr />
                                                            <div class="col-sm-3">
                                                                <div class="author-detail">
                                                                  <h5><a>Smash And Pass</a></h5>
                                                                  <p class="function">Moderator</p>
                                                                    <ul class="list-unstyled">
                                                                        <li><strong>Join Date</strong>09/12/2017</li>
                                                                        <li><strong>Reputation</strong>9999</li>
                                                                        <li><strong>Posts</strong>9999</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <article class="forum-post">
                                                                    <div class="date">09-12-2017, 10:18 AM</div>
                                                                    <p>Make Your First Announcement Today</p>
                                                                    <a class="btn btn-primary">Like <i class="fa fa-heart"></i></a>
                                                                </article>
                                                            </div>
                                                        </div>
                                        
                                        </div>
                   </div>                                        
                                        <?php }else{ ?>

<?php do{ ?>
                    <div id="thread_box" class="box">

                                        <div class="forum-post-wrapper">

                                                        <div class="row">
                                                        <hr />
                                    <div class="col-xs-3">
                                    <?php if($row_userthread['user_profile_blob']){ ?>
                                    <a href="/member/<?php echo $row_userthread['user_id']; ?>/" class="gallery-photos">
                                     <img src="<?php echo $row_userthread['user_blob_file_path']; ?>" class="img-responsive center-block img-circle" alt="">
                                    </a>
									<?php }else{ ?>
                                    <img src="assets/images/loading.gif" class="img-responsive center-block img-circle" alt="">
                                    <?php } ?>
                                    </div>




                                                            <div class="col-sm-9">
                                                                <article class="forum-post">
                                                                    <div class="date"><?php echo $row_userthread['usr_thread_created_at']; ?></div>
                                                                    <p><?php echo $row_userthread['usr_thread_user_html']; ?></p>
                                                                    <a name="like/admin/" class="btn btn-primary">Like <i class="fa fa-heart"></i></a>
                                                                </article>
                                                            </div>
                                                        </div>

                                        </div>

                    </div>                 
<?php } while ($row_userthread = mysqli_fetch_array($result_userthread)); ?>
                                        <?php } ?>
                                        

                                        
                                        
                                        
                                        <div class="clearfix"></div>

                                </div>

                                <div id="tab-2" class="tab-pane">

					<div class="box">
                    
                    
                    		<!--a href="/profile" title="Clearbox Info" rel="clearbox[height=1000,,width=700]">
                            Clear Box Info
                            </a>


             <a rel="clearbox[gallery=Gallery,,width=600,,height=400]" href="http://www.idscrm.com" title="Iframe">
             <img  src="example/no_iframe.gif" alt="Iframe" />
             </a>


                    



             
             <a href="https://www.youtube.com/v/NBzDb8UB8yA" rel="clearbox[gallery=Gallery,,width=700,,height=490,,title=A clearbox 3 preview movie on YouTube,,comment=I uploaded some movies to YouTube from clearbox 3...]">
             <img src="https://www.youtube.com/yts/img/ringo/hitchhiker/logo_small_2x-vfl4_cFqn.png" alt="youtube movie" />
             </a -->



                    
                    </div>


                    <div class="box">
                        

                    
                                        <div class="profile-gallery">
                                            <h2>Profile gallery</h2>
                                            <div class="gallery-ajax">
                                                <div class="row">
                                                    
                    
                    <?php if($totalRows_ofuser_pic != 0) : do { ?>
                                                    
                                                    <div class="col-md-4 col-xs-6">
                                                        <a rel="<?php echo $row_ofuser_pic['profile_photoblob_id']; ?>" href="/picaction/<?php echo $row_ofuser_pic['profile_photoblob_id']; ?>/" title="<?php echo $row_ofuser_pic['profile_photoblob_created_at']; ?>"><img src="<?php echo $row_ofuser_pic['profile_photoblob_filepath'];  ?>" class="img-responsive" alt=""></a>
                                                    </div>
                    
                    <?php } while ($row_ofuser_pic = mysqli_fetch_array($result_ofuser_pic)); else: ?>
                        <div class="col-md-12">
                            <p class="text-center">No Photos At This Time</p>
                            </div>
                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                
                        
                	</div>


                                        <div class="clearfix"></div>

                                </div>

                                <div id="tab-3" class="tab-pane">
                                        <div class="box">
                                        
                    
                                                    <div class="row">
                                                        <div class="col-sm">
                                                                            <div id="profile_aboutme">
                                                                            
                                                                            
                                                                            <?php if($row_found_user['user_aboutme']){ echo $row_found_user['user_aboutme']; }else{ echo '<h2 align="center">Nothing Mentioned Yet!</h2>' ; } ?>
                                                                            
                                                                            
                                                                            </div>
                                                    
                                                                                    
                                                        </div>
                                                    </div>
                    
                                       
                                        </div>
                                </div>

                                <!-- div id="tab-4" class="tab-pane">
                                    		

                                            <div class="box">
                                                    <p>Tab 4 on yall </p>
                
                                                    <p>This is tab 4 for real</p>
                                            </div>

                                </div -->
                            

                                
                            
                            </div>

                        </div>

                    </div>



                    
                    
                    
                    
                    <div class="box">
                        

                                
                        
                	</div>


                    <!--div class="box profile-gallery">
                    	<h2>Video gallery</h2>
                        <div class="gallery-page">
                            <div class="row">
                                

<?php //do { ?>
                                
                                <div class="col-md-4 col-xs-6">
                                    <a href="<?php //echo 'data:image/jpeg;base64,'.base64_encode($row_ofuser['userblob_image'] ); ?>"><img src="<?php //echo 'data:image/jpeg;base64,'.base64_encode($row_ofuser['userblob_image'] ); ?>" class="img-responsive" alt=""></a>
                                </div>

<?php //} while ($row_ofuser = mysqli_fetch_array($result_ofuser)); ?>
                                
                            </div>
                        </div>
                    </div -->
                    
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="box sidebar-box widget-wrapper">
                                <h3>Latest Sold</h3>
                                <ul class="nav nav-sidebar">
                                    <?php if($totalRows_lastest_member_sold != 0): do{ ?>
                                    <li><a href="#"><?php echo $row_lastest_member_sold['userledger_log_price']; ?><span><?php echo $row_lastest_member_sold['userledger_log_created_at']; ?></span></a></li>
					                 <?php } while ($row_lastest_member_sold = mysqli_fetch_array($query_lastest_member_sold)); else: ?>
                                     <li><a href="#">No Recent<span>Sales</span></a></li>
                                     
                                     <?php endif; ?>

                                    
                                    
                                </ul>
                            </div>
                    	</div>
                        
                        <div class="col-md-6">
                            <div class="box sidebar-box widget-wrapper">
                                <h3>Latest Transactions</h3>
                                <ul class="nav nav-sidebar">
                                    <?php if($totalRows_lastest_member_transactions != 0): do{ ?>
                                    <li><a href="#"><?php echo $row_lastest_member_transactions['userledger_log_price']; ?><span><?php echo $row_lastest_member_transactions['userledger_log_created_at']; ?></span></a></li>
					                 <?php } while ($row_lastest_member_transactions = mysqli_fetch_array($query_lastest_member_transactions)); else: ?>
                                     <li><a href="#">No Recent<span>Sales</span></a></li>
                                     <?php endif; ?>

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
    
    
    
    
    <!-- Modal -->
<div class="modal fade" id="message_player_view_pane" tabindex="-1" role="dialog" aria-labelledby="message_player_view_paneLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" align="center">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
      
        <h5 align="center" class="modal-title" id="signinGoogle">Send A Private Message</h5>
      </div>
      <div class="modal-body">
        
        	<div class="row justify-content-center">
              <div id="signinGoogle_captionblock">
            	<div class="col-sm-12 m-b-10">
                	
                    
                    
                    <textarea id="private_comment_messsage" class="form-control m-t-10 m-b-15" name="private_comment_messsage" placeholder="Say Something Good..." aria-required="true"></textarea>
                    
                    
                    <a id="submit_private_message_to_member" class="btn btn-block btn-primary" href="#" data-dismiss="modal">Send Message</a>
                    
                </div>
              </div>
            </div>
      </div>
      <div class="modal-footer" align="center">
        <a href="#" data-dismiss="modal" class=""><span class="fa fa-close"></span> Close</a>
      </div>
    </div>
  </div>
</div>
    
    
    
   <?php include("footer_loggedin.php"); ?>
   <script src="assets/js/tz/jstz.js"></script>   
   <script src="assets/js/dropzone.js"></script>
   <script src="assets/js/member.js"></script>
   <script src="assets/js/clearbox/clearbox.js"></script>
   
</body>
</html>
<?php include("_end.mysql.php"); ?>
