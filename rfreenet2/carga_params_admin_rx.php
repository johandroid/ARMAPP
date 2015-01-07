<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT * FROM %s", $tabla_name_config);
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
		echo "<configuracion port_udp=\"";
		echo $row['config_port_udp'];
		echo "\" port_tcp=\"";
		echo $row['config_port_tcp'];
		echo "\" port_tcp_tx=\"";
		echo $row['config_port_tcp_tx'];
		echo "\" modo_offline=\"";
		echo $row['config_offline'];
		echo "\" puerto_soap=\"";
		echo $row['config_tcp_soap'];
		echo "\" tiempo_soap=\"";
		echo $row['config_tiempo_sesion'];
		echo "\" tiempo_soap_unit=\"";
		echo $row['config_tiempo_sesion_unit'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>
