<?php
//**********************************
// http://www.DwZone.it
// Xml Writer
// Copyright (c) DwZone.it 2000-2005
//**********************************

include('dwzIO.php');
include('dwzString.php');

class dwzXmlExport
{
	
	var $Encoding,
		$CodePage,
		$recordset,
		$cname,
		$fileName,
		$numberOfRecord,
		$StartOnEvent,
		$StartOnValue,
		$ExportAs,
		$RootLabel,
		$RowLabel,
		
		$ItemLabel,
		$ItemRecField,
		$ItemFormat,
		$ItemType;

	
	function addItem($Label, $Rec, $Format, $sType){
		if($Label == "dwz_cname"){
			$this->cname = $Rec;
			return;
		}
		//ItemCount = ItemCount + 1
		//ReDim Preserve ItemLabel(ItemCount)
		//ReDim Preserve ItemRecField(ItemCount)
		//ReDim Preserve ItemFormat(ItemCount)
		//ReDim Preserve ItemType(ItemCount)
		
		$this->ItemLabel[] = $Label;
		$this->ItemRecField[] = $Rec;
		$this->ItemFormat[] = $Format;
		$this->ItemType[] = $sType;
	}
	
	function setrecordset (&$rs){
		$this->recordset = $rs;
	}
	
	function SetEncoding($param){
		$tmp = preg_split("/;/", $param);
		$this->Encoding = $tmp[0];
		$this->CodePage = $tmp[1];
	}	
		
	function SetfileName($param){
		if($param != ""){
			$this->fileName = trim($param);
		}else{
			$this->fileName = "Export.xml";
		}
	}
	
	function SetnumberOfRecord($param){
		if(strtoupper($param) != "ALL"){
			if(!doubleval($param)){
				$param = "ALL";
			}
		}
		$this->numberOfRecord = trim($param);
	}
	
	function SetStartOn($param1, $param2){
		$this->StartOnEvent = $param1;
		$this->StartOnValue = $param2;
	}
	
	function SetExportAs($param){
		$this->ExportAs = $param;
	}
	
	function SetRootLabel($param){
		$this->RootLabel = $param;
	}
	
	function SetRowLabel($param){
		$this->RowLabel = $param;
	}		
	
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
	}
	
	function Init(){
		$this->recordset = null;
		$this->ItemLabel = array();
		$this->ItemRecField = array();
		$this->ItemFormat = array();
		$this->ItemType = array();
	}
	
	function Start(){
		$retStr = false;
		switch(strtoupper($this->StartOnEvent)){
		case "GET":
			if(isset($_GET[$this->StartOnValue]) && $_GET[$this->StartOnValue] != ""){
				$retStr = true;
			}
			break;
		case "POST":
			if(isset($_POST[$this->StartOnValue]) && $_POST[$this->StartOnValue] != ""){
				$retStr = true;
			}
		case "SESSION":
			if(isset($_SESSION[$this->StartOnValue]) && $_SESSION[$this->StartOnValue] != ""){
				$retStr = true;
			}
			break;
		case "COOKIE":
			if(isset($_COOKIE[$this->StartOnValue]) && $_COOKIE[$this->StartOnValue] != ""){
				$retStr = true;
			}
		case "ONLOAD":
			$retStr = true;
		}
		return $retStr;
	}
	
	
	function Execute(){
		if(!$this->Start()){
			return;
		}
		//If Not isObject(recordset) Then
		//	Response.write "<strong>DwZone - XML Export Error.</strong><br/>The recordset is not valid"
		//	Exit sub
		//End If
		if(count($this->ItemLabel) < 1){
			ob_clean();
			echo "<strong>DwZone - XML Export Error.</strong><br/>No Item defined";
			exit();
		}
				
		$cont = array();
		$aCapo = "\n";
		$tab = "\t";
		
		$cont[] = "<" ."?xml version=\"1.0\" encoding=\"" .$this->Encoding ."\"?>" .$aCapo;
		$cont[] = "<" .$this->RootLabel .">" .$aCapo;
				
		$nRec = 0;
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
			
			while ($this->row_recordset = ($this->IsMySqli() ? mysqli_fetch_assoc($this->recordset) : mysql_fetch_assoc($this->recordset))){
			
				if($this->ExportAs == "Nodes"){
					$cont[] = $tab ."<" .$this->RowLabel .">" .$aCapo;
		
					for($i=0; $i<count($this->ItemRecField); $i++){
					
						$strValue = $this->row_recordset[$this->ItemRecField[$i]] ."";
						if($strValue != "" && $this->ItemFormat[$i] != "String"){
							$strValue = $this->FormatValue($strValue, $this->ItemFormat[$i]);
						}
													
						$cont[] = $tab .$tab ."<" .$this->ItemLabel[$i] .">";
						if($this->ItemType[$i] == "Multiline"){
							$cont[] = "<![CDATA[";
						}
						if($this->ItemType[$i] == "Line"){
							$strValue = $this->EscapeValue($strValue);
						}
						$cont[] = $strValue;
						
						if($this->ItemType[$i] == "Multiline"){
							$cont[] = "]]>";
						}
						$cont[] = "</" .$this->ItemLabel[$i] .">" .$aCapo;
					}
				
					$cont[] = $tab ."</" .$this->RowLabel .">" .$aCapo;
					
				}else{
					$cont[] = $tab ."<" .$this->RowLabel;
		
					for($i=0; $i<count($this->ItemRecField); $i++){	
						$strValue = $this->row_recordset[$this->ItemRecField[$i]] ."";
						
						if($strValue != "" && $this->ItemFormat[$i] != "String"){
							$strValue = $this->FormatValue($strValue, $this->ItemFormat[$i]);
						}
						
						$cont[] = " " .$this->ItemLabel[$i] ."=\"" .$this->EscapeValue($strValue) ."\"";
					}				
					$cont[] = " />" .$aCapo;
				}
			
				$nRec ++;
				if($this->numberOfRecord != "ALL"){
					if(intval($this->numberOfRecord) <= $nRec){
						break;
					}
				}
			}
		}
		
		$cont[] = "</" .$this->RootLabel .">" .$aCapo;
		
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
		//Response.AddHeader "Pragma", "public"
		//Response.AddHeader "Expires", "Thu, 19 Nov 1981 08:52:00 GMT"
		//Response.AddHeader "Cache-Control", "must-revalidate, post-check=0, pre-check=0"
		//Response.AddHeader "Cache-Control", "no-store, no-cache, must-revalidate"
		//Response.AddHeader "Cache-Control", "private"
		//'response.codepage = CodePage
		//Response.CharSet = Encoding
		//Response.ContentType = "text/xml"
		//Response.AddHeader "Content-Length", len(RssContent)
		//If fileName <> "" Then
		//	Response.AddHeader "Content-disposition", "attachment; fileName=""" & fileName & """;"
		//End If
		//Response.write RssContent
		//Response.Flush()
		//Response.End()		
		
	}
		
	function EscapeValue($valueStr){
		if(empty($valueStr)){ 
			return "";
		}else{
			$valueStr = $valueStr ."";
			$valueStr = preg_replace("/&amp;/i", "&", $valueStr);
			$valueStr = preg_replace("/&/i", "&amp;", $valueStr);
			$valueStr = preg_replace("/>/", "&gt;", $valueStr);
			$valueStr = preg_replace("/</", "&lt;", $valueStr);
			$valueStr = preg_replace("/\n/", "", $valueStr);
			$valueStr = preg_replace("/\r/", "", $valueStr);
			return $valueStr;
		}
	}
	
	function FormatValue($strValue, $Format){
		if(strtolower(substr($Format, 0, 6)) == "number"){
			return $this->FormatAsNumber($strValue, $Format);
		}elseif(strtolower(substr($Format, 0, 4)) == "date"){
			return $this->FormatAsDate($strValue, $Format);
		}elseif(strtolower(substr($Format, 0, 7)) == "boolean"){
			return $this->FormatAsChk($strValue, $Format);
		}else{
			return $strValue;
		}
	}
	
	function FormatAsNumber($strValue, $Format){
		$retStr = "";
		if(floatval($strValue)){
			$strValue = floatval($strValue);
		}else{
			$strValue = 0;
		}
		$dec_point = $this->GetDecPoint();
		$thousands_sep = ""; //$this->GetThousandSep();
		
		switch($Format){
		case "Number (Default)":		
			$retStr = number_format($strValue);
			break;
		case "Number (0 decimal)":
			$retStr = number_format($strValue,0,$dec_point,$thousands_sep);
			break;
		case "Number (1 decimal)":
			$retStr = number_format($strValue,1,$dec_point,$thousands_sep);
			break;
		case "Number (2 decimal)":
			$retStr = number_format($strValue,2,$dec_point,$thousands_sep);
			break;
		case "Number (3 decimal)":
			$retStr = number_format($strValue,3,$dec_point,$thousands_sep);
			break;
		case "Number (4 decimal)":
			$retStr = number_format($strValue,4,$dec_point,$thousands_sep);
			break;
		case "Number (5 decimal)":
			$retStr = number_format($strValue,5,$dec_point,$thousands_sep);
			break;
		default:
			$retStr = $strValue;
		}
		return $retStr;
	}
	
	function GetDecPoint(){
		$tmp = number_format(0.1,1);
		return substr($tmp, 1, 1);
	}
	
	function GetThousandSep(){
		$tmp = number_format(1000,0);
		return substr($tmp, 1, 1);
	}
	
	function FormatAsChk($strValue, $Format){
		$tmpFormat = preg_replace("/Boolean/i", "", $Format);
		$tmpFormat = preg_replace("/\(/", "", $tmpFormat);
		$tmpFormat = preg_replace("/\)/", "", $tmpFormat);
		$tmpValue = preg_split("/\//", trim($tmpFormat));
		if($strValue){
			return $tmpValue[0];
		}else{
			return $tmpValue[1];
		}
	}
	
	function ConvertDateToNumber($str){
		if(strtotime($str) === false){
			return "";
		}
		$date = getdate(strtotime($str, 0));
		$dateto = $date['mday'] ."/" .$date['mon'] ."/" .$date['year'];
		$giorni = dateDiff('d', "01/01/1970", $dateto);
		$giorni += 25569;	//thye days from 01/01/1900 to 01/01/1970
		return $giorni;
		//40192.517361111109">14/01/2010 12.25		
		//$myDate = getdate(strtotime($str));		
		//$time = mktime($myDate['hours'], $myDate['minutes'], $myDate['seconds'], $myDate['mon'] , $myDate['mday'], $myDate['year']); 
		//return ""; //$time;
	}
	
	function FormatAsDate($strValue, $Format){
		if(strtotime($strValue) === false){
			return "";
		}
		
		$myDate = getdate(strtotime($strValue));
		if($Format == "Date yyyy-mm-ddT00:00:00+00:00"){
			$d = new DateTime($strValue);
			$retStr = $d->format("c");
		}else{
			$retStr = trim(preg_replace("/DATE/i", "", $Format));		
			$retStr = preg_replace("/DD/i", str_pad($myDate['mday'], 2, "0", STR_PAD_LEFT), $retStr);
			$retStr = preg_replace("/MM/i", str_pad($myDate['mon'], 2, "0", STR_PAD_LEFT), $retStr);
			$retStr = preg_replace("/YYYY/i", $myDate['year'], $retStr);
			$retStr = preg_replace("/h/i", str_pad($myDate['hours'], 2, "0", STR_PAD_LEFT), $retStr);
			$retStr = preg_replace("/m/i", str_pad($myDate['minutes'], 2, "0", STR_PAD_LEFT), $retStr);
			$retStr = preg_replace("/s/i", str_pad($myDate['seconds'], 2, "0", STR_PAD_LEFT), $retStr);		
		}
		return trim($retStr);
	}
	
	function FormatAsColor($strValue, $Format){
		$strValue .= "";
		if($strValue != ""){
			$strValue = preg_replace("/#/", "0x", $strValue);
		}
		return trim($strValue);
	}
	
	function FormatAsTime($strValue, $Format){
		if(strtotime($strValue) === false){
			return "";
		}
		
		$myDate = getdate(strtotime($strValue));
		$retStr = trim(preg_replace("/TIME/i", "", $Format));	
		$retStr = preg_replace("/h/i", str_pad($myDate['hours'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/m/i", str_pad($myDate['minutes'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/s/i", str_pad($myDate['seconds'], 2, "0", STR_PAD_LEFT), $retStr);		
		return trim($retStr);
	}
	
}

?>