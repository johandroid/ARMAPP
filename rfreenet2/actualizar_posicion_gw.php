<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$gw_id = $_GET["gw_id"];
$gw_latitud = $_GET["lat"];
$gw_longitud = $_GET["lon"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE cliente_gateways SET gw_latitud=%s,gw_longitud=%s WHERE gw_id='%s';", $gw_latitud, $gw_longitud, $gw_id);
//echo $query;
$result = mysql_query($query,$link);
if ($result)
{
	$query = sprintf("UPDATE cliente_instalaciones SET instalacion_latitud_et1=%s WHERE instalacion_gw_et1='%s';", $gw_latitud, $gw_id);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else 
	{
		$query = sprintf("UPDATE cliente_instalaciones SET instalacion_latitud_et2=%s WHERE instalacion_gw_et2='%s';", $gw_latitud, $gw_id);
		//echo $query;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR";
		}
		else 
		{
			$query = sprintf("UPDATE cliente_instalaciones SET instalacion_latitud_et3=%s WHERE instalacion_gw_et3='%s';", $gw_latitud, $gw_id);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR";
			}
			else 
			{
				echo "OK";	
			}
		}
	}
	
}
else
{
	echo "ERROR";
}        	
mysql_close($link);
?>