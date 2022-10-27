<?php
require_once('header.php');
include'captcha/captcha.php';
if (!empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
	exit;
}

$title = "Sign up";

if (isset($title)) { ?>
	<head><title>Veryserio.us | <?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>

<body>

	<div class="container gray2">
		<div class="row">
			<h4 class="offset-md-4" style="color: #11A9E1">Sign up</h4>
			<div id="info"></div>
			<div class="col-md-4 offset-md-4 bluepanel">
				<form action="process/signup.php" method="post" id="signupform">
					<div class="form-group">
						<label for="nickname">Nickname</label>
						<input type="text" name="nickname" id="nickname" class="form-control" placeholder="enter nickname" tabindex="1" autofocus="" autocomplete="off" required="">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="enter email address" tabindex="2">
					</div>
					<div class="form-group">
						<label for="password">Password(min 6 characters)</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="enter password" tabindex="3" autocomplete="off" required="">
					</div>
					<div class="form-group">
						<label for="rpassword">Retype password</label>
						<input type="password" name="rpassword" id="rpassword" class="form-control" placeholder="retype password" tabindex="4" autocomplete="off" required="">
					</div>
					<div class="form-group">
						<label for="captcha"><img src="<?php echo "captcha/".$captcha; ?>"></label>
						<input type="text" name="captcha" id="captcha" class="form-control" placeholder="type captcha" tabindex="5" required="" autocomplete="off">
						<input type="hidden" name="cmd5" value="<?php echo md5($selectword); ?>">
					</div>
					<div class="form-group">
						<button type="submit" class="bluebutton" tabindex="6" id="signup" name="signup">
							Sign up
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
<footer>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
	<script type="text/javascript">
		$("#signupform").submit(function(e) {

			e.preventDefault(); 

			var form = $(this);
			var url = form.attr('action');

/*			var nickname = $('#nickname').val();
			var email = $('#email').val();
			var password = $('#password').val();
			var rpassword = $('#rpassword').val();
			var passleght = password.leght;*/

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), 
				success: function(data)
				{
					$('#info').append(data);

				}
			});


		});
	</script>
</footer>
</html>