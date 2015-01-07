<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_clientes, $link);

$query = "SELECT cliente_id,cliente_nombre FROM clientes_datos order by cliente_nombre";
$result = mysql_query($query,$link);
if(!$result)
{
	echo "ERROR";
}
else
{	
	echo "<clientes>";
	echo "<cliente id=\"0000\" nombre=\"".$idiomas[$_SESSION['opcion_idioma']]['general111']."\" ></cliente>";
	while($row = mysql_fetch_array($result))
	{
		echo "<cliente id=\"";
		echo $row['cliente_id'];
		echo "\" nombre=\"";
		echo $row['cliente_nombre'];
		echo "\" ></cliente>";
	}
	echo "</clientes>";
}

mysql_free_result($result);
mysql_close($link);
?>