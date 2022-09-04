<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   header('location:home.php');
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass=$_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass =$_POST['cpass'];
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);



  
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
              $pass=md5($pass);
              $pass=sha1($pass);
          $pass=password_hash($pass,PASSWORD_BCRYPT,["cost"=>12]);
           $register_array['name']=$name;
           $register_array['email']=$email;
           $register_array['number']=$number;
           $register_array['password']=$pass;
           $post_register_array=json_encode($register_array);
      
           
           $ch = curl_init();
            
           curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/userregister.php?key=6CU1qSJfcs");
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $post_register_array);
           curl_setopt($ch, CURLOPT_FAILONERROR, true); 
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $server_output_register=curl_exec($ch);
           $server_output_register=json_decode($server_output_register,true);
         
       
      
         $message[] =$server_output_register['message'] ;
         
      }
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="enter your number" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>