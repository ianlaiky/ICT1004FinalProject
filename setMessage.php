<?php
/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 28/3/2019
 * Time: 9:04 PM
 */

session_start();


if (isset($_SESSION['username']) && isset($_GET['rUsr']) && isset($_GET['pid']) && isset($_GET['msg'])) {

    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_errno());
    }


    $recevingUser = $_GET['rUsr'];
    $sendingUser = $_SESSION['user_id'];
    $productid = $_GET['pid'];
    $msgContent = $_GET['msg'];

    $sellUserId = "";
    $sql1 = "select * from product where product_id = '" . $productid . "'";

    if ($result1 = mysqli_query($connection, $sql1)) {
        while ($row1 = mysqli_fetch_assoc($result1)) {

            $sellUserId = $row1['userid'];
        }
    }


    if($sendingUser==$sellUserId){
        $msgdir = "from";
        $stmt = $connection->prepare("INSERT INTO users_message (message_content, fk_productid, fk_sellerUserId,fk_custUserId,msgDirection) VALUES (?, ?, ? , ? , ?)");
        $stmt->bind_param("siiis", $msgContent, $productid, $sendingUser,$recevingUser,$msgdir);

        $stmt->execute();
        echo "New records created successfully";
        $stmt->close();

    }else{
        $msgdir = "to";
        $stmt = $connection->prepare("INSERT INTO users_message (message_content, fk_productid, fk_sellerUserId,fk_custUserId,msgDirection) VALUES (?, ?, ? , ? , ?)");
        $stmt->bind_param("siiis", $msgContent, $productid,$recevingUser,$sendingUser,$msgdir);

        $stmt->execute();
        echo "New records created successfully";
        $stmt->close();
    }


    $connection->close();

} else {

    echo "Not logged in";

}


?>