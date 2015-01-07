<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_id = $_GET["cliente_id"];
$cliente_nombre = $_GET["cliente_nombre"];
$cliente_direccion = $_GET["cliente_direccion"];
$cliente_localidad = $_GET["cliente_localidad"];
$cliente_provincia = $_GET["cliente_provincia"];
$cliente_telefono = $_GET["cliente_telefono"];
$cliente_contacto = $_GET["cliente_contacto"];
$cliente_email = $_GET["cliente_email"];
$cliente_web = $_GET["cliente_web"];

$cliente_email_comercial1 = $_GET["cliente_email_comercial1"];
$cliente_email1_on = $_GET["cliente_email1_on"];
$cliente_email1_idioma = $_GET["cliente_email1_idioma"];
$cliente_email2_on = $_GET["cliente_email2_on"];
$cliente_email_comercial2 = $_GET["cliente_email_comercial2"];
$cliente_email2_idioma = $_GET["cliente_email2_idioma"];
$cliente_evento_nodo_off = $_GET["cliente_evento_nodo_off"];
$cliente_evento_gw_off = $_GET["cliente_evento_gw_off"];
$cliente_evento_utc_off = $_GET["cliente_evento_utc_off"];
$cliente_evento_nodo_bat = $_GET["cliente_evento_nodo_bat"];
$cliente_evento_gw_bat = $_GET["cliente_evento_gw_bat"];
$cliente_evento_nodo_cob = $_GET["cliente_evento_nodo_cob"];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("UPDATE clientes_datos SET cliente_direccion='%s',cliente_localidad='%s',cliente_provincia='%s',cliente_telefono='%s',cliente_contacto='%s',cliente_email='%s',cliente_web='%s',cliente_email_ventas1_on='%s',cliente_email_ventas1='%s',cliente_email_ventas1_idioma='%s',cliente_email_ventas2_on='%s',cliente_email_ventas2='%s',cliente_email_ventas2_idioma='%s',cliente_notificacion_gwoff='%s',cliente_notificacion_utroff='%s',cliente_notificacion_utcoff='%s',cliente_notificacion_gwbat='%s',cliente_notificacion_utrbat='%s',cliente_notificacion_utrcob='%s' where cliente_id='%s'", $cliente_direccion, $cliente_localidad,$cliente_provincia, $cliente_telefono,$cliente_contacto,$cliente_email,$cliente_web,$cliente_email1_on,$cliente_email_comercial1,$cliente_email1_idioma,$cliente_email2_on,$cliente_email_comercial2,$cliente_email2_idioma,$cliente_evento_gw_off,$cliente_evento_nodo_off,$cliente_evento_utc_off,$cliente_evento_gw_bat,$cliente_evento_nodo_bat,$cliente_evento_nodo_cob,$cliente_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general1']." ".$cliente_nombre." ".$idiomas[$_SESSION['opcion_idioma']]['general174'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general175']." ".$cliente_nombre;
}
mysql_close($link);
?>