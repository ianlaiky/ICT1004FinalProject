<?php 
	$email = $password = "";
	if (isset($_POST['submit'])) {
		$connection = mysqli_connect('localhost', 'pswrite', 'password','fast_trade');
	    if (mysqli_connect_errno() ){
	        die( mysqli_connect_error() );
	    }

	    $email = mysqli_real_escape_string($connection, $_POST['email']);
	    $password = mysqli_real_escape_string($connection, $_POST['password']);

	    if ($findAccount = mysqli_prepare($connection, "SELECT * FROM users WHERE email =?")) {
	    	echo "select statement works";
	    	$findAccount->bind_param('s', $email);
			$findAccount->execute(); 
			$result = $findAccount->get_result();
//
			if ($result->num_rows != 0) {
				echo "account exist";
				$row = $result->fetch_assoc();
				$hash = $row['password'];
				$verified = $row['is_verified'];

				if (password_verify($password, $hash) and $verified == 1) {
					echo "You are logged in";
				}
				else{
					echo "no";
				}
			}
			else{
				echo "no";
			}
	    }
	    else{
	    	echo "select statement dont work";
	    }

	    // $findAccount = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1"; 
	    // //Check if account exist. 
	    // if (mysqli_num_rows($result = mysqli_query($connection, $findAccount)) !=0) {
	    // 	$row = mysqli_fetch_assoc($result);
	    // 	$verified = $row['is_verified'];

	    // 	if ($verified == 1) {
	    // 		echo "You are logged in.";
	    // 	}
	    // 	else{
	    // 		echo "Something went wrong.";
	    // 	}
	    // }
	    // else{
	    // 	echo "Invalid username/password";
	    // }
	}
 ?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Login</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
</head>
<body>
	<?php include 'header.inc.php'; ?>

	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Email:</label>
		<div class="col-sm-10">
		  <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">Password:</label>
		<div class="col-sm-10"> 
		  <input type="password" class="form-control" name="password">
		</div>
	</div>
	<div class="form-group"> 
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" name="submit" class="btn btn-info">Login</button>
		</div>
	</div>
	</form>
	<?php include 'footer.inc.php' ?>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>