<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT * FROM rfreenet_config_eventos");
$result = mysql_query($query,$link);
echo "<params>";
if(!$result)
{
	echo "ERROR";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo "<configuracion eventos_cobertura_nodo=\"";
		echo $row['eventos_cobertura_nodo'];
		echo "\" eventos_bateria_nodo=\"";
		echo $row['eventos_bateria_nodo'];		
		echo "\" eventos_alimentacion_gw=\"";
		echo $row['eventos_alimentacion_gw'];
		echo "\" eventos_bateria_gw=\"";
		echo $row['eventos_bateria_gw'];
		echo "\" eventos_bateria_gw_low=\"";
		echo $row['eventos_bateria_gw_low'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>