<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_db.inc';

$instalacion = $_GET["instalacion_id"];
$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];
$num_pestana = 1;
$salida = array();
$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

ob_start();
?>
<?php include "contenido_tooltip_gw_low.php";?>

<?
$salida1 = ob_get_clean();
$num_pestana = 2;
ob_start();
//ob_end_clean();
?>
<?php include "contenido_tooltip_gw_low.php"; ?>
<?

//echo "Hollaaaa";
$salida2 = ob_get_clean();

//$salida = array($salida1, $salida2);	
array_push($salida, $salida1);
array_push($salida, $salida2);
echo json_encode($salida);
//echo "salida 1 ".$salida[1];
//echo "salida 2 ".$salida[1];
mysql_free_result($result);
mysql_close($link);
?>