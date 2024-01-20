// JavaScript Document
$(document).ready(function(){

 	$('[data-toggle="tooltip"]').tooltip(); 



	$(document).on('click', 'a', function(event){
		var that = $(this).attr('href');
		if( that == '#')
		{ 
			console.log('Found #'); 
			event.preventDefault();
			return false; 
		}
	});
	


	$(document).on('click', '#pic_action_likebox .comment', function() {	
 	
 
		$('#pic_comment_box').toggle();
		return false;
	});

	// User Likes
	$(document).on('click', 'ul#li-actions.like', function() {	
	
			console.log('Clicked Like');
	
			var user_id = $('input#user_id').val();
			var photoid = $(this).attr('rel');
			var usr_cookie = $('input#usr_cookie').val();
	
			$(this).toggleClass("unlike");
			
			if($(this).hasClass(".comment")) return false;
			
			if($('#pic_action_likebox ul.like').hasClass("unlike")){
			
					console.log('Clicked Like Photo');
					
					var thisParagraph = $( this );
					//var count =   parseInt(thisParagraph, 10);
					var count =   parseInt(thisParagraph.find( "li.likecount" ).text(), 10);
					console.log('count'+count);
					count++;
					thisParagraph.find( "li.likecount" ).text( count );    
					
					$.post('models/script_like_user_photo.php', {
							user_id: user_id, usr_cookie: usr_cookie, photoid: photoid
					}, function(data){
					//console.log(data);
				});
				
				
				}else{
			
					console.log('Unclicked Like');
			
			
					  var thisParagraph = $( this );
					  //var count =   parseInt(thisParagraph, 10);
					  var count =   parseInt(thisParagraph.find( "li.likecount" ).text(), 10);
					  console.log('count'+count);
						--count;
						thisParagraph.find( "li.likecount" ).text( count );    
			
				$.post('models/script_chglike_user_photo.php', {user_id: user_id, usr_cookie: usr_cookie, photoid: photoid}, function(data){
				console.log(data);
				});
					
					
			}
	
	
			console.log('Finished Like');
	
	});









}); // End Document Ready!!!