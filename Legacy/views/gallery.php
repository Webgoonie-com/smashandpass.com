<?php
require_once("classes/db_connect.php");


include("classes/restrict_login.php");



?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($webgoneGlobal_mysqli,$theValue) : mysqli_escape_string($webgoneGlobal_mysqli,$theValue);

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




$find_user_query = "SELECT * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `userblob_users_id` = '$user_id'";
$result_ofuser = mysqli_query($webgoneGlobal_mysqli, $find_user_query);
$row_ofuser = mysqli_fetch_assoc($result_ofuser);
$totalRows_ofuser = mysqli_num_rows($result_ofuser);	




$maxRows_news_picthreads = 100;
$pageNum_news_picthreads = 0;
if (isset($_GET['pageNum_news_picthreads'])) {
  $pageNum_news_picthreads = $_GET['pageNum_news_picthreads'];
}
$startRow_news_picthreads = $pageNum_news_picthreads * $maxRows_news_picthreads;

mysqli_select_db($webgoneGlobal_mysqli, $database_webgoonSmash);
$query_news_picthreads = "
SELECT * 
	FROM 
	`smashan_smashandpass`.`user_threads`, `smashan_smashandpass`.`user_picthreads`, `smashan_smashandpass`.`user_imgblobs` 
	WHERE 
		`user_threads`.`usr_thread_id` = `user_picthreads`.`picthread_userblob_id`
			AND
		`user_picthreads`.`picthread_userblob_id` = `user_imgblobs`.`userblob_id` 
	ORDER BY 
		 `user_picthreads`.`picthread_created_at` ASC";
$query_limit_news_picthreads = sprintf("%s LIMIT %d, %d", $query_news_picthreads, $startRow_news_picthreads, $maxRows_news_picthreads);
$news_picthreads = mysqli_query($webgoneGlobal_mysqli, $query_limit_news_picthreads);
$row_news_picthreads = mysqli_fetch_array($news_picthreads);

if (isset($_GET['totalRows_news_picthreads'])) {
  $totalRows_news_picthreads = $_GET['totalRows_news_picthreads'];
} else {
  $all_news_picthreads = mysqli_query($webgoneGlobal_mysqli, $query_news_picthreads);
  $totalRows_news_picthreads = mysqli_num_rows($all_news_picthreads);
}
$totalPages_news_picthreads = ceil($totalRows_news_picthreads/$maxRows_news_picthreads)-1;






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
    <title>Gallery</title>
    
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
        		<h2><a><span class="text-primary">Gal</span>lery</a></h2>
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
                        
                        <h3>Profile <a id="top_btn_photoupload" class="btn btn-primary pull-right btn-sm"><i class="fa fa-camera"></i> Upload Photo</a></h3> 
                                          
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
                                        <li><strong>NetWorth</strong>$9,018,761,980</li>
                                        <li><strong>Liquid:</strong>$1,405,809,771</li>
                                        <li><strong>Property(s):</strong>$1,100,000,030</li>
                                        <li><strong>Asset(s):</strong>$1,100,000,030</li>
                                        <li><strong>Wishers:</strong>4</li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li><strong>Growth Rate</strong>85% Up<i class="fa fa-up"></i></li>
                                    </ul>

                                </div>                            
                            
                            
                            <button class="btn btn-block btn-lg btn-green">Buy Now</button>
                            
                            
                            
                            <h4>&nbsp;</h4>
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches">
                    	<h3>Upcoming matches <a href="matches-list.html" class="btn btn-primary pull-right btn-sm">All matches</a></h3>
                        
                        <a href="match-single.html">
                            <table class="table match-wrapper">
                                <tbody>
                                    <tr>
                                        <td class="game">
                                            <img src="assets/icons/dota2.png" alt="">
                                            <span>Dota 2</span>
                                        </td>
                                        <td class="game-date">
                                            <span>5/10/2015 - 19:30</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/cze.png" alt="">Czech Republic</td>
                                        <td class="team-score">-</td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/swe.png" alt="">Sweden</td>
                                        <td class="team-score">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </a>
                        
                        <a href="match-single.html">
                            <table class="table match-wrapper">
                                <tbody>
                                    <tr>
                                        <td class="game">
                                            <img src="assets/icons/csgo.jpg" alt="">
                                            <span>CS GO</span>
                                        </td>
                                        <td class="game-date">
                                            <span>22/11/2015 - 22:00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/den.png" alt="">Fnatic</td>
                                        <td class="team-score">-</td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/swe.png" alt="">Ninjas in Pyjamas</td>
                                        <td class="team-score">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </a>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper widget-matches">
                        <h3>Latest matches <a href="matches-list.html" class="btn btn-primary pull-right btn-sm">All matches</a></h3>
                        
                        <a href="match-single.html">
                            <table class="table match-wrapper">
                                <tbody>
                                    <tr>
                                        <td class="game">
                                            <img src="assets/icons/lol.png" alt="">
                                            <span>LoL</span>
                                        </td>
                                        <td class="game-date">
                                            <span>18/02/2015 - 14:00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/usa.png" alt=""><b>Ninjas in Pyjamas</b></td>
                                        <td class="team-score win">9</td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/den.png" alt="">Natus Vincere</td>
                                        <td class="team-score lose">5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </a>
                        
                        <a href="match-single.html">
                            <table class="table match-wrapper">
                                <tbody>
                                    <tr>
                                        <td class="game">
                                            <img src="assets/icons/gta.png" alt="">
                                            <span>GTA</span>
                                        </td>
                                        <td class="game-date">
                                            <span>8/6/2015 - 12:00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/swe.png" alt=""><b>Ninjas in Pyjamas</b></td>
                                        <td class="team-score win">9</td>
                                    </tr>
                                    <tr>
                                        <td class="team-name"><img src="assets/icons/usa.png" alt="">Natus Vincere</td>
                                        <td class="team-score lose">5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </a>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper">
                    	<h3>Categories</h3>
                        <ul class="nav nav-sidebar">
                        	<li><a href="#">Tournaments<span>45</span></a></li>
                            <li><a href="#">Leagues<span>122</span></a></li>
                            <li><a href="#">Counter Strike<span>684</span></a></li>
                            <li><a href="#">Dota 2<span>1242</span></a></li>
                            <li><a href="#">World of Warcraft<span>112</span></a></li>
                            <li><a href="#">Minecraft<span>18</span></a></li>
                        </ul>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper">
                    	<h3>Latest Tweets</h3>
                        <div id="twitter-wrapper">
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-8">
                    
                	<div class="box">


                    	<ul class="list-unstyled list-inline team-categories">
                        	<li><a href="" class="btn btn-primary active">Admins</a></li>
                          	<li><a href="" class="btn btn-primary ">Moderators</a></li>
                          	<li><a href="" class="btn btn-primary ">Users</a></li>
                      	</ul>


                        
                     	<div class="team-members-wrapper">
                            
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><img src="assets/images/member-01.jpg" class="img-responsive center-block img-circle" alt=""></div>
                                    <div class="col-xs-9">
                                        <h2>Player nickname<small>John Doe</small></h2>
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


<?php do { ?>
                            <!-- TEAM MEMBER - START -->   
                            <div class="team-member">
                                <div class="row">
                                    <div class="col-xs-3"><img src="assets/images/member-02.jpg" class="img-responsive center-block img-circle" alt=""></div>
                                    <div class="col-xs-9">
                                        <h2>Player nickname<small>John Doe <?php echo $row_news_picthreads['picthread_userblob_id']; ?></small></h2>
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


  
  <?php } while ($row_news_picthreads = mysqli_fetch_array($news_picthreads)); ?>



                            
                    	</div>



                    	

                    </div>
                    
                    <div id="load_morenews" class="box">

						<ul class="list-unstyled list-inline team-categories">
                        	<li><a href="" class="btn btn-primary active">Load More News</a></li>
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
   
	<?php include("footer.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    
    <script src="assets/js/dropzone.js"></script>


</body>
</html>