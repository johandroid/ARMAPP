<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_id,gw_nombre FROM cliente_gateways where instalacion_id='%s' ORDER BY gw_nombre;", $instalacion);
$result = mysql_query($query,$link);

$query2 = sprintf("SELECT nodo_ip,nodo_nombre,nodo_mac,gw_id FROM cliente_nodos where instalacion_id='%s' AND nodo_latitud!=0 and nodo_longitud!=0 ORDER BY nodo_nombre;", $instalacion);
$result2 = mysql_query($query2,$link);

echo "<instalacion>";
if((!$result) && (!$result2))
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<gateway id=\"";
		echo $row['gw_id'];
		echo "\" nombre=\"";
		echo $row['gw_nombre'];
		echo "\" ></gateway>";
	}

	while($row = mysql_fetch_array($result2))
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
echo "</instalacion>";

mysql_free_result($result);
mysql_close($link);
?>