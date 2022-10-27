<?php
require_once("header.php");
if (!empty($_SESSION['userid'])) { ?>
	<script type="text/javascript">
		window.location.href = "index.php";
	</script>
	<?php
	exit;
}

$title = "Sign in";

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
			<h4 class="offset-md-4" style="color: #11A9E1">Sign in</h4>
			<div id="info"></div>
			<div class="col-md-4 offset-md-4 bluepanel" style="padding-bottom: 100px">
				<form action="process/signin.php" method="post" id="signinform">
					<div class="form-group">
						<label for="login">Email or account</label>
						<input type="text" name="login" id="login" class="form-control" placeholder="enter email or account" tabindex="1" autofocus="" required="">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="enter password" tabindex="2" required="">
					</div>
					<div class="form-group">
						<div class="form-check">
							<input type="checkbox" name="remember" id="remember" class="form-check-input" value="remember" tabindex="3">
							<label class="form-check-label" for="remember">Remember me</label>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="bluebutton" tabindex="3" name="signin">
							Sign in
						</button>
					</div>
				</form>
				<br/>
				Why are you running? <a href="signup.php" class="rounded">Sign up</a><br/><br/>
				Forget the password? <a href="resetpass.php" class="rounded">Reset password</a>
			</div>
		</div>

	</div>

</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/darkmode.js"></script>
<script src="js/darkmodeopt.js"></script>
<script type="text/javascript">
	$("#signinform").submit(function(e) {

		e.preventDefault(); 

		var form = $(this);
		var url = form.attr('action');
		
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