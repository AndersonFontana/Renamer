<?php
	$title = "Série";
	include '../header.php';
?>

	<div class="wrapper">
		<div class="main">
			<div class="container">
				<div class="row" style="margin: 100px auto;">
					<div class="col-md-8 col-md-offset-2">
						<form class="form" method="post" action="rename.php">
							<div class="content">
								
								<div class="col-sm-8">
									<div class="form-group label-floating">
										<label class="control-label">Série: </label>
										<input type="text" class="form-control text-center" name="serie" required>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group label-floating">
										<label class="control-label">Temporada: </label>
										<input type="number" class="form-control text-center" min="1" name="temp" required/>
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