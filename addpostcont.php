<?php
require_once('header.php');
include'process/functions.php';
if (empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
	exit;
}

$pid = clear($_GET['pid']);

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
$title = "Addpost";

if (isset($title)) { ?>
	<head><title>Veryserio.us | <?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>

<body>
	<link rel="stylesheet" type="text/css" href="css/quill.bubble.css">
	<link rel="stylesheet" type="text/css" href="css/dropzone.min.css">

	<div class="container profiletab">
		<div class="info"></div>
		<div class="col-md-8 offset-md-2 bluepanel">
			<div class="row">
				<form action="process/addpostpictures.php" class="dropzone dropzonecustom">
					<input type="hidden" name="pid" value="<?php echo $pid; ?>">
				</form>
			</div>
			<form action="process/addtl.php" method="post">
				<div class="row">
					<div class="col-sm">
						<label for="tubelink">Youtube video link</label> (don't use starting time)
						<input type="text" class="form-control" name="tubelink" placeholder="youtu.be/xxxxxxxxxxx">
					</div>
				</div>
				<div class="row" style="margin-bottom: 10px;margin-top: 10px">
					<div class="col-sm">
						<div class="form-group">
							<label for="tags">Tags</label> (if you have hottag write that tag tag1)<br/>
							<input type="text" name="tags[]" class="rounded" style="font-size: 12px" placeholder="tag 1">
							<input type="text" name="tags[]" class="rounded" style="font-size: 12px" placeholder="tag 2">
							<input type="text" name="tags[]" class="rounded" style="font-size: 12px" placeholder="tag 3">
							<input type="text" name="tags[]" class="rounded" style="font-size: 12px" placeholder="tag 4">
							<input type="text" name="tags[]" class="rounded" style="font-size: 12px" placeholder="tag 5">
							<input type="hidden" name="pid" value="<?php echo $pid; ?>">
						</div>
					</div>
				</div>
				<div class="row" style="margin-bottom: 10px;margin-top: 10px">
					<div class="col-md-4 offset-md-4">
						<button type="submit" id="publish" class="form-control bluebuttonnext">Publish</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</body>

<script src="js/dropzone.min.js"></script>

<footer>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
	<!-- <script type="text/javascript">
		$(document).on('click','#publish',function(){

			var tags = $('#tags').val();
			var pid = <?php echo $pid; ?>

			$.ajax({
				url:'process/addtags',
				post:'post',
				data:{'tags':tags,'pid':pid},
				success:function(data){
					$('#info').append(data);
				}

			});
		});
	</script> -->
</footer>
</html>