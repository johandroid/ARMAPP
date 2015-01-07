<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT analizador_id,analizador_nombre,analizador_direccion FROM %s where instalacion_id='%s' ORDER BY analizador_nombre ASC;", $tabla_name_utcs, $instalacion);
$result = mysql_query($query,$link);
echo "<utcs>";
if(!$result)
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
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
echo "</utcs>";

mysql_free_result($result);
mysql_close($link);
?>