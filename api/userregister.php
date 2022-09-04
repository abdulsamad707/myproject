<?php	


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');

header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include("function.php");
include("validkey.php");
ob_start();
if(!isset($status)){

$posttye=$_SERVER['REQUEST_METHOD'];
   if($posttye==="POST"){
   $userdata=file_get_contents("php://input");

  $userdatas=json_decode($userdata,true);


 
    
   extract(json_decode($userdata,true));
   $sql="SELECT * from `users` WHERE  email ='$email' OR number='$number' ";
  $userRegister=$data->sql($sql,"read");

   $totalRecord=$userRegister['totalRecord'];
     if($totalRecord>0){
      $insertStatus["message"]="User Already Exists";

     }else{
      $data->insert('users',$userdatas);
      $insertStatus["message"]="User Register Successfully";
     }

    
   echo json_encode($insertStatus);

            
            
            
      }
        
  
   
         

    }
   

?>