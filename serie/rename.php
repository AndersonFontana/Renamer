<?php 
	$style = "../style.css";
	$favicon = "../favicon.ico";
	$home = "../index.php";
	$filme = "../filme";
	$serie = "../serie";
	$title = "Série";
	include '../header.php';
?>

<script type="text/javascript">
	function copyToClipboard(element) {
		var $temp = $("<textarea>");
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}
</script>
<div class="wrapper">
	<div class="main">
		<div class="container">
			<div class="row" style="margin: 100px auto;">
				<?php

					// $res = file_get_contents('data.php?serie=flash&temp=3', FILE_USE_INCLUDE_PATH);
					// $res = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/data.php?serie=flash&temp=3');
					// $response = http_post_fields('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/data.php', $_POST);

					$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/data.php';

					// use key 'http' even if you send the request to https://...
					$options = array(
					    'http' => array(
					        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					        'method'  => 'POST',
					        'content' => http_build_query($_POST)
					    )
					);
					$context  = stream_context_create($options);
					$res = file_get_contents($url, false, $context);
					$res = (json_decode($res, true));

					if ($res['ok'])
					{
						$season = intval($res['season']);

						echo "<h2 class='text-center'>".$season."ª Temp - <a href='http://www.imdb.com/title/".$res['imdbTT']."/'>".$res['name']."</a> (".$res['year'].")</h2>";
						echo "</div><div class='row' style='margin: 100px auto;'>";
						echo "
						<table class='table'>
							<thead>
								<tr>
									<th class='text-center'>Episode</th>
									<th class='text-center'>Title</th>
									<th class='text-center'>Year</th>
									<th class='text-center'>Rating</th>
									<th class='text-center'>Thumb</th>
								</tr>
							</thead>
							<tbody>";
						$raw = $season."ª Temp - ".$res['name']." (".$res['year'].")\n";
						foreach ($res['episodes'] as $ep)
						{
							echo "
								<tr>
									<td class='text-center'>".$ep['episode']."</td>
									<td class='text-center'>
										<a href='http://www.imdb.com/title/".$ep['imdbTT']."/'>".$ep['title']."</a>
									</td>
									<td class='text-center'>".$ep['year']."</td>
									<td class='text-center'>".$ep['rating']."</td>
									<td class='text-center'><img src='".$ep['thumb']."'></td>
								</tr>";
							$raw .= "s".$res['season']."e".$ep['episode']." - ".$ep['title']." (".$ep['rating'].")\n";
						}
						echo "
							</tbody>
						</table>";

						echo "<p style='display: none' id='p1'>$raw</p>";
					}
					else
					{
						echo "<pre>";
						var_dump($res);
						echo "</pre>";
					}
				?>
			</div>
			<div class='row' style='margin: 100px auto;'>
				<button class="btn btn-default" onclick="window.history.go(-1)">Voltar</button>
				<button class="btn btn-default" style="float: right;" onclick="copyToClipboard('#p1')">Copiar RAW</button>
			</div>
		</div>
	</div>
</div>

<?php include '../footer.php'; ?>