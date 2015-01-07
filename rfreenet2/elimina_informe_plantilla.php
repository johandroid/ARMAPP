<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$plantilla_id = $_GET["plantilla_id"];
$cliente_db = $_GET['cliente_db'];

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

$query = sprintf("DELETE FROM cliente_plantillas where plantilla_id='%s'", $plantilla_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['plantilla9'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_plantilla5'];
}
mysql_close($link);
?>