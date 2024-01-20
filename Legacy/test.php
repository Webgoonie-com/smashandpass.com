<?php


include("classes/db_connect.php");


$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";






/// Check if button name "Submit" is active, do this 
if(isset($_POST['user_id'])){

	for($i=0;$i<$count;$i++){
		
		$sql1="UPDATE $tbl_name SET name='$name[$i]', lastname='$lastname[$i]', email='$email[$i]' WHERE id='$id[$i]'";
		
		$result1=mysql_query($sql1);
	}

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test</title>
</head>
<body>
<p> <a href="assets/sweetalert/sweetalert.min.js">sweetalert.min.js</a> </p>
<p> <a href="https://unpkg.com/sweetalert/dist/sweetalert.min.js">sweetalert.min.js</a> </p>




<div>

</div>




<p>
  <button id="seeme" class="btn" onClick="run_swap_deom()" type="button">Click Swap</button>
</p>
<script src="assets/sweetalert/sweetalert.min.js"></script> 
<script>

//swal("Here's the title!", "...and here's the text!");




function run_swap_deom(){



					swal("A wild Pikachu appeared! What do you want to do?", {
				  buttons: {
					cancel: "Run away!",
					catch: {
					  text: "Throw Pokéball!",
					  value: "catch",
					},
					defeat: true,
				  },
				})
				.then(function(value){
				  switch (value) {
				 
					case "defeat":
					  swal("Pikachu fainted! You gained 500 XP!");
					  break;
				 
					case "catch":
					  swal("Gotcha!", "Pikachu was caught!", "success");
					  break;
				 
					default:
					  swal("Got away safely!");
				  }
				});

}
	

</script>
</body>
</html>