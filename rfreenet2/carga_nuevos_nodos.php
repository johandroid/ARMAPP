<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT nodo_ip,nodo_nombre,nodo_mac,gw_id FROM cliente_nodos where instalacion_id='%s' AND nodo_latitud=0 and nodo_longitud=0;", $instalacion);
$result = mysql_query($query,$link);
echo "<nodos>";
if(!$result)
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<nodo ip=\"";
		echo $row['nodo_ip'];
		echo "\" nombre=\"";
		echo $row['nodo_nombre'];
		echo "\" mac=\"";
		echo $row['nodo_mac'];
		echo "\" gw=\"";
		echo $row['gw_id'];
		echo "\" ></nodo>";
	}
}
echo "</nodos>";

mysql_free_result($result);
mysql_close($link);
?>