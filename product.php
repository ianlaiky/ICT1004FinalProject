<?php session_start() ?>
<?php 
	$productName = $price = $expiry = $condition = $venue = $productDesc = "";
	//Using get['product_id'], search db for the above info and echo out to html. 
 ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <?php include 'header.inc.php'; ?>
    <br>
    <br>
    <div class="container">
    	<div class="row">
    		<div class="col-md-7">
    			<img style="border: 1px solid #ddd; border-radius: 4px; padding: 10px" src="img/user.png">
    		</div>
    		<div class="col-md-5">
    			<ul class="list-group">
					<h1>Product Name</h1>
					<br>
					<li class="list-group-item">Price</li>
					<li class="list-group-item">Item listing expiring in: </li>
					<li class="list-group-item">Condition</li>
					<li class="list-group-item">Trading place</li>
				</ul>
    		</div>
    	</div>
    </div>
    
    <div class="container">
    	<hr>
    	<h1>Product Description</h1>
    	<br>
    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
    <br>
    <br>
    <br>
    <div></div>
    <?php include 'footer.inc.php' ?>
	<!-- Custom JavaScript -->
	<script src="vendor/form.js"></script>
	  <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>