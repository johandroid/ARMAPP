<?php
	session_start();
	include 'inc/idiomas.inc';
	
	$cadena_input = $_GET["cadena_input"];
	
	if ($_SESSION['opcion_idioma'] == "")
	{
		echo $idiomas['es'][$cadena_input];
	}
	else if($cadena_input=="idioma")
	{
		echo $_SESSION['opcion_idioma'];
	}	
	else
	{
		echo $idiomas[$_SESSION['opcion_idioma']][$cadena_input];
	}			
?>