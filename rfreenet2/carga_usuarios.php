<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_id = $_GET["cliente_id"];

mysql_select_db($db_name_clientes, $link);

if ($cliente_id=='0000')
{
	$query = "SELECT usuario_id,usuario_nombre,usuario_perfil,usuario_email,cliente_id FROM clientes_usuarios ORDER BY usuario_nombre";
}
else
{
	$query = sprintf("SELECT usuario_id,usuario_nombre,usuario_perfil,usuario_email,cliente_id FROM clientes_usuarios where cliente_id='%s' ORDER BY usuario_nombre", $cliente_id);
}
$result = mysql_query($query,$link);
if(!$result)
{
	echo "ERROR";
}
else
{
	echo "<usuarios>";
	while($row = mysql_fetch_array($result))
	{
		echo "<usuario id=\"";
		echo $row['usuario_id'];
		echo "\" nombre=\"";
		echo $row['usuario_nombre'];
		echo "\" perfil=\"";
		echo $row['usuario_perfil'];
		echo "\" email=\"";
		echo $row['usuario_email'];
		echo "\" cliente=\"";
		echo $row['cliente_id'];
		echo "\"> </usuario>";
	}
	echo "</usuarios>";
}

mysql_free_result($result);
mysql_close($link);
?>