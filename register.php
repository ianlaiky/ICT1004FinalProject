<?php session_start() ?>
<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = $email = $username = "";
    $nameER = $usernameER = $confirmER = $captchaErr = $emailER = $passwordER = "";

    require_once('config.php');

    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {

        $validcount = 0;
        if (empty($_POST['name'])) { //check name if empty
            $nameER = "Please enter your name";
        } else {

            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                $nameER = "Only letters and white space allowed";
            } else {
                $name = test_input($_POST["name"]);
                $validcount++;
            }
        }
        if (empty($_POST["username"])) //check username if empty
            $usernameER = "Please enter your username";

        else {

            if (!preg_match("/^[a-zA-Z0-9_]*$/", $_POST["username"])) {
                $usernameER = "Only alphanumeric and underscore characters allowed";
            } else {
                $username = test_input($_POST["username"]);
                $validcount++;
            }
        }


        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailER = "Please enter a valid email address. A verification will be sent to this address.";
        } else {
            $email = test_input($_POST["email"]);
            $validcount++;
        }

        if (empty($_POST["password"])) { //check password if empty
                $passwordER = "Please enter a password.";
        } else {

            if (!preg_match("/\w{8,}/", $_POST["password"])) {
                $passwordER = "Password must be alphanumeric and be at least 8 characters long";
            } else {
                $password = test_input($_POST["password"]);
                $validcount++;
            }
        }

        if (empty($_POST["confirm"])) { //check passwordconfirm if empty
            $passwordconfirmER = "Please re-enter the confirmed password";
        } else {
            if ($_POST["password"] == $_POST["confirm"]) {
                $confirm = test_input($_POST["confirm"]);
                $validcount++;
            } else {
                $confirmER = "Passwords do not match";
            
            }
        }

        if (empty($_POST['g-recaptcha-response'])) {
            echo '<script>alert("Please verify yourself through recaptcha.")</script>';
        }
        else{
            $validcount++;
        }

        if ($validcount == 6) {
            $name = mysqli_real_escape_string($connection, $name);
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $confirm = mysqli_real_escape_string($connection, $confirm);
            $password = password_hash($password, PASSWORD_DEFAULT);
            //Check if user account exist before inserting. 

            if ($sel_stmt = mysqli_prepare($connection, "SELECT user_id, password FROM users WHERE username = ?")) {
                $sel_stmt->bind_param("s", $username);
                $sel_stmt->execute();
                $sel_stmt->store_result();

                if ($sel_stmt->num_rows > 0) {
                    $usernameER= "Username taken. Please choose another username!";
                } else {
                    //account does not exist in database; continue to store.
                    $vkey = md5(time() . $name);
                    if ($insert_stmt = mysqli_prepare($connection, "INSERT INTO users (name, username, password, email, vkey) VALUES (?,?,?,?,?)")) {
                        $insert_stmt->bind_param('sssss', $name, $username, $password, $email, $vkey);
                        // $stmt->execute();
                        if ($insert_stmt->execute()) {
                            
                            $to = $email;
                            $subject = "Email Verification";
                            $message = "<a href=\"http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/verify.php?vkey=$vkey\">Verify Now!</a>";
                            $headers = "From: fast-trade@gmail.com \r\n";
                            $headers .= "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            mail($to, $subject, $message, $headers);
                        
                            echo "<script type='text/javascript'>"
                            . "alert('Thank you for signing up with us! Please go to your email to verify!');"
                                    ." window.location='index.php';</script>";
                        
                        } else {
                            echo "fail";
                        }
                    }
                }
            }
        }
    }
    mysqli_close($connection);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Register</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <!-- Custom styles for this template -->
        <link href="css/shop-homepage.css" rel="stylesheet">
        <style>
            .col-form-label{
                padding-right: 0;
            }
            small{
                color: red;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <?php include 'header.inc.php'; ?>
        <div class="container">
            <br><br>
            <h1>Register Account</h1>
            <br><hr>

            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">Name:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $nameER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">Username:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $usernameER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="email">Email:</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $emailER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="password">Password:</label>
                    <div class="col-sm-5">
                        <input  type="password" class="form-control" name="password">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $passwordER ?></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="confirm">Confirm password:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="confirm">
                        <small style="margin-bottom:0px" class="help-block"><?php echo $confirmER ?></small>
                    </div>
                </div>
                <div class="g-recaptcha" data-sitekey="6Ld5M5sUAAAAAC1rw5rXmToFyYlRbRHoR8_Qqw5I"></div><br>
                <small style="margin-bottom:0px" class="help-block"><?php echo $captchaErr ?></small>
                <div class="form-group row"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
            <p>Already have an account?<a href="login.php"> Sign in </a></p>
        </div>

<?php include 'footer.inc.php' ?>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </body>
</html>