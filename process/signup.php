<?php
require_once('connect.php');
include'functions.php';

if (empty($_POST['nickname'])) {?>
	<script type="text/javascript">
		window.location.href = "nopage.php";
	</script>
	<?php 
	exit;
}

$nickname = clear($_POST['nickname']);
$account = seo($nickname);
$email = clear($_POST['email']);
$password = clear($_POST['password']);
$password = md5($password);
$rpassword = clear($_POST['rpassword']);
$rpassword = md5($rpassword);
$captchapost = clear($_POST['captcha']);

$queryuser = $db->query("SELECT * FROM users WHERE nickname='$nickname'");
$alreadyusenick = $queryuser->rowCount();

$queryemail = $db->query("SELECT * FROM users WHERE email='$email'");
$alreadyuseemail = $queryemail->rowCount();

if($alreadyusenick>0){?>

	<br/><span class="info">-Nickname already use</span>

<?php }
else{
	if ($alreadyuseemail>0) {?>

		<br/><span class="info">-Email address already use</span>

	<?php }
	else{
		if (strlen($_POST['password'])<6) {?>

			<br/><span class="info">-Password must be minimum 6 characters</span>

		<?php }
		else{
			if ($password!=$rpassword) {?>

				<br/><span class="info">-Passwords not the same</span>

			<?php }
			else{
				if (md5($captchapost)!=$_POST['cmd5']) {?>

					<br/><span class="info">-Captcha is incorrect</span>

				<?php }
				else{
					if ($insert=$db->query("INSERT INTO users(nickname,account,email,password) VALUES('$nickname','$account','$email','$password')")) { ?>
						<script type="text/javascript">
							window.location.href = "signin.php?r=n";
						</script>
					<?php }
					else{ ?>
						<br/><span class="info">*Something are wrong</span>
					<?php }
				}
			}
		}
	}
}

?>