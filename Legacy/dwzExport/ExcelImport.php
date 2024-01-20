<?php

ob_start();
if(!isset($_SESSION)) 
{ 
	session_start(); 
}  

include('dwzIO.php');
include('dwzString.php');
include('dwzDataBase.php');
include('SetTempFolder.php');
include('PHPExcel.php');


//'**********************************
//' http://www.DwZone.it
//' Excel Import
//' Copyright (c) DwZone.it 2000-2005
//'**********************************
class dwzExcelImport
{
	var $debug = false;
	var $debug_sql = false;
	
	var $root,	
	$startOnEvent,
	$startOnValue,
	$redirectPage,
	$displayErrors,
	$filePath,
	$fullFilePath,
	$progress_key,
	$skipFirstRow,
	
	$hostname, 
	$database, 
	$username, 
	$password,
	$cname,
	$db,
	$table,
	$tableUniqueKey,
	$colIsNum,
	$onDuplicateEntry,
	$csvUniqueKey,
	$csvData,
	
	$itemFieldRec,
	$itemFormat,
	$itemFromValue,
	$itemReference,
	$itemColumn,
	
	$progressBar,
	$progressUpdate,
	$progressPagePath,
	$startTime,
	$totalLineNumber,
	
	$totalRows,
	$errMsg;
	
	
	function Additem($rec, $from, $format, $reference, $column){
		if($rec == "dwz_cname"){
			$this->cname = $column;
			return;
		}
		$this->itemFieldRec[] = $rec;
		$this->itemFromValue[] = $from;
		$this->itemFormat[] = $format;
		$this->itemReference[] = $reference;
		$this->itemColumn[] = $column;
	}
	
	function SetProgressBar($param){
		$tmp = preg_split("/@_@/", $param);
		$this->progressBar = $tmp[0];
		if(floatval($tmp[1]) == 0){
			$this->progressUpdate = 10;			
		}else{
			$this->progressUpdate = intval($tmp[1]);
		}
		$this->progressPagePath = $this->root ."dwzExport/";
	}
	
	function SetExtraData($param){
		$tmp = preg_split("/@_@/", $param);
		$this->root = $tmp[0];
		if(count($tmp) > 1){
			$this->skipFirstRow = $tmp[1];
		}else{
			$this->skipFirstRow = "false";
		}
	}
			
	function SetStartOn($param1,$param2){
		$this->startOnEvent = $param1;
		$this->startOnValue = $param2;
	}
	
	function SetRedirectPage($param){
		$this->redirectPage = $param;
	}
	
	function SetDisplayErrors($param){
		if(strtolower($param) == "true"){
			$this->displayErrors = true;
		}else{
			$this->displayErrors = false;
		}
	}
	
	function SetFilePath($param){
		$this->filePath = $param;
	}
		
	function SetConnection($host, $db, $user, $pwd){
		$this->hostname = $host;
		$this->database = $db;
		$this->username = $user;
		$this->password = $pwd;
	}
	
	function SetTable($param){
		$this->table = $param;
	}
	
	function SetTableUniqueKey($param){
		$this->tableUniqueKey = $param;
	}
	
	function SetColIsNum($param){
		if(strtolower($param) == "true"){
			$this->colIsNum = true;
		}else{
			$this->colIsNum = false;
		}
	}
	
	function SetOnDuplicateEntry($param){
		$this->onDuplicateEntry = $param;
	}
	
	function SetCsvUniqueKey($param){
		$this->csvUniqueKey = $param;
	}
	
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
	}
	
	function GetProgressKey(){
		return $this->progress_key;
	}
	
	function Init (){
		$this->itemFieldRec = array();
		$this->itemFormat = array();
		$this->itemFromValue = array();
		$this->itemReference = array();
		$this->itemColumn = array();
		$this->csvData = array();
		
		$this->totalRows = -1;
		$this->errMsg = array();
		//$_SESSION['dwzCsvImport'] = "";
		
		if(isset($_GET["excel_import_progress_key"]) && $_GET["excel_import_progress_key"] != ""){
			$this->progress_key = $_GET["excel_import_progress_key"];
			
		}elseif(isset($_POST["excel_import_progress_key"]) && $_POST["excel_import_progress_key"] != ""){
			$this->progress_key = $_POST["excel_import_progress_key"];
			
		}else{
			$this->progress_key = uniqid("");
		}
		$this->DeleteProgressFile();
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
		case "SESSION":
			if(isset($_SESSION[$this->startOnValue]) && $_SESSION[$this->startOnValue] != ""){
				$retStr = true;
			}
			break;
		case "COOKIE":
			if(isset($_COOKIE[$this->startOnValue]) && $_COOKIE[$this->startOnValue] != ""){
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
		if(count($this->itemFieldRec) < 1){
			ob_clean();
			echo "<strong>DwZone - CSV Import Error.</strong><br/>No item defined";
			exit();
		}
		
		if($this->filePath == ""){
			ob_clean();
			echo "<strong>DwZone - CSV Import Error.</strong><br/>The file path is void";
			exit();
		}
		
		$this->fullFilePath = dwzIO::GetRealPath($this->filePath); // $this->GetFilePath();
						
		if(!file_exists($this->fullFilePath)){
			$this->AddError( "101", "The file: " .$this->fullFilePath ." is not find", "getfilePath");
		}
		
		if(count($this->errMsg) > 0){
			$this->ResponseError();
			exit();
		}
		
		$this->ReadFromExcelContent();
		
		if(count($this->errMsg) > 0){
			$this->ResponseError();
			exit();
		}
		
		$this->ImportData();
		
		if($this->debug || $this->debug_sql){
			exit();
		}
		
		if(count($this->errMsg) > 0){
			$this->ResponseError();
			exit();
		}
						
		if($this->redirectPage != ""){
			$aaa = $this->redirectPage;
			header("location: " .$this->redirectPage);
			exit();
		}		
	}
		
	function ResponseError(){
		if($this->displayErrors){			
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
		}else{
			if($this->redirectPage != ""){
				header("location: " .$this.redirectPage);
				exit();
			}
		}
	}
	
	
	function ImportData(){
		
		$this->startTime = time();
        
		$this->db = new dwzDataBase();
		
		$this->db->SetConn($this->hostname,
						$this->database,
						$this->username,
						$this->password);
		
		$this->db->SetMySqli($this->IsMySqli());
		
		for($i=0; $i<=$this->totalRows; $i++){
			if($this->progressBar != ""){
				if($i == 0 || $i % $this->progressUpdate == 0){
					$sStato = "1";
					$sN_Line = $i + 1;
					$sT_Line = $this->totalRows + 1;
					$sstartTime =  time() - $this->startTime;
					$oper = "Import data";
					$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sstartTime, $oper);
				}
			}
			if($this->skipFirstRow == "true" && $i==0){
				//skip first row
			}else{
				if($this->onDuplicateEntry == "NoVerify"){
					$result = $this->CreateInsertQuery($i);
				}else{
					$recExists = $this->RecordExists($i);
					if($recExists){
						if($this->onDuplicateEntry == "Update"){
							$result = $this->CreateUpdateQuery($i);
						}elseif($this->onDuplicateEntry == "Skip"){
							$result = true;
						}else{
							$result = false;
							$this->AddError("110", "Row: " .($i + 1) ."- Err: Duplicate entry", "ImportData");
						}
					}else{
						$result = $this->CreateInsertQuery($i);
					}
				}
			}
		}
		
		$this->db->Close();
		
		if($this->progressBar != ""){
			$sStato = "DONE";
			$sN_Line = $this->totalRows + 1;
			$sT_Line = $this->totalRows + 1;
			$sstartTime =  time() - $this->startTime;
			$oper = "Import data completed";
			$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sstartTime, $oper);
		}			
	}
	
	function AddError($n, $d, $p){
		$this->errMsg[] = array("Number" => $n, "Description" => $d, "Position" => $p);
	}
	
	function CreateUpdateQuery($index){
				
		$update["table_name"] = $this->table;
		
		for($i=0; $i<count($this->itemReference); $i++){
			$value = $this->GetCsvData($index, $this->itemReference[$i], $this->itemFromValue[$i], $this->itemColumn[$i]);
			$value = $this->FormatValue($value, $this->itemFormat[$i]);
			$type = $this->GetFieldType($this->itemFormat[$i]);
			
			$def_value = "";
			$not_def_value = "";
			if($type == "defined"){
				$tmp = preg_split("/,/", $this->itemFormat[$i]);
				$def_value = $tmp[1];
				$not_def_value = $tmp[2];
			}
			
			$update["fields"][$i] = array(
									"name" => $this->itemFieldRec[$i],
									"value" => $value,
									"type" => $type,
									"def_value" => $def_value,
									"not_def_value" => $not_def_value									
									);
		}
		
		$update["where"][0] = array(
								"name" => $this->tableUniqueKey,
								"value" => $this->GetCsvData($index, "", "excel", $this->csvUniqueKey),
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		if($this->debug_sql){
			echo var_dump($update) ."\n\n";
		}
		
		$result = $this->db->Update($update);
						
		if($result !== true){
			$this->AddError("126", "Error in sql: " .$this->db.GetSql() , "CreateUpdateQuery");
			$this->AddError("126", "Error message: " .$result , "CreateUpdateQuery");
		}
		
		return $result;
	}
	
	
	function CreateInsertQuery($index){
			
		$insert["table_name"] = $this->table;
		
		for($i=0; $i<count($this->itemReference); $i++){
			$value = $this->GetCsvData($index, $this->itemReference[$i], $this->itemFromValue[$i], $this->itemColumn[$i]);
			$value = $this->FormatValue($value, $this->itemFormat[$i]);
			$type = $this->GetFieldType($this->itemFormat[$i]);
			
			$def_value = "";
			$not_def_value = "";
			if($type == "defined"){
				$tmp = preg_split("/,/", $this->itemFormat[$i]);
				$def_value = $tmp[1];
				$not_def_value = $tmp[2];
			}
			
			$insert["fields"][$i] = array(
									"name" => $this->itemFieldRec[$i],
									"value" => $value,
									"type" => $type,
									"def_value" => $def_value,
									"not_def_value" => $not_def_value									
									);
		}
		
		if($this->debug_sql){
			echo var_dump($insert) ."\n\n";
		}
		
		$result = $this->db->Insert($insert);
		
		if($result !== true){
			$this->AddError("127", "Error in sql: " .$this->db->GetSql() , "CreateInsertQuery");
			$this->AddError("127", "Error message: " .$result , "CreateInsertQuery");
		}
		
		return $result;		
	}
	
	function RecordExists($index){
		
		$select["table_name"] = $this->table;
		
		$select["fields"][0] = array(
								"name" => $this->tableUniqueKey,
								"value" => "",
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		$select["where"][0] = array(
								"name" => $this->tableUniqueKey,
								"value" => $this->GetCsvData($index, "", "excel", $this->csvUniqueKey),
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		$recordset = $this->db->Select($select);
		
		if($recordset === false){
			$this->AddError("128", "Error in sql: " .$this->db->GetSql() , "RecordExists");
			$this->AddError("128", "Error message: " .$result , "RecordExists");
		}		
				
		$result = false;
		if($this->IsMySqli()){
			if(mysqli_num_rows($recordset) > 0){
				$result = true;
			}			
		}else{
			if(mysql_num_rows($recordset) > 0){
				$result = true;
			}
		}
		return $result;
	}
	
	
	function GetCsvData($index, $strValue, $valueFrom, $column){
		if($valueFrom == ""){
			for($i=0; $i<count($this->itemReference); $i++){
				if(strtolower($this->itemReference[$i]) == strtolower($strValue)){
					$valueFrom = strtolower($this->itemFromValue[$i]);
					break;
				}
			}
		}else{
			$valueFrom = strtolower($valueFrom);
		}
		
		$retStr = "";
		switch($valueFrom){
		case "excel":
			$retStr = @$this->csvData[$index][$column - 1];
			break;
		case "get":
			$retStr = @$_GET[$strValue];
			break;
		case "post":
			$retStr = @$_POST[$strValue];
			break;		
		case "session":
			$retStr = @$_SESSION[$strValue];
			break;
		case "cookie":
			$retStr = @$_COOKIE[$strValue];
			break;
		case "entered":
			$retStr = $strValue;
			break;
		}
		return $retStr;
	}
	
		
	function ReadFromExcelContent(){
		$this->startTime = time();
		
		//	$inputFileType = 'Excel5';
		//  $inputFileType = 'Excel2007';
		//  $inputFileType = 'Excel2003XML';
		//  $inputFileType = 'OOCalc';
		//  $inputFileType = 'SYLK';
		//  $inputFileType = 'Gnumeric';
		//  $inputFileType = 'CSV';
		
		$part = dwzIO::GetFilePart($this->fullFilePath);
		$inputFileType = 'Excel5';
		if(strtolower($part["ext"] == ".xls")){
			$inputFileType = 'Excel5';
		}else if(strtolower($part["ext"] == ".xlsx")){
			$inputFileType = 'Excel2007';
		}
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
				
		$objPHPExcel = $objReader->load($this->fullFilePath);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		
		$this->totalLineNumber = $highestRow;
		$this->totalRows = -1;
		$firstLine = true;
						
		if($this->debug){
			ob_clean();
			echo '<table>' . "\n";
		}
		
		//echo "<tr><td>" .date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(40515)) ."</tr></td>"; 
		//echo "<tr><td>" .date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP(40515.0)) ."</tr></td>"; 
		
		for ($row = 1; $row <= $highestRow; ++$row) {
			if($this->debug){
				echo '<tr>' . "\n";
			}
			
			$row_data = array();
			$this->totalRows ++;
			
			for ($col = 0; $col <= $highestColumnIndex; ++$col) {
				if($this->debug){
					
					echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
				}
				$row_data[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();		
			}
			$this->csvData[$this->totalRows] = $row_data;
			
			if($this->debug){
				echo '</tr>' . "\n";
			}
			
			if($this->progressBar != ""){
				if( $firstLine || $this->totalRows % $this->progressUpdate == 0){
					$sStato = "1";
					$sN_Line = $this->totalRows + 1;
					$sT_Line = $this->totalLineNumber;
					$sStartTime =  time() - $this->startTime;
					$oper = "Read excel data";
					$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sStartTime, $oper);
				}
			}
			$firstLine = false;
			
		}
		if($this->debug){
			echo '</table>' . "\n";
			//exit();
		}
		
		
		
		/*
		$data = new Spreadsheet_Excel_Reader();

		//Set output Encoding.
		$data->setOutputEncoding("utf-8");	
		$data->setUTFEncoder("mb");
		$data->read($this->fullFilePath);
		
		$this->totalLineNumber = $data->sheets[0]['numRows'];			
		$this->totalRows = -1;
		$firstLine = true;
		
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			$this->totalRows ++;
			$row = array();
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {				
				$row[] = $data->sheets[0]['cells'][$i][$j];
			}
			$this->csvData[$this->totalRows] = $row;
			
			if($this->progressBar != ""){
				if( $firstLine || $this->totalRows % $this->progressUpdate == 0){
					$sStato = "1";
					$sN_Line = $this->totalRows + 1;
					$sT_Line = $this->totalLineNumber;
					$sStartTime =  time() - $this->startTime;
					$oper = "Read excel data";
					$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sStartTime, $oper);
				}
			}
			$firstLine = false;
		}
		*/
		
	}
	
	
	
	
	function GetFieldType($format){
		if(strtolower(substr($format, 0, 1)) == "s"){
			return "text";
			
		}elseif(strtolower(substr($format, 0, 2)) == "ni"){
			return "int";
		
		}elseif(strtolower(substr($format, 0, 1)) == "n"){
			return "double";
			
		}elseif(strtolower(substr($format, 0, 1)) == "d"){
			return "date";
			
		}elseif(strtolower(substr($format, 0, 1)) == "b"){
			return "defined";
			
		}else{
			return "text";
		}
	}

	
	
	function FormatValue($strValue, $format){
		if(strtolower(substr($format, 0, 1)) == "s"){
			return htmlentities($strValue);
			
		}elseif(strtolower(substr($format, 0, 1)) == "n"){
			return $this->FormatAsNumber($strValue, $format);
			
		}elseif(strtolower(substr($format, 0, 1)) == "d"){
			return $this->FormatAsDate($strValue, substr($format, 2));
			
		}elseif(strtolower(substr($format, 0, 1)) == "b"){
			return $this->FormatAsBoolean($strValue, $format);
			
		}else{
			return $strValue;
		}
	}
			
	function FormatAsBoolean($strValue, $format){
		if($strValue == ""){
			return "";
		}
		$tmp = preg_split("/,/", $format);
		if(strtolower($strValue) == strtolower($tmp[1])){
			return $strValue;
		}else{
			return "";
		}
	}
	
	function FormatAsDate($strValue, $format){
		
		$int = intval($strValue);
		$dec = $strValue - intval($strValue);
		if($dec != 0){
			$mysqldate = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($strValue));
		}else{
			$mysqldate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($strValue));
		}		
		return $mysqldate;
		
		/*
		if($strValue == ""){
			return "";
		}
		
		$day = "00";
		$month = "00";
		$year = "00";
		$hours = "00";
		$minutes = "00";
		$seconds = "00";
		
		$tmp = preg_split("/\s/", $strValue);		
		$data = $tmp[0];
		if(count($tmp) > 1){
			$time = $tmp[1];
		}else{
			$time = "00:00:00";
		}
		$tmp = preg_split("/:/", $time);
		$hours = $tmp[0];
		$minutes = $tmp[1];
		$seconds = $tmp[2];
		
		switch($format){
		case "DD/MM/YYYY":
		case "DD-MM-YYYY":
		case "DD.MM.YYYY":
		case "DD/MM/YY":
		case "DD-MM-YY":
		case "DD.MM.YY":
		case "DD/MM/YYYY hh:mm:ss":
		case "DD-MM-YYYY hh:mm:ss":
		case "DD.MM.YYYY hh:mm:ss":		 
		case "DD/MM/YY hh:mm:ss":
		case "DD-MM-YY hh:mm:ss":
		case "DD.MM.YY hh:mm:ss":
		 	if(substr($data, 2, 1) == "/" || substr($data, 2, 1) == "."){
				$tmp = preg_split("/\\" .substr($data, 2, 1) ."/", $data);
			}else{
				$tmp = preg_split("/" .substr($data, 2, 1) ."/", $data);
			}
			$day = $tmp[0];
			$month = $tmp[1];
			$year = $tmp[2];
			
			break;
		case "MM/DD/YYYY":
		case "MM-DD-YYYY":
		case "MM.DD.YYYY":																				 
		case "MM/DD/YY":
		case "MM-DD-YY":
		case "MM.DD.YY":
		case "MM/DD/YYYY hh:mm:ss":
		case "MM-DD-YYYY hh:mm:ss":
		case "MM.DD.YYYY hh:mm:ss":
		case "MM/DD/YY hh:mm:ss":
		case "MM-DD-YY hh:mm:ss":
		case "MM.DD.YY hh:mm:ss":
			if(substr($data, 2, 1) == "/" || substr($data, 2, 1) == "."){
				$tmp = preg_split("/\\" .substr($data, 2, 1) ."/", $data);
			}else{
				$tmp = preg_split("/" .substr($data, 2, 1) ."/", $data);
			}
			$day = $tmp[1];
			$month = $tmp[0];
			$year = $tmp[2];
			
			break;
		case "YYYYMMDD":
			$day = substr($data, 6, 2);
			$month = substr($data, 4, 2);
			$year = substr($data, 0, 4);
			break;
		case "YYMMDD":
			$day = substr($data, 4, 2);
			$month = substr($data, 2, 2);
			$year = substr($data, 0, 2);
			break;
		}
		
		if(strlen($year) == 2){
			$year = "20" .$year;
		}		
		
		$d = mktime(intval($hours), intval($minutes), intval($seconds), intval($month), intval($day), intval($year));
        $mysqldate = date( 'Y-m-d H:i:s', $d );
		return $mysqldate;
		*/
	}
	
	function GetDecPoint(){
		$tmp = number_format(0.1,1);
		return substr($tmp, 1, 1);
	}
	
	function GetThousandSep(){
		$tmp = number_format(1000,0);
		return substr($tmp, 1, 1);
	}
	
	function FormatAsNumber($strValue, $format){	
		if(strtolower(substr($format, 0, 2)) == "ni"){
			return intval($strValue);
		}else{
			$thouand = substr($format, 1, 1);
			$decimal = substr($format, 2, 1);
			if($thouand == "."){
				$thouand = "\\" .$thouand;
			}
			if($decimal == "."){
				$decimal = "\\" .$decimal;
			}
			$strValue = preg_replace("/" .$thouand ."/", "", $strValue);
			$strValue = preg_replace("/" .$decimal ."/", $this->GetDecPoint(), $strValue);			
			$val = floatval($strValue);
			return $val;
		}
	}
	
	function InsertProgressJs(){
		$vbcrlf = "\n";
		
		$retStr = "";
		$retStr .= "<script language=\"javascript\">" .$vbcrlf;
		$retStr .= "var GoUpload" .$vbcrlf;
		$retStr .= "var isMAC = (navigator.userAgent.toLowerCase().indexOf(\"mac\") != -1);" .$vbcrlf;
		$retStr .= "var isIE = document.all;" .$vbcrlf;
		$retStr .= "var isNS6 = (!document.all && document.getElementById ? true : false);" .$vbcrlf;
		$retStr .= "var isNS7 = (navigator.userAgent.toLowerCase().indexOf(\"netscape/7\") != -1);" .$vbcrlf;
		$retStr .= "var dwz_SendForm = false" .$vbcrlf;

		$retStr .= "function dwzImportProgressBar(){	" .$vbcrlf;
		$retStr .= "	if(dwz_SendForm){" .$vbcrlf;
		$retStr .= "		return true" .$vbcrlf;
		$retStr .= "	}	" .$vbcrlf;		
		if( $this->progressBar == "mac" ){ 
			$retStr .= "	dimW = 350" .$vbcrlf;
			$retStr .= "	dimH = 100" .$vbcrlf;
		}else{
			$retStr .= "	dimW = 350" .$vbcrlf;
			$retStr .= "	dimH = 210" .$vbcrlf;
		}		
		$retStr .= "	PosL = (screen.width-dimW)/2" .$vbcrlf;
		$retStr .= "	PosT = (screen.height-dimH)/2" .$vbcrlf;
				
		$retStr .= "	progressURL = '" .$this->progressPagePath ."ProgressBar/ProgressBar.php?ProgressPage=" .$this->progressBar ."&progress_key=" .$this->progress_key ."'" .$vbcrlf;
		$retStr .= "	mailWin = window.open(progressURL,'progressImportBarPage','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width='+dimW+',height='+dimH+',top='+PosT+',left='+PosL)" .$vbcrlf;
		$retStr .= "	dwz_SendForm = true" .$vbcrlf;
		$retStr .= "	setTimeout('dwzSendForm()',500)" .$vbcrlf;
		$retStr .= "	return false" .$vbcrlf;
		$retStr .= "}" .$vbcrlf;
		$retStr .= "function dwzSendForm(){" .$vbcrlf;
		$retStr .= "	var el = document.getElementsByTagName('FORM')" .$vbcrlf;
		$retStr .= "	el[0].submit()" .$vbcrlf;
		$retStr .= "}" .$vbcrlf;
		$retStr .= "</scr" ."ipt>" .$vbcrlf;
		
		echo $retStr;
		
	}
	
	function DeleteProgressFile(){
		$filename = dwzIO::PathCombine(GetTempFolder(), $this->progress_key .".xml");
		if(file_exists($filename)){
			unlink($filename);
		}
	}
	
	function WriteProgressBarInfo($stato, $n_Line, $t_Line, $startTime, $oper){
		//$linea = $stato ."," .$n_Line ."," .$t_Line ."," .$startTime ."," .$oper;
		
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
		$xml .= "<root>";
		$xml .= "<total>" .$t_Line ."</total>";
		$xml .= "<current>" .$n_Line ."</current>";
		$xml .= "<work>" .$oper ."</work>";
		$xml .= "<done>" .$stato ."</done>";
		$xml .= "<start_time>" .$startTime ."</start_time>";
		$xml .= "</root>";
		
		$filename = dwzIO::PathCombine(GetTempFolder(), $this->progress_key .".xml");
		
		//if (is_writable($filename)) {
			if (!$handle = fopen($filename, 'w')) {
				 exit();
			}		
			if (fwrite($handle, $xml) === FALSE) {
				exit();
			}
			fclose($handle);		
		//}
		
		//$_SESSION['dwzCsvImport'] = $linea;		
	}
	
	
}

?>