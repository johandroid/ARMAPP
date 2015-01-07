<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$cliente_id = $_GET["cliente_id"];
$nuevo_saldo = $_GET["nuevo_saldo"];
$operacion = $_GET['operacion'];

mysql_select_db($db_name_clientes, $link);

if ($operacion == 'R')
{
	$query = sprintf("UPDATE clientes_datos SET cliente_saldo_sms=IF(cliente_saldo_sms>%s, cliente_saldo_sms - %s, 0) WHERE cliente_id='%s';",$nuevo_saldo,$nuevo_saldo,$cliente_id);
}
else
{
	$query = sprintf("UPDATE clientes_datos SET cliente_saldo_sms=cliente_saldo_sms + %s WHERE cliente_id='%s';",$nuevo_saldo,$cliente_id);
}
//echo $query;
$result = mysql_query($query,$link);
if(!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_sms9'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['sms_text2'];
}
mysql_close($link);
?>