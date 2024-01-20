// JavaScript Document

// http://dimsemenov.com/plugins/magnific-popup/documentation.html


// input#navbar-search
// button#navbar-search-submitbutton#navbar-search-submit

$('button#navbar-search-submit').on('click', function(){	

	//console.log('Name: '+$(this).attr('name'));
	
	var str_search = $('input#navbar-search').val();
	
	//$('ul.nav.nav-tabs li').removeClass('active');
	
		
		
	window.location.href = "/search/?mbrname="+str_search;
	
	


});


$('ul.nav.nav-tabs li a').on('click', function(){	

	//console.log('Name: '+$(this).attr('name'));
	
	var name = $(this).attr('name');
	
	//$('ul.nav.nav-tabs li').removeClass('active');
	
	$('div.tab-content').find('.tab-pane.active').removeClass('active');
	
	$('div.tab-content').find('div'+name).addClass('active');
	
	
	


});


//Edit about me Modal
$('button#open_aboutme_modal').on('click', function(){
	console.log('Clicked open about me modal');
				$('div#about_memodal').modal({
					backdrop: 'static',
				  	keyboard: false,
					show: true
				});


});


	$(document).on('click', 'button#write_aboutme', function() {	
	
			var user_id = $('input#user_id').val();
			var usr_cookie = $('input#usr_cookie').val();

			var _thisaboutme = $('textarea#edit_thisaboutme').val(); 
			
			$.post('models/script_updatethisaboutme.php', {_thisaboutme: _thisaboutme, usr_cookie: usr_cookie, user_id: user_id},
			 function(data){
			
				console.log('thisabout me data: '+data);
				
				$('#footer_aboutme').html(_thisaboutme);
				
				$('#profile_aboutme').html(_thisaboutme);
			
			});	

	});





