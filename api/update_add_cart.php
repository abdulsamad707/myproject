<?php

header('Access-Control-Allow-Methods:POST');

header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include("function.php");
include("validkey.php");


 $cartdata=file_get_contents("php://input");
 $cartdata=json_decode($cartdata,true);


  extract($cartdata);

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}
$ipadd=   get_client_ip();

$sql="SELECT * FROM cart WHERE ip_add ='$ipadd' AND user_id='$user_id' AND pid='$pid' ";

$cartdatadetail=$data->sql($sql,"read");
$totalRecord=$cartdatadetail['totalRecord'];
$api_status=array();

if($totalRecord>0){
    
           if($action==="add"){
            $stat_message="already added to cart!";
           }else{
            $cart_id = $_POST['cart_id'];
            $qty = $_POST['qty'];
            print_r($cartdatadetail);
            print_r($cartdata);
                 die();
            $qty = filter_var($qty, FILTER_SANITIZE_STRING);
            $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
            $update_qty->execute([$qty, $cart_id]);

            $stat_message= "cart quantity updated";
           }
  $api_status['message']=$stat_message;
}else{

$conn=$data->getConnection();
  $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, price, quantity,ip_add) VALUES(?,?,?,?,?)");
  $insert_cart->execute([$user_id,$pid,$price,$quantity,$ip_add]);
  $api_status['message']= 'added to cart!';
  
}


echo json_encode($api_status);




   
  
    
        
            
    




?>