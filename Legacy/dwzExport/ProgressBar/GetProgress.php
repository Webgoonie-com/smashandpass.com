<?php
include('../dwzIO.php');
include('../dwzString.php');
include('../SetTempFolder.php');

function LoadProgressInfo(){	
	$filename = dwzIO::PathCombine(GetTempFolder(), $_GET['progress_key'] .".xml");
	$retval = false;
	
	if(file_exists($filename)){
		$retval = file_get_contents($filename);
	}
	return $retval;
}

if(isset($_GET['progress_key'])) {
	$status = LoadProgressInfo();
}else{
	$status = false;
}

if($status === false){
	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
	$xml .= "<root>";
	$xml .= "<total>0</total>";
	$xml .= "<current>0</current>";
	$xml .= "<work></work>";
	$xml .= "<done>0</done>";
	$xml .= "<start_time>0</start_time>";
	$xml .= "</root>";	
}else{
	$xml = $status;
}

ob_clean();
header('Content-type: text/xml');
header('Content-Length: ' + strlen($xml));
echo $xml;
exit();
?>

