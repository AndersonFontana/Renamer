<?php
	$title = "Filme";
	include '../header.php';
?>

	<div class="wrapper">
		<div class="main">
			<div class="container">
				<div class="row" style="margin: 100px auto;">
					<div class="col-md-8 col-md-offset-2">
						<form class="form" method="post" action="rename.php">
							<div class="content">
								
								<textarea class="form-control text-center" name="filme" placeholder="Digite o nome do(s) filme(s), um por linha" rows="10" style="font-size: 15px;"></textarea>
								
								<div class="col-sm-6">
									<div class="form-group">
										<input type="text" class="form-control text-center" name="imdb" placeholder="Imdb ID"/>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<input type="text" class="form-control text-center" name="adcnm" placeholder="AdoroCinema ID"/>
									</div>
								</div>
								
								<div class="col-sm-12" style="text-align: center">
									<div class="form-group">
										<input class="btn btn-success" name="submit" value="Enviar" type="submit">
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	include '../footer.php';
?>