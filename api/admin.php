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
       $sql="SELECT * FROM admin WHERE id='$id'";
       }else{
       $sql= "SELECT * FROM admin";
           
       }
       $userdata=$data->sql($sql,"read");


    
       
 
      
     echo json_encode($userdata);
           
    }


?>