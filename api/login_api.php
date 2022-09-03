<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include ("function.php");
include ("validkey.php");
ob_start();
if (!isset($status))
{
   $conn=$data->getConnection();
    $userdata=file_get_contents("php://input");
    $userdata=json_decode($userdata,true);
    extract($userdata);
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    if($select_user->rowCount() > 0){


        if(password_verify($password,$row['password'])){
        $logindata['message']="login Successfully";
        $logindata['id']=$row['id'];
        $logindata['status']=1;
        }else{
            $logindata['message']="Wrong Password";
            $logindata['id']="";
            $logindata['status']=0; 
        }
    }else{
        $logindata['message']="Email Is Not Registered";
        $logindata['id']="";
        $logindata['status']=0;
    }


    echo json_encode($logindata);

}

?>