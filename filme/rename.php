<?php 
	$style = "../style.css";
	$favicon = "../favicon.ico";
	$home = "../index.php";
	$filme = "../filme";
	$serie = "../serie";

	include '../head.php';
?>

<div>
	<?php
		require 'find.php';
		$filmes = explode("\n", $_POST['filme']);

		echo "<table>";
		foreach ($filmes as $filme)
		{
			$final = finder($filme, $ok, $AC_url, $IMDB_url, $img, $ERROR_url);
			if($ok)
				echo "<tr class='y'>\n\t<td><img src=\"$img\"></td>\n\t<td>$final<br/><a href=\"$AC_url\">AdoroCinema</a> | <a href=\"$IMDB_url\">Imdb</a></td></tr>";
			else
				echo "<tr class='n'>\n\t<td>ERRO</td>\n\t<td>$filme<br/><a href=\"$ERROR_url\">Search Error</a></td></tr>";
		}
		echo "</table>";

	?>
	<button onclick="window.history.go(-1)">Voltar</button>
</div>

<?php include '../footer.php'; ?>