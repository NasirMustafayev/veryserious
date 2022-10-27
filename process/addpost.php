<?php
require_once('connect.php');
include'functions.php';
session_start();

$title = clear($_POST['title']);
$seotitle = seo($title);
$post = clear($_POST['post']);
$userid = $_SESSION['userid'];

$titlecut = substr($title, 1, 20);
$destinationfolder = '../imgs/posts/thumb';
$thumb = $_FILES["thumb"]["name"];

if ($_FILES['thumb']['size']>2010000) {
	echo " <meta http-equiv='refresh' content='0;URL=../addpost.php?r=s'>"; 
	exit;
}

$authorizedtype=array('jpg','jpeg','img','webp','png','gif','bmp');
$findtype=strtolower(substr( $_FILES["thumb"]["name"], strpos( $_FILES["thumb"]["name"],'.')+1));

if (in_array($findtype, $authorizedtype)===false) {
	echo " <meta http-equiv='refresh' content='0;URL=../addpost.php?r=t'>"; 
	exit;
}

$rand = rand(100,9999);
$thumbnail=substr($destinationfolder, 3)."/".$userid.$titlecut.$rand.$thumb;


move_uploaded_file($_FILES["thumb"]["tmp_name"], $destinationfolder.'/'.$userid.$titlecut.$rand.$thumb);

$insert = $db->prepare("INSERT INTO posts SET
	user_id=:userid,
	posttitle=:title,
	seotitle=:seotitle,
	post=:post,
	postthumb=:thumbnail");
$save=$insert->execute(array(
	'userid'=>$userid,
	'title'=>$title,
	'seotitle'=>$seotitle,
	'post'=>$post,
	'thumbnail'=>$thumbnail
));

if($save) {
	$getid = $db->lastInsertId();
	?>
	<script type="text/javascript">
		window.location.href = "../addpostcont.php?pid=<?php echo $getid ?>";
	</script>
<?php }
?>