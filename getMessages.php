<?php
/**
 * Created by PhpStorm.
 * User: Ian
 * Date: 24/3/2019
 * Time: 3:19 PM
 */
session_start();

if (isset($_SESSION['username'])) {

    // get var: productid, userid

    require_once('config.php');
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_errno());
    }

    $sellertrue = 0;

    $sql1 = "select * from product where userid = '".$_SESSION['user_id']."' and product_id = '".$_GET['productid']."'";
    if ($result1 = mysqli_query($connection, $sql1)) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if($row1 > 0){
                $sellertrue =1;
            }



        }}

//    echo $sellertrue;

$sql="";

//    if($sellertrue==0){
        $sql = "Select * from users_message where (fk_custUserId = '".$_SESSION['user_id']."' or fk_sellerUserId = '".$_SESSION['user_id']."') and fk_productid = ".$_GET['productid'];

//    }else{
//
//        $sql = "Select * from users_message where fk_sellerUserId = '".$_SESSION['user_id']."' and fk_productid = ".$_GET['productid'];
//
//    }



    $data = array();

    if ($result = mysqli_query($connection, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $tempdata = array();
            $tempdata['message_id'] = $row['message_id'];
            $tempdata['message_content'] = $row['message_content'];
            $tempdata['fk_productid'] = $row['fk_productid'];
            $tempdata['fk_sellerUserId'] = $row['fk_sellerUserId'];
            $tempdata['fk_custUserId'] = $row['fk_custUserId'];


            if($sellertrue==1){
                if($row['msgDirection']=="to"){
                    $tempdata['msgDirection']="from";
                }else{
                    $tempdata['msgDirection']="to";
                }

            }else{
                $tempdata['msgDirection'] = $row['msgDirection'];
            }



            array_push($data,$tempdata);


        }
    }

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(
        $data
    );

    
}else{
    echo "Not logged in";
}