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
          </div>
        </div>