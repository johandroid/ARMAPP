<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET['cliente_db'];

mysql_select_db($cliente_db, $link);

$query = "UPDATE cliente_instalaciones SET ";

for ($i=1;$i<4;$i++)
{
	if($i>1)
		$query .= ",";
	$query .= " instalacion_habilitado_et".$i."=". $_GET['calculo_enable'.$i];
	$query .= " ,instalacion_alias_et".$i."='". $_GET['calculo_alias'.$i]."'";
	$query .= " ,instalacion_gw_et".$i."='". $_GET['calculo_gw'.$i]."'";
	$query .= " ,instalacion_altura_mar_et".$i."='". $_GET['calculo_alturamar'.$i]."'";
	$query .= " ,instalacion_altura_anemometro_et".$i."='". $_GET['calculo_alturaz'.$i]."'";
	$query .= " ,instalacion_coeficiente_cultivo_et".$i."='". $_GET['calculo_coefcultivo'.$i]."'";	
	$query .= " ,instalacion_latitud_et".$i."='". $_GET['calculo_latitud'.$i]."'";
}
$query .= " where instalacion_id='".$instalacion_id."'";
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	
	//echo $idiomas[$_SESSION['opcion_idioma']]['general22']." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general7']." ".$instalacion_nombre;
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_et8'];

}
mysql_close($link);
?>