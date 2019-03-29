<?php session_start() ?>
<?php 
	// $dp = "img/user.png";
	// if (!empty($_SESSION['profile_picture'])) {
	// 	$dp = $_SESSION['profile_picture'];
	// }
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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
	<?php include 'header.inc.php'; ?>
	<br><br>
	<div class="container">
		<h1>Hello, <?php echo $_SESSION['name'].'!' ?></h1>
		<br>
		<form enctype="multipart/form-data" class="form-horizontal" method="post" action="update_profile.php"> 
			<div class="form-group row">
				<label for="picture" class="col-sm-2 col-form-label">Profile Image</label>
		    	<div class="col-sm-8">
		      		<div class="file-field hoverEffect">
						<!-- <div class="z-depth-1-half mb-4"> -->
							 <!-- Need to change src to $_SESSION['picture'] after inserting -->
						<img onClick="popupFileExplorer()" id="preview" class="img-fluid image" src=<?php echo $_SESSION['profile_picture']; ?>>
						<div class="middle">
							<i class="fa fa-camera fa-lg" aria-hidden="true"></i>
						</div>
						<!-- <img src="img/user.png" onclick="popupFileExplorer()" id="preview" style="height:100px" > -->
						<!-- </div> -->
						<!-- <div class="d-flex"> -->
							<!-- <div style="padding:0px" class="btn btn-mdb-color btn-rounded float-left"> -->
						<input type="file" accept="image/*" name="picture" onChange="changePreview(this)" id="picture" class="form-control" value="" style="display: none;">
							<!-- </div> -->
						<!-- </div> -->
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
				  	<input type="text" class="form-control" name="email" value=<?php echo $_SESSION['email']?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="gender" class="col-sm-2 col-form-label ">Gender</label>
					<div class="col-sm-8 ">
						<?php 
							//Checks if the user already select a gender. If yes, user shouldn't need to select gender anymore so therefore, display a readonly field for gender. 
							if (isset($_SESSION['gender'])) {
								echo '<input type="text" readonly class="form-control" value='.$_SESSION['gender'].'>';
							}
							else{
								echo '<div style="margin-top:0.5em" class="custom-control custom-radio custom-control-inline">';
								echo '<input type="radio" id="radio1" name= "gender" class="custom-control-input" value="Male">';
								echo '<label class="custom-control-label" name="gender" for="radio1">Male</label>';
								echo '</div>';
								echo '<div style="margin-top:0.5em" class="custom-control custom-radio custom-control-inline">';
								echo '<input type="radio" id="radio2" name= "gender" class="custom-control-input" value="Female">';
								echo '<label class="custom-control-label" name="gender" for="radio2">Female</label>';
								echo '</div>';
							}	
							
						 ?>
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
				<button type="submit" class="btn btn-info float-right" name="update">Update profile</button>
				</div>
			</div>
			<br>
			<br>

		</form>
	</div>
	<?php include 'footer.inc.php' ?>
	<!-- Custom JavaScript -->
	<script src="vendor/form.js"></script>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>