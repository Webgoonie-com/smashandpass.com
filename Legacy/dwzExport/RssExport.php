<?php
ob_start();
if(!isset($_SESSION)) 
{ 
	session_start(); 
}  

include('dwzIO.php');
include('dwzString.php');

//**********************************
// http://www.DwZone.it
// Rss Writer
// Copyright (c) DwZone.it 2000-2005
//**********************************
class dwzRssExport
{
	
	var $encoding,
		$codePage,
		$pubDate,
		$title,
		$description,
		$link,
		$recordset,
		$row_recordset,
		$itemTitle,
		$itemDescription,
		$itemLink,
		$itemLinkText,
		$itemAuthor,
		$itemPubDate,
		$fileName,
		$numberOfRecord,
		$startOnEvent,
		$startOnValue,
		$feedImageUrl,
		$feedImageLink,
		$feedImageTitle,
		$language,
		$category,
		$TTL,
		$docs,
		$managingEditor,
		$webmaster,
		$generator,
		$timeZone,
		
		$itemLabelField,
		$itemRecField,
		$itemTypeTag,
		$itemAttrName,
		$itemAttrValue,
		$isMySqli,
		
		$baseLabelField,
		$baseRecField,
		$baseTypeTag,
		$baseAttrName,
		$baseAttrValue;
	
	
	
	function addCustomitem($Label, $Rec, $sType, $sAttrName, $sAttrValue){
		/*
		itemCustomCount = itemCustomCount + 1
		ReDim Preserve itemLabelField(itemCustomCount)
		ReDim Preserve itemRecField(itemCustomCount)
		ReDim Preserve itemTypeTag(itemCustomCount)
		ReDim Preserve itemAttrName(itemCustomCount)
		ReDim Preserve itemAttrValue(itemCustomCount)
		*/
		$this->itemLabelField[] = $Label;
		$this->itemRecField[] = $Rec;
		$this->itemTypeTag[] = $sType;
		$this->itemAttrName[] = $sAttrName;
		$this->itemAttrValue[] = $sAttrValue;		
	}
	
	function addBaseCustomitem($Label, $Rec, $sType, $sAttrName, $sAttrValue){
		/*
		BaseCustomCount = BaseCustomCount + 1
		ReDim Preserve baseLabelField(BaseCustomCount)
		ReDim Preserve baseRecField(BaseCustomCount)
		ReDim Preserve baseTypeTag(BaseCustomCount)
		ReDim Preserve baseAttrName(BaseCustomCount)
		ReDim Preserve baseAttrValue(BaseCustomCount)
		*/
		
		$this->baseLabelField[] = $Label;
		$this->baseRecField[] = $Rec;
		$this->baseTypeTag[] = $sType;
		$this->baseAttrName[] = $sAttrName;
		$this->baseAttrValue[] = $sAttrValue;
	}
	
	function SetRecordset(&$rs){
		$this->recordset = $rs;
	}
	
	function SetEncoding($param){
		$tmp = preg_split("/;/", $param);
		$this->encoding = $tmp[0];
		$this->codePage = $tmp[1];
	}
	
	function SetPubDate($param){
		if(strtolower($param) == "true"){
			$this->pubDate = true;
		}else{
			$this->pubDate = false;
		}
	}
	
	function SetTitle($param){
		$this->title = $this->getEvalValue($param);
	}
	
	function SetDescription($param){
		$this->description = $this->getEvalValue($param);
	}	
	
	function SetLink($param){
		$this->link = $this->getEvalValue($param);
	}	
	
	function SetItemTitle($param){
		$this->itemTitle = trim($param);
	}	
	
	function SetItemDescription($param){
		$this->itemDescription = trim($param);
	}	
	
	function SetItemLink($param){
		$this->itemLink = trim($param);
	}	
	
	function SetItemLinkText($param){
		$this->itemLinkText = trim($param);
	}
	
	function SetItemAuthor($param){
		$this->itemAuthor = trim($param);
	}	
	
	function SetItempubDate($param){
		$this->itemPubDate = trim($param);
	}	
	
	function SetFileName($param){
		$this->fileName = trim($param);
	}	
	
	function SetNumberOfRecord($param){
		if(strtoupper($param) != "ALL"){
			if(!doubleval($param)){
				$param = "ALL";
			}
		}
		$this->numberOfRecord = trim($param);
	}	
	
	function SetStartOn($param1, $param2){
		$this->startOnEvent = $param1;
		$this->startOnValue = $param2;
	}
	
	function SetfeedImage($param){
		$tmp = preg_split("/__@_@__/", $param);
		$this->feedImageUrl = $this->getEvalValue($tmp[0]);
		$this->feedImageLink = $this->getEvalValue($tmp[1]);
		$this->feedImageTitle = $this->getEvalValue($tmp[2]);
	}
	
	function SetAdditionalInfo($param){
		$tmp = preg_split("/__@_@__/", $param);
		$this->language = $tmp[0];
		$this->category = $this->getEvalValue($tmp[1]);
		$this->TTL = $this->getEvalValue($tmp[2]);
		$this->docs = $this->getEvalValue($tmp[3]);
		$this->managingEditor = $this->getEvalValue($tmp[4]);
		$this->webmaster = $this->getEvalValue($tmp[5]);
		$this->generator = $this->getEvalValue($tmp[6]);
		if(count($tmp) > 7){
			$this->isMySqli = (strtolower($tmp[7]) == "mysqli");
		}else{
			$this->isMySqli = false;
		}
	}
	
	function SetTimeZone($param){
		$this->timeZone = $param;
	}
			
	
	function Init (){
		$this->recordset = null;	
		$this->itemLabelField = array();
		$this->itemRecField = array();
		$this->itemTypeTag = array();
		$this->itemAttrName = array();
		$this->itemAttrValue = array();
		
		$this->baseLabelField = array();
		$this->baseRecField = array();
		$this->baseTypeTag = array();
		$this->baseAttrName = array();
		$this->baseAttrValue = array();		
	}
	
	function Start(){
		$retStr = false;
		switch(strtoupper($this->startOnEvent)){
		case "GET":
			if(isset($_GET[$this->startOnValue]) && $_GET[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;
		case "POST":
			if(isset($_POST[$this->startOnValue]) && $_POST[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;
		case "REQUEST":
			if(isset($_REQUEST[$this->startOnValue]) && $_REQUEST[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;
		case "SESSION":
			if(isset($_SESSION[$this->startOnValue]) && $_SESSION[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;						
		case "COOKIE":
			if(isset($_COOKIE[$this->startOnValue]) && $_COOKIE[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;					
		case "ONLOAD":
			$retStr = true;
			break;
		}
		return $retStr;
	}
	
	
	function Execute(){
		if(!$this->Start()){
			return;
		}
		//if Not isObject(recordset) Then
		//	Response.write "<strong>DwZone - ATOM Export Error.</strong><br/>The recordset is not valid"
		//	Exit sub
		//End If
		
		$cont = array();
		$aCapo = "\n";
		$tab = "\t";
		
		$cont[] = "<" ."?xml version=\"1.0\" encoding=\"" .$this->encoding ."\"?>" .$aCapo;
		$cont[] = "<rss version=\"2.0\">" .$aCapo;
		$cont[] = $tab ."<channel>" .$aCapo;
		if($this->title != ""){
			$cont[] = $tab ."<title>" .$this->EscapeValue($this->title) ."</title>" .$aCapo;
		}
		if($this->link != ""){
			$cont[] = $tab ."<link>" .$this->EscapeValue($this->link) ."</link>" .$aCapo;
		}
		if($this->description != ""){
			$cont[] = $tab ."<description>" .$this->EscapeValue($this->description) ."</description>" .$aCapo;
		}
		if($this->language != ""){
			$cont[] = $tab ."<language>" .$this->EscapeValue($this->language) ."</language>" .$aCapo;
		}
		if($this->pubDate != ""){
			//'Mon, 28 Feb 2005 13:12:09 +0100
			$cont[] = $tab ."<pubDate>" .$this->GetStringDate(getdate(time())) ."</pubDate>" .$aCapo;
		}
		if($this->docs != ""){
			$cont[] = $tab ."<docs>" .$this->EscapeValue($this->docs) ."</docs>" .$aCapo;
		}
		if($this->managingEditor != ""){
			$cont[] = $tab ."<managingEditor>" .$this->EscapeValue($this->managingEditor) ."</managingEditor>" .$aCapo;
		}
		if($this->webmaster != ""){
			$cont[] = $tab ."<webmaster>" .$this->EscapeValue($this->webmaster) ."</webmaster>" .$aCapo;
		}
		if($this->category != ""){
			$cont[] = $tab ."<category>" .$this->EscapeValue($this->category) ."</category>" .$aCapo;
		}
		if($this->TTL != ""){
			$cont[] = $tab ."<ttl>" .$this->EscapeValue($this->TTL) ."</ttl>" .$aCapo;
		}
		if($this->generator != ""){
			$cont[] = $tab ."<generator>" .$this->EscapeValue($this->generator) ."</generator>" .$aCapo;
		}	
		
		for($i=0; $i<count($this->baseTypeTag); $i++){
			
			if($this->baseTypeTag[Si] == "Date"){
				$tmpVal = $this->GetEvalValue($this->baseRecField[$i]);
				if(strtotime($tmpVal) !== false){
					$tmpVal = $this->GetStringDate(getdate(strtotime($tmpVal)));
				}else{
					$tmpVal = "";
				}
			}else if($this->baseTypeTag[$i] == "Text"){
				$tmpVal = $this->EscapeValue($this->GetEvalValue($this->baseRecField[$i]));
			}else{
				$tmpVal = $this->GetEvalValue($this->baseRecField[$i]);
			}
			
			if($this->baseAttrName[$i] != ""){
				$Attribute = " " .$this->baseAttrName[$i] ."=\"" .$this->SearchValue($this->baseAttrValue[$i]) ."\" ";
			}else{
				$Attribute = "";
			}
			if($this->baseTypeTag[$i] == "Memo"){
				$cont[] = $tab ."<" .$this->baseLabelField[$i] .$Attribute ."><![CDATA[" .$tmpVal ."]]></" .$this->baseLabelField[$i] .">" .$aCapo;
			}else{
				$cont[] = $tab ."<" .$this->baseLabelField[$i] .$Attribute .">" .$tmpVal ."</" .$this->baseLabelField[$i] .">" .$aCapo;
			}
		}
		
		if($this->feedImageUrl != ""){
			$cont[] = $tab ."<image>" .$aCapo;
			$cont[] = $tab .$tab ."<title>" .$this->feedImageTitle ."</title>" .$aCapo;
			$cont[] = $tab .$tab ."<url>" .$this->GetFullLink($this->feedImageUrl) ."</url>" .$aCapo;	
			$cont[] = $tab .$tab ."<link>" .$this->feedImageLink ."</link>" .$aCapo;					
			$cont[] = $tab ."</image>" .$aCapo;
		}
		
		$nRec = 0;
		if($this->isMySqli ){
			$totalRows_recordset = mysqli_num_rows($this->recordset);
		}else{
			$totalRows_recordset = mysql_num_rows($this->recordset);
		}
		
		if($totalRows_recordset > 0){
			if($this->isMySqli ){
				mysqli_data_seek($this->recordset, 0);
			}else{
				mysql_data_seek($this->recordset, 0);
			}
			
			while ($this->row_recordset = ($this->isMySqli ? mysqli_fetch_assoc($this->recordset) : mysql_fetch_assoc($this->recordset))){
				
				$cont[] = $tab .$tab ."<item>" .$aCapo;
				if($this->itemTitle != ""){
					$cont[] = $tab .$tab .$tab ."<title>" .$this->EscapeValue($this->row_recordset[$this->itemTitle]) ."</title>" .$aCapo;
				}
				if($this->itemLink != "" || $this->itemLinkText != ""){
					if($this->itemLink != ""){
						$cont[] = $tab .$tab .$tab ."<link>" .$this->itemLinkText .$this->EscapeValue($this->row_recordset[$this->itemLink]) ."</link>" .$aCapo;
					}else{
						$cont[] = $tab .$tab .$tab ."<link>" .$this->itemLinkText ."</link>" .$aCapo;
					}
				}
				if($this->itemDescription != ""){
					$cont[] = $tab .$tab .$tab ."<description><![CDATA[" .$this->row_recordset[$this->itemDescription] ."]]></description>" .$aCapo;
				}
				if($this->itemAuthor != ""){
					$cont[] = $tab .$tab .$tab ."<author>" .$this->EscapeValue($this->row_recordset[$this->itemAuthor]) ."</author>" .$aCapo;
				}
				if($this->itemPubDate != ""){
					if(strtotime($this->row_recordset[$this->itemPubDate]) !== false){
						$cont[] = $tab .$tab .$tab ."<pubDate>" .$this->GetStringDate(getdate(strtotime($this->row_recordset[$this->itemPubDate]))) ."</pubDate>" .$aCapo;
					}else{
						$cont[] = $tab .$tab .$tab ."<pubDate></pubDate>" .$aCapo;
					}
				}
			
				for($y=0; $y<count($this->itemRecField); $y++){	
				
					if($this->itemTypeTag[$y] == "Date"){
						$tmpVal = $this->row_recordset[$this->itemRecField[$y]];
						if(strtotime($tmpVal) !== false){
							$tmpVal = $this->GetStringDate(getdate(strtotime($tmpVal)));
						}else{
							$tmpVal = "";
						}
					}else if($this->itemTypeTag[$y] == "Text"){
						$tmpVal = $this->EscapeValue($this->row_recordset[$this->itemRecField[$y]]);
					}else{
						$tmpVal = $this->row_recordset[$this->itemRecField[$y]];
					}
					if($this->itemAttrName[$y] != ""){
						$Attribute = " " .$this->itemAttrName[$y] ."=\"" .$this->SearchValue($this->itemAttrValue[$y]) ."\" ";
					}else{
						$Attribute = "";
					}
					if($this->itemTypeTag[$y] == "Memo"){
						$cont[] = $tab .$tab .$tab ."<" .$this->itemLabelField[$y] .$Attribute ."><![CDATA[" .$tmpVal ."]]></" .$this->itemLabelField[$y] .">" .$aCapo;
					}else{
						$cont[] = $tab .$tab .$tab ."<" .$this->itemLabelField[$y] .$Attribute .">" .$tmpVal ."</" .$this->itemLabelField[$y] .">" .$aCapo;
					}
				}
			
				$cont[] = $tab .$tab ."</item>" .$aCapo;
				$nRec ++;
				if(strtoupper($this->numberOfRecord) != "ALL"){
					if(intval($this->numberOfRecord) <= $nRec){
						break;
					}
				}
			}
		}
		
		$cont[] = $tab ."</channel>" .$aCapo;
		$cont[] = "</rss>" .$aCapo;
		
		$RssContent = implode("", $cont);
		
		ob_clean();
		ob_start();
		header('Content-type: text/xml');
		//header('Content-Length: ' .strlen($RssContent));
		if($this->fileName != ""){
			header('Content-disposition: attachment; fileName="' .$this->fileName .'";');
		}
				
		echo $RssContent;
		ob_end_flush();
		exit();		
		
	}
	
	function SearchValue($str){
		$retStr = "";		
		$retStr = $this->row_recordset[$str];
		if(empty($retStr)){
			$retStr	= "";
		}
		return $retStr;
	}
		
	function GetStringDate($d){		
		$tmp = "";
		$tmp .= $this->GetLetterDay($d['wday']);
		$tmp .= ", " .$d['mday'];
		$tmp .= " " .$this->GetLetterMonth($d['mon']);
		$tmp .= " " .$d['year'];
		$tmp .= " " .str_pad($d['hours'], 2, "0", STR_PAD_LEFT);
		$tmp .= ":" .str_pad($d['minutes'], 2, "0", STR_PAD_LEFT);
		$tmp .= ":" .str_pad($d['seconds'], 2, "0", STR_PAD_LEFT);
		$tmp .= " " .$this->timeZone;
		return $tmp;
	}
			
	function GetLetterDay($d){
		$tmpDay = preg_split("/,/", "Sun,Mon,Tue,Wed,Thu,Fri,Sat");
		return $tmpDay[intval($d)];
	}
	
	function GetLetterMonth($m){
		$tmpMonth = preg_split("/,/", ",Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec");
		return $tmpMonth[intval($m)];
	}
		
	function EscapeValue($valueStr){
		if(empty($valueStr)){ 
			return "";
		}else{
			$valueStr = $valueStr ."";
			$valueStr = htmlspecialchars($valueStr);			
			return $valueStr;
		}
	}
	
	function GetEvalValue($valueStr){
		$valore = "";
		if(empty($valueStr) || strlen($valueStr) == 0 || $valueStr == ""){
			$valore = "";
		}else{
			$valore = $valueStr;			
			$valore = preg_replace("/@_ec_ho_@/i", "", $valore);
			$valore = preg_replace("/@_dollar_@/i", "$", $valore);
			$valore = preg_replace("/@_dot_comma_@/i", "", $valore);		
			$valore = preg_replace("/@_''_@/i", "\"", $valore);
			
			while(strpos($valore, "@_start_@") !== false){
				$inizio = strpos($valore, "@_start_@");
				$fine = strpos($valore, "@_end_@", $inizio);
				if($inizio === false || $fine == false){
					break;	
				}
				$inizio += 9;
				$lung = $fine - $inizio;
				if($lung < 0){
					break;	
				}
                $str = substr($valore, $inizio, $lung);
                $result = @eval($str);
				if($result === false || $result == null){
					$result = $str;	
				}
				$valore = trim(substr($valore, 0, $inizio - 9) .$result .substr($valore, $fine + 7));
			}
			/*
			while instr(retStr,"@_start_@")>0
				inizio = instr(retStr,"@_start_@") + 9
				fine = instr(inizio,retStr,"@_end_@")
				lung = fine-inizio
				retStr = left(retStr,inizio-10) & eval(mid(retStr,inizio,lung)) & mid(retStr,fine + 7)
			wend
			*/
		}
		return $valore;
	}
	
	function GetFullLink($LinkVal){
		if(strtolower(substr($LinkVal, 0, 7)) != "http://"){
			if(substr($LinkVal, -1) != "/"){
				//'LinkVal = LinkVal & "/"
			}
			$LinkVal = "http://" .$_SERVER["HTTP_HOST"] .$LinkVal;
		}
		return $LinkVal;
	}

}

?>