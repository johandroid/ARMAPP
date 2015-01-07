<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$gw_id = $_GET["gw_id"];
$nodo_mac = $_GET["nodo_mac"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE cliente_nodos SET nodo_imagen=(SELECT cliente_imagen_nodo_aux FROM cliente_aux WHERE gw_id='%s' AND nodo_mac='%s') WHERE gw_id='%s' AND nodo_mac='%s';", $gw_id,$nodo_mac,$gw_id,$nodo_mac);
//echo $query;
$result = mysql_query($query,$link);
if ($result)
{
	$query = sprintf("DELETE FROM cliente_aux WHERE gw_id='%s' AND nodo_mac='%s';", $gw_id, $nodo_mac);
	//echo $query;
	$result = mysql_query($query,$link);
	if (!$result)
	{
		echo "ERROR";	
	}		
}
else
{
	echo "ERROR";
}        	
mysql_close($link);
?>