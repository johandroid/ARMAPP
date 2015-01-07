<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$utc_id = $_GET["utc_id"];
$utc_latitud = $_GET["lat"];
$utc_longitud = $_GET["lon"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE %s SET analizador_latitud=%s,analizador_longitud=%s WHERE analizador_id='%s';", $tabla_name_utcs, $utc_latitud, $utc_longitud, $utc_id);
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