<?php 
require_once('header.php');

$query = $db->query("SELECT * FROM posts ORDER BY postdate DESC limit 8");
$queryft = $db->query("SELECT * FROM posts ORDER BY postview DESC limit 10");
$queryfm = $db->query("SELECT * FROM posts ORDER BY postview DESC limit 10");

$hottag = $db->query("SELECT * FROM hottag WHERE id='1'");
$fetchht = $hottag->fetch(PDO::FETCH_ASSOC);
?>
<head><title>Veryserio.us</title></head>
<body>
	<div class="container">
		<div class="row owltop">

			<div class="col-md owl-carousel owl-theme" id="owltop">
				<?php 
				foreach ($queryft as $value) {
					?>
					<div class="item">
						<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>"><img alt="example" src="<?php echo $value['postthumb']; ?>"></a>
					</div>
				<?php } ?>
			</div>

		</div>
	</div>
	<div class="container">
		<?php
		if (isset($_SESSION['userid'])) {
			?>
			<div class="row">
				<div class="col-md-12 text-center">
					<a href="addpost.php" class="bluebuttonadd"><img src="css/plus.png"> Add post</a>
				</div>
			</div>
		<?php }
		if ($_GET['p']==s) { ?>
			<div class="row">
				<div class="col-md text-center success rounded">
					<h6>Your post succesfully sharing</h6>
				</div>
			</div>
		<?php }
		?>
		<div class="row">
			<div class="col-md tags text-center">
				<h6 class="hot rounded">Hot tag: <a href="latest.php?ht=<?php echo $fetchht['hottag']; ?>" class="rounded">&#128293;<?php echo $fetchht['hottag']; ?></a></h6>
			</div>
			<div class="col-md-12 text-center">
				<form id="sform">
					<label for="searchtext"><img style="width: 16px;height: 16px" src="imgs/glass.png"/></label>
					<input type="text" name="searchtext" id="searchtext" class="searchinput rounded text-center" placeholder="Type here..(peoples,posts)">
				</form>
			</div>
		</div>
		<div id="result"></div>
		<div class="row">
			<div class="col-md owl-carousel owl-theme owlmid rounded" id="owlmid">
				<?php
				while($value = $queryfm->fetch(PDO::FETCH_ASSOC)) {
					$pid = $value['id'];
					$querypt = $db->query("SELECT * FROM tags WHERE post_id='$pid'");
					$fetchpt = $querypt->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="item owlmid">
						<div class="col-md-6">
							<span style="font-size: 10px"><?php echo($value['user_id']==$userid) ? $value['postview']." views " : ""; echo "🕘".timeConvert($value['postdate']); ?></span>
							<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">
								<img src="<?php echo $value['postthumb']; ?>" class="float-left rounded"/>
							</a>
						</div>
						<div class="col-md">
							<h5 class="mt-0"><?php echo (strlen($value['posttitle'])>50) ? substr($value['posttitle'],0,50)."..." : $value['posttitle']; ?></h5>
							<?php if($fetchpt['tag']==$fetchht['hottag']){ ?>
								<a href="latest.php?ht=<?php echo $fetchht['hottag']; ?>" class="hot rounded" id="tagbtn" style="color: white">&#128293;<?php echo $fetchht['hottag']; ?></a>
							<?php }
							?>
							<br/>
							<h6 style="font-size: 14px;"><?php echo substr($value['post'], 0,155)."..."; ?><a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">See more</a></h6>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<h4 style="color: #11A9E1;">Latest</h4>
		<div class="row posts">
			<?php
			foreach ($query as $value) {
				$pid = $value['id'];
				$querytag = $db->query("SELECT * FROM tags WHERE post_id='$pid'");
				$fetchtag = $querytag->fetch(PDO::FETCH_ASSOC);

				$authorid= $value['user_id'];
				$queryauthor = $db->query("SELECT * FROM users WHERE id='$authorid'");
				$fetchauthor = $queryauthor->fetch(PDO::FETCH_ASSOC);

				?>
				<div class="col-sm-3 news <?php echo($fetchtag['tag']==$fetchht['hottag']) ? "hotnew" : "" ?>">
					<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">
						<img src="<?php echo $value['postthumb'] ?>" class="<?php echo($fetchtag['tag']==$fetchht['hottag']) ? "rounded" : "rounded" ?>" style="width:240px;height: 150px">
						<h6 style="width: 240px"><?php echo (strlen($value['posttitle'])>64) ? substr($value['posttitle'],0,64)."..." : $value['posttitle']; ?></h6>
						<span style="float: left;"><img class="smallpp rounded-circle" src="<?php echo ($fetchauthor['profilephoto']) ? $fetchauthor['profilephoto'] : 'imgs/user3.jpg';?>"><?php echo($value['user_id']==$userid) ? $value['postview']." views|" : " "; echo timeConvert($value['postdate']); ?></span>
					</a>
				</div>
			<?php } ?>

			<div class="col-md-12 text-center">
				<a href="latest.php">
					<button class="morebtn">
						Show more
					</button>
				</a>
			</div>

		</div>

	</div>
</body>

<?php
include"footer.php";

?>