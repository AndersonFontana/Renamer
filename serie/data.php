<?php
ob_start();
function lead0($val)
{
	if(strlen($val)==1)
		$val = "0".$val;
	return $val;
}

if ($_REQUEST)
{
	$name = $_REQUEST['serie'];
	$temp = $_REQUEST['temp'];

	// $url = "http://www.imdb.com/find?q=".str_ireplace(' ', '%20', $name)."&s=tt&ttype=tv&exact=true&ref_=fn_tt_ex";
	$url = "http://www.imdb.com/find?q=".str_ireplace(' ', '%20', $name)."&s=tt&ref_=fn_tt";
	$conteudo = file_get_contents($url);

	$ret['type'] = 'serie';

	// se o resultado da pesquisa tiver uma serie
	$regex = "/<td class=\"result_text\">\s?<a href=\"\/title\/(tt\d+)[^\"]+\" >([^<]+)<\/a>\s?\(\d+\)\s?\(TV Series\)/";
	if (preg_match_all($regex, $conteudo, $matches))
	{
		$imdbTT = $matches[1][0];

		$ret['ok'] = true;
		$ret['name'] = $matches[2][0];
		$ret['imdbTT'] = $imdbTT = $matches[1][0];

		$url = "http://www.imdb.com/title/$imdbTT/episodes?season=$temp";
		$conteudo = file_get_contents($url);

		$regex = "/src=\"([^\"]+)\">\s+<div>S(\d+), Ep(\d+)<\/div>(?:\n.+){5}\s+\d+ \w{3}\.? (\d{4})\s+<\/div>\s+<strong><a href=\"\/title\/(tt\d+)\/\?ref_=ttep_ep\d+\"\s+title=\"[^\"]+\" itemprop=\"name\">([^<]+)<\/a><\/strong>/";
		$qtd = preg_match_all($regex, $conteudo, $episodio);

		$ret['year']= $episodio[4][$qtd-1];
		$ret['season'] = lead0($episodio[2][0]);

		for ($i=0; $i < $qtd; $i++) { 
			$retEp[$i]['episode'] = lead0($episodio[3][$i]);
			$retEp[$i]['title'] = $episodio[6][$i];
			$retEp[$i]['year'] = $episodio[4][$i];
			$retEp[$i]['imdbTT'] = $episodio[5][$i];

			$url = "http://www.imdb.com/title/".$episodio[5][$i];
			$conteudo = file_get_contents($url);

			// $regex = "/<span class=\"rating\">(\d+\.\d+)<span class=\"ofTen\">/";
			$regex = "/title=\"(\d+.\d+) based on/";
			preg_match_all($regex, $conteudo, $matches);

			$retEp[$i]['rating'] = str_replace(",",".",$matches[1][0]);
			$retEp[$i]['thumb'] = $episodio[1][$i];
		}
		$ret['episodes'] = $retEp;
	}
	else
	{
		$ret['ok'] = false;
		$ret['reason'] = "Cannot find query";
		$ret['tried'] = $url;
	}
}
else
{
	$ret['ok'] = false;
	$ret['reason'] = "No data received";
}
ob_end_clean();

print_r(json_encode($ret));

?>