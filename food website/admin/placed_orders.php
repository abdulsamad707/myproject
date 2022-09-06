<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
  
   $ch=curl_init();
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_order.php?key=6CU1qSJfcs");
   curl_setopt($ch, CURLOPT_POST, 1);
       unset($_POST['update_payment']);
       $product_data=json_encode($_POST);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $product_data);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $server_product_add=curl_exec($ch);
     $server_product_add=json_decode($server_product_add,true);
     $server_product_add['message']="Order Status Updated";


   


   $message[] = $server_product_add['message'];

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- placed orders section starts  -->

<section class="placed-orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/orders.php?key=6CU1qSJfcs");
$header[]="Content-Type:applictaion/json";
curl_setopt($ch,CURLOPT_POST,false);
curl_setopt($ch, CURLOPT_FAILONERROR, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result=curl_exec($ch);
$result= json_decode($result,true);

 $totaLOrder=$result['totalRecord'];



 
      if($totaLOrder >  0){
        foreach ($result['data'] as $fetch_orders ){
   ?>
   <div class="box">
      <p> Order id : <span><?= $fetch_orders['id']; ?></span> </p>
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="<?= $fetch_orders['payment_status']; ?>" selected ><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update_payment">
           
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>

   </div>

</section>

<!-- placed orders section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>