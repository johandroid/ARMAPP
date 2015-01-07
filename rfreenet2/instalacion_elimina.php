<?
include 'inc/datos_db.inc';
$instalacion_id = $_GET["instalacion_id"];
$instalacion_nombre = $_GET["instalacion_nombre"];
$cliente_db_inst = $_GET['cliente_db'];

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db_inst, $link);

$query = sprintf("DELETE FROM cliente_instalaciones where instalacion_id='%s'", $instalacion_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general7']." '".$instalacion_nombre."' ".$idiomas[$_SESSION['opcion_idioma']]['general228'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala9']." '".$instalacion_nombre."'";
}
mysql_close($link);
?>