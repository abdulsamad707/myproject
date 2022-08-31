<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:appliction/json');

include("function.php");
include("validkey.php");


ob_start();

    


 
    $ip_add=   get_client_ip();
   $dataCart= cartTotal($custumerId,$ip_add,$data);

      echo json_encode($dataCart);

?>