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
       $sql="SELECT * FROM reviews WHERE id ='$id'";
       }if(isset($_GET['type'])){
       $sql= "SELECT * FROM reviews ";
           
       }
       if(!isset($_GET['type']) && !isset($_GET['id'])){
        $sql="SELECT name,review,DATE_FORMAT(created_at,'%d-%M-%Y') as created_at FROM reviews where status ='1'";
       }

       $userdata=$data->sql($sql,"read");


    
       
 
      
     echo json_encode($userdata);
           
    }


?>