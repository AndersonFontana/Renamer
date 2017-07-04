<?php

	function resizeTo1280($img)
	{
		$x = imagesx($img);
		$y = imagesy($img);
		if ($x > $y)
			$new_width = 1280;
		else
			$new_width = intval($x*1280/$y);
		// var_dump($new_width);
		return imagescale($img, $new_width);
	}
	
	function squareImg($img)
	{
		$minSize = min(imagesx($img), imagesy($img));
		$maxSize = max(imagesx($img), imagesy($img));
		
		if (imagesx($img) < imagesy($img))
		{
			$img = imagecrop($img, ['x' => 0, 'y' => $maxSize/2-$minSize/2, 'width' => $minSize, 'height' => $minSize]);
		}

		$imgL = imagecreatetruecolor($maxSize, $maxSize);
		imagecopyresampled($imgL, $img, 0, 0, 0, 0, $maxSize, $maxSize, $minSize, $minSize);

		return $imgL;
	}

	function blurImg($img, $scale)
	{
		for ($i=5; $i<$scale+5; $i++)
		{	
			if ($i%5==0)
			{	
				imagefilter($img, IMG_FILTER_PIXELATE, 5);
				imagefilter($img, IMG_FILTER_SMOOTH, -5);
			}
			imagefilter($img, IMG_FILTER_GAUSSIAN_BLUR);
		}

		return $img;
	}

	function hex2rgb($hex)
	{
		$hex = ltrim($hex,'#');
		$c['r'] = hexdec(substr($hex,0,2));
		$c['g'] = hexdec(substr($hex,2,2));
		$c['b'] = hexdec(substr($hex,4,2));
		// var_dump($c);
		return $c;
	}

	function fillColor($img, $colorRGB, $opacity)
	{
		$size = imagesx($img);
		$colorImg = imagecreate($size, $size);
		imagecolorallocate($colorImg, $colorRGB['r'], $colorRGB['g'], $colorRGB['b']);
		
		imagecopymerge($img, $colorImg, 0, 0, 0, 0, $size, $size, $opacity);
		return $img;
	}

	function putOver($sqrImg, $orgImg)
	{
		$minSize = min(imagesx($orgImg), imagesy($orgImg));
		$maxSize = max(imagesx($orgImg), imagesy($orgImg));

		// echo "min: $minSize<br>";
		// echo "max: $maxSize<br>";
		// echo "x: ".($maxSize/2-$minSize/2)."<br>";

		if (imagesx($orgImg) < imagesy($orgImg))
		{
			imagecopy( $sqrImg, $orgImg, $maxSize/2-$minSize/2, 0, 0, 0, $minSize, $maxSize );
		}
		return $sqrImg;
	}

	function img2base64($img)
	{
		ob_start();
		  imagepng($img);
		  $data = ob_get_contents(); 
		ob_end_clean();
		imagedestroy($img);
		return base64_encode($data);
	}

	function showHTML($image, $original, $opac, $blur, $color)
	{
		if ($image == $original) {
			$img = $org = img2base64($original);
		}
		else {
			$img = img2base64($image);
			$org = img2base64($original);
		}

		echo "
		<!DOCTYPE html>
		<html>
		<head>
			<title>ImageEditor</title>
			
			<meta charset='utf-8'>
			<meta content='width=device-width, initial-scale=1' name='viewport'>

			<!--     Fonts and icons     -->
			<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons' />
			<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' />
			<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' />

			<!-- CSS Files -->
			<link href='../assets/css/bootstrap.min.css' rel='stylesheet' />
			<link href='../assets/css/material-kit.css' rel='stylesheet'/>
			<link href='style.css' rel='stylesheet'/>
		</head>
		<body>

		<div class='wrapper'>
			<div class='main'>
				<div class='container'>
					<div class='row' style='margin: auto; padding:50px'>
						<div class='col-md-6'>
							<form method='POST'>
								<label for='blur'>Blur</label>
									<input type='range' name='blur' id='blur' min='0' max='40' value='$blur' step='1' class='slider' /><br><br>
								<label for='color'>Cor</label>
									<input class='btn btn-white form-control' style='margin-top: -30px;' type='color' name='color' id='color' value='$color'>
								<label for='opac'>Opacidade</label>
									<input type='range' name='opac' id='opac' min='0' max='100' value='$opac' step='1' class='slider' /><br>
								<button class='btn btn-success' style='margin: auto; display: block;' type='submit' name='submit' value='$org'>Atualizar</button><br>
							</form>
						</div>
						<div class='col-md-6'>
							<img alt='Image' style='width: 100%;' src='data:image/png;base64,$img' />
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<p style='text-align: center;'>@2017 - Desenvolvido por <a href='https://github.com/AndersonFontana'>Anderson A. Fontana</a>.</p>
		</footer>
		<!--   Core JS Files   -->
		<script src='../assets/js/jquery.min.js' type='text/javascript'></script>
		<script src='../assets/js/bootstrap.min.js' type='text/javascript'></script>
		<script src='../assets/js/material.min.js'></script>
		<script src='../assets/js/material-kit.js' type='text/javascript'></script>
		</body>
		</html>
		";
	}
?>