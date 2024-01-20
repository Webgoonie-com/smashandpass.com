// JavaScript Document

	// http://foliotek.github.io/Croppie/
	$image_crop = $('#crop_frame_bx').croppie({
		enableExif: true,
		viewport: {	width: 200,	height: 200,type: 'square'},
		boundary: {	width: 300,	height: 300	},
		strict: true
	});

	

	$('button#save_photo').on('click', function (ev)
	{
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) 
			{
				$.ajax({
						url: "classes/crop_profilephoto.php",
						type: "POST",
						data: {"image":response},
						success: function (data)
						{
							console.log('data: '+data);
							//html = '<img class="my-image" src="' + response + '" />';
							//$("#upload-image-i").html(html);
							
							//$('img#profile_bpic').attr("src", response);

									setTimeout(function() {
										//window.location.href = "http://smashandpass.com/profile/";
										//window.location.replace("http://smashandpass.com/profile");
										window.location.replace("/profile");

									}, 2000);									
							
		
						}
					  });
			}).hide();
		

		
		
		
	});

		


$(document).ready(function(){






		$("div#regphotocrop-dropzone").dropzone({


				// Prevents Dropzone from uploading dropped files immediately
				autoProcessQueue: true,
				maxFilesize: 5,
				maxFiles: 1,
				addRemoveLinks: false,
				//parallelUploads: 100,
				forceFallback: false,
				//previewsContainer: '#upload-image-i',
				//clickable:  ["div#still_upload", "#dropzone-top-btn", "div#my-dropzone"],
				clickable:  ["button#upload_photo", "img#bpic_frame"],
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
					
					$("#bpic_frame").html(html);
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
					$('div#upload_reg_photoblock').hide();
					$('div#crop_reg_photoblock').show();
				}
				
		
		
		
		});








});