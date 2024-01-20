<?php
//**********************************
// http://www.DwZone.it
// Atom Writer
// Copyright (c) DwZone.it 2000-2005
//**********************************
include('dwzIO.php');
include('dwzString.php');


class dwzAtomExport
{
	
	var $cong;
		
	var $encoding,
		$codePage,
		$pubDate,
		$fileName,
		$numberOfRecord,
		$startOnEvent,
		$startOnValue,
		$language,
		$timeZone;
		
	var $title,
		$titleType,
		$subTitle,
		$subTitleType,
		$link,
		$linkType,
		$authorName,
		$authorLink,
		$authorMail;
	
	var $recordset,
		$row_recordset,
		$cname,
		$itemTitle,
		$itemTitleType,
		$itemSummary,
		$itemSummaryType,
		$itemContent,
		$itemContentType,
		$itempubDate,
		$itemAuthorName,
		$itemAuthorLink,
		$itemAuthorLinkType,
		$itemAuthorMail,
		$itemLink,
		$itemLinkText,
		$itemLinkType;
	
	var $itemLabelField,
		$itemRecField,
		$itemTypeTag;
	//$itemCustomCount
	
	var $baseLabelField,
		$baseRecField,
		$baseTypeTag;
	//$BaseCustomCount
	
	
	
	function AddCustomItem($label, $rec, $type){
		//itemCustomCount = itemCustomCount + 1
		//ReDim Preserve itemLabelField(itemCustomCount)
		//ReDim Preserve itemRecField(itemCustomCount)
		//ReDim Preserve itemTypeTag(itemCustomCount)
		
		array_push($this->itemLabelField, $label);
		array_push($this->itemRecField, $rec);
		array_push($this->itemTypeTag, $type);		
	}
	
	function AddBaseCustomItem($label, $rec, $type){
		//BaseCustomCount = BaseCustomCount + 1
		//ReDim Preserve baseLabelField(BaseCustomCount)
		//ReDim Preserve baseRecField(BaseCustomCount)
		//ReDim Preserve baseTypeTag(BaseCustomCount)
		
		array_push($this->baseLabelField, $label);
		array_push($this->baseRecField, $rec);
		array_push($this->baseTypeTag, $type);
	}
	
	function SetRecordset(&$rs){
		$this->recordset = $rs;
	}
	
	function SetEncoding($param){
		$tmp = preg_split("/;/", $param);
		$this->encoding = $tmp[0];
		$this->codePage = $tmp[1];
	}	
	
	
	function SetAdditionalInfo($param){
		$tmp = preg_split("/" .$this->cong ."/", $param);
		$this->SetEncoding($tmp[0]);
		$this->pubDate = $tmp[1];
		$this->fileName = $tmp[2];
		$this->SetNumberOfRecord($tmp[3]);
		$this->startOnEvent = $tmp[4];
		$this->startOnValue = $tmp[5];
		$this->timeZone = $tmp[6];
		$this->language = $tmp[7];
		
		if(count($tmp) > 8){
			$this->cname = $tmp[8];
		}
	}
	
	
	
	function SetMasterInfo($param){
		$tmp = preg_split("/" .$this->cong ."/", $param);
		$this->title = $tmp[0];
		$this->titleType = $tmp[1];
		$this->subTitle = $tmp[2];
		$this->subTitleType = $tmp[3];
		$this->link = $tmp[4];
		$this->linkType = $tmp[5];
		$this->authorName = $tmp[6];
		$this->authorLink = $tmp[7];
		$this->authorMail = $tmp[8];
	}
	
	
	function SetItemMasterInfo($param){
		$tmp = preg_split("/" .$this->cong ."/", $param);
		$this->itemTitle = $tmp[0];
		$this->itemTitleType = $tmp[1];
		$this->itemSummary = $tmp[2];
		$this->itemSummaryType = $tmp[3];
		$this->itemContent = $tmp[4];
		$this->itemContentType = $tmp[5];
		$this->itempubDate = $tmp[6];		
	}	
	
	
	function SetItemAuthor($param){
		$tmp = preg_split("/" .$this->cong ."/", $param);
		$this->itemAuthorName = $tmp[0];
		$this->itemAuthorLink = $tmp[1];
		$this->itemAuthorLinkType = $tmp[2];
		$this->itemAuthorMail = $tmp[3];
	}
	
	function SetItemLink($param){
		$tmp = preg_split("/" .$this->cong ."/", $param);
		$this->itemLink = $tmp[0];
		$this->itemLinkText = $tmp[1];
		$this->itemLinkType = $tmp[2];
	}
	
	function SetNumberOfRecord($param){
		if(strtoupper($param) != "ALL"){
			if(is_nan($param)){
				$param = "ALL";
			}
		}
		$this->numberOfRecord = trim($param);
	}	
			
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
	}
	
	function Init(){
		$this->itemLabelField = array();
		$this->itemRecField = array();
		$this->itemTypeTag = array();
		$this->baseLabelField = array();
		$this->baseRecField = array();
		$this->baseTypeTag = array();
	
		$this->recordset = null;
		//itemCustomCount = -1
		//BaseCustomCount = -1
		$this->cong = "\|dwz\|";
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
			if(isset($_POST[startOnValue]) && $_POST[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;
		case "SESSION":
			if(isset($_SESSION[startOnValue]) && $_SESSION[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;						
		case "COOKIE":
			if(isset($_COOKIE[startOnValue]) && $_COOKIE[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;					
		case "ONLOAD":
			$retStr = true;
			break;
		}
		return $retStr;
	}
	
	function CreateLink($content, $linkType){
		//<link href="http://example.org/2003/12/13/atom-beispiel"/>
		$retStr = "<link href=\"" .$content ."\" ";
		if($linkType != "" && $linkType != "None"){
			$retStr .= "rel=\"" .strtolower($linkType) ."\"";
		}
		//retStr = retStr & " type=""" & "text/html" & """ "
		$retStr .= " />\n";
		return $retStr;
	}
	
	function CreateItem($sName, $sContent, $sType){
		$retStr = "";
		switch(strtolower($sType)){
		case "":
		case "none":
			$retStr .= "<" .$sName ." >";
			$retStr .= $sContent;
			$retStr .= "</" .$sName .">";
			break;
		case "text":
		case "data":
			$retStr .= "<" .$sName ." type=\"" ."text" ."\" >";
			$retStr .= $sContent;
			$retStr .= "</" .$sName .">";
			break;
		case "html":
			$retStr .= "<" .$sName ." type=\"" ."html" ."\" >";
			$retStr .= preg_replace("/>/", "&gt;", preg_replace("/</", "&lt;", $sContent));
			$retStr .= "</" .$sName .">";
			break;
		case "xhtml":
			$retStr .= "<" .$sName ." type=\"" ."xhtml" ."\" >";
			$retStr .= $sContent;
			$retStr .= "</" .$sName .">";
		}
		$retStr .= "\n";
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
		
		array_push($cont, "<" ."?xml version=\"1.0\" encoding=\"" .$this->encoding ."\"?>" .$aCapo);
		array_push($cont, "<feed xmlns=\"http://www.w3.org/2005/Atom\" xml:lang=\"" .$this->language ."\">" .$aCapo);
		
		if($this->title != ""){
			array_push($cont, $this->CreateItem("title", $this->title, $this->titleType));
		}
		if($this->subTitle != ""){
			array_push($cont, $this->CreateItem("subTitle", $this->subTitle, $this->subTitleType));
		}
		if($this->link != ""){
			array_push($cont, $this->CreateLink($this->link, $this->linkType));
		}
		if($this->authorName != "" || $this->authorLink != "" || $this->authorMail != ""){
			array_push($cont, "<author>" .$aCapo);
			if($this->authorName != ""){
				array_push($cont, $this->CreateItem("name", $this->authorName, ""));
			}
			if($this->authorLink != ""){
				array_push($cont, $this->CreateItem("uri", $this->authorLink, ""));
			}
			if($this->authorMail != ""){
				array_push($cont, $this->CreateItem("email", $this->authorMail, ""));
			}
			array_push($cont, "</author>" .$aCapo);
		}
		
		if($this->pubDate == "true"){
			//2003-12-13T18:30:02Z
			array_push($cont, $this->CreateItem("updated", $this->GetStringDate(getdate()), ""));
		}
		
		for($i=0; $i<count($this->baseTypeTag); $i++){
			$tmpVal = "";
			if($this->baseTypeTag[$i] == "Date"){
				$tmpVal = $this->GetEvalValue($this->baseRecField[$i]);				
				if(strtotime($tmpVal)){
					$tmpVal = $this->GetStringDate(strtotime($tmpVal));
				}else{
					$tmpVal = "";
				}
			}elseif($this->baseTypeTag[$i] == "Text"){
				$tmpVal = $this->EscapeValue($this->GetEvalValue($this->baseRecField[$i]));
			}else{
				$tmpVal = $this->GetEvalValue($this->baseRecField[$i]);
			}
			if($this->baseTypeTag[$i] == "Text" || $this->baseTypeTag[$i] == "Date"){
				array_push($cont, $this->CreateItem($this->baseLabelField[$i], $tmpVal, "Text"));
			}elseif($this->baseTypeTag[$i] == "None"){
				array_push($cont, $this->CreateItem($this->baseLabelField[$i], $tmpVal, ""));
			}else{
				array_push($cont, $this->CreateItem($this->baseLabelField[$i], $tmpVal, "Html"));
			}
		}
		
		if($this->IsMySqli()){
			$totalRows_recordset = mysqli_num_rows($this->recordset);
		}else{
			$totalRows_recordset = mysql_num_rows($this->recordset);
		}
		if($totalRows_recordset > 0){
			if($this->IsMySqli()){
				mysqli_data_seek($this->recordset, 0);	
			}else{
				mysql_data_seek($this->recordset, 0);
			}
			$nRec = 0;
			while ($this->row_recordset = ($this->IsMySqli() ? mysqli_fetch_assoc($this->recordset) : mysql_fetch_assoc($this->recordset))){
				
				array_push($cont, "<entry>" .$aCapo);
				
				if($this->itemTitle != ""){
					array_push($cont, $this->CreateItem("title", trim($this->row_recordset[$this->itemTitle]), $this->itemTitleType));
				}
				if($this->itemSummary != ""){
					array_push($cont, $this->CreateItem("summary", trim($this->row_recordset[$this->itemSummary]), $this->itemSummaryType));
				}
				if($this->itemContent != ""){
					array_push($cont, $this->CreateItem("content", trim($this->row_recordset[$this->itemContent]), $this->itemContentType));
				}
				if($this->itempubDate != ""){
					if($this->row_recordset[$this->itempubDate] != ""){
						if(strtotime(trim($this->row_recordset[$this->itempubDate]))){
							$val = trim($this->row_recordset[$this->itempubDate]);
							$d_val = getdate(strtotime($val));
							array_push($cont, $this->CreateItem("updated", $this->GetStringDate($d_val), ""));
						}
					}
				}
				
				if($this->itemAuthorName != "" || $this->itemAuthorLink != "" || $this->itemAuthorMail != ""){
					array_push($cont, "<author>" .$aCapo);
					if($this->itemAuthorName != ""){
						array_push($cont, $this->CreateItem("name", trim($this->row_recordset[$this->itemAuthorName]), ""));
					}
					if($this->itemAuthorLink != ""){
						array_push($cont, $this->CreateItem("uri", trim($this->row_recordset[$this->itemAuthorLink]), $this->itemAuthorLinkType));
					}
					if($this->itemAuthorMail != ""){
						array_push($cont, $this->CreateItem("email", trim($this->row_recordset[$this->itemAuthorMail]), ""));
					}
					array_push($cont, "</author>" .$aCapo);
				}
	
				if($this->itemLink != "" || $this->itemLinkText != ""){
					if($this->itemLink != ""){
						array_push($cont, $this->CreateLink($this->itemLinkText .$this->EscapeValue(trim($this->row_recordset[$this->itemLink])), $this->itemLinkType));
					}else{
						array_push($cont, $this->CreateLink($this->itemLinkText, $this->itemLinkType));
					}
				}
				
				for($i=0; $i<count($this->itemRecField); $i++){
					$tmpVal = "";
					if($this->itemTypeTag[$i] == "Date"){
						$tmpVal = $this->row_recordset[$this->itemRecField[$i]];
						if(strtotime($tmpVal)){
							$tmpVal = $this->GetStringDate(strtotime($tmpVal));
						}else{
							$tmpVal = "";
						}
					}elseif($this->itemTypeTag[$i] == "Text"){
						$tmpVal = $this->EscapeValue(trim($this->row_recordset[$this->itemRecField[$i]]));
					}else{
						$tmpVal = trim($this->row_recordset[$this->itemRecField[$i]]);
					}
					
					if($this->itemTypeTag[$i] == "Text" || $this->itemTypeTag[$i] == "Date"){
						array_push($cont, $this->CreateItem($this->itemLabelField[$i], $tmpVal, "Text"));
					}elseif($this->baseTypeTag[$i] == "None"){
						array_push($cont, $this->CreateItem($this->itemLabelField[$i], $tmpVal, ""));
					}else{
						array_push($cont, $this->CreateItem($this->itemLabelField[$i], $tmpVal, "Html"));
					}
				}
							
				array_push($cont, "</entry>" .$aCapo);
				
				$nRec ++;
				if($this->numberOfRecord != "ALL"){
					if(intval($this->numberOfRecord) <= $nRec){
						break;
					}
				}
				
			}
		}
		
		array_push($cont, "</feed>" .$aCapo);
				
		$RssContent = implode("\n", $cont);
		
		ob_clean();
		
		//header('Pragma: public');
		//header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		//header('Cache-Control: no-store, no-cache, must-revalidate');
		//header('Cache-Control: private');
		header('Content-type: text/xml');
		header('Content-Length: ' .strlen($RssContent));
		if($this->fileName != ""){
			header('Content-disposition: attachment; fileName="' .$this->fileName .'";');
			//Response.AddHeader "Content-disposition", "attachment; fileName=""" & fileName & """;"
		}
		
		echo $RssContent;
		
		exit();
		
		
		//Response.Clear()
		//'Response.AddHeader "Pragma", "public"
		//'Response.AddHeader "Expires", "Thu, 19 Nov 1981 08:52:00 GMT"
		//'Response.AddHeader "Cache-Control", "must-revalidate, post-check=0, pre-check=0"
		//'Response.AddHeader "Cache-Control", "no-store, no-cache, must-revalidate"
		//'Response.AddHeader "Cache-Control", "private"
		//'response.codePage = codePage
		//Response.CharSet = encoding
		//Response.ContentType = "text/xml"
		//Response.AddHeader "Content-Length", len(RssContent)
		//If fileName <> "" Then
		//	Response.AddHeader "Content-disposition", "attachment; fileName=""" & fileName & """;"
		//End If
		//Response.write RssContent
		//Response.Flush()
		//Response.End()		
		
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
		//$d = getdate($mydate[0]);
		//'2003-12-13T18:30:02Z
		//'tmp = GetLetterDay(WeekDay(mydate,vbsunday))
		$tmp = $d['year']; 
		$tmp .= "-" .str_pad($d['mon'], 2, "0", STR_PAD_LEFT);
		$tmp .= "-" .str_pad($d['mday'], 2, "0", STR_PAD_LEFT);
		$tmp .= "T" .str_pad($d['hours'], 2, "0", STR_PAD_LEFT);
		$tmp .= ":" .str_pad($d['minutes'], 2, "0", STR_PAD_LEFT);
		$tmp .= ":" .str_pad($d['seconds'], 2, "0", STR_PAD_LEFT);
		$tmp .= "Z";
		return $tmp;
	}
	
	function GetLetterDay($d){
		$tmpDay = preg_split("/,/", ",Sun,Mon,Tue,Wed,Thu,Fri,Sat");
		return $tmpDay[intval(d)];
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
			$valueStr = preg_replace("/\n/", "", $valueStr);
			$valueStr = preg_replace("/\r/", "", $valueStr);
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