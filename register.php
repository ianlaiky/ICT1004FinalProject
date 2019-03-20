<?php 


	$name = $email = "";
	$nameErr = $emailErr = $passwordErr = $confirmErr = "";

	require_once('config.php');
	
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

	if (isset($_POST['submit'])) {
		$name = mysqli_real_escape_string($connection, $_POST['name']);
    	$email = mysqli_real_escape_string($connection, $_POST['email']);
    	$password = mysqli_real_escape_string($connection, $_POST['password']);
    	$confirm = mysqli_real_escape_string($connection, $_POST['confirm']);

		if ($password != $confirm) {
			$confirmErr = "Password does not match.";
		}
		else{
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			//Check if user account exist before inserting. 

			if ($sel_stmt = mysqli_prepare($connection, "SELECT user_id, password FROM users WHERE email = ?")) {
				$sel_stmt->bind_param("s", $email);
				$sel_stmt->execute(); 
				$sel_stmt->store_result(); 

				if ($sel_stmt->num_rows > 0) {
					echo "account exist.";
				}
				else{
					echo "im here1";
					//account does not exist in database; continue to store.
					$vkey = md5(time().$name);
					if ($insert_stmt = mysqli_prepare($connection, "INSERT INTO users (name, password, email, vkey) VALUES (?,?,?,?)"))
					 {
					 	echo "im here2";
						$insert_stmt->bind_param('ssss', $name, $password, $email, $vkey);
						// $stmt->execute();
						if ($insert_stmt->execute()) {
							echo "im here3";
							$to = $email;
			        		$subject = "Email Verification";
			        		$message = "<a href='http://localhost/fasttrade/verify.php?vkey=$vkey'>Verify Now!</a>";
			        		$headers = "From: fast-trade@gmail.com \r\n";
			        		$headers .= "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	

							mail($to, $subject, $message, $headers);
							header('location: index.php');
						}
						else{
							echo "fail";
						}
					}

		    //     	$query = "INSERT INTO users(`name`, `password`, `email`, `vkey`) VALUES ('$name', '$password', '$email', '$vkey')";
		    //     	if (mysqli_query($connection, $query)) {
		    //     		$to = $email;
		    //     		$subject = "Email Verification";
		    //     		$message = "<a href='http://localhost/fasttrade/verify.php?vkey=$vkey'>Verify Now!</a>";
		    //     		$headers = "From: fast-trade@gmail.com \r\n";
		    //     		$headers .= "MIME-Version: 1.0" . "\r\n";
						// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	

						// mail($to, $subject, $message, $headers);
						// header('location: index.php');

		    //     	}else{
		    //     		echo "fail";
		    //     	}
				}
			}
		}
	}
	mysqli_close($connection);
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Register</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
</head>
<body>
	<?php include 'header.inc.php'; ?>
	
	<div class="container">
		<h1>Register Accounts</h1>
		<p>If you already have an account with us, please login in the login page.</p>

		<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group">
				<label class="control-label col-sm-2" for="name">Name:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="name" value="<?php echo $name;?>">
					<span class="error"><?php echo $nameErr;?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="email">Email:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" name="email" value="<?php echo $email;?>">
					<span class="error"><?php echo $emailErr;?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="password">Password:</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password">
					<span class="error"><?php echo $passwordErr;?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="confirm">Password Confirm:</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" name="confirm" >
					<span class="error"><?php echo $confirmErr;?></span>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" name="submit" class="btn btn-info">Submit</button>
				</div>
			</div>
	</form>
	</div>

	<?php include 'footer.inc.php' ?>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>