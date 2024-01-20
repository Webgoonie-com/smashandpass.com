   	<!-- ==========================
    	FOOTER - START 
    =========================== -->
    <div class="container">
    	<div class="footer-boxes">
        	<div class="row">

        	<div id="console_debug" class="row">
                        
            </div>
                        
                <!-- FOOTER BOX - START -->
            	<div class="col-md-4 hidden-xs hidden-sm">
                	<div class="box">
                    	<h4>Promote You</h4>
                         <ul class="list-unstyled list-inline team-categories">
                        	<li><a href="/promote" class="btn btn-primary">Promote A Website</a></li>
                          	<li><a href="/promote" class="btn btn-primary ">Promote A Vieo</a></li>
                          	<li><a href="/promote" class="btn btn-primary ">Promote Brand Or Business</a></li>
                      	 </ul>
                        
                        <p id="footer_aboutme">
						<?php if($row_user['user_aboutme']){ ?>
                        
                        <?php echo $row_user['user_aboutme']; ?>
                        
                        <?php }else{ ?>
                        <div class="row">
                            <div class="col-sm-12" align="center">
                                <a href="/profile" class="btn btn-primary btn-sm" type="button"><i class="fa fa-pencil"></i> Edit About Me</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php } ?>
                        </p>
                    </div>
            	</div>
                <!-- FOOTER BOX - END -->
                
                <!-- FOOTER BOX - START -->
                <div class="col-sm-6 col-md-4">
                	<div class="box footer-tags">
						<h4>Latest Members</h4>
                 <?php do{ ?> 
<a href="member/<?php echo $row_lastest_members_advert['theusr_id']; ?>">
                            <img  style="width:60px;" src="<?php echo 'data:image/png;base64,'.base64_encode($row_lastest_members_advert['user_profile_blob']); ?>" class="img-responsive img-circle"  alt="">
							<span class="text-10"><?php if($row_lastest_members_advert['user_nickname']){ echo $row_lastest_members_advert['user_nickname']; }else{ echo $row_lastest_members_advert['user_fname']; } ?></span>
</a>

                 <?php } while ($row_lastest_members_advert = mysqli_fetch_array($query_lastest_members_advert_sql)); ?>
                                      
					</div>
            	</div>
                <!-- FOOTER BOX - END -->
                
                <!-- FOOTER BOX - START -->
                <div class="col-sm-6 col-md-4 hidden-xs">
                	<div class="box footer-posts">
                        <h4>Latest Earnings</h4>	
                        <ul class="list-unstyled">
                 <?php do{ ?> 
                            <li><a href="member/<?php echo $row_lastest_members_transactions['theusr_id']; ?>"><?php echo $row_lastest_members_transactions['userledger_log_descrp']; ?></a> <span class="post-date"><?php echo $row_lastest_members_transactions['userledger_log_created_at']; ?></span></li>
                 <?php } while ($row_lastest_members_transactions = mysqli_fetch_array($query_lastest_members_transactions_sql)); ?>

                        </ul>
                    </div>
            	</div>
                <!-- FOOTER BOX - END -->
                
            </div>
        </div>
    	<footer class="navbar navbar-default">
        	<div class="row">
            	<div class="col-md-6 hidden-xs hidden-sm">
                	
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/privacy">Privacy Policy</a></li>
                        <li><a href="/terms">Terms</a></li>
                        <li><a href="/howitworks">How It Works</a></li>
                        <li><a href="/support">Support</a></li>
                    </ul>
                    
                </div>
                <div class="col-md-6">
                	<p class="copyright">&copy; SmashAndPass.com <?php echo date('Y'); ?> All right reserved. <a href="http://smashandpass.com/" target="_blank">Smash And Pass, Inc.</a></p>
                </div>
            </div>
        </footer>
    </div>
    <!-- ==========================
    	FOOTER - END 
    =========================== -->
   
   	<!-- ==========================
    	JS 
    =========================== -->        
	<script src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/creative-brands.js"></script>
    <script src="assets/js/jquery.vegas.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/goonie.js"></script>

   <script src="assets/sweetalert/sweetalert.min.js"></script>


<script>
<?php
if($user_emailverify != 1){
echo "
$('#verifyEmailCodeModal').modal('show');
";
}
?>
</script>