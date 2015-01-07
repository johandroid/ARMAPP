<?php
	session_start();
	include 'inc/idiomas.inc';
	$_SESSION['opcion_idioma']=$_GET['opcion_idioma'];
	//if (($_SESSION['opcion_idioma'] != 'es') && ($_SESSION['opcion_idioma'] != 'en') && ($_SESSION['opcion_idioma'] != 'fr'))
	//{
	//	$_SESSION['opcion_idioma'] = 'es';
	//}
?>
