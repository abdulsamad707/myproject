<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include ("function.php");
include ("validkey.php");
ob_start();
if (!isset($status))
{
   $conn=$data->getConnection();
    $userdata=file_get_contents("php://input");

   $userdata=json_decode($userdata,true);

    extract($userdata);
    $update_sql="UPDATE categories SET cat_status='$status_action' WHERE id='$product_id'";
  $productUpdateStatus=  $data->sql($update_sql,"update");
    $productUpdateStatus['message']="Product Status Change";
     echo json_encode($productUpdateStatus);
}

?>