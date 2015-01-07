<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$usuario_id = $_GET['usuario_id'];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("DELETE FROM clientes_usuarios where usuario_id='%s'", $usuario_id);
//echo $query;
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general32']." ".$idiomas[$_SESSION['opcion_idioma']]['general231'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_user9'];
}
mysql_close($link);
?>