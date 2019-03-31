<?php session_start() ?>
<?php 

	$name = $email = $username = "";

	require_once('config.php');
	
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

	if (isset($_POST['submit'])) {
		$name = mysqli_real_escape_string($connection, $_POST['name']);
		$username = mysqli_real_escape_string($connection, $_POST['username']);
    	$email = mysqli_real_escape_string($connection, $_POST['email']);
    	$password = mysqli_real_escape_string($connection, $_POST['password']);
    	$confirm = mysqli_real_escape_string($connection, $_POST['confirm']);

		if ($password != $confirm) {
			$confirmErr = "Password does not match.";
		}
		else{
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			//Check if user account exist before inserting. 

			if ($sel_stmt = mysqli_prepare($connection, "SELECT user_id, password FROM users WHERE username = ?")) {
				$sel_stmt->bind_param("s", $username);
				$sel_stmt->execute(); 
				$sel_stmt->store_result(); 

				if ($sel_stmt->num_rows > 0) {
					echo "Username taken.";
				}
				else{
					//account does not exist in database; continue to store.
					$vkey = md5(time().$name);
					if ($insert_stmt = mysqli_prepare($connection, "INSERT INTO users (name, username, password, email, vkey) VALUES (?,?,?,?,?)"))
					 {
						$insert_stmt->bind_param('sssss', $name, $username, $password, $email, $vkey);
						// $stmt->execute();
						if ($insert_stmt->execute()) {
							$to = $email;

			        		$subject = "Email Verification";
			        		$message = "<a href=\"http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/verify.php?vkey=$vkey\">Verify Now!</a>";
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
        <style>
            .col-form-label{
                padding-right: 0;
            }
            small{
                color: red;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <?php include 'header.inc.php'; ?>
        <div class="container">
            <br><br>
            <h1>Register Account</h1>
            <br><hr>

            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">Name:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $nameER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">Username:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $usernameER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="email">Email:</label>
                    <div class="col-sm-5">
                        <input aria-describedby="emailVerify" type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        <small style="margin-bottom:0px" id="emailVerify" class="form-text text-muted">Please enter a valid email. A verification email will be sent to this address.</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="password">Password:</label>
                    <div class="col-sm-5">
                        <input aria-describedby="passwordVerify" type="password" class="form-control" name="password">
                        <small style="margin-bottom:0px" id="passwordVerify" class="form-text text-muted">Password must be alphanumeric and be at least 8 characters long</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="confirm">Confirm password:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="confirm">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $confirmER ?></small>
                    </div>
                </div>
                <div class="form-group row"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
            <p>Already have an account?<a href="login.php"> Sign in </a></p>
        </div>

<?php include 'footer.inc.php' ?>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>