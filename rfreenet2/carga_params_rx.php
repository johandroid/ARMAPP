<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT * FROM cliente_config");
$result = mysql_query($query,$link);
echo "<params>";
if(!$result)
{
	echo "error";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo "<configuracion timeout_gw=\"";
		echo $row['config_timeout_gw'];
		echo "\" timeout_gw_unit=\"";
		echo $row['config_timeout_gw_unit'];
		echo "\" timeout_nodo=\"";
		echo $row['config_timeout_nodo'];
		echo "\" timeout_nodo_unit=\"";
		echo $row['config_timeout_nodo_unit'];
		echo "\" timeout_trama=\"";
		echo $row['config_timeout_trama'];
		echo "\" timeout_trama_unit=\"";
		echo $row['config_timeout_trama_unit'];
		echo "\" timeout_utc=\"";
		echo $row['config_timeout_utc'];
		echo "\" timeout_utc_unit=\"";
		echo $row['config_timeout_utc_unit'];
		echo "\" soap_habilitado=\"";
		echo $row['config_soap_habilitado'];
		echo "\" soap_ip=\"";
		echo $row['config_soap_ip'];
		echo "\" soap_puerto=\"";
		echo $row['config_soap_puerto'];
		echo "\" soap_contexto=\"";
		echo $row['config_soap_contexto'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>