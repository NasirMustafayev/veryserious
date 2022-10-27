<?php
require_once("header.php");
include'process/functions.php';

$clear = $_GET['ht'];
$hottag = $db->query("SELECT * FROM hottag WHERE id='1'");
$fetchht = $hottag->fetch(PDO::FETCH_ASSOC);
$ht = $fetchht['hottag'];
$querytag = $db->query("SELECT * FROM tags WHERE tag='$ht'");

$title="Veryserio.us | Latest";

if (empty($_GET['ht'])) {

	$query = $db->query("SELECT * FROM posts ORDER BY postdate DESC");
}

elseif ($clear!=$fetchht['hottag']) {
	$query = $db->query("SELECT * FROM posts ORDER BY postdate DESC");
}

if (isset($title)) { ?>
	<head><title><?php echo $title; ?></title></head>
<?php }
else{
	?>
	<head><title>Veryserio.us</title></head>
<?php } ?>
<body>
	<div class="container">
		<div class="row">
			<div class="owltop">
				<h4>Latest
					<?php if($_GET['ht']==$fetchht['hottag']){ ?>
						<a href="" class="hot rounded" id="tagbtn">&#128293;<?php echo $fetchht['hottag']; ?></a>
					<?php }
					?>
				</h4>
			</div>
			<div class="col-md-12 text-center">
				<form id="sform">
					<label for="searchtext"><img style="width: 16px;height: 16px" src="imgs/glass.png"/></label>
					<input type="text" name="searchtext" id="searchtext" class="searchinput rounded text-center" placeholder="Type here..(peoples,posts)">
				</form>
			</div>
		</div>
		<div id="result">
		</div>
		<div class="row posts">
			<?php
			if (isset($_GET['ht'])) {
				
				if ($clear==$ht) {
					
					while ($fetchtag = $querytag->fetch(PDO::FETCH_ASSOC))
					{
						$postid = $fetchtag['post_id'];
						$query = $db->query("SELECT * FROM posts WHERE id='$postid' ORDER BY postdate DESC");
						foreach ($query as $value)
						{ 
							$authorid= $value['user_id'];
							$queryauthor = $db->query("SELECT * FROM users WHERE id='$authorid'");
							$fetchauthor = $queryauthor->fetch(PDO::FETCH_ASSOC);
							?>
							<div class="col-md-3 news">
								<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>?from=lht">
									<img src="<?php echo $value['postthumb'] ?>" class="rounded" style="width:240px;height: 150px">
									<h6 style="width: 240px"><?php echo (strlen($value['posttitle'])>64) ? substr($value['posttitle'],0,64)."..." : $value['posttitle']; ?></h6>
									<span style="float: left;"><img class="smallpp rounded-circle" src="<?php echo ($fetchauthor['profilephoto']) ? $fetchauthor['profilephoto'] : 'imgs/user3.jpg';?>"> <?php echo($value['user_id']==$userid) ? $value['postview']." views|" : " "; echo timeConvert($value['postdate']); ?></span>
								</a>
							</div>
						<?php }
					}
				}
			}
			
			foreach ($query as $value) {
				$authorid= $value['user_id'];
				$queryauthor = $db->query("SELECT * FROM users WHERE id='$authorid'");
				$fetchauthor = $queryauthor->fetch(PDO::FETCH_ASSOC);
				
				?>

				<div class="col-md-3 news">
					<a href="post/<?php echo $value['id']."/".$value['seotitle']; ?>	">
						<img src="<?php echo $value['postthumb'] ?>" class="rounded" style="width:240px;height: 150px">
						<h6 style="width: 240px"><?php echo (strlen($value['posttitle'])>64) ? substr($value['posttitle'],0,64)."..." : $value['posttitle']; ?></h6>
						<span style="float: left;"><img class="smallpp rounded-circle" src="<?php echo ($fetchauthor['profilephoto']) ? $fetchauthor['profilephoto'] : 'imgs/user3.jpg';?>"> <?php echo($value['user_id']==$userid) ? $value['postview']." views|" : " "; echo timeConvert($value['postdate']); ?></span>
					</a>
				</div>
			<?php }
			?>
		</div>
	</div>
</body>
<footer>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			load_data();
			function load_data(query)
			{
				$.ajax({
					url:"process/search.php",
					method:"post",
					data:{query:query},
					success:function(data)
					{
						$('#result').html(data);
					}
				});
			}

			$('#searchtext').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else
				{
					load_data();            
				}
			});

		});
	</script>
</footer>
</html>