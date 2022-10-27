<?php
require_once('connect.php');
include'functions.php';
session_start();

$about = clear($_POST['about']);
$userid = $_SESSION['userid'];

if ($query = $db->query("UPDATE users SET about='$about' WHERE id='$userid'")) { ?>
	<script type="text/javascript">
		window.location.href = "../user.php";
	</script>
<? }
else{ ?>
	<script type="text/javascript">
		window.location.href = "../user.php?p=e";
	</script>
	<? } ?>