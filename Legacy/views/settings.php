<?php


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
                <div style="padding:10px;">
                	<h2>Get Ready To Splash</h2>
                	<p><strong>Smash And Pass</strong> is a great way to hook up with new people.
To begin playing, please tell us a little more about yourself.</p>
                            <hr />

                </div>
                <!-- ERROR - END -->
                
   				</div>             
                
                <div class="row">
  <div class="">
    <div class="col-sm-12" style="padding-left:60px; padding-right:60px;">
      <div id="respond" class="comment-respond">
        <h3 id="reply-title" class="">Enter And Choose The Correct Settings Below</h3>
        <div id="commentform" class="comment-form">
          <div class="row" style="display:none; visibility:hidden;">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="my_displayname">Display Name</label>
                <br />
                <input  type="hidden"id="my_displayname" class="form-control" name="my_displayname" value="<?php echo $row_user['user_nickname']; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="m-t-10">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="join_fname">First Name</label>
                  <br />
                  <input type="text" class="form-control" id="join_fname" placeholder="First Name" value="<?php echo $row_user['user_fname']; ?>">
                </div>
                <div class="form-group">
                  <label for="join_lname">Last Name</label>
                  <br />
                  <input type="text" class="form-control" id="join_lname" placeholder="Last Name" value="<?php echo $row_user['user_lname']; ?>">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="show_fullname">Show/Hide Full Name</label>
                  <br />
                  <select class="form-control" id="show_fullname">
                    <option value="0" <?php if (!(strcmp(0, $row_user['show_fullname']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                    <option value="1" <?php if (!(strcmp(1, $row_user['show_fullname']))) {echo "selected=\"selected\"";} ?>>Show</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="my_gender">Gender</label>
                <select id="my_gender" class="form-control" name="my_gender">
                  <option value="">Select One</option>
                  <option value="M" <?php if (!(strcmp("M", $row_user['user_sex']))) {echo "selected=\"selected\"";} ?>>Male</option>
                  <option value="F" <?php if (!(strcmp("F", $row_user['user_sex']))) {echo "selected=\"selected\"";} ?>>Female</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-inline">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="my_birth_month">Month</label>
                  <br />
                  <select id="my_birth_month" class="form-control" name="my_birthdate_month">
                    <option value="-1" <?php if (!(strcmp(-1, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>Select Month</option>
                    <option value="1" <?php if (!(strcmp(1, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>January</option>
                    <option value="2" <?php if (!(strcmp(2, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>February</option>
                    <option value="3" <?php if (!(strcmp(3, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>March</option>
                    <option value="4" <?php if (!(strcmp(4, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>April</option>
                    <option value="5" <?php if (!(strcmp(5, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>May</option>
                    <option value="6" <?php if (!(strcmp(6, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>June</option>
                    <option value="7" <?php if (!(strcmp(7, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>July</option>
                    <option value="8" <?php if (!(strcmp(8, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>August</option>
                    <option value="9" <?php if (!(strcmp(9, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>September</option>
                    <option value="10" <?php if (!(strcmp(10, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>October</option>
                    <option value="11" <?php if (!(strcmp(11, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>November</option>
                    <option value="12" <?php if (!(strcmp(12, $row_user['user_bdaymonth']))) {echo "selected=\"selected\"";} ?>>December</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="my_birth_day">Day</label>
                  <br />
                  <div id="day" rel="birthdate">
                    <select id="my_birth_day" class="form-control" name="my_birthdate_day">
                      <option value="">Select Day</option>
                      <option value="1" <?php if (!(strcmp(1, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>1</option>
                      <option value="2" <?php if (!(strcmp(2, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>2</option>
                      <option value="3" <?php if (!(strcmp(3, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>3</option>
                      <option value="4" <?php if (!(strcmp(4, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>4</option>
                      <option value="5" <?php if (!(strcmp(5, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>5</option>
                      <option value="6" <?php if (!(strcmp(6, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>6</option>
                      <option value="7" <?php if (!(strcmp(7, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>7</option>
                      <option value="8" <?php if (!(strcmp(8, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>8</option>
                      <option value="9" <?php if (!(strcmp(9, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>9</option>
                      <option value="10" <?php if (!(strcmp(10, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>10</option>
                      <option value="11" <?php if (!(strcmp(11, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>11</option>
                      <option value="12" <?php if (!(strcmp(12, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>12</option>
                      <option value="13" <?php if (!(strcmp(13, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>13</option>
                      <option value="14" <?php if (!(strcmp(14, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>14</option>
                      <option value="15" <?php if (!(strcmp(15, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>15</option>
                      <option value="16" <?php if (!(strcmp(16, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>16</option>
                      <option value="17" <?php if (!(strcmp(17, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>17</option>
                      <option value="18" <?php if (!(strcmp(18, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>18</option>
                      <option value="19" <?php if (!(strcmp(19, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>19</option>
                      <option value="20" <?php if (!(strcmp(20, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>20</option>
                      <option value="21" <?php if (!(strcmp(21, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>21</option>
                      <option value="22" <?php if (!(strcmp(22, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>22</option>
                      <option value="23" <?php if (!(strcmp(23, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>23</option>
                      <option value="24" <?php if (!(strcmp(24, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>24</option>
                      <option value="25" <?php if (!(strcmp(25, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>25</option>
                      <option value="26" <?php if (!(strcmp(26, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>26</option>
                      <option value="27" <?php if (!(strcmp(27, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>27</option>
                      <option value="28" <?php if (!(strcmp(28, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>28</option>
                      <option value="29" <?php if (!(strcmp(29, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>29</option>
                      <option value="30" <?php if (!(strcmp(30, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>30</option>
                      <option value="31" <?php if (!(strcmp(31, $row_user['user_bdayday']))) {echo "selected=\"selected\"";} ?>>31</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="my_birth_year">Birth Year</label>
                  <br />
                  <select id="my_birth_year" class="form-control" name="my_birth_year">
                    <option value="-1" <?php if (!(strcmp(-1, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>Select Year</option>
                    <option value="1999" <?php if (!(strcmp(1999, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1999</option>
                    <option value="1998" <?php if (!(strcmp(1998, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1998</option>
                    <option value="1997" <?php if (!(strcmp(1997, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1997</option>
                    <option value="1996" <?php if (!(strcmp(1996, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1996</option>
                    <option value="1995" <?php if (!(strcmp(1995, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1995</option>
                    <option value="1994" <?php if (!(strcmp(1994, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1994</option>
                    <option value="1993" <?php if (!(strcmp(1993, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1993</option>
                    <option value="1992" <?php if (!(strcmp(1992, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1992</option>
                    <option value="1991" <?php if (!(strcmp(1991, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1991</option>
                    <option value="1990" <?php if (!(strcmp(1990, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1990</option>
                    <option value="1989" <?php if (!(strcmp(1989, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1989</option>
                    <option value="1988" <?php if (!(strcmp(1988, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1988</option>
                    <option value="1987" <?php if (!(strcmp(1987, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1987</option>
                    <option value="1986" <?php if (!(strcmp(1986, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1986</option>
                    <option value="1985" <?php if (!(strcmp(1985, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1985</option>
                    <option value="1984" <?php if (!(strcmp(1984, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1984</option>
                    <option value="1983" <?php if (!(strcmp(1983, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1983</option>
                    <option value="1982" <?php if (!(strcmp(1982, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1982</option>
                    <option value="1981" <?php if (!(strcmp(1981, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1981</option>
                    <option value="1980" <?php if (!(strcmp(1980, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1980</option>
                    <option value="1979" <?php if (!(strcmp(1979, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1979</option>
                    <option value="1978" <?php if (!(strcmp(1978, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1978</option>
                    <option value="1977" <?php if (!(strcmp(1977, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1977</option>
                    <option value="1976" <?php if (!(strcmp(1976, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1976</option>
                    <option value="1975" <?php if (!(strcmp(1975, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1975</option>
                    <option value="1974" <?php if (!(strcmp(1974, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1974</option>
                    <option value="1973" <?php if (!(strcmp(1973, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1973</option>
                    <option value="1972" <?php if (!(strcmp(1972, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1972</option>
                    <option value="1971" <?php if (!(strcmp(1971, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1971</option>
                    <option value="1970" <?php if (!(strcmp(1970, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1970</option>
                    <option value="1969" <?php if (!(strcmp(1969, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1969</option>
                    <option value="1968" <?php if (!(strcmp(1968, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1968</option>
                    <option value="1967" <?php if (!(strcmp(1967, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1967</option>
                    <option value="1966" <?php if (!(strcmp(1966, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1966</option>
                    <option value="1965" <?php if (!(strcmp(1965, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1965</option>
                    <option value="1964" <?php if (!(strcmp(1964, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1964</option>
                    <option value="1963" <?php if (!(strcmp(1963, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1963</option>
                    <option value="1962" <?php if (!(strcmp(1962, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1962</option>
                    <option value="1961" <?php if (!(strcmp(1961, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1961</option>
                    <option value="1960" <?php if (!(strcmp(1960, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1960</option>
                    <option value="1959" <?php if (!(strcmp(1959, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1959</option>
                    <option value="1958" <?php if (!(strcmp(1958, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1958</option>
                    <option value="1957" <?php if (!(strcmp(1957, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1957</option>
                    <option value="1956" <?php if (!(strcmp(1956, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1956</option>
                    <option value="1955" <?php if (!(strcmp(1955, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1955</option>
                    <option value="1954" <?php if (!(strcmp(1954, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1954</option>
                    <option value="1953" <?php if (!(strcmp(1953, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1953</option>
                    <option value="1952" <?php if (!(strcmp(1952, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1952</option>
                    <option value="1951" <?php if (!(strcmp(1951, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1951</option>
                    <option value="1950" <?php if (!(strcmp(1950, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1950</option>
                    <option value="1949" <?php if (!(strcmp(1949, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1949</option>
                    <option value="1948" <?php if (!(strcmp(1948, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1948</option>
                    <option value="1947" <?php if (!(strcmp(1947, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1947</option>
                    <option value="1946" <?php if (!(strcmp(1946, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1946</option>
                    <option value="1945" <?php if (!(strcmp(1945, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1945</option>
                    <option value="1944" <?php if (!(strcmp(1944, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1944</option>
                    <option value="1943" <?php if (!(strcmp(1943, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1943</option>
                    <option value="1942" <?php if (!(strcmp(1942, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1942</option>
                    <option value="1941" <?php if (!(strcmp(1941, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1941</option>
                    <option value="1940" <?php if (!(strcmp(1940, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1940</option>
                    <option value="1939" <?php if (!(strcmp(1939, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1939</option>
                    <option value="1938" <?php if (!(strcmp(1938, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1938</option>
                    <option value="1937" <?php if (!(strcmp(1937, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1937</option>
                    <option value="1936" <?php if (!(strcmp(1936, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1936</option>
                    <option value="1935" <?php if (!(strcmp(1935, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1935</option>
                    <option value="1934" <?php if (!(strcmp(1934, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1934</option>
                    <option value="1933" <?php if (!(strcmp(1933, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1933</option>
                    <option value="1932" <?php if (!(strcmp(1932, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1932</option>
                    <option value="1931" <?php if (!(strcmp(1931, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1931</option>
                    <option value="1930" <?php if (!(strcmp(1930, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1930</option>
                    <option value="1929" <?php if (!(strcmp(1929, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1929</option>
                    <option value="1928" <?php if (!(strcmp(1928, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1928</option>
                    <option value="1927" <?php if (!(strcmp(1927, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1927</option>
                    <option value="1926" <?php if (!(strcmp(1926, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1926</option>
                    <option value="1925" <?php if (!(strcmp(1925, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1925</option>
                    <option value="1924" <?php if (!(strcmp(1924, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1924</option>
                    <option value="1923" <?php if (!(strcmp(1923, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1923</option>
                    <option value="1922" <?php if (!(strcmp(1922, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1922</option>
                    <option value="1921" <?php if (!(strcmp(1921, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1921</option>
                    <option value="1920" <?php if (!(strcmp(1920, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1920</option>
                    <option value="1919" <?php if (!(strcmp(1919, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1919</option>
                    <option value="1918" <?php if (!(strcmp(1918, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1918</option>
                    <option value="1917" <?php if (!(strcmp(1917, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1917</option>
                    <option value="1916" <?php if (!(strcmp(1916, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1916</option>
                    <option value="1915" <?php if (!(strcmp(1915, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1915</option>
                    <option value="1914" <?php if (!(strcmp(1914, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1914</option>
                    <option value="1913" <?php if (!(strcmp(1913, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1913</option>
                    <option value="1912" <?php if (!(strcmp(1912, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1912</option>
                    <option value="1911" <?php if (!(strcmp(1911, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1911</option>
                    <option value="1910" <?php if (!(strcmp(1910, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1910</option>
                    <option value="1909" <?php if (!(strcmp(1909, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1909</option>
                    <option value="1908" <?php if (!(strcmp(1908, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1908</option>
                    <option value="1907" <?php if (!(strcmp(1907, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1907</option>
                    <option value="1906" <?php if (!(strcmp(1906, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1906</option>
                    <option value="1905" <?php if (!(strcmp(1905, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1905</option>
                    <option value="1904" <?php if (!(strcmp(1904, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1904</option>
                    <option value="1903" <?php if (!(strcmp(1903, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1903</option>
                    <option value="1902" <?php if (!(strcmp(1902, $row_user['user_bdayyear']))) {echo "selected=\"selected\"";} ?>>1902</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="m-t-15">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="my_zipcode">Zip Code</label>
                  <br />
                  <input type="text" class="form-control" id="my_zipcode" placeholder="Postal/Zip Code" value="<?php echo $row_user['user_zipcode']; ?>">
                </div>
                <div class="form-group">
                  <label for="my_country">Country</label>
                  <br />
                  <select class="form-control" id="my_country">
                    <option value="US" title="United States" <?php if (!(strcmp("US", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>United States</option>
                    <option value="AU" title="Australia" <?php if (!(strcmp("AU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Australia</option>
                    <option value="CA" title="Canada" <?php if (!(strcmp("CA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Canada</option>
                    <option value="GB" title="United Kingdom" <?php if (!(strcmp("GB", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>United Kingdom</option>
                    <option value="AX" title="Aaland Islands" <?php if (!(strcmp("AX", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Aaland Islands</option>
                    <option value="AF" title="Afghanistan" <?php if (!(strcmp("AF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Afghanistan</option>
                    <option value="AL" title="Albania" <?php if (!(strcmp("AL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Albania</option>
                    <option value="DZ" title="Algeria" <?php if (!(strcmp("DZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Algeria</option>
                    <option value="AS" title="American Samoa" <?php if (!(strcmp("AS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>American Samoa</option>
                    <option value="AD" title="Andorra" <?php if (!(strcmp("AD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Andorra</option>
                    <option value="AO" title="Angola" <?php if (!(strcmp("AO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Angola</option>
                    <option value="AI" title="Anguilla" <?php if (!(strcmp("AI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Anguilla</option>
                    <option value="AQ" title="Antarctica" <?php if (!(strcmp("AQ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Antarctica</option>
                    <option value="AG" title="Antigua and Barbuda" <?php if (!(strcmp("AG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Antigua and Barbuda</option>
                    <option value="AR" title="Argentina" <?php if (!(strcmp("AR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Argentina</option>
                    <option value="AM" title="Armenia" <?php if (!(strcmp("AM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Armenia</option>
                    <option value="AW" title="Aruba" <?php if (!(strcmp("AW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Aruba</option>
                    <option value="AU" title="Australia" <?php if (!(strcmp("AU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Australia</option>
                    <option value="AT" title="Austria" <?php if (!(strcmp("AT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Austria</option>
                    <option value="AZ" title="Azerbaijan" <?php if (!(strcmp("AZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Azerbaijan</option>
                    <option value="BH" title="Bahrain" <?php if (!(strcmp("BH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bahrain</option>
                    <option value="BD" title="Bangladesh" <?php if (!(strcmp("BD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bangladesh</option>
                    <option value="BB" title="Barbados" <?php if (!(strcmp("BB", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Barbados</option>
                    <option value="BY" title="Belarus" <?php if (!(strcmp("BY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Belarus</option>
                    <option value="BE" title="Belgium" <?php if (!(strcmp("BE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Belgium</option>
                    <option value="BZ" title="Belize" <?php if (!(strcmp("BZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Belize</option>
                    <option value="BJ" title="Benin" <?php if (!(strcmp("BJ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Benin</option>
                    <option value="BM" title="Bermuda" <?php if (!(strcmp("BM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bermuda</option>
                    <option value="BT" title="Bhutan" <?php if (!(strcmp("BT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bhutan</option>
                    <option value="BO" title="Bolivia" <?php if (!(strcmp("BO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bolivia</option>
                    <option value="BQ" title="Bonaire, Sint Eustatius and Saba" <?php if (!(strcmp("BQ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA" title="Bosnia and Herzegovina" <?php if (!(strcmp("BA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bosnia and Herzegovina</option>
                    <option value="BW" title="Botswana" <?php if (!(strcmp("BW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Botswana</option>
                    <option value="BV" title="Bouvet Island" <?php if (!(strcmp("BV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bouvet Island</option>
                    <option value="BR" title="Brazil" <?php if (!(strcmp("BR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Brazil</option>
                    <option value="IO" title="British Indian Ocean Territory" <?php if (!(strcmp("IO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>British Indian Ocean Territory</option>
                    <option value="VG" title="British Virgin Islands" <?php if (!(strcmp("VG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>British Virgin Islands</option>
                    <option value="BN" title="Brunei" <?php if (!(strcmp("BN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Brunei</option>
                    <option value="BG" title="Bulgaria" <?php if (!(strcmp("BG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Bulgaria</option>
                    <option value="BF" title="Burkina Faso" <?php if (!(strcmp("BF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Burkina Faso</option>
                    <option value="BI" title="Burundi" <?php if (!(strcmp("BI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Burundi</option>
                    <option value="KH" title="Cambodia" <?php if (!(strcmp("KH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cambodia</option>
                    <option value="CM" title="Cameroon" <?php if (!(strcmp("CM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cameroon</option>
                    <option value="CA" title="Canada" <?php if (!(strcmp("CA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Canada</option>
                    <option value="CV" title="Cape Verde" <?php if (!(strcmp("CV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cape Verde</option>
                    <option value="KY" title="Cayman Islands" <?php if (!(strcmp("KY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cayman Islands</option>
                    <option value="CF" title="Central African Republic" <?php if (!(strcmp("CF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Central African Republic</option>
                    <option value="TD" title="Chad" <?php if (!(strcmp("TD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Chad</option>
                    <option value="CL" title="Chile" <?php if (!(strcmp("CL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Chile</option>
                    <option value="CN" title="China" <?php if (!(strcmp("CN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>China</option>
                    <option value="CX" title="Christmas Island" <?php if (!(strcmp("CX", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Christmas Island</option>
                    <option value="CC" title="Cocos (Keeling) Islands" <?php if (!(strcmp("CC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cocos (Keeling) Islands</option>
                    <option value="CO" title="Colombia" <?php if (!(strcmp("CO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Colombia</option>
                    <option value="KM" title="Comoros" <?php if (!(strcmp("KM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Comoros</option>
                    <option value="CG" title="Congo (Brazzaville)" <?php if (!(strcmp("CG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Congo (Brazzaville)</option>
                    <option value="CD" title="Congo (Kinshasa)" <?php if (!(strcmp("CD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Congo (Kinshasa)</option>
                    <option value="CK" title="Cook Islands" <?php if (!(strcmp("CK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cook Islands</option>
                    <option value="CR" title="Costa Rica" <?php if (!(strcmp("CR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Costa Rica</option>
                    <option value="CI" title="Cote D'Ivoire" <?php if (!(strcmp("CI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cote D'Ivoire</option>
                    <option value="HR" title="Croatia" <?php if (!(strcmp("HR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Croatia</option>
                    <option value="CU" title="Cuba" <?php if (!(strcmp("CU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cuba</option>
                    <option value="CW" title="Curacao" <?php if (!(strcmp("CW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Curacao</option>
                    <option value="CY" title="Cyprus" <?php if (!(strcmp("CY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Cyprus</option>
                    <option value="CZ" title="Czech Republic" <?php if (!(strcmp("CZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Czech Republic</option>
                    <option value="DK" title="Denmark" <?php if (!(strcmp("DK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Denmark</option>
                    <option value="DJ" title="Djibouti" <?php if (!(strcmp("DJ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Djibouti</option>
                    <option value="DM" title="Dominica" <?php if (!(strcmp("DM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Dominica</option>
                    <option value="DO" title="Dominican Republic" <?php if (!(strcmp("DO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Dominican Republic</option>
                    <option value="TL" title="East Timor" <?php if (!(strcmp("TL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>East Timor</option>
                    <option value="EC" title="Ecuador" <?php if (!(strcmp("EC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Ecuador</option>
                    <option value="EG" title="Egypt" <?php if (!(strcmp("EG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Egypt</option>
                    <option value="SV" title="El Salvador" <?php if (!(strcmp("SV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>El Salvador</option>
                    <option value="GQ" title="Equatorial Guinea" <?php if (!(strcmp("GQ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Equatorial Guinea</option>
                    <option value="ER" title="Eritrea" <?php if (!(strcmp("ER", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Eritrea</option>
                    <option value="EE" title="Estonia" <?php if (!(strcmp("EE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Estonia</option>
                    <option value="ET" title="Ethiopia" <?php if (!(strcmp("ET", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Ethiopia</option>
                    <option value="FK" title="Falkland Islands (Islas Malvinas)" <?php if (!(strcmp("FK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Falkland Islands (Islas Malvinas)</option>
                    <option value="FO" title="Faroe Islands" <?php if (!(strcmp("FO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Faroe Islands</option>
                    <option value="FJ" title="Fiji" <?php if (!(strcmp("FJ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Fiji</option>
                    <option value="FI" title="Finland" <?php if (!(strcmp("FI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Finland</option>
                    <option value="FR" title="France" <?php if (!(strcmp("FR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>France</option>
                    <option value="GF" title="French Guiana" <?php if (!(strcmp("GF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>French Guiana</option>
                    <option value="PF" title="French Polynesia" <?php if (!(strcmp("PF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>French Polynesia</option>
                    <option value="TF" title="French Southern and Antarctic Lands" <?php if (!(strcmp("TF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>French Southern and Antarctic Lands</option>
                    <option value="GA" title="Gabon" <?php if (!(strcmp("GA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Gabon</option>
                    <option value="GE" title="Georgia" <?php if (!(strcmp("GE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Georgia</option>
                    <option value="DE" title="Germany" <?php if (!(strcmp("DE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Germany</option>
                    <option value="GH" title="Ghana" <?php if (!(strcmp("GH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Ghana</option>
                    <option value="GI" title="Gibraltar" <?php if (!(strcmp("GI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Gibraltar</option>
                    <option value="GR" title="Greece" <?php if (!(strcmp("GR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Greece</option>
                    <option value="GL" title="Greenland" <?php if (!(strcmp("GL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Greenland</option>
                    <option value="GD" title="Grenada" <?php if (!(strcmp("GD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Grenada</option>
                    <option value="GP" title="Guadeloupe" <?php if (!(strcmp("GP", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guadeloupe</option>
                    <option value="GU" title="Guam" <?php if (!(strcmp("GU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guam</option>
                    <option value="GT" title="Guatemala" <?php if (!(strcmp("GT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guatemala</option>
                    <option value="GN" title="Guinea" <?php if (!(strcmp("GN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guinea</option>
                    <option value="GW" title="Guinea-Bissau" <?php if (!(strcmp("GW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guinea-Bissau</option>
                    <option value="GY" title="Guyana" <?php if (!(strcmp("GY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Guyana</option>
                    <option value="HT" title="Haiti" <?php if (!(strcmp("HT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Haiti</option>
                    <option value="HM" title="Heard Island and McDonald Islands" <?php if (!(strcmp("HM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Heard Island and McDonald Islands</option>
                    <option value="VA" title="Holy See (Vatican City)" <?php if (!(strcmp("VA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Holy See (Vatican City)</option>
                    <option value="HN" title="Honduras" <?php if (!(strcmp("HN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Honduras</option>
                    <option value="HK" title="Hong Kong" <?php if (!(strcmp("HK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Hong Kong</option>
                    <option value="HU" title="Hungary" <?php if (!(strcmp("HU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Hungary</option>
                    <option value="IS" title="Iceland" <?php if (!(strcmp("IS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Iceland</option>
                    <option value="IN" title="India" <?php if (!(strcmp("IN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>India</option>
                    <option value="ID" title="Indonesia" <?php if (!(strcmp("ID", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Indonesia</option>
                    <option value="IR" title="Iran" <?php if (!(strcmp("IR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Iran</option>
                    <option value="IQ" title="Iraq" <?php if (!(strcmp("IQ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Iraq</option>
                    <option value="IE" title="Ireland" <?php if (!(strcmp("IE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Ireland</option>
                    <option value="IL" title="Israel" <?php if (!(strcmp("IL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Israel</option>
                    <option value="IT" title="Italy" <?php if (!(strcmp("IT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Italy</option>
                    <option value="JM" title="Jamaica" <?php if (!(strcmp("JM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Jamaica</option>
                    <option value="JP" title="Japan" <?php if (!(strcmp("JP", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Japan</option>
                    <option value="JO" title="Jordan" <?php if (!(strcmp("JO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Jordan</option>
                    <option value="KZ" title="Kazakhstan" <?php if (!(strcmp("KZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kazakhstan</option>
                    <option value="KE" title="Kenya" <?php if (!(strcmp("KE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kenya</option>
                    <option value="KI" title="Kiribati" <?php if (!(strcmp("KI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kiribati</option>
                    <option value="XK" title="Kosovo" <?php if (!(strcmp("XK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kosovo</option>
                    <option value="KW" title="Kuwait" <?php if (!(strcmp("KW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kuwait</option>
                    <option value="KG" title="Kyrgyzstan" <?php if (!(strcmp("KG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Kyrgyzstan</option>
                    <option value="LA" title="Laos" <?php if (!(strcmp("LA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Laos</option>
                    <option value="LV" title="Latvia" <?php if (!(strcmp("LV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Latvia</option>
                    <option value="LB" title="Lebanon" <?php if (!(strcmp("LB", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Lebanon</option>
                    <option value="LS" title="Lesotho" <?php if (!(strcmp("LS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Lesotho</option>
                    <option value="LR" title="Liberia" <?php if (!(strcmp("LR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Liberia</option>
                    <option value="LY" title="Libya" <?php if (!(strcmp("LY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Libya</option>
                    <option value="LI" title="Liechtenstein" <?php if (!(strcmp("LI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Liechtenstein</option>
                    <option value="LT" title="Lithuania" <?php if (!(strcmp("LT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Lithuania</option>
                    <option value="LU" title="Luxembourg" <?php if (!(strcmp("LU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Luxembourg</option>
                    <option value="MO" title="Macau" <?php if (!(strcmp("MO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Macau</option>
                    <option value="MK" title="Macedonia" <?php if (!(strcmp("MK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Macedonia</option>
                    <option value="MG" title="Madagascar" <?php if (!(strcmp("MG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Madagascar</option>
                    <option value="MW" title="Malawi" <?php if (!(strcmp("MW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Malawi</option>
                    <option value="MY" title="Malaysia" <?php if (!(strcmp("MY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Malaysia</option>
                    <option value="MV" title="Maldives" <?php if (!(strcmp("MV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Maldives</option>
                    <option value="ML" title="Mali" <?php if (!(strcmp("ML", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mali</option>
                    <option value="MT" title="Malta" <?php if (!(strcmp("MT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Malta</option>
                    <option value="MH" title="Marshall Islands" <?php if (!(strcmp("MH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Marshall Islands</option>
                    <option value="MQ" title="Martinique" <?php if (!(strcmp("MQ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Martinique</option>
                    <option value="MR" title="Mauritania" <?php if (!(strcmp("MR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mauritania</option>
                    <option value="MU" title="Mauritius" <?php if (!(strcmp("MU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mauritius</option>
                    <option value="YT" title="Mayotte" <?php if (!(strcmp("YT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mayotte</option>
                    <option value="MX" title="Mexico" <?php if (!(strcmp("MX", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mexico</option>
                    <option value="FM" title="Micronesia,Federated States of" <?php if (!(strcmp("FM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Micronesia,Federated States of</option>
                    <option value="MD" title="Moldova" <?php if (!(strcmp("MD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Moldova</option>
                    <option value="MC" title="Monaco" <?php if (!(strcmp("MC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Monaco</option>
                    <option value="MN" title="Mongolia" <?php if (!(strcmp("MN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mongolia</option>
                    <option value="ME" title="Montenegro" <?php if (!(strcmp("ME", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Montenegro</option>
                    <option value="MS" title="Montserrat" <?php if (!(strcmp("MS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Montserrat</option>
                    <option value="MA" title="Morocco" <?php if (!(strcmp("MA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Morocco</option>
                    <option value="MZ" title="Mozambique" <?php if (!(strcmp("MZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Mozambique</option>
                    <option value="MM" title="Myanmar (Burma)" <?php if (!(strcmp("MM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Myanmar (Burma)</option>
                    <option value="NA" title="Namibia" <?php if (!(strcmp("NA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Namibia</option>
                    <option value="NR" title="Nauru" <?php if (!(strcmp("NR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Nauru</option>
                    <option value="NP" title="Nepal" <?php if (!(strcmp("NP", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Nepal</option>
                    <option value="NL" title="Netherlands" <?php if (!(strcmp("NL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Netherlands</option>
                    <option value="AN" title="Netherlands Antilles" <?php if (!(strcmp("AN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Netherlands Antilles</option>
                    <option value="NC" title="New Caledonia" <?php if (!(strcmp("NC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>New Caledonia</option>
                    <option value="NZ" title="New Zealand" <?php if (!(strcmp("NZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>New Zealand</option>
                    <option value="NI" title="Nicaragua" <?php if (!(strcmp("NI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Nicaragua</option>
                    <option value="NE" title="Niger" <?php if (!(strcmp("NE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Niger</option>
                    <option value="NG" title="Nigeria" <?php if (!(strcmp("NG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Nigeria</option>
                    <option value="NU" title="Niue" <?php if (!(strcmp("NU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Niue</option>
                    <option value="NM" title="No Man's Land" <?php if (!(strcmp("NM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>No Man's Land</option>
                    <option value="NF" title="Norfolk Island" <?php if (!(strcmp("NF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Norfolk Island</option>
                    <option value="KP" title="North Korea" <?php if (!(strcmp("KP", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>North Korea</option>
                    <option value="MP" title="Northern Mariana Islands" <?php if (!(strcmp("MP", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Northern Mariana Islands</option>
                    <option value="NO" title="Norway" <?php if (!(strcmp("NO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Norway</option>
                    <option value="OM" title="Oman" <?php if (!(strcmp("OM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Oman</option>
                    <option value="PK" title="Pakistan" <?php if (!(strcmp("PK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Pakistan</option>
                    <option value="PS" title="Palestine" <?php if (!(strcmp("PS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Palestine</option>
                    <option value="PW" title="Paluau" <?php if (!(strcmp("PW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Paluau</option>
                    <option value="PA" title="Panama" <?php if (!(strcmp("PA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Panama</option>
                    <option value="PG" title="Papua New Guinea" <?php if (!(strcmp("PG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Papua New Guinea</option>
                    <option value="PY" title="Paraguay" <?php if (!(strcmp("PY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Paraguay</option>
                    <option value="PE" title="Peru" <?php if (!(strcmp("PE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Peru</option>
                    <option value="PH" title="Philippines" <?php if (!(strcmp("PH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Philippines</option>
                    <option value="PN" title="Pitcairn Islands" <?php if (!(strcmp("PN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Pitcairn Islands</option>
                    <option value="PL" title="Poland" <?php if (!(strcmp("PL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Poland</option>
                    <option value="PT" title="Portugal" <?php if (!(strcmp("PT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Portugal</option>
                    <option value="PR" title="Puerto Rico" <?php if (!(strcmp("PR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Puerto Rico</option>
                    <option value="QA" title="Qatar" <?php if (!(strcmp("QA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Qatar</option>
                    <option value="RE" title="Reunion" <?php if (!(strcmp("RE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Reunion</option>
                    <option value="RO" title="Romania" <?php if (!(strcmp("RO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Romania</option>
                    <option value="RU" title="Russia" <?php if (!(strcmp("RU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Russia</option>
                    <option value="RW" title="Rwanda" <?php if (!(strcmp("RW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Rwanda</option>
                    <option value="SH" title="Saint Helena" <?php if (!(strcmp("SH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Helena</option>
                    <option value="KN" title="Saint Kitts and Nevis" <?php if (!(strcmp("KN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Kitts and Nevis</option>
                    <option value="LC" title="Saint Lucia" <?php if (!(strcmp("LC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Lucia</option>
                    <option value="MF" title="Saint Martin" <?php if (!(strcmp("MF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Martin</option>
                    <option value="PM" title="Saint Pierre and Miquelon" <?php if (!(strcmp("PM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Pierre and Miquelon</option>
                    <option value="VC" title="Saint Vincent and the Grenadines" <?php if (!(strcmp("VC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saint Vincent and the Grenadines</option>
                    <option value="WS" title="Samoa" <?php if (!(strcmp("WS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Samoa</option>
                    <option value="SM" title="San Marino" <?php if (!(strcmp("SM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>San Marino</option>
                    <option value="ST" title="Sao Tome and Principe" <?php if (!(strcmp("ST", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sao Tome and Principe</option>
                    <option value="SA" title="Saudi Arabia" <?php if (!(strcmp("SA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Saudi Arabia</option>
                    <option value="SN" title="Senegal" <?php if (!(strcmp("SN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Senegal</option>
                    <option value="RS" title="Serbia" <?php if (!(strcmp("RS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Serbia</option>
                    <option value="SC" title="Seychelles" <?php if (!(strcmp("SC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Seychelles</option>
                    <option value="SL" title="Sierra Leone" <?php if (!(strcmp("SL", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sierra Leone</option>
                    <option value="SG" title="Singapore" <?php if (!(strcmp("SG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Singapore</option>
                    <option value="SX" title="Sint Maarten" <?php if (!(strcmp("SX", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sint Maarten</option>
                    <option value="SK" title="Slovakia" <?php if (!(strcmp("SK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Slovakia</option>
                    <option value="SI" title="Slovenia" <?php if (!(strcmp("SI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Slovenia</option>
                    <option value="SB" title="Solomon Islands" <?php if (!(strcmp("SB", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Solomon Islands</option>
                    <option value="SO" title="Somalia" <?php if (!(strcmp("SO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Somalia</option>
                    <option value="ZA" title="South Africa" <?php if (!(strcmp("ZA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>South Africa</option>
                    <option value="GS" title="South Georgia and the South Sandwich Islands" <?php if (!(strcmp("GS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>South Georgia and the South Sandwich Islands</option>
                    <option value="KR" title="South Korea" <?php if (!(strcmp("KR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>South Korea</option>
                    <option value="SS" title="South Sudan" <?php if (!(strcmp("SS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>South Sudan</option>
                    <option value="ES" title="Spain" <?php if (!(strcmp("ES", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Spain</option>
                    <option value="LK" title="Sri Lanka" <?php if (!(strcmp("LK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sri Lanka</option>
                    <option value="SD" title="Sudan" <?php if (!(strcmp("SD", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sudan</option>
                    <option value="SR" title="Suriname" <?php if (!(strcmp("SR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Suriname</option>
                    <option value="SJ" title="Svalbard" <?php if (!(strcmp("SJ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Svalbard</option>
                    <option value="SZ" title="Swaziland" <?php if (!(strcmp("SZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Swaziland</option>
                    <option value="SE" title="Sweden" <?php if (!(strcmp("SE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Sweden</option>
                    <option value="CH" title="Switzerland" <?php if (!(strcmp("CH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Switzerland</option>
                    <option value="SY" title="Syria" <?php if (!(strcmp("SY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Syria</option>
                    <option value="TW" title="Taiwan" <?php if (!(strcmp("TW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Taiwan</option>
                    <option value="TJ" title="Tajikistan" <?php if (!(strcmp("TJ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tajikistan</option>
                    <option value="TZ" title="Tanzania" <?php if (!(strcmp("TZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tanzania</option>
                    <option value="TH" title="Thailand" <?php if (!(strcmp("TH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Thailand</option>
                    <option value="BS" title="The Bahamas" <?php if (!(strcmp("BS", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>The Bahamas</option>
                    <option value="GM" title="The Gambia" <?php if (!(strcmp("GM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>The Gambia</option>
                    <option value="TG" title="Togo" <?php if (!(strcmp("TG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Togo</option>
                    <option value="TK" title="Tokelau" <?php if (!(strcmp("TK", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tokelau</option>
                    <option value="TO" title="Tonga" <?php if (!(strcmp("TO", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tonga</option>
                    <option value="TT" title="Trinidad and Tobago" <?php if (!(strcmp("TT", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Trinidad and Tobago</option>
                    <option value="TN" title="Tunisia" <?php if (!(strcmp("TN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tunisia</option>
                    <option value="TR" title="Turkey" <?php if (!(strcmp("TR", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Turkey</option>
                    <option value="TM" title="Turkmenistan" <?php if (!(strcmp("TM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Turkmenistan</option>
                    <option value="TC" title="Turks and Caicos Islands" <?php if (!(strcmp("TC", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Turks and Caicos Islands</option>
                    <option value="TV" title="Tuvalu" <?php if (!(strcmp("TV", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Tuvalu</option>
                    <option value="UM" title="US Minor Outlying Islands" <?php if (!(strcmp("UM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>US Minor Outlying Islands</option>
                    <option value="UG" title="Uganda" <?php if (!(strcmp("UG", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Uganda</option>
                    <option value="UA" title="Ukraine" <?php if (!(strcmp("UA", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Ukraine</option>
                    <option value="AE" title="United Arab Emirates" <?php if (!(strcmp("AE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>United Arab Emirates</option>
                    <option value="GB" title="United Kingdom" <?php if (!(strcmp("GB", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>United Kingdom</option>
                    <option value="US" selected="selected" title="United States" <?php if (!(strcmp("US", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>United States</option>
                    <option value="UY" title="Uruguay" <?php if (!(strcmp("UY", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Uruguay</option>
                    <option value="UZ" title="Uzbekistan" <?php if (!(strcmp("UZ", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Uzbekistan</option>
                    <option value="VU" title="Vanuatu" <?php if (!(strcmp("VU", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Vanuatu</option>
                    <option value="VE" title="Venezuela" <?php if (!(strcmp("VE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Venezuela</option>
                    <option value="VN" title="Vietnam" <?php if (!(strcmp("VN", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Vietnam</option>
                    <option value="VI" title="Virgin Islands (US)" <?php if (!(strcmp("VI", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Virgin Islands (US)</option>
                    <option value="WF" title="Wallis and Futuna" <?php if (!(strcmp("WF", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Wallis and Futuna</option>
                    <option value="EH" title="Western Sahara" <?php if (!(strcmp("EH", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Western Sahara</option>
                    <option value="YE" title="Yemen" <?php if (!(strcmp("YE", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Yemen</option>
                    <option value="ZM" title="Zambia" <?php if (!(strcmp("ZM", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Zambia</option>
                    <option value="ZW" title="Zimbabwe" <?php if (!(strcmp("ZW", $row_user['user_country']))) {echo "selected=\"selected\"";} ?>>Zimbabwe</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="show_mylocation">Show/Hide My Location</label>
                  <br />
                  <select class="form-control" id="show_mylocation">
                    <option value="0" <?php if (!(strcmp(0, $row_user['show_mylocation']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                    <option value="1" <?php if (!(strcmp(1, $row_user['show_mylocation']))) {echo "selected=\"selected\"";} ?>>Show</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="m-t-15">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="ethnicity_select">Ethnicity: </label>
                  <select tabindex="12" name="ethnicity_select" id="ethnicity_select" class="form-control">
                    <option value="none" <?php if (!(strcmp("none", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Select Ethnicity</option>
                    <option value="asian" <?php if (!(strcmp("asian", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Asian</option>
                    <option value="african_american" <?php if (!(strcmp("african_american", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Black</option>
                    <option value="caucasian" <?php if (!(strcmp("caucasian", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Caucasian/White</option>
                    <option value="east_indian" <?php if (!(strcmp("east_indian", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>East Indian</option>
                    <option value="hispanic_latino" <?php if (!(strcmp("hispanic_latino", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Hispanic/Latino</option>
                    <option value="middle_eastern" <?php if (!(strcmp("middle_eastern", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Middle Eastern</option>
<option value="native_american" <?php if (!(strcmp("native_american", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Native American</option>
                    <option value="pacific_islander" <?php if (!(strcmp("pacific_islander", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Pacific Islander</option>
                    <option value="other" <?php if (!(strcmp("other", $row_user['user_ethnicity']))) {echo "selected=\"selected\"";} ?>>Other</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="show_ethnicity">Show/Hide My Ethnicity</label>
                  <br />
                  <select class="form-control" id="show_ethnicity">
                    <option value="0" <?php if (!(strcmp(0, $row_user['show_ethnicity']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                    <option value="1" <?php if (!(strcmp(1, $row_user['show_ethnicity']))) {echo "selected=\"selected\"";} ?>>Show</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label for="my_religion">My Religion <span class="required">*</span></label>
                <select class="form-control" name="my_religion" id="my_religion">
                  <option value="-1" <?php if (!(strcmp(-1, $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Select Religion</option>
                  <option value="G" <?php if (!(strcmp("G", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Agnostic</option>
                  <option value="A" <?php if (!(strcmp("A", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Atheist</option>
                  <option value="B" <?php if (!(strcmp("B", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Buddhist</option>
                  <option value="T" <?php if (!(strcmp("T", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Catholic</option>
                  <option value="C" <?php if (!(strcmp("C", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Christian</option>
                  <option value="H" <?php if (!(strcmp("H", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Hindu</option>
                  <option value="J" <?php if (!(strcmp("J", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Jewish</option>
                  <option value="M" <?php if (!(strcmp("M", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Muslim</option>
                  <option value="S" <?php if (!(strcmp("S", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Spiritual</option>
                  <option value="O" <?php if (!(strcmp("O", $row_user['user_religion']))) {echo "selected=\"selected\"";} ?>>Other</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="show_religion">Show/Hide My Religion</label>
                <select class="form-control" name="show_religion" id="show_religion">
                  <option value="0" <?php if (!(strcmp(0, $row_user['user_showreligion']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                  <option value="1" <?php if (!(strcmp(1, $row_user['user_showreligion']))) {echo "selected=\"selected\"";} ?>>Show</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label for="Sexual Orientation">Sexual Orientation <span class="required">*</span></label>
                <select id="sexualorientation" name="sexualorientation" class="form-control">
                  <option value="-1" <?php if (!(strcmp(-1, $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Sexual orientation</option>
                  <option value="straight" <?php if (!(strcmp("straight", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Straight</option>
                  <option value="gay" <?php if (!(strcmp("gay", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Gay</option>
                  <option value="bisexual" <?php if (!(strcmp("bisexual", $row_user['user_orientation']))) {echo "selected=\"selected\"";} ?>>Bisexual</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="show_ethnicity">Show/Hide My Orientation</label>
                <br />
                <select class="form-control" id="show_orientation">
                  <option value="0" <?php if (!(strcmp(0, $row_user['show_orientation']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                  <option value="1" <?php if (!(strcmp(1, $row_user['show_orientation']))) {echo "selected=\"selected\"";} ?>>Show</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label for="my_relstatus">Relationship Status</label>
                <br />
                <select id="my_relstatus" class="form-control" name="my_relstatus">
                  <option value="X" <?php if (!(strcmp("X", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Select Status</option>
                  <option value="S" <?php if (!(strcmp("S", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Single</option>
                  <option value="D" <?php if (!(strcmp("D", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Dating</option>
                  <option value="R" <?php if (!(strcmp("R", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>In a Relationship</option>
                  <option value="E" <?php if (!(strcmp("E", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Engaged</option>
                  <option value="M" <?php if (!(strcmp("M", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Married</option>
                  <option value="C" <?php if (!(strcmp("C", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>It's Complicated</option>
                  <option value="O" <?php if (!(strcmp("O", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Open Relationship</option>
                  <option value="P" <?php if (!(strcmp("P", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Separated</option>
                  <option value="V" <?php if (!(strcmp("V", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Divorced</option>
                  <option value="W" <?php if (!(strcmp("W", $row_user['user_relstatus']))) {echo "selected=\"selected\"";} ?>>Widowed</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="show_my_relstatus">Show/Hide Full Name</label>
                <br />
                <select class="form-control" id="show_my_relstatus">
                  <option value="0" <?php if (!(strcmp(0, $row_user['show_user_relstatus']))) {echo "selected=\"selected\"";} ?>>Hide</option>
                  <option value="1" <?php if (!(strcmp(1, $row_user['show_user_relstatus']))) {echo "selected=\"selected\"";} ?>>Show</option>
                </select>
              </div>
            </div>
          </div>
          <hr />
          <button id="save_profile_settings" class="btn btn-primary" type="button">Save Profile Settings</button>
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
   
	<?php include("footer.php"); ?>
    <!-- ==========================
    	DropZone 
    =========================== -->
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/dropzone.js"></script>


</body>
</html>