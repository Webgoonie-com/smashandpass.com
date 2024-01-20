<?php


include("classes/restrict_login.php");



$message_pageurl  = $url->segment(2);


if(!is_numeric($message_pageurl)){

	
	//return;
	$val = 'IS';
	
}else{

	//exit();
	
		$val = 'NOT';
}


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


$query_loop_messages = "SELECT * 
	FROM 
		`smashan_smashandpass`.`user_messages`
	LEFT JOIN 
		`smashan_smashandpass`.`users` ON  
		`users`.`user_id` =  `user_messages`.`usr_message_touser_id` 
	 WHERE 
	 	`user_messages`.`usr_message_touser_id` = '$user_id' 
		
		OR
		`user_messages`.`usr_message_frmuser_id` = '$user_id' 
	 GROUP BY
	 `users`.`user_id`
	ORDER BY 
	`user_messages`.`usr_message_id` DESC

	
	";
$loop_messages = mysqli_query($webgoneGlobal_mysqli, $query_loop_messages);
$row_loop_messages = mysqli_fetch_assoc($loop_messages);
$totalRows_loop_messages = mysqli_num_rows($loop_messages);



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
    <title>Messages</title>

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
        		<h2><a href="index.html"><span class="text-primary">Mes</span>sages</a></h2>
                <p>View your latest private messages here.</p>
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
                            <h3>Messages</h3>
                            <ul class="nav nav-sidebar">
                                <li><a href="/messages">Conversations <span>With <?php echo $totalRows_loop_messages; ?> Members</span></a></li>
                                
                                
                            </ul>
                        </div>
                        <!-- SIDEBAR BOX - END -->
                        
                        
                    </div>
                    <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                    <div class="col-sm-8">
    
                        <div class="box">
                            
                            <div class="row forum-header">                            
                            
                            <div class="col-sm-2 col-xs-3">
                                <h2><a href="#" class="btn btn-primary"><i class="fa fa-edit"></i> Private Messages ( <?php echo $totalRows_loop_messages; ?> )</a></h2>
                            </div>
                            

                            <div class="col-sm-10 col-xs-9">
                                <ul class="pagination">
                                    <li class="disabled"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div>                            

                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered forum-wrapper">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Message</th>
                                            
                                            <th>When?</th>
                                        </tr>
                                    </thead>
                                    <tbody>


  <?php if($totalRows_loop_messages != 0){ do {
	  $usr_message_html = trim(strip_tags($row_loop_messages['usr_message_html']));
 ?>
                                      
                                        <!-- FORUM - START -->
                                        <tr>
                                            <td class="forum-icon">
                                            <a href="message/<?php echo $row_loop_messages['usr_message_touser_id']; ?>"><?php if($row_loop_messages['show_fullname'] == 1){ echo $row_loop_messages['user_fname'].' '.$row_loop_messages['user_lname']; }else if($row_loop_messages['user_nickname']){ echo $row_loop_messages['user_nickname']; }else{ echo $row_loop_messages['user_fname']; } ?>
                                            <br />
                                            <img src="<?php echo $row_loop_messages['user_blob_file_path']; ?>" alt=""></a>
                                            </td>
                                            <td>
                                            <div class="post-detail">
                                            
                                            
												
												 <p><a href="message/<?php echo $row_loop_messages['usr_message_touser_id']; ?>"><?php echo  mb_strimwidth(strtolower($usr_message_html), 0, 80, "<cite title='Source Title'>...</cite>"); ?></a></p>                                                
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <p class="post-detail"><a href="message/<?php echo $row_loop_messages['usr_message_touser_id']; ?>">
                                                <?php echo $row_loop_messages['usr_message_created_at']; ?></a></p>
                                            </td>
                                        </tr>
                                        <!-- FORUM - END -->
  <?php } while ($row_loop_messages = mysqli_fetch_array($loop_messages)); }else{ ?>

                                        
                                        <!-- FORUM - START -->
                                        <tr>
                                            <td class="forum-icon new"><a href="/play"><i class="fa fa-comment"></i></a></td>
                                            <td><a href="/play">Meet New Friends And Play</a></td>
                                            
                                            <td>
                                                <p class="post-detail"><a href="/play"><?php echo date('m/d/Y h:i'); ?></a></p>
                                            </td>
                                        </tr>
                                        <!-- FORUM - END -->

<?php } ?>


                                    </tbody>
                                </table>
                            </div>
                            
                            
                    
                        
                            <div class="row forum-header forum-footer">
                                <div class="col-sm-2 col-xs-3">
                                    <a href="/news" class="btn btn-primary"><i class="fa fa-edit"></i> New Thread</a>
                                </div>
                                <div class="col-sm-10 col-xs-9">
                                    <ul class="pagination">
                                        <li class="disabled"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
        
                        </div><!-- endview -->
                
                    </div>
                
			</div>
     	</section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   
	<?php include("views/footer_loggedin.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    
    <script src="assets/js/dropzone.js"></script>


</body>
</html>