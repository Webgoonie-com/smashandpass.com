// JavaScript Document
	
	$.vegas('slideshow', {
		delay:5000,
		backgrounds:[
			{ src:'assets/images/background-0.jpg', fade:1500 },
			{ src:'assets/images/background-1.jpg', fade:1500 },
			{ src:'assets/images/background-2.jpg', fade:1500 },
			{ src:'assets/images/background-3.jpg', fade:1500 },
			{ src:'assets/images/background-4.jpg', fade:1500 },
			//{ src:'assets/images/background-5.jpg', fade:1500 },
	  	]
	})('overlay', {src:'assets/images/overlay.png'});



function run_userjoin_script(){

		window.location.replace("/uphoto");

}


function run_joincheck(){

		var join_e = $('input#join_email').val().trim();
		
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		
		if(testEmail.test(join_e)){
		 		 //return true;
			$('input#join_email').removeClass("has-error active").addClass("has-success");
			$('input#join_email').removeClass("error").addClass("active");
			$('input#join_email').parent().removeClass("error").addClass("has-success");
				console.log('Good Email');

		}else{
				console.log('Bad Email');
			
		 		$('input#join_email').removeClass("has-success active").addClass("has-error");
				
				if($('input#join_email').parent().hasClass("has-success"))
				{
					$('input#join_email').parent().removeClass('has-success');
					$('input#join_email').addClass('error');
					$('input#join_email').parent().addClass('error');
					return false;
				}

		 
		 return false;
		}
		
		
		if($('input#join_pass').hasClass("erorr"))
		{
			$('input#join_pass').removeClass('error');
			$('input#join_pass').addClass('active');
			$('input#join_pass').parent().addClass('active');
			return false;
		}


}


//.bind('change click', function(){
$('input#join_email').on('click', function(){
	
	if(!$(this).hasClass( "active" )){
		$(this).addClass('active');
		$(this).parent().addClass('active');
	}
	
	
});

$('input#join_email').on('change', function(){

	
	
	
	
	if($(this).hasClass("erorr")){
		$(this).removeClass('error');
		$(this).addClass('active');
		$(this).parent().addClass('active');
	}
	
	
	run_joincheck()
	
});

$('input#join_pass').on('change', function(){
	
	if($(this).hasClass("erorr")){
		$(this).removeClass('error');
		$(this).addClass('active');
		$(this).parent().addClass('active');
	}

});

$(document).ready(function(){


  	var tz = jstz();
  
	var zname = tz.timezone_name;
	//console.log('Timezone: '+zname);
	
	
	//GOOGLE SECTION
	$('span.fa.fa-google-plus-square').click(function() {
			$('#signinGoogleModal').modal('show');
			$('#signinGoogle_captionblock').load('gredirect.php');
	});
	
	$('a.btn.btn-block.btn-social.btn-google').click(function() {
			$('#signinGoogleModal').modal('show');
			$('#signinGoogle_captionblock').load('gredirect.php');
			
	});



	//FACEBOOK SECTION
	$('span.fa.fa-facebook-square').click(function() {
			$('#signinFacebookModal').modal('show');
			$('#signinFacebook_captionblock').load('fbredirect.php');
	});
	
	$('a.btn.btn-block.btn-social.btn-facebook').click(function() {
			$('#signinFacebookModal').modal('show');
			
			
			$('#signinFacebook_captionblock').load('fbredirect.php');
	});



	$( "select#ethnicity_select" ).change(function() {
		var ethnicity = $(this).val();
		console.log(ethnicity);
	});


	//Activate Form Home Page
	$('.box.registration-form input.form-control, .box.registration-form select.form-control').on('click', function(){
		$(this).addClass('active');
	});


	//JOIN SECTION
	$('button#join_submit').click(function() {
		
		run_joincheck();
		
		
		var join_fname = $('input#join_fname').val();
		
		var join_lname = $('input#join_lname').val();
		
		var join_email = $('input#join_email').val().trim();

		var join_e = $('input#join_email').val().trim();
		
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		
		if(testEmail.test(join_e)){
		 		 //return true;
			$('input#join_email').removeClass("has-error active").addClass("has-success");
				console.log('Good Email');
				
				if($('input#join_email').hasClass("erorr"))
				{
					$('input#join_email').removeClass('error');
					$('input#join_email').addClass('success');
					$('input#join_email').parent().addClass('success');
				}

		}else{
				console.log('Bad Email');
			
		 $('input#join_email').removeClass("has-success active").addClass("has-error");
		 alert('Sorry Your Email Is Not Valid');
				$('input#join_email').removeClass('active');
				$('input#join_email').addClass('error');
				$('input#join_email').parent().addClass('error');
				
		 
		 return false;
		}


		
		
		var join_pass = $('input#join_pass').val();
		if(!join_pass){
			alert('Password Empty');
			
				$('input#join_pass').removeClass('active');
				$('input#join_pass').addClass('error');
				$('input#join_pass').parent().addClass('error');
			
			return false;
		}
		
		
		var join_zipcode = $('input#join_zipcode').val();
		
		var birth_month = $('select#birth_month').val();
		var birth_day = $('select#birth_day').val();
		var birth_year = $('select#birth_year').val();


		var ethnicity = $('#ethnicity_select').val();
		
		
		if($('input#male').is(':checked')) {
			var join_sex = "Male"; 
		}else if($('input#female').is(':checked')) {
			var join_sex = "Female"; 
		}else{
			var join_sex = ""; 
		}
		
		
		$.post('classes/script_joinuser.php', {
				join_fname: join_fname,
				join_lname: join_lname,
				join_email: join_email,
				join_pass: join_pass,
				join_zipcode: join_zipcode,
				birth_month: birth_month,
				birth_day: birth_day,
				birth_year: birth_year,
				ethnicity: ethnicity,
				join_sex: join_sex,
				zname: zname
		},  function(data){
		
		console.log('Data: '+data);
		
		$('div#console_debug').html(data);
		
		});
		
		
		
		
		
		
	});


	$('button#loginone').click(function(){
	
	
		var email1 = $('input#email1').val().trim();
		var passme1 = $('input#passme1').val().trim();

		if(!email1) return false;
		if(!passme1) return false;
		
		$.post('classes/scipt_loggin.php', {
				email1: email1,
				passme1: passme1
			}, function(data){
		
			console.log('loggedin data'+data);
			
			$('div#console_debug').html(data);
			
		
		});
		
		
	
	});



});



function run_useralreadyexist_script() {

	console.log('Running User Already Exist Script');
	// Put some code here
	

}	
