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

  $userdata=json_decode($userdata,true);
    
    extract($userdata);

  $password=password_hash($password,PASSWORD_BCRYPT,['cost'=>12]);
      $username=ucfirst($username);


    
   
     $checkData=['email'=>"'$email'",'mobile'=>"'$mobile'",'username'=>"'$username'"];
     
                
      $userdat=  $data->getData('users','id',null,$checkData,null,null,'OR');
        $totalRecord= $userdat['totalRecord'];

             if($totalRecord<1){
        
          include ("phpmail.php");  
          include ("smtp.php");  
        

         $randStr= $data->generateRandomString();
          $rdStr=  bin2hex($randStr);
                  $otp=mt_rand(1000,9999);
              
              //Load Composer's autoloader
              $html="";
      $html.="<br> Thanks For Register With Us Please  Verify Your Email At <a href='http://localhost/grocery/verify.html?token=$rdStr&mobile=$mobile'> verify  </a> ";
         $email_message="Your Otp is $otp ".$html;
            $subject="Verification Code";
      /*  $sendMailer=sendMail($email_message,$email,$username,$subject);*/
        $number="+".$mobile;
        $message="Thanks For Registration $username Your OTP is ".$otp."Regards IAD Project Grocery PK";
   /*    $json= SendSms($number,$message);*/
    
         if($sendMailer==1){
    
    
   
            $insertData=['email'=>$email,'mobile'=>$mobile,'verified'=>0,'status'=>1,
            'username'=>$username,'password'=>$password,'otp'=>$otp,'str_rand'=>$rdStr];
           $insertStatus=$data->insert('users',$insertData);
           $insertStatus['http_code']=200;
           $insertStatus['operationStatus']="success";
         }else{
          $insertStatus['message']=' User Not Register Due To Internet Connection';
          $insertStatus['code']=500;
          $insertStatus['insertId']=0;
          $insertStatus['http_code']=200;
          $insertStatus['operationStatus']="error";
         }
       
     
       
           
           
      
             }else{
                $insertStatus['message']=' User Exist';
                $insertStatus['code']=500;
                $insertStatus['http_code']=200;
                $insertStatus['insertId']=$userdat['data'][0]['id'];
                $insertStatus['operationStatus']="error";
             }
             $insertStatus=json_encode($insertStatus);
             echo $insertStatus;
          
      
  
            }else{
               $response["message"]="Invalid Response ";
               echo json_encode($response);
               http_response_code(500);
            }
 
   
         

    }
  

?>