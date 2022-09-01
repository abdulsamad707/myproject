<?php

include 'components/connect.php';
include  'components/function.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];


       
        
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/carts.php?key=6CU1qSJfcs&user_id=$user_id");
        $header[]="Content-Type:applictaion/json";
        curl_setopt($ch,CURLOPT_POST,false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result_cart_number=curl_exec($ch);
        $result_cart_number=json_decode($result_cart_number,true);
          $totalCartItem=$result_cart_number['totalRecord'];
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if(  $totalCartItem > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
          unset($_POST['submit']);
         $post_orders=$_POST;
         $post['user_id']=$user_id;
         $post_orders=json_encode($post_orders);
           $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/checkout.php?key=6CU1qSJfcs");
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $post_orders);
         curl_setopt($ch, CURLOPT_FAILONERROR, true); 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $server_output_order = curl_exec($ch);
         $server_output_order = json_decode($server_output_order,true);
       
           extract($server_output_order);
     
          if($code==200){
            echo $insertId;
          }
         die();
         $ch = curl_init();

         $delete_data["user_id"]=$user_id;
         $delete_data=json_encode($delete_data);
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/delete_cart.php?key=6CU1qSJfcs");
   curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE" );                                                                                                                 
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $delete_data);
   curl_setopt($ch, CURLOPT_FAILONERROR, true); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $delete_server_output = curl_exec($ch);
      /*   $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);*/

         $message[] = 'order placed successfully!';
    
      }
      
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

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
   <h3>checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">order summary</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>cart items</h3>
      <?php
      


    


         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
           
         $ch=curl_init();
         curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/carts.php?key=6CU1qSJfcs&user_id=$user_id");
         $header[]="Content-Type:applictaion/json";
         curl_setopt($ch,CURLOPT_POST,false);
         curl_setopt($ch, CURLOPT_FAILONERROR, true); 
         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
         $result_cart=curl_exec($ch);
         $result_cart=json_decode($result_cart,true);
            foreach($result_cart['data'] as $fetch_cart){
               $cart_items[] = $fetch_cart['product_name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['product_name']; ?></span><span class="price">Rs<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         
      ?>
      <p class="grand-total"><span class="name">grand total :</span><span class="price">Rs<?= $grand_total; ?></span></p>
      <a href="cart.php" class="btn">veiw cart</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
   <input type="hidden" name="user_id" value="<?= $user_id?>">
   <div class="user-info">
      <h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <h3>delivery address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="cash on delivery" selected>cash on delivery</option>
         <option value="credit card">credit card</option>
         <option value="paytm">paytm</option>
         <option value="paypal">paypal</option>
      </select>
      <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>