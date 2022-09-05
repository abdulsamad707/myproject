

<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Content-Type:application/json");
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include("function.php");
include("validkey.php");
ob_start();


if(!isset($status)){

     $userdata=file_get_contents("php://input");
   
   

 




    $productData=$_POST;
    extract($_POST);
    $productData['image']=$file;
    $productData['name']=$productName;
    $productData['productStatus']=1;
    unset($productData['productName']);
    unset($productData['action']);
   $sql_check_product="SELECT * FROM products WHERE name='$productName'";
    $sql_check_product_data=$data->sql($sql_check_product,"read");
    $fileName= $_FILES['file']['name'];
    $fileSize= $_FILES['file']['size'];
    $tmpName=$_FILES['file']['tmp_name'];
    $ext= pathinfo($fileName,PATHINFO_EXTENSION);
    $file=rand().".".$ext;

       $totalProduct=$sql_check_product_data['totalRecord'];
       if($totalProduct < 1){
    
        $insertProduct=$data->insert("products",$productData);
        $insertProduct['message']="Product Added Into The Store Successfully";
              
      move_uploaded_file($tmpName,'productImage/'.$file);
       }else{

       
           if($action=="add"){
        $insertProduct['message']="Product Already Exists";
           }else{
           print_r($sql_check_product_data);
           
                die();
             if(!empty( $fileName)){
              move_uploaded_file($tmpName,'productImage/'.$file);
              unlink('../uploaded_img/'.$old_image);
             }
            $insertProduct['message']="Product Update";
           }

       }
       echo json_encode($insertProduct);



 
  


}


?>