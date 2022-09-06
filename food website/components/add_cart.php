<?php
include 'function.php';
if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login');
   }else{


      $user_id = $_SESSION['user_id'];
    

$ip_add=get_client_ip();


// Receive server response ...



$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);




$post['ip_add']=get_client_ip();
$pid=filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
$post['pid']=$pid;
$post['user_id']=  $user_id;
$post['action']='add';
$quantity=filter_var($_POST['qty'], FILTER_SANITIZE_STRING);
$post['quantity']=$quantity;
$price=filter_var($_POST['price'], FILTER_SANITIZE_STRING);
$post['price']=$price;
$post=json_encode($post);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_add_cart.php?key=6CU1qSJfcs");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_FAILONERROR, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
$server_output = curl_exec($ch);

$server_output=json_decode($server_output,true);

$messages=$server_output['message'];
$message[]=$messages;
curl_close ($ch);


     
       
      

   }

}

?>