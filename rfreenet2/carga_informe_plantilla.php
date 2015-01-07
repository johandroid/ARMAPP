<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$usuario_nombre = $_GET["usuario_nombre"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT plantilla_id,plantilla_nombre FROM %s where instalacion_id='%s' AND user_id=(SELECT usuario_id FROM rfreenet_clientes.clientes_usuarios WHERE usuario_nombre='%s');", $tabla_name_plantillas, $instalacion, $usuario_nombre);
$result = mysql_query($query,$link);
//echo $query;
echo "<plantillas>";
if((!$result) && (!$result2))
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<plantilla id=\"";
		echo $row['plantilla_id'];
		echo "\" nombre=\"";
		echo $row['plantilla_nombre'];
		echo "\" ></plantilla>";
	}
}
echo "</plantillas>";

mysql_free_result($result);
mysql_close($link);
?>