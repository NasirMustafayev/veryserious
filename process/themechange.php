<?php
include'functions.php';

$t = clear($_GET['t']);
if ($t=='dark') {
	$cookieend = time() + (60*60*24*7);
	setcookie("theme","dark", $cookieend);
}
?>
