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
      if($totalRecord<=0){
        $logindata['message']="Wrong User Name";
        $logindata['id']=0;
      }else{
        $old_password=$sql_admin_data['data'][0]['password'];
        $status=$sql_admin_data['data'][0]['status'];
        if(password_verify($password,$old_password)){
             if($status==1){

            $logindata['message']=" User Authenticate";
            $logindata['id']=$sql_admin_data['data'][0]['id'];
             }else{
                $logindata['message']="User Deactivated";
                $logindata['id']=0;
             }
        }else{
            $logindata['message']=" Wrong Password";
            $logindata['id']=0;
        }
      }
      echo json_encode($logindata);

}
?>