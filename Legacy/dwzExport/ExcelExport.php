<?php
//**********************************
// http://www.DwZone.it
// Excel Writer
// Copyright (c) DwZone.it 2000-2005
//**********************************
include('dwzIO.php');
include('dwzString.php');


class dwzExcelExport
{
	
	var $recordset,
		$row_recordset,
		$cname,
		$FileName,
		$NumberOfRecord,
		$StartOnEvent,
		$StartOnValue,
		
		$FieldLabel,
		$StringApex,
		
		$ItemLabel,
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
		
	function setRecordset(&$rs){
		$this->recordset = $rs;
	}
	
	function setStringApex($param){
		if(strtoupper($param) == "TRUE"){
			$this->StringApex = true;
		}else{
			$this->StringApex = false;
		}
	}
	
	function SetFileName($param){
		if($param != ""){
			$this->FileName = trim($param);
		}else{
			$this->FileName = "Export.xls";
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
	
	function SetFieldLabel($param){
		if(strtoupper($param) == "TRUE"){
			$this->FieldLabel = true;
		}else{
			$this->FieldLabel = false;
		}
	}
	
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
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
		
		
		$cont[] = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">";
		
		$cont[] = "<head>";
		$cont[] = "<meta name=Generator content=\"Microsoft Excel 9\">";
		
		
		$cont[] = "<style>" .$aCapo;
		$cont[] = "table";
		$cont[] = "	{mso-displayed-decimal-separator:\"\\,\";";
		$cont[] = "	mso-displayed-thousand-separator:\"\\.\";}" .$aCapo;
		$cont[] = ".xl24";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_0";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_1";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\\.0\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_2";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\\.00\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_3";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\\.000\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_4";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\\.0000\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl25_5";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"0\\.00000\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl26";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"dd\\/mm\\/yyyy\";";
		$cont[] = "white-space:normal;}" .$aCapo;
		
		$cont[] = ".xl28";
		$cont[] = "{";
		$cont[] = "mso-style-parent:style0;";
		$cont[] = "mso-number-format:\"\\@\";";
		$cont[] = "border:.5pt solid windowtext;";
		$cont[] = "white-space:normal;";
		$cont[] = "}" .$aCapo;
		
		$cont[] = ".xBody";
		$cont[] = "{mso-style-parent:style0;";
		$cont[] = "border:.5pt solid windowtext;}" .$aCapo;
				
		$cont[] = "</style>" .$aCapo;
		$cont[] = "</head>" .$aCapo;
		
		$cont[] = "<body class=xBody >" .$aCapo;
		$cont[] = "<table>" .$aCapo;
		
		if($this->FieldLabel){
			$newLine = "<tr>";
			for($i=0; $i<count($this->ItemLabel); $i++){				
				$newLine .= "<td>" .$this->ItemLabel[$i] ."</td>";
			}
			$newLine .= "</tr>";			
			$cont[] = $newLine .$aCapo;
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
			
				$newLine = "<tr>";
				for($i=0; $i<count($this->ItemLabel); $i++){
					$strValue = $this->row_recordset[$this->ItemRecField[$i]] ."";
										
					if($strValue != "" && $this->ItemFormat[$i] != "String"){
						$strValue = $this->FormatValue($strValue, $this->ItemFormat[$i]);
					}
					
					if(substr($this->ItemFormat[$i], 0, 6) == "Number"){
						$xFormat = "class=xl25_" .substr($this->ItemFormat[$i], 8, 1);
						
						if($this->GetDecPoint() == ","){
							$val = preg_replace("/,/", ".", $strValue);
						}else{
							$val = 	$strValue;
						}
						$xFormat .= " u1:num=\"" .$val ."\"";
						$xFormat .= " x:num=\"" .$val ."\"";
						
					}elseif(substr($this->ItemFormat[$i], 0, 4) == "Date" && $strValue != ""){
						$xFormat = "align=right class=xl26 x:num=\"" .$this->ConvertDateToNumber($strValue) ."\"";
						//$xFormat = "align=right class=xl26 ";
					}elseif(substr($this->ItemFormat[$i], 0, 6) == "String" && $this->StringApex){
						$xFormat = "x:str=\"" ."'" .$strValue ."'" ."\"";
						
					}elseif(substr($this->ItemFormat[$i], 0, 6) == "String" && !$this->StringApex){
						$xFormat = " class=xl28 ";
						
					}else{
						$xFormat = "";
					}
					
					$newLine .= "<td " .$xFormat ." >" .$strValue ."</td>";
				}
				$newLine .= "</tr>";
				
				$cont[] = $newLine .$aCapo;
				
				$nRec ++;
				if(strtoupper($this->NumberOfRecord) != "ALL"){
					if(intval($this->NumberOfRecord) <= $nRec){
						break;
					}
				}
			}
		}
		
		$cont[] = "</table>" .$aCapo;
		$cont[] = "</body>" .$aCapo;
				
		$RssContent = implode("", $cont);
		
		ob_clean();
		
		//header('Pragma: public');
		//header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		//header('Cache-Control: no-store, no-cache, must-revalidate');
		//header('Cache-Control: private');
		header('Content-type: application/vnd.ms-excel');
		header('Content-Length: ' .strlen($RssContent));
		header('Content-disposition: attachment; fileName="' .$this->FileName .'";');
		
		echo $RssContent;
		
		exit();		
		
		//Response.Clear()
		//'Response.AddHeader "Pragma", "public"
		//'Response.AddHeader "Expires", "Thu, 19 Nov 1981 08:52:00 GMT"
		//'Response.AddHeader "Cache-Control", "must-revalidate, post-check=0, pre-check=0"
		//'Response.AddHeader "Cache-Control", "no-store, no-cache, must-revalidate"
		//'Response.AddHeader "Cache-Control", "private"
		//Response.ContentType = "application/vnd.ms-excel"
		//Response.AddHeader "Content-Length", len(RssContent)
		//Response.AddHeader "Content-disposition", "attachment; filename=""" & FileName & """;"
		//Response.write RssContent
		//Response.Flush()
		//Response.End()		
		
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
		
		$sec = ($date['hours'] * 60 * 60) + ($date['minutes'] * 60) + $date['seconds'];
		if($sec != 0){
			$sec_day = (24 * 60 * 60);
			$decimal = $sec / $sec_day;
			$giorni += $decimal;
		}
		return $giorni;		
	}
	
	function FormatAsDate($strValue, $Format){
		if(strtotime($strValue) === false){
			return "";
		}
		
		$myDate = getdate(strtotime($strValue));
		$retStr = trim(preg_replace("/DATE/i", "", $Format));		
		$retStr = preg_replace("/DD/i", str_pad($myDate['mday'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/MM/i", str_pad($myDate['mon'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/YYYY/i", $myDate['year'], $retStr);
		$retStr = preg_replace("/h/i", str_pad($myDate['hours'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/m/i", str_pad($myDate['minutes'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/s/i", str_pad($myDate['seconds'], 2, "0", STR_PAD_LEFT), $retStr);		
		return trim($retStr);
	}
		
	
}

?>


<?php

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */
    
    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);		
    }
    $difference = $dateto - $datefrom; // Difference in seconds
     
    switch($interval) {
     
    case 'yyyy': // Number of full years

        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;

    case "q": // Number of full quarters

        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;

    case "m": // Number of full months

        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;

    case 'y': // Difference between day numbers

        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

    case "d": // Number of full days

        $datediff = floor($difference / 86400);
        break;

    case "w": // Number of full weekdays

        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

    case "ww": // Number of full weeks

        $datediff = floor($difference / 604800);
        break;

    case "h": // Number of full hours

        $datediff = floor($difference / 3600);
        break;

    case "n": // Number of full minutes

        $datediff = floor($difference / 60);
        break;

    default: // Number of full seconds (default)

        $datediff = $difference;
        break;
    }    

    return $datediff;

}

?>