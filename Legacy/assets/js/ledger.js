// JavaScript Document
$(document).ready(function(){
	
	
	
	
	
	$('td a').on('click', function(){
		
		var mbr_linkID = $(this).attr('id');
		
		console.log('mbr_linkID: '+mbr_linkID);
		$(this).parent().parent().next("tr.led").toggle();
		var what = $(this).parent().parent().next("tr.led").html();
		console.log(what);
		
	});
	
	
	
	
	
	
	
	
	
	
});