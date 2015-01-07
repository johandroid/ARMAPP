<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE cliente_gateways SET gw_imagen=(SELECT cliente_imagen_gw_aux FROM cliente_aux WHERE gw_id='%s') WHERE gw_id='%s';", $gw_id, $gw_id);
//echo $query;
$result = mysql_query($query,$link);
if ($result)
{
	$query = sprintf("DELETE FROM cliente_aux WHERE gw_id='%s';", $gw_id);
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