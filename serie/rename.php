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

		$name = $_POST['serie'];
		$temp = $_POST['temp'];
		

		function Url2Content($link)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $l);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

			$conteudo = curl_exec($ch);
			curl_close($ch);
			return $conteudo;
		}

		$url = "http://www.omdbapi.com/?t=".str_ireplace(' ', '%20', $name)."&Season=".$temp;
		$conteudo = Url2Content($url);

		if(preg_match("/\"Title\":\"(.+)\",\"Season\":\"(\d+)\",\"/", $conteudo, $matches))
		{
			$conteudo = preg_replace("/{\"Title\".+\[/", "", $conteudo);
			$serie = $matches[1];
			$season = $matches[2];
			
			$qtd = preg_match_all("/\"Title\":\"([^\"]+)\",\"Released\":\"(\d{4})-\d+-\d+\",\"Episode\":\"(\d+)\",\"imdbRating\":\"(\S.\S)\",\"imdbID\":\"(tt\d+)\"/", $conteudo, $matches);

			echo "<p>".$season."ª Temp - ".$serie." (".$matches[2][--$qtd].")</p><br>";

			if(strlen($season)==1)
				$season = "0".$season;

			for ($i=0; $i <= $qtd; $i++)
			{
//				nome $matches[1][$i]
//				data $matches[2][$i]
//				ep   $matches[3][$i]
//				imdb $matches[4][$i]
//				tt   $matches[5][$i]

				if(strlen($matches[3][$i])==1)
					$matches[3][$i] = "0".$matches[3][$i];

				if ($matches[4][$i] == "N/A")
					$matches[4][$i] = "...";

				$matches[1][$i] = str_ireplace(':', ' -', $matches[1][$i]);

				echo "s".$season."e".$matches[3][$i]." - <a href=\"http://www.imdb.com/title/".$matches[5][$i]."/\">".$matches[1][$i]."</a> (".$matches[4][$i].")<br/>";
			}
		}
		else
			echo "<a href=\"http://".$url."\" >Erro</a>";
		echo "<br>";

	?>
	<button onclick="window.history.go(-1)">Voltar</button>
</div>

<?php include '../footer.php'; ?>