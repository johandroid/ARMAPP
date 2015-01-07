<?php
session_start();
include 'inc/datos_db.inc';
//include 'inc/idiomas.inc';
include 'inc/funciones_db.inc';

//$_SESSION['opcion_idioma'] = 'en';
$instalacion=$_POST['instalacionid'];
$hora_calculo=$_POST['horacalculo'];
$fecha_anterior=$_POST['fechaanterior'];
$fecha_ahora=$_POST['fechaahora'];
$cliente_db=$_POST['dbname'];

$timezone_server = date_default_timezone_get();

$fecha_anterior_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_anterior);
$fecha_ahora_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_ahora);

//echo "Fecha anterior ".date_format($fecha_anterior_datetime, 'Y-m-d H:i:s')." y ahora ".date_format($fecha_ahora_datetime, 'Y-m-d H:i:s')."\r\n";

$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
//echo $zona_horaria.'<br/>';

//Aqui se pasan esos datetime a la hora de la instalacion
date_timezone_set($fecha_anterior_datetime,timezone_open($zona_horaria));
date_timezone_set($fecha_ahora_datetime,timezone_open($zona_horaria));

//echo "Fecha anterior hora inst ".date_format($fecha_anterior_datetime, 'Y-m-d H:i:s')." y ahora ".date_format($fecha_ahora_datetime, 'Y-m-d H:i:s')."\r\n";

$fecha_et = date_format($fecha_ahora_datetime, 'Y-m-d ');
$fecha_et .= $hora_calculo;

$fecha_calculo = date_create_from_format('Y-m-d H:i:s',$fecha_et,timezone_open($zona_horaria));

//Si la hora a la que habia que calcular la ET es mayor que la hora a la que se calculo la ultima ET
//y ademas menor a la hora actual, es que si que hay que calcular una ET
//echo date_format($fecha_calculo, 'Y-m-d H:i:s').'<br/>';
//echo date_format($fecha_anterior_datetime, 'Y-m-d H:i:s').' < '.date_format($fecha_calculo, 'Y-m-d H:i:s').' <= '.date_format($fecha_ahora_datetime, 'Y-m-d H:i:s').'<br/>';
if($fecha_calculo>$fecha_anterior_datetime && $fecha_calculo<=$fecha_ahora_datetime)
{
	echo "1\r\n";
	//date_sub($fecha_calculo, date_interval_create_from_date_string('1 day'));
	
	
	//Se le cambia la zona horaria a la del server para guardar el string con la fecha de inicio
	date_timezone_set($fecha_calculo,timezone_open($timezone_server));
	//$fecha_inicio_calculo = date_format($fecha_calculo, 'Y-m-d H:i:s');
	
	//Ahora se le suma al datetime 23:59:59 para sacar la fecha fin
	//date_add($fecha_calculo, date_interval_create_from_date_string('23 hours + 59 minutes + 59 seconds'));
	$fecha_fin_calculo = date_format($fecha_calculo, 'Y-m-d H:i:s');
	
	echo /*$fecha_inicio_calculo."\r\n".*/$fecha_fin_calculo."\r\n";
}
else
{
	echo "0\r\n \r\n";
}
?>