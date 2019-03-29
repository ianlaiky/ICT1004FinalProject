<!DOCTYPE html>
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
      <div class="container">

      <div class="row">

          <div class="col-lg-3">

            <h1 class="my-4">Categories</h1>
            <ul class="list-group">
              <?php
                $type = "";

                $sql = "SELECT * FROM category ORDER BY category.cat_id ASC";
                if (isset($_GET['type'])) {
                    $type = $_GET['type'];
                }

                if ($result = mysqli_query($connection, $sql)) {
                  echo '<a href="index.php" class="list-group-item';
                        if (!isset($_GET['type'])) {
                            echo ' active';
                        }
                        echo '">';
                        echo 'All';
                        echo '</a>';
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="index.php?type='.$row['type'].'" class="list-group-item';
                        if ($row['type'] == $type) {
                            echo ' active';
                        }
                        echo '">';
                        echo $row['type'];
                        echo '</a>';
                    }
                }
              ?>
            </ul>

          </div>
          <!-- /.col-lg-3 -->

          <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" ></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                  <?php
                    $cnt = 1;
                    $type = "";
                    $currDate = date('Y-m-d');
                    if (isset($_GET['type'])) {
                        $type = $_GET['type'];
                        $sql = "SELECT * FROM product WHERE product.type='$type' ORDER BY RAND() LIMIT 3;";

                        if ($result = mysqli_query($connection, $sql)) {
                            while($row = mysqli_fetch_assoc($result)) {
                                if($cnt == 1){
                                  echo '<div class="carousel-item active">';
                                }
                                else{
                                  echo '<div class="carousel-item">';
                                }
                                echo '<img class="d-block img-fluid caroImage" src="data:image/png;base64,'.base64_encode($row['picture']).'" alt="First slide">';
                                echo '<div class="carousel-caption">';
                                echo '<h3>'.$row['title'].'</h3>';
                                echo '<p>'.$row['description'].'</p>';
                                echo '</div>';
                                echo '</div>';
                                ++$cnt;
                            }
                        }
                    }
                    else
                    {
                        $sql = "SELECT * FROM product ORDER BY RAND() LIMIT 3;";
                        if ($result = mysqli_query($connection, $sql)) {
                          while($row = mysqli_fetch_assoc($result)) {
                              if($cnt == 1){
                                echo '<div class="carousel-item active">';
                              }
                              else{
                                echo '<div class="carousel-item">';
                              }
                              echo '<img class="d-block img-fluid caroImage" src="data:image/png;base64,'.base64_encode($row['picture']).'" alt="First slide">';
                              echo '<div class="carousel-caption">';
                              echo '<h3>'.$row['title'].'</h3>';
                              echo '<p>'.$row['description'].'</p>';
                              echo '</div>';
                              echo '</div>';
                              ++$cnt;
                          }
                        }
                    }
                  ?>
                <!-- <div class="carousel-item active">
                  <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
                </div> -->
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

            <div class="row">
              <?php
                  $type = "";
                  $sql = "SELECT * FROM product WHERE product.expiry > '$currDate' AND product.is_active = 'yes'";
                  if (isset($_GET['type'])) {
                      $type = $_GET['type'];

                      if ($result = mysqli_query($connection, $sql)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['type'] == $type) {
                                echo '<div class="col-lg-4 col-md-6 mb-4">';
                                echo '<div class="card h-100">';
                                echo '<a href="product.php?product_id='.$row['product_id'].'&user_id='.$row['userid'].'"><img class="card-img-top" src="data:image/png;base64,'.base64_encode($row['picture']).'"></a>';
                                //echo '<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">'.$row['title'].'</div>';
                                echo '<div class="card-text">Price: '.$row['price'].'</div>';
                                echo '</div>';
                                // echo '<div class="card-footer">';
                                // echo '<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>';
                                // echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }           
                        }
                    }
                  }
                  else
                  {
                    if ($result = mysqli_query($connection, $sql)) {
                      while ($row = mysqli_fetch_assoc($result)) {
                              echo '<div class="col-lg-4 col-md-6 mb-4">';
                              echo '<div class="card h-100">';
                              echo '<a href="product.php?product_id='.$row['product_id'].'&user_id='.$row['userid'].'"><img class="card-img-top" src="data:image/png;base64,'.base64_encode($row['picture']).'"></a>';
                              //echo '<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>';
                              echo '<div class="card-body">';
                              echo '<div class="card-text">'.$row['title'].'</div>';
                              echo '<div class="card-text">Price: S$'.$row['price'].'</div>';
                              echo '</div>';
                              // echo '<div class="card-footer">';
                              // echo '<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>';
                              // echo '</div>';
                              echo '</div>';
                              echo '</div>';     
                      }
                  }
                  }
                  
                ?>
              <!-- <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item One</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item Two</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item Three</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item Four</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item Five</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#">Item Six</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div> -->

            </div>
            <!-- /.row -->

          </div>
          <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-12 -->


    <!-- /.row -->

  </div>
  <!-- /.container -->


  
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<br>
<?php include 'footer.inc.php' ?>
</html>
