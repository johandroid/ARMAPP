<?php
session_start();
include 'inc/datos_db.inc';
include 'inc/funciones_db.inc';

//$_SESSION['opcion_idioma'] = 'en';
$instalacion=$_POST['instalacionid'];
$hora_calculo=$_POST['fechacalculo'];
$cliente_db=$_POST['dbname'];

$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
echo sObtener_Fecha_Desde_String($cliente_db, $instalacion, $hora_calculo, $zona_horaria)."\r\n";
?>