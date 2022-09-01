<?php
ob_start();
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:appliction/json');
include("function.php");
include("validkey.php");
      $_GET['user_id'];
 $user_id=$_GET['user_id'];

 $ipadd=   get_client_ip();
$sql="SELECT cart.id as cart_id,cart.pid,cart.quantity,cart.price,products.name as product_name,products.image as product_image  FROM cart,products WHERE  user_id='$user_id' AND ip_add='$ipadd' AND products.id=cart.pid";
$cartdatas=$data->sql($sql,"read");
echo json_encode($cartdatas);



?>