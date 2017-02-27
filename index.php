<?php
	$title = "Página Inicial";
	include 'header.php';
?>

	<div class="wrapper">
		<div class="main">
			<div class="container">
				<div class="row" style="margin: 100px auto; min-height: 200px;">
					<div class="col-md-4" style="padding: 10px; text-align: center">
						<a href="$baseUrl/filme/">
							<button class="btn btn-info btn-lg" style="width: 200px">
								<i class="material-icons" style="font-size: 40px;">movie</i>
								<br><br>Filme
							</button>
						</a>
					</div>
					<div class="col-md-4" style="padding: 10px; text-align: center">
						<a href="$baseUrl/serie/">
							<button class="btn btn-info btn-lg" style="width: 200px">
								<i class="material-icons" style="font-size: 40px;">theaters</i>
								<br><br>Série
							</button>
						</a>
					</div>
					<div class="col-md-4" style="padding: 10px; text-align: center">
						<a href="$baseUrl/music/">
							<button class="btn btn-info btn-lg" style="width: 200px">
								<i class="material-icons" style="font-size: 40px;">audiotrack</i>
								<br><br>Música
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	include 'footer.php';
?>