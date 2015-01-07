<?php
session_start();
echo "<markers>";

include 'inc/datos_db.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_db = $_GET["cliente_db"];
$instalacion_id = $_GET["instalacion_id"];

mysql_select_db($cliente_db, $link);

$query = "SELECT nodo_ip,nodo_mac,gw_id as nodo_gw,nodo_onoff,nodo_nombre,nodo_bateria,nodo_estado from cliente_nodos WHERE instalacion_id='".$instalacion_id."' AND (nodo_latitud!=0 or nodo_longitud!=0) ORDER BY nodo_nombre";
//echo $query;
$result = mysql_query($query,$link);

while ($row = mysql_fetch_array($result))
{
	echo "<nodo ip=\"";
	echo $row['nodo_ip'];
	echo "\" mac=\"";
	echo $row['nodo_mac'];
	echo "\" gw=\"";
	echo $row['nodo_gw'];
	echo "\" onoff=\"";
	echo $row['nodo_onoff'];
	echo "\" estado=\"";
	echo $row['nodo_estado'];
	echo "\" nombre=\"";
	echo $row['nodo_nombre'];
	echo "\" bateria=\"";
	echo $row['nodo_bateria'];
	echo "\" />";
}

$query = "SELECT gw_id,gw_nombre,gw_onoff,gw_bateria,gw_alimentacion,gw_estado,gw_tipo from cliente_gateways WHERE instalacion_id='".$instalacion_id."' AND (gw_latitud!=0 OR gw_longitud!=0) ORDER BY gw_nombre ASC";
//echo $query;
$result2 = mysql_query($query,$link);
	
while ($row = mysql_fetch_array($result2))
{
	echo "<gateway id=\"";
	echo $row['gw_id'];
	echo "\" onoff=\"";
	echo $row['gw_onoff'];
	echo "\" estado=\"";
	echo $row['gw_estado'];
	echo "\" nombre=\"";
	echo $row['gw_nombre'];
	echo "\" alimentacion=\"";
	echo $row['gw_alimentacion'];
	echo "\" bateria=\"";
	echo $row['gw_bateria'];
	echo "\" tipo=\"";
	echo $row['gw_tipo'];		
	echo "\" />";
}

$query = "SELECT analizador_id,analizador_direccion,gw_id,analizador_estado,analizador_nombre,analizador_vector_errores,analizador_vector_alarmas,analizador_vector_warnings from ".$tabla_name_utcs." WHERE instalacion_id='".$instalacion_id."' AND (analizador_latitud!=0 OR analizador_longitud!=0) ORDER BY analizador_nombre ASC";
//echo $query;
$result2 = mysql_query($query,$link);
	
while ($row = mysql_fetch_array($result2))
{
	echo "<utc id=\"";
	echo $row['analizador_id'];
	echo "\" direccion=\"";
	echo $row['analizador_direccion'];
	echo "\" gw_id=\"";
	echo $row['gw_id'];
	echo "\" onoff=\"";
	echo $row['analizador_estado'];
	//echo "\" estado=\"11";
	if((intval($row['analizador_vector_errores'])!=0) || (intval($row['analizador_vector_alarmas'])!=0) || (intval($row['analizador_vector_warnings'])!=0))
		echo "\" estado=\"13";
	else
		echo "\" estado=\"11";
	echo "\" nombre=\"";
	echo $row['analizador_nombre'];
	echo "\" />";
}

mysql_close($link);

echo "</markers>";
?>
