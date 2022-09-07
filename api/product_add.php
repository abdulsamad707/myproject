<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header("Content-Type:application/json");
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
include ("function.php");
include ("validkey.php");
ob_start();

if (!isset($status))
{

    $userdata = file_get_contents("php://input");

    $productData = $_POST;
   
     extract($productData);

    $productData['name'] = $productName;
    $productData['productStatus'] = 1;
    unset($productData['productName']);
    unset($productData['action']);
    $sql_check_product = "SELECT * FROM products WHERE name='$productName'";
    $sql_check_product_data = $data->sql($sql_check_product, "read");

    $totalProduct = $sql_check_product_data['totalRecord'];
    if($pid== "")
    {
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $tmpName = $_FILES['file']['tmp_name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $file = rand() . "." . $ext;
        $productData['image'] = $file;
           if($totalProduct==0){
            unset($productData['pid']);
        $insertProduct = $data->insert("products", $productData);
        $insertProduct['message'] = "Product Added Into The Store Successfully";
        
        move_uploaded_file($tmpName, 'productImage/' . $file);
           }else{
            $insertProduct['message'] = "Product Already Exists";
           }

    }
    else
    {

        $sql_check_product = "SELECT * FROM products WHERE id='$pid'";
        $sql_check_product_data = $data->sql($sql_check_product, "read");
          $image_old=$sql_check_product_data['data'][0]['image'];
          
      
            
            if (isset($_FILES['file']['name']))
            {
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $tmpName = $_FILES['file']['tmp_name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $file = rand() . "." . $ext;
                $productData['image'] = $file;
                 move_uploaded_file($tmpName, 'productImage/' . $file);
                unlink('productImage/'.$image_old);
            }
            else
            {
                $productData['image'] = $image_old;

            }
              unset($productData['pid']);
            $data_update = $data->updateData("products", $productData, ["id" => "'$pid'"]);
        
            $insertProduct['message'] = "Product Updated";
     

 
         

    }
    echo json_encode($insertProduct);

}

?>