<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Error!</title>
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
</head>
<body>
	<header>
	</header>
	<?php include 'header.inc.php'; ?>
	<div class="container h-100">
    	<div class="row h-100 justify-content-center align-items-center">
			<div class="col-md-12">
				<div class="text-center">
					<h1>Oops!</h1>
					<p>Sorry, an error has occured! Don't worry, we have dispatched our engineers to look at the issue!</p>
					<br/>
					<br/>	
					<button class="btn btn-primary btn-lg" onclick="goBack()"/><span class="glyphicon glyphicon-home"></span>
						Click here to go back </a>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.inc.php' ?>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script>
		function goBack() {
  			window.history.back();
		}
	</script>
</body>
</html>