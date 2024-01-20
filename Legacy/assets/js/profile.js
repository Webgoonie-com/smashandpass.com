// http://www.dropzonejs.com/#event-success




	// http://dimsemenov.com/plugins/magnific-popup/
	$('.gallery-ajax').each(function() { 


		$(this).magnificPopup({
			delegate: 'div a',
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



// JavaScript Document

// Prevent Dropzone from auto discovering this element:
Dropzone.options.myAwesomeDropzone = false;
// This is useful when you want to create the
// Dropzone programmatically later

// Disable auto discover for all elements:
Dropzone.autoDiscover = false;



	
	
	// http://foliotek.github.io/Croppie/
	$image_crop = $('#upload-image').croppie({
		enableExif: true,
		viewport: {	width: 200,	height: 200,type: 'square'},
		boundary: {	width: 300,	height: 300	},
		strict: true
	});

	


	$('.cropped_image').on('click', function (ev) {
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) {
			$.ajax({
				url: "classes/crop_profilephoto.php",
				type: "POST",
				data: {"image":response},
				success: function (data) {
					console.log('data: '+data);
					html = '<img class="my-image" src="' + response + '" />';
					$("#upload-image-i").html(html);
					
					$('img#profile_bpic').attr("src", response);

				}
			});
		});
		
		$('#updateProfilePhotoModal').modal('hide');


									setTimeout(function() {
										//window.location.href = "http://smashandpass.com/profile";
										window.location.replace("http://smashandpass.com/profile");
									}, 800);									
		
	});	




$(document).on('click', 'img#profile_bpic', function() {

			


		$(this).magnificPopup({
			delegate: 'div a',
			type: 'ajax',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] 
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


		$("div#crop-dropzone").dropzone({


				// Prevents Dropzone from uploading dropped files immediately
				autoProcessQueue: true,
				maxFilesize: 5,
				maxFiles: 1,
				addRemoveLinks: false,
				//parallelUploads: 100,
				forceFallback: false,
				//previewsContainer: '#upload-image-i',
				//clickable:  ["div#still_upload", "#dropzone-top-btn", "div#my-dropzone"],
				clickable:  ["div#still_upload"],
				dictFileTooBig: 'Sorry File Size Too big',
				dictInvalidFileType: "Sorry This File Type Is Not Allowed!",
				dictFallbackMessage: "Sorry your browser does not support thise file upload feature.",
				createImageThumbnails: true,
				uploadMultiple: true,
				enqueueForUpload: false,
				//acceptedFiles: 'image/jpeg,image/pjpeg',
				acceptedFiles: 'image/jpeg,image/pjpeg,image/png,image/gif',
				//paramName: "myphotos",
				url: "/uploads/post_crop.php",
				uploadprogress: function(file, progress, bytesSent) {
					// Display the progress
						//console.log('Upload Progress: File:'+file.name+
						//			' Progress: '+progress+' Bytes Sent'+bytesSent
					//)
				},
				success: function (file, responseText, response) {
					//console.log('Success: '+response);
					//console.log('Success: '+responseText);

					html = '<img src="' + response + '" />';
					//console.log('html: '+html);
					
					$("#upload-image-i").html(html);
					//$('img#profile_bpic').attr("src", response);
			
					var reader = new FileReader();
					reader.onload = function (e) {
						$image_crop.croppie('bind', {
							url: e.target.result
						}).then(function(){
							console.log('jQuery bind complete');
						});			
					}
					reader.readAsDataURL(this.files[0]);
					
					//var args = Array.prototype.slice.call(responseText);
					//console.log('Args: '+args+' Arguments: '+arguments);
					//var trial = file.previewTemplate.appendChild(document.createTextNode(responseText));
					//console.log('Trial: '+trial);
				}
				
		
		
		
		});
	

		$("div#my-dropzone").dropzone({ 

		// Prevents Dropzone from uploading dropped files immediately
		autoProcessQueue: true,
		maxFilesize: 3,
		maxFiles: 50,
		addRemoveLinks: true,

		removedfile: function(file) {
		var name = file.name;    
		name =name.replace(/\s+/g, '-').toLowerCase();    /*only spaces*/
		$.ajax({
			  type: 'POST',
			  url: 'classes/dropzone-delete.php',
			  data: "id="+name,
			  dataType: 'html',
			  success: function(data) {
					//$("#msg").html(data);
					console.log('Delete: '+data);		
			  }
		});		
		var _ref;
		if (file.previewElement) {
		  if ((_ref = file.previewElement) != null) {
			_ref.parentNode.removeChild(file.previewElement);
		  }
		}
		return this._updateMaxFilesReachedClass();
		},
		//parallelUploads: 100,
		forceFallback: false,
		previewsContainer: '.dropzone-previews',
		//clickable:  ["div#still_upload", "#dropzone-top-btn", "div#my-dropzone"],
		clickable:  ["#dropzone-top-btn", "div#my-dropzone"],
		dictFileTooBig: 'Sorry File Size Too big',
		dictInvalidFileType: "Sorry This File Type Is Not Allowed!",
		dictFallbackMessage: "Sorry your browser does not support thise file upload feature.",
		createImageThumbnails: true,
		uploadMultiple: true,
		enqueueForUpload: false,
		acceptedFiles: 'image/jpeg,image/pjpeg',
		//acceptedFiles: 'image/jpeg,image/pjpeg,image/png,image/gif',
		//paramName: "myphotos",
		url: "/uploads/post.php",
		uploadprogress: function(file, progress, bytesSent) {
			// Display the progress
				//console.log('Upload Progress: File:'+file.name+
				//			' Progress: '+progress+' Bytes Sent'+bytesSent
			//)
		},
		success: function (file, responseText, response) {
			//console.log('Success: '+responseText);
			//var args = Array.prototype.slice.call(responseText);
			//console.log('Args: '+args+' Arguments: '+arguments);
			//var trial = file.previewTemplate.appendChild(document.createTextNode(responseText));
			//console.log('Trial: '+trial);
		},
		complete: function (file, responseText, response) {
			//console.log('C: '+response);
			//console.log('Complete responseText: '+response);

		}

		
		});	
	
	
	

$('div#still_upload').on('click', function(){

			
			//$('#updateProfilePhotoModal').modal('hide');
			
				var name = $(this).attr('name');
	
				//$('ul.nav.nav-tabs li').removeClass('active');
				
				//$('div.tab-content').find('.tab-pane.active').removeClass('active');
				
				//$('div.tab-content').find('div'+name).addClass('active');
				
				$('div#choose_photo_block').hide();
				$('div#crop_photo_block').show();
				$('div#frst_photo_cropper').show();				
				$('div#sec_photo_cropper').hide();
		
				

			
});
	

	$('button#submit_pubcomment').on('click', function(){

		var user_id = $('input#user_id').val();
		var member_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();
		
		var comment = $('textarea#profile_comment').val();
		console.log('Comment: '+comment);
			

		
		$.post('classes/scriptpost_publiccomment.php', {user_id: user_id, member_id: member_id, usr_cookie: usr_cookie, comment: comment}, function(data){
		
			console.log('Data: '+data);
		 $("div#big_thread_box").html(data);
		 //$('div#thread_box:first-child').append("" + data + "");
		
		});
		
		$('textarea#profile_comment').val('');
		
		
	});



	
	
	
$(document).ready(function(){	


$('input#user_nicknameurl').on('click', function(){

	var url =  $.trim($(this).val().toLowerCase());
	 	url = url.replace(" ", "");
	console.log('url space: '+url);
	
	var url_length = $("input#user_nicknameurl").val().length;
	
	if(url_length < 4) return false;
	
	$('input#user_nicknameurl').val(url);
	
});


$('input#user_nicknameurl').on('change', function(){
	
	
	
	var url =  $.trim($(this).val().toLowerCase());
	 	url = url.replace(" ", "");
	console.log('url: '+url);
	
	var url_length = $("input#user_nicknameurl").val().length;
	
	if(url_length < 4) return false;
	
	$('input#user_nicknameurl').val(url);

 	var user_nicknameurl  = $('input#user_nicknameurl').val();
	
	
	console.log('user_nicknameurl-url: '+url);

		var user_id = $('input#user_id').val();
		var member_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

	
	$.post('models/script_checkuser_usernameurl.php', {
		user_id: user_id,
		member_id: member_id,
		usr_cookie: usr_cookie,
		user_nicknameurl: user_nicknameurl
		
		}, function(data){
			
			$('span#username_htmlresults').html(data);
			
	});
	
	
});



$('button#check_usernameurl').on('click', function(){
	
 	var user_nicknameurl  = $('input#user_nicknameurl').val();
	
	//$(this).html('Save');

	
	var url_length = $("input#user_nicknameurl").val().length;
	
	if(url_length < 4) return false;
	
	console.log('user_nicknameurl: '+user_nicknameurl);

		var user_id = $('input#user_id').val();
		var member_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

	
	$.post('models/script_checkuser_usernameurl.php', {
		user_id: user_id,
		member_id: member_id,
		usr_cookie: usr_cookie,
		user_nicknameurl: user_nicknameurl
		
		}, function(data){
			
			$('span#username_htmlresults').html(data);
			
	});
	
});


$('button#save_usernameurl').on('click', function(){
	
 	var user_nicknameurl  = $('input#user_nicknameurl').val();
	
	//$(this).html('Save');

	
	var url_length = $("input#user_nicknameurl").val().length;
	
	if(url_length < 4) return false;
	
	console.log('user_nicknameurl: '+user_nicknameurl);

		var user_id = $('input#user_id').val();
		var member_id = $('input#user_id').val();
		var usr_cookie = $('input#usr_cookie').val();

	$('div#read_nicknameurl').html('<h3>@' + user_nicknameurl + '</h3>');
	
	$.post('models/script_checkuser_svusernameurl.php', {
		user_id: user_id,
		member_id: member_id,
		usr_cookie: usr_cookie,
		user_nicknameurl: user_nicknameurl
		
		}, function(data){
			
			
			$('div#console_debug').html(data);
			
	});
	
	$(this).hide();
 
});



	var user_nicknameurl = $('input#user_nicknameurl').val();













	$('a#top_btn_photoupload').on('click', function(){
	
				
	
				$('#updateProfilePhotoModal').modal({
					backdrop: 'static',
				  	keyboard: false,
					show: true
				})
				// Disabled because I couldn't get photos to load properly for .profile_pic_op
				$('#modal_photo_flow').load('classes/ajax_private.profile_photos.php');
				$('div#choose_photo_block').show();
				
				$('div#crop_photo_block').hide();
				
				$('div#frst_photo_cropper').hide();
				
				$('div#sec_photo_cropper').hide();

	
	
	});






	
	//http://dimsemenov.com/plugins/magnific-popup/



$('.gallery-ajax ul.dropdown-menu.dropdown-user li span#del_photo').on('click', function(){
	console.log('Clicked Delete Photo');
	var user_id = $('input#user_id').val();
	var photoid = $(this).attr('class');
	var usr_cookie = $('input#usr_cookie').val();
	$.post('models/script_del_profile_photo.php', {user_id: user_id, usr_cookie: usr_cookie, photoid: photoid}, function(data)
	{
			console.log('Data Del Profile Photo: '+data);
	});
	
	var _thatphoto = $(this).closest('.col-md-4.col-xs-6').hide(400);
	
});

	
	
	
	
});
