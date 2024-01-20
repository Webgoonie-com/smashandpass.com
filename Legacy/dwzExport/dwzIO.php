<?php
if(!class_exists('dwzIO')){
class dwzIO
{

	const  BETWEEN_NAME_AND_EXTENSION = 2;
	const  BEFORE_NAME = 1;
	
//	Mac -> /var/www/vhosts/aaa.com/httpdocs
//	Mac -> \\var\www\vhosts\aaa.com\httpdocs
//	Win -> c:\var\www\vhosts\aaa.com\httpdocs
		
	public static $root_path_for_test = "";
	
	public static function SetRootPath($path){
		self::$root_path_for_test = $path;
	}
	
	public static function ConvertRelativeToAbsolutePath($page_absolute_path, $relative_path){
		if(dwzString::StartWith($relative_path, "/")){
			$relative_path = preg_replace("/\//", (self::UseSlash() ? "/" : "\\"), $relative_path);
			$new_path = self::PathCombine(self::GetSiteRoot(), $relative_path);
			return $new_path;
		}
		$page_path = self::GetFilePart($page_absolute_path);
		$page_path['path'] = dwzString::TrimRight($page_path['path'], (self::UseSlash() ? "/" : "\\"));
						
		$relative_path = dwzString::TrimLeft($relative_path, "./");
		$levels = 0;
		while(substr($relative_path, 0, 3) == "../"){
			$levels ++;
			$relative_path = substr($relative_path, 3);
		}				
		$relative_path = preg_replace("/\//", (self::UseSlash() ? "/" : "\\"), $relative_path);		
		if(self::UseSlash()){
			$folders = preg_split("/\//", $page_path['path']);
		}else{
			$folders = preg_split("/\\\\/", $page_path['path']);
		}
		$new_path = "";
		if(count($folders) > 1){
			for($i=0; $i<count($folders) - $levels; $i++){
				if($new_path != ""){
					$new_path .= (self::UseSlash() ? "/" : "\\");
				}
				$new_path .= $folders[$i];
			}
		}
		if($new_path == ""){
			$new_path = $page_path['path'];
		}
		
		$new_path = self::PathCombine($new_path, $relative_path);
		$start_path = self::GetStartPath();
		if(self::IsMac() && !dwzString::StartWith($new_path, $start_path)){
			$new_path = $start_path .$new_path;
		}		
		if(!dwzString::StartWith($new_path, self::GetSiteRoot())){
			$new_path = self::GetSiteRoot();
		}
		return $new_path;
	}
	
	public static function GetSiteRootRelativePath($absolute_path){
		$root = self::GetSiteRoot();
		$extra_length = 0;
		if(substr($root, strlen($root)) == "\\" || substr($root, strlen($root)) == "/"){
			$extra_length = 1;
		}
		$site_relative_path = substr($absolute_path, strlen($root) - $extra_length);
		return preg_replace("/\\\\/", "/", $site_relative_path);
	}
	
	public static function ConvertAbsoluteToRelativePath($page_absolute_path, $absolute_path_to_convert){
		$root_path = self::GetSiteRoot();
		$page = self::GetFilePart($page_absolute_path);
		$rel_page = self::GetFilePart($absolute_path_to_convert);
		
		$page['path'] = dwzString::TrimRight($page['path'], (self::UseSlash() ? "/" : "\\"));
		$page['path'] = dwzString::TrimLeft($page['path'], $root_path);
		$page['path'] = dwzString::TrimLeft($page['path'], (self::UseSlash() ? "/" : "\\"));
		
		$rel_page['path'] = dwzString::TrimRight($rel_page['path'], (self::UseSlash() ? "/" : "\\"));
		$rel_page['path'] = dwzString::TrimLeft($rel_page['path'], $root_path);	
		$rel_page['path'] = dwzString::TrimLeft($rel_page['path'], (self::UseSlash() ? "/" : "\\"));
		$rel_page['path'] = preg_replace("/\\\\/", "/", $rel_page['path']);
		
		$rel_path = "";
		
		if(strlen($page['path']) != 0){
			if(self::UseSlash()){
				$levels = count(preg_split("/\//", $page['path']));
			}else{
				$levels = count(preg_split("/\\\\/", $page['path']));
			}
			
			for($i=0; $i<$levels; $i++){
				$rel_path .= "../";
			}
		}
		return $rel_path .$rel_page['path'] ."/" .$rel_page['name'] .$rel_page['ext'];
	} 
	
	public static function GetSiteURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"];
		}
		return $pageURL;
	}
	
	public static function GetSiteRoot(){
		
		if(self::$root_path_for_test != ""){
			return self::$root_path_for_test;
		}
		if(isset($_SESSION) && isset($_SESSION['SITE_ROOT'])){
			$path = $_SESSION['SITE_ROOT'];
			if(strlen($path) != 0){
				$path = dwzString::TrimRight(dwzString::TrimRight($path, "/"), "\\");
			}
			return $path;
		}		
		$path = @$_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
		
		if(strlen($path) == 0){
			$path = @$_SERVER['DOCUMENT_ROOT'];
		}		
		if(strlen($path) == 0){
			$path = @$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
		}
		if(strlen($path) == 0){
			$path = @$_SERVER['APPL_PHYSICAL_PATH'];
		}
		return $path;
	}
	
	public static function PathCombine($path_1, $path_2){		
		$path_1 = self::SetSeparator($path_1);
		$path_2 = self::SetSeparator($path_2);				
		$path_separator = self::GetPathSeparator();
		$path_1 = dwzString::TrimRight($path_1, "/");
		$path_1 = dwzString::TrimRight($path_1, "\\");				
		$path_2 = dwzString::TrimLeft($path_2, "/");
		$path_2 = dwzString::TrimLeft($path_2, "\\");
		return $path_1 .(self::UseSlash() ? "/" : "\\") .$path_2;
	}
	
	public static function SetSeparator($path){
		if(self::UseSlash()){
			return preg_replace("/\\\\/", "/", $path);
		}else{
			return preg_replace("/\//", "\\", $path);
		}	
	}
	
	public static function IsSiteRootRelativePath($path){
		if(dwzString::StartWith($path, "/")){
			return true;
		}		
		return false;
	}
	
	public static function IsDocumentRelativePath($path){
		$pattern = "/^[\w]+/";
		if(dwzString::StartWith($path, "../") || 
			dwzString::StartWith($path, "./") ||
			(preg_match($pattern, $path) && strpos($path, ":") === false)){
			return true;
		}		
		return false;
	}
	
	public static function GetRealPath($path){
		if($path == ""){
			return "";
		}
				
		$rel_path = "";
		if(self::IsDocumentRelativePath($path)){
			//$page_absolute_path = self::GetCurrentAbsolutePath();
			//$rel_path = self::ConvertRelativeToAbsolutePath($page_absolute_path, $path);				
			$rel_path = realpath($path);
			if($rel_path === false){
				$rel_path = $path;
			}
		}else{
			$root = self::GetSiteRoot();
			
			//if(substr($path, 0, 1) == "/"){
				if(strpos($root, "/") !== false){
					//	/folder/
					/*
					if(substr($root, -1) == "/" && substr($path, 0, 1) == "/"){
						$path = substr($path, 1);
					}
					*/
					$rel_path = self::PathCombine($root, $path);
				}else{
					//	c:\folder\
					if(strpos($path, ":") !== false || substr($path, 0, 2) == "\\\\" || substr($path, 0, 2) == "//"){
						$rel_path = $path;
					}else if(self::IsMac()){
						$rel_path = self::PathCombine($root, $path);
					}else{
						$rel_path = self::PathCombine($root, preg_replace("/\//", "\\", $path));
					}
				}
			//}		
		}
		
		$part = self::GetFilePart($rel_path);
		if($part['path'] != "" && self::IsNotDir($part['path'])){
			self::CreateFoldersTree($part['path']);
		}
		return $rel_path;
	}
	
	public static function GetCurrentPagePath(){
		$uri = $_SERVER["REQUEST_URI"];
		if(preg_match("/\?/", $uri)){
			$uri = substr($uri, 0, strpos($uri, "?"));
		}
		return $uri;
	}
	
	public static function GetCurrentAbsolutePath(){
		$path = @$_SERVER["SCRIPT_FILENAME"];
		if(strlen($path) == 0){
			$path = @$_SERVER["ORIG_PATH_TRANSLATED"];
		}
		if(strlen($path) == 0){
			$path = $_ENV["DOCUMENT_ROOT"];
		}
		if(strlen($path) == 0){
			$path = $_ENV["SCRIPT_FILENAME"];
		}
		if(strlen($path) == 0){
			$path = $_ENV["ORIG_PATH_TRANSLATED"];
		}
		if(strlen($path) == 0){
			return realpath(".");
		}else{
			$part = self::GetFilePart($path);
			return $part['path'];
		}
	}
	
	public static function GetThumbPath($image_path, $suffix, $suffix_position){
		$relative_path = self::IsDocumentRelativePath($image_path) || self::IsSiteRootRelativePath($image_path);
		$part = self::GetFilePart($image_path, $relative_path);	
		if($suffix_position == self::BEFORE_NAME){
			return self::PathCombine($part["path"], $suffix .$part["name"] .$part["ext"]);
		}else{
			return self::PathCombine($part["path"], $part["name"] .$suffix .$part["ext"]);
		}
	}
	
	public static function GetStartPath(){
		$root = self::GetSiteRoot();
		$start = "";
		$index = 0;		
		while(substr($root, $index, 1) == "/" || substr($root, $index, 1) == "\\"){
			$start .= substr($root, $index, 1);
			$index++;
		}
		return $start;
	}
	
	public static function GetFilePart($file_path, $relative_path = false){
		$separator = self::GetPathSeparator();
		$pattern = (self::UseSlash() ? "/\//" : "/\\\\/");
		$parts = preg_split($pattern, $file_path);
			
		if($relative_path){
			if(strpos($file_path, "/") !== false){
				$separator = "/";
			}else{
				$separator = "\\";
			}
			$pattern = ($separator == "/" ? "/\//" : "/\\\\/");
			$parts = preg_split($pattern, $file_path);
		}
		
		$name = "";
		$ext = "";
		$path = "";
				
		$site_root = self::GetSiteRoot();
							
		if($relative_path){
			$path = $separator;
		}else{
			if(self::IsMac()){
				$path = self::GetStartPath();			
			}
		}
		
		$counter = count($parts);
		if(strripos($parts[count($parts) - 1], ".") !== false){
			$tmp_name = preg_split("/\./", $parts[count($parts) - 1]);
			$name = "";
			for($i=0; $i<count($tmp_name) - 1; $i++){
				if($i != 0){
					$name .= ".";
				}
				$name .= $tmp_name[$i];				
			}
			$ext = "." .$tmp_name[count($tmp_name) - 1];
			
			$parts[count($parts) - 1] = "";
		}
		
		if($counter > 0 && $parts[0] == "." && $relative_path && $path == "/"){
			$path = "";
		}
				
		$index = 0;
		for($i=0; $i<$counter; $i++){
			if($parts[$i] != ""){
				if($path != "" && $path != $separator && $index > 0){
					$path .= $separator;
				}
				$path .= $parts[$i];
				$index++;
			}
		}
		
		if(substr($path, -1) != $separator){
			$path .= $separator;
		}
		
		$ret_val =  array("name" => $name, "path" => $path, "ext" => $ext);
		return $ret_val;		
	}
	
	public static function GetPathSeparator(){
		$path = self::GetSiteRoot();
		if(strpos($path, "/") !== false){
			return "/";
		}else{
			return "\\";
		}
	}
	
	public static function IsDebug(){
		if(self::$root_path_for_test != ""){
			return true;
		}
		return false;
	}
	
	public static function CreateFoldersTree($path){
		if(self::IsDebug()){
			return;
		}
				
		$path_separator = self::GetPathSeparator();
		$folder = "";
			
		if($path_separator == "/"){			
			$tmp = preg_split("/\//", $path);
		}else{
			$tmp = preg_split("/\\\/", $path);
		}
		
		if(!self::IsWindows() && $folder == ""){
			$folder = "/";
		}
		
		foreach($tmp as $part){
			if($folder != "" && $folder != $path_separator){
				$folder .= $path_separator;
			}
			if($part != ""){
				$folder .= $part;
				//echo $folder ."<br>";
				if($part != ".." && self::IsNotDir($folder)){
					//echo "Create<br>";
					self::CreateFolder($folder);
				}
			}
		}		
		return $folder;
	}
	
	public static function FileCopy($source_path, $dest_path, $overwrite){
		if(!self::FileExist($source_path) || (self::FileExist($source_path) && $overwrite)){
			return copy($source_path, $dest_path);
		}
		return false;
	}
	public static function FileExist($file_path){
		if(@file_exists($file_path)){
			return true;
		}else{
			return false;
		}
	}
	
	public static function IsNotDir($folder){
		if(self::IsDebug()){
			return true;
		}
		if(@is_dir($folder)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function CreateFolder($folder){
		if(self::IsNotDir($folder)){
			@mkdir($folder, 0755, true);
		}
	}
	
	public static function VerifyFolder($folder){
		$path = self::GetRealPath($folder);
		self::CreateFoldersTree($path);
	}

	public static function IsWindows(){
		$path = self::GetSiteRoot();
		if(preg_match("/^[a-zA-Z]+:/", $path)){
			return true;
		}
		return false;
	}
	
	public static function IsMac(){
		return !self::IsWindows();		
	}
	
	public static function UseSlash(){
		$sep = self::GetPathSeparator();
		if($sep == "/"){
			return true;
		}
		return false;
	}
	
	public static function GetFileContent($file_path){
		if(self::FileExist($file_path)){
			return file_get_contents($file_path);
		}
		return "";
	}
	
}
}
?>