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
  $title = $price = $expiry = $condition = $trading_place = $description = $picture = $type = "";
  $update_stmt = "";
  $pID = $_GET['productid'];
  $currDate = date('Y-m-d');
  $nextDate = date('Y-m-d', strtotime($currDate . ' +1 day'));
	//Using get['product_id'], search db for the above info and echo out to html. 
	require_once('config.php');
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

    // $sql = "SELECT * FROM product where product_id = ?";
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
      $sql = mysqli_prepare($connection, "SELECT * FROM product where product_id = ?");
      $sql->bind_param('s', $_GET['productid']);
      $sql->execute(); 
      $result = $sql->get_result();
      if ($result) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $type = $row['type'];
        $price = $row['price'];
        $condition = $row['condition'];
        $age = $row['age'];
        $trading_place = $row['trading_place'];
        $description = $row['description'];
        $expiry = $row['expiry'];
        $picture = '"data:image/png;base64,'.base64_encode($row['picture']).'" width="520" height="400"';
        $userid = $row['userid'];
        $active = $row['is_active'];
        if($_SESSION['user_id'] != $userid)
        {
             ob_start();
             header('Location: user_items.php');
             ob_end_flush();
             die();
        }
      }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $product_ID = mysqli_real_escape_string($connection,$_POST['productid']);
      $newtitle = mysqli_real_escape_string($connection,$_POST['title']);
      $newage = mysqli_real_escape_string($connection,$_POST['age']);
      $newprice = mysqli_real_escape_string($connection,$_POST['price']);
      $newcondition = mysqli_real_escape_string($connection,$_POST['condition']);
      $newtrading_place = mysqli_real_escape_string($connection,$_POST['trading_place']);
      $newdescription = mysqli_real_escape_string($connection,$_POST['description']);
      $newexpiry = mysqli_real_escape_string($connection,$_POST['expiry']);
      $newactive = mysqli_real_escape_string($connection,$_POST['isactive']);
      $newtype = mysqli_real_escape_string($connection,$_POST['type']);
      $sql = "";
      $picture = 0;
      //For photo
      if(filesize($_FILES['picture']['tmp_name']) == 0)
      {
        $sql = "UPDATE product SET `title` = ?, `age` = ?,`price` = ?,`condition` = ?,`trading_place` = ?,`description` = ?,`expiry` = ?, `is_active` = ?, `type` = ? WHERE product.product_id = '".$product_ID."' AND product.userid = '".$_SESSION['user_id']."'";
        $picture = 1;
      }
      else
      {
        //Get the directory of the temp uploaded file/image
        $currfile = $_FILES['picture']['tmp_name'];
        //Get the binary contents of the temp file
        $bin_data = file_get_contents($currfile);
        $sql = "UPDATE product SET `title` = ?, `age` = ?,`price` = ?,`condition` = ?,`trading_place` = ?,`description` = ?,`expiry` = ?, `picture` = ?, `is_active` = ?, `type` = ? WHERE product.product_id = '".$product_ID."' AND product.userid = '".$_SESSION['user_id']."'";
      }
      if($update_stmt = mysqli_prepare($connection, $sql))
      {
        if($picture == 0)
        {
          $update_stmt->bind_param('sssssssbss', $newtitle, $newage, $newprice, $newcondition, $newtrading_place, $newdescription, $newexpiry, $null, $newactive, $newtype);
          $update_stmt->send_long_data(7, $bin_data);
          $update_stmt->execute();
        }
        else
        {
          $update_stmt->bind_param('sssssssss', $newtitle, $newage, $newprice, $newcondition, $newtrading_place, $newdescription, $newexpiry, $newactive, $newtype);
          $update_stmt->execute();
        }
          ob_start();
          header('Location: user_items.php');
          ob_end_flush();
          die();
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
    <title>Edit product</title>
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
      <input type="hidden" name="productid" value="<?php echo $pID ?>">
      <div class="container">
      <h1>Editting your item: <?php echo $title ?></h1>
        <div class="row">
          <div class="col-md-7">
            <div class="file-field hoverEffect">
                <!-- Need to change src to $_SESSION['picture'] after inserting -->
              <img onClick="popupFileExplorer()" id="preview" class="image" style="border: 1px solid #ddd; border-radius: 4px; padding: 10px" src=<?php echo $picture ?>>
              <div class="middle">
							  <i class="fa fa-camera fa-lg" aria-hidden="true"></i>
						  </div>
              <input type="file" accept="image/*" name="picture" onChange="changePreview(this)" id="picture" class="form-control" value="" style="display: none;">
            </div>
            <!-- <img style="border: 1px solid #ddd; border-radius: 4px; padding: 10px" src=<?php echo $picture ?>> -->
          </div>
          <div class="col-md-5">
            <ul class="list-group">
            <li class="list-group-item form-group">Title:
              <input type="text" name="title" value="<?php echo $title ?>">
            </li>
            <li class="list-group-item form-group">Type:
              <select name="type">
              <?php 
                      $sql = "SELECT * FROM category ORDER BY category.cat_id ASC";
                      if ($result = mysqli_query($connection, $sql)){
                          while($row = mysqli_fetch_assoc($result)) {
                            if($type == $row['type'])
                            {
                              echo '<option value="'.$row['type'].'" selected>'.$row['type'].'</option>';
                            }
                            else
                            {
                              echo '<option value="'.$row['type'].'">'.$row['type'].'</option>';
                            }
                          }
                      }
                 ?>
              </select>
            </li>
            <li class="list-group-item form-group">Price: $
              <input type="number" name="price" value="<?php echo $price ?>">
            </li>
            <li class="list-group-item">Item listing expiring in: 
              <input type="date" name="expiry" value="<?php echo $expiry ?>"  min="<?php echo $nextDate?>">
            </li>
            <li class="list-group-item">Age of item: 
              <input type="text" name="age" value="<?php echo $age ?>">
            </li>
            <li class="list-group-item">Condition: 
              <select name="condition">
                  <?php
                    $num = 1;
                    while($num < 11)
                    {
                      if($num == $condition)
                      {
                        echo'<option value="'.$num.'" selected>'.$num.'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$num.'">'.$num.'</option>';
                      }
                      ++$num;
                    }
                  ?>
              </select>
            </li>
            <li class="list-group-item">Trading place:
              <input type="text" name="trading_place" value="<?php echo $trading_place ?>">
            </li>
            <li class="list-group-item">Listed?
              <select name="isactive">
                    <?php
                      if($active == "yes")
                      {
                        echo '<option value="yes" selected>Yes</option>';
                        echo '<option value="no">No</option>';
                      }
                      else
                      {
                        echo '<option value="yes">Yes</option>';
                        echo '<option value="no" selected>No</option>';
                      }
                    ?>
              </select>
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
    <!-- Custom JavaScript -->
	<script src="vendor/form.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>