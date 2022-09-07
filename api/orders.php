<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:GET');
include("validkey.php");
ob_start();
if(!isset($status)){

   

     if(isset($_GET['user_id']))
     {
      $user_id=$_GET['user_id'];
    $order_sql="SELECT id, name,number,email,method,address,total_products,total_price,payment_status,DATE_FORMAT(placed_on,'%d-%M-%Y') as placed_on from orders WHERE user_id='$user_id'";

     }else{
      $order_sql="SELECT id, name,number,email,method,address,total_products,total_price,payment_status,DATE_FORMAT(placed_on,'%d-%M-%Y') as placed_on from orders Order By Id desc";

     }
      $order_data_container=  $data->sql($order_sql,'read');
       $order_data=$order_data_container;
         echo json_encode($order_data);
         
         
         
         
  

          
    
           
        
               
   
                        
      
     
    }
  

?>