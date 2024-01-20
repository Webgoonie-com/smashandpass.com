// JavaScript Document
$(document).ready(function(){	

// Prevent Dropzone from auto discovering this element:
Dropzone.options.myAwesomeDropzone = false;
// This is useful when you want to create the
// Dropzone programmatically later

// Disable auto discover for all elements:
Dropzone.autoDiscover = false;




	$(document).on('click', '.u-friend-player', function(event){

			var user_id = $('input#user_id').val();
			var member_id = $('input#member_id').val();
			var usr_cookie = $('input#usr_cookie').val();

			console.log('Clicked u-friend-player');
			$.post('models/script_request_friendship.php', {

					user_id: user_id, member_id: member_id, usr_cookie: usr_cookie
					
				}, function(data){
					
					console.log('data: '+data);
					$('div#console_debug').html(data);

			}); 

	});


	$(document).on('click', '#submit_private_message_to_member', function(event){

			console.log('Clicked to send private message to player');
			
			var user_id = $('input#user_id').val();
			var member_id = $('input#member_id').val();
			var usr_cookie = $('input#usr_cookie').val();
			var private_comment_messsage = $('textarea#private_comment_messsage').val();

			$.post('models/script_send_private_message_to_member.php', {

					user_id: user_id, 
					member_id: member_id, 
					usr_cookie: usr_cookie,
					private_comment_messsage: private_comment_messsage
					
				}, function(data){
					
					console.log('data: '+data);
					$('div#console_debug').html(data);

			}); 
			
			
			$('textarea#private_comment_messsage').val('');
			

	});
	

	$(document).on('click', '.u-message-player', function(event){

			console.log('Clicked u-message-player');
			
			$('div#message_player_view_pane').modal({backdrop: 'static', keyboard: false});
			

	});
	
	


	$(document).on('click', '.u-like-player', function(event){

			console.log('Clicked u-like-player'); 

	});


	$(document).on('click', '.u-follow-player', function(event){

			console.log('Clicked u-follow-player'); 

			var user_id = $('input#user_id').val();
			var member_id = $('input#member_id').val();
			var usr_cookie = $('input#usr_cookie').val();

			$.post('models/script_request_following.php', {

					user_id: user_id, member_id: member_id, usr_cookie: usr_cookie
					
				}, function(data){
					
					console.log('data: '+data);
					$('div#console_debug').html(data);

			}); 


	});
	
	
 
	// http://dimsemenov.com/plugins/magnific-popup/	
	$('.gallery-ajax').each(function() { // the containers for all your galleries


		$(this).magnificPopup({
			delegate: 'div a',
			type: 'ajax',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			callbacks: {
					elementParse: function(item) {
					  // Function will fire for each target element
					  // "item.el" is a target DOM element (if present)
					  // "item.src" is a source that you may modify
					
					  //console.log('_Thisitem: '+item); // Do whatever you want with "item" object
					}
			},
			image: {

			markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<div class="mfp-img"></div>'+
					'<div class="mfp-bottom-bar">'+
					  '<div class="mfp-title"></div>'+
					  '<div class="mfp-counter"></div>'+
					'</div>'+
				  '</div>', // Popup HTML markup. `.mfp-img` div will be replaced with img tag, `.mfp-close` by close button
			
			cursor: 'mfp-zoom-out-cur', // Class that adds zoom cursor, will be added to body. Set to null to disable zoom out cursor.
			
			titleSrc: 'title', // Attribute of the target element that contains caption for the slide.
			// Or the function that should return the title. For example:
			// titleSrc: function(item) {
			//   return item.el.attr('title') + '<small>by Webgoonie</small>';
			// }
			
			verticalFit: true, // Fits image in area vertically
			
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			},
			modal: true
		});
		
		$(document).on('click', '.popup-modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
			return false;
		});		



	}); 



	















	$('button#submit_pubcomment').on('click', function(){

		var user_id = $('input#user_id').val();
		var member_id = $('input#member_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		
		var comment = $('textarea#profile_comment').val();
		console.log('Comment: '+comment);
			

		
		$.post('classes/scriptpost_publiccomment.php', {user_id: user_id, member_id: member_id, usr_cookie: usr_cookie, comment: comment}, function(data){
		
		console.log('Data: '+data);
		 $("div#thread_box").before("" + data + "");
		 //$('div#thread_box:first-child').append("" + data + "");
		
		});
		
		$('textarea#profile_comment').val('');
		
		
	});






	$(document).on('click', 'button#buy_player', function() {	
 	
			console.log('Clicked Buy Player');
			
		var purchase_amount = $(this).attr('name');
		
		var copy_profile_photo = $('img#profile_bpic').attr('src');
 
		$('div#buy_modal').modal({backdrop: 'static', keyboard: false});
		
		$('#dsply_purchamount').html('Purchase For $ '+purchase_amount);
		
		$('img#modal-pic').attr('src', copy_profile_photo);
		
	});
	
	
	
	$(document).on('click', 'button#buy_player_now', function() {	
 	
		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

		var member_id = $('input#member_id').val();
	
		var purchase_amount = $('button#buy_player').attr('name');
		 
		$('div#buy_modal').modal('hide');
		
		$.post('models/script_user_buyplayer.php', {


			
					user_id: user_id,
					member_id: member_id, 
					usr_cookie: usr_cookie, 
					purchase_amount: purchase_amount
			
			}, function(data){
		
		
				console.log(data);
				
				$('div#console_debug').html(data);
		
		
		});
		
		
	});



	
	










	
	



	
	
	
	
});