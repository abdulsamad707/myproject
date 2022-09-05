<?php

$db_name = 'mysql:host=localhost;dbname=food_db';
$user_name = 'root';
$user_password = '';
define("PRODUCT_IMAGE_PATH","http://localhost/project/api/productImage");
$conn = new PDO($db_name, $user_name, $user_password);

?>