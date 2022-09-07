<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login');
};

if(isset($_POST['add_category'])){


     unset($_POST['add_category']);
    

 

   $image_name= $_FILES['image']['name'];

   $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_type= $_FILES['image']['type'];
   $image_folder = '../uploaded_img/'.$image_name;
   $cf = new CURLFile($image_tmp_name,$image_type,$image_name);

  $dataProduct=$_POST;
  $file=$_FILES;
  $ch=curl_init();
  /*
  $file_data=array("file"=>$cf,"productKeyWord"=>$keyword,"productName"=>$name,'price'=>$price,'category'=>$category,"action"=>"add");
     */
$file_data=$_POST;
  $file_data['file']=$cf;
  $file_data["action"]="add";
  $file_data['cat_id']="";
  



 
/*

  */
  curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/category_add.php?key=6CU1qSJfcs");

  curl_setopt($ch, CURLOPT_POST, 1);

  $header=array('Content-Type:multipart/form-data'); 
 /* curl_setopt($ch,CURLOPT_HTTPHEADER,$header);*/
  curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


  


  

      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
       

         $server_product_add=curl_exec($ch);
        
         $server_product_add=json_decode($server_product_add,true);
         $messages=$server_product_add['message'];
         $message[]=$messages;
      }

   

}

if(isset($_GET['update_status'])){

   $delete_id = $_GET['update_status'];
   $status_action=$_GET['status_action'];
   $ch=curl_init();
   /*curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs");*/
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/categoriesStatus.php?key=6CU1qSJfcs");
   curl_setopt($ch, CURLOPT_POST, 1);
     $product_data['product_id']=$_GET['update_status'];
     $product_data['status_action']=$_GET['status_action'];
       $product_data=json_encode($product_data);
       
   curl_setopt($ch, CURLOPT_POSTFIELDS, $product_data);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $server_product_add=curl_exec($ch);
  
/*
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);*/
       
   

     
   header('location:categories');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categories</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css?v=34">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add Category</h3>
      <input type="text" required placeholder="enter category name" name="cat_name" maxlength="100" class="box">
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add Category" name="add_category" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
 $ch=curl_init();
 curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/categories.php?key=6CU1qSJfcs");
 $header[]="Content-Type:applictaion/json";
 curl_setopt($ch,CURLOPT_POST,false);
 curl_setopt($ch, CURLOPT_FAILONERROR, true); 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 $result=curl_exec($ch);
 $result= json_decode($result,true);
 

   
      if($result['productData']['totalRecord'] > 0){
         foreach($result['productData']['data'] as $fetch_products){  


$image_Path=CATEGORY_IMAGE_PATH."/".$fetch_products['cat_image'];
   ?>
   <div class="box">
      <img src="<?=$image_Path; ?>" alt="">
   
      <div class="name"><?= $fetch_products['cat_name']; ?></div>
      <div class="flex-btn">
         <a href="update_category?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>


         <?php
       $statusProduct= $fetch_products['cat_status'];
              if($statusProduct!=1){
              $btnClass= "delete-btn";
              $btnClassAct="Inactive";
              $statusAct=1;
              }else{
               $btnClass= "active-btn";
               $btnClassAct="Active";
               $statusAct=0;
              }
           ?>
         
         <a href="categories?update_status=<?= $fetch_products['id']; ?>&status_action=<?=$statusAct;?>" class="<?=$btnClass; ?>" onclick="return confirm('update the statius of product?');"><?= $btnClassAct;?></a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no Categires added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>