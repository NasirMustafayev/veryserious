<?php
require_once("header.php");
include'process/functions.php';
if (empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
	exit;
}

if (isset($_GET['nn'])) {
	$nn = clear($_GET['nn']);
	$queryuser = $db->query("SELECT * FROM users WHERE account='$nn'");
	$count = $queryuser->rowCount();
	if ($count==0) { ?>
		<script type="text/javascript">
			window.location.href = "nopage.php";
		</script>
	<?php }
}
else{
	$userid = $_SESSION['userid'];
	$queryuser = $db->query("SELECT * FROM users WHERE id='$userid'");
}
$fetchuser = $queryuser->fetch(PDO::FETCH_ASSOC);
$thisuserid = $fetchuser['id'];
$querypost = $db->query("SELECT * FROM posts WHERE user_id='$thisuserid' ORDER BY postdate DESC");

$title="Veryseriou.us - ".$fetchuser['nickname']." | posts";
if (isset($title)) { ?>
	<head><title><?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>
<body>
	<div class="container">
		<h4 class="owltop">Latest posts <?php echo $fetchuser['nickname']; ?></h4>
		<div class="row posts">
			<?php
			foreach ($querypost as $value) { ?>
				<div class="col-md-3 news">
					<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">
						<img src="<?php echo $value['postthumb'] ?>" class="img-thumbnail" style="width:240px;height: 150px">
						<h6 style="width: 240px"><?php echo (strlen($value['posttitle'])>64) ? substr($value['posttitle'],0,64)."..." : $value['posttitle']; ?></h6>
						<span style="float: left;"><?php echo $value['postview']." views | ".timeConvert($value['postdate']); ?></span>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
<footer>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
</footer>
</html>