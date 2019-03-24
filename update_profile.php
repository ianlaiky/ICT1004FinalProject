<?php session_start() ?>

<?php 
	//after updating the db, must overwrite the session variable. 
	$email = $_SESSION['email'];
	//check if email is posted in. if yes, change email.
	echo $_FILES['picture']['size'];
	echo "<br>";
	echo $_FILES['picture']['error'];
	echo "<br>";
	echo $_FILES['picture']['type'];
	echo "<br>";
	echo $_FILES['picture']['tmp_name']

	
 ?>