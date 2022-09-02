<?php
include("function.php");
include("validkey.php");
ob_start();
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
$userdata=file_get_contents("php://input");
$userdata=json_decode($userdata,true);
$user_id=$userdata['user_id'];
$insertStatus=$data->insert("orders",$userdata);
$orderId=$insertStatus['insertId'];
if($orderId>0){
  $sql_delete="delete from cart where user_id='$user_id'";
   $data->sql($sql_delete,"delete");
}
$insertStatus['message']="Your Order Has Been Placed Successfully Your Order Id is $orderId";
echo json_encode($insertStatus);




?>