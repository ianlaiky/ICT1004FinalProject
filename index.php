<?php session_start() 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<!--  <article>-->
      <!-- Page Content -->
      <div class="container-fluid">
        <div class="jumbotron"></div>  
        <h1 style="border-left: 0px; border-right:0px;"class="bg-text display-3">Sell, buy, trade. Today!</h1>   
      </div>

      <div class="container">
        <div class="row">
  
              <?php
                  $currDate = date('Y-m-d');
                  $type = "";
                  $ids = array();
                  //$sql = "SELECT * FROM product WHERE product.expiry > '$currDate' AND product.is_active = 'yes'";
                  //is_active determines if the product is ready for listing.
                  //'yes' means it is being listed. 'no' = expired/sold
                  $sql = "SELECT * FROM product WHERE product.is_active = 'yes'";
                  if (isset($_GET['type'])) {
                      $type = $_GET['type'];
                      echo '<h2 class="text-line"><span>'.$type.'</span></h2>';
                      if ($result = mysqli_query($connection, $sql)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['type'] == $type) {
                              if(strtotime($row['expiry']) > strtotime($currDate))
                              {
                                  echo '<div class="col-lg-3 col-md-4 mb-4">';
                                  echo '<a href="product.php?product_id='.$row['product_id'].'&user_id='.$row['userid'].'">';
                                  echo '<div class="card">';
                                  echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row['picture']).'">';
                                  echo '<hr>';
                                  //echo '<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>';
                                  echo '<div class="product-details">';
                                  echo '<p class="text-muted">'.$row['type'].'</p>';
                                  echo '<h3 class="text-center product-title">'.$row['title'].'</h3>';
                                  echo '<h4 class="text-center product-price">S$'.$row['price'].'</h4>';
                                  echo '</div>';
                                  // echo '<div class="card-footer">';
                                  // echo '<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>';
                                  // echo '</div>';
                                  echo '</div>';
                                  echo '</a>';
                                  echo '</div>';
                              }
                              else if($row['is_active'] == 'yes')
                              {
                                array_push($ids, $row['product_id']);
                              }
                            }           
                        }
                    }
                  }
                  else
                  {
                    echo '<h2 class="text-line"><span>All products</span></h2>';
                    if ($result = mysqli_query($connection, $sql)) {

                      while ($row = mysqli_fetch_assoc($result)) {
                        if(strtotime($row['expiry']) > strtotime($currDate))
                        {
                              echo '<div class="col-lg-3 col-md-4 mb-4">';
                              echo '<a href="product.php?product_id='.$row['product_id'].'&user_id='.$row['userid'].'">';
                              echo '<div class="card">';
                              echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row['picture']).'">';
                              echo '<hr>';
                              //echo '<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>';
                              echo '<div class="product-details">';
                              echo '<p class="text-muted">'.$row['type'].'</p>';
                              echo '<h3 class="text-center product-title">'.$row['title'].'</h3>';
                              echo '<h4 class="text-center product-price">S$'.$row['price'].'</h4>';
                              echo '</div>';
                              // echo '<div class="card-footer">';
                              // echo '<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>';
                              // echo '</div>';
                              echo '</div>';
                              echo '</a>';
                              echo '</div>';     
                      }
                      else if($row['is_active'] == 'yes')
                      {
                          array_push($ids, "'".$row['product_id']."'");
                      }
                    }
                   }
                  }            
                ?>
            </div>
      </div>
  </div>



  
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    var pIDs = "<?php echo join(', ', $ids);?>"
    $(document).ready(function(){
      //Only fire the update event when there's expired product IDs in the database.
      if(pIDs != "")
        updateActive(pIDs);
      if(ifType())
        window.scrollTo(0, 400);
    });

    function updateActive(ids)
    {
        $.ajax({
        type: "POST",
        url: "update_active.php",
        data: {productid: ids},
        });
    }

    function ifType(){
      var field = 'type';
      var url = window.location.href;
      if(url.indexOf('?' + field + '=') != -1)
          return true;
      else if(url.indexOf('&' + field + '=') != -1)
          return true;
      return false
    }
  </script>
</body>

<?php include 'footer.inc.php' ?>
</html>
