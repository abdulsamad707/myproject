<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $keyword=$_POST['keyword'];

   $ch=curl_init();
   curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs&productId=$pid");
   $header[]="Content-Type:applictaion/json";
   curl_setopt($ch,CURLOPT_POST,false);
   curl_setopt($ch, CURLOPT_FAILONERROR, true); 
   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
   $result=curl_exec($ch);

    if(isset($_FILES['image']['name'])){
   $image_name = $_FILES['image']['name'];

   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_type = $_FILES['image']['type'];

   $image_folder = '../uploaded_img/'.$image_name;
    } 
   if($image_name!=''&& isset($_FILES['image']['name'])){
   $cf = new CURLFile($image_tmp_name,$image_type,$image_name);

   $file_data['file']=$cf;
   } 
   $file_data['productName']=$name;
   $file_data['pid']=$pid;
   $file_data['price']=$price;
   $file_data['category']=$category;
   $file_data["action"]="update";
   $file_data["productKeyWord"]=$keyword;
   $ch=curl_init();
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/product_add.php?key=6CU1qSJfcs");
 
   curl_setopt($ch, CURLOPT_POST, 1);
 
   $header=array('Content-Type:multipart/form-data'); 
  /* curl_setopt($ch,CURLOPT_HTTPHEADER,$header);*/
   curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $server_product_update=curl_exec($ch);
    
    $server_product_update=json_decode($server_product_update,true);
   $messages=$server_product_update['message'];
   $message[]=$messages;


 

   

   
   /*
   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         $ch2=curl_init();
         $file_data=array("file"=>$cf,"productName"=>$name,'price'=>$price,'category'=>$category,"action"=>"add");
       
        
     
         curl_setopt($ch2, CURLOPT_URL,"http://localhost/project/api/product_add.php?key=6CU1qSJfcs");
       
         curl_setopt($ch2, CURLOPT_POST, 1);
       
         $header=array('Content-Type:multipart/form-data'); 
       curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
         curl_setopt($ch2, CURLOPT_POSTFIELDS, $file_data);
         curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    
         $message[] = 'image updated!';
      }
   }*/
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $pid = $_GET['update'];
     
     
      $ch=curl_init();
      curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs&productId=$pid");
      $header[]="Content-Type:applictaion/json";
      curl_setopt($ch,CURLOPT_POST,false);
      curl_setopt($ch, CURLOPT_FAILONERROR, true); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $result=curl_exec($ch);
  
      $result= json_decode($result,true);
         
         foreach($result['data'] as $fetch_products){  
            $image_Path= PRODUCT_IMAGE_PATH."/".$fetch_products['image'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="<?=    $image_Path ; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>update category</span>

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

    ?>
      <select name="category" class="box" required>
         
        
          <?php
            foreach($result['productData']['data'] as $categories ){
            ?>
         <option value="<?=$categories['cat_name']?>"><?= $categories['cat_name'] ?></option>
         
         <?php
            }
          ?>
      </select>
      <input type="text" value="<?=$fetch_products['productKeyWord'];?>" placeholder="KeyWord" name="keyword" maxlength="100" class="box">
      <span>update image</span>

      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>