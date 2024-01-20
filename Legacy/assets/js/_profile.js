// JavaScript Document

 $(document).ready( function() {	





	
	$(document).on('click', '.profile_pic_op', function() {	
				console.log('.profile_pic_op');


				$('div#choose_photo_block').hide();
				
				$('div#crop_photo_block').show();
				
				$('div#frst_photo_cropper').hide();
				
				$('div#sec_photo_cropper').show();

		
						var src = $(this).find('a img.img-responsive').attr('src');
			
							//console.log('src: '+src);
							
						//var html = '<img class="my-secimage" src="' + src + '" />';
						//$('#upload-image').croppie('destroy');
						
						//$("#demo-basic").html(html);
						
						//$('img#profile_bpic').attr("src", response);
			//console.log('html '+html);
			
			$('#demo-basic').croppie('destroy');

						$demo_basic = $('#demo-basic').croppie({
							//enableExif: true,
							url: src,
							viewport: {	width: 200,	height: 200,type: 'square'},
							boundary: {	width: 300,	height: 300	},
							strict: true,
							showZoomer: true,
							enableResize: false
							//enableOrientation: true
						});

						
							//console.log('reader.onload complete'+src);
							


							$('button#process_blob').on('click', function (ev) {
								
										$demo_basic.croppie('result', {
											type: 'canvas',
											size: 'viewport'
										}).then(function (response) {
										$.ajax({
											url: "classes/crop_profilephoto_noblobid.php",
											type: "POST",
											data: {"image":response},
											success: function (data) {
												console.log('process_blob success data: '+data);
												//html = '<img class="my-image" src="' + response + '" />';
												//$("#sec_upload-image-i").html(html);
												
												$('img#profile_bpic').attr("src", response);
							
											}
										});
									});
									$('#updateProfilePhotoModal').modal('hide');


									setTimeout(function() {
										//window.location.href = "https://smashandpass.com/profile/";
										window.location.replace("/profile");

									}, 800);									
									

								});	


			
						//reader.readAsDataURL(this.files[0]);
	
	
	});


				





});
