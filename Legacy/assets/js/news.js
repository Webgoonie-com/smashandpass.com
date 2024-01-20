



$(document).on('click', 'button#changemy_view', function(){

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
			//$(this).parent().closest('div.playmatch-feat').hide();
			
		});


		window.location.href="/news";


});





$(document).ready(function(){






	// http://dimsemenov.com/plugins/magnific-popup/
	$('.team-members-wrapper').each(function() { 


		$(this).magnificPopup({
			delegate: 'div a.gallery-photos',
			type: 'ajax',
			callbacks: {
			  lazyLoad: function(item) {
				//console.log(item); // Magnific Popup data object that should be loaded
			  }
			},
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1],				
				tPrev: 'Previous (Left arrow key)', // title for left button
				tNext: 'Next (Right arrow key)', // title for right button
				tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter  
				
			},
			image: {

			 markup: '<div class="mfp-figure">'+
						'<div class="mfp-close"></div>'+
						'<div class="mfp-img"></div>'+
						'<div class="mfp-bottom-bar">'+
						  '<div class="mfp-title"></div>'+
						  '<div class="mfp-counter"></div>'+
						'</div>'+
					  '</div>', 
			
			  cursor: 'mfp-zoom-out-cur', 
			
			  titleSrc: 'title', 
			
			  verticalFit: true,

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
		});		



	}); 
			





$(document).on('click', 'div#jumbotron-slider button.btn.has-success', function(){

		$(this).parent().closest('div.item').hide(700);
		
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

		//var that = 	$(this).parent().closest('div.item').html();
		//console.log('Smash: '+that);
		
});

$(document).on('click', 'div#jumbotron-slider button.btn.has-danger', function(){
		//console.log('Pass Clicked: ');
		$(this).parent().closest('div.item').hide(700);

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
		
		//var that = $(this).parent().closest('div.item').html();
		//console.log('Pass: '+that);
		
		
});

























});