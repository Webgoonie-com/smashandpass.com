<?php

include('fpdf/fpdf.php');
include('dwzIO.php');
include('dwzString.php');

//**********************************
// http://www.DwZone-it.com
// Pdf Export
// Copyright (c) DwZone.it 2000-2005
//**********************************

class PDF extends FPDF
{
	var $pageNumbers, $pageNumbersAlign;
	
	function SetFooterPar($pageNum, $pageNumAlign){
		$this->pageNumbers = $pageNum;
		$this->pageNumbersAlign = $pageNumAlign;
	}
	
	function Footer()
	{
		if($this->pageNumbers == "true"){
			$this->SetY(-15);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			
			if(strtolower($this->pageNumbersAlign) == "center"){
			    $this->Cell(0,10,'Page ' .$this->PageNo() .' of {nb}',0,0,'C');
			}elseif(strtolower($this->pageNumbersAlign) == "left"){
			    $this->Cell(0,10,'Page ' .$this->PageNo() .' of {nb}',0,0,'L');
			}elseif(strtolower($this->pageNumbersAlign) == "right"){
			    $this->Cell(0,10,'Page ' .$this->PageNo() .' of {nb}',0,0,'R');		
			}
		}		
	}
	
	
	function GetImageInfo($filename){
		$info = array();
		$image_info = getimagesize($filename);
		$image_type = $image_info[2];
		
		if( $image_type == IMAGETYPE_JPEG ) {
			$image = imagecreatefromjpeg($filename);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			$image = imagecreatefromgif($filename);
		}elseif( $image_type == IMAGETYPE_PNG ) {
			$image = imagecreatefrompng($filename);
		}elseif( $image_type == IMAGETYPE_WBMP ) {
			$image = imagecreatefromwbmp($filename);
		}else{
			$info['w'] = 100;
			$info['h'] = 100;
			return $info;		
		}		
		$info['w'] = imagesx($image);
		$info['h'] = imagesy($image);
		return $info;		
	}
	
	
	
	function NbLines($xw , $xtxt){
		$xnb;
		$xcw = &$this->CurrentFont["cw"];
		if($xw == 0){
			$xw = $this->w - ($this->rMargin) - $this->x;
		}
		$xwmax = ($xw - 2 * $this->cMargin) * 1000 / ($this->FontSize);
		$xs = preg_replace("/\r/", "", $xtxt);
		$xnb = strlen($xs);
		if($xnb>0 && $xs[$xnb-1] == "\n"){
			$xnb--;
		}
		
		$xsep = -1;
		$xi = 0;
		$xj = 0;
		$xl = 0;
		$xnl = 1;
		while($xi < $xnb){
			$xc = $xs[$xi];
			if($xc == "\n"){
				$xi++;
				$xsep = -1;
				$xj = $xi;
				$xl = 0;
				$xnl++;
				continue;
			}
			if($xc == " "){
				$xsep = $xi;
			}
			$xl += ($xcw[$xc]);
			if($xl > $xwmax){
				if($xsep == -1){
					if($xi == $xj)$xi++;
				}
				else $xi = $xsep + 1;
				$xsep = -1;
				$xj = $xi;
				$xl = 0;
				$xnl++;
			}
			else {$xi++;}
			}
		return $xnl;
	}
	
}







class dwzPdfExport
{
	
	var $posX,
	$posY,
	$pDF,
	$recordset,
	$row_recordset,
	$cname,
	$filePath,
	$fileName,
	$numberOfRecord,
	$startOnEvent,
	$startOnValue,
	$rootPath,
	
	$fieldLabel,
	
	$itemLabel,
	$itemRecField,
	$itemFormat,
	$itemWidth,
	$itemAlign,
	//$itemCount,

	$headerFont,
	$headerSize,
	$headerColor,
	$headerBold,
	$headerItalic,
	$headerUnderline,
	$headerBgColor,
	
	$cellFont,
	$cellSize,
	$cellColor,
	$cellBold,
	$cellItalic,
	$cellUnderline,
	$cellBgColor,
	$cellHeight,
	$cellLineColor,
	$cellLineWidth,
	
	$pageSize,
	$pageOrientation,
	$marginLeft,
	$marginRight,
	$marginTop,
	$marginBottom,
	$pageNumbers,
	$pageNumbersAlign,
	$displayMethod;
	
	function SetPath($param){
		if($param = ""){
			$this->rootPath = "/";
		}else{
			$this->rootPath = $param;
		}
	}
	
	function SetGeneralSettings($param){
		$tmp = preg_split("/;/", $param);
		$this->pageSize = $tmp[0];
		$this->pageOrientation = $tmp[1];
		$this->marginLeft = $tmp[2];
		$this->marginRight = $tmp[3];
		$this->marginTop = $tmp[4];
		$this->marginBottom = $tmp[5];
		$this->pageNumbers = $tmp[6];
		$this->pageNumbersAlign = $tmp[7];
		$this->displayMethod = $tmp[8];
		if(count($tmp) > 9){
			$this->cname = $tmp[9];
		}
	}
	
	function SetCellSettings($param){
		$tmp = preg_split("/;/", $param);
		$this->cellFont = $tmp[0];
		$this->cellSize = $tmp[1];
		$this->cellColor = $tmp[2];
		$this->cellBold = $tmp[3];
		$this->cellItalic = $tmp[4];
		$this->cellUnderline = $tmp[5];
		$this->cellBgColor = $tmp[6];
		$this->cellHeight = $tmp[7];
		$this->cellLineColor = $tmp[8];
		$this->cellLineWidth = $tmp[9];
	}
	
	function SetHeaderSettings($param){
		$tmp = preg_split("/;/", $param);
		$this->headerFont = $tmp[0];
		$this->headerSize = $tmp[1];
		$this->headerColor = $tmp[2];
		$this->headerBold = $tmp[3];
		$this->headerItalic = $tmp[4];
		$this->headerUnderline = $tmp[5];
		$this->headerBgColor = $tmp[6];
	}
	
	function AddItem($label, $rec, $format, $width, $align){
		$this->itemLabel[] = $label;
		$this->itemRecField[] = $rec;
		$this->itemFormat[] = $format;
		$this->itemWidth[] = $width;
		$this->itemAlign[] = $align;
	}
	
	function SetRecordset(&$rs){
		$this->recordset = $rs;
	}
	
	function SetfilePath($param){
		$this->filePath = trim($param);
	}	
	
	function SetfileName($param){
		if(trim($param) != ""){
			$this->fileName = trim($param);
		}else{
			$this->fileName = "Export.pdf";
		}
	}	
	
	function SetNumberOfRecord($param){
		if(strtoupper($param) != "ALL"){
			if(is_nan($param)){
				$param = "ALL";
			}
		}
		$this->numberOfRecord = trim($param);
	}	
	
	function SetStartOn($param1, $param2){
		$this->startOnEvent = $param1;
		$this->startOnValue = $param2;
	}
	
	function SetFieldLabel($param){
		if(strtolower($param) == "true"){
			$this->fieldLabel = true;
		}else{
			$this->fieldLabel = false;
		}
	}
	
	function IsMySqli(){
		if (isset($GLOBALS[$this->cname]) && $GLOBALS[$this->cname] && is_object($GLOBALS[$this->cname])){
			return true;
		}
		return false;
	}
	
	function Init(){
		$this->recordset = null;
		$this->itemLabel = array();
		$this->itemRecField = array();
		$this->itemFormat = array();
		$this->itemWidth = array();
		$this->itemAlign = array();
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
		if(count($this->itemLabel) < 1){
			ob_clean();
			echo "<strong>DwZone - XML Export Error.</strong><br/>No Item defined";
			exit();
		}
				
		$cont = array();
		$aCapo = "\n";
		
		$this->SetCellHeight();
						
		$this->PDF = new PDF($this->pageOrientation, "mm", $this->pageSize);
		$this->PDF->AliasNbPages();
		$this->PDF->SetFooterPar($this->pageNumbers, $this->pageNumbersAlign);
		
		if( strtolower($this->headerFont) != "arial" &&
		   strtolower($this->headerFont) != "courier" &&
		   strtolower($this->headerFont) != "times" &&
		   strtolower($this->headerFont) != "symbol" &&
		   strtolower($this->headerFont) != "zapfdingbats"){
		   	
			$this->PDF->AddFont( $this->headerFont, "", $this->headerFont & ".php");
			$this->PDF->AddFont( $this->headerFont, "B", $this->headerFont & "B.php");
			$this->PDF->AddFont( $this->headerFont, "I", $this->headerFont & "I.php");
			$this->PDF->AddFont( $this->headerFont, "BI", $this->headerFont & "BI.php");
		}
		
		if( strtolower($this->cellFont) != "arial" &&
		    strtolower($this->cellFont) != "courier" &&
		    strtolower($this->cellFont) != "times" &&
		    strtolower($this->cellFont) != "symbol" &&
		    strtolower($this->cellFont) != "zapfdingbats" &&
		    strtolower($this->headerFont) != strtolower($this->cellFont)){
		   
		   	$this->PDF->AddFont( $this->cellFont, "", $this->cellFont & ".php");
			$this->PDF->AddFont( $this->cellFont, "B", $this->cellFont & "B.php");
			$this->PDF->AddFont( $this->cellFont, "I", $this->cellFont & "I.php");
			$this->PDF->AddFont( $this->cellFont, "BI", $this->cellFont & "BI.php");			
		}
				
		$this->PDF->SetAuthor("DwZone Pdf Writer");
		$this->PDF->SetCreator("ASP2PDF");
		$this->PDF->SetKeywords("");
		$this->PDF->SetSubject("");
		$this->PDF->SetTitle ("");
				
		$color = $this->html2rgb($this->cellLineColor);		
		$this->PDF->SetDrawColor( $color['R'], $color['G'], $color['B']);
		$this->PDF->SetLineWidth(intval($this->cellLineWidth));
		$this->PDF->SetMargins( floatval($this->marginLeft), floatval($this->marginTop), floatval($this->marginRight) );
		$this->PDF->SetAutoPageBreak( true, floatval($this->marginBottom));
		
		$this->PDF->AddPage();
		
		$this->posX = floatval($this->marginLeft);
		$this->posY = floatval($this->marginTop);
		$this->PDF->SetXY($this->posX, $this->posY);
		
		if($this->fieldLabel){
			$this->WriteHeader();
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
		
				$cHeight = $this->cellHeight;
				$style = "";
				$size = intval($this->cellSize);
				if(strtolower($this->cellBold) == "true"){
					$style .= "B";
				}
				if(strtolower($this->cellUnderline) == "true"){
					$style .= "U";
				}
				if(strtolower($this->cellItalic) == "true"){
					$style .= "I";
				}			
				$family = $this->cellFont;
			
				$maxLines = 1;
				for($i=0; $i<count($this->itemRecField); $i++){
					if($this->itemFormat[$i] != "Image"){
										
						$strValue = $this->row_recordset[$this->itemRecField[$i]] ."";
					
						if($strValue != "" && $this->itemFormat[$i] != "String"){
							$strValue = $this->FormatValue($strValue, $this->itemFormat[$i]);
						}
						$strValue = preg_replace("/\\n/", "\n", $strValue);
					
						$width = $this->GetCellWidth($this->itemWidth[$i]);
						$lines = $this->GetNumberOfLines($strValue, $width);
					
						if($lines > $maxLines){
							$maxLines = $lines;
						}
					}
				}
			
				for($i=0; $i<count($this->itemRecField); $i++){
					if($this->itemFormat[$i] == "Image"){				
						$strValue = $this->row_recordset[$this->itemRecField[$i]] ."";
						if($strValue != ""){
							
							//'for DataGrid
							//set Fs = server.CreateObject("Scripting.FileSystemObject")
							//if not Fs.FileExists(server.MapPath(strValue)) and session("dwzImagesFolder") <> ""){
							//	strValue = session("dwzImagesFolder") & strValue
							//}
							//set Fs = nothing
							if(isset($_SESSION['dwzImagesFolder'])){
								$strValue = $_SESSION['dwzImagesFolder'] .$strValue;
							}
							
							$strValue = $this->GetRealPath($strValue);
							
							if(file_exists($strValue)){
					   			
								$currentImageInfo = $this->PDF->GetImageInfo($strValue);
								$currentImageSizeWidth = $currentImageInfo['w'];
								$currentImageSizeHeight = $currentImageInfo['h'];
								
								$cellPixels = $this->GetCellPixels($width);
								
								$percW = $currentImageSizeWidth / $cellPixels;
								$percH = 1;
								if($percW > $percH){
									$finalImageSizeWidth = round($currentImageSizeWidth / $percW, 0);
									$finalImageSizeHeight = round($cCurrentImageSizeHeight / $percW, 0);
								}else{
									$finalImageSizeWidth = round($currentImageSizeWidth / $percH, 0);
									$finalImageSizeHeight = round($currentImageSizeHeight / $percH, 0);
								}
								
								if($finalImageSizeHeight > $maxLines * (floatval($this->cellHeight) * 2.8)){
									$maxLines = $finalImageSizeHeight / (floatval($this->cellHeight) * 2.8);
									if($maxLines - floor($maxLines) != 0){
										$maxLines = floor($maxLines) + 1;
									}
								}							
							}
						}
					}
				}
			
				$testHeight = $maxLines * floatval($this->cellHeight);
				if($testHeight < floatval($cHeight)){
					$testHeight = floatval($cHeight);
				}
				
				if($this->NeedNewPage($this->posY + $testHeight)){
					$this->PDF->AddPage();
					$this->posY = floatval($this->marginTop);
					if($this->fieldLabel){
						$this->WriteHeader();
					}
				}						
			
				for($i=0; $i<count($this->itemRecField); $i++){
					
					$currentImage = "";
					$currentImageSizeWidth = 0;
					$currentImageSizeHeight = 0;
					$finalImageSizeWidth = 0;
					$finalImageSizeHeight = 0;
					
					$this->PDF->SetXY($this->posX, $this->posY);
					$strValue = $this->row_recordset[$this->itemRecField[$i]] ."";
					$width = $this->GetCellWidth($this->itemWidth[$i]);
					
					if($this->itemFormat[$i] == "Image"){
						if($strValue != ""){
							
							//'for DataGrid
							//set Fs = server.CreateObject("Scripting.FileSystemObject")
							//if not Fs.FileExists(server.MapPath(strValue)) and session("dwzImagesFolder") <> ""){
							//	strValue = session("dwzImagesFolder") & strValue
							//}
							//set Fs = nothing
							if(isset($_SESSION['dwzImagesFolder'])){
								$strValue = $_SESSION['dwzImagesFolder'] .$strValue;
							}
							
							$strValue = $this->GetRealPath($strValue);
							
							if(file_exists($strValue)){
								
								$currentImageInfo = $this->PDF->GetImageInfo($strValue);
								$currentImageSizeWidth = $currentImageInfo['w'];
								$currentImageSizeHeight = $currentImageInfo['h'];
								
								$cellPixels = $this->GetCellPixels($width);
								
								$percW = $currentImageSizeWidth / $cellPixels;
								$percH = 1;
								if($percW > $percH){
									$finalImageSizeWidth = round($currentImageSizeWidth / $percW, 0);
									$finalImageSizeHeight = round($cCurrentImageSizeHeight / $percW, 0);
								}else{
									$finalImageSizeWidth = round($currentImageSizeWidth / $percH, 0);
									$finalImageSizeHeight = round($currentImageSizeHeight / $percH, 0);
								}
								
								$point = 72.0 / 25.4;
								$finalImageSizeWidth = round($finalImageSizeWidth / $point, 0);
								$finalImageSizeHeight = round($finalImageSizeHeight / $point, 0);
								
								$currentImage = $strValue;
							}
						}
					}
					
					$color = $this->html2rgb($this->cellColor);	
					$this->PDF->SetTextColor( $color['R'], $color['G'], $color['B']);
					
					$color = $this->html2rgb($this->cellBgColor);	
					$this->PDF->SetFillColor( $color['R'], $color['G'], $color['B']);
					
					$this->PDF->SetFont( $family, $style, $size);
					$border = 1;
					$fill = 1;
					$align = "L";
					if(strtolower($this->itemAlign[$i]) == "center"){
						$align = "C";
					}elseif(strtolower($this->itemAlign[$i]) == "right"){
						$align = "R";
					}elseif(strtolower($this->itemAlign[$i]) == "justify"){
						$align = "J";
					}
					
					if($this->itemFormat[$i] == "Image"){
						$strValue = "";
						for($ii=0; $ii<$maxLines; $ii++){
							$strValue .= "\n";
						}
					}else{
						if($strValue != "" && $this->itemFormat[$i] != "String"){
							$strValue = $this->FormatValue($strValue, $this->itemFormat[$i]);
						}
						$strValue = preg_replace("/\\n/", "\n", $strValue);
						
						$lines = $this->GetNumberOfLines($strValue, $width);
						if($lines < $maxLines){
							for($ii=0; $ii<$maxLines; $ii++){
								$strValue .= "\n";
							}
						}					
					}
					
					$this->PDF->MultiCell( $width, floatval($cHeight), $strValue, $border, $align, $fill);
					
					if($currentImage != ""){
						$this->InsertImage($currentImage, 
										  $width, 
										  ($maxLines * floatval($this->cellHeight)), 
										  $finalImageSizeWidth, 
										  $finalImageSizeHeight, 
										  $this->posX, 
										  $this->posY);
					}
					
					$this->posX += $width;	
				}
							
				$this->posY += ($maxLines * floatval($this->cellHeight));
				$this->posX = floatval($this->marginLeft);
				
				$nRec ++;
				if($this->numberOfRecord != "ALL"){
					if(intval($this->numberOfRecord) <= $nRec){
						break;
					}
				}
				
			}
		}
		
		/*
		FullfilePath = ""
		if filePath <> "" and fileName <> ""){
			FullfilePath = server.MapPath(filePath)			
			set Fs = server.CreateObject("Scripting.FileSystemObject")
			if Fs.FolderExists(FullfilePath)){
				if right(FullfilePath, 1) <> "\\"){
					FullfilePath = FullfilePath & "\\"
				}
				FullfilePath = FullfilePath & fileName
			else
				FullfilePath = ""
			}
		}
		
		if($this->displayMethod == ""){
			$download = true;
		}else{
			$download = false;
		}
		*/
		
		ob_clean();
		
		$this->PDF->Close();
		$this->PDF->Output();
	}
	
	function SetCellHeight(){
		$s = $this->headerSize;
		if(intval($s) < intval($this->cellSize)){
			$s = intval($this->cellSize);
		}		
		switch($s){
		case "5":
			$this->cellHeight = "3";
			break;
		case "8":
			$this->cellHeight = "5";
			break;
		case "9":
			$this->cellHeight = "5";
			break;
		case "10":
			$this->cellHeight = "6";
			break;
		case "12":
			$this->cellHeight = "7";
			break;
		case "14":
			$this->cellHeight = "8";
			break;
		case "16":
			$this->cellHeight = "9";
			break;
		case "20":
			$this->cellHeight = "11";
			break;
		}
	}
	
	
	
	function GetRealPath($filePath){	
		if($filePath == ""){
			return "";
		}else{
			$root = $this->GetSiteRoot() ;	
			$filePath = str_replace("\\", "/", $filePath);
			if(substr($filePath, 0, 1) == "/"){				
				if(strpos($root, "/") !== false){
					//	/folder/			
					if(substr($root, -1) == "/"){
						$filePath = substr($filePath, 1);
					}
					return $root .$filePath;		
				}else{
					//	c:\folder\
					if(substr($root, -1) == "\\"){
						$filePath = substr($filePath, 1);
					}
					return $root .str_replace("/", "\\", $filePath);
				}
			}else{
				if(!is_dir($filePath)){					
					return $filePath;
				}
				return realpath($filePath);
			}
		}		
	}
	
	function InsertImage($imagePath, $width, $height, $imageW, $imageH, $posX, $posY){
		if($imagePath == ""){
			return;
		}
		$imagePath = $this->GetRealPath($imagePath);
		
		if(file_exists($imagePath) &&
			(
			 substr(strtolower($imagePath), -3) == "jpg" ||
			 substr(strtolower($imagePath), -4) == "jpeg" ||
			 substr(strtolower($imagePath), -3) == "png" ||
			 substr(strtolower($imagePath), -3) == "gif"
			 )
			){
			
			if($height > $imageH){
				$imagePosY = $this->posY + round((($height - $imageH) / 2), 0);
			}else{
				$imagePosY = $this->posY;
			}
						
			if($width > $imageW){
				$imagePosX = $this->posX + round((($width - $imageW) / 2), 0);
			}else{
				$imagePosX = $this->posX;
			}
			
			$this->PDF->Image($imagePath, 
								$imagePosX + floatval($this->cellLineWidth) , 
								$imagePosY + floatval($this->cellLineWidth), 
								$imageW - (2 * floatval($this->cellLineWidth)), 
								$imageH - (2 * floatval($this->cellLineWidth)));
			
		}
	}
	
	function GetNumberOfLines($testo, $width){	
		$linee = $this->PDF->NbLines($width, $testo);
		return $linee;				
	}
	
	function WriteHeader(){				
		$style = "";
		$size = intval($this->headerSize);
		if (strtolower($this->headerBold) == "true"){
			$style .= "B";
		}
		if (strtolower($this->headerUnderline) == "true"){
			$style .= "U";
		}
		if (strtolower($this->headerItalic) == "true"){
			$style .= "I";
		}			
		$family = $this->headerFont;
				
		$this->PDF->SetFont( $family, $style, $size);
		
		$color = $this->html2rgb($this->headerColor);	
		$this->PDF->SetTextColor( $color['R'], $color['G'], $color['B']);
		
		$color = $this->html2rgb($this->headerBgColor);	
		$this->PDF->SetFillColor( $color['R'], $color['G'], $color['B']);
			
		$maxLines = 1;
		for($i=0; $i<count($this->itemRecField); $i++){
			$width = $this->GetCellWidth($this->itemWidth[$i]);
			$strValue = preg_replace("/\\n/", "\n", $this->itemLabel[$i]);
			$lines = $this->GetNumberOfLines($strValue, $width);
		
			if($lines > $maxLines){
				$maxLines = $lines;
			}
		}
					
		for($i=0; $i<count($this->itemRecField); $i++){
			$border = 1;
			$fill = 1;			
			$align = "L";
			if(strtolower($this->itemAlign[$i]) == "center"){
				$align = "C";
			}elseif(strtolower($this->itemAlign[$i]) == "right"){
				$align = "R";
			}elseif(strtolower($this->itemAlign[$i]) == "justify"){
				$align = "J";
			}
			$width = $this->GetCellWidth($this->itemWidth[$i]);
			$strValue = preg_replace("/\\n/", "\n", $this->itemLabel[$i]);
						
			$lines = $this->GetNumberOfLines($strValue, $width);
			if($lines < $maxLines){
				for($ii=$lines; $ii<$maxLines; $ii++){
					$strValue .= "\n";
				}
			}
			
			$this->PDF->SetXY($this->posX, $this->posY);
			$this->PDF->MultiCell( $width, floatval($this->cellHeight), $strValue, $border, $align, $fill);
			
			$this->posX += $width;
			
		}
		
		$this->posY += ($maxLines * floatval($this->cellHeight));
		$this->posX = floatval($this->marginLeft);
				
	}
	
	
	function GetPageDimension($which){
		//'if(xunit=="pt")this.k=1;
		//'else if(xunit=="mm")this.k=72/25.4;
		//'else if(xunit=="cm")this.k=72/2.54;
		//'else if(xunit=="in")this.k=72;
		
		//'if(xformat=="a3")xformat=new Array(841.89,1190.55);
		//'	else if(xformat=="a4")xformat=new Array(595.28,841.89);
		//'	else if(xformat=="a5")xformat=new Array(420.94,595.28);
		//'	else if(xformat=="letter")xformat=new Array(612,792);
		//'	else if(xformat=="legal")xformat=new Array(612,1008);
		
		$pageDimension = array();
		$point = 72.0 / 25.4;
		if(strtolower($this->pageSize) == "a3"){
			$pageDimension[] = 841.89;
			$pageDimension[] = 1190.55;
		}elseif(strtolower($this->pageSize) == "a4"){
			$pageDimension[] = 595.28;
			$pageDimension[] = 841.89;
		}elseif(strtolower($this->pageSize) == "a5"){
			$pageDimension[] = 420.94;
			$pageDimension[] = 595.28;
		}elseif(strtolower($this->pageSize) == "letter"){
			$pageDimension[] = 612.0;
			$pageDimension[] = 792.0;
		}elseif(strtolower($this->pageSize) == "legal"){
			$pageDimension[] = 612.0;
			$pageDimension[] = 1008.0;
		}
		
		if(strtolower($this->pageOrientation) == "p"){
			$pageWidth = $pageDimension[0] / $point;
			$pageHeight = $pageDimension[1] / $point;
		}else{
			$pageWidth = $pageDimension[1] / $point;
			$pageHeight = $pageDimension[0] / $point;
		}	
		
		if($which == "w"){
			return $pageWidth;
		}else{
			return $pageHeight;
		}
	}
	
	function NeedNewPage($y){
		$pageHeight = $this->GetPageDimension("h");
		$maxY = $pageHeight - floatval($this->marginBottom);
		if($y > $maxY){
			return true;
		}else{
			return false;
		}		
	}
	
	
	function GetCellPixels($percWidth){
		$pageWidth = $this->GetPageDimension("w");
		$point = 72.0 / 25.4;
		$pixels = round($this->GetCellWidth($percWidth) * $point, 0);
		return $pixels;
	}
	
	function GetCellWidth($percWidth){
		$pageWidth = $this->GetPageDimension("w");
		$width = round(($pageWidth - (floatval($this->marginLeft) + floatval($this->marginRight))) / 100 * $percWidth, 2);
		return $width;
	}
	
	function FormatValue($strValue, $format){
		if(strtolower(substr($format, 0, 6)) == "number"){
			return $this->FormatAsNumber($strValue, $format);
		}elseif(strtolower(substr($format, 0, 4)) == "date"){
			return $this->FormatAsDate($strValue, $format);
		}elseif(strtolower(substr($format, 0, 7)) == "boolean"){
			return $this->FormatAsChk($strValue, $format);
		}elseif(strtolower(substr($format,0,8)) == "checkbox"){
			return $this->FormatAsChk($strValue, $format);
			//FormatValue = FormatAsChk(strValue, Format)
		}else{
			return $strValue;
		}
	}
	
	function FormatAsNumber($strValue, $format){
		$retStr = "";
		if(floatval($strValue)){
			$strValue = floatval($strValue);
		}else{
			$strValue = 0;
		}
		$dec_point = $this->GetDecPoint();
		$thousands_sep = ""; //$this->GetThousandSep();
		
		switch($format){
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
	
	function FormatAsChk($strValue, $format){
		$tmpFormat = preg_replace("/Boolean/i", "", $format);
		$tmpFormat = preg_replace("/Checkbox/i", "", $tmpFormat);
		$tmpFormat = preg_replace("/\(/", "", $tmpFormat);
		$tmpFormat = preg_replace("/\)/", "", $tmpFormat);
		$tmpValue = preg_split("/\//", trim($tmpFormat));
		if($strValue){
			return $tmpValue[0];
		}else{
			return $tmpValue[1];
		}
	}
		
	
	function FormatAsDate($strValue, $format){
		if(strtotime($strValue) === false){
			return "";
		}
		
		$myDate = getdate(strtotime($strValue));
		$retStr = trim(preg_replace("/DATE/i", "", $format));		
		$retStr = preg_replace("/DD/i", str_pad($myDate['mday'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/MM/i", str_pad($myDate['mon'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/YYYY/i", $myDate['year'], $retStr);
		$retStr = preg_replace("/h/i", str_pad($myDate['hours'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/m/i", str_pad($myDate['minutes'], 2, "0", STR_PAD_LEFT), $retStr);
		$retStr = preg_replace("/s/i", str_pad($myDate['seconds'], 2, "0", STR_PAD_LEFT), $retStr);		
		return trim($retStr);
	}
	
	
	function html2rgb($color){    
		if ($color[0] == '#')        
			$color = substr($color, 1);    
		if (strlen($color) == 6)        
			list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);    
		elseif (strlen($color) == 3)  
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);    
		else        
			return false;    
		
		$r = hexdec($r); 
		$g = hexdec($g); 
		$b = hexdec($b);    
		return array('R'=>$r, 'G'=>$g, 'B'=>$b);
	}
	
	function rgb2html($r, $g=-1, $b=-1){    
		if (is_array($r) && sizeof($r) == 3)        
			list($r, $g, $b) = $r;
		
		$r = intval($r); 
		$g = intval($g);    
		$b = intval($b);    
		
		$r = dechex($r<0?0:($r>255?255:$r));    
		$g = dechex($g<0?0:($g>255?255:$g));    
		$b = dechex($b<0?0:($b>255?255:$b));    
		
		$color = (strlen($r) < 2?'0':'').$r;    
		$color .= (strlen($g) < 2?'0':'').$g;    
		$color .= (strlen($b) < 2?'0':'').$b;    
		return '#'.$color;
	}
	
	
	
}
?>