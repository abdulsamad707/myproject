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


$data->insert("messages",$userdata);
$contactMsg=array("messages"=>"Message Sent Successfully");
echo json_encode($userdata);





?>