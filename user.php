<?php
require_once('header.php');
if (empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
	exit;
}

$title = $fetch['nickname'];

if (isset($title)) { ?>
	<head><title>Veryserio.us - <?php echo $title; ?> | settings</title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>

<body>
	<div class="container profiletab">
		<div class="row">
			<h2 class="bluetext"><?php echo $fetch['nickname']; ?> </h2> <h2>informations</h2>
		</div>
		<div id="info" class="text-center"></div>
		<div class="bluepanel col-md-6 offset-md-3">
			<div class="row">
				<div class="col-md text-center">
					<img src="<?php echo ($fetch['profilephoto']) ? $fetch['profilephoto'] : 'imgs/user3.jpg';?>" class="rounded-circle" style="width: 120px;height: 120px">
					<br/>
					<label class="customupload">
						<form id="mypp" enctype="multipart/form-data">
							<input type="file" name="ppicture" id="ppicture" style="display: none">
						</form>
						<a class="decnone">&#128394;Change..</a>
					</label>
				</div>
			</div>
			<hr>
			<div class="form-group row">
				<label for="email" class="col-sm-3 col-form-label">Email</label>
				<input type="email" id="email" readonly="" class="form-control col-sm-6" value="<?php echo $fetch['email']; ?>" aria-describedby="emaildesc">
			</div>
			<form action="process/updateabout.php" method="post">
				<div class="form-group row">
					<label for="about" class="col-sm-3">About you</label>
				</div>
				<div class="form-group row">
					<textarea class="form-control col-sm abtxtarea" id="about" name="about" placeholder="Type your story..."><?php echo (isset($fetch['about'])) ? $fetch['about'] : ""; ?></textarea>
				</div>
				<div class="form-group row">
					<button class="bluebutton col-sm-3 offset-md-9" tabindex="4">
						Update
					</button>
				</div>
			</form>
			<h3 class="whiteh3">Update password</h3>
			<div id="infopass">
				<?php
				if ($_GET['r']=='p') { ?>
					<b style="color: green;font-size: 20px">✔</b><span id="info">Passowrd succesfully updated</span>
				<?php }
				?>
			</div>
			<form action="process/updatepassword.php" method="post" id="updatepassform">

				<div class="form-group row">
					<label for="lastpass" class="col-sm-3 col-form-label">Last password</label>
					<input type="password" name="lastpass" id="lastpass" class="form-control col-sm-6" placeholder="enter your last password" tabindex="1">
				</div>

				<div class="form-group row">
					<label for="newpass" class="col-sm-3 col-form-label">New password</label>
					<input type="password" name="newpass" id="newpass" class="form-control col-sm-6" placeholder="enter your new password" tabindex="2">
				</div>

				<div class="form-group row">
					<label for="rnewpass" class="col-sm-3 col-form-label">Retype new password</label>
					<input type="password" name="rnewpass" id="rnewpass" class="form-control col-sm-6" placeholder="enter again your new password" tabindex="3">
				</div>

				<div class="form-group row">
					<button class="bluebutton col-sm-6 offset-md-3" tabindex="4">
						Update
					</button>
				</div>

			</form>

		</div>

	</div>
</body>

<footer>
	<div class="container-fluid footgray">
		<div class="row">
			<div class="col-md-9">
				<h6 style="font-size: 13px;">Management does not have any obligations regarding the ones placed on the site.</h6>
			</div>
			<div class="col-sm" style="text-align: right;">
				<h6 style="font-size: 13px;">2019 - Veryserio.us</h6>
			</div>

		</div>

	</div>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script type="text/javascript">
		//Upload profile picture
		$("#ppicture").change(function() {
			var form_data = new FormData($("#mypp")[0]);
			$.ajax({
				url: "process/ppupload.php",
				dataType: 'script',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(ppic) {
					$('#info').append(ppic);
				}
			});
		});
	</script>
	<script>
		$("#updatepassform").submit(function(e) {

			e.preventDefault(); 

			var form = $(this);
			var url = form.attr('action');

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), 
				success: function(data)
				{
					$('#infopass').append(data);

				}
			});


		});

	</script>
</footer>
</html>