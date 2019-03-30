<?php session_start() ?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Search result</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
</head>
<body>
	<?php include 'header.inc.php'; ?>
	<br>
	<div class="container">
        <h1>Searching products for <?php echo $_GET['search'] ?> : </h1>
        <br>
        <div class="row">
            <?php 
            	require_once('config.php');
				$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
				if (mysqli_connect_errno() ){
				    die( mysqli_connect_error() );
				}
			     
			    $searchString = $_GET['search'];
                $currDate = date('Y-m-d');
                $sql = "SELECT * FROM product WHERE product.expiry > '$currDate' AND product.is_active = 'yes' AND (product.title LIKE '%$searchString%' OR product.description LIKE '%$searchString%')";
                if ($result = mysqli_query($connection, $sql)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    	echo '<div class="col-md-3">';
                        echo '<a href="product.php?product_id='.$row['product_id'].'&user_id='.$row['userid'].'">';
                        echo '<div class="card">';
                        echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row['picture']).'">';
                        echo '<hr>';
                        echo '<div class="product-details">';
                        echo '<p class="text-muted">'.$row['type'].'</p>';
                        echo '<h3 class="text-center product-title">'.$row['title'].'</h3>';
                        echo '<h4 class="text-center product-price">S$'.$row['price'].'</h4>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';         
                    }
                  }
            ?>
        </div> 
	<?php include 'footer.inc.php'; ?>
	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>