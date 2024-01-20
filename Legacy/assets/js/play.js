// JavaScript Document
$(document).ready(function(){




//alert('Play.js Loaded!');


$('#myPlayModal').modal({
  backdrop: 'static',
  keyboard: false
});




$(document).on('click', 'button#message_from_splash_pane_now', function(){
	
			console.log('Clicked A Ajax Pane From Splash Window!');	
});


$(document).on('click', 'button#changemy_view', function(){

		$(this).parent().closest('div.playmatch-feat').hide();

		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		var view_iama = $('select#view_iama').val();
		var view_letmeview = $('select#view_letmeview').val();
		var view_agerange = $('select#view_agerange').val();
		var view_zipcode = $('input#view_zipcode').val();

		$.post('models/script_record_playersettings.php', {
					user_id: user_id,
					usr_cookie: usr_cookie,
					view_iama: view_iama,
					view_letmeview: view_letmeview,
					view_agerange: view_agerange,
					view_zipcode: view_zipcode	
		}, function(data){
			console.log(data);			
			$('div#console_debug').html(data);
		
			
		});


});

$(document).on('click', 'div#play_newmatches button.btn.btn-success', function(){
		var that = 	$(this).parent().closest('div.playmatch-feat').html();
		//console.log('Smash: '+that);


		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		var player_id = $(this).attr('id');
		var player_smashpassaction = 'smash';
		
		$.post('models/script_record_playersmashpass.php', {
					user_id: user_id,
					usr_cookie: usr_cookie,
					player_id: player_id,
					player_smashpassaction: player_smashpassaction	
		}, function(data){
			console.log(data);			
			$('div#console_debug').html(data);
			
		});

		$(this).parent().closest('div.playmatch-feat').hide();
		
});

$(document).on('click', 'div#play_newmatches button.btn.btn-danger', function(){
		var that = $(this).parent().closest('div.playmatch-feat').html();
		//console.log('Pass: '+that);



		
		var user_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		var player_id = $(this).attr('id');
		var player_smashpassaction = 'pass';
		
		$.post('models/script_record_playersmashpass.php', {
					user_id: user_id,
					usr_cookie: usr_cookie,
					player_id: player_id,
					player_smashpassaction: player_smashpassaction	
		}, function(data){
			console.log(data);
			$('div#console_debug').html(data);

		});
		
		$(this).parent().closest('div.playmatch-feat').hide();

		
});




});