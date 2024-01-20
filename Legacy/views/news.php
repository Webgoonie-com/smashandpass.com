<?php
require_once("classes/db_connect.php");


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



$user_view_iama = $row_user['user_view_iama'];
$user_view_letmeview = $row_user['user_view_letmeview'];
$user_view_agerange = $row_user['user_view_agerange'];
$user_view_zipcode= $row_user['user_view_zipcode'];



$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	


// SELECT `user_id`, sum( `user_networth_ply` ) as total_mark FROM `users` WHERE `user_owner_id` = '6'
// SELECT `users`.`user_id`, `users`.`user_owner_id`, `users`.`user_nickname`, `users`.`user_profile_blob`, `users`.`user_networth_ply` FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '$found_user_id'
// Runs Value Of Assests
$query_plyrassets_sql = "SELECT `user_id`, sum( `user_networth_ply` ) as `networth_ply` FROM `smashan_smashandpass`.`users` WHERE `users`.`user_owner_id` = '6'";
$plyrassets = mysqli_query($webgoneGlobal_mysqli, $query_plyrassets_sql);
$row_plyrassets = mysqli_fetch_assoc($plyrassets);
$totalRows_plyrassets = mysqli_num_rows($plyrassets);

$networth_ply = $row_plyrassets['networth_ply'];




$maxRows_news_threads = 100;
$pageNum_news_threads = 0;
if (isset($_GET['pageNum_news_threads'])) {
  $pageNum_news_threads = $_GET['pageNum_news_threads'];
}
$startRow_news_threads = $pageNum_news_threads * $maxRows_news_threads;

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

$query_news_threads = "
	SELECT * FROM 
			`smashan_smashandpass`.`user_threads`
			LEFT JOIN `smashan_smashandpass`.`users` 
			ON `user_threads`.`usr_thread_user_id` = `users`.`user_id`
			LEFT JOIN `smashan_smashandpass`.`user_friends` 
			ON `user_threads`.`usr_thread_tomember_id` = `user_friends`.`friend_userid`
			
				WHERE 
				`user_threads`.`usr_thread_user_html` IS NOT NULL
				
					
	ORDER BY `usr_thread_id` DESC 
	";
	
/*AND
 `user_friends`.`friend_userid` = '$user_id'
*/					
$query_limit_news_threads = sprintf("%s LIMIT %d, %d", $query_news_threads, $startRow_news_threads, $maxRows_news_threads);
$news_threads = mysqli_query($webgoneGlobal_mysqli, $query_limit_news_threads);
$row_news_threads = mysqli_fetch_array($news_threads);
$totalRows_picthreads = mysqli_num_rows($news_threads);

if (isset($_GET['totalRows_news_threads'])) {
  $totalRows_news_threads = $_GET['totalRows_news_threads'];
} else {
  $all_news_threads = mysqli_query($webgoneGlobal_mysqli, $query_news_threads);
  $totalRows_news_threads = mysqli_num_rows($all_news_threads);
}
$totalPages_news_threads = ceil($totalRows_news_threads/$maxRows_news_threads)-1;


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
    <title>News</title>
    
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
    <?php include("views/subfolder/_profile_modals.php"); ?>
    
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
    	JUMBOTRON - START 
    =========================== -->
    <div class="container">
    	<div class="jumbotron">
        	<div class="jumbotron-panel">
            	<div class="panel panel-primary collapse-horizontal">
                    <a data-toggle="collapse" class="btn btn-primary collapsed" data-target="#toggle-collapse">Change your player view<i class="fa fa-caret-down"></i></a>
                    
                    <div id="toggle-collapse" class="panel-collapse collapse">
                        <div class="panel-body">
                            
                            
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h2>View Settings</h2>
                                            <div class="container">
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
									
                                    	<div class="col-sm-6">
                                        
                                        <?php //echo $find_playuser_pic; ?>
                                        
                                        </div>
                                    </div>


                            
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if($totalRows_playuser_pic != 0): ?>
        	<div id="jumbotron-slider">

                    <?php do { ?>
            	
                <!-- JUMBOTRON ITEM - START -->       
                <div class="item">
                        <div class="overlay-wrapper" align="center">
		                	<a href="<?php echo "member/".$row_playuser_pic['user_id']; ?>">
	                            <img src="<?php echo 'data:image/png;base64,'.base64_encode($row_playuser_pic['user_profile_blob']); ?>" class="img-responsive" alt="">
                            </a>
                            <span class="overlay"></span>
                            <button id="<?php echo $row_playuser_pic['user_id']; ?>" type="button" class="btn has-success">Smash</button>
                            <button id="<?php echo $row_playuser_pic['user_id']; ?>" type="button" class="btn has-danger"> Pass </button>
                        </div>
                    </a>
                </div>
                <!-- JUMBOTRON ITEM - END -->     
                    <?php } while ($row_playuser_pic = mysqli_fetch_array($result_playuser_pic)); ?>
                    
                   
                
            </div>
            
             <?php endif; ?>
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
                        
                        <h3>News </h3>
                        
                        <?php
						
						//echo $find_playuser_pic;
						
						 ?> 
                                          
                        <div class="tournament">

                            <div id="profile_pic_block" align="center">
                            <?php if(!$row_user['user_profile_blob']): ?>
    
                        
                                <a><img id="profile_bpic" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
                            
                                
                           <?php else: ?>
    
                                <a rel="clearbox[gallery=Gallery,,width=600,,height=400]" href="<?php if(!$row_user['user_blob_file_path']){ echo 'data:image/png;base64,'.base64_encode($row_user['user_profile_blob']); }else{ echo $row_user['user_blob_file_path']; } ?>">
                                <img id="profile_bpic" src="<?php echo 'data:image/png;base64,'.base64_encode($row_user['user_profile_blob']); ?>" class="img-responsive"  alt="">
                                </a>
    
    
                           
                           <?php endif; ?>
                            
                            </div>                        
                            

                            <div class="team-member">
                                    <ul class="list-unstyled">
                                        <li><strong>NetWorth</strong>$  <?php echo $CountMyOwnNetworth; ?></li>
                                        <li><strong>Liquid Cash:</strong>$ <?php echo $row_user['MyLiquidCash']; ?></li>
                                        <li><strong>'Asset(s): </strong>$  <?php if(!$row_user['SumPlyrassets']){ echo 'N/A'; }else{ echo $row_user['SumPlyrassets']; } ?></li>
		                                <li><strong>Owns:</strong>#  <?php echo  $row_user['CountPlyrsOwned']; ?></li>
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
                        	<li><a class="btn btn-primary active">Everyone <?php echo $totalRows_picthreads.' - '. $totalPages_news_threads; ?></a></li>
                          	<li><a href="/friends"  class="btn btn-primary ">Friends</a></li>
                          	<li><a href="/myassets"  class="btn btn-primary ">Assets</a></li>
                      	</ul>


                        
                     	<div class="team-members-wrapper">
<?php if($news_threads != 0): ?>

<?php  do { ?>



                            
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3">
                                    <?php if($row_news_threads['user_profile_blob']){ ?>
                                    <a href="/thread/<?php echo $row_news_threads['usr_thread_token']; ?>/" class="gallery-photos picaction">
                                     <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row_news_threads['user_profile_blob']); ?>" class="img-responsive center-block img-circle" alt="">
                                    </a>
									<?php }else{ ?>
                                    <img src="assets/images/loading.gif" class="img-responsive center-block img-circle" alt="">
                                    <?php } ?>
                                    </div>
                                    <div class="col-xs-9">
                                        <h2><a target="_parent" href="/member/<?php if($row_news_threads['user_nickname']){ echo $row_news_threads['user_nickname']; }else{ echo $row_news_threads['user_id'];} ?>"><?php echo $row_news_threads['user_nickname']; ?></a><small><?php echo date( "M  Y D", strtotime(  $row_news_threads['user_last_loggedin'] ) ); ?></small></h2>
                                        <p><?php echo $row_news_threads['usr_thread_user_html']; ?></p>
                                        <ul class="brands brands-tn brands-circle brands-colored brands-inline">
                                           <li><a class="brands-facebook pnt"><i class="fa fa-thumbs-up"></i></a></li>
                                            <li><a class="brands-twitter pnt"><i class="fa fa-comment"></i></a></li>
                                            <li><a class="brands-google-plus pnt"><i class="fa fa-bank"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- TEAM MEMBER - END --> 




  
<?php } while ($row_news_threads = mysqli_fetch_array($news_threads)); ?>


<?php  else: ?>









                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><img src="assets/images/blank_profileimg.png" class="img-responsive center-block img-circle" alt=""></div>
                                    <div class="col-xs-9">
                                        <h2>Currently You Have No News</h2>
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
                        	<li><button type="button" class="btn btn-block btn-primary btn-lg active">Load More News</button></li>
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
	<script src="test/Croppie/Croppie-master/Croppie-master/croppie.js"></script>
    
    <script src="assets/js/dropzone.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/news.js"></script>








</body>
</html>
<?php include("_end.mysql.php"); ?>