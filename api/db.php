<?php
class CRUDOPERATION {

function __construct($host_name,$dbname,$username,$password){

$this->host_name=$host_name;

$pdo=new PDO('mysql:host='.$host_name.';dbname='.$dbname.';',$username,$password);
$this->pdo=$pdo;








}
function getConnection(){
  $db= $this->pdo;
  return $db;
}

function getData($table=null,$rows=null,$groupBy=null,$whereCondition=null,string $orderBy=null,$limit=null,$operator=null){
$db=$this->pdo;
      
            

             if($rows==null){
             $rows="*";
             }else{
              if(gettype($rows)=='array'){
              $rows=implode(" , ",$rows);
               
              }else{
               $rows=$rows;
              }
                 
             }     if(gettype($table)=='array'){
                 $table=implode(" , ",$table);
               }
                  $sql="SELECT $rows FROM $table"; 
                 
              if($whereCondition!=null){
      
              
                   if(gettype($whereCondition)=='array'){
                     $whereConditions='';
                  $whereCondition=   array_unique($whereCondition);
                       if(count($whereCondition) > 1){
                         foreach ($whereCondition  as $key => $value){
                                  
                            $whereConditions.= " $key = $value $operator ";
                                   
                         }
                          if($operator=="OR"){
                         $whereConditions=rtrim($whereConditions," OR ");
                          }else{
                           $whereConditions=rtrim($whereConditions," AND ");
                          }
                         
                       }else{
                        foreach ($whereCondition  as $key => $value){
                            $whereConditions.= " $key = $value ";
                         }
                            
                       } 
                   
                   }           
                $sql.=" WHERE $whereConditions";
             }
                
                
                if($groupBy!=null){
                 
                 $sql.=" GROUP BY  $groupBy ";
                 }
              if($orderBy!=null){
               $sql.=" ORDER BY $orderBy";
              
              }
              if($limit!=null){
                $sql.="LiMIT $limit";
              
              }
              
                   
                      
                    if($table!='apikey'){
                   
                      
                    }
                  
            
     
              
        
   
                  
                 $result=$this->sql($sql,"read"); 
                   return $result;
                         
      
  
   


}


function updateData ($table,$params=array(),$whereCod=null){
    
    
    
    
   $sql="UPDATE $table SET "; 
   
       $args=array();
       foreach($params as $key => $value){
       $args[]="$key = '$value'";
       
       }
  
   
   
   $numberOfcondit=count($whereCod);
   $newArray=array();
 
     $whereConditions='';
       if($numberOfcondit >1){
   
           foreach($whereCod as $key => $value){
         $whereConditions.=" $key='$value' AND";
          
           
           }
        $whereConditions=rtrim($whereConditions,"AND");
        
       }else{
         foreach($whereCod as $key => $value){
           $whereConditions.="$key=$value";
           
           }
           
       }
       $db=$this->pdo;
       $sql.=implode(',',$args);
      $sql.=" WHERE  $whereConditions";
        
     return  $this->sql($sql,'update');
       


}

      
     function insert($table,$insertParams){
   
            $table_column=implode(",",array_keys($insertParams));
               $table_value=implode("' , '",$insertParams);
         $sql="INSERT INTO $table ($table_column) VALUES ('$table_value')";
      
          
        $result= $this->sql($sql,"insert");
        return $result;
     
     }
     function deleteData($table,$id){
      $sql="DELETE FROM $table WHERE id='$id'";
      $result= $this->sql($sql,"delete");
      return $result;
     }
  function sql($sql,$type) {
   $db=$this->pdo;
       $sql;     


          $stmt= $db->prepare($sql);                                                                                                                                                                                                                                                                                                                                         $db->prepare($sql);
          $stmt->execute();
                                   
         
       
           
           
      
              
          
            $totalRecord=$stmt->rowCount();
           if($type=="read"){
                $result_array=array();
               while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
                   $result_array[]=$data;
                   
                   
               }
          
            $result["data"]=$result_array;
            $result["totalRecord"]=$totalRecord;
            if($totalRecord>0){
            $result["code"]=200;
            $result["message"]="Data Found";
            }else{
            
               $result["code"]=500;
                   $result["message"]="Data Not Found";
            }
          }
          if($type=="update"){
                 $result["code"]=200;
            $result["message"]="Data Upated";
           $result["totalRecord"]=$totalRecord;
          }if($type=="insert"){
              $result["message"]="Data Inseted";
              $result["code"]=200;
              $result["insertId"]=$db->lastInsertId();

          }if($type=="delete"){
            $result["code"]=200;
            $result["message"]="Data Upated";
           $result["totalRecord"]=$totalRecord;
          }
        
          
          
     return  $result;
   }
   function generateRandomString($length = 10) {
      return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }
}
?>