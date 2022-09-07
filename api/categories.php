<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:appliction/json');


include("validkey.php");


   
 if(isset($_GET['cate'])){
     $cate= $_GET['cate'];
    $sql="SELECT * FROM `categories` WHERE cat_status = '1'";
    }
   if(!isset($_GET['cate']) && !isset($_GET['id']) ){
      $sql="SELECT * FROM `categories`";
   }
   if(isset($_GET['id'])){
    $id=  $_GET['id'];
      $sql="SELECT * FROM `categories` WHERE id='$id'";
   }
$productdatas=$data->sql($sql,'read');
$totalRecord=$productdatas['totalRecord'];
 
$productdata['productData']=$productdatas;
$productdata['status']=1;
echo json_encode($productdata);


?>