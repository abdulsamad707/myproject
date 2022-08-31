
<?php
clearstatcache();
       include("db.php");
include("credential.php");

session_start();
session_regenerate_id();

$data=new CRUDOPERATION($hostname,$dbname,$username,$password);

  if(isset($_GET['key']) && !empty($_GET['key']) ){
             $apikey=$_GET['key'];
              $table=["apikey"];
             $apicondition=['apikey'=>"'$apikey'"];           
            
            
           
             $apikeydata =  $data->getData('apikey',null,null,$apicondition,null,null);
     
               
             if($apikeydata['totalRecord']<1){
                $result['msg']="$apikey is not valid key";
            
                        $status=false;
          $result["code"]=2;
  
             }else{
             
                $hitlimits= $apikeydata['data'][0]['hitlimit'];
                
                $hit= $apikeydata['data'][0]['hit'];
                $expired_at=$apikeydata['data'][0]['expirydate'];
                $apistatus=$apikeydata['data'][0]['status'];
                       $time2=strtotime(date('Y-m-d H:i:s'));
                    $time1=strtotime($expired_at);
                            
                     if($apistatus==0){
                       $result['msg']="API Key $apikey is Disabled";
                       $result["code"]=3;
                     $status=false;
        
                     }else{
                        if($hit  >= $hitlimits){
                         $result['msg']='Hit Limit Exceed';
                           
                     $status=false;
          $result["code"]=4;
                        }else{
                        
                                   if($time1 < $time2){
                                     
                                     
                                    
                               $diff=date_diff(date_create(date("Y-M-d")),date_create($expired_at));
                                $day=$diff->d;
                                   $result['msg']="API Key $apikey is Expired";
                                   $result["code"]=4;
                                 $status=false;
                                 
                             }else{
                           
                             
                               $result['code']='200';
                                
                            
                             
                             
                           
                           }
                        }
                     }
             
             }
  
  
  }else{
  
   $result['msg']="Please Provide API Key  ";
          $status=false;
          $result["code"]=1;
  
  }
    if(isset($status)){
  echo json_encode($result);
    }


?>

              
              
              
              
              
              
              
              
              
              
               