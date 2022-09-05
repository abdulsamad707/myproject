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

 
   }

   if(isset($productSearch) && $productSearch!='' ){
    $productSearch= trim($productSearch,'/');
$productSearch= rtrim($productSearch,'/');
$productSearch= ltrim($productSearch,'/');
$productSearch= rtrim($productSearch,'/');
 $productSearch= rtrim($productSearch," ");
   $sql="SELECT * FROM products WHERE  productKeyWord like '%$productSearch%' or soundex('$productSearch')=soundex(productKeyWord)";
   }else{
    $sql="SELECT * FROM products  ";   
   }

$productdatas=$data->sql($sql,'read');
$totalRecord=$productdatas['totalRecord'];
 
$productdata['productData']=$productdatas;
$productdata['status']=1;
echo json_encode($productdata);


?>