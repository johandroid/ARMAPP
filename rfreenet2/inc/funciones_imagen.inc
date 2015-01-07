<?php
session_start();
function cargar_imagen_nodo($cliente_db,$cliente_id,$nodo_ip)
{
	include 'inc/idiomas.inc'; 
	include 'inc/datos_db.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	$query = "SELECT nodo_imagen FROM cliente_nodos WHERE nodo_ip='$nodo_ip'";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_store_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{		
		$result_array = mysql_fetch_array($result);
		header("Content-Type: image/jpg");
		echo $result_array[0];
		mysql_free_result($result);
		mysql_close($mysql);
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['success_load_imagen_nodo'];?>"); </script><?
	}
}

function cargar_imagen_gateway($cliente_db,$cliente_id,$gw_id)
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	$query = "SELECT nodo_imagen FROM cliente_gateways WHERE gw_id='$gw_id'";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_store_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{		
		$result_array = mysql_fetch_array($result);
		header("Content-Type: image/jpg");
		echo $result_array[0];
		mysql_free_result($result);
		mysql_close($mysql);
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['success_load_imagen_gw'];?>"); </script><?
	}
}

function guardar_imagen_nodo($cliente_db,$cliente_id,$nodo_ip,$imagen_nodo)
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	$imagen_nodo = str_replace('##','\#\#',mysql_escape_string($imagen_nodo));
	$query = "UPDATE cliente_nodos SET nodo_imagen='$imagen_nodo' WHERE nodo_ip='$nodo_ip';";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_store_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['success_store_imagen_nodo'];?>"); </script><?
		mysql_free_result($result);
		mysql_close($mysql);
	}
}

function guardar_imagen_gateway($cliente_db,$cliente_id,$gw_ip,$imagen_gw)
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$imagen_gw = str_replace('##','\#\#',mysql_escape_string($imagen_gw));
	$query = "UPDATE cliente_gateways SET nodo_imagen='$imagen_gw' WHERE gw_ip='".$gw_ip."';";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_store_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['success_store_imagen_gw'];?>"); </script><?
		mysql_free_result($result);
		mysql_close($mysql);
	}
}
?>