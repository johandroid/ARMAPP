<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$alarma_id = $_GET["idAl"];
$alarma_tabla = $_GET["tabla"];
$cliente_db_inst = $_GET['cliente_db'];

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db_inst, $link);

$query = sprintf("UPDATE cliente_alarmas_%s SET alarma_repuesta='1',alarma_fecha_repuesta=NOW(),alarma_usuario_repuesta='%s' where alarma_id='%s'", $alarma_tabla, $_SESSION['usuario'], $alarma_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general303']." ".$idiomas[$_SESSION['opcion_idioma']]['general228'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala16'];
}
mysql_close($link);
?>