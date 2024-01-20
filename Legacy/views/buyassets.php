<?php
require_once("classes/db_connect.php");

include("classes/restrict_login.php");




$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "SELECT 	`users`.`user_id` AS theusr_id ,
		`users`.* ,
	`users`.`user_nickname`, 
	`users`.`user_profile_blob`, 
	`users`.`user_networth_ply`,  
	
			SUM(`users`.`user_networth_ply`) as MyLiquidCash, 
			
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS sumMyPlyrassets,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets
			
FROM `smashan_smashandpass`.`users`
WHERE `users`.`user_email` = '$MM_UsernameAgent'";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);
$user_id = $row_user['user_id'];

// Defining MyLiquidWorth
$MyLiquidCash = $row_user['MyLiquidCash'];
$SumPlyrassets = $row_user['SumPlyrassets'];
$CountMyOwnNetworth = $MyLiquidCash + $SumPlyrassets;



$user_view_iama = $row_user['user_view_iama'];
$user_view_letmeview = $row_user['user_view_letmeview'];
$user_view_agerange = $row_user['user_view_agerange'];
$user_view_zipcode= $row_user['user_view_zipcode'];



$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	



// Smash And Pass Quick Picks
$find_playuser_pic = "

SELECT `users`.`user_id` AS theusr_id, `users`.* , `user_imgblobs`.`userblob_users_id` AS `users_id`,
(SELECT COUNT(*) FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = theusr_id) AS total_records 
FROM `smashan_smashandpass`.`users` 
LEFT JOIN `smashan_smashandpass`.`user_imgblobs` 
ON `users`.`user_id` = `user_imgblobs`.`userblob_users_id` 
WHERE
				`users`.`user_sex` = '$user_view_letmeview'
					AND				
					`user_imgblobs`.`userblob_users_id` NOT IN ('$user_id')
						GROUP BY
						`users`.`user_id`
						HAVING COUNT(`users`.`user_id`) > 0 
							ORDER BY RAND() LIMIT 50
";
$result_playuser_pic = mysqli_query($webgoneGlobal_mysqli, $find_playuser_pic);
$row_playuser_pic = mysqli_fetch_assoc($result_playuser_pic);
$totalRows_playuser_pic = mysqli_num_rows($result_playuser_pic);	



// SELECT `user_id`, sum( `user_networth_ply` ) as total_mark FROM `users` WHERE `user_owner_id` = '6'
// SELECT `users`.`user_id`, `users`.`user_owner_id`, `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply` FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '$found_user_id'
// Runs Value Of Assests
$query_plyrassets_sql = "SELECT `user_id`, sum( `user_networth_ply` ) as `networth_ply` FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '6'";
$plyrassets = mysqli_query($webgoneGlobal_mysqli, $query_plyrassets_sql);
$row_plyrassets = mysqli_fetch_assoc($plyrassets);
$totalRows_plyrassets = mysqli_num_rows($plyrassets);

$networth_ply = $row_plyrassets['networth_ply'];




$maxRows_view_assets = 100;
$pageNum_view_assets = 0;
if (isset($_GET['pageNum_view_assets'])) {
  $pageNum_view_assets = $_GET['pageNum_view_assets'];
}
$startRow_view_assets = $pageNum_view_assets * $maxRows_view_assets;

mysqli_select_db($webgoneGlobal_mysqli, $database_webgoonSmash);
/*
Took out to keep things simple need to come back to this one.
SELECT 	`users`.`user_id` AS theusr_id ,
		`users`.* ,
		`user_picthreads`.* ,
		`user_picthreads`.`picthread_userblob_id` AS picthread_userblob_id,
		`user_picthreads`.`picthread_touser_id` AS picthread_touser_id,
		`user_picthreads`.`picthread_fromuserid` AS picthread_fromuserid,
		`user_imgblobs`.`userblob_users_id` AS `users_id`,
		(SELECT COUNT(*) FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = theusr_id) AS total_records 
FROM 
	`smashan_smashandpass`.`user_picthreads` 
	LEFT JOIN `smashan_smashandpass`.`users`
		ON  `user_picthreads`.`picthread_userblob_id`  = `users`.`user_id`
	LEFT JOIN `smashan_smashandpass`.`user_imgblobs`
		ON  `user_imgblobs`.`userblob_users_id`  = `users`.`user_id`
WHERE
	`user_picthreads`.`picthread_userblob_id` IS NOT NULL

GROUP BY `user_picthreads`.`picthread_id`
ORDER BY 
		 `user_picthreads`.`picthread_created_at` ASC
*/

/*
`users`.`user_sex` = '$user_view_letmeview'
					AND		
					
*/
$query_view_assets = "
SELECT `users`.`user_id` AS theusr_id, `users`.* , `user_imgblobs`.`userblob_users_id` AS `users_id`,
	`users`.`user_networth_ply` as MyLiquidCash, 

			(SELECT COUNT(*) FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = theusr_id) AS total_records ,
			(SELECT COUNT(`users`.`user_id`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS CountPlyrsOwned,
			(SELECT SUM(`users`.`user_networth_ply`) FROM  `smashan_smashandpass`.`users` WHERE `user_owner_id`  = theusr_id) AS SumPlyrassets

FROM `smashan_smashandpass`.`users` 
LEFT JOIN `smashan_smashandpass`.`user_imgblobs` 
ON `users`.`user_id` = `user_imgblobs`.`userblob_users_id` 
WHERE

					`users`.`user_id` = `user_imgblobs`.`userblob_users_id`
					AND

					`users`.`user_profile_blob` IS NOT NULL
					AND
					
					`users`.`user_id` NOT IN ('$user_id')
						GROUP BY
						`users`.`user_id`
						HAVING COUNT(`user_imgblobs`.`userblob_users_id`) > 0 
							ORDER BY RAND(),  `user_id` DESC
	";
	
/*AND
 `user_friends`.`friend_userid` = '$user_id'
*/					
$query_limit_view_assets = sprintf("%s LIMIT %d, %d", $query_view_assets, $startRow_view_assets, $maxRows_view_assets);
$view_assets = mysqli_query($webgoneGlobal_mysqli, $query_limit_view_assets);
$row_view_assets = mysqli_fetch_array($view_assets);
$totalRows_picthreads = mysqli_num_rows($view_assets);

if (isset($_GET['totalRows_view_assets'])) {
  $totalRows_view_assets = $_GET['totalRows_view_assets'];
} else {
  $all_view_assets = mysqli_query($webgoneGlobal_mysqli, $query_view_assets);
  $totalRows_view_assets = mysqli_num_rows($all_view_assets);
}
$totalPages_view_assets = ceil($totalRows_view_assets/$maxRows_view_assets)-1;




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
    <title>Buy Assets</title>
    
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
    <link href="assets/css/app.css" rel="stylesheet" type="text/css">
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
   <?php include("views/subfolder/_buy.member_modals.php"); ?>
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container hidden-xs">
    	<div class="header-title">
        	<div class="pull-left">
        		<h2><a href="/play"><span class="text-primary">Smash</span>And Pass</a></h2>
                <p>An exciting way to meet new people and build value.</p>
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
                    	<!--h3>Profile <a href="/uphoto" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a></h3 --> 
                        
                        <h3><a href="/profile"><?php if(!$row_user['user_nickname']){ echo $row_user['user_fname'].' '.$row_user['user_lname']; }else{ echo '@'.$row_user['user_nickname']; } ?></a></h3> 
                        
                        <?php
						
						// echo $find_playuser_pic;
						// echo $query_view_assets;
						
						 ?> 
                                          
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
                            

                            <div class="team-member">
                                    <ul class="list-unstyled">
                                        <li><strong>NetWorth</strong>$  <?php echo $CountMyOwnNetworth; ?></li>
                                        <li><strong>Liquid Cash:</strong>$ <?php echo $row_user['MyLiquidCash']; ?></li>
                                        <li><strong>Asset(s):</strong>$  <?php echo  $row_user['SumPlyrassets']; ?></li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li><strong>Growth Rate</strong><?php echo $row_found_user['user_growthrate_ply']; ?>% Up<i class="fa fa-up"></i></li>
                                    </ul>
                                     <ul class="list-unstyled">
                                        <li><a class="btn btn-primary" href="/profile">View Profile</a></li>
                                    </ul>
                                </div>                            
                            
                            
                           
                            
                            
                            
                            <h4>&nbsp;</h4>
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-8">
                    
                	<div class="box">


                    	<ul class="list-unstyled list-inline team-categories">
                        	<li><a  class="btn btn-primary active">Everyone <?php echo $totalRows_picthreads.' - '. $totalPages_view_assets; ?></a></li>
                          	<li><a  class="btn btn-primary ">Friends</a></li>
                          	<li><a  class="btn btn-primary ">Assets</a></li>
                      	</ul>


                        
                     	<div class="team-members-wrapper">
<?php if($view_assets != 0): ?>

<?php  do {
	

// Defining MyLiquidWorth
if(!$row_view_assets['MyLiquidCash']){ 
	$MyLiquidCash = '10';
}else{
	$MyLiquidCash = $row_view_assets['MyLiquidCash'];
}


if(!$row_view_assets['SumPlyrassets']){ 
	$SumPlyrassets = '10';
}else{
	$SumPlyrassets = $row_view_assets['SumPlyrassets'];
}


$CountMyOwnNetworth = $MyLiquidCash + $SumPlyrassets;
	
?>



                            
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3">
                                    <?php if($row_view_assets['user_profile_blob']){ ?>
                                    <a href="#">
                                     <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row_view_assets['user_profile_blob']); ?>" class="buy-pic img-responsive center-block img-circle" alt="">
                                    </a>
									<?php }else{ ?>
                                    <img src="assets/images/loading.gif" class="img-responsive center-block img-circle" alt="">
                                    <?php } ?>
                                    </div>
                                    <div class="col-xs-9">
                                      <div>
                                        <h2><a href="/member/<?php if($row_view_assets['user_nickname']){ echo $row_view_assets['user_nickname']; }else{ echo $row_view_assets['user_id'];} ?>"><?php if(!$row_view_assets['user_nickname']){ echo $row_view_assets['user_fname'].' '.$row_view_assets['user_lname']; }else{ echo '@'.$row_view_assets['user_nickname']; } ?><small><?php echo date( "M  Y D", strtotime(  $row_view_assets['user_last_loggedin'] ) ); ?></small></a></h2>
                                        <p><?php echo $row_view_assets['usr_thread_user_html']; ?></p>
                                        <ul class="brands brands-tn brands-circle brands-colored brands-inline">
                                           <li><a class="brands-facebook pnt"><?php echo $MyLiquidCash; ?></a></li>
                                            <li><a class="brands-google-plus pnt"><?php echo $SumPlyrassets; ?></a></li>
                                            <li><a class="brands-twitter pnt"><?php echo $CountMyOwnNetworth; ?></a></li>
                                        </ul>
                                      </div>
                                      <div id="<?php echo $row_view_assets['user_id']; ?>">

<?php if($user_id != $member_id){   // This stops the actual user from purchasing him or herself.  ?>


                                      	<button id="buy_player" name="<?php echo $CountMyOwnNetworth; ?>" data-toggle="tooltip"  title="<?php echo 'Buy For $'.$CountMyOwnNetworth; ?>" type="button" class="btn btn-primary"><i class="fa fa-dollar"></i> Buy Now</button>
                            <?php } ?>

                                      </div>
                                      
                                        
                                    </div>
                                </div>
                            	<div class="row">
                                	<div class="col-xs-9">
                                    	
                                        <ul class="brands brands-tn brands-circle brands-colored brands-inline">
                                           <li><a class="brands-facebook pnt"><i class="fa fa-thumbs-up"></i></a></li>
                                            <li><a class="brands-twitter pnt"><i class="fa fa-comment"></i></a></li>
                                            <li><a class="brands-google-plus pnt"><i class="fa fa-bank"></i></a></li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM MEMBER - END --> 




  
<?php } while ($row_view_assets = mysqli_fetch_array($view_assets)); ?>


<?php  else: ?>









                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><img src="assets/images/blank_profileimg.png" class="img-responsive center-block img-circle" alt=""></div>
                                    <div class="col-xs-9">
                                        <h2>Currently You Have No New Assets To View</h2>
                                        <p>Try playing smash and pass to gain new friends and build value.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM MEMBER - END -->


<?php endif; ?>
                            
                    	</div>



                    	

                    </div>
                    
                    <div id="load_morenews" class="box">

						<ul class="list-unstyled list-inline team-categories">
                        	<li><button type="button" class="btn btn-block btn-primary btn-lg active">Load More Assets</button></li>
                      	</ul>
                        
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
    <!-- ==========================
    	DropZone 
    =========================== -->

   <script src="assets/js/tz/jstz.js"></script>   
   <script src="assets/js/clearbox/clearbox.js"></script>
	
    <script src="assets/js/global.js"></script>
    <script src="assets/js/news.js"></script>



   
   
   <script src="assets/js/buyassets.js"></script>





</body>
</html>
