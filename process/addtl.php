<?php
require_once('connect.php');
include'functions.php';
session_start();
$pid = clear($_POST['pid']);

$tubelink = clear($_POST['tubelink']);
if (empty($_POST['tubelink'])) {

}
else{
	$update = $db->query("UPDATE posts SET tubelink='$tubelink' WHERE id='$pid'");
	if (!$update) {
		?>
		<span class="info">-Somethink went wrong!</span>
	<?php }
}
if (empty($_POST['tags'])) { ?>
	<script type="text/javascript">
		window.location.href = "../index.php?p=s";
	</script>
	<?php
	exit;
}
else{
	$tags = $_POST['tags'];

	$querypost = $db->query("SELECT * FROM posts WHERE id='$pid'");
	$fetch = $querypost->fetch(PDO::FETCH_ASSOC);
	$userid = $fetch['user_id'];

	if($userid!=$_SESSION['userid']){?>
		<script type="text/javascript">
			window.location.href = "addpost.php";
		</script>
		<?
		exit;
	}

	foreach ($tags as $value) {
		$cleartags = clear($value);
		if (isset($tags)) {
			$insert = $db->query("INSERT INTO tags(tag,post_id) VALUES('$cleartags','$pid')");
			if (!$insert) {
				?>
				<span class="info">-Somethink went wrong!</span>
			<?php }
		}
	}
}
?>
<script type="text/javascript">
	window.location.href = "../index.php?p=s";
</script>