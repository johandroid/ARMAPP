<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$gw_id = $_GET["gw_id"];

mysql_select_db($cliente_db, $link);
$query = sprintf("SELECT gw_latitud FROM %s WHERE instalacion_id='%s' AND gw_id='%s'", $tabla_name_gateways, $instalacion_id, $gw_id);
//echo $query;
$result = mysql_query($query,$link);
if(!$result)
{
	echo "NO";
}
else
{
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		echo $row[0];
	}
	else {
		echo "NO";
	}
}

mysql_free_result($result);
mysql_close($link);
?>