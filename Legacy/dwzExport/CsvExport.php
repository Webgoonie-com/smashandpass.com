<?php

//**********************************
// http://www.DwZone.it
// Csv Writer
// Copyright (c) DwZone.it 2000-2005
//**********************************

include('dwzIO.php');
include('dwzString.php');

class dwzCsvExport
{
	
	var $recordset,
		$row_recordset,
		$cname,
		$FileName,
		$NumberOfRecord,
		$StartOnEvent,
		$StartOnValue,
		$FieldSeparator,
		$FieldLabel,
		$EncloseField;
	
	var $ItemLabel,
		$ItemRecField,
		$ItemFormat;

	
	function addItem($Label, $Rec, $Format){
		if($Label == "dwz_cname"){
			$this->cname = $Rec;
			return;
		}
		//ItemCount = ItemCount + 1
		//ReDim Preserve ItemLabel(ItemCount)
		//ReDim Preserve ItemRecField(ItemCount)
		//ReDim Preserve ItemFormat(ItemCount)		
		array_push($this->ItemLabel, $Label);
		array_push($this->ItemRecField, $Rec);
		array_push($this->ItemFormat, $Format);
	}
	
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
	}
	
	function setRecordset (&$rs){
		$this->recordset = $rs;
	}
	
	function SetEncloseField($param){
		if(strtoupper($param) == "SA"){
			$this->EncloseField = "'";
		}elseif(strtoupper($param) == "DA"){
			$this->EncloseField = "\"";
		}elseif(strtoupper($param) == "P"){
			$this->EncloseField = "|";
		}
	}
	
	function SetFileName($param){
		if($param != ""){
			$this->FileName = trim($param);
		}else{
			$this->FileName = "Export.csv";
		}
	}
	
	function SetNumberOfRecord($param){
		if(strtoupper($param) != "ALL"){
			if(is_nan($param)){
				$param = "ALL";
			}
		}
		$this->NumberOfRecord = trim($param);
	}
	
	function SetStartOn($param1, $param2){
		$this->StartOnEvent = $param1;
		$this->StartOnValue = $param2;
	}
	
	function SetFieldSeparator($param){
		if(strtoupper($param) == "TAB"){
			$this->FieldSeparator = "\t";
		}else{
			$this->FieldSeparator = $param;
		}
	}
	
	function SetFieldLabel($param){
		if(strtolower($param) == "true"){
			$this->FieldLabel = true;
		}else{
			$this->FieldLabel = false;
		}
	}
				
	
	function Init(){
		$this->ItemLabel = array();
		$this->ItemRecField = array();
		$this->ItemFormat = array();
		$this->recordset = null;
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
		
		if($this->FieldLabel){
			$newLine = "";
			for($i=0; $i<count($this->ItemLabel); $i++){				
				if($newLine != ""){
					$newLine .= $this->FieldSeparator;
				}
				$newLine .= $this->EscapeValue($this->ItemLabel[$i]);
			}
			$newLine .= $aCapo;
			array_push($cont, $newLine);
		}
				
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
					
				$newLine = "";
				for($i=0; $i<count($this->ItemRecField); $i++){
					$strValue = $this->row_recordset[$this->ItemRecField[$i]] ."";
					
					if($strValue != "" && $this->ItemFormat[$i] != "String"){
						$strValue = $this->FormatValue($strValue, $this->ItemFormat[$i]);
					}
					$strValue = $this->EscapeValue($strValue);
										
					if($newLine != ""){
						$newLine .= $this->FieldSeparator;
					}					
					$newLine .= $this->EncloseField .$strValue .$this->EncloseField;					
				}
				array_push($cont, $newLine .$aCapo);
				
				$nRec ++;
				if(strtoupper($this->NumberOfRecord) != "ALL"){
					if(intval($this->NumberOfRecord) <= $nRec){
						break;
					}
				}			
			}
		}
		
		$RssContent = implode("", $cont);
		
		ob_clean();
		
		//header('Pragma: public');
		//header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		//header('Cache-Control: no-store, no-cache, must-revalidate');
		//header('Cache-Control: private');
		header('Content-type: text/csv');
		header('Content-Length: ' .strlen($RssContent));
		header('Content-disposition: attachment; fileName="' .$this->FileName .'";');
		
		echo $RssContent;
		
		exit();		
				
		
	}
		
	function EscapeValue($valueStr){
		if(strlen($valueStr) == 0){
			return "";
		}else{
			$valueStr = $valueStr ."";
			$valueStr = preg_replace("/" .$this->FieldSeparator ."/", "", $valueStr);
			//$valueStr = htmlspecialchars($valueStr);
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
	
	function FormatAsDate($strValue, $Format){
		if(strtotime($strValue) === false){
			return "";
		}
		
		if($Format == "Date yyyy-mm-ddT00:00:00+00:00"){
			$d = new DateTime($strValue);
			$retStr = $d->format("c");
		}else{
			$myDate = getdate(strtotime($strValue));
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
	
}

?>