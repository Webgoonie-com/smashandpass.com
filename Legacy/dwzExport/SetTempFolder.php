<?php

//DON'T REMOVE THE COMMENT IN THE LINE 1-14
//*********************************************************
//*  HERE YOU MUST INSERT THE REFERENCE FOR THE TEMP FOLDER
//*  FOR EXEMPLE:
//*  TO SET A PERSONAL TEMP FOLDER USE THIS LINE
//*    return CreateTempFolder("/public/");
//*  TO USE SYSTEM TEMP FOLDER USE THIS LINES
//*    	$tmpfile = tempnam("dummy","");
//*		$path = dirname($tmpfile);
//*		if(substr($path, -1) != "\\"){
//*			$path .= "\\";
//*		}
//*		return $path;
//*  IMPORTANT: COMMENT THE LINES YOU DON'T USE
//*  REMENBER IN THIS FOLDER YOU MUST HAVE WRITE PERMISSION
//**********************************************************
function GetTempFolder(){
	//lines to use personal temp folder
	//return CreateTempFolder("/public/temp");
	
	//lines to use system temp folder
	$tmpfile = tempnam("dummy","");
	$path = dirname($tmpfile);
	/*
	if(substr($path, -1) != "\\"){
		$path .= "\\";
	}
	*/
	return $path;
}



function CreateTempFolder($folder){
	$folder = preg_replace("/\\/", "/", $folder);
	if(substr($folder, 0, 1) == "/"){
		$folder = dwzIO::GetSiteRoot() .preg_replace("/\//", "\\", $folder);
	}else{
		$folder = realpath($folder);
	}	
	if(!is_dir($folder)){
		mkdir($folder, 0755, true);
	}
	if(substr($folder, -1) != "\\"){
		$folder .= "\\";
	}
	return $folder;
}
?>