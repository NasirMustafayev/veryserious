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
	<script src="js/infinite.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/owl_conf.js"></script>
	<script src="js/darkmode.js"></script>
	<script src="js/darkmodeopt.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script type="text/javascript">
		$('.posts').infiniteScroll({
  // options
  path: '.pagination__next',
  append: '.news',
  history: false,});
		
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
	<script> $('#scrollhere').scrollView(); </script>
</footer>
</html>