<?php

$order_id = $_GET['order_id'];

   $product_data['payment_status']="cancel";
   $product_data['order_id']=$order_id;
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_order.php?key=6CU1qSJfcs");
curl_setopt($ch, CURLOPT_POST, 1);
    unset($_POST['update_payment']);
    $product_data=json_encode($product_data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $product_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_product_add=curl_exec($ch);
  $server_product_add=json_decode($server_product_add,true);
   header('location:orders');
    



?>