<?php
// retorna conteudo do site
function Url2Content($link)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	$conteudo = curl_exec($ch);
	curl_close($ch);
	return $conteudo;
}

function finder($filme, &$ok, &$AC_url, &$IMDB_url, &$img, &$ERROR_url)
{
	$q = "";
	if (strripos($filme, "720") !== false)
		$q = " - 720p";
	if (strripos($filme, "1080") !== false)
		$q = " - 1080p";

	$nome = trim(preg_replace(array("/\s.?\s/", "/[^\s\wàáâãäçèéêëìíîïñòóôõöùúûüýÿ]/", "/\s\s*/", "/720p?|1080p?|Dual|Bluray|x?264/i"), " ", $filme));

	$t = preg_match_all("/(?<=\s)((?:19|20)\d{2})(?!p)/", $nome, $matches);
	if ($t==1)
		$p_ano = "(".($matches[1][0]-1)."|".$matches[1][0]."|".($matches[1][0]+1).")";
	else
		$p_ano = "\d{4}";

	$ERROR_url = "http://www.imdb.com/find?q=".urlencode($nome)."&s=tt&ttype=ft";
	$conteudo = file_get_contents($ERROR_url);

	$ok = true;
	$regex = "/href=\"\/title\/(tt\d+)\/\?ref_=(.){0,100}<\/a>(?: \(\w+\))? \(".$p_ano."\) </";
	if (preg_match($regex, $conteudo, $matches, PREG_OFFSET_CAPTURE)>0 || $_POST['imdb'])
	{
		$IMDB_url = "http://www.imdb.com/title/".$matches[1][0]."/";
		$url = "http://www.omdbapi.com/?i=".$matches[1][0];
		if($_POST['imdb'])
		{
			$url = "http://www.omdbapi.com/?i=".$_POST['imdb'];
			$IMDB_url = "http://www.imdb.com/title/".$_POST['imdb']."/";
		}

		$conteudo = Url2Content($url);

		preg_match("/\"Title\":\"(.+?)\",\"Year\":\"(\d{4})\".+\"Runtime\":\"(\d+) min\".+\"imdbRating\":\"(\d+.\d)\",\"imdbVotes\"/", $conteudo, $matches, PREG_OFFSET_CAPTURE);

		$title = $matches[1][0];
		$year = $matches[2][0];
		$r = $matches[3][0];
		$runtime_f = intval($r/60)."h".($r%60)."min";
		$imdb = $matches[4][0];

		$ERROR_url = "http://www.adorocinema.com/busca/1/?q=".urlencode($title);
		$conteudo = Url2Content($ERROR_url);

		$conteudo = preg_replace('/<.?b>/', '', $conteudo);

		// var_dump($conteudo);

		$regex = "/<a href='(\/filmes\/filme-\d+\/)'>\n(.+)\n.+\n(.+\n)?.+\n(".($year-1)."|".$year."|".($year+1).")<br \/>/";
		if (preg_match($regex, $conteudo, $matches, PREG_OFFSET_CAPTURE)>0 || $_POST['adcnm'])
		{
			$titulo = strip_tags($matches[2][0]);
			$AC_url = "http://www.adorocinema.com".$matches[1][0];
			if($_POST['adcnm'])
			{
				$AC_url = "http://www.adorocinema.com/filmes/filme-".$_POST['adcnm']."/";
				$conteudo = Url2Content($AC_url);
				//var_dump($conteudo);
				preg_match("/titlebar-title titlebar-title-lg\">(.+?)<\/div><div/", $conteudo, $matches, PREG_OFFSET_CAPTURE);
				$titulo = strip_tags($matches[1][0]);
			}
			else
				$conteudo = Url2Content($AC_url);
			$titulo = str_replace(array("  ",":"), array(" "," -"), $titulo);

			preg_match("/<img class=\"thumbnail-img\" src=\"(.+)\" alt=\"/", $conteudo, $matches);
			$img = $matches[1];

			$qtd = preg_match_all("/<span itemprop=\"genre\">(.+?)<\/span><\/span>/", $conteudo, $matches);

			for ($i=0; $i < $qtd; $i++)
				$matches[1][$i] = ucwords(trim($matches[1][$i]));

			setlocale(LC_ALL, "pt_BR", "ptb");
			sort($matches[1], SORT_LOCALE_STRING);

			$gen_f = implode(", ", $matches[1]);

			$final = "$titulo ~ $year ($gen_f) $imdb $runtime_f $q";
			return str_replace("  ", " ", $final);
		}
		else
			$ok = false;
	}
	else
		$ok = false;

}

$src = $_POST['src'];
if ($src == ".py")
{
	$filme = $_POST['filme'];
	$final = finder($filme, $ok, $AC_url, $IMDB_url, $img, $ERROR_url);
	if ($ok)
		echo "$final|-|$img";
	else
		echo "ERROR|-|$ERROR_url";
}

?>