<script>
var nua = navigator.userAgent;
var is_android = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));
if(is_android) {
		$('select.form-control').removeClass('form-control').css('width', '100%');

}
</script>

<header class="navbar navbar-default navbar-fixed-top">
    	<div class="container">
            <div class="navbar-header">
            	<a href="/profile/" class="navbar-brand visible-xs">Smash And Pass</a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                		<i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="navbar-collapse collapse">
            	<ul class="nav navbar-nav">
                	<li><a href="/news">Home</a></li>
                    <li><a href="/friends">Friends</a></li>
                    <li><a href="/profile">Profile</a></li>
                    <li><a href="/gallery">Gallery</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Play</a>
                        <ul class="dropdown-menu">
                        	<li><a href="/play"><i class="fa fa-plus"></i>Smash And Pass</a></li>
                            <li><a href="/following"><i class="fa fa-plus"></i>Following</a></li>
                            <li><a href="/wishlist"><i class="fa fa-plus"></i>Wishlist</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>Repass Or Smash</a></li>
                            <li><a href="/buyassets"><i class="fa fa-plus"></i>Buy Assets</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cash</a>
                        <ul class="dropdown-menu">
                        	<li><a href="/ledger"><i class="fa fa-plus"></i>Current Hot List</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>View Recommend Purchases</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>View Elite Purchases</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>Sell Assets</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>Sold Assets</a></li>                            
                            <li><a href="#"><i class="fa fa-plus"></i>Purchase More Cash</a></li>
                            <li><a href="#"><i class="fa fa-plus"></i>Earn More Cash</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Messages</a>
                        <ul class="dropdown-menu">
                        	<li><a href="/messages"><i class="fa fa-plus"></i>Inbox</a></li>
                            <li><a href="/messages"><i class="fa fa-plus"></i>Drafts</a></li>
                            <li><a href="/messages/new"><i class="fa fa-plus"></i>New Message</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                        	<li><a href="#"><i class="fa fa-plus"></i>Refer New Members</a></li>
                            <li><a href="/forceset"><i class="fa fa-plus"></i>My Set Up</a></li>
                            <li><a href="/ledger"><i class="fa fa-plus"></i>My Ledger</a></li>
                        	<li><a href="/logout"><i class="fa fa-plus"></i>Log Out</a></li>
                        </ul>
                    </li>
                    

<input id="user_id" type="hidden" value="<?php echo $user_id; ?>" />
<input id="usr_cookie" type="hidden" value="<?php echo $cookie; ?>" />
                </ul>
                <div class="pull-right navbar-buttons hidden-xs">
                	<a href="/settings" class="btn btn-primary">Settings</a>
                    <a class="navbar-icon show2" id="open-search">Member Search <i class="fa fa-search"></i></a>
                    <a class="navbar-icon hidden" id="close-search"><i class="fa fa-times"></i></a>
                    <a href="/logout" class="btn btn-inverse">Logout</a>                    
              <div class="hidden" id="navbar-search-form">
                        <form action="/search/" method="get" target="_parent" role="search">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" value="" name="mbrname" id="navbar-search" class="form-control" placeholder="Search Here...">
                                    <span class="input-group-btn"><button class="btn btn-primary" type="submit" id="navbar-search-submit"><i class="fa fa-search"></i></button></span>
                                </div>
                            </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </header>






<!-- Modal -->
<div class="modal fade" id="verifyEmailCodeModal" tabindex="-1" role="dialog" aria-labelledby="verifyEmailCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" align="center">
        <h5 align="center" class="modal-title" id="verifyEmailCode">Welcome To Smash And Pass</h5>
      </div>
      <div class="modal-body">
        
        	<div class="row justify-content-center">
              <div id="verifyEmailCode_captionblock">
            	<div class="col-sm-12" align="center">
                	<p>Click the link in the email we have sent to</p>
                    <p><a><?php echo $row_user['user_email']; ?></a></p>
                    <p>to complete your registrtion.</p>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
            	<div id="verifyEmailCode_codeblock">
                        <div class="col-sm-6" align="right">
                            <label>Or enter your confirmtion code:</label>
                            <input id="user_enter_regemail_code" class="form-control" type="text" value="" />
                        </div>
                        <div class="col-sm-6" align="left">
	                        <p></p>
                            <button id="user_enter_regemail_code_btn" class="btn dk_green btn-lg">Confirm</button>
                        </div>
            	</div>
            </div>
      </div>
      <div class="modal-footer" align="center">
        <a id="verifyEmailCode_resendemail" href="#" data-dismiss="modal" class="">Resend Confirmation Email  |  </a>
        <a id="verifyEmailCode_changeemail" href="#" data-dismiss="modal" class=""> Change Email Address</a>
      </div>
    </div>
  </div>
</div>

