<?php
	session_start();

	include 'inc/datos_db.inc';
	
	$instalacion_id = $_GET['instalacion_id'];
	$diario_id=$_GET['diario_id'];
	$fecha = $_GET['fecha'];
	$operador = $_GET['operador'];
	$mensaje = $_GET['mensaje'];
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_GET['cliente_db'], $link);
	
	if(strstr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
	{
		$operador = utf8_decode($operador);
		$mensaje = utf8_decode($mensaje);
	}
	
	$query = sprintf("INSERT INTO cliente_diario(instalacion_id, fecha, operador, mensaje) VALUES('%s', '%s', '%s', '%s')", $instalacion_id, $fecha, $operador, $mensaje);
	echo $query.'<br>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR ";
		echo $query.'<br>';
	}


?>