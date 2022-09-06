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
   if($confirm_pass!=$new_pass){
    $update_profile['message']="Confirm Password Doesmnot Match";

     echo json_encode($update_profile);
     return false;
   }else{
    $whereCondition['id']="'$id'";
    $getData= $data->getData("admin",null,null,$whereCondition,null,null,null);
      $old_password=$getData['data'][0]['password'];


      if(password_verify($new_pass,$old_password)){
        
        $update_profile['message']="Wrong Old Password";

        echo json_encode($update_profile);
        return false;


      }
       if(!empty($name)){
        $whereCondition['name']="'$name'";
        $getData= $data->getData("admin",null,null,$whereCondition,null,null,null);

     




          $totalRecord=$getData['totalRecord'];
            if($totalRecord>0){
                $update_profile['message']="User Name Already Taken";
                echo json_encode($update_profile);
                return false;
            }else{
              $update_data_field["name"]=$name;
               $update_data_field['password']=password_hash($new_pass,PASSWORD_BCRYPT);
               $whereCondition['id']="'$id'";
               $getData= $data->getData("admin",null,null,$whereCondition,null,null,null);
               $data->updateData('admin',$update_data_field,$whereCondition);
               echo json_encode(["message"=>"Admin Updated"]);
            }

       }else{
     
        $update_data_field['password']=password_hash($new_pass,PASSWORD_BCRYPT);
        $data->updateData('admin',$update_data_field,$whereCondition);
        echo json_encode(["message"=>"Admin Updated"]);
       }
      
   }

     

     
  
}

?>