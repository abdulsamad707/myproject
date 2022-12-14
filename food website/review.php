<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = 0;

};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

    $review = $_POST['msg'];
    $review = filter_var($review, FILTER_SANITIZE_STRING);
     $post_checkout['review']=$review;
    $post_checkout['name']=$name;
    $post_checkout['email']=$email;
    $post_checkout['number']=$number;
    $post_checkout['status']=0;
    $post_checkout['action']="review";
   $post_data=json_encode($post_checkout);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/contact.php?key=6CU1qSJfcs");
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
   curl_setopt($ch, CURLOPT_FAILONERROR, true); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $server_output_order = curl_exec($ch);

   $server_output_order=json_decode($server_output_order,true);


   $message[]="Review Sent Successfully";


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Review</title>

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
   <h3>Review</h3>
   <p><a href="home.php">home</a> <span> / review</span></p>
</div>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">
      
  

      <form action="" method="post">
         <h3>tell us something!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="enter your number" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required>
         <textarea name="msg" class="box" required placeholder="enter your review" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="send review" name="send" class="btn">
      </form>

   </div>

</section>

<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>