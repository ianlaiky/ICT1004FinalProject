<?php session_start();
//Users that are not registered should not be able to access this page.
  if(!isset($_SESSION['user_id']))
  {
    ob_start();
    header('Location: errorpage.php');
    ob_end_flush();
    die();
  }
?>
<?php 
  $type = $title = $description = $picture = $condition = $age = $price = $trading_place = $userid = $active = $expiry = "";
  $titleBool = $descriptionBool = $priceBool = $trading_placeBool = $expiryBool = "";
  $titleErr = $descriptionErr = $priceErr = $trading_placeErr = $expiryErr = "";
  $currDate = date('Y-m-d');
  $nextDate = date('Y-m-d', strtotime($currDate . ' +1 day'));
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }

    if(empty(test_input($_POST['title'])))
    {
      $titleErr = "Title is compulsory!";
    }
    else{
      $titleBool = true;
      $title = mysqli_real_escape_string($connection, $_POST['title']);
    }
    if(empty(test_input($_POST['description']))){
      $descriptionErr = "Please do describe your item!";
    }
    else{
      $descriptionBool = true;
      $description = mysqli_real_escape_string($connection, $_POST['description']);
    }
    if(empty(test_input($_POST['price']))){
      $priceErr = "A price is needed! Negotiations can come later.";
    }
    else{
      $priceBool = true;
      $price = mysqli_real_escape_string($connection, $_POST['price']);
    }
    if(empty(test_input($_POST['trading_place']))){
      $trading_placeErr = "Trading place is necessary! It increases the chances of having a buyer :)";
    }
    else{
      $trading_placeBool = true;
      $trading_place = mysqli_real_escape_string($connection, $_POST['trading_place']);
    }
    if(strtotime($_POST['expiry']) == strtotime('0000-00-00'))
    {
      $expiry = date('Y-m-d', strtotime($currDate . ' +5 day'));
      echo $expiry;
    }
    else
    {
      $expiryBool = true;
      $expiry = mysqli_real_escape_string($connection, $_POST['expiry']);
    }
    //For optional fields
    if(filesize($_FILES['picture']['tmp_name']) == 0)
    {
      $bin_data = file_get_contents('img/placeholder.jpg');
    }
    else
    {
      //Get the directory of the temp uploaded file/image
      $currfile = $_FILES['picture']['tmp_name'];
      //Get the binary contents of the temp file
      $bin_data = file_get_contents($currfile);
    }
    if(!isset($_POST['age'])){
      $age = NULL;
    }
    else{
      $age = mysqli_real_escape_string($connection, $_POST['age']);
    }
      
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $condition = mysqli_real_escape_string($connection, $_POST['condition']);
    $userid = mysqli_real_escape_string($connection, $_SESSION['user_id']);
    $active =  mysqli_real_escape_string($connection, "yes");
    if($titleBool == true && $descriptionBool == true && $priceBool == true && $trading_placeBool == true)
    {

      if($insert_stmt = mysqli_prepare($connection, "INSERT INTO product (`title`, `description`, `picture`, `condition`, `age`, `price`, `trading_place`, `type`, `userid`, `is_active`, `expiry`) VALUES (?,?,?,?,?,?,?,?,?,?,?)"))
      {
        $insert_stmt->bind_param('ssbsssssiss', $title, $description, $null, $condition, $age, $price, $trading_place, $type, $userid, $active, $expiry);
        $insert_stmt->send_long_data(2, $bin_data);
        $insert_stmt->execute();
        ob_start();
        header('Location: index.php');
        ob_end_flush();
       die();
      }
      else
      {
        echo 'fail';
      }
    }
    
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>FastTrade</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <header>
    <?php include 'header.inc.php'; 
    
    ?>
    </header>
    <article>
        <div class="container">
          <br>
          <h1>List an item for sale</h1>
          <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group row">
              <label for="type" class="col-sm-2 col-form-label">Type</label>
              <div class="col-sm-10">
                <select class="form-control" name="type" placeholder="Select your item type.">
                <?php 
                      $sql = "SELECT * FROM category ORDER BY category.cat_id ASC";
                      if ($result = mysqli_query($connection, $sql)){
                          while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row['type'].'">'.$row['type'].'</option>';
                          }
                      }
                 ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="title" placeholder="Please enter a title.">
                <span class="error"> <?php echo $titleErr;?></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="description" placeholder="Please describe your item.">
                <span class="error"> <?php echo $descriptionErr;?></span>
              </div>
            </div>
            <div class="form-group row">                
                <label for="picture" class="col-sm-2">Picture</label>
                <input type="file" class="col-sm-10 form-control-file" name="picture" id="picture" value="">
            </div>
            <div class="form-group row">
              <label for="condition" class="col-sm-2 col-form-label">Condition</label>
              <div class="col-sm-10">
                <select class="form-control" name="condition" placeholder="Item's condition">
                <?php
                  $num = 1;
                  while($num < 11)
                  {
                    echo'<option value="'.$num.'">'.$num.'</option>';
                    ++$num;
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="age" class="col-sm-2 col-form-label">Age</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="age" placeholder="Please indicate the age of your item.">
              </div>
            </div>
            <div class="form-group row">
              <label for="price" class="col-sm-2 col-form-label">Price</label>
              <div class="col-sm-10">
                <input type="number" step="0.01" class="form-control" name="price" placeholder="e.g. 12.00">
                <span class="error"> <?php echo $priceErr;?></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="trading_place" class="col-sm-2 col-form-label">Trading place</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="trading_place" placeholder="Where would you like to trade?">
                <span class="error"> <?php echo $trading_placeErr;?></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="expiry" class="col-sm-2 col-form-label">Expiry date</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" name="expiry" min="<?php echo $nextDate?>">
                <small class="form-text text-muted">You may wish to list the length of your item listing. By default, it will be 5 days.</small>
              </div>
            </div>
            <div class="form-group row">
              <button type="submit" class="btn btn-primary" value="Send File">Submit</button>
            </div>
          </form>
        </div>
    </article>
  <?php include 'footer.inc.php' ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
