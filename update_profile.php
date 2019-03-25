<?php session_start() ?>

<?php 

	//after updating the db, must overwrite the session variable. 
	$email = $_SESSION['email']; 
	$contact = $gender = NULL;

	// if ($_POST['email'] != $email and isset($_POST['email'])) {
	// 	$email = $_POST['email'];
	// }

	if (isset($_POST['contact'] || isset($_POST['gender']))) {
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
	}

	
	echo $_FILES['picture']['size'];
	echo "<br>";
	echo $_FILES['picture']['error'];
	echo "<br>";
	echo $_FILES['picture']['type'];
	echo "<br>";
	echo $_FILES['picture']['tmp_name']

	
 ?>