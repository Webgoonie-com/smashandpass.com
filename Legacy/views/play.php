<?php


include("classes/restrict_login.php");





$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "SELECT  * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
$user_sql = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user_sql);
$totalRows_user = mysqli_num_rows($user_sql);
$user_id = $row_user['user_id'];

$user_view_iama = $row_user['user_view_iama'];
$user_view_letmeview = $row_user['user_view_letmeview'];
$user_view_agerange = $row_user['user_view_agerange'];
$user_view_zipcode = $row_user['user_view_zipcode'];








/* 

SELECT * FROM `smashan_smashandpass`.`user_imgblobs`
	 WHERE 
	 		`userblob_users_id` = '$user_id'
			AND
			`userblob_image_profilepic` = 'Y'
			AND
			`userblob_profilepic_timelist` IS NOT NULL
		ORDER BY 
			`userblob_profilepic_timelist` DESC LIMIT 1


\


	(
	SELECT 
			`user_imgblobs`.`userblob_image`,
		 	`user_imgblobs`.`userblob_users_id`
        FROM
        `smashan_smashandpass`.`user_imgblobs`, `smashan_smashandpass`.`users`
		WHERE
			`user_imgblobs`.`userblob_image_profilepic` = 'Y' AND
			`users`.`user_id` = `user_imgblobs`.`userblob_users_id`
		ORDER BY `user_imgblobs`.`userblob_profilepic_timelist` DESC LIMIT 1
	) 









SELECT 
`users`.`user_id`,
`users`.`user_nickname`,
`users`.`user_emailverify`,
`users`.`user_last_loggedin`,
`user_imgblobs`.`userblob_image` AS userblob_image
FROM 
 `smashan_smashandpass`.`users`
  LEFT JOIN `smashan_smashandpass`.`user_imgblobs` ON (`users`.`user_id` =  `user_imgblobs`.`userblob_users_id`)
  WHERE
  	`user_imgblobs`.`userblob_image_profilepic` = 'Y'



SELECT 
`users`.`user_id`,
`users`.`user_nickname`,
`users`.`user_emailverify`,
`users`.`user_last_loggedin`,
`user_imgblobs`.`userblob_users_id` AS userblob_users_id,
`user_imgblobs`.`userblob_profilepic_timelist` AS userblob_profilepic_timelist,
`user_imgblobs`.`userblob_image` AS userblob_image
FROM smashan_smashandpass`.`users` mcr
    left outer join (
SELECT * FROM `smashan_smashandpass`.`user_imgblobs`
	 WHERE 
	 		`userblob_users_id` = '$user_id'
			AND
			`userblob_image_profilepic` = 'Y'
			AND
			`userblob_profilepic_timelist` IS NOT NULL
		ORDER BY 
			`userblob_profilepic_timelist` DESC LIMIT 1
    ) r ON mcr.	user_id = r.userblob_users_id 
WHERE mcr.user_emailverify = '1'
 

*/


$find_users_queryyyy = "
SELECT * FROM 
 `smashan_smashandpass`.`users`
 WHERE `users`.`user_blob_file_path` IS NOT NULL
 	AND
	`users`.`user_sex` = '$user_view_letmeview'	
	AND
	`users`.`user_id` NOT LIKE '%$user_id%'
	GROUP BY
	`users`.`user_id`
		ORDER BY RAND()

";

$find_users_queryyy = "
SELECT
`users`.`user_id`,
`users`.`user_nickname`,
`users`.`user_emailverify`,
`users`.`user_last_loggedin`,
`user_imgblobs`.`userblob_users_id` AS userblob_users_id,
`user_imgblobs`.`userblob_profilepic_timelist` AS userblob_profilepic_timelist,
MIN(userblob_profilepic_timelist),
`user_imgblobs`.`userblob_image` AS userblob_image
FROM 
 `smashan_smashandpass`.`users`
 
 WHERE `user_imgblobs`.`userblob_users_id` = (
 
 SELECT `user_imgblobs`.`userblob_users_id` FROM `smashan_smashandpass`.`user_imgblobs`
	 WHERE 
			`userblob_image_profilepic` = 'Y'
			AND
			`userblob_profilepic_timelist` IS NOT NULL
		ORDER BY 
			`userblob_profilepic_timelist` DESC LIMIT 1

 
 
 )
 	AND
	`users`.`user_sex` = '$user_view_letmeview'	
	GROUP BY `userblob_users_id`
	ORDER BY `user_imgblobs`.`userblob_profilepic_timelist` DESC, `user_imgblobs`.`userblob_users_id` ASC

 


";


$find_users_queryy = "
SELECT 
mcr.user_id,
mcr.user_nickname,
mcr.user_emailverify,
mcr.user_last_loggedin,
r.userblob_users_id,
r.userblob_profilepic_timelist,
r.userblob_image
FROM `smashan_smashandpass`.`users` AS mcr
    left outer join (
SELECT `user_imgblobs`.`userblob_image` FROM `smashan_smashandpass`.`user_imgblobs`
	 WHERE 
	 		`userblob_users_id` = '$user_id'
			AND
			`userblob_image_profilepic` = 'Y'
			AND
			`userblob_profilepic_timelist` IS NOT NULL
			AND
			`userblob_image` IS NOT NULL
		ORDER BY 
			`userblob_profilepic_timelist` DESC LIMIT 1
    ) AS r ON mcr.user_id = r.userblob_users_id 
WHERE mcr.user_emailverify = '1'
";

$find_users_query = "
SELECT 
`users`.`user_id`,
`users`.`user_nickname`,
`users`.`user_emailverify`,
`users`.`user_last_loggedin`,
`user_imgblobs`.`userblob_users_id` AS userblob_users_id,
`user_imgblobs`.`userblob_profilepic_timelist` AS userblob_profilepic_timelist,
MAX(userblob_profilepic_timelist),
`user_imgblobs`.`userblob_image` AS userblob_image
FROM 
 `smashan_smashandpass`.`users`
  LEFT JOIN `smashan_smashandpass`.`user_imgblobs` ON (`user_imgblobs`.`userblob_users_id` = `users`.`user_id`)
  WHERE
  	`user_imgblobs`.`userblob_image_profilepic` = 'Y'
	AND
	`users`.`user_sex` = '$user_view_letmeview'	
	GROUP BY `userblob_users_id`
	ORDER BY `user_imgblobs`.`userblob_profilepic_timelist` DESC, `user_imgblobs`.`userblob_users_id` ASC
	
";
$result_ofusers = mysqli_query($webgoneGlobal_mysqli, $find_users_queryyyy);
$row_ofusers = mysqli_fetch_assoc($result_ofusers);
$totalRows_ofusers = mysqli_num_rows($result_ofusers);	

$find_users_connections_query = "
SELECT 

`aSmash`.`smashandpass_id` AS `aSmashpass_id`,
`aSmash`.`smashandpass_user_idone` AS `aSmashpass_user_idone`,
`aSmash`.`smashandpass_user_idone_time` AS `aSmashpass_user_idone_time`,
`aSmash`.`smashandpass_user_idone_action` AS `aSmashpass_user_idone_action`,
`aSmash`.`smashandpass_user_idtwo` AS `aSmashpass_user_idtwo`,
`aSmash`.`smashandpass_user_idtwo_time` AS `aSmashpass_user_idtwo_time`,
`aSmash`.`smashandpass_user_idtwo_action` AS `aSmashpass_idtwo_action`,

`mySmash`.`smashandpass_id` AS `mySmash_idtwo_action`,
`mySmash`.`smashandpass_user_idone` AS `mySmash_user_idone`,
`mySmash`.`smashandpass_user_idone_time` AS `mySmash_user_idone_time`,
`mySmash`.`smashandpass_user_idone_action` AS `mySmash_user_idone_action`,
`mySmash`.`smashandpass_user_idtwo` AS `mySmash_user_idtwo`,
`mySmash`.`smashandpass_user_idtwo_time` AS `mySmash_user_idtwo_time`,
`mySmash`.`smashandpass_user_idtwo_action` AS `mySmash_user_idtwo_action`,
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
  `smashan_smashandpass`.`users_smashandpass` AS `aSmash`
 
 INNER JOIN `smashan_smashandpass`.`users_smashandpass` AS `mySmash` ON
    	   `aSmash`.`smashandpass_user_idone` = `mySmash`.`smashandpass_user_idtwo`
LEFT JOIN `smashan_smashandpass`.`users` AS `u` ON
    	   `u`.`user_id` = `mySmash`.`smashandpass_user_idone`
		   
		   
 WHERE 
 `u`.`user_blob_file_path` IS NOT NULL
 	AND
	`aSmash`.`smashandpass_user_idone_action` = 'smash'
 	
	AND
	`mySmash`.`smashandpass_user_idtwo` = '$user_id'
	AND
	`u`.`user_id` NOT LIKE '%$user_id%'
	GROUP BY
	`u`.`user_id`
";
$result_ofusers_connectme = mysqli_query($webgoneGlobal_mysqli, $find_users_connections_query);
$row_ofusers_connectme = mysqli_fetch_assoc($result_ofusers_connectme);
$totalRows_ofusers_connectme = mysqli_num_rows($result_ofusers_connectme);	



$find_users_noticeme_query = "
SELECT * FROM 
 `smashan_smashandpass`.`users`,  `smashan_smashandpass`.`users_smashandpass`
 WHERE `users`.`user_blob_file_path` IS NOT NULL
 	AND
	`users`.`user_id` = `users_smashandpass`.`smashandpass_user_idtwo`
 	AND
	`users_smashandpass`.`smashandpass_user_idone_action` = 'smash'
	AND
	`users`.`user_id` NOT LIKE '%$user_id%'
	GROUP BY
	`users`.`user_id`
		

";
$result_ofusers_noticeme = mysqli_query($webgoneGlobal_mysqli, $find_users_noticeme_query);
$row_ofusers_noticeme = mysqli_fetch_assoc($result_ofusers_noticeme);
$totalRows_ofusers_noticeme = mysqli_num_rows($result_ofusers_noticeme);	

$find_users_myfavs_query = "
SELECT * FROM 
 `smashan_smashandpass`.`users`,  `smashan_smashandpass`.`users_smashandpass`
 WHERE `users`.`user_blob_file_path` IS NOT NULL
 	AND
	`users`.`user_id` = `users_smashandpass`.`smashandpass_user_idtwo`
 	AND
	`users_smashandpass`.`smashandpass_user_idone_action` = 'smash'
	AND
	`users`.`user_id` NOT LIKE '%$user_id%'
	GROUP BY
	`users`.`user_id`
		

";
$result_ofusers_myfavs = mysqli_query($webgoneGlobal_mysqli, $find_users_myfavs_query);
$row_ofusers_myfavs = mysqli_fetch_assoc($result_ofusers_myfavs);
$totalRows_ofusers_myfavs = mysqli_num_rows($result_ofusers_myfavs);	



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
    <title>Playing Now</title>
    
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
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png"/>

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
    	Dropzone CSS 
    =========================== -->
    <link href="assets/css/basic.css" rel="stylesheet" type="text/css">    
    <link href="assets/css/dropzone.css" rel="stylesheet" type="text/css">
    
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
    <div class="container">
        <section class="content-wrapper">
        	<div class="row">
            
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-12">



                    <div class="panel blank-panel">

                        <div class="panel-heading">
                            <div class="panel-title m-b-md"><h4>Make New Friends On Smash And Pass</h4></div>
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a role="tab" data-toggle="tab" name="#tab-1">Play</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-2">Connections</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-3">Notice Me</a></li>
                                    <li class=""><a role="tab" data-toggle="tab" name="#tab-4">Favorites</a></li>

                                    <li class="last-nav-match"><a role="tab" data-toggle="tab" name="#view-settings">Settings &nbsp;&nbsp;  <i class="fa fa-server" aria-hidden="true"></i></a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="panel-body clearfix">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                
					                <div id="play_newmatches" class="col-sm-8 clearfix">
									
                                    
									<?php do { ?>
                                    
                                    <div class="playmatch-feat col-sm-6">
                                    <div class="row">
                                        <div class="col-sm" align="center">
                                        
                                        <a ><img src="<?php echo $row_ofusers['user_blob_file_path']; ?>" class="img-responsive" width="200px" alt=""> <span class="usr-tname"><?php if(!$row_ofusers['user_nickname']){ echo $row_ofusers['user_fname'].' '.$row_ofusers['user_lname']; ;  }else{  echo $row_ofusers['user_nickname']; } ?></span></a>
                                        
                                        
                                        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 clearfix">
                                         <div class="smashwin-btn pull-left"><button id="<?php echo $row_ofusers['user_id']; ?>" type="button" class="btn btn-success btn-block">SMASH</button></div>
                                        <div class="passwin-btn pull-right"><button id="<?php echo $row_ofusers['user_id']; ?>" type="button" class="btn btn-danger btn-block">PASS</button></div>
                                       
                                        </div>
                                    </div>
                                      
                                    </div>
    
									<?php } while ($row_ofusers = mysqli_fetch_array($result_ofusers)); ?>
                                    		
                                    <div class="clearfix"></div>
                                    </div>
					                <div id="play_newmatch_adzone" class="col-sm-4 hidden-xs">
                                    <strong>Advertisement</strong>

                                    <p>{AD}</p>
                                    
                                    </div>

                                </div>

                                <div id="tab-2" class="tab-pane">

                                    <strong>Connections</strong>


										<?php do{ ?>


                                    		<p><img src="<?php echo $row_ofusers_connectme['user_blob_file_path']; ?>" class="img-responsive" width="120px"></p>

			


										<?php } while ($row_ofusers_connectme = mysqli_fetch_array($result_ofusers_connectme)); ?>



                                
                                
                                
                                </div>

                                <div id="tab-3" class="tab-pane">
                                    <strong>Notice Me</strong>
									<?php do{ ?>
                                    <p><img src="<?php echo $row_ofusers_noticeme['user_blob_file_path']; ?>" class="img-responsive" width="120px"></p>

                                   



										 <p>This is tab 3 connections</p>


			

									<?php } while ($row_ofusers_noticeme = mysqli_fetch_array($result_ofusers_noticeme)); ?>


                                </div>

                                <div id="tab-4" class="tab-pane">
                                    <strong>Favorites</strong>

                                   

                                   




										<?php do{ ?>
                                         <p>Tab 4 on yall </p>
                                        
                                        
                                                     <p><img src="<?php echo $row_ofusers_myfavs['user_blob_file_path']; ?>" class="img-responsive" width="120px"></p>
                                        
                                        
                                        <?php } while ($row_ofusers_myfavs = mysqli_fetch_array($result_ofusers_myfavs)); ?>

                                </div>
                                <div id="view-settings" class="tab-pane">





                                    <div class="row">
                                        <div class="box registration-form">
                                            <h2>View Settings</h2>
                                            <div>
                                                <div class="form-group">
                                                    <label for="view_iama">I am a:</label>
                                                    <select class="form-control" id="view_iama">
                                                    <option value="Male" <?php if (!(strcmp("Male", $row_user['user_view_iama']))) {echo "selected=\"selected\"";} ?>>Male</option>
                                                    <option value="Female" <?php if (!(strcmp("Female", $row_user['user_view_iama']))) {echo "selected=\"selected\"";} ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="view_letmeview">Let me view:</label>
                                                    <select class="form-control" id="view_letmeview">
                                                    <option value="Male" <?php if (!(strcmp("Male", $row_user['user_view_letmeview']))) {echo "selected=\"selected\"";} ?>>Males</option>
                                                    <option value="Female" <?php if (!(strcmp("Female", $row_user['user_view_letmeview']))) {echo "selected=\"selected\"";} ?>>Females</option>
                                                    </select>
    
                                                </div>
                                                <div class="form-group">
                                                    <label for="view_agerange">Max Age Range</label>
                                                    <select class="form-control" id="view_agerange">
                                                      <option value="18" <?php if (!(strcmp(18, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>18</option>
                                                      <option value="19" <?php if (!(strcmp(19, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>19</option>
                                                    <option value="20" <?php if (!(strcmp(20, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>20</option>
                                                    <option value="21" <?php if (!(strcmp(21, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>21</option>
                                                    <option value="22" <?php if (!(strcmp(22, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>22</option>
                                                    <option value="23" <?php if (!(strcmp(23, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>23</option>
                                                    <option value="24" <?php if (!(strcmp(24, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>24</option>
                                                    <option value="25" <?php if (!(strcmp(25, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>25</option>
                                                    <option value="26" <?php if (!(strcmp(26, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>26</option>
                                                    <option value="27" <?php if (!(strcmp(27, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>27</option>
                                                    <option value="28" <?php if (!(strcmp(28, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>28</option>
                                                    <option value="29" <?php if (!(strcmp(29, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>29</option>
    <option value="30" <?php if (!(strcmp(30, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>30</option>
    <option value="31" <?php if (!(strcmp(31, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>31</option>
    <option value="32" <?php if (!(strcmp(32, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>32</option>
    <option value="33" <?php if (!(strcmp(33, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>33</option>
    <option value="34" <?php if (!(strcmp(34, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>34</option>
    <option value="35" <?php if (!(strcmp(35, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>35</option>
    <option value="36" <?php if (!(strcmp(36, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>36</option>
    <option value="37" <?php if (!(strcmp(37, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>37</option>
    <option value="38" <?php if (!(strcmp(38, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>38</option>
    <option value="39" <?php if (!(strcmp(39, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>39</option>
    <option value="40" <?php if (!(strcmp(40, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>40</option>
    <option value="41" <?php if (!(strcmp(41, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>41</option>
    <option value="42" <?php if (!(strcmp(42, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>42</option>
    <option value="43" <?php if (!(strcmp(43, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>43</option>
    <option value="44" <?php if (!(strcmp(44, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>44</option>
    <option value="45" <?php if (!(strcmp(45, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>45</option>
    <option value="46" <?php if (!(strcmp(46, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>46</option>
    <option value="47" <?php if (!(strcmp(47, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>47</option>
    <option value="48" <?php if (!(strcmp(48, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>48</option>
    <option value="49" <?php if (!(strcmp(49, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>49</option>
    <option value="50" <?php if (!(strcmp(50, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>50</option>
    <option value="51" <?php if (!(strcmp(51, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>51</option>
    <option value="52" <?php if (!(strcmp(52, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>52</option>
    <option value="53" <?php if (!(strcmp(53, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>53</option>
    <option value="54" <?php if (!(strcmp(54, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>54</option>
    <option value="55" <?php if (!(strcmp(55, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>55</option>
    <option value="56" <?php if (!(strcmp(56, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>56</option>
    <option value="57" <?php if (!(strcmp(57, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>57</option>
    <option value="58" <?php if (!(strcmp(58, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>58</option>
    <option value="59" <?php if (!(strcmp(59, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>59</option>
    <option value="60" <?php if (!(strcmp(60, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>60</option>
    <option value="61" <?php if (!(strcmp(61, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>61</option>
    <option value="62" <?php if (!(strcmp(62, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>62</option>
    <option value="63" <?php if (!(strcmp(63, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>63</option>
    <option value="64" <?php if (!(strcmp(64, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>64</option>
    <option value="65" <?php if (!(strcmp(65, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>65</option>
    <option value="66" <?php if (!(strcmp(66, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>66</option>
    <option value="67" <?php if (!(strcmp(67, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>67</option>
    <option value="68" <?php if (!(strcmp(68, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>68</option>
    <option value="69" <?php if (!(strcmp(69, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>69</option>
    <option value="70" <?php if (!(strcmp(70, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>70</option>
    <option value="71" <?php if (!(strcmp(71, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>71</option>
    <option value="72" <?php if (!(strcmp(72, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>72</option>
    <option value="73" <?php if (!(strcmp(73, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>73</option>
    <option value="74" <?php if (!(strcmp(74, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>74</option>
    <option value="75" <?php if (!(strcmp(75, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>75</option>
    <option value="76" <?php if (!(strcmp(76, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>76</option>
    <option value="77" <?php if (!(strcmp(77, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>77</option>
    <option value="78" <?php if (!(strcmp(78, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>78</option>
    <option value="79" <?php if (!(strcmp(79, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>79</option>
    <option value="80" <?php if (!(strcmp(80, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>80</option>
    <option value="81" <?php if (!(strcmp(81, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>81</option>
    <option value="82" <?php if (!(strcmp(82, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>82</option>
    <option value="83" <?php if (!(strcmp(83, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>83</option>
    <option value="84" <?php if (!(strcmp(84, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>84</option>
    <option value="85" <?php if (!(strcmp(85, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>85</option>
    <option value="86" <?php if (!(strcmp(86, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>86</option>
    <option value="87" <?php if (!(strcmp(87, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>87</option>
    <option value="88" <?php if (!(strcmp(88, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>88</option>
    <option value="89" <?php if (!(strcmp(89, $row_user['user_view_agerange']))) {echo "selected=\"selected\"";} ?>>89</option>
    
                                                    </select>
    
                                                </div>
    
                                              <div class="form-group">
                                                <label for="view_zipcode">Zip Code</label>
                                                  <input type="text" class="form-control" id="view_zipcode" value="<?php echo $row_user['user_view_zipcode']; ?>" placeholder="Enter zipcode">
                                                </div>
                                                <div class="form-group">
                                                    <p>&nbsp;</p>
                                                    <p><button id="changemy_view" type="button" class="btn btn-primary login-btn">Change My View</button></p>
                                                </div>
                                                <div class="checkbox remember">By changing your view your selectioins above will determine by what you set.</div>
                                            </div>
                                        </div>
									</div>







                                
                                </div>
                            
                            
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
    
    
    <!-- ==========================
    	MODALS - START
    =========================== -->
    <!-- Modal -->
    <div class="modal fade" id="signalSplashModal" tabindex="-1" role="dialog" aria-labelledby="signalSplashModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" align="center">
            <h5 align="center" class="modal-title" id="signinGoogle">YOU TWO JUST MADE A SPLASH!!!</h5>
          </div>
          <div id="spalsh_body_view" class="modal-body">
            
               
          </div>
          <div class="modal-footer" align="center">
            <a id="close_smash_Window" href="#" data-dismiss="modal" class="btn btn-sm btn-danger"><span class="fa fa-close"></span> Skip For Now</a>
          </div>
        </div>
      </div>
    </div>
    <!-- ==========================
    	MODALS - END 
    =========================== -->


   <?php include("footer_loggedin.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    <script src="assets/js/tz/jstz.js"></script>   
  
    <script src="assets/js/play.js"></script>
    
</body>
</html>
<?php include("_end.mysql.php"); ?>