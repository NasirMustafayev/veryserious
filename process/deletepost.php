<?php
require_once('connect.php');
include'functions.php';
session_start();
$pid = clear($_GET['pid']);

$querypost = $db->query("SELECT * FROM posts WHERE id='$pid'");
$fetch = $querypost->fetch(PDO::FETCH_ASSOC);
$userid = $fetch['user_id'];

if ($userid==$_SESSION['userid'] || $_SESSION['userid']==1) {

	$postthumb = $fetch['postthumb'];
	unlink("../$postthumb");
	$deletepost = $db->query("DELETE FROM posts WHERE id='$pid'");

	$querypp = $db->query("SELECT * FROM postphotos WHERE post_id='$pid'");

	while($fetchpp = $querypp->fetch(PDO::FETCH_ASSOC)){
		$postphoto = $fetchpp['postphoto'];
		unlink("../$postphoto");
		$postid = $fetchpp['post_id'];

		$deletepp = $db->query("DELETE FROM postphotos WHERE post_id='$pid'");
	} ?>
	<script type="text/javascript">
		window.location.href = "../index.php?s=del";
	</script>
<?php }

else{ ?>
	<script type="text/javascript">
		window.location.href = "../pff.php";
	</script>
<?php }
?>

