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

    unset($_POST['action']);
    if(isset($_FILES)){
        print_r($_FILES);

    }
       extract($productData);

           
       echo $cat_name;
       $sql_category_check="SELECT * FROM categories WHERE cat_name='$cat_name' OR cat_name like '%$cat_name%'";
       $sql_category_check_data=$data->sql($sql_category_check,"read");
       print_r($sql_category_check_data);
}
?>