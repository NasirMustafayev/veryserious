<?php
require_once('connect.php');
include'functions.php';
session_start();
$userid= $_SESSION['userid'];
$pid = clear($_POST['postid']);

if (empty($userid)) { ?>
	<script type="text/javascript">
		window.location.href = "../post/<?php echo $pid."/".$fetch['seotitle']; ?>";
	</script>
	<?php
	exit;
}

if (empty($_POST['comment'])) { ?>
	<script type="text/javascript">
		window.location.href = "../post/<?php echo $pid."/".$fetch['seotitle']; ?>";
	</script>
	<?php
	exit;
}

$comment = clear($_POST['comment']);

$query = $db->query("SELECT seotitle FROM posts WHERE id = '$pid'");
$fetch = $query->fetch(PDO::FETCH_ASSOC);

$insert = $db->query("INSERT INTO comments(post_id,user_id,comment) VALUES('$pid','$userid','$comment')");

if($insert) {
	?>
	<script type="text/javascript">
		window.location.href = "../post/<?php echo $pid."/".$fetch['seotitle']; ?>";
	</script>
<?php }
?>