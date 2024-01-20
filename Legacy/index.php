<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";


include 'classes/simpleUrl.php';

include("classes/db_connect.php");


$url = new simpleUrl('/join');


//echo $_SERVER['REQUEST_URI'];
if( !$url->segment(1) )
	$page = 'join';
else
	$page = $url->segment(1);




switch ($page){

	case '@' : 
		$view_pagefile = 'views/member.php';
	break;
	case 'backoffice' :
		$view_pagefile = 'backoffice/index.php';
	break;
	case 'buycredits' :
		$view_pagefile = 'views/buycredits.php';
	break;
	case 'buyassets' : 
		$view_pagefile = 'views/buyassets.php';
	break;
	case 'blank' : 
		$view_pagefile = 'views/blank.php';
	break;
	case 'earncredits' :
		$view_pagefile = 'views/earncredits.php';
	break;
	case 'forceset' :
		$view_pagefile = 'views/forceset.php';
	break;
	case 'following' :
		$view_pagefile = 'views/following.php';
	break;
	case 'friends' :
		$view_pagefile = 'views/friends.php';
	break;
	case 'gallery' :
		$view_pagefile = 'views/gallery.php';
	break;
	case 'howitworks' :
		$view_pagefile = 'views/howitworks.php';
	break;
	case 'ledger' :
		$view_pagefile = 'views/ledger.php';
	break;
	case 'picaction' :
		$view_pagefile = 'views/picaction.php';
	break;
	case 'picproaction' :
		$view_pagefile = 'views/picproaction.php';
	break;
	case 'play' :
		$view_pagefile = 'views/play.php';
	break;
	case 'privacy' :
		$view_pagefile = 'views/privacy.php';
	break;
	case 'promote' :
		$view_pagefile = 'views/promote.php';
	break;
	case 'profile' :
		$view_pagefile = 'views/profile.php';
	break;
	case 'messages' :
		$view_pagefile = 'views/subfolder/messages.php';
	break;
	case 'message' :
		$view_pagefile = 'views/subfolder/message.php';
	break;
	case 'member' :
		$view_pagefile = 'views/member.php';
	break;
	case 'myassets' : 
		$view_pagefile = 'views/myassets.php';
	break;
	case 'myteam' :
		$view_pagefile = 'views/myteam.php';
	break;
	case 'news' : 
		$view_pagefile = 'views/news.php';
	break;
	case 'googlelogin' : 
		$view_pagefile = 'gredirect.php';  
	break;
	case 'search' :
		$view_pagefile = 'views/search.php';
	break;
	case 'settings' :
		$view_pagefile = 'views/settings.php';
	break;
	case 'single_iphoto' :
		$view_pagefile = 'classes/script_process_blob.php';
	break;
	case 'support' :
		$view_pagefile = 'views/support.php';
	break;
	case 'splashaction' :
		$view_pagefile = 'views/splashaction.php';
	break;
	case 'terms' :
		$view_pagefile = 'views/terms.php';
	break;
	case 'test' :
		$view_pagefile = 'views/test.php';
	break;
	case 'test-blob' :
		$view_pagefile = 'views/test-blob.php';
	break;
	case 'thread' :
		$view_pagefile = 'views/thread.php';
	break;
	case 'uphoto' : 
		$view_pagefile = 'views/reg_photo.php';		
	break;
	case 'user' :
		$view_pagefile = 'views/user.php';
	break;	
	case 'verify' :
		$view_pagefile = 'views/verify.php';
	break;
	case 'watch' :
		$view_pagefile = 'views/watch.php';
	break;
	case 'wishlist' :
		$view_pagefile = 'views/wishlist.php';
	break;
	case 'logout' : 
		$view_pagefile = 'classes/script_logout.php';		
	break;	
	default :    // 404 page
		$view_pagefile = 'views/join.php';
	break;
}





?>
<?php include("$view_pagefile"); ?>
