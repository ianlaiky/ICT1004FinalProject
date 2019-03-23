<?php session_start() ?>
<?php 
	if (isset($_SESSION['test'])) {
		$test = $_SESSION['test'];
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>My profile</title>
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
</head>
<body>
	<?php include 'header.inc.php'; ?>
	<br><br>
	<div class="container">
		<h1>Hello <?php echo $_SESSION['name'].'!' ?></h1>
		<br>
		<form class="form-horizontal" method="post" action="update_profile.php"> 
			<div class="form-group row">
				<label for="username" class="col-sm-2 col-form-label">Profile picture</label>
		    	<div class="col-sm-8">
		      		<div class="file-field">
						<div class="z-depth-1-half mb-4">
							<!-- Need to change src to $_SESSION['picture'] after inserting-->
							<img style="height:200px" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" class="img-fluid">
						</div>
						<div class="d-flex">
							<div style="padding:0px" class="btn btn-mdb-color btn-rounded float-left">
								<input type="file" name="picture">
							</div>
						</div>
					</div>
		    	</div>
			</div>
		  	<div class="form-group row">
		   		<label for="username" class="col-sm-2 col-form-label">Username</label>
		    	<div class="col-sm-8">
		      		<input type="text" readonly class="form-control" value=<?php echo $_SESSION['username']?>>
		    	</div>
		  	</div>
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-8">
				  	<input type="text" readonly class="form-control" name="email" value=<?php echo $_SESSION['email']?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="gender" class="col-sm-2 col-form-label ">Gender</label>
					<div class="col-sm-8 ">
						<div style="margin-top:0.5em" class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="radio1" name= "gender" class="custom-control-input" value="male">
						  <label class="custom-control-label" name="gender" for="radio1">Male</label>
						</div>
						<div style="margin-top:0.5em" class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="radio2" name= "gender" class="custom-control-input" value="female">
						  <label class="custom-control-label" name="gender" for="radio2">Female</label>
						</div>
					</div>
				</label>
			</div>
			<div class="form-group row">
				<label for="contact" class="col-sm-2 col-form-label">Contact</label>
				<div class="col-sm-8">
				  	<input type="text" class="form-control" name="contact" value=<?php echo $_SESSION['contact']?>>
				</div>
			</div>
			<br>
			<hr>
			<br>

			<h1>Update password</h1>
			<br>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="password">New Password:</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" name="password">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="confirm">Confirm password:</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" name="confirm">
				</div>
			</div>
			<br>
			<div class="form-group row"> 
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" name="update" class="btn btn-info float-right">Update profile</button>
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