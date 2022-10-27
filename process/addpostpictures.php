<?php
require_once('connect.php');
include'functions.php';
session_start();

if (isset($_FILES)) {
	$destinationfolder = '../imgs/posts';
	$file = $_FILES["file"]["name"];
	$pid = $_POST['pid'];

	if ($_FILES['file']['size']>2010000) {
		echo " <meta http-equiv='refresh' content='0;URL=../addpostpt.php?r=s'>"; 
		exit;
	}

	$authorizedtype=array('jpg','jpeg','png','gif','bmp');

	$findtype=strtolower(substr( $_FILES['file']["name"], strpos( $_FILES['file']["name"],'.')+1));

	if (in_array($findtype, $authorizedtype)===false) {
		echo " <meta http-equiv='refresh' content='0;URL=../addpostpt.php?r=t'>"; 
		exit;
	}

	$rand = rand(100,99999);
	$files=substr($destinationfolder, 3)."/".$pid.$rand.$file;


	move_uploaded_file($_FILES["file"]["tmp_name"], $destinationfolder.'/'.$pid.$rand.$file);

	$insert = $db->query("INSERT INTO postphotos(post_id,postphoto) VALUES('$pid','$files')");

}
?>