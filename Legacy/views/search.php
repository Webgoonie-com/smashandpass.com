<?php


include("classes/restrict_login.php");

$member_id  = $url->segment(2);

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


$member_sql = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_id` = '$member_id'";
$member_user_sql = mysqli_query($webgoneGlobal_mysqli, $member_sql);
$found_user = mysqli_fetch_assoc($member_user_sql);
$row_user = mysqli_fetch_assoc($member_user_sql);
$totalRows_found_user = mysqli_num_rows($member_user_sql);



$colname_mbrsearch = "-1";
if (isset($_GET['mbrname'])) {
  $colname_mbrsearch = $_GET['mbrname'];
}
$query_mbrsearch = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `users`.`user_nickname` LIKE '%$colname_mbrsearch%' ORDER BY `user_nickname` ASC LIMIT 25";
$result_mbrsearch = mysqli_query($webgoneGlobal_mysqli, $query_mbrsearch);
$row_mbrsearch = mysqli_fetch_assoc($result_mbrsearch);
$totalRows_mbrsearch = mysqli_num_rows($result_mbrsearch);



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
    <title>Member Search</title>

    <base href="/">    
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


        	
            <div class="row forum-header">
                	<div class="col-sm-2 col-xs-3">
                    	<a href="/play" class="btn btn-primary"><i class="fa fa-edit"></i> Play Smash And Pass</a>
                    </div>
                    <div class="col-sm-10 col-xs-9">
                    
                	</div>
            </div>

  <?php if($totalRows_mbrsearch != 0): ?>


  <?php do { ?>
            
            <!-- FORUM POST - START -->
            <div class="box forum-post-wrapper">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="author-detail">
                            <h3><a class="" href="/member/<?php echo $row_mbrsearch['user_id']; ?>"><?php echo $row_mbrsearch['user_nickname']; ?></a><br /></h3>
                            <p class="function"><?php echo $row_mbrsearch['user_sex']; ?></p>




                            
                            <div class="avatar">
                            <a href="/member/<?php echo $row_mbrsearch['user_id']; ?>">
                            <img src="<?php if(!$row_mbrsearch['user_blob_file_path']){ echo 'assets/images/blank_profileimg.png'; }else{ echo $row_mbrsearch['user_blob_file_path']; } ?>" alt="">
                            </a>
                            </div>
							
                            
                            <ul class="list-unstyled">
                                <li><strong>Networth</strong> <?php echo $row_mbrsearch['user_pointsvalue']; ?></li>
                            </ul>
                            
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <article class="forum-post">
                            <div class="date"><?php echo $row_mbrsearch['user_last_loggedin']; ?></div>
                            <p><?php echo $row_mbrsearch['user_sex']; ?> worth <?php echo $row_mbrsearch['user_pointsvalue']; ?></p>

                            <a class="btn btn-primary" href="/member/<?php echo $row_mbrsearch['user_id']; ?>">View Profile</a>
                        </article>
                    </div>
                </div>
            </div>
            <!-- FORUM POST - END -->
            
            





  
  
  

  
  
  
  <?php } while ($row_mbrsearch = mysqli_fetch_array($result_mbrsearch, MYSQLI_ASSOC)); ?>
  
  
  <?php else: ?>


            <!-- FORUM POST - START -->
            <div class="box forum-post-wrapper">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="author-detail">
                            <h3><a class="">Not Found</a><br /></h3>
                            
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <article class="forum-post">
                            <blockquote>
                                <div class="author">Not Results</div>
                                <h1>Sorry! No Member Found</h1>
                            </blockquote>



                            <a class="btn btn-primary" href="/play">Play Smash And Pass</a>
                        </article>
                    </div>
                </div>
            </div>
            <!-- FORUM POST - END -->
  
  
				
  
  

<?php endif; ?>

                
            </div>
        </section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   <?php include("footer_loggedin.php"); ?>
   <script src="/assets/js/tz/jstz.js"></script>   
   <script src="/assets/js/dropzone.js"></script>
   <script src="/assets/js/member.js"></script>
   <script src="/assets/js/clearbox/clearbox.js"></script>
   
</body>
</html>