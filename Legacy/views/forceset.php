<?php
require_once("classes/db_connect.php");


include("classes/restrict_login.php");





$MM_UsernameAgent = $_SESSION['MM_UsernameAgent'];

$query_user = "SELECT * FROM `smashan_smashandpass`.`users` WHERE `user_email` = '$MM_UsernameAgent'";
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
    
    <?php //include("views/navbar_blank.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container hidden-xs">
    	<div class="header-title">
        	<div class="pull-left">
        		<h2><a><span class="text-primary">Set</span>tings</a></h2>
                <p>Below are some things that we need to know before you proceed any futher.</p>
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
        	<div class="box">
                <div class="row">
                <!-- ERROR - START -->
                <div class="" style="padding: 10px">
                	<h2>Get Ready To Splash</h2>
                	<p><strong>Smash And Pass</strong> is a great way to hook up with new people.
To begin playing, please tell us a little more about yourself.</p>
					<p>Adjust your settings below to personalize your experience and have other find you as well.</p>
                </div>
                <!-- ERROR - END -->
                
   				</div>             
                <div class="row">
         
         
          
         
				<div class="error">

                    <div class="col-sm-12" style="padding-left:60px; padding-right:60px;">
                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">Choose The Correct Settings Below</h3>
                                <div id="commentform" class="comment-form">
                                    
                                    
                                                <div class="form-group comment-form-comment">
                                                    <label for="view_iama">I am a: <?php echo $row_user['user_view_iama']; ?></label>
                                                    <select class="form-control" id="view_iama">
                                                    <option value="Male" <?php if (!(strcmp("Male", $row_user['user_view_iama']))) {echo "selected=\"selected\"";} ?>>Male</option>
                                                    <option value="Female" <?php if (!(strcmp("Female", $row_user['user_view_iama']))) {echo "selected=\"selected\"";} ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group comment-form-comment">
                                                    <label for="view_letmeview">Let me view:</label>
                                                    <select class="form-control" id="view_letmeview">

                                                    <option value="Female" <?php if (!(strcmp("Female", $row_user['user_view_letmeview']))) {echo "selected=\"selected\"";} ?>>Females</option>
                                                    <option value="Male" <?php if (!(strcmp("Male", $row_user['user_view_letmeview']))){echo "selected=\"selected\"";} ?>>Males</option>
                                                    </select>
    
                                                </div>


                                                <div class="form-group comment-form-comment">
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
    
    
    
                                                <div class="form-group comment-form-author">
                                                    <label for="orientation">Orientation<span class="required">*</span></label>
                                                            <select id="orientation" name="orientation" class="form-control">
                                                              <option value="">Select Orientation Preference?</option>
                                                              <option value="Straight" <?php if (!(strcmp("Male", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Straight</option>
                                                              <option value="Gay" <?php if (!(strcmp("Male", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Gay</option>
                                                              <option value="Bisexual" <?php if (!(strcmp("Male", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Bisexual</option>
                                                            </select>                                    
                                                    
                                                </div>
    
    
                                              <div class="form-group comment-form-comment">
                                                <label for="view_zipcode">Zip Code</label>
                                                  <input type="text" class="form-control" id="view_zipcode" value="<?php echo $row_user['user_view_zipcode']; ?>" placeholder="Enter zipcode">
                                                </div>
                                    
                                    
                                    <button id="save_foresettings" class="btn btn-primary btn-block" type="button"><i class="fa fa-floppy-o"></i> Save Settings</button>					
                                </div>
                            </div>         
                    </div>
         		</div>


        </div>
                
                
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


	<script>
    
    
    $(document).on('click', 'button#save_foresettings', function(){
	
				var user_id = $('input#user_id').val();
				var usr_cookie = $('input#usr_cookie').val();
				var view_iama = $('select#view_iama').val();
				var view_letmeview = $('select#view_letmeview').val();
				var view_agerange = $('select#view_agerange').val();
				var view_zipcode = $('input#view_zipcode').val();
		
				$.post('models/script_record_playersettings.php', {
							user_id: user_id,
							usr_cookie: usr_cookie,
							view_iama: view_iama,
							view_letmeview: view_letmeview,
							view_agerange: view_agerange,
							view_zipcode: view_zipcode	
				}, function(data){
					console.log(data);			
					$('div#console_debug').html(data);
					//$(this).parent().closest('div.playmatch-feat').hide();
					
				});

	
	
	});
    
    
    </script>

</body>
</html>