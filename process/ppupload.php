<?php
require_once('connect.php');
include'functions.php';
session_start();

$userid = $_SESSION['userid'];
$query = $db->query("SELECT * FROM users WHERE id='$userid'");
$fetch = $query->fetch(PDO::FETCH_ASSOC);

$querypp = $db->query("SELECT profilephoto FROM users WHERE id='$userid'");
$fetchpp = $querypp->fetch(PDO::FETCH_ASSOC);
$oldphoto = $fetchpp['profilephoto'];

$account = $fetch['account'];
$destinationfolder = '../imgs/users/pp';
$picture = $_FILES["ppicture"]["name"];

if ($_FILES['ppicture']['size']>2010000) { ?>
	<br/><span class="info">-File size too big(until 1mb)</span>
	<?php
	exit;
}

$authorizedtype=array('jpg','jpeg','png','gif','bmp');
$findtype=strtolower(substr( $_FILES["ppicture"]["name"], strpos( $_FILES["ppicture"]["name"],'.')+1));

if (in_array($findtype, $authorizedtype)===false) { ?>
	<br/><span class="info">-File type doesnt allow(only jpg,jpeg,png,bmp)</span>
	<?php
	exit;
}
unlink("../$oldphoto");

$rand = rand(100,9999);
$ppicture=substr($destinationfolder, 3)."/".$userid.$account.$rand.$picture;


move_uploaded_file($_FILES["ppicture"]["tmp_name"], $destinationfolder.'/'.$userid.$account.$rand.$picture);

$update = $db->query("UPDATE users SET profilephoto='$ppicture' WHERE id='$userid'");

if (!$update) { ?>
	<br/><span class="info">-Something went wrong</span>
<?php }
else{ ?>
	<script>
		location.reload();
	</script>
<?php }
?>