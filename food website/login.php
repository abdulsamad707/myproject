<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass=md5($pass);
    $pass=sha1($pass);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
  $login_array['email']=$email;
  $login_array['password']=$pass;

  $post_data=json_encode($login_array);
  $ch = curl_init();
   
  curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/login_api.php?key=6CU1qSJfcs");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($ch, CURLOPT_FAILONERROR, true); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
  $server_output_login=json_decode(curl_exec($ch),true);
  $id= $server_output_login['id'];
  $status= $server_output_login['status'];
  if($status==1){
  $_SESSION['user_id'] = $id;
  $_SESSION['email'] = $email;
  header('location:home');
  }else{
   $messages=$server_output_login['message'];
   $message[]=$messages;
  }
 



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>