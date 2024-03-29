<?php
/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 24/3/2019
 * Time: 3:19 PM
 */
session_start();
//Users that are not registered should not be able to access this page.
if(!isset($_SESSION['user_id']))
{
  ob_start();
  header('Location: errorpage.php');
  ob_end_flush();
  die();
}
if (isset($_SESSION['username'])) {

    // get var: productid, userid

    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_errno());
    }

    $sellertrue = 0;

    $sql1 = "select * from product where userid = '" . $_SESSION['user_id'] . "' and product_id = '" . $_GET['productid'] . "'";
    if ($result1 = mysqli_query($connection, $sql1)) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if ($row1 > 0) {
                $sellertrue = 1;
            }


        }
    }


    $sql = "";
//    echo $_GET['custid'];


    if ($_GET['custid'] != 0) {

        $sql = "Select * from users_message where (fk_custUserId = '" . $_SESSION['user_id'] . "' or fk_sellerUserId = '" . $_SESSION['user_id'] . "') and fk_productid = '" . $_GET['productid'] . "'and fk_custUserId='" . $_GET['custid']."'";

    } else {
        $sql = "Select * from users_message where (fk_custUserId = '" . $_SESSION['user_id'] . "' or fk_sellerUserId = '" . $_SESSION['user_id'] . "') and fk_productid = " . $_GET['productid'];

    }


    $data = array();

    $otheruser = "";

    if ($result = mysqli_query($connection, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $tempdata = array();
            $tempdata['message_id'] = $row['message_id'];
            $tempdata['message_content'] = $row['message_content'];
            $tempdata['fk_productid'] = $row['fk_productid'];
            $tempdata['fk_sellerUserId'] = $row['fk_sellerUserId'];
            $tempdata['fk_custUserId'] = $row['fk_custUserId'];


            if ($sellertrue == 1) {
                if ($row['msgDirection'] == "to") {
                    $tempdata['msgDirection'] = "from";
                } else {
                    $tempdata['msgDirection'] = "to";
                }

            } else {
                $tempdata['msgDirection'] = $row['msgDirection'];
            }

            if ($otheruser == "") {
                if ($tempdata['fk_sellerUserId'] != $_SESSION['user_id']) {
                    $otheruser = $tempdata['fk_sellerUserId'];
                } else {
                    $otheruser = $tempdata['fk_custUserId'];
                }
            }

            array_push($data, $tempdata);


        }
    }
    array_push($data, $otheruser);
    array_push($data, $_GET['productid']);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(
        $data
    );
    $connection->close();

} else {
    echo "Not logged in";
}