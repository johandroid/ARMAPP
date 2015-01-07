<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$nodo_mac = $_GET["nodo_mac"];
$nodo_latitud = $_GET["lat"];
$nodo_longitud = $_GET["lon"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE cliente_nodos SET nodo_latitud=%s,nodo_longitud=%s WHERE nodo_mac='%s';", $nodo_latitud, $nodo_longitud, $nodo_mac);
//echo $query;
$result = mysql_query($query,$link);

if ($result)
{
	echo "OK";	
}
else
{
	echo "ERROR";
} 
       	
mysql_close($link);
?>