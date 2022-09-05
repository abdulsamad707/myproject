<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);


   $image_name= $_FILES['image']['name'];

   $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_type= $_FILES['image']['type'];
   $image_folder = '../uploaded_img/'.$image_name;
   $cf = new CURLFile($image_tmp_name,$image_type,$image_name);

  $dataProduct=$_POST;
  $file=$_FILES;
  $ch=curl_init();
  $file_data=array("file"=>$cf,"productName"=>$name,'price'=>$price,'category'=>$category);

 
/*

  */
  curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/product_add.php?key=6CU1qSJfcs");

  curl_setopt($ch, CURLOPT_POST, 1);

  $header=array('Content-Type:multipart/form-data'); 
 /* curl_setopt($ch,CURLOPT_HTTPHEADER,$header);*/
  curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


  


  

      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
   
         $server_product_add=json_decode(curl_exec($ch),true);

        
         $messages=$server_product_add['message'];
         $message[]=$messages;
      }

   

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['update_status'];
   
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs");

   curl_setopt($ch, CURLOPT_POST, 1);
     $product_data['product_id']=$_GET['update_status'];
   curl_setopt($ch, CURLOPT_POSTFIELDS, $product_data);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   /*$server_product_add=json_decode(curl_exec($ch),true);
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);*/
   
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

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
      <h3>add product</h3>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>select category --</option>
         <option value="main dish">main dish</option>
         <option value="fast food">fast food</option>
         <option value="drinks">drinks</option>
         <option value="desserts">desserts</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
 $ch=curl_init();
 curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/products.php?key=6CU1qSJfcs");
 $header[]="Content-Type:applictaion/json";
 curl_setopt($ch,CURLOPT_POST,false);
 curl_setopt($ch, CURLOPT_FAILONERROR, true); 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 $result=curl_exec($ch);
 $result= json_decode($result,true);
 

   
      if($result['productData']['totalRecord'] > 0){
         foreach($result['productData']['data'] as $fetch_products){  

           $image_Path= PRODUCT_IMAGE_PATH."/".$fetch_products['image'];
   ?>
   <div class="box">
      <img src="<?=$image_Path; ?>" alt="">
      <div class="flex">
         <div class="price"><span>Rs </span><?= $fetch_products['price']; ?><span>/-</span></div>
         <div class="category"><?= $fetch_products['category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>


         <?php
     echo    $statusProduct= $fetch_products['productStatus'];
              if($statusProduct!=1){
              $btnClass= "delete-btn";
              $btnClassAct="Inactive";
              }else{
               $btnClass= "active-btn";
               $btnClassAct="Active";
              }
           ?>
         
         <a href="products.php?update_status=<?= $fetch_products['id']; ?>" class="<?=$btnClass; ?>" onclick="return confirm('update the statius of product?');"><?= $btnClassAct;?></a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>