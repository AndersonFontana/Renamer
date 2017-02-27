<?php 

$liFilme  = ($title=="Filme")  ? "<li class='active'>" : "<li>";
$liSerie  = ($title=="Série")  ? "<li class='active'>" : "<li>";
$liMusica = ($title=="Música") ? "<li class='active'>" : "<li>";
$baseUrl = "https://myrenamer.herokuapp.com/";

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='utf-8'/>
	<link rel='shortcut icon' type='image/x-icon' href='$baseUrl/assets/img/favicon.ico'/>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>

	<title> $title - Renamer </title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>

	<!--     Fonts and icons     -->
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700'/>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css'/>

	<!-- CSS Files -->
	<link href='$baseUrl/assets/css/bootstrap.min.css' rel='stylesheet'/>
	<link href='$baseUrl/assets/css/material-kit.css' rel='stylesheet'/>
</head>
<body>
	<nav class='navbar' style='background-color: #444; margin-bottom: 0px;'>
		<div class='container'>
			<div class='navbar-header' style='padding-left: 15px'>
				<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navigation-index' aria-expanded='false'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
				<a class='navbar-brand' href='$baseUrl'>
					<i class='material-icons'>home</i>
				</a>
			</div>

			<div class='navbar-collapse collapse' id='navigation-index' aria-expanded='false' style='height: 0px;'>
				<ul class='nav navbar-nav navbar-right'>
					$liFilme
						<a href='$baseUrl/filme/'>
							<i class='material-icons'>movie</i> Filme
						<div class='ripple-container'></div></a>
					</li>
					$liSerie
						<a href='$baseUrl/serie/'>
							<i class='material-icons'>theaters</i> Série
						</a>
					</li>
					$liMusica
						<a href='$baseUrl/music/'>
							<i class='material-icons'>audiotrack</i> Música
						</a>
					</li>
				</ul>
			 </div>
		</div>
	</nav>";
?>