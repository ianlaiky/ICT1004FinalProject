<!DOCTYPE html>
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

</head>


  <header>
    <?php include 'header.inc.php';
    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }
    ?>
  </header>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <!--<button onclick="filteritems('here')">test filter button</button>-->
            </div>
            <div class="col-md-10">
            <br/>
                <h1>Your items:</h1>
                <?php
                    $user = $_SESSION['user_id'];
                    $sql = "SELECT * FROM product where userid = '$user'";
                    $cnt = 1;
                    if ($result = mysqli_query($connection, $sql)) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="'.$cnt.'" items">';
                            echo '<h3>Item: '.$cnt.'</h3>';
                            echo '<div class="media" style="background-color: white">';
                            echo '<img class="align-self-center mr-3" src="data:image/png;base64,'.base64_encode($row['picture']).'" width="280" height="200">';
                            echo '<div class="media-body">';
                            echo '<br/>';
                            echo '<h4>Title: '.$row['title'].'</h4>';
                            echo '<p>Price: '.$row['price'].'</p>';
                            echo '<p>Condition: '.$row['condition'].'</p>';
                            echo '<p>The trading place you set is: '.$row['trading_place'].'</p>';
                            echo '<p>Its expiry date is: '.$row['expiry'].'</p>';
                            echo '<br/>';
                            echo '<h4>Description:</h4><p>'.$row['description'].'</p>';
                            echo '</div>';
                            echo '<div class="align-self-center mr-3 btn-group-vertical">';
                            echo '<button type="button" class="btn btn-primary">Edit</button>';
                            echo '<button type="button" class="btn btn-danger" onclick="deleteItem('.$row['product_id'].','.$cnt.')">Delete</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '<hr/>';
                            echo '</div>';
                            ++$cnt;
                        }
                    }
                ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteItem(id,element)
        {
            // Fire off the request to delete_product.php
            $.ajax({
                type: "POST",
                url: "delete_product.php",
                data: {productid: id},
                success: function(data){
                    alert("Item deleted.");
                    $('.'+element).hide();
                }
            });
        }
    </script>

</body>
<?php include 'footer.inc.php' ?>
</html>
