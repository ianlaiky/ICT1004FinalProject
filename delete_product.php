<?php
    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
    if (mysqli_connect_errno() ){
        die( mysqli_connect_error() );
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $pid = $_POST['productid'];
        $delete_stmt = mysqli_prepare($connection, "DELETE FROM product WHERE product.product_id = ?");
        $delete_stmt->bind_param('s', $pid);
        $delete_stmt->execute();
    }
?>