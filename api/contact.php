<?php
include("function.php");
include("validkey.php");
ob_start();
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
$userdata=file_get_contents("php://input");
$userdata=json_decode($userdata,true);
if($userdata['action']=='message'){
unset($userdata['action']);
$data->insert("messages",$userdata);
$contactMsg=array("messages"=>"Message Sent Successfully");
echo json_encode($contactMsg);
} 
if($userdata['action']=='review'){
    unset($userdata['action']);
    
    $data->insert("reviews",$userdata);
    
    $contactMsg=array("messages"=>"Review Sent Successfully");
    echo json_encode($contactMsg);
} 



?>