<?php session_start() ?>
<?php 

	$title = $price = $expiry = $condition = $trading_place = $description = $picture = "";
	//Using get['product_id'], search db for the above info and echo out to html. 
	require_once('config.php');
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

    $sql = mysqli_prepare($connection, "SELECT p.*, u.name FROM product p INNER JOIN users u ON p.userid = u.user_id WHERE p.product_id = ? AND u.user_id = ?");
    $sql->bind_param('ss', $_GET['product_id'], $_GET['user_id']);
	$sql->execute(); 
	$result = $sql->get_result();
    if ($result) {

    	$row = $result->fetch_assoc();
        $productId = $row['product_id'];
        $name = $row['name'];
    	$title = $row['title'];
    	$price = $row['price'];
        $age = $row['age'];
    	$condition = $row['condition'];
    	$trading_place = $row['trading_place'];
    	$description = $row['description'];
        $expiryCountdown = $row['expiry'] . " 00:00:00";
    	$picture = '"data:image/png;base64,'.base64_encode($row['picture']).'" width="520" height="400"';
        $relevantItems = $row['type'];
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
    <title>Product of <?php echo $title ?></title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include 'header.inc.php'; ?>
    <br>
    <br>
    <div class="container">
    	<div class="row">
    		<div class="col-md-7">
    			<img style="height:400px;" class="img-thumbnail" src=<?php echo $picture ?>>

                
    		</div>
    		<div class="col-md-5">
                <h1 class="display-3"><?php echo $title ?></h1>
                <br>
                <p class="font-weight-lighter"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $name ?></p>
                <p class="font-weight-lighter"><i class="fa fa-clock-o" aria-hidden="true"></i> <span id="expiry-countdown"></span> </p>
                <p class="product-price">S$<?php echo $price ?></p>
                <hr>
                <p class="font-weight-lighter">Age of item: <?php echo $age ?></p>
                <p class="font-weight-lighter">Condition: <?php echo $condition ?></p>
                <p class="font-weight-lighter">Meet up: <?php echo $trading_place ?></p>
                <br><br>
                <?php if (isset($_SESSION['user_id'])) 
                {
                    echo '<a href="messageInbox.php?pid='.$productId.'&redirect=true&custid=0" style="position: absolute;  bottom:0; " type="button" class="btn btn-dark btn-lg">Chat to buy now!</a>';
                } else{
                    echo '<a href="login.php" style="position: absolute;  bottom:0;" type="button" class="btn btn-dark btn-lg">Interested? Login to buy now.</a>';
                }

                ?>			
    		</div>
    	</div>
    </div>
    
    <div class="container">
    	<hr>
    	<h1 class="display-4">Product Description</h1>
    	<br>
    	<p><?php echo $description ?></p>
        <hr>
    </div>

    <div class="container">
        <h1>You may also like...</h1>
        <br>
        <div class="row">
            <?php 
                $currDate = date('Y-m-d');
                $sql = "SELECT * FROM product WHERE product.expiry > '$currDate' AND product.is_active = 'yes' AND product.type='$relevantItems' AND product.title != '$title'";
                if ($result = mysqli_query($connection, $sql)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['type'] == $relevantItems) {
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
                  }
            ?>
        </div> 
        
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
<script>  
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $expiryCountdown;?>").getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();      
        // Find the distance between now and the count down date
        var distance = countDownDate - now;     
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        // Output the result in an element with id="demo"
        document.getElementById("expiry-countdown").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";    
    }, 1000);
</script>
</html>