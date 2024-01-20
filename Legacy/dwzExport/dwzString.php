<?php
if(!class_exists('dwzString')){
class dwzString
{
	
	public static function GetTagList($html, $tag_name){
		$matches = array();
		preg_match_all("/<" .$tag_name ."[^>]*>(.*?)<\/" .$tag_name .">/i", $html, $matches);
		return $matches;
	}
	
	public static function GetOpenTag($str){
		$end_pos = strpos($str, ">");
		if($end_pos > 0){
			return substr($str, 0, $end_pos + 1);
		}
		return "";
	}
	
	public static function GetTagAttribute($tag, $name){
		if(strlen($tag) == 0){
			return "";
		}	
		$pattern = "/" .$name ."\s*=\s*([\"'])?([^\"']*)/i";
		preg_match($pattern, $tag, $matches);
		if(count($matches) > 0){
			$match = substr($matches[0], strpos($matches[0], "=") + 1);
			$match = trim(preg_replace("/\"/", "", $match));
			return $match;
		}
		return "";
	}

	public static function StartWith($str, $start){
		$str    = (string)$str; 
		$start = (string)$start;
		if(empty($start) || empty($str)) 
		{ 
			return $str; 
		}
		for($i=0; $i<strlen($start); $i++){
			if(substr(strtolower($str), $i, 1) != substr(strtolower($start), $i, 1)){
				return false;
			}
		}
		return true;
	}
	
	public static function EndWith($str, $end){
		$str    = (string)$str; 
		$end = (string)$end;
		if(empty($end) || empty($str)) 
		{ 
			return $str; 
		}
		for($i=strlen($end); $i>0; $i--){
			if(substr(strtolower($str), ($i * -1), 1) != substr(strtolower($end), ($i * -1), 1)){
				return false;
			}
		}
		return true;
	}
	
	public static function Trim($str, $remove = " "){
		return self::TrimRight(self::TrimLeft($str, $remove), $remove);
	}
	
	public static function TrimLeft($str, $remove = " "){
		$str    = (string)$str; 
		$remove = (string)$remove;
		if(empty($remove) || empty($str)) 
		{ 
			return $str; 
		}
		while(substr(strtolower($str), 0, strlen($remove)) == strtolower($remove)) 
		{ 
			$str = substr($str, strlen($remove));         
		}
		return $str;
	}
	
	
	public static function TrimRight($str, $remove = " "){
		$str    = (string)$str; 
		$remove = (string)$remove;    
		
		if(empty($remove) || empty($str)) 
		{ 
			return $str; 
		}
		$len = strlen($remove); 
		$offset = strlen($str)-$len; 
		while($offset > 0 && $offset == strpos(strtolower($str), strtolower($remove), $offset)) 
		{ 
			$str = substr($str, 0, $offset); 
			$offset = strlen($str)-$len; 
		}
		return $str;
	}	
}
}
?>