<?php


include("classes/restrict_login.php");



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
    <title>Settings</title>
    
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
    <h1>&nbsp;</h1>
	
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("views/navbar_blank.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container hidden-xs">
    	<div class="header-title">
        	<div class="pull-left">
        		<h2><a href="index.html"><span class="text-primary">Pro</span>gaming</a></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            </div>
        </div>
    </div>
    <!-- ==========================
    	TITLE - END 
    =========================== -->








<div class="col-md-6 col-xs-6 box" align="left">
                    	
                        
                        <div class="row">
                        <span class="pull-right"> <button class="btn btn-default popup-modal-dismiss pull-right" type="button">Close</button> </span>
                        
                        <h5><span style="color:#00F; text-decoration:underline;"><?php echo $row_ofuser['user_nickname']; ?></span></h5>
                        <h6><strong>Published:</strong> <?php echo $row_ofuser['userblob_image_created_at']; ?></h6>
                        
                        <hr />



                <!-- COMMENT WRAPPER - START -->
                <div class="comments">
                    <ol class="commentlist">

							<?php if($totalRows_picthread != 0): do{ ?>
                            
                                        
                            
                    
                        <!-- COMMENT - START -->
                        <li id="<?php echo $row_picthread['picthread_id']; ?>" class="comment picthread">
                            <div class="avatar"><img src="assets/images/user.jpg" alt=""></div>
                            <div class="comment-body">
                                <div class="author">
                                    <h3>John Doe</h3>
                                    <div class="meta"><span class="date" title="2015-01-29 20:16:04">2015-01-29 20:16:04</span></div>
                                </div>      
                                <p class="message comtext"><?php echo $row_picthread['picthread_comtext']; ?></p>
                                <div class="reply"><a id="<?php echo $row_picthread['picthread_id']; ?>"><i class="fa fa-reply"></i>Reply</a></div>
                            </div>
                        </li>
                        <!-- COMMENT - END -->

                            <?php } while ($row_picthread = mysqli_fetch_array($result_picthread)); endif; ?>
                        
                        
                        
                    </ol>    
                </div>
                <!-- COMMENT WRAPPER - START -->
                
                        
                            
                        </div>
                        <div class="row">
                        	<div>

                                        <!-- COMMENT FORM - END --> 
                                        <div id="respond" class="box comment-respond">
                                            <form method="post" id="commentform" class="comment-form">
                                                <div id="<?php echo $userblob_users_id;  ?>" class="form-group comment-form-comment">
                                                  <label id="<?php echo	$picthread_userblob_id; ?>" for="comment">Comment on this pic<span class="required">*</span></label>
                                                    <textarea name="pic_comment" rows="2" class="form-control" id="pic_comment" placeholder='Comment...' aria-required="true"></textarea>
                                                </div>												
                                                <button id="submit_pubcomment" class="btn btn-primary" type="button">Submit</button>
                                                
                                               				
                                            </form>
                                        </div>
                                        <!-- COMMENT FORM - END -->  

					 
                            </div>
                                                   

                        </div>
                        
                        
                    </div>



















            
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container">
        <section class="content-wrapper">
        	<div class="box">
                            
                <!-- ERROR - START -->
                <div class="error">
                	<h2>Error 404 - Page not found</h2>
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam auctor dictum nibh, ac gravida orci porttitor et. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.</p>
                	<a href="index.html" class="btn btn-primary btn-lg">Back to Homepage</a>
                </div>
                <!-- ERROR - END -->
                
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