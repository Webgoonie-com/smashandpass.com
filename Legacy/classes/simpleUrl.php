<?php


/*
*** YouTube Video
*** Creating Clean URLS using PHP
*** ScoobyDooobyD00
*** https://www.youtube.com/watch?v=ZgCW2x5QCXo&list=PLvbQYvxdDoWsrYQE9XqOUv4r2HtFX0eTQ&index=62
***
*/




class simpleUrl {

	var $site_path;
	
	function __construct($site_path){
		$this->site_path = $this->removeSlash($site_path);
	}

	function __toString(){
		return $this->site_path;
	}
	
	private function removeSlash($string){
		if( $string[strlen($string) -1] == '/' )
			$string = rtrim($string, '/');
			
			return $string;
		
	}
	
	function segment($segment){
		
		$url = str_replace($this->site_path, '', $_SERVER['REQUEST_URI']);
		$url = explode('/', $url);
		
		//echo $url;
		
		if( isset($url[$segment]))
			return $url[$segment];
		else
			return false;
		
		return $url;
	}
	


}


$uri =  $_SERVER['REQUEST_URI'];

if($uri == '/index.php?accesscheck=%2Findex.php'){
	
	header('Location: /join');
	
}

?>