<?php

/*
*********************
      INSERT
*********************

$this->db = new dwzDataBase();
		
$this->db->SetConn($this->hostname,
					$this->database,
					$this->username,
					$this->password);

$insert["table_name"] = $this->masterTable;

//TEXT FIELD TYPE
"text"
"long"
"int"
"double"
"date"
"defined"

$field = array(
					"name" => "",
					"value" => "",
					"type" => "",
					"def_value" => "",
					"not_def_value" => "",
					"operator" => ""
					);

$insert["fields"][] = $field
		
$this->db->Insert($insert);

if($this->db->HasError()){
	$this->db->Close();
	ob_clean();
	echo "Error on insert<br>";
	echo $this->db->GetLastError() ."<br><br><br>";
	echo var_export($insert, true);
	exit();
}

$this->db->GetLast_id();



*************************
      UPDATE / DELETE
*************************
$update["where"][] = array(
						"name" => "",
						"value" => "",
						"type" => ""
						);






*/

if (!class_exists("dwzDataBase")){
class dwzDataBase{
	
	var $db;
	var $debug;
	var $last_sql;
	var $hasError;
	var $lastError;
	var $enclose_char;
	var $is_mysql_i;
	
	function __construct(){
		$this->db["conn_is_open"] = false;
		$this->debug = false;
		$this->hasError = false;
		$this->lastError = "";
		$this->enclose_char = "`";
		$this->is_mysql_i = false;
	}
	
	function SetConn($hostname, 
					 $database, 
					 $username, 
					 $password){
		$this->db["hostname"] = $hostname;
		$this->db["database"] = $database;
		$this->db["username"] = $username;
		$this->db["password"] = $password;
	}
	
	function SetMySqli($value){
		$this->is_mysql_i = $value;
	}
	
	function ExecuteSql($sql){
		if(!$this->db["conn_is_open"]){
			$this->Open();	
		}
		
		$this->hasError = false;
		$this->lastError = "";
		
		$this->SelectDb();
		
		$this->last_sql = $sql;
		
		if($this->is_mysql_i){
			$result = mysqli_query($this->db["connessione"], $sql);
		}else{
			$result = mysqli_query($this->db["connessione"], $sql);
		}
		
		if($result === false){
			$this->hasError = true;
			if($this->is_mysql_i){
				$this->lastError = mysqli_error();
				return mysqli_error();
			}else{
				$this->lastError = mysqli_error();
				return mysqli_error();
			}
		}

		return $result;
	}
	
	function Select($select){
		if(!$this->db["conn_is_open"]){
			$this->Open();	
		}
		
		$this->hasError = false;
		$this->lastError = "";
		
		$this->SelectDb();
		
		$sql = "SELECT ";
		$args = array();
		$cong = "";
		
		if(isset($select["fields"]) && count($select["fields"]) != 0){
			foreach($select["fields"] as $field){
				if($field["type"] == "COUNT"){
					$sql .= $cong ."count(1) as " .$field["name"];
				}else{
					$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char;
				}
				$cong = ", ";
			}
		}else{
			$sql .= " * ";
		}
		
		$sql .= " FROM " .$this->enclose_char .$select["table_name"] .$this->enclose_char;
		
		$cong = "";
		
		if(isset($select["where"]) && count($select["where"]) != 0){
			$sql .= " WHERE ";
			foreach($select["where"] as $field){
				$def_value = (array_key_exists("def_value", $field) ? $field["def_value"] : "");
				$not_def_value = (array_key_exists("not_def_value", $field) ? $field["not_def_value"] : "");
				if($def_value == "Y" || $def_value == "N"){
					$def_value = "'" .$def_value ."'";
				}
				if($not_def_value == "Y" || $not_def_value == "N"){
					$not_def_value = "'" .$not_def_value ."'";
				}
				
				if(isset($field["operator"])){
					switch($field["operator"]){
						case "Not Null":
							$sql .= $cong ." Not " .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						case "Null":
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						default:
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." " .$field["operator"] ." %s";
							$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
							break;
					}
				}else{
					$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." = %s";
					$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
				}
				$cong = " AND ";
			}
			$selectSQL = vsprintf($sql, $args);	
		}else{
			$selectSQL = $sql;	
		}
		
		$this->last_sql = $selectSQL;
		
		if($this->debug){
			echo $selectSQL;
			exit();
		}
		
		if($this->is_mysql_i){
			$result = mysqli_query($this->db["connessione"], $selectSQL);
		}else{
			$result = mysqli_query($this->db["connessione"], $selectSQL);
		}
		
		if($result === false){
			$this->hasError = true;
			if($this->is_mysql_i){
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}else{
				$this->lastError = mysqli_error();
				return mysqli_error();
			}
		}

		return $result;
	}
	
	function Insert($insert){
		if(!$this->db["conn_is_open"]){
			$this->Open();	
		}
		
		$this->hasError = false;
		$this->lastError = "";
		
		$this->SelectDb();
				
		$sql_fields = "INSERT INTO " .$this->enclose_char .$insert["table_name"] .$this->enclose_char ." ( ";
		$sql_values = "";
		$args = array();
		$cong = "";
		
		foreach($insert["fields"] as $field){
			$def_value = (array_key_exists("def_value", $field) ? $field["def_value"] : "");
			$not_def_value = (array_key_exists("not_def_value", $field) ? $field["not_def_value"] : "");
			if($def_value == "Y" || $def_value == "N"){
				$def_value = "'" .$def_value ."'";
			}
			if($not_def_value == "Y" || $not_def_value == "N"){
				$not_def_value = "'" .$not_def_value ."'";
			}
			
			$sql_fields .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ;
										
			$sql_values .= $cong ." %s";
			$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
			$cong = ", ";
		}
		$total_sql = $sql_fields ." ) VALUES ( " .$sql_values ." )";
		
		$insertSQL = vsprintf($total_sql, $args);		
		
		$this->last_sql = $insertSQL;
		
		if($this->debug){
			echo $insertSQL;
			exit();
		}
		
		if($this->is_mysql_i){
			$result = mysqli_query($this->db["connessione"], $insertSQL);
		}else{
			$result = mysqli_query($this->db["connessione"], $insertSQL);
		}
		
		if($result === false){
			$this->hasError = true;	
			if($this->is_mysql_i){
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}else{
				$this->lastError = mysqli_error();
				return mysqli_error();
			}
		}

		return $result;
	}
			
	function Update($update){
		if(!$this->db["conn_is_open"]){
			$this->Open();	
		}
		
		$this->hasError = false;
		$this->lastError = "";
		
		$this->SelectDb();
		
		$and;
		$sql = "UPDATE " .$this->enclose_char .$update["table_name"] .$this->enclose_char ." SET ";
		$args;
		$cong = "";
		
		foreach($update["fields"] as $field){
			$def_value = (array_key_exists("def_value", $field) ? $field["def_value"] : "");
			$not_def_value = (array_key_exists("not_def_value", $field) ? $field["not_def_value"] : "");
			if($def_value == "Y" || $def_value == "N"){
				$def_value = "'" .$def_value ."'";
			}
			if($not_def_value == "Y" || $not_def_value == "N"){
				$not_def_value = "'" .$not_def_value ."'";
			}
			$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." = %s";
			$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
			$cong = ", ";
		}
		
		$cong = "";
		
		if(isset($update["where"]) && count($update["where"]) != 0){
			$sql .= " WHERE ";
			foreach($update["where"] as $field){
				$def_value = (array_key_exists("def_value", $field) ? $field["def_value"] : "");
				$not_def_value = (array_key_exists("not_def_value", $field) ? $field["not_def_value"] : "");
				if($def_value == "Y" || $def_value == "N"){
					$def_value = "'" .$def_value ."'";
				}
				if($not_def_value == "Y" || $not_def_value == "N"){
					$not_def_value = "'" .$not_def_value ."'";
				}
				if(isset($field["operator"])){
					switch($field["operator"]){
						case "Not Null":
							$sql .= $cong ." Not " .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						case "Null":
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						default:
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." " .$field["operator"] ." %s";
							$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
							break;
					}
				}else{
					 $sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." = %s"; 
					 $args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
				}				
				
				$cong = " AND ";
			}
		}		
						
		$updateSQL = vsprintf($sql, $args);		
		
		$this->last_sql = $updateSQL;
		
		if($this->debug){
			echo $updateSQL;
			exit();
		}
		
		if($this->is_mysql_i){
			$result = mysqli_query($this->db["connessione"], $updateSQL);
		}else{
			$result = mysqli_query($this->db["connessione"], $updateSQL);
		}
		
		if($result === false){
			$this->hasError = true;
			if($this->is_mysql_i){
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}else{
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}
		}

		return $result;
	}
	
	function Delete($delete){
		if(!$this->db["conn_is_open"]){
			$this->Open();	
		}
		
		$this->hasError = false;
		$this->lastError = "";
		
		$this->SelectDb();
		
		$and;
		$sql = "DELETE FROM " .$this->enclose_char .$delete["table_name"] .$this->enclose_char ;
		$args;
		$cong = "";
		
		
		if(count($delete["where"]) != 0){
			$sql .= " WHERE ";
			foreach($delete["where"] as $field){
				$def_value = (array_key_exists("def_value", $field) ? $field["def_value"] : "");
				$not_def_value = (array_key_exists("not_def_value", $field) ? $field["not_def_value"] : "");
				if($def_value == "Y" || $def_value == "N"){
					$def_value = "'" .$def_value ."'";
				}
				if($not_def_value == "Y" || $not_def_value == "N"){
					$not_def_value = "'" .$not_def_value ."'";
				}
				if(isset($field["operator"])){
					switch($field["operator"]){
						case "Not Null":
							$sql .= $cong ." Not " .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						case "Null":
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." Is Null ";
							break;
						default:
							$sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." " .$field["operator"] ." %s";
							$args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
							break;
					}
				}else{
					 $sql .= $cong .$this->enclose_char .$field["name"] .$this->enclose_char ." = %s"; 
					 $args[] = $this->GetSQLValueString($field["value"], $field["type"], $def_value, $not_def_value);
				}				
				$cong = " AND ";
			}
		}
				
		$deleteSQL = vsprintf($sql, $args);		
		
		$this->last_sql = $deleteSQL;
		
		if($this->debug){
			echo $deleteSQL;
			exit();
		}
		
		if($this->is_mysql_i){
			$result = mysqli_query($this->db["connessione"], $deleteSQL);
		}else{
			$result = mysql_query($deleteSQL, $this->db["connessione"]);
		}
		if($result === false){
			$this->hasError = true;
			if($this->is_mysql_i){
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}else{
				$this->lastError = mysqli_error($this->db["connessione"]);
				return mysqli_error($this->db["connessione"]);
			}
		}
                
		return $result;		
	}
	
	function HasError(){
		return $this->hasError;
	}
	function GetLastError(){
		return $this->lastError;
	}
	
	function GetSql(){
		return $this->last_sql;
	}
	function GetLast_id(){
		if($this->is_mysql_i){
			return @mysqli_insert_id($this->db["connessione"]);
		}else{
			return @mysqli_insert_id($this->db["connessione"]);
		}
	}
	
	function Open(){
		if($this->is_mysql_i){
			$this->db["connessione"] = new mysqli($this->db["hostname"], $this->db["username"], $this->db["password"], "");
			if ($this->db["connessione"]->connect_errno) {
			    trigger_error(mysqli_error($this->db["connessione"]),E_USER_ERROR);	
			}						
		}else{
			$this->db["connessione"] = new mysqli($this->db["hostname"], $this->db["username"], $this->db["password"], "");
			if ($this->db["connessione"]->connect_errno) {
			    trigger_error(mysqli_error($this->db["connessione"]),E_USER_ERROR);	
			}						
		}
		$this->db["conn_is_open"] = true;
	}
	
	function Close(){
		if($this->db["conn_is_open"]){
			if($this->is_mysql_i){
				@mysqli_close($this->db["connessione"]);
			}else{
				@mysql_close($this->db["connessione"]);
			}
		}		
		$this->db["conn_is_open"] = false;
	}
	
	function SelectDb(){
		if($this->is_mysql_i){
			mysqli_select_db($this->db["connessione"], $this->db["database"]);
		}else{
			mysql_select_db($this->db["database"], $this->db["connessione"]);
		}
	}
	
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }
		
	  if($this->is_mysql_i){
		$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($this->db["connessione"], $theValue) : mysqli_escape_string($this->db["connessione"], $theValue);
	  }else{
		$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($this->db["connessione"], $theValue) : mysqli_escape_string($this->db["connessione"], $theValue);
	  }
	  
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}

}
}
?>