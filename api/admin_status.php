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
    $update_sql="UPDATE admin SET status='$status' WHERE id='$id'";
  $productUpdateStatus=  $data->sql($update_sql,"update");
    $productUpdateStatus['message']="Admin Status Change";
     echo json_encode($productUpdateStatus);
}

?>