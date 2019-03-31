<?php
    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }
    //statement to update all products that have already expired or sold.
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $pid = $_POST['productid'];
        $sql = "UPDATE product SET `is_active` = 'no' WHERE product.product_id IN (".$pid.")";
        $update_stmt = mysqli_prepare($connection, $sql);
        $update_stmt->execute();
    }
?>