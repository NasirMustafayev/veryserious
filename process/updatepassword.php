<?php
require_once('connect.php');
include'functions.php';
session_start();

$userid = $_SESSION['userid'];

$lastpass = md5(clear($_POST['lastpass']));
$newpass = md5(clear($_POST['newpass']));
$rnewpass = md5(clear($_POST['rnewpass']));

$queryuser = $db->query("SELECT * FROM users WHERE id='$userid'");
$fetchuser = $queryuser->fetch(PDO::FETCH_ASSOC); 


if ($lastpass!=$fetchuser['password']) { ?>
	❗<span>Last password is incorrect</span>
	<?php 
	exit;
}
elseif(strlen($_POST['newpass'])<6) { ?>
	❗<span>Password must be minimum 6 characters</span>
	<?php 
	exit;
}
elseif ($newpass!=$rnewpass) { ?>
	❗<span>Passwords not the same</span>
	<?php 
	exit;
}
else{
	$query = $db->query("UPDATE users SET password='$newpass' WHERE id='$userid'");
	if ($query) { ?>
		<script type="text/javascript">
			window.location.href = "localhost/sites/veryserious/user?r=p";
		</script>
	<?php }
	else{ ?>
		❗<span>Something went wrong</span>
	<?php }
}
?>