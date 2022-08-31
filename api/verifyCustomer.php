


<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');


include("validkey.php");
ob_start();
if(!isset($status)){
   echo  $userdata=file_get_contents("php://input");
           $userdata=json_decode($userdata);
  
    echo json_encode($userdata);
  $insertStatus['message']=' Mobile Verified Successfully';
  $insertStatus['code']=500;
  $insertStatus['insertId']=0;
  $insertStatus['http_code']=200;
  echo json_encode($insertStatus);
  
 /*$updatedata=  $data->updateData("users",['verified'=>1,'str_rand'=>'','otp'=>'']
 ,['otp'=>$mobile,'str_rand'=>$token]);
 $sendMailer=sendMail($email_message,$email,$username,$subject);
 $number="+".$mobile;
 $message=" $username Your Account Has Been Verified Successfully  Regards IAD Project Grocery PK";*/
/*    $json= SendSms($number,$message);*/
 
  
 

}
?>