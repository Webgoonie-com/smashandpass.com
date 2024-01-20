// JavaScript Document
$(document).ready(function(){
	








	$(document).on('click', 'button#buy_player', function() {	
 	
			console.log('Clicked Buy Player');
			
		var purchase_amount = $(this).attr('name');
		
		var buy_pic = $(this).parent().parent().parent().find('img.buy-pic').attr('src');
		//console.log('buy_pic: '+buy_pic);
 
		$('div#buy_modal').modal('show');
		
		$('#dsply_purchamount').html('Purchase For $ '+purchase_amount);
		
		var member_id = $(this).parent('div').attr('id');

		
		$('img#modal-pic').attr('src', buy_pic);
		console.log('purchase_amount: '+purchase_amount);
		$('button#buy_player_now').attr('name', purchase_amount);
		
		$('#dsply_purchsebutton').attr('data-id', member_id);
		
	});
	
	

	$(document).on('click', 'button#buy_player_no_owner', function() {	
 	
		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

		var member_id = $(this).parent('div').attr('id');
			
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

	
	$(document).on('click', 'button#buy_player_now', function() {	
 	
		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

		var member_id = $(this).parent('div#dsply_purchsebutton').attr('data-id');
		
	
		var purchase_amount = $('button#buy_player_now').attr('name');
		 
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