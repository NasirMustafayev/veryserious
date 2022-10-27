<?php
error_reporting(0);
try{

	$db = new PDO("mysql:host=localhost;dbname=veryserious;charset=UTF8","root","");
}
catch(PDOException $error){

	echo "<h2>Database connection interrupted!</h2><br/>";
	echo $error->getMessage();
}
?>