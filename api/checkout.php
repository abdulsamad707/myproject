<?php
include("function.php");
include("validkey.php");
ob_start();
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include('./vendor/autoload.php');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
if(!isset($status)){
    $userdata=file_get_contents("php://input");
$userdata=json_decode($userdata,true);
if(isset($_COOKIE['token'])){
    $jwt=$_COOKIE['token'];
    $key="owt125";
  $decoded = JWT::decode($jwt, new Key($key, 'HS512'));
      $decoded=json_decode(json_encode($decoded),true);
        $issue_at=$decoded['iat'];
           $custumerId=$decoded['data']['id'];
    }else{
      $custumerId=0;
    }
    $ip_add=   get_client_ip();
    
     $dataCart= cartTotal($custumerId,$ip_add,$data);
     
}



?>