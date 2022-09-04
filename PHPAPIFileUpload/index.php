<?php
if(isset($_POST['submit'])){
	$url="api_link/index.php";
	$name=$_FILES['file']['name'];
	$tmp_name=$_FILES['file']['tmp_name'];
	$type=$_FILES['file']['type'];
	$ch=curl_init();
	$data=array("file"=>curl_file_create($tmp_name,$type,$name));
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:multipart/form-data'));
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	
	$result=curl_exec($ch);
	$result=json_decode($result,true);
	echo $result['msg'];
}
?>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="file" required/>
	<input type="submit" name="submit"/>
</form>