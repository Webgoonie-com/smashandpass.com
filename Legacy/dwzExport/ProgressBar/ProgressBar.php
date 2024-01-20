<?php
$progress_page = "graphics_cyan_1";
$progress_key  = "";
if(isset($_GET["ProgressPage"])){
	$progress_page = strtolower($_GET["ProgressPage"]);
}
if(isset($_GET["progress_key"])){
	$progress_key = $_GET["progress_key"];
}
?>

<html>
<head>

<script language="javascript" src="jquery-1.3.2.min.js" type="text/javascript" ></script>

<meta http-equiv="Page-Enter" content="revealTrans(Duration=0,Transition=6)">
<Title>Upload in Progress</Title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
.Testo12BB {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #003399;
}
.Testo12N {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
</style>
<script language="javascript">
var C_ATTRIBUTE = 0
var C_TEXT = 1
var C_DATA = 2

var date_start = new Date()
var progress_page = "<?php echo $progress_page; ?>"
var progress_key = "<?php echo $progress_key;  ?>"
var host = "<?php echo $_SERVER['HTTP_HOST'];  ?>"
var TDsread
var TDsRemain
var Bar
var refresh_timeout = 750

var TotalBytes = 0
var BytesRead = 0

var PercBytesRead = 0
var PercentRest = 0
var RestTime = 0
var TransferRate = 0
var UploadTime = 0
var is_done
var work

function Start(){
	RenderProgress()
	setTimeout("CallProgress()", 1000)
}

function CallProgress(){
	
	var urlPage = "GetProgress.php"
	var postData = "progress_key=" + progress_key
	//prompt(urlPage + "?" + postData, urlPage + "?" + postData)
	var objXml
	$.ajax({
		url: urlPage,
		dataType:"xml",
		data: postData,
		type: "GET",
		cache:false,
		complete:function(XMLHttpRequest, textStatus){
			
			if(XMLHttpRequest.status.toString() == "500" && textStatus.toLowerCase() == 'error'){
				win = window.open("")
				win.document.open()
				win.document.write(XMLHttpRequest.responseText)
				win.document.close()
			}else{
				objXml = XMLHttpRequest.responseXML
				
				if(objXml){
					TotalBytes = parseFloat(dwzGetXmlValue(objXml, "total", C_TEXT))
					BytesRead = parseFloat(dwzGetXmlValue(objXml, "current", C_TEXT))
					is_done = dwzGetXmlValue(objXml, "done", C_TEXT)				
					work = dwzGetXmlValue(objXml, "work", C_TEXT)
					UploadTime = parseInt(dwzGetXmlValue(objXml, "start_time", C_TEXT))
					
					if(!isNaN(TotalBytes)){
						RenderProgress()
					}
				}
				if(is_done != "DONE"){
					setTimeout("CallProgress()", refresh_timeout)
				}
			}
		},
		async: true
	});
	
	
}

function RenderProgress(){
	if(BytesRead != 0){
				
		PercBytesRead = Math.round(100 * BytesRead / TotalBytes, 0)
		PercentRest = (100 - PercBytesRead).toString()
		PercBytesRead = PercBytesRead.toString()
		
		if(UploadTime < 1){
			UploadTime = 0
			//TransferRate = 0
			RestTime = 0
		}else{
			TransferRate = BytesRead / UploadTime	
			RestTime = FormatTime((TotalBytes - BytesRead) / TransferRate)		
			//TransferRate = FormatBytes(TransferRate)
		}
		
		UploadTime = FormatTime(UploadTime)
		TotalBytes = FormatBytes(TotalBytes)
		BytesRead = FormatBytes(BytesRead)
	}
	
	
	switch(progress_page){
	case "bigbar":
		TDsread = GetString(0.25 * PercBytesRead, "<TD BGColor=blue >&nbsp;</TD>")
		TDsRemain = GetString(0.25 * PercentRest, "<TD >&nbsp;</TD>")		
		Bar = "<Table cellpadding='0' height='20' cellspacing='0' border='1' width='100%' style='border:1px inset white' ><tr>" 
		Bar += TDsread & TDsRemain + "</tr></table>"

		break;
	case "bigbar2":
		TDsread = GetString(0.25 * PercBytesRead, "<TD BGColor=blue >&nbsp;</TD>")
		TDsRemain = GetString(0.25 * PercentRest, "<TD >&nbsp;</TD>")		
		Bar = "<Table cellpadding='0' height='20' cellspacing='2' border='0' width='100%'  ><tr>" + TDsread + TDsRemain + "</tr></table>"
		
		break;
	case "littlebar":
		TDsread = GetString(0.5 * PercBytesRead, "<TD BGColor=blue >&nbsp;</TD>")
	  	TDsRemain = GetString(0.5 * PercentRest, "<TD >&nbsp;</TD>")
		Bar = "<Table cellpadding='0' height='20' cellspacing='0' border='1' width='100%' style='border:1px inset white' ><tr>" 
		Bar += TDsread + TDsRemain & "</tr></table>"
		break;
	case "littlebar2":
						
		TDsread = GetString(0.5 * PercBytesRead, "<TD BGColor=blue >&nbsp;</TD>")
  		TDsRemain = GetString(0.5 * PercentRest, "<TD >&nbsp;</TD>")
		Bar = "<Table cellpadding='0' height='20' cellspacing='2' border='0' width='100%' style='border:1px inset white' ><tr>" 
		Bar += TDsread + TDsRemain + "</tr></table>"
		
		break;
	case "mac":
		imageBar = "../Images/MacBar.gif"
		Bar = "<Table align=left background='../Images/MacBg.gif' cellpadding=0 height='12' cellspacing=0 border='0' width='300' >"
		Bar += "<tr><TD nowrap='nowrap' align=left>"
		qty = 43
		t = Math.round(qty / 100 * PercBytesRead, 0)
		for(var x=0; x<t; x++){
			Bar += "<img src='" + imageBar + "' width='7' border='0' height='12' />"
		}
		Bar += "</TD></tr></table>"		
		
		break;		
	case "graphics3d":
	case "graphics_cyan_1":
	case "graphics_cyan_2":
	case "graphics_cyan_3":
	case "graphics_orange":
	case "graphics_green":
	case "graphics_blue":
	
		if (progress_page == "graphics3d"){
			imageBar = "../Images/3D_Bar.gif"
		}else if(progress_page == "graphics_cyan_1" || progress_page == "graphics_cyan_2" || progress_page == "graphics_cyan_3"){
			imageBar = "../Images/Bar_Cyan.gif"
		}else if(progress_page == "graphics_orange"){
			imageBar = "../Images/Bar_Orange.gif"
		}else if(progress_page == "graphics_green"){
			imageBar = "../Images/Bar_Green.gif"
		}else if(progress_page == "graphics_blue"){
			imageBar = "../Images/Bar_Blue.gif"
		}
		Bar = "<Table align='center' cellpadding='0' height='21' cellspacing='0' border='1' width='337' ><tr><TD align=left>"
		Bar += "<img src='" + imageBar + "' width=" + Math.round(3.35 * PercBytesRead, 0) + " border='0' height='21' /></TD></tr></table>"		
		break;
		
	default:
		TDsread = GetString(0.5 * PercBytesRead, "<TD BGColor=blue>&nbsp;</TD>")
		TDsRemain = GetString(0.5 * PercentRest, "<TD>&nbsp;</TD>")
		Bar = "<Table cellpadding='0' height='20' cellspacing='0' border='0' width='100%' ><tr>" + TDsread + TDsRemain + "</tr></table>"
	}
		
	document.title = PercBytesRead + "% completed - import to " + host + " in progress";;
		
	if(progress_page == "mac"){
		SetHtml("tr_mac_bar", Bar)
		SetHtml("tr_mac_total_bytes", "Importing:&nbsp;" + work)
		SetHtml("tr_mac_progress", BytesRead + "&nbsp;of&nbsp;" + TotalBytes + "&nbsp;(" + PercBytesRead + "%)&nbsp;-&nbsp;About&nbsp;" + RestTime)
	}else{
		SetHtml("tr_total_bytes", work)
		SetHtml("tr_bar", Bar)
		SetHtml("tr_bytes", BytesRead + "&nbsp;of&nbsp;" + TotalBytes + "&nbsp;(" + PercBytesRead + "%)")
		SetHtml("tr_time", UploadTime)
		SetHtml("tr_time_left", RestTime)
	}
	
}

function SetHtml(el, html){
	$("#"+el).html(html)
}

function FormatBytes(bytes){
	/*
	if(!isNaN(bytes)){
		if(parseFloat(bytes) > 1000000){ 		//1M
			return Math.round(parseFloat(bytes) / 1000000,1).toString() + "MB"
		}else if( parseFloat(bytes) > 1024 ){	//1k
			return Math.round(parseFloat(bytes) / 1024, 1).toString() + "Kb"
		}else{
		  	return Math.round(parseFloat(bytes), 0).toString() + "B"
		}
	}
	*/
	return bytes;
}


function FormatTime(ms){
	//var ms = 0.001 * ms //get second
	var minute = Math.round(ms / 60, 0).toString();
	var sec = "0" + Math.round(ms % 60, 0).toString();
	sec = sec.substring(sec.length - 2);
	return minute + ":" + sec + "s";
}


function GetString(num, char){
	var str = ""
	num = Math.round(num, 0)	
	for(var x=0; x<num; x++){
		str += char
	}	
	return str
}
function dwzGetXmlValue(objXml, tagName, sType){
	var doc = objXml.getElementsByTagName(tagName)
	retStr = ""
	if( doc.length > 0 ) 
	{
		switch(sType){
		case C_TEXT:
			if(doc[0].text){
				retStr = doc[0].text
			}else if(doc[0].textContent){
				retStr = doc[0].textContent
			}			
			break
		case C_DATA:
			if(doc[0].hasChildNodes() && doc[0].childNodes[0]){
				if(doc[0].childNodes[0].text){
					retStr = doc[0].childNodes[0].text
				}else if(doc[0].textContent){
					retStr = doc[0].textContent
				}
			}
			break
		}
	}
	return retStr	
	
}


function closeWin(){
	top.close()
}	
</script>
</Head>

<Body <?php echo " onload='javascript:Start()' " ?> BGcolor="<?php

switch($progress_page){
	case "graphics_cyan_1":
	case "graphics_cyan_2":
	case "graphics_cyan_3":
		echo "#D4E6F9";
		break;
	case "graphics3d":
		echo "#09CFFB";
		break;
	case "graphics_orange":
		echo "#FDCF7D";
		break;
	case "graphics_green":
		echo "#6FD764";
		break;
	case "graphics_blue":
		echo "#60ADFE";
		break;
	case "mac":
		echo "#FFFFFF";
		break;
	default:
		echo "#cecece";
		break;
}
?>" scroll="no" LeftMargin="5" TopMargin="5" rightmargin="5" bottommargin="5"  marginwidth="0" marginheight="0">

<table width="100%" border="0" cellspacing="0" cellpadding="00">
    <tr>
      <td align="center"><img src="<?php
switch($progress_page){
	case "graphics_cyan_1":
		echo "../Images/Cyan_1.gif";
		break;
	case "graphics_cyan_2":
		echo "../Images/Cyan_2.gif";
		break;
	case"graphics_cyan_3":
		echo "../Images/Cyan_3.gif";
		break;
	case "graphics3d":
		echo "../Images/Transfer.gif";
		break;
	case "graphics_orange":
		echo "../Images/Orange.gif";
		break;
	case "graphics_green":
		echo "../Images/Green.gif";
		break;
	case "graphics_blue":
		echo "../Images/Blue.gif";
		break;
	default:
		echo "../Images/Transfer.gif";
}
?>" border="0" /></td>
    </tr>
  </table>


<?php
if ($progress_page == "mac"){
?>



<table><tr><td height="10"></td></tr></table>
<Table class="Testo12N" width=100% border=0 align="center" cellpadding=0 cellspacing=0 height="60" >
  <tr>
  	<td rowspan="3" width="40" valign="middle" align="center"><img src="../Images/MacSx.gif" width="28" height="34" /></td>
  	<td id="tr_mac_total_bytes" >Importing:&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" align="left" id="tr_mac_bar" >
    
    	<Table align="center" background='../Images/MacBg.gif' cellpadding=0 height='12' cellspacing=0 border='0' width='300' ><tr><TD nowrap='nowrap' align=left>
		<img src='../Images/MacBar.gif' width='7' border='0' height='12' />
		</TD></tr></table>
    
    </td>
  </tr>
  <tr>
  	<td id="tr_mac_progress" >Progress:&nbsp;</td>
  </tr>
</table>



<?php }else{ ?>




<Table width=100% border=0 align="center" cellpadding=3 cellspacing=0 >
  <tr>
    <td width="9%" class="Testo12N">Importing: </td>
	<td width="91%" class="Testo12N" id="tr_total_bytes" >&nbsp;</td>
</tr></Table>



<Table width=100% border=0 align="center" cellpadding=1 cellspacing=0 height="23" >
  <tr>
    <td valign="middle" align="left" id="tr_bar" >&nbsp;</td>
  </tr>
</table>



<Table  width="100%" border=0 align="center" cellpadding=3 cellspacing=0>
  <tr> 
    <Td width="77" class="Testo12N" >Progress :</td>
    <Td width="629" class="Testo12N" id="tr_bytes" >&nbsp;</Td>
  </tr>
  <tr> 
    <Td class="Testo12N">Time :</td>
    <Td class="Testo12N" id="tr_time" >&nbsp;</Td>
  </tr>
  <tr> 
    <Td class="Testo12N">Time left :</td>
    <Td class="Testo12N" id="tr_time_left" >&nbsp;</Td>
  </tr>
</table>

<?php } ?>
 
</Body>
</HTML>
