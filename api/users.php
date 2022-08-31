<?php	


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include("validkey.php");
ob_start();
if(!isset($status)){


       if(isset($_GET['id'])){
       $id=  $_GET['id'];
       $sql="SELECT * FROM users";
       }else{
       $sql= "SELECT * FROM users";
           
       }
       $userdata=$data->sql($sql,"read");


    
       
      $update= $data->updateData("apikey",["hit"=>$hit+1],["apikey"=>"'$apikey'"]);  
      
     echo json_encode($userdata);
           
    }

       echo   $result=json_encode($result);

?>