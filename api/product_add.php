

<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include("function.php");
include("validkey.php");
ob_start();


if(!isset($status)){

    $userdata=file_get_contents("php://input");
      $userdata=json_decode($userdata,true);



     print_r($userdata);
print_r($_FILES);

 

 
  


}


?>