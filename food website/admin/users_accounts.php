<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['update'])){
   $update_id = $_GET['update'];
   $ch=curl_init();
   curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/users.php?key=6CU1qSJfcs&id=$update_id");
   $header[]="Content-Type:applictaion/json";
   curl_setopt($ch,CURLOPT_POST,false);
   curl_setopt($ch, CURLOPT_FAILONERROR, true); 
   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
   $result=curl_exec($ch);

   $result=json_decode($result,true);
  
   $old_status=$result['data'][0]['status'];
   if($old_status==1){
      $newStatus=0;
    }else{
      $newStatus=1;
    }
     $update_user['id']=$update_id;
     $update_user['status']=$newStatus;
     $update_user=json_encode($update_user);
     $ch=curl_init();
     /*curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/productsDetail.php?key=6CU1qSJfcs");*/
     curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api/update_users.php?key=6CU1qSJfcs");
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $update_user);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $server_product_add=curl_exec($ch);

   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- user accounts section starts  -->

<section class="accounts">

   <h1 class="heading">users account</h1>

   <div class="box-container">

   <?php
     $ch=curl_init();
     curl_setopt($ch,CURLOPT_URL,"http://localhost/project/api/users.php?key=6CU1qSJfcs");
     $header[]="Content-Type:applictaion/json";
     curl_setopt($ch,CURLOPT_POST,false);
     curl_setopt($ch, CURLOPT_FAILONERROR, true); 
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
     $result=curl_exec($ch);

       $result=json_decode($result,true);
      

     
      if($result['totalRecord'] > 0){
         foreach($result['data'] as $fetch_accounts){  

            if($fetch_accounts['status']==1){
               $btnClass= "btn";
               $btnClassAct="Active";
             }else{
               $btnClass= "delete-btn";
               $btnClassAct="Inactive";
             }
         


   ?>      
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <a href="users_accounts?update=<?= $fetch_accounts['id']; ?>" class="<?=   $btnClass; ?>"><?= $btnClassAct; ?></a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?>

   </div>

</section>

<!-- user accounts section ends -->







<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>