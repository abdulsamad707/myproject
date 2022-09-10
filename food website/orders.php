<?php

include 'components/connect.php';
include 'components/function.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>orders</h3>
   <p><a href="html.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
          
         $ch=curl_init();
         curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/orders.php?key=6CU1qSJfcs&user_id=$user_id");
         $header[]="Content-Type:applictaion/json";
         curl_setopt($ch,CURLOPT_POST,false);
         curl_setopt($ch, CURLOPT_FAILONERROR, true); 
         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
         $result_orders=curl_exec($ch);
         $result_orders=json_decode($result_orders,true);
         $totalOrder=$result_orders['totalRecord'];
   

      
   
      
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($totalOrder >0){
            foreach($result_orders['data'] as $fetch_orders){
   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>Rs <?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> order status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?>
      <?php if($fetch_orders['payment_status'] == 'pending'){
         ?>

         <a href="cancel?order_id=<?=$fetch_orders['id'];?>" class="delete-btn">Cancel</a>
         <?php
      }?>
   </span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>