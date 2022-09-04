<?php

$con=mysqli_connect('localhost','username','password','dbname');
if($_FILES['file']['name']==''){
    $msg="Please provide file";
}else{
    $ext=strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
    if($ext=='jpg' || $ext=='jpeg'){
        $file=rand(111111111,999999999).'.'.$ext;
        move_uploaded_file($_FILES['file']['tmp_name'],'media/'.$file);  
        $added_on=date('Y-m-d h:i:s');
        mysqli_query($con,"insert into api_images(image,added_on) values('$file','$added_on')");
        $msg="File uploaded";
    }else{
        $msg="Please provide only jpeg or jpg file";
    }
}
echo json_encode(array('msg'=>$msg));
?>