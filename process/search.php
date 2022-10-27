<?php
require_once('connect.php');
include'functions.php';
include'timeconvert.php';
session_start();

if (isset($_POST['query'])) {
	if (strlen($_POST['query'])>=3) {
		$searchtext = clear($_POST['query']);

		$queryuser = $db->query("SELECT * FROM users WHERE nickname LIKE '$searchtext%' OR account LIKE '$searchtext%'");
		$querypost = $db->query("SELECT * FROM posts WHERE posttitle LIKE '%$searchtext%' ORDER BY postdate DESC");
		$countuser = $queryuser->rowCount();
		$countpost = $querypost->rowCount();
		$overall = $countuser+$countpost;
		?>
		<div class="row">
			<h4 style="color: #11A9E1;">Results</h4><span style="font-size: 12px;color: #11A9E1"><?php echo $overall; ?></span>
		</div>
		<?php 
		if ($countuser>0) { ?>
			<div class="row">
				<?php
				while($showuser =$queryuser->fetch(PDO::FETCH_ASSOC)){
					?>
					<div class="col-md profilebox rounded">
						<a href="<?php echo $showuser['account']; ?>"><img src="<?php echo ($showuser['profilephoto']) ? $showuser['profilephoto'] : 'imgs/user3.jpg';?>" class="cmbimg"><h5><?php echo $showuser['nickname']; ?></h5></a>
					</div>
				<?php }
				?>
			</div>
			<?php 
		}

		elseif ($countpost>0) { ?>
			<div class="row posts">
				<?php
				foreach ($querypost as $value) {
					$pid = $value['id'];
					$querytag = $db->query("SELECT * FROM tags WHERE post_id='$pid'");
					$fetchtag = $querytag->fetch(PDO::FETCH_ASSOC);

					$authorid= $value['user_id'];
					$queryauthor = $db->query("SELECT * FROM users WHERE id='$authorid'");
					$fetchauthor = $queryauthor->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="col-sm-2 news <?php echo($fetchtag['tag']==$fetchht['hottag']) ? "hotnew" : "" ?>">
						<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>">
							<img src="<?php echo $value['postthumb'] ?>" class="<?php echo($fetchtag['tag']==$fetchht['hottag']) ? "rounded" : "img-thumbnail" ?>" style="width:200px;height: 110px">
							<h6 style="width: 180px"><?php echo (strlen($value['posttitle'])>48) ? substr($value['posttitle'],0,48)."..." : $value['posttitle']; ?></h6>
							<span style="float: left;"><img class="vsmallpp rounded-circle" src="<?php echo ($fetchauthor['profilephoto']) ? $fetchauthor['profilephoto'] : 'imgs/user3.jpg';?>"> <?php echo $value['postview']." views | ".timeConvert($value['postdate']); ?></span>
						</a>
					</div>
				<?php } ?>
			</div>
		<?php }
	}
}
?>