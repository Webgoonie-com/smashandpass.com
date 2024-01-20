<?php
if(!$_POST) exit();
if(isset($_POST['image'])){

$croped_image = $_POST['image'];
list($type, $croped_image) = explode(';', $croped_image);
list(, $croped_image)      = explode(',', $croped_image);
$croped_image = base64_decode($croped_image);
$image_name = time().'.png';
// upload cropped image to server 
file_put_contents('../uploads/'.$image_name, $croped_image);
//echo 'Cropped image uploaded successfully.';
}
?>