<?php session_start() ?>

<?php 
	//after updating the db, must overwrite the session variable. 
	$email = $_SESSION['email'];
	//check if email is posted in. if yes, change email.
	if (isset($_FILES['file']['name'])) {
		echo 'file received';
	}
 ?>