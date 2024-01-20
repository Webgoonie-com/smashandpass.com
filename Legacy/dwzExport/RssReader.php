<?php
//'**********************************
//' http://www.DwZone.it
//' Rss Reader
//' Copyright (c) DwZone.it 2000-2005
//'**********************************

include('dwzIO.php');
include('dwzString.php');

class dwzRssReader
{
	
	var $rssUrlPath,
		$recname,
		$channel,
		$items,
		$itemsNumber,
		$errMsg,
		$xmlContent;
		
	function SetUrlPath($param){
		$this->rssUrlPath = $param;
	}
	
	function Init (){
		//set Channel = CreateObject("Scripting.Dictionary")
		//set Items = CreateObject("Scripting.Dictionary")	
		$channel = array();
		$items = array();
		$errMsg = array();
	}
		
	
	function Execute(){
		/*
		if left(lcase(RssUrlPath),7) = "http://" then
			getContentFromUrl()
		else
			getContentFromPath()
		end if
		*/
		
		if(count($this->errMsg) != 0){
			$this->ResponseError();
			exit();
		}
				
		$this->ReadFromXmlContent();
		
		if(count($this->errMsg) != 0){
			$this->ResponseError();
			exit();
		}
		
	}
	
	
	
	function ResponseError(){
		$retStr = "<table border=1>";
		$retStr .= "<tr><td colspan=3></td></tr>";
		$retStr .= "<tr>";
		$retStr .= "<td>Number</td>";
		$retStr .= "<td>Description</td>";
		$retStr .= "<td>Position</td>";
		$retStr .= "</tr>";
		foreach($this->errMsg as $msg){
			$tmp = "<tr>";
			$tmp .= "<td>" .$msg['Number'] ."</td>";
			$tmp .= "<td>" .$msg['Description'] ."</td>";
			$tmp .= "<td>" .$msg['Position'] ."</td>";
			$tmp .= "</tr>";
			$retStr .= $tmp;
		}
		$retStr .= "</table>";
		ob_clean();
		echo $retStr;
		exit();
		//response.write(ErrMsg.getTable("Some errors in the XmlImport"))	
		//response.End()
	}
		
	
	
	
	function ReadFromXmlContent(){
		//NODE_ELEMENT		= 1
		//NODE_ATTRIBUTE		= 2
		//NODE_TEXT			= 3
		//NODE_CDATA			= 4
		//NODE_PROCCESSING	= 7
		//NODE_COMMENT		= 8
			
		if(substr($this->rssUrlPath, 0, 7) == "http://"){
			$xml = simplexml_load_file($this->rssUrlPath, 'SimpleXMLElement', LIBXML_NOCDATA);			
		}else{
			$fullFilePath = dwzIO::GetRealPath($this->rssUrlPath); // $this->GetFilePath($this->rssUrlPath);
			$xml = simplexml_load_file($fullFilePath, 'SimpleXMLElement', LIBXML_NOCDATA);			
		}
		
		$namespaces = $xml->getDocNamespaces(); 
		$xPath = "channel";
		$channels = $xml->xpath($xPath);
		foreach($channels as $channel){
			
			foreach($channel as $key => $value){
				if(strtolower($key) == "item"){					
				}else if(strtolower($key) == "image"){					
				}else{
					$name = strtoupper("Channel_" .preg_replace("/:/", "_", $key));
					$this->channel[$name] = $value;
				}
			}
			
			$items = $channel->xpath("item"); 
			//$aaa = count($items)
			foreach($items as $item){
				
				$str = '<rss ';
				foreach($namespaces as $prefix => $ns){
					$str .= ' xmlns:' .$prefix .'="' .$ns .'" ';
				}	
				$str .= '>' .$item->asXML() ."</rss>";
				
				$xml = new SimpleXMLElement($str);
				$items = $xml->xpath("item");

				$item = array();
				foreach($items[0] as $key => $value){
					$name = strtoupper("Items_" .preg_replace("/:/", "_", $key));
					$item[$name] = $value;
				}
				$this->items[] = $item;				
			}
			
			$images = $channel->xpath("image"); 
			foreach($images as $image){
				$xml = new SimpleXMLElement($image->asXML());
				foreach($xml as $key => $value){
					$name = strtoupper("Channel_image_" .preg_replace("/:/", "_", $key));
					$this->channel[$name] = $value;				
				}
			}
			
			break;
		}
		
		
	}
			
	
	function GetChannelValue($tagName){		
		if(array_key_exists( strtoupper("Channel_" .preg_replace("/:/", "_", $tagName)), $this->channel)){
			return $this->channel[strtoupper("Channel_" .preg_replace("/:/", "_", $tagName))];
		}else{
			return "";
		}
	}
	
	function GetItemValue($index, $tagName){
		if(count($this->items) < $index){
			return "";
		}
				
		if( array_key_exists( strtoupper("Items_" .preg_replace("/:/", "_", $tagName)) ,  $this->items[$index - 1] )){
			return $this->items[$index - 1][strtoupper("Items_" .preg_replace("/:/", "_", $tagName))];
		}else{
			return "";
		}
	}
	
	function GetItemsNumber(){
		return count($this->items);
	}
	
}

?>