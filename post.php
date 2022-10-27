<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once("process/connect.php");
	include'process/timeconvert.php';
	session_start();

	function urltolink($text){
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		preg_match_all($reg_exUrl, $text, $matches);
		$usedPatterns = array();
		foreach($matches[0] as $pattern){
			if(!array_key_exists($pattern, $usedPatterns)){
				$usedPatterns[$pattern]=true;
				$text = str_replace  ($pattern, "<a href='{$pattern}' target='_blank' rel='nofollow'>{$pattern}</a> ", $text);   
			}
		}
		return $text;            
	}
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<link rel="shortcut icon" href="../../imgs/v.png"/>
	<link rel="stylesheet" type="text/css" href="../../css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/owl.theme.default.min.css">
</head>

<header>
	<nav class="navbar gray navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a href="../../index.php" class="navbar-brand">
			<img src="../../imgs/logo2.png"/ style="width: 140px">
		</a>
		<?php
		if (isset($_SESSION['userid']) or isset($_COOKIE['userid'])) {
			if (isset($_COOKIE['userid'])) {
				$userid = $_COOKIE['userid'];
			}
			else{
				$userid = $_SESSION['userid'];
			}
			$query = $db->query("SELECT * FROM users WHERE id='$userid'");
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			?>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarmenu" aria-controls="navbarmenu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse flex-grow-0 ml-auto bg-dark justify-content-end" id="navbarmenu">
				<ul class="navbar-nav text-right">
					<li class="nav-item dropdown">
						<a href="../../" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="smallpp rounded-circle" src="../../<?php echo ($fetch['profilephoto']) ? $fetch['profilephoto'] : 'imgs/user3.jpg';?>"><?php echo $fetch['nickname']; ?></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a href="../../profile.php" class="dropdown-item">My profile</a>
							<a href="../../user.php" class="dropdown-item">Preferences</a>
							<a href="../../process/logout.php" class="dropdown-item">Log out</a>
						</div>
					</li>
				</ul>
			</div>
			<?
		}
		else{
			?>
			<a href="../../signup.php" role="button" class="bluebuttonsmb ml-auto mr-1" style="width: 80px">Sign up</a>
			<a href="../../signin.php" role="button" class="bluebuttonsm mr-1" style="width: 80px">Sign in</a>
		<?php } ?>
	</nav>
</header>

<?php
$pid = $_GET['pid'];
$query = $db->query("SELECT * FROM posts WHERE id ='$pid'");
$fetch = $query->fetch(PDO::FETCH_ASSOC);
$count = $query->rowCount();
if ($count==0) { ?>
	<script type="text/javascript">
		window.location.href = "nopage.php";
	</script>
	<?php
	exit;
}

$userid = $fetch['user_id'];

$querypp = $db->query("SELECT * FROM postphotos WHERE post_id='$pid'");
$queryuser = $db->query("SELECT * FROM users WHERE id='$userid'");
$fetchuser = $queryuser->fetch(PDO::FETCH_ASSOC);

$querypt = $db->query("SELECT * FROM tags WHERE post_id='$pid'");
$fetchpt = $querypt->fetch(PDO::FETCH_ASSOC);
$posttag = $fetchpt['tag'];

$queryt = $db->query("SELECT * FROM tags WHERE tag='$posttag' AND post_id!='$pid'");
$counttag = $queryt->rowCount();

$hottag = $db->query("SELECT * FROM hottag WHERE id='1'");
$fetchht = $hottag->fetch(PDO::FETCH_ASSOC);

$title = $fetch['posttitle'];

$postviewup = $fetch['postview'];
$postviewup++;
$queryview = $db->query("UPDATE posts SET postview = '$postviewup' WHERE id = '$pid'");

$querycomment = $db->query("SELECT * FROM comments WHERE post_id='$pid'");

if (isset($title)) { ?>
	<head><title><?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>
?>

<body>

	<div class="container">
		<div class="row">
			<div class="col-md post rounded" style="margin-top: 60px">
				<span style="float: right;"><a id="decnone" href="../../latest.php<?php echo($_GET['from']=="lht") ? "?ht=".$fetchht['hottag'] : ""; ?>">&#128473;</a></span>
				<h3 style="margin-bottom: 10px"><?php echo $fetch['posttitle']; ?></h3>
				<span><?php echo($fetch['user_id']==$_SESSION['userid']) ? $fetch['postview']." views " : ""; echo "🕘".timeConvert($fetch['postdate']); ?></span>
				<?php
				if($fetchpt['tag']==$fetchht['hottag']){ ?>
					<a href="../../latest.php?ht=<?php echo $fetchht['hottag']; ?>" class="hot rounded" id="tagbtn">&#128293;<?php echo $fetchht['hottag']; ?></a>
				<?php }
				if ($fetch['user_id']==$_SESSION['userid'] || $_SESSION['userid']==1) { ?>
					<!-- <a id="decnone" href="../../addpostcont.php?pid=<?php echo $pid; ?>">Add images or tags</a> / <a id="decnone" href="../../edpost.php">Edit post</a> /  --> | <a id="decnone" href="../../process/deletepost.php?pid=<?php echo $pid; ?>"><img src="../../imgs/trash.png" style="width: 16px">Delete</a>
				<?php }
				?>
				<div class="owl-carousel owl-theme owlpost" id="owlpost" style="max-width: 700px;margin-bottom: 10px">
					<?php
					foreach ($querypp as $value) {
						?>
						<div class="item">
							<img class="rounded" src="../../<?php echo $value['postphoto'] ?>" style="max-height: 500px">
						</div>
					<?php } ?>
				</div>
				<?php
				if (!$fetch['tubelink']=='') { ?>
					<iframe width="96%" height="350px" src="https://www.youtube.com/embed/<?php echo substr($fetch['tubelink'],-11);?>?rel=0&amp;showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php }
				?>
				<p>
					<?php
					$post = $fetch['post'];
					echo nl2br(urltolink($post));
					?>
					<br/><br/><br/><br/><br/><br/><br/>
				</p>
			</div>

			<div class="col-md-4">
				<div class="author rounded-top"><span class="rounded-left">By:</span><a id="decnone" href="../../<?php echo $fetchuser['account']; ?>"><img class="smallpp rounded-circle" src="../../<?php echo ($fetchuser['profilephoto']) ? $fetchuser['profilephoto'] : 'imgs/user3.jpg';?>"><?php echo $fetchuser['nickname']; ?></a></div>
				<div class="related rounded position-relative">
					<h4>Related</h4>
					<ul class="list-unstyled">
						<?php
						while ($fetchtag = $queryt->fetch(PDO::FETCH_ASSOC))
						{
							$postid = $fetchtag['post_id'];

							$queryrp = $db->query("SELECT * FROM posts WHERE id='$postid'");
							foreach ($queryrp as $value) {
								?>
								<a href="../../post/<?php echo $value['id']."/".$value['seotitle']; ?>">
									<li class="media relatedpost">
										<img src="../../<?php echo $value['postthumb']; ?>" class="mr-3" style="width: 130px;height: 100px">
										<div class="media-body">
											<span style="font-size: 13px"><?php echo (strlen($value['posttitle'])>48) ? substr($value['posttitle'],0,48)."..." : $value['posttitle']; ?></span>
										</div>
									</li>
								</a>
							<?php }
						} ?>
						<span style="font-size: 11px"><?php echo $counttag; ?> related posts</span>
					</ul>
				</div>

				<h4>Comments</h4>
				<div class="cmb rounded">
					<?php
					echo ($_GET['r']=="cd") ? "Your comment has been deleted" : "";
					foreach ($querycomment as $value) {
						$authorid = $value['user_id'];
						$queryca = $db->query("SELECT * FROM users WHERE id='$authorid'");
						$fetchca = $queryca->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="media">
							<img src="../../<?php echo ($fetchca['profilephoto']) ? $fetchca['profilephoto'] : 'imgs/user3.jpg';?>" class="mr-3 smallpp rounded-circle" alt="">
							<div class="media-body">
								<?php echo $value['comment']; ?><br>
								<font size="2" class="mt-0">by:<a href="../../<?php echo $fetchca['account']; ?>"><?php echo $fetchca['nickname']; ?></a></font>
								<?php
								if ($value['user_id']==$_SESSION['userid'] || $_SESSION['userid']==1) { ?>
									<a href="../../process/deletecomment.php?plink=post/<?php echo $fetch['id']."/".$fetch['seotitle' ];?>&cid=<?php echo $value['id']?>" style="float: right;" class="delcm rounded"><img src="../../imgs/trash.png" style="width: 12px"></a>
									<?php
								}
								?>
							</div>
						</div>
						<hr/>
					<?php } ?>
				</div>

				<form action="../../process/addcomment.php" method="post">
					<div class="form-group" id="txtbar">
						<textarea id="txtarea" name="comment" <?php echo (empty($_SESSION['userid'])) ? "disabled" : ""; ?> class="form-control cmbtxtarea" placeholder="Type here" required=""></textarea>
						<input type="hidden" name="postid" value="<?php echo $pid; ?>">
						<?php echo (empty($_SESSION['userid'])) ? "Before <a id='decnone' href='../../signin.php'>sign in</a> or <a id='decnone' href='../../signup.php'>sign up</a>" : ""; ?> 
					</div>
					<div class="form-group">
						<button type="submit" <?php echo (empty($_SESSION['userid'])) ? "disabled" : ""; ?> class="bluebuttoncmb">Write</button>
					</div>
				</form>

			</div>
		</div>
	</div>


</body>
<footer>
	<script src="../../js/jquery-3.4.1.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/infinite.js"></script>
	<script src="../../js/owl.carousel.min.js"></script>
	<script src="../../js/owl_conf.js"></script>
	<script src="../../js/darkmode.js"></script>
	<script src="../../js/darkmodeopt.js"></script>
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