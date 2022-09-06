<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $logindata['name']=$name;
    $logindata['password']=$pass;
     $logindata=json_encode($logindata);
    
       $ch = curl_init();
   
  curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/admin_login.php?key=6CU1qSJfcs");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $logindata);
  curl_setopt($ch, CURLOPT_FAILONERROR, true); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output_login=curl_exec($ch);
  $server_output_login=json_decode($server_output_login,true);
 
       $id=$server_output_login['id'];
       $messages_admin=$server_output_login['message'];
       if($id==0){
         $message[]=$server_output_login['message'];
     
       }else{
         $_SESSION['admin_id'] = $id;
         header('location:dashboard');
         die();
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
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- admin login form section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>login now</h3>
     <!-- <p>default username = <span>admin</span> & password = <span>111</span></p>-->
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<!-- admin login form section ends -->











</body>
</html>