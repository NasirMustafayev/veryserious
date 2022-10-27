<?php
require_once('connect.php');
include'functions.php';
session_start();
$cid = clear($_GET['cid']);

$querypost = $db->query("SELECT * FROM comments WHERE id='$cid'");
$fetch = $querypost->fetch(PDO::FETCH_ASSOC);
$userid = $fetch['user_id'];

if ($_SESSION['userid']==1 || $userid==$_SESSION['userid']) {

	$deletecomment = $db->query("DELETE FROM comments WHERE id='$cid'");
	?>
	<script type="text/javascript">
		window.location.href = "../<?php echo $_GET['plink'];?>?r=cd";
	</script>
<?php }
else{
	?>
	<script type="text/javascript">
		window.location.href = "../pff.php";
	</script>
<?php }
?>