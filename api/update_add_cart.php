<?php

header('Access-Control-Allow-Methods:POST');
/*
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
*/
include("function.php");
include("validkey.php");


 $cartdata=file_get_contents("php://input");
 $cartdata=json_decode($cartdata,true);

    
  print_r($cartdata);
  extract($cartdata);

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}
$ipadd=   get_client_ip();

$sql="SELECT * FROM cart WHERE ip_add ='$ipadd' AND user_id='$user_id'  ";

$cartdatadetail=$data->sql($sql,"read");
print_r($cartdatadetail);


/*hgi*/
   
die();

   
  
    
        
            
    




?>