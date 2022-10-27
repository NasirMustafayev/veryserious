<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once("process/connect.php");
	include'process/timeconvert.php';

	$hottag = $db->query("SELECT * FROM hottag WHERE id='1'");
	$fetchht = $hottag->fetch(PDO::FETCH_ASSOC);
	session_start();
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="veryserio.us sign up and become writer" />
	<meta name="keywords" content="<?php echo $fetchht['hottag']; ?>"/>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="imgs/v.png"/>
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css"/>
</head>

<header>
	<nav class="navbar gray navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a href="index.php" class="navbar-brand">
			<img src="imgs/logo2.png"/ style="width: 140px">
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
						<a href="" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="smallpp rounded-circle" src="<?php echo ($fetch['profilephoto']) ? $fetch['profilephoto'] : 'imgs/user3.jpg';?>"><?php echo $fetch['nickname']; ?></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a href="profile.php" class="dropdown-item">My profile</a>
							<a href="user.php" class="dropdown-item">Preferences</a>
							<a href="process/logout.php" class="dropdown-item">Log out</a>
						</div>
					</li>
				</ul>
			</div>
			<?
		}
		else{
			?>
			<a href="signup.php" role="button" class="bluebuttonsmb ml-auto mr-1" style="width: 80px">Sign up</a>
			<a href="signin.php" role="button" class="bluebuttonsm mr-1" style="width: 80px">Sign in</a>
		<?php } ?>
	</nav>
</header>