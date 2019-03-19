<?php 
    function linkActive($requestUri)
    {
        $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

        if ($current_file_name == $requestUri)
            echo 'class="active"';
    }
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Fast Trade</a>
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
        <li <?=linkActive("register")?>>
            <a class="nav-link" href="register.php">
                Register
            </a>
        </li>
        <li <?=linkActive("login")?>>
            <a class="nav-link" href="login.php">
                Login
            </a>
        </li>
      </ul>
    </div>
  </div>
</nav>