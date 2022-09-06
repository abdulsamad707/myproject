<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include ("function.php");
include ("validkey.php");
if (!isset($status)){
$userdata=file_get_contents("php://input");
$userdata=json_decode($userdata,true); 
   extract($userdata);
   $sql_admin="SELECT * FROM admin WHERE name ='$name'";
   $sql_admin_data=$data->sql($sql_admin,"read");

      $totalRecord=$sql_admin_data['totalRecord'];
      if($totalRecord > 0){
        $logindata['message']="User Name Already Taken";
      
      }else{
        $logindata['message']=" Admin Register"; 
        $insertAdmin['name']=$name;
        $pass=password_hash($pass,PASSWORD_BCRYPT,["cost"=>12]);
        $insertAdmin['password']=$pass;
        $insertAdmin['status']=1;
        $data->insert('admin',$insertAdmin);
        $logindata['message']=" Admin Register"; 
      }
      echo json_encode($logindata);

}
?>