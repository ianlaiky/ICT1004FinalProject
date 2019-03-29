<?php

    $ref1 = $ref2 = $ref1Name = $ref2Name = "";
    function linkActive($requestUri)
    {
        $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
        if ($current_file_name == $requestUri)
            echo 'class="active"';
    }

    if (!isset($_SESSION['username'])) {
        $ref1 = "register";
        $ref1Name = "Register";
        $ref2 = "login";
        $ref2Name = "Login";
    }
    else{
        $ref1 = "profile";
        $ref1Name = "My Profile";
        $ref2 = "logout";
        $ref2Name = "Logout";
    }

?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Fast Trade</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        
        <li <?=linkActive("index")?>>
            <a class="nav-link" href="index.php">
                Home
            </a>
        </li>

        <!--For products-->
        <?php
            if (isset($_SESSION['username'])) {
              echo '<li class="nav-item dropdown">';
              echo '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Items</a>';
              echo '<div class="dropdown-menu">';
              echo '<a class="dropdown-item" href="user_items.php">My items</a>';
              echo '<a class="dropdown-item" href="create_product.php">Sell an item</a>';
              echo '</div>';
              echo '</li>';

                echo '<li class="nav-item">';
                echo '<a class="nav-link" href="messageInbox.php?pid=0">Inbox</a>';
                echo '</li>';
            }
        ?>
        <li <?=linkActive($ref1)?>>
            <a class="nav-link" href=<?php echo $ref1.".php" ?>>
                <?php echo $ref1Name ?>
            </a>
        </li>
        <li <?=linkActive($ref2)?>>
            <a class="nav-link" href=<?php echo $ref2.".php" ?>>
                <?php echo $ref2Name ?>
            </a>
        </li>
        <form class="form-inline my-2 my-lg-0">
            <input id="search" class="form-control ml-sm-5" type="search" placeholder="Search" aria-label="Search">
        </form>
      </ul>
    </div>
  </div>
</nav>

<script>
    document.getElementById("search").onkeypress = function (e){
        var search = document.getElementById("search").value;
        if (e.keyCode == 13) {
            e.preventDefault();
            window.location.href = "searchProduct.php?search=" + search;;       
        }
    }
</script>