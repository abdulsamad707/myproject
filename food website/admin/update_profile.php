<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   unset($_POST['submit']);
  
       $dataPost=$_POST;
       $dataPost['id']=$admin_id;
       $dataPost=json_encode($dataPost);

       $ch=curl_init();
       /*curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs");*/
       curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_admin_profile.php?key=6CU1qSJfcs");
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $server_product_add=curl_exec($ch);
       $server_product_add=json_decode($server_product_add,true);
       $message[]=$server_product_add['message'];






 

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin profile update section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>update profile</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>

<!-- admin profile update section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>