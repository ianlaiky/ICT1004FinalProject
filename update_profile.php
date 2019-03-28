<?php session_start() ?>

<?php 
	
	require_once('config.php');
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
	if (mysqli_connect_errno() ){
	    die( mysqli_connect_error() );
	}

	$imageData = file_get_contents($_FILES['picture']['tmp_name']);

	//email field cannot be empty. so check whether if it's empty. if empty email value submitted, should use the session email variable instead. 
	$email = (!empty($_POST['email']) ? mysqli_real_escape_string($connection, $_POST['email']) : $_SESSION['email']);
	//allows contact to be empty; user may choose to remove contact information from their profile in the future. 
	$contact = (isset($_POST['contact']) ? mysqli_real_escape_string($connection, $_POST['contact']) : $_SESSION['contact'] );
	$gender = (isset($_POST['gender']) ? mysqli_real_escape_string($connection, $_POST['gender']) : $_SESSION['gender']);

	$null = NULL;

	$stmt = $connection->prepare("UPDATE users SET `email` = ?, `contact` = ?, `gender` = ?, `profile_picture` = ? WHERE `user_id` = ?");
	$stmt->bind_param('sssbs', $email, $contact, $gender, $null, $_SESSION['user_id']);
	$stmt->send_long_data(3, $imageData);
	if ($stmt->execute()) {
		//change session variable value.  
		$_SESSION['contact'] = $contact;
		$_SESSION['gender'] = $gender;
		$_SESSION['email'] = $email;
		// Read image path, convert to base64 encoding
		$encodedImage = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
		// Format the image SRC:  data:{mime};base64,{data};
		$src = 'data: '.mime_content_type($_FILES['picture']['tmp_name']).';base64,'.$encodedImage;
		$_SESSION['profile_picture'] = '"' . $src . '"';
		header("Location: profile.php");
		// echo '<img src='$_SESSION['profile_picture']'>';
	}
 ?>