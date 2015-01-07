<?php
echo "<markers>";

include 'inc/datos_db.inc';
require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();
$mifirePHP = FirePHP::getInstance(true); 

$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_db = $_GET["cliente_db"];
$instalacion_id = $_GET["instalacion_id"];

mysql_select_db($cliente_db, $link);

$query = "SELECT nodo_ip, nodo_mac, gw_id as nodo_gw,nodo_onoff,nodo_nombre,nodo_latitud,nodo_longitud,nodo_estado from cliente_nodos WHERE instalacion_id='".$instalacion_id."'  ORDER BY nodo_nombre";
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
	echo "\" lat=\"";
	echo $row['nodo_latitud'];
	echo "\" lng=\"";
	echo $row['nodo_longitud'];
	echo "\" estado=\"";
	echo $row['nodo_estado'];
	echo "\" nombre=\"";
	echo $row['nodo_nombre'];
	echo "\" />";
}

$query = "SELECT gw_id, gw_tipo, gw_onoff,gw_nombre,gw_latitud,gw_longitud,gw_estado from cliente_gateways WHERE instalacion_id='".$instalacion_id."'  ORDER BY gw_latitud DESC , gw_longitud DESC";
//echo $query;
$result2 = mysql_query($query,$link);
$num_rows = mysql_num_rows($result2);
$ilatitud = 0;
$ilongitud = 0;

$iIdx = 0;

while ($row = mysql_fetch_array($result2))
{
	//AMB 03/05/12 Función que introduce los datos del gateway
	if($num_rows > 1 && $iIdx == 0 && ($row['gw_latitud'] != 0 ||  $row['gw_longitud'] != 0))
	{ //AMB 03/05/12 Guardamos las primeras coordenadas para asignar a los no situados
		$ilatitud = $row['gw_latitud'] - 0.01;
		$ilongitud = $row['gw_longitud'] + 0.01;
	}elseif($num_rows == 1)
	{
		$ilatitud = '41.633';
		$ilongitud = '0.8';
	}	
	if($row['gw_longitud'] == 0 && $row['gw_latitud'] == 0) //AMB 03/05/12 Asignamos las coordenadas guardadas para los no situados y las modificamos para el próximo
	{
		echo "<gateway id=\"";
		echo $row['gw_id'];
		echo "\" onoff=\"";
		echo $row['gw_onoff'];
		echo "\" lat=\"";
		echo $ilatitud;
		echo "\" lng=\"";
		echo $ilongitud;
		echo "\" estado=\"";
		echo $row['gw_estado'];
		echo "\" nombre=\"";
		echo $row['gw_nombre'];
		echo "\" tipo=\"";
		echo $row['gw_tipo'];		
		echo "\" />";
		
		$ilatitud = $ilatitud - 0.01;
		$ilongitud = $ilongitud + 0.01;
		
		//AMB 03/05/12 Actualizamos las cooredenadas en la BD
		$query_update = sprintf("UPDATE cliente_gateways SET gw_latitud=%s,gw_longitud=%s WHERE gw_id='%s';", $ilatitud, $ilongitud, $row['gw_id']);
		
		$result_update = mysql_query($query_update,$link);
		if ($result_update)
		{
			echo "OK";	
		}
		else
		{
			echo "ERROR";
		}      
	}
	else {
		echo "<gateway id=\"";
		echo $row['gw_id'];
		echo "\" onoff=\"";
		echo $row['gw_onoff'];
		echo "\" lat=\"";
		echo $row['gw_latitud'];
		echo "\" lng=\"";
		echo $row['gw_longitud'];
		echo "\" estado=\"";
		echo $row['gw_estado'];
		echo "\" nombre=\"";
		echo $row['gw_nombre'];
		echo "\" tipo=\"";
		echo $row['gw_tipo'];		
		echo "\" />";
	}
		
	$iIdx++;
}

$query = "SELECT analizador_id,analizador_direccion,gw_id,analizador_estado,analizador_nombre,analizador_latitud,analizador_longitud from ".$tabla_name_utcs." WHERE instalacion_id='".$instalacion_id."' AND (analizador_latitud!=0 OR analizador_longitud!=0) ORDER BY analizador_nombre ASC";
echo $query;
$result3 = mysql_query($query,$link);
	
while ($row = mysql_fetch_array($result3))
{
	echo "<utc id=\"";
	echo $row['analizador_id'];
	echo "\" direccion=\"";
	echo $row['analizador_direccion'];
	echo "\" gw_id=\"";
	echo $row['gw_id'];
	echo "\" onoff=\"";
	echo $row['analizador_estado'];
	echo "\" estado=\"11";
	echo "\" lat=\"";
	echo $row['analizador_latitud'];
	echo "\" lng=\"";
	echo $row['analizador_longitud'];
	echo "\" nombre=\"";
	echo $row['analizador_nombre'];
	echo "\" />";
}


mysql_close($link);

echo "</markers>";
?>
