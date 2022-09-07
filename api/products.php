<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:appliction/json');


include("validkey.php");


   if(isset($_GET['productSearch'])){
$productSearch=$_GET['productSearch'];
$productSearch= trim($productSearch,'/');
$productSearch= rtrim($productSearch,'/');

$productSearch = preg_replace("/[^A-Za-z0-9\-]/", '', $productSearch); // Removes special chars.
 // Removes special chars.
 if(isset($productSearch) && $productSearch!='' ){
        
   $sql="SELECT   products.* FROM products  WHERE  products.category like '%$productSearch%' or  name like '%$productSearch%' OR productKeyWord like '%$productSearch%' or soundex('$productSearch')=soundex(productKeyWord) or soundex('$productSearch')=soundex(name)";
 }
 
 }
 if(isset($_GET['cate'])){
     $cate= $_GET['cate'];
    $sql="SELECT * FROM `products` WHERE category = '$cate'";
    }
   if(!isset($_GET['cate']) && !isset($_GET['productSearch'])){
      $sql="SELECT products.* FROM `products`";
   }

$productdatas=$data->sql($sql,'read');
$totalRecord=$productdatas['totalRecord'];
 
$productdata['productData']=$productdatas;
$productdata['status']=1;
echo json_encode($productdata);


?>