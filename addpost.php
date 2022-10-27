<?php
require_once('header.php');
if (empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
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

	<div class="container profiletab">
		<div id="go">
			<?php 
			if($_GET['r']=='s'){
				?>
				<span class="info">-File size is too big(1mb)</span>
			<?php }
			elseif ($_GET[r]=='t') { ?>
				<span class="info">-File format doesn't support</span>
			<?php }
			?>
		</div>
		<div class="col-md-8 offset-md-2 bluepanel">
			<form action="process/addpost.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-sm">
						<label for="title">Title</label><br/>
						<input type="text" name="title" id="title" class="largeinput rounded" placeholder="write here" required="">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm">
						<label for="thumb">Thumbnail</label> (jpg,png,gif,bmp)<br/>
						<input type="file" name="thumb" class="rounded" id="thumb" required="">
						<img src="" id="showthumb"/ style="max-height: 150px;" class="img-thumbnail">
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<textarea name="post" id="post" class="postarea rounded" placeholder="write here..."></textarea>
					</div>
				</div>
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-md-4 offset-md-4">
						<button type="submit" class="form-control bluebuttonnext" id="next">Next</button>
					</div>
				</div>
			</div>
		</form>
	</div>

</body>

<footer>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
</footer>
</html>
<script>
	function readURL(input) {
		if (input.files && input.files[0])
		{
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#showthumb').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#thumb").change(function() {
		readURL(this);
	});
</script>
<!-- <script>
	$(document).ready(function(){
		$(document).on('click','#next',function(){

			var title = $('#title').val();
			var post = $('#post').val();

			$.ajax({
				url: 'process/addpost.php',
				type: 'post',
				data : {'title':title,'post':post},
				success: function(data)
				{
					$('#go').append(data);
				}
			});
		});
	});
</script> -->