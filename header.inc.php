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
      </ul>
    </div>
  </div>
</nav>