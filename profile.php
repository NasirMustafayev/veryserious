<?php
require_once('header.php');
include'process/functions.php';

if (empty($_GET['nn']) and empty($_SESSION['userid'])) { ?>
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
$queryft = $db->query("SELECT * FROM posts WHERE user_id='$thisuserid' ORDER BY postview DESC");
$countposts = $querypost->rowCount();

$title = $fetchuser['nickname'];

if (isset($title)) { ?>
	<head><title>Veryserio.us - <?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>

<body>

	<div class="container profiletab">

		<div class="row">
			<a href="" class="profileimg"><img src="<?php echo ($fetchuser['profilephoto']) ? $fetchuser['profilephoto'] : 'imgs/user3.jpg';?>" alt=""></a>
			<h5><?php echo $fetchuser['nickname']; ?></h5>
		</div>
		<span style="font-size: 12px;color:gray">accountname: <?php echo $fetchuser['account']; ?></span>
		<div class="row owltop">

			<div class="owl-carousel owl-theme" id="owltop">
				<?php
				foreach ($queryft as $value) {
					?>
					<div class="item"><a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>"><img alt="example" src="<?php echo $value['postthumb']; ?>" style="max-height: 190px"></a></div>
				<?php } ?>
			</div>

		</div>

		<div class="card">

			<div class="row">

				<div class="col-md-2">
					<img src="<?php echo ($fetchuser['profilephoto']) ? $fetchuser['profilephoto'] : 'imgs/user3.jpg';?>" class="card-img rounded" style="max-height: 200px">
				</div>
				<div class="col-md-10">
					<div class="card-body">
						<h5 class="card-title">About <?php echo (isset($_GET['nn'])) ? $fetchuser['nickname'] : "me"; ?></h5>
						<p class="card-text">
							<i>
								<?php
								if($fetchuser['about']){
									echo nl2br($fetchuser['about']);
								}
								else{
									echo "Nothing";
								}
								?>
							</i>
						</p>
					</div>
				</div>
			</div>


		</div>
		<div class="row">
			<h4 style="color: #11A9E1"><?php  echo (isset($_GET['nn'])) ? "Latest posts ".$fetchuser['nickname'] : "My latest posts"; ?></h4><span style="font-size: 12px;color: #11A9E1"><?php echo $countposts." posts"; ?></span>
		</div>
		<div class="row">
			<?php
			if ($countposts==0) {
				echo "<h4 style='color:#11A9E1'>Are you kidding me?</h4>";
			}
			else{
				foreach($querypost as $value){
					?>
					<div class="col-md-3 news">
						<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">
							<img src="<?php echo $value['postthumb'] ?>" class="img-thumbnail" style="width:240px;height: 150px">
							<h6 style="width: 240px"><?php echo (strlen($value['posttitle'])>64) ? substr($value['posttitle'],0,64)."..." : $value['posttitle']; ?></h6>
							<span style="float: left;"><?php echo($value['user_id']==$userid) ? $value['postview']." views|" : " "; echo timeConvert($value['postdate']); ?></span>
						</a>
					</div>
				<?php }
				if (!$countposts>=12) {
					?>
					<div class="col-md-12 text-center">
						<a href="<?php echo($fetchuser['id']==$_SESSION['userid']) ? "userposts.php" : "userposts.php?nn=".$fetchuser['account'];?>">
							<button class="morebtn">
								See more...
							</button>
						</a>
					</div>
				<?php  }} ?>

			</div>
		</div>
	</body>

	<footer>
		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/infinite.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/owl_conf.js"></script>
		<script src="js/darkmode.js"></script>
		<script src="js/darkmodeopt.js"></script>
		<script type="text/javascript">
			$('.posts').infiniteScroll({
  // options
  path: '.pagination__next',
  append: '.news',
  history: false,
});
</script>
</footer>
</html>