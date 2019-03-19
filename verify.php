<?php 
	if (isset($_GET['vkey'])) {
		$vkey = $_GET['vkey'];

		$connection = mysqli_connect('localhost', 'pswrite', 'password','fast_trade');
	    if (mysqli_connect_errno() ){
	        die( mysqli_connect_error() );
	    }

	    $query = "SELECT is_verified FROM users WHERE is_verified = 0 AND vkey = '$vkey' LIMIT 1";

	    if (mysqli_num_rows(mysqli_query($connection, $query)) == 1) {
	    	echo 'select statement success';
	    	$update_query = "UPDATE users SET is_verified = 1 WHERE vkey = '$vkey' LIMIT 1";
	    	if (mysqli_query($connection, $update_query)) {
	    		echo "update statement success";
	    	}
	    	else{
	    		echo "update statement failed";
	    	}
	    }
	    else{
	    	echo 'select statement failed.';
	    }
	}
 ?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Verification</title>
</head>
<body>
	
</body>
</html>