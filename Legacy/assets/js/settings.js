// JavaScript Document

$(document).ready(function(){



			
			
		$('button#save_profile_settings').on('click', function(){

			
			var my_displayname = $('input#my_displayname').val();
			var join_fname = $('input#join_fname').val();
			var join_lname = $('input#join_lname').val();
			var my_zipcode = $('input#my_zipcode').val();
			var show_fullname = $('select#show_fullname').val();
			var my_gender = $('select#my_gender').val();
			var my_birth_month = $('select#my_birth_month').val();
			var my_birth_day = $('select#my_birth_day').val();
			var my_birth_year = $('select#my_birth_year').val();
			var my_zipcode = $('input#my_zipcode').val();
			var my_country = $('select#my_country').val();
			var show_mylocation = $('select#show_mylocation').val();
			
			var ethnicity_select = $('select#ethnicity_select').val();
			var show_ethnicity = $('select#show_ethnicity').val();
			
			var my_religion = $('select#my_religion').val();
			var show_religion = $('select#show_religion').val();
			var sexualorientation = $('select#sexualorientation').val();
			var show_orientation = $('select#show_orientation').val();
			console.log(show_orientation+' :show_orientation');
			
			var my_relstatus = $('select#my_relstatus').val();
			var show_my_relstatus = $('select#show_my_relstatus').val();
			
			
			$.post( 'classes/script_settings.php', {
				my_displayname: my_displayname,
				join_fname: join_fname,
				join_lname: join_lname,
				my_zipcode: my_zipcode,
				show_fullname: show_fullname,
				my_gender: my_gender,
				my_birth_month: my_birth_month,
				my_birth_day: my_birth_day,
				my_birth_year: my_birth_year,
				my_zipcode: my_zipcode,
				my_country: my_country,
				show_mylocation: show_mylocation,
				show_ethnicity: show_ethnicity,
				ethnicity_select: ethnicity_select,
				my_religion: my_religion,
				show_religion: show_religion,
				sexualorientation: sexualorientation,
				show_orientation: show_orientation,
				my_relstatus: my_relstatus,
				show_my_relstatus: show_my_relstatus
			}, function(data){
				//console.log('Data: '+data);

				
			});


			swal({
			  title: "Settings Updated",
			  text: "You settings have been saved!",
			  icon: "success",
			  button: "OK!",
			});
		
		});	
			



});