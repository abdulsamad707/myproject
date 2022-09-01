<?php
header('Access-Control-Allow-Methods:DELETE');
header('Access-Control-Allow-Origin:*');
/*header('Content-Type:appliction/json');*/
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include("function.php");
include("validkey.php");
$cartdata=file_get_contents("php://input");
$cartdata=json_decode($cartdata,true);
extract($cartdata);
if(isset($cart_id)){
    $deleteStatus=$data->deleteData("cart",$cart_id);
}
if(isset($user_id)){
    $deleteStatus=$data->deleteData("cart",$user_id);
}

if($deleteStatus["code"]==200){

    $stat_message="delete from cart";
    $api_status['message']=$stat_message;
    echo json_encode($api_status);
}





  
?>