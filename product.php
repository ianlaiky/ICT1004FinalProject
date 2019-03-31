<?php session_start() ?>
<?php 
	$title = $price = $expiry = $condition = $trading_place = $description = $picture = "";
	//Hard to product id = 3;
	$productId = $_GET['product_id'];
	//Using get['product_id'], search db for the above info and echo out to html. 
	require_once('config.php');
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

    // $sql = "SELECT * FROM product where product_id = ?";
    $sql = mysqli_prepare($connection, "SELECT * FROM product where product_id = ?");
    $sql->bind_param('s', $_GET['product_id']);
	$sql->execute(); 
	$result = $sql->get_result();
    if ($result) {
    	$row = $result->fetch_assoc();
    	$title = $row['title'];
    	$price = $row['price'];
    	$condition = $row['condition'];
    	$trading_place = $row['trading_place'];
    	$description = $row['description'];
    	$picture = '"data:image/png;base64,'.base64_encode($row['picture']).'" width="520" height="400"';
    }
    else{
    	echo "Fail";
    }
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
    			<img style="border: 1px solid #ddd; border-radius: 4px; padding: 10px" src=<?php echo $picture ?>>
    		</div>
    		<div class="col-md-5">
    			<ul class="list-group">
					<h1><?php echo $title ?></h1>
					<br>
					<li class="list-group-item">Price: $<?php echo $price ?></li>
					<li class="list-group-item">Item listing expiring in: </li>
					<li class="list-group-item">Condition: <?php echo $condition ?></li>
					<li class="list-group-item">Trading place: <?php echo $trading_place ?></li>
				</ul>
				<button onclick="location.href='index.php';" style="position: absolute; right: 30; bottom:0; " type="button" class="btn btn-dark btn-lg">Chat to buy now!</button>
    		</div>
    	</div>
    </div>
    
    <div class="container">
    	<hr>
    	<h1>Product Description</h1>
    	<br>
    	<p><?php echo $description ?></p>
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