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
  $id=$_GET['productId'];
  $sql="SELECT products.* FROM `products` WHERE  products.id='$id'";
  $productData=$data->sql($sql,"read");



 echo json_encode($productData);


}

?>