<?php
	$title = "Música";
	include '../header.php';
?>

	<div class="wrapper">
		<div class="main">
			<div class="container">
				<div class="row" style="margin: 100px auto;">
					<?php
						// $bdcon3 = pg_connect("host=ec2-107-20-195-181.compute-1.amazonaws.com port=5432 dbname=dfm0ks4a9637i8 user=rfndhmuypazerb password=a49292339f28fe05535630c3d2edf39805c869dcdfd49c1d587687396cde0fc5");
						$db = pg_connect("postgres://rfndhmuypazerb:a49292339f28fe05535630c3d2edf39805c869dcdfd49c1d587687396cde0fc5@ec2-107-20-195-181.compute-1.amazonaws.com:5432/dfm0ks4a9637i8Heroku") or die('connection failed');
						$result = pg_query($db, "SELECT * FROM pg_stat_activity");
						var_dump(pg_fetch_all($result));
					?>
				</div>
			</div>
		</div>
	</div>

<?php
	include '../footer.php';
?>