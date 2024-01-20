<?php


include("classes/restrict_login.php");




$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

// user_id`, `user_token`, `user_emailverify`, `user_nickname`, `user_fname`, `user_lname`, `user_email`, `user_pointsvalue`


mysqli_select_db($webgoneGlobal_mysqli, $database_webgoneGlobal);
$query_user = "SELECT * FROM  `smashan_smashandpass`.`users` WHERE `users`.`user_email` = '$MM_UsernameAgent'";
$user = mysqli_query($webgoneGlobal_mysqli, $query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);
$user_id = $row_user['user_id'];



$user_profile_blob = $row_user['user_profile_blob'];

$user_blob_file_path = $row_user['user_blob_file_path'];


$query_userblob_image_sql = "SELECT  * FROM `smashan_smashandpass`.`user_imgblobs` WHERE `user_imgblobs`.`userblob_users_id` = '$user_id'";
$userblob_image = mysqli_query($webgoneGlobal_mysqli, $query_userblob_image_sql);
$row_userblob_image = mysqli_fetch_assoc($userblob_image);
$totalRows_userblob_image = mysqli_num_rows($userblob_image);




















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
    <title>Add Photo</title>
    
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
<body class="bdy_plain">
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
        
        	<div id="upload_reg_photoblock" class="row" style="display:block;">
            
            	<!-- SIDEBAR - START -->
            	<div class="col-sm-6">
					
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box w idget-wrapper">
                    	<h1>Add A Profile Photo</h1>
                        <p>Uploading a photo makes it easier to smash and pass with new people.</p>
                        <div class="row">
                                                        
                            <div align="center">
                                <div class="col-sm-12">

<div class="img_frame_bx">
			<?php if(!$row_user['user_profile_blob'] && !$row_user['user_blob_file_path'] ){ ?>
                <a href="#"><img id="bpic_frame" src="assets/images/blank_profileimg.png" class="img-responsive" alt=""></a>
            <?php }else if($row_user['user_blob_file_path']){ ?>
				             <a href="#"><img id="bpic_frame" src="<?php echo $row_user['user_blob_file_path']; ?>" class="img-responsive" alt=""></a>
            <?php }else if($row_user['user_profile_blob']){ ?>
				
							<a href="<?php echo $row_user['user_blob_file_path']; ?>">
                            <img id="bpic_frame" src="<?php echo 'data:image/png;base64,'.base64_encode($row_user['user_profile_blob']); ?>" class="img-responsive"  alt="">
                            </a>
                            
               
            <?php } ?>

</div>

                                </div>

						
                            </div>
                            
                            
                            
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-6">
                	<div class="box registration-form">
                    	<h3 align="center">Make Your Profile Photo Easy </h3>
                        <div class="row">
                        		<div>
									<?php //echo $update_new_user_imgblobs_sql; ?>
                                    <img src="<?php //echo 'data:image/png;base64,'.base64_encode($thisraw_image); ?>" class="img-responsive" alt="">
                                    <img src="<?php //echo 'data:image/png;base64,'.base64_encode($user_profile_blob); ?>" class="img-responsive" alt="">
                                </div>

                        </div>
                        <div class="row">
                        <div align="center">
                        <form name="join_uploadphoto" action="single_iphoto" method="post" enctype="multipart/form-data">

							<div class="signup_error">
                            	
                            </div>

							<div id="joina-signup" class="form-group">
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>

								<p><button id="upload_photo" type="button" name="submit1" class="btn dk_green btn-lg btn-block">Upload Photo</Button></p>
								<!--p><button id="join_submit" type="submit" name="submit1" class="btn dk_green btn-lg btn-block">Choose File</button></p -->
                        	</div>
                            

							<div id="joina-signup" class="form-group">
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>
                                <p><a href="/forceset" id="uphoto_skip" class="">Skip For Now! &raquo;&raquo;</a></p>
                        	</div>

                        </form>    
                      </div>
                    	</div>
                    
                    </div>
                    
                    <div class="box registration-form" id="reset-password">

                            <div id="regphotocrop-dropzone" class="form-group">
                            
                            </div>

                        
                    </div>
                </div>
                <!-- CONTENT BODY - END -->
                
            </div>
        


        
        	<div id="crop_reg_photoblock" class="row" style="display:none;">
            
            	<!-- SIDEBAR - START -->
            	<div class="col-sm-6">
					
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box w idget-wrapper">
                    	<h1>Add A Profile Photo</h1>
                        <p>Uploading a photo makes it easier to smash and pass with new people.</p>
                        <div class="row">
                                                        
                            <div align="center">
                                <div class="col-sm-12">

                                    <div id="crop_frame_bx" class="img_frame_bx">
                                                                
                                    </div>

                                </div>

                                <div class="col-sm-12">

									
                                    
                                </div>
						
                            </div>
                            
                            
                            
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-6">
                	<div class="box registration-form">
                    	<h3 align="center">Upload a photo from your device</h3>
                        <div align="center">
                        <form name="join_uploadphoto" action="single_iphoto" method="post" enctype="multipart/form-data">

							<div class="signup_error">
                            	
                            </div>
                            <div class="">

                            </div>

							<div id="joina-signup" class="form-group">
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>

								<p><button id="save_photo" type="button" name="submit1" class="btn dk_green btn-lg btn-block">Save Photo</Button></p>
								<!--p><button id="join_submit" type="submit" name="submit1" class="btn dk_green btn-lg btn-block">Choose File</button></p -->
                        	</div>

							<div id="joina-signup" class="form-group">
                                <p>&nbsp;&nbsp;</p>
                                <p>&nbsp;&nbsp;</p>
                                <p><a href="/profile" id="uphoto_skip" class="">Skip For Now! &raquo;&raquo;</a></p>
                        	</div>

                        </form>    
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
    	JS 
    =========================== -->        
   <?php include("footer_loggedin.php"); ?>

   <script src="assets/js/tz/jstz.js"></script>   
   <script src="assets/js/clearbox/clearbox.js"></script>
	<script src="test/Croppie/Croppie-master/Croppie-master/croppie.js"></script>

   <script src="assets/js/dropzone.js"></script>

   <script src="assets/js/reg_photo.js"></script>

</body>
</html>
<?php include("_end.mysql.php"); ?>