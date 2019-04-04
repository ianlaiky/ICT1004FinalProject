<?php 
	
         
session_start();
	$username = $password =$wrong= "";
	require_once('config.php');
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
	if (mysqli_connect_errno() ){
	    die( mysqli_connect_error() );
	}

	if (isset($_POST['submit'])) {
	    $username = mysqli_real_escape_string($connection, $_POST['username']);
	    $password = mysqli_real_escape_string($connection, $_POST['password']);

	    if ($findAccount = mysqli_prepare($connection, "SELECT * FROM users WHERE username =?")) {
	    	$findAccount->bind_param('s', $username);
			$findAccount->execute(); 
			$result = $findAccount->get_result();

			if ($result->num_rows != 0) {
				$row = $result->fetch_assoc();
				$hash = $row['password'];
				$verified = $row['is_verified'];

				if (password_verify($password, $hash) and $verified == 1) {
					$_SESSION['username'] = $username;
					$_SESSION['name'] = $row['name'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['gender'] = $row['gender'];
					$_SESSION['contact'] = ($row['contact'] == 0 ? "" : $row['contact']);
					$_SESSION['user_id'] = $row['user_id'];
					if (!empty($row['profile_picture'])) {
						$_SESSION['profile_picture'] = '"data:image/png;base64,'.base64_encode($row['profile_picture']).'" width="150" height="150"';
					}
					else{
						$_SESSION['profile_picture'] = "img/user.png";
					}					
					echo "<script type='text/javascript'>". "alert('You have logged in. Redirecting you back to homepage now.');"." window.location='index.php';</script>";
				}
				else{
                    $wrong = "Incorrect username/password.";
				}
			}
			else{
                $wrong = "Incorrect username/password.";
			}
	    }
	    else{
	    	echo "select statement dont work";
	    }
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .help-block{
            color:red;
        }
    </style>
</head>
<body>
	<?php include 'header.inc.php'; ?>
	<br><br>
	<div class="container">
		<h1>Login to start shopping!</h1>

		<br><hr><br>
		<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group row">
				<label class="col-form-label col-sm-2" for="username">Username:</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control" name="username">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-2" for="pwd">Password:</label>
				<div class="col-sm-5"> 
				  <input type="password" class="form-control" name="password">
				</div>
			</div>
			<div class="form-group row"> 
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" name="submit" class="btn btn-info">Login</button>
				</div>
			</div>
			<small style="margin-bottom:0px" class="help-block"><?php echo $wrong ?></small>

		</form>
		<p>Don't have an account?<a href="register.php"> Sign up now! </a></p>	
	</div>
	<?php include 'footer.inc.php' ?>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>