<?php

include 'components/connect.php';
include  'components/function.php';
session_start();
$ipd_add=get_client_ip();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
   exit;
   die();
};

if(isset($_POST['delete'])){

   $cart_id = $_POST['cart_id'];
   $delete_array['cart_id']=$cart_id;
   $delete_data=json_encode($delete_array);
   $ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/delete_cart.php?key=6CU1qSJfcs");
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE" );                                                                                                                 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $delete_data);
curl_setopt($ch, CURLOPT_FAILONERROR, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$delete_server_output = curl_exec($ch);
    
$delete_server_output= json_decode($delete_server_output,true);

$messagedelete=$delete_server_output['message'];


$message[]=$messagedelete;

  /* $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';*/
}

if(isset($_POST['delete_all'])){
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
     
   $delete_server_output= json_decode($delete_server_output,true);
   
   $messagedelete=$delete_server_output['message'];

   // header('location:cart.php');
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
  $update_data['ip_add']= $ipd_add;
  $quantity=$_POST["qty"];
 
  $update_data["quantity"]=$quantity;
  $pid=$_POST['pid'];
  $update_data["pid"] =$pid;
  $update_data["user_id"]=$user_id;
  $update_data["action"]="update";
  $update_data=json_encode($update_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_add_cart.php?key=6CU1qSJfcs");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $update_data);
curl_setopt($ch, CURLOPT_FAILONERROR, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
$server_output=json_decode($server_output,true);
$messageupdate=$server_output['message'];

$message[]=$messageupdate;


}                                                   

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

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
   <h3>shopping cart</h3>
   <p><a href="home.php">home</a> <span> / cart</span></p>
</div>

<!-- shopping cart section starts  -->

<section class="products">

   <h1 class="title">your cart</h1>

   <div class="box-container">

      <?php
 $ch=curl_init();
 curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/carts.php?key=6CU1qSJfcs&user_id=$user_id");
 $header[]="Content-Type:applictaion/json";
 curl_setopt($ch,CURLOPT_POST,false);
 curl_setopt($ch, CURLOPT_FAILONERROR, true); 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 $result=curl_exec($ch);
 
 $result=json_decode($result,true);
 


         $grand_total = 0;
        foreach($result["data"] as $fetch_cart){
         $product_image_path=PRODUCT_IMAGE_PATH."/".$fetch_cart['product_image'];
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
         <img src="<?= $product_image_path ?>" alt="">
         <div class="name"><?= $fetch_cart['product_name']; ?></div>
         <div class="flex">
            <div class="price"><span>Rs</span><?= $fetch_cart['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
              <input type="hidden" name="pid" value="<?php echo $fetch_cart['pid']?>" >
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div class="sub-total"> sub total : <span>Rs<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         
      ?>

   </div>

   <div class="cart-total">
      <p>cart total : <span>Rs<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
      </form>
      <a href="menu.php" class="btn">continue shopping</a>
   </div>

</section>

<!-- shopping cart section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>