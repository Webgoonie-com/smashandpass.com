<?php


$gpicture_raw = "https://lh4.googleusercontent.com/-XipnPiXHnNw/AAAAAAAAAAI/AAAAAAAAAAA/AAKWJJPRSp0nNyatuxXy467Ms-JXCy7C0Q/photo.jpg";



		
		$photodata = getimagesize($gpicture_raw);
		print_r($photodata);
		
		echo $uphotowidth = $photodata[0];
		echo '<br />';
		echo $uphotoheight = $photodata[1];
		
		echo $image_size = $photodata['bits'];
		
   		$mime = $photodata['mime];
 
		
		
?>