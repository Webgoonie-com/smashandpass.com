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


//'**********************************
//' http://www.DwZone.it
//' Xml Import
//' Copyright (c) DwZone.it 2000-2005
//'**********************************
class dwzXmlImport
{
	const MASTER_TABLE = 1;
	const CHILD_TABLE = 2;

	var $xmlContent,	
	$root,
	$debug,
	$startOnEvent,
	$startOnValue,
	$redirectPage,
	$displayErrors,
	$importFrom,
	$filePath,
	$fileUrl,
	$fullFilePath,
	$progress_key,
		
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
	
	$xmlUniqueKeyName,
	$xmlUniqueKeyXPath,
	$xmlRepeatItem,
	$xmlDetailUniqueKeyName,
	$xmlDetailUniqueKeyXPath,
	$xmlDetailRepeatItem,
	
	$xmlData,
	
	$hasDetails,
	$tableDetail,
	$detailTableUniqueKey,
	$detailTableForeignKeyColumn,
	
	$itemFieldRec,
	$itemFormat,
	$itemFromValue,
	$itemReferenceXPath,
	$itemReferenceName,
	
	$subItemFieldRec,
	$subItemFormat,
	$subItemFromValue,
	$subItemReferenceName,
	$subItemReferenceXpath,
	
	$progressBar,
	$progressUpdate,
	$progressPagePath,
	$startTime,
	$totalLineNumber,
	
	$totalRows,
	$inErr,
	$errMsg;
	

			
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

	function AddSubItem($rec, $from, $format, $reference){
		$this->subItemFieldRec[] = $rec;
		$this->subItemFromValue[] = $from;
		$this->subItemFormat[] = $format;
		$tmp = preg_split("/\|_\|/", $reference);
		$this->subItemReferenceName[] = $tmp[0];
		$this->subItemReferenceXpath[] = $tmp[1];
	}
	
	function Additem($rec, $from, $format, $reference){
		$this->itemFieldRec[] = $rec;
		$this->itemFromValue[] = $from;
		$this->itemFormat[] = $format;
		$tmp = preg_split("/\|_\|/", $reference);
		$this->itemReferenceName[] = $tmp[0];
		$this->itemReferenceXPath[] = $tmp[1];
	}
	
	function SetExtraData($param){
		$tmp = preg_split("/\|_\|/", $param);
		$this->root = $tmp[0];
		$this->hasDetails = $tmp[1];
		$this->tableDetail = $tmp[2];
		$this->detailTableUniqueKey = $tmp[3];
		$this->detailTableForeignKeyColumn = $tmp[4];
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
	
	function SetImportFrom($param){
		$this->importFrom = $param;
	}
	
	function SetFilePath($param){
		$this->filePath = $param;
	}
	
	function SetFileUrl($param){
		$this->fileUrl = $param;
	}
	
		
	function SetConnection($host, $db, $user, $pwd){
		$this->hostname = $host;
		$this->database = $db;
		$this->username = $user;
		$this->password = $pwd;
	}
	
	function SetTable($param){
		$tmp = preg_split("/@_@/", $param);		
		$this->table = $tmp[0];
		if(count($tmp) > 1){
			$this->cname = $tmp[1];
		}
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
	
	function SetXmlUniqueKey($param){
		$tmp = preg_split("/\|_\|/", $param);
		$this->xmlUniqueKeyName = $tmp[0];
		$this->xmlUniqueKeyXPath = $tmp[1];
		$this->xmlDetailUniqueKeyName = $tmp[2];
		$this->xmlDetailUniqueKeyXPath = $tmp[3];
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
	
	function SetXmlRepeatItem($param){
		$tmp = preg_split("/\|_\|/", $param);
		$this->xmlRepeatItem = $tmp[1];
		if(substr($this->xmlRepeatItem , -1) == "/"){
			$this->xmlRepeatItem = substr($this->xmlRepeatItem , 0, -1);
		}
		
		$this->xmlDetailRepeatItem = $tmp[3];
		if(substr($this->xmlDetailRepeatItem , -1) == "/"){
			$this->xmlDetailRepeatItem = substr($this->xmlDetailRepeatItem , 0, -1);
		}
	}
	
	function Init (){
		$this->itemFieldRec = array();
		$this->itemFormat = array();
		$this->itemFromValue = array();
		$this->itemReferenceName = array();
		$this->itemReferenceXPath = array();
		$this->itemColumn = array();
		
		$this->subItemFieldRec = array();
		$this->subItemFormat = array();
		$this->subItemFromValue = array();
		$this->subItemReferenceName = array();
		$this->subItemReferenceXpath = array();
		
		$this->csvData = array();
		$this->inErr = false;
		$this->debug = true;
		$this->totalRows = -1;
		$this->errMsg = array();
		
		if(isset($_GET["xml_import_progress_key"]) && $_GET["xml_import_progress_key"] != ""){
			$this->progress_key = $_GET["xml_import_progress_key"];
			
		}elseif(isset($_POST["xml_import_progress_key"]) && $_POST["xml_import_progress_key"] != ""){
			$this->progress_key = $_POST["xml_import_progress_key"];
			
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
			if(!isset($_SESSION)){
				session_start();
			}
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
			echo "<strong>DwZone - XML Import Error.</strong><br/>No item defined";
			exit();
		}
		
		if($this->filePath == ""){
			ob_clean();
			echo "<strong>DwZone - XML Import Error.</strong><br/>The file path is void";
			exit();
		}
		
		$this->fullFilePath = $this->GetFilePath();
		
		if(!file_exists($this->fullFilePath)){
			$this->AddError( "101", "The file: " .$this->fullFilePath ." is not find", "getfilePath");
		}
		
		if(count($this->errMsg) > 0){
			$this->ResponseError();
			exit();
		}
				
		$this->ReadXmlContent();
		
		//$this->Debug();
		
		if(count($this->errMsg) > 0){
			$this->ResponseError();
			exit();
		}
		
		$this->ImportData();

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
			
			if($this->onDuplicateEntry == "NoVerify"){
				$result = $this->CreateInsertQuery($i, self::MASTER_TABLE, -1, -1);
				
				$id = $this->db->GetLast_id();
				$this->ImportChildData($i, $id);
				
			}else{
				$recExists = $this->RecordExists($i, -1, self::MASTER_TABLE);
				if($recExists){
					if($this->onDuplicateEntry == "Update"){
						$result = $this->CreateUpdateQuery($i, self::MASTER_TABLE, -1);
					}elseif($this->onDuplicateEntry == "Skip"){
						$result = true;
					}else{
						$result = false;
						$this->AddError("110", "Row: " .($i + 1) ."- Err: Duplicate entry", "ImportData");
					}
					$id = $this->GetXmlData($i, $this->xmlUniqueKeyName, "xml");
					$this->ImportChildData($i, $id);
				}else{
					$result = $this->CreateInsertQuery($i, self::MASTER_TABLE, -1, -1);
					$id = $this->db->GetLast_id();
					$this->ImportChildData($i, $id);
				}
			}			
		}
		
		$this->db->Close();
		
		if($this->progressBar != ""){
			$sStato = "DONE";
			$sN_Line = $this->totalRows + 1;
			$sT_Line = $this->totalRows + 1;
			$sstartTime =  mktime() - $this->startTime;
			$oper = "Import data completed";
			$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sstartTime, $oper);
		}			
	}
	
	function ImportChildData($master_index, $foreign_key_value){				
		if(count($this->subItemFieldRec) != 0){
			$detail_nodes_counter = intval($this->GetXmlData($master_index, "detail_nodes_counter", "xml"));
			for($x=0; $x<$detail_nodes_counter; $x++){
				if($this->onDuplicateEntry == "NoVerify"){
					$result = $this->CreateInsertQuery($master_index, self::CHILD_TABLE, $x, $foreign_key_value);
				}else{
					$recExists = $this->RecordExists($master_index, $x, self::CHILD_TABLE);
					if($recExists){
						if($this->onDuplicateEntry == "Update"){
							$result = $this->CreateUpdateQuery($master_index, self::CHILD_TABLE, $x);
						}elseif($this->onDuplicateEntry == "Skip"){
							$result = true;
						}else{
							$result = false;
							$this->AddError("110", "Row: " .($master_index + 1) ." - Child: " .($x+1) ." - Err: Duplicate entry", "ImportData");
						}						
					}else{
						$result = $this->CreateInsertQuery($master_index, self::CHILD_TABLE, $x, $foreign_key_value);
					}
				}
			}
		}
	}
	
	
	
	function AddError($n, $d, $p){
		$this->errMsg[] = array("Number" => $n, "Description" => $d, "Position" => $p);
	}
	
	function CreateUpdateQuery($index, $table_type, $child_index){
				
		$update["table_name"] = ($table_type == self::MASTER_TABLE ? $this->table : $this->tableDetail);
		
		$item_counter = ($table_type == self::MASTER_TABLE ? count($this->itemReferenceName) : count($this->subItemReferenceName));
		
		for($i=0; $i<$item_counter; $i++){
			
			if($table_type == self::MASTER_TABLE){
				$value = $this->GetXmlData($index, $this->itemReferenceName[$i], $this->itemFromValue[$i]);
			}else{
				$name = $this->subItemReferenceName[$i];						
				$value = $this->GetXmlData($index, "sub_" .strval($child_index) ."_" .$name, "xml");						
			}
			
			$value = $this->FormatValue($value, ($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
			$type =  $this->GetFieldType(($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
						
			$def_value = "";
			$not_def_value = "";
			if($type == "defined"){
				$tmp = preg_split("/,/", ($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
				$def_value = $tmp[1];
				$not_def_value = $tmp[2];
			}
									
			$update["fields"][$i] = array(
									"name" => ($table_type == self::MASTER_TABLE ? $this->itemFieldRec[$i] : $this->subItemFieldRec[$i]),
									"value" => $value,
									"type" => $type,
									"def_value" => $def_value,
									"not_def_value" => $not_def_value									
									);
		}
				
		$update["where"][0] = array(
								"name" => ($table_type == self::MASTER_TABLE ? $this->tableUniqueKey : $this->detailTableUniqueKey),
								"value" => $this->GetXmlData($index, 
													($table_type == self::MASTER_TABLE ? 
														$this->xmlUniqueKeyName : 
														"sub_" .strval($child_index) ."_" .$this->xmlDetailUniqueKeyName), 
													"xml"),
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		$result = $this->db->Update($update);
		
		/*
		if($table_type == self::CHILD_TABLE){
		echo $this->db->GetSql();
		exit();
		}
		*/
		
		if($result !== true){
			$this->AddError("126", "Error in sql: " .$this->db.GetSql() , "CreateUpdateQuery");
			$this->AddError("126", "Error message: " .$result , "CreateUpdateQuery");
		}
		
		return $result;
	}
	
	
	function CreateInsertQuery($index, $table_type, $child_index, $foreign_key_value){
		$i = 0;
		$insert["table_name"] = ($table_type == self::MASTER_TABLE ? $this->table : $this->tableDetail);
		
		$item_counter = ($table_type == self::MASTER_TABLE ? count($this->itemReferenceName) : count($this->subItemReferenceName));
						
		for($i=0; $i<$item_counter; $i++){
			
			if($table_type == self::MASTER_TABLE){
				$value = $this->GetXmlData($index, $this->itemReferenceName[$i], $this->itemFromValue[$i]);
			}else{
				$name = $this->subItemReferenceName[$i];						
				$value = $this->GetXmlData($index, "sub_" .strval($child_index) ."_" .$name, "xml");						
			}
			
			$value = $this->FormatValue($value, ($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
			$type = $this->GetFieldType(($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
			
			$def_value = "";
			$not_def_value = "";
			if($type == "defined"){
				$tmp = preg_split("/,/", ($table_type == self::MASTER_TABLE ? $this->itemFormat[$i] : $this->subItemFormat[$i]));
				$def_value = $tmp[1];
				$not_def_value = $tmp[2];
			}
			
			$insert["fields"][$i] = array(
									"name" => ($table_type == self::MASTER_TABLE ? $this->itemFieldRec[$i] : $this->subItemFieldRec[$i]),
									"value" => $value,
									"type" => $type,
									"def_value" => $def_value,
									"not_def_value" => $not_def_value									
									);
		}
		
		if($table_type == self::CHILD_TABLE){
			$insert["fields"][$item_counter] = array(
												"name" => $this->detailTableForeignKeyColumn,
												"value" => $foreign_key_value,
												"type" => ($this->colIsNum ? "int" : "text")									
												);
		}
						
		$result = $this->db->Insert($insert);
				
		if($result !== true){
			$this->AddError("127", "Error in sql: " .$this->db->GetSql() , "CreateInsertQuery");
			$this->AddError("127", "Error message: " .$result , "CreateInsertQuery");
		}
		
		return $result;		
	}
	
	function RecordExists($index, $child_index, $table_type){
		
		$select["table_name"] = ($table_type == self::MASTER_TABLE ? $this->table : $this->tableDetail);
		
		$select["fields"][0] = array(
								"name" => ($table_type == self::MASTER_TABLE ? $this->tableUniqueKey : $this->detailTableUniqueKey),
								"value" => "",
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		$select["where"][0] = array(
								"name" => ($table_type == self::MASTER_TABLE ? $this->tableUniqueKey : $this->detailTableUniqueKey),
								"value" => $this->GetXmlData($index, 
													($table_type == self::MASTER_TABLE ? 
															$this->xmlUniqueKeyName : 
															"sub_" .strval($child_index) ."_" .$this->xmlDetailUniqueKeyName), 
													"xml"),
								"type" => ($this->colIsNum ? "int" : "text")
								);
		
		
		if($table_type == self::CHILD_TABLE){
			/*
			$select["where"][1] = array(
								"name" => $this->detailTableForeignKeyColumn,
								"value" => $this->GetXmlData($index, $this->xmlUniqueKeyName, "xml"),
								"type" => ($this->colIsNum ? "int" : "text")
								);
			*/
			//$recordset = $this->db->Select($select);
			//echo $this->db->GetSql();
			//exit();
		}
				
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
		
	
	function GetXmlData($index, $strValue, $valueFrom){
		$i = 0;
		if($valueFrom == ""){
			for($i=0; $i<count($this->itemReferenceName); $i++){
				if(strtolower($this->itemReferenceName[$i]) == strtolower($strValue)){
					$valueFrom = strtolower($this->itemFromValue[$i]);
					break;
				}
			}
		}else{
			$valueFrom = strtolower($valueFrom);
		}
		
		$retStr = "";
		switch($valueFrom){
		case "xml":
			//$tmp = preg_split("/\|_\|/", $strValue);
			$retStr = $this->TrimCDataValues(@$this->xmlData[$index][$strValue]);
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
	
	function TrimCDataValues($str){
		if(strlen($str) == 0){
			return "";
		}
		$str = preg_replace("/^[\r\n\r\s]+/", "", $str);
		$str = preg_replace("/[\r\n\r\s]+$/", "", $str);
		return $str;
	}
	
	function ReadXmlContent(){				
		$this->startTime = time();
		
		if($this->importFrom == "File"){
			$xml = simplexml_load_file($this->fullFilePath, 'SimpleXMLElement', LIBXML_NOCDATA);
		}else{
			$xml = simplexml_load_file($this->fileUrl, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		
		$xPath = substr($this->xmlRepeatItem, strpos($this->xmlRepeatItem, "/") + 1);
		$nodes = $xml->xpath($xPath);
		
		$this->totalLineNumber = count($nodes);
		$this->totalRows = -1;
						
		foreach($nodes as $node){
			$row = array();
			for($i=0; $i<count($this->itemFieldRec); $i++){
				$xml = new SimpleXMLElement($node->asXML());
				
				$name = $this->itemReferenceName[$i];
				$xPath = $this->GerRealXPath($this->itemReferenceXPath[$i]);
				$res = $xml->xpath($xPath);
				$value = "";
				if(count($res)){
					$value = implode(",", $res);
				}
				$row[$name] = $value;
			}
									
			//'Verify if the xmlUniqueKeyXPath is in the XmlData object
			//$tmp = preg_split("/\|_\|/", $this->xmlUniqueKeyXPath);
			$name = $this->xmlUniqueKeyName;
			$xPath = $this->GerRealXPath($this->xmlUniqueKeyXPath);
			if(!array_key_exists($name, $row)){
				$res = $xml->xpath($xPath);
				$value = "";
				if(count($res)){
					$value = implode(",", $res);
				}
				$row[$name] = $value;
			}			
			
			//lìread sub_items						
			if(count($this->subItemFieldRec) != 0){
				
				//$pos = strpos($this->xmlDetailRepeatItem, "/") + 1;
				$pos = strlen($this->xmlRepeatItem) + 1;
				$xPath = substr($this->xmlDetailRepeatItem, $pos);
				
				$xml = new SimpleXMLElement($node->asXML());
				$detail_nodes = $xml->xpath($xPath);
								
				$row['detail_nodes_counter'] = count($detail_nodes);
				$child_index = -1;
				foreach($detail_nodes as $detail_node){
					$child_index++;		
					for($i=0; $i<count($this->subItemFieldRec); $i++){
						$xml = new SimpleXMLElement($detail_node->asXML());
						$name = $this->subItemReferenceName[$i];
						$xPath = $this->GerRealChildXPath($this->subItemReferenceXpath[$i]);
						$res = $xml->xpath($xPath);
						
						if(count($res)){
							$row["sub_" .strval($child_index) ."_" .$name] = implode(",", $res);							
						}else{
							$row["sub_" .strval($child_index) ."_" .$name] = $res;
						}
					}
					
					//'Verify if the xmlUniqueKeyXPath is in the XmlData object
					$name = $this->xmlDetailUniqueKeyName;
					$xPath = $this->GerRealChildXPath($this->xmlDetailUniqueKeyXPath);
					if(!array_key_exists("sub_" .strval($child_index) ."_" .$name, $row)){
						$res = $xml->xpath($xPath);
						$value = "";
						if(count($res)){
							$row["sub_" .strval($child_index) ."_" .$name] = implode(",", $res);
						}else{
							$row["sub_" .strval($child_index) ."_" .$name] = $value;
						}
					}
				}
			}else{
				$row['detail_nodes_counter'] = 0;
			}
			
			$this->totalRows ++;
			$this->xmlData[$this->totalRows] = $row;
			
			
			
			if($this->progressBar != ""){
				if( $this->totalRows == 0 || $this->totalRows % $this->progressUpdate == 0){
					$sStato = "1";
					$sN_Line = $this->totalRows + 1;
					$sT_Line = $this->totalLineNumber;
					$sStartTime =  mktime() - $this->startTime;
					$oper = "Read xml data";
					$this->WriteProgressBarInfo( $sStato, $sN_Line, $sT_Line, $sStartTime, $oper);
				}
			}
		}
	}
	
	function GerRealChildXPath($str){
		$retVal = substr($str, strlen($this->xmlDetailRepeatItem) + 1);
		if(substr($retVal, 1) == "/"){
			$retVal = substr($retVal, 2);
		}
		return $retVal;
	}
	
	function GerRealXPath($str){
		$retVal = substr($str, strlen($this->xmlRepeatItem) + 1);
		if(substr($retVal, 1) == "/"){
			$retVal = substr($retVal, 2);
		}
		return $retVal;
	}
	
	function GetRandomNumber(){
		return uniqid("");
	}
	/*
	function GetSiteRoot(){
		$path = @$_SERVER['DOCUMENT_ROOT'];
		if(strlen($path) == 0){
			$path = @$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
		}
		if(strlen($path) == 0){
			$path = @$_SERVER['APPL_PHYSICAL_PATH'];		
		}
		if(strlen($path) == 0 && isset($_SESSION)){
			$path = @$_SESSION['SITE_ROOT'];
			if(strlen($path) != 0){
				if(substr($path, -1) == "/" || substr($path, -1) == "\\"){
					$path = substr($path, 0, -1);
				}
			}
		}
		return $path;
	}
	*/
	function GetFilePath(){
		if($this->filePath == ""){
			$this->AddError("100","The file is missing","getfilePath");
			break;
		}else{
			return dwzIO::GetRealPath($this->filePath);
		}
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
			return $strValue;
			
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
		case "yyyy-mm-ddT00:00:00+00:00":
			$d = new DateTime($strValue);
			$day = $d->format("d");
			$month = $d->format("m");
			$year = $d->format("Y");
			$hours = $d->format("H");
			$minutes = $d->format("i");
			$seconds = $d->format("s");
		
			break;
		case "YYYY.MM.DD":
		case "YYYY.MM.DD hh:mm:ss":
		case "YYYY-MM-DD hh:mm:ss":
		case "YYYY/MM/DD hh:mm:ss":
			if(substr($data, 2, 1) == "/" || substr($data, 2, 1) == "."){
				$tmp = preg_split("/\\" .substr($data, 2, 1) ."/", $data);
			}else{
				$tmp = preg_split("/" .substr($data, 2, 1) ."/", $data);
			}
			$day = $tmp[2];
			$month = $tmp[1];
			$year = $tmp[0];
			
			break;
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
	
	function Debug(){
		
		ob_clean();
		
		echo "<table border=1 cellspacing=2 >";
		
		echo "<td>";
		echo "Row index";
		echo "</td>";
		
		echo "<td>";
		echo "Xml Unique Key";
		echo "</td>";
		
		for($i=0; $i<count($this->itemReferenceName); $i++){
			$name = $this->itemReferenceName[$i];
			echo "<td>";
			echo $name;
			echo "</td>";
		}
		
		if(count($this->subItemFieldRec) != 0){
			$i = 0;
			$detail_nodes_counter = intval($this->GetXmlData($i, "detail_nodes_counter", "xml"));
			for($r=0; $r<$detail_nodes_counter; $r++){
				echo "<td>";
				echo "Xml Unique Key";
				echo "</td>";
					
				for($ii=0; $ii<count($this->subItemFieldRec); $ii++){
					echo "<td>";
					$name = $this->subItemReferenceName[$ii];
					echo "sub_" .strval($r) ."_" .$name;
					echo "</td>";
				}
			}
		}
		
		$aaa = $this->totalLineNumber;
		for($i=0; $i<$this->totalLineNumber; $i++){
			echo "<tr>";
			
			echo "<td>";
			echo $i;
			echo "</td>";
				
			echo "<td>";
			echo $this->GetXmlData($i, $this->xmlUniqueKeyName, "xml");
			echo "</td>";
			
			for($ii=0; $ii<count($this->itemReferenceName); $ii++){
				//$name = $this->itemReferenceName[$ii];
				echo "<td>";
				echo $this->GetXmlData($i, $this->itemReferenceName[$ii], "") ."&nbsp;";
				echo "</td>";
			}
			
			if(count($this->subItemFieldRec) != 0){
				$detail_nodes_counter = intval($this->GetXmlData($i, "detail_nodes_counter", "xml"));
				for($r=0; $r<$detail_nodes_counter; $r++){
					echo "<td>";
					$name = $this->xmlDetailUniqueKeyName;
					echo $this->GetXmlData($i, "sub_" .strval($r) ."_" .$name, "xml") ."&nbsp;";
					echo "</td>";
					for($ii=0; $ii<count($this->subItemFieldRec); $ii++){
						echo "<td>";
						$name = $this->subItemReferenceName[$ii];
						echo $this->GetXmlData($i, "sub_" .strval($r) ."_" .$name, "xml") ."&nbsp;";
						echo "</td>";
					}
				}
			}
			
			echo "</tr>";
		}		
		echo "</table>";
		exit();		
	}
	
}

?>