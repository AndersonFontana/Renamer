<?php
	require 'funcs.php';
	
	if (isset($_POST['submit']))
	{
		$opac  = $_POST['opac'];
		$blur  = $_POST['blur'];
		$color = $_POST['color'];

		$temp = base64_decode($_POST['submit']);
		$img = imagecreatefromstring($temp);
		
		$originalImage = $img;

		$img = squareImg($img);
		$img = blurImg($img, $blur);

		$img = fillColor($img, hex2rgb($color), $opac);

		$img = putOver($img, $originalImage);

		showHTML($img, $originalImage, $opac, $blur, $color);
	}
	else if (isset($_POST['upload']))
	{	
		switch ($_FILES['file']['type']) {
			case 'image/png':
				$img = imagecreatefrompng($_FILES['file']['tmp_name']);
				break;
			case 'image/jpeg':
				$img = imagecreatefromjpeg($_FILES['file']['tmp_name']);
				break;
			
			default:
				$img = false;
				break;
		}
		// imagecreatefrombmp
		// imagecreatefromgd2
		// imagecreatefromgd2part
		// imagecreatefromgd
		// imagecreatefromgif
		// imagecreatefromwbmp
		// imagecreatefromwebp
		// imagecreatefromxbm
		// imagecreatefromxpm

		$opac  = 70;
		$blur  = 10;
		$color = '#000000';
		
		$img = resizeTo1280($img);

		$originalImage = $img;

		$img = squareImg($img);
		$img = blurImg($img, $blur);

		$img = fillColor($img, hex2rgb($color), $opac);

		$img = putOver($img, $originalImage);

		showHTML($img, $originalImage, $opac, $blur, $color);
	}
?>