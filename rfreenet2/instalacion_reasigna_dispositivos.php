<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$instalacion_id = $_GET["instalacion_id"];
$instalacion_id_nueva = $_GET["instalacion_id_nueva"];
$instalacion_nombre_nueva = $_GET["instalacion_nombre_nueva"];
$cliente_db_inst = $_GET['cliente_db'];
$disp_cliente_id = $_GET['cliente_id'];

$iFinal=0;

//echo '<br>'.$cliente_db_inst.'<br>';
$link2 = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db_inst, $link2);

$query2 = sprintf("UPDATE cliente_gateways SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala10']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

$query2 = sprintf("UPDATE cliente_params_gw SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala10']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

$query2 = sprintf("UPDATE cliente_params_gw_low SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala10']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}
$query2 = sprintf("UPDATE cliente_nodos SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala11']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

$query2 = sprintf("UPDATE cliente_params_nodo SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala11']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

$query2 = sprintf("UPDATE cliente_analizadores SET instalacion_id='%s' where instalacion_id='%s'", $instalacion_id_nueva, $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala11']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

mysql_select_db($db_name_clientes, $link2);

$query2 = sprintf("UPDATE clientes_suscriptores SET instalacion_id='%s' where instalacion_id='%s' and cliente_id='%s'", $instalacion_id_nueva, $instalacion_id, $disp_cliente_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala12']." '$instalacion_nombre_nueva'\r\n";
	$iFinal++;
}

if ($iFinal == 0)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['instala_text5']." '$instalacion_nombre_nueva'";
}
mysql_close($link2);
?>