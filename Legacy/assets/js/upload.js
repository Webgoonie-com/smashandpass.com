// JavaScript Document
$(document).ready(function(){


	$image_crop = $('#upload-image').croppie({
		enableExif: true,
		viewport: {
			width: 200,
			height: 200,
			type: 'square'
		},
		boundary: {
			width: 300,
			height: 300
		},
		showZoomer: true,
		enableResize: true
		//enableOrientation: true
	});
	
	$('#images').on('change', function () { 
		var reader = new FileReader();
		reader.onload = function (e) {
			$image_crop.croppie('bind', {
				url: e.target.result
			}).then(function(){
				console.log('jQuery bind complete');
			});			
		}
		reader.readAsDataURL(this.files[0]);
	});



	$('.cropped_image').on('click', function (ev) {
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) {
			$.ajax({
				url: "classes/Coderszine.php",
				type: "POST",
				data: {"image":response},
				success: function (data) {
					html = '<img src="' + response + '" />';
					$("#upload-image-i").html(html);
					console.log('html: '+html);
					$('img#profile_bpic').attr("src", html);

				}
			});
		});
	});	




});