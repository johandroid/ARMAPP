<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link2 = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$instalacion_nombre = $_GET["instalacion_nombre"];
$cliente_db_inst = $_GET['cliente_db'];
$cliente_id_inst = $_GET['cliente_id'];

$iFinal=0;

//echo '<br>'.$cliente_db_inst.'<br>';
mysql_select_db($cliente_db_inst, $link2);

$query2 = sprintf("DELETE FROM cliente_gateways where instalacion_id='%s'", $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala6']." '$instalacion_nombre'\r\n";
	$iFinal++;
}

$query2 = sprintf("DELETE FROM cliente_params_gw where instalacion_id='%s'", $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala6']." '$instalacion_nombre'\r\n";
	$iFinal++;
}

$query2 = sprintf("DELETE FROM cliente_nodos where instalacion_id='%s'", $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala7']." '$instalacion_nombre'\r\n";
	$iFinal++;
}

$query2 = sprintf("DELETE FROM cliente_params_nodo where instalacion_id='%s'", $instalacion_id);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala7']." '$instalacion_nombre'\r\n";
	$iFinal++;
}

mysql_select_db($db_name_clientes, $link2);

$query2 = sprintf("DELETE FROM clientes_suscriptores where instalacion_id='%s' and cliente_id='%s'", $instalacion_id,$cliente_id_inst);
//echo '<br>'.$query2.'<br>';
$result2 = mysql_query($query2,$link2);
if (!$result2)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala8']." '$instalacion_nombre'\r\n";
	$iFinal++;
}

if ($iFinal == 0)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['instala_text3'];
}
mysql_close($link2);
?>