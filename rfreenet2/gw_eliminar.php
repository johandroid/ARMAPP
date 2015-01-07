<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	
	$sInstalacionActual=$_GET['instalacion_id'];
	$sGatewayDEL=$_GET['gw_id'];

	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	mysql_select_db($_SESSION['cliente_db'], $link);
	
	$query = sprintf("UPDATE %s SET instalacion_habilitado_et1='0' WHERE instalacion_gw_et1='%s'",$tabla_instalaciones,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	$query = sprintf("UPDATE %s SET instalacion_habilitado_et2='0' WHERE instalacion_gw_et2='%s'",$tabla_instalaciones,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	$query = sprintf("UPDATE %s SET instalacion_habilitado_et3='0' WHERE instalacion_gw_et3='%s'",$tabla_instalaciones,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	// en primer lugar lo insertamos en la tabla de suscriptores general
	mysql_select_db($db_name_clientes, $link);
	
	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_suscriptores,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR1 ";
	}

	mysql_select_db($_SESSION['cliente_db'], $link);
	
	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_gateways,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR2 ";
	}

	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_params_gateways,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_nodos,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_params_nodos,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR4 ";
	}
	
	$query = sprintf("DELETE FROM %s WHERE gw_id='%s'",$tabla_name_utcs,$sGatewayDEL);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR5 ";
	}
			
	echo $idiomas[$_SESSION['opcion_idioma']]['general217'].' '.$sGatewayDEL.' '.$idiomas[$_SESSION['opcion_idioma']]['general216'];
	mysql_close($link);

?>
