<?php session_start();
//Users that are not registered should not be able to access this page.
  if(!isset($_SESSION['user_id']))
  {
    ob_start();
    header('Location: login.php');
    ob_end_flush();
    die();
  }
?>
<?php 
  $title = $price = $expiry = $condition = $trading_place = $description = $picture = "";
  $newprice = $newexpiry = $newcondition = $newtrading_place = $newdescription = "";
  $update_stmt = "";
	$pID = $_GET['product_id'];
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
      $expiry = $row['expiry'];
    	$picture = '"data:image/png;base64,'.base64_encode($row['picture']).'" width="520" height="400"';
    }
    else{
    	echo "Fail";
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      echo $_GET['product_id'];
      $newprice = mysqli_real_escape_string($connection,$_POST['price']);
      $newcondition = mysqli_real_escape_string($connection,$_POST['condition']);
      $newtrading_place = mysqli_real_escape_string($connection,$_POST['trading_place']);
      $newdescription = mysqli_real_escape_string($connection,$_POST['description']);
      $newexpiry = mysqli_real_escape_string($connection,$_POST['expiry']);
      if($update_stmt = mysqli_prepare($connection, "UPDATE product SET `price` = ?,`condition` = ?,`trading_place` = ?,`description` = ?,`expiry` = ? WHERE product.product_id = '3' AND product.userid = '15'"))
      {
         $update_stmt->bind_param('sssss', $newprice, $newcondition, $newtrading_place, $newdescription, $newexpiry);
         $update_stmt->execute();
        // ob_start();
        // header('Location: user_items.php');
        // ob_end_flush();
        // die();
      }
      else
      {
        echo 'fail';
      }
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
    <header>
    <?php include 'header.inc.php';?>
    </header>
    <br>
    <br>
    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <img style="border: 1px solid #ddd; border-radius: 4px; padding: 10px" src=<?php echo $picture ?>>
          </div>
          <div class="col-md-5">
            <ul class="list-group">
            <h1></h1>
            <br>
            <li class="list-group-item form-group">Price: $
              <input type="number" name="price" value="<?php echo $price ?>">
            </li>
            <li class="list-group-item">Item listing expiring in: 
              <input type="date" name="expiry" value="<?php echo $expiry ?>">
            </li>
            <li class="list-group-item">Condition: 
              <input type="text" name="condition" value="<?php echo $condition ?>">
            </li>
            <li class="list-group-item">Trading place:
              <input type="text" name="trading_place" value="<?php echo $trading_place ?>">
            </li>
          </ul>
          </div>
        </div>
      </div>
      <div class="container">
        <hr>
        <h1>Product Description</h1>
        <br>
        <p><textarea class="form-control" rows="3" name="description"><?php echo $description ?></textarea></p>
        <button type="submit" class="btn btn-primary" value="Send File">Submit</button>
      </div>
      <br>
      <br>
      <br>
    </form>
    <footer>
        <?php include 'footer.inc.php' ?>
    </footer>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>