<?php

// https://stackoverflow.com/questions/409999/getting-the-location-from-an-ip-address
/*
  "ip": "8.8.8.8",
  "hostname": "google-public-dns-a.google.com",
  "loc": "37.385999999999996,-122.0838",
  "org": "AS15169 Google Inc.",
  "city": "Mountain View",
  "region": "CA",
  "country": "US",
  "phone": 650
*/
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
// echo $details->city; // -> "Mountain View"

//print_r($details);

?>
<!DOCTYPE html>
<html>
	<head>
    <!-- ==========================
    	Meta Tags 
    =========================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <!-- ==========================
    	Title 
    =========================== -->
    <title>Join Now</title>

    <!-- <base href="/"> -->
    <!-- ==========================
    	Favicons 
    =========================== -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png"/>
    
	<link rel="apple-touch-icon" href="assets/images/favicon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon.png">
    
    <!-- ==========================
    	Fonts 
    =========================== -->
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!-- ==========================
    	Meta Tags 
    =========================== -->
    <link rel="canonical" href="https://www.smashandpass.com"/>
    <meta property="og:site_name" content="Smash And Pass"/>
    <meta property="og:title" content="Smash And Pass"/>
    <meta property="og:url" content="https://www.smashandpass.com"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="Build Your Social Currency While Meeting And Chatting With New Friends"/>
    <meta property="og:image:width" content="1500"/>
    <meta property="og:image:height" content="547"/>
    <meta itemprop="name" content="Smash And Pass"/>
    <meta itemprop="url" content="https://www.smashandpass.com"/>
    <meta itemprop="description" content="Build Your Social Currency While Meeting And Chatting With New Friends"/>
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
    	JS 
    =========================== -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<?php include_once("analyticstracking.php") ?>
    <h1>&nbsp;</h1>
	
    <!-- ==========================
    	HEADER - START 
    =========================== -->
    <?php include("navbar.php"); ?>
    <!-- ==========================
    	HEADER - END 
    =========================== -->  
    
    
    <!-- ==========================
    	CONTENT - START 
    =========================== -->
    <div class="container">
        <section class="content-wrapper join">
        	<div class="row">
            
            	<!-- SIDEBAR - START -->
            	<div class="col-sm-4">
					
                    <!-- SIDEBAR BOX - START -->
                    <div class="box sidebar-box widget-wrapper">
                    	<h3>The Social Network That Lets You Connect With People<?php if(isset($details->city)){ echo ' in '.$details->city; } ?>.</h3>
                        <div class="tournament">
                        	<!--a href="#"><img src="" class="img-responsive" alt=""></a -->
                            
                            <h4>Smash And Pass <?php echo date('Y'); ?></h4>
                            <p>People are having fun and making new friends on SmashAndPass every anc day long. Join Now And You can too!</p>
                            
                            <div class="row">
                            	<div class="col-sm-12">
                                <p>
                                    <a class="btn btn-block btn-social btn-google">
                                        <span class="fa fa-google"></span> Sign in with Google
                                    </a>
                                </p>
                                </div>
                                <div class="col-sm-12">
                                <p>
                                    <a class="btn btn-block btn-social btn-facebook">
                                        <span class="fa fa-facebook"></span>  Sign in with Facebook
                                    </a>
                                </p>
                                </div>

                            </div>
                            
                            
                            
                        </div>
                    </div>
                    <!-- SIDEBAR BOX - END -->
                    
                    
                    
                </div>
                <!-- SIDEBAR - END -->
                
                <!-- CONTENT BODY - START -->
                <div class="col-sm-8">
                	<div class="box registration-form">
                    	<h1 align="center">JOIN 4 FREE</h1>
                        <div>

                            <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="join_fname">First Name</label><br />
                                <input tabindex="3" type="text" class="form-control" id="join_fname" placeholder="First Name">
                              </div>
                            </div>
                            
                            
                            
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="join_lname">Last Name</label><br />
                                <input tabindex="4" type="text" class="form-control" id="join_lname" placeholder="Last Name">
                              </div>                        
                            </div>
                            </div>                   
                        
                        
                        
                        	<div class="form-group">
                                <label for="join_email">Email</label>
                                <input tabindex="5" type="text" class="form-control" id="join_email" placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <label for="join_pass">Password</label>
                                <input tabindex="6" type="password" class="form-control" id="join_pass" placeholder="Password">
                            </div>
                        	<div class="form-group">
                                <label for="join_zipcode">Zip Code</label>
                                <input tabindex="7" type="text" class="form-control" id="join_zipcode" placeholder="Zip Code">
                            </div>



                        	<div class="form-group">
                                <label for="birth_month">Birthday</label>

                                <div class="row">
                                  <div class="col-xs-4">
                                    <select tabindex="8" name="birthMonth" id="birth_month" class="form-control">
                                            <option value="0" id="month_option">Month</option>
                                            <option id="birth_month1" value="1">January</option>
                                            <option id="birth_month2" value="2">February</option>
                                            <option id="birth_month3" value="3">March</option>
                                            <option id="birth_month4" value="4">April</option>
                                            <option id="birth_month5" value="5">May</option>
                                            <option id="birth_month6" value="6">June</option>
                                            <option id="birth_month7" value="7">July</option>
                                            <option id="birth_month8" value="8">August</option> 
                                            <option id="birth_month9" value="9">September</option>
                                            <option id="birth_month10" value="10">October</option>
                                            <option id="birth_month11" value="11">November</option>
                                            <option id="birth_month12" value="12">December   </option>
                                    </select>                                                              
    							 </div>
                                 <div class="col-xs-4">

                                            <select tabindex="9" name="birthDay" id="birth_day" class="form-control">
                                                <option value="0" id="day_option">Day</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option> 
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                  </div>
                                  <div class="col-xs-4">

                                    <select tabindex="10" name="birthYear" id="birth_year" class="form-control">
                                            <option value="0" id="year_option">Year</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                            <option value="1989">1989</option>
                                            <option value="1988">1988</option>
                                            <option value="1987">1987</option>
                                            <option value="1986">1986</option>
                                            <option value="1985">1985</option>
                                            <option value="1984">1984</option>
                                            <option value="1983">1983</option>
                                            <option value="1982">1982</option>
                                            <option value="1981">1981</option>
                                            <option value="1980">1980</option>
                                            <option value="1979">1979</option>
                                            <option value="1978">1978</option>
                                            <option value="1977">1977</option>
                                            <option value="1976">1976</option>
                                            <option value="1975">1975</option>
                                            <option value="1974">1974</option>
                                            <option value="1973">1973</option>
                                            <option value="1972">1972</option>
                                            <option value="1971">1971</option>
                                            <option value="1970">1970</option>
                                            <option value="1969">1969</option>
                                            <option value="1968">1968</option>
                                            <option value="1967">1967</option>
                                            <option value="1966">1966</option>
                                            <option value="1965">1965</option>
                                            <option value="1964">1964</option>
                                            <option value="1963">1963</option>
                                            <option value="1962">1962</option>
                                            <option value="1961">1961</option>
                                            <option value="1960">1960</option>
                                            <option value="1959">1959</option>
                                            <option value="1958">1958</option>
                                            <option value="1957">1957</option>
                                            <option value="1956">1956</option>
                                            <option value="1955">1955</option>
                                            <option value="1954">1954</option>
                                            <option value="1953">1953</option>
                                            <option value="1952">1952</option>
                                            <option value="1951">1951</option>
                                            <option value="1950">1950</option>
                                            <option value="1949">1949</option>
                                            <option value="1948">1948</option>
                                            <option value="1947">1947</option>
                                            <option value="1946">1946</option>
                                            <option value="1945">1945</option>
                                            <option value="1944">1944</option>
                                            <option value="1943">1943</option>
                                            <option value="1942">1942</option>
                                            <option value="1941">1941</option>
                                            <option value="1940">1940</option>
                                            <option value="1939">1939</option>
                                            <option value="1938">1938</option>
                                            <option value="1937">1937</option>
                                            <option value="1936">1936</option>
                                            <option value="1935">1935</option>
                                            <option value="1934">1934</option>
                                            <option value="1933">1933</option>
                                            <option value="1932">1932</option>
                                            <option value="1931">1931</option>
                                            <option value="1930">1930</option>
                                            <option value="1929">1929</option>
                                            <option value="1928">1928</option>
                                            <option value="1927">1927</option>
                                            <option value="1926">1926</option>
                                            <option value="1925">1925</option>
                                            <option value="1924">1924</option>
                                            <option value="1923">1923</option>
                                            <option value="1922">1922</option>
                                            <option value="1921">1921</option>
                                            <option value="1920">1920</option>
                                            <option value="1919">1919</option>
                                            <option value="1918">1918</option>
                                            <option value="1917">1917</option>
                                            <option value="1916">1916</option>
                                            <option value="1915">1915</option>
                                            <option value="1914">1914</option>
                                            <option value="1913">1913</option>
                                            <option value="1912">1912</option>
                                            <option value="1911">1911</option>
                                            <option value="1910">1910</option>
                                            <option value="1909">1909</option>
                                            <option value="1908">1908</option>
                                            <option value="1907">1907</option>
                                            <option value="1906">1906</option>
                                            <option value="1905">1905</option>
                                            <option value="1904">1904</option>
                                            <option value="1903">1903</option>
                                            <option value="1902">1902</option>
                                    </select>
    
    
                                  </div>  
                                </div>                                
                                
                                
                                
                                
                            </div>
                        	<div class="form-group">
                              <label for="ethnicity_select">Ethnicity: </label>
                                    <select tabindex="11" name="ethnicity_select" id="ethnicity_select" class="form-control">
                                        <option value="none">
                                            Ethnicity
                                		</option>
                                        <option value="asian">
                                            Asian                
                                		</option>
                                        <option value="african_american">
                                            Black                
                                		</option>
                                        <option value="caucasian">
                                            Caucasian/White                
                                		</option>
                                        <option value="east_indian">
                                            East Indian                
                                		</option>
                                        <option value="hispanic_latino">
                                            Hispanic/Latino                
                                		</option>
                                        <option value="middle_eastern">
                                            Middle Eastern                
                                		</option>
                                        <option value="native_american">
                                            Native American                
                                		</option>
                                        <option value="pacific_islander">
                                            Pacific Islander                
                                		</option>
                                        <option value="other">
                                            Other                
                                		</option>
                                    </select>                            
                    </div>


                        	<div class="form-group">
                                <div class="row">
                                    <div id="mandfradio" class="container">
                                        <div class="col-xs-3">
                                            <label class="radio inline ptn" for="male">
                                                <input type="radio" class="radio pln mtn" name="gender" id="male" value="Male" tabindex="12">
                                                <span class="sex_label">Male</span>
                                            </label>
                                        </div>
                                        <div class="col-xs-3">
                                            <label class="radio inline ptn">
                                                <input type="radio" class="radio mtn" name="gender" id="female" value="Female" tabindex="13">
                                                <span class="sex_label">Female</span>
                                            </label>
                                        </div>
                                     </div>
                                 </div>							
                            </div>

							<div class="signup_error">
                            	
                            </div>
                            <div class="form-group">
                                    ​<span>By clicking Sign up, you are indicating that you have read and agree to the <a id="termsOfUse" href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>.</span>
                            </div>

							<div id="joina-signup" class="form-group">
                            <button id="join_submit" type="submit" class="btn btn-success btn-lg btn-block">Sign Up</button>
                        	</div>
                            
                        </div>
                    </div>
                    
                    <div class="box registration-form" id="reset-password">
                    	<h2>Frogotten password</h2>
                        <p>If you've forgotten your password use this form to reset your password. New password will be send to your email.</p>
                        <div>
                        	<div class="form-group">
                                <label for="forg_email">Email address</label>
                                <input type="email" class="form-control" id="forg_email" placeholder="Enter email">
                            </div>
                            <button type="submit" class="btn btn-primary">Reset password</button>
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

	<?php include("footer.php"); ?>
    <script src="assets/js/tz/jstz.js"></script>

    <script src="assets/js/start.js"></script>
    
</body>
</html>
