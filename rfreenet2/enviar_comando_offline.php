<?php
	session_start(); //continuamos session o la creamos si no hay
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$instalacion = $_GET["instalacion_id"];
	$nodo_ip = $_GET["nodo_ip"];
	$cliente_db = $_GET["cliente_db"];
	$gw_id = $_GET["gw_id"];
	$comando=$_GET['comando'];
	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $nodo_ip, $comando);
	//echo $query;
	mysql_query($query,$link) or die(mysql_error());	
	if (substr($comando,0,1) == "A")
	{
		$comando2="E".substr($comando,1);
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $nodo_ip, $comando2);
		mysql_query($query,$link) or die(mysql_error());
	}
	mysql_close($link);
	echo "OK";
?>