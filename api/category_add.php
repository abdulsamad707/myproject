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



    extract($_POST);

    $productData['cat_name'] = $cat_name;
    $productData['cat_status'] = 1;
   
    unset($productData['action']);

    if ($cat_id=='')
    {
        $sql_check_category="SELECT * FROM categories WHERE cat_name = '$cat_name' or  cat_name like '%$cat_name%'";
        $sql_check_category_data=$data->sql($sql_check_category,"read");
        $total_category_found=$sql_check_category_data['totalRecord'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $tmpName = $_FILES['file']['tmp_name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $file = rand() . "." . $ext;
        $productData['cat_image'] = $file;
        if($total_category_found==0){
        unset($productData['cat_id']);
        $insertProduct = $data->insert("categories", $productData);
        move_uploaded_file($tmpName, 'categoryImage/' . $file);
        $insertProduct['message'] = "Category Added Into The Store Successfully";
        }else{
         $insertProduct['message'] = "Category Already Exists";
        }
       

    }
    else
    {


        $sql_check_product="SELECT * FROM categories WHERE id = '$cat_id' ";
        $sql_check_product_data = $data->sql($sql_check_product, "read");
    
    

            $image_old = $sql_check_product_data['data'][0]['cat_image'];
            $product_id = $sql_check_product_data['data'][0]['id'];
            if (isset($_FILES['file']['name']))
            {
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $tmpName = $_FILES['file']['tmp_name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $file = rand() . "." . $ext;
                $productData['cat_image'] = $file;
                 move_uploaded_file($tmpName, 'categoryImage/' . $file);
                unlink('categoryImage/'.$image_old);
            }
            else
            {
                $productData['cat_image'] = $image_old;

            }
            unset($productData['cat_id']);
            $data_update = $data->updateData("categories", $productData, ["id" => "'$product_id'"]);
        
            $insertProduct['message'] = "category Updated";
     

 
        

    }
    echo json_encode($insertProduct);

}

?>