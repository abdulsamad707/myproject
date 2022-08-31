<?php

if(isset($_SESSION['admin_id'])){
echo $welcomeMsg="Helloworld";
}else{
    header('location:dashboard.php');
}
?>