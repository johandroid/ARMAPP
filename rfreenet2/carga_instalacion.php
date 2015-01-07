<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_id,gw_nombre FROM cliente_gateways where instalacion_id='%s' ORDER BY gw_nombre ASC;", $instalacion);
$result = mysql_query($query,$link);

$query2 = sprintf("SELECT nodo_ip,nodo_nombre,nodo_mac FROM cliente_nodos where instalacion_id='%s' AND (nodo_latitud!=0 OR nodo_longitud!=0) ORDER BY nodo_nombre;", $instalacion);
$result2 = mysql_query($query2,$link);

$query3 = sprintf("SELECT analizador_id,analizador_direccion,analizador_nombre FROM cliente_analizadores where instalacion_id='%s' AND (analizador_latitud!=0 OR analizador_longitud!=0) ORDER BY analizador_nombre;", $instalacion);
$result3 = mysql_query($query3,$link);

echo "<instalacion>";
if((!$result) && (!$result2) && (!$result3))
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
		echo "\" ></nodo>";
	}
	
	while($row = mysql_fetch_array($result3))
	{
		echo "<utc id=\"";
		echo $row['analizador_id'];
		echo "\" nombre=\"";
		echo $row['analizador_nombre'];
		echo "\" direccion=\"";
		echo $row['analizador_direccion'];
		echo "\" ></utc>";
	}
}
echo "</instalacion>";

mysql_free_result($result);
mysql_close($link);
?>
