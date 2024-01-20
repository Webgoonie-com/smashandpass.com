//Javascript Document

	$(document).on('click', 'button#send_private_message', function(event){

			console.log('Clicked to send private message to player');
			
			var fromFriend = $('input#fromFriend').val();
			var toFriend = $('input#toFriend').val();
			var usr_cookie = $('input#usr_cookie').val();
			var private_messageto_member_html = $('textarea#private_messageto_member_html').val();

			$.post('views/subfolder/ajax_load_private_messages.php', {

					user_id: fromFriend, 
					member_id: toFriend, 
					usr_cookie: usr_cookie,
					private_comment_messsage: private_messageto_member_html
					
				}, function(data){
					
					console.log('data: '+data);
					$('ol.commentlist').html(data);					

			}); 
			
			
			$('textarea#private_messageto_member_html').val('');
			
			
			
			//window.location.href = "/message/"+toFriend;
			

	});
