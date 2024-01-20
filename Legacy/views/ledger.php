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



$query_user_ledger = "SELECT * FROM 
		`smashan_smashandpass`.`users_ledger_log` 
		left join `smashan_smashandpass`.`users`
		on  `users_ledger_log`.`userledger_log_usr_playerid` = `users`.`user_id`
		WHERE 
		`users_ledger_log`.`userledger_user_id` = '$user_id' 
		ORDER BY 
		`users_ledger_log`.`userledger_log_id` DESC";
$user_ledger = mysqli_query($webgoneGlobal_mysqli, $query_user_ledger);
$row_user_ledger = mysqli_fetch_assoc($user_ledger);
$totalRows_user_ledger = mysqli_num_rows($user_ledger);



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
	
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("views/navbar_loggedin.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    <?php include("views/subfolder/_profile_modals.php"); ?>
    <!-- ==========================
    	TITLE - START 
    =========================== -->
    <div class="container hidden-xs">
    	<div class="header-title">
        	<div class="pull-left">
        		<h2><a href="#"><span class="text-primary">Led</span>ger</a></h2>
                <p>Latest Transactions </p>
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
        	
            <div class="box list-matches">
            	<h2>Recent Transactions</h2>
                <div class="table-responsive">
                    <table class="table table-bordered match">
                        <thead>
                            <tr>
                                <td></td>
                                <td>When</td>
                                <td>Description</td>
                                <td colspan="2" class="text-center">Type | Qty</td>
                                <td class="text-right">Amount</td>
                            </tr>
                        </thead>
                        
                        <tbody>



<?php do { ?>
                            
                            <!-- MATCH - START -->   
                            <tr>
                                <td class="status">
                                    <a id="<?php echo $row_user_ledger['userledger_log_usr_playerid']; ?>"><i class="fa fa-eye"></i></a>
                                </td>
                                <td class="game">
                                    <i class="fa fa-plus"></i>
                                    
                                    <span class="game-date"><?php echo $row_user_ledger['userledger_log_created_at']; ?></span>
                                </td>
                                <td class="team-name left"><?php echo $row_user_ledger['userledger_log_descrp']; ?></td>
                                <td class="team-score"><?php echo $row_user_ledger['userledger_log_typtransc']; ?> <?php echo $row_user_ledger['user_ledger_price']; ?></td>
                                <td class="team-score"><?php  if(!$row_user_ledger['userledger_log_qty']){  echo '1';  }else{ echo $row_user_ledger['userledger_log_qty'];  } ?></td>
                                <td class="team-name right"><?php echo $row_user_ledger['userledger_log_amount']; ?></td>
                            </tr>
                            <tr class="led" style="display:none;">
                              <td colspan="6" class="status ledg_info">

               	<p>
               	  <em>
               	  <?php if($row_user_ledger['show_fullname'] == 1){ echo '<strong>Referenced: </strong>'.$row_user_ledger['user_fname'].' '.$row_user_ledger['user_lname']; }else if($row_user_ledger['user_nickname']){ echo '<strong>Referenced: </strong>'.$row_user_ledger['user_nickname']; } ?>
               	  </em>               	  
                  
                  <?php if($row_user_ledger['user_networth_ply']){ ?>
                  <strong>Worth:</strong> <em><?php echo $row_user_ledger['user_networth_ply']; ?></em>
                  <?php } ?>
                  
                  </p>
                
               <p><strong>Earned:</strong> <?php echo $row_user_ledger['userledger_log_amount']; ?></p>
                              
                              
                              </td>
                            </tr>

                            <!-- MATCH - END -->
  <?php } while ($row_user_ledger = mysqli_fetch_assoc($user_ledger)); ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        	
        	
        </section>
    </div>
    <!-- ==========================
    	CONTENT - END 
    =========================== -->
   
   <?php include("footer_loggedin.php"); ?>
   <script src="assets/js/ledger.js"></script>
</body>
</html>