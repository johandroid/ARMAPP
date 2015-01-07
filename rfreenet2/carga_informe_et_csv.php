<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

$gw_id = $_GET["gw_id"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];

mysql_select_db($cliente_db, $link);

$query = "";

//$NombreTabla="cliente_eventos_".date(mY);
if($fecha_begin !=0 && $fecha_end!=0)
{
	//echo "Fecha inicio ".$fecha_begin." Fecha fin ".$fecha_end."<br>";
	list($fecha_begin_ex,$hora_init_ex)= explode (" ",$fecha_begin);
	list($fecha_end_ex,$hora_end_ex)= explode (" ",$fecha_end);
	
	list($anyo_begin,$mes_begin,$dia_begin)= explode ("-",$fecha_begin_ex);
	list($anyo_end,$mes_end,$dia_end)= explode("-",$fecha_end_ex);		
	
	$fecha_begin = $anyo_begin."-".$mes_begin."-".$dia_begin." 00:00:00";
	$fecha_end = $anyo_end."-".$mes_end."-".$dia_end." 00:00:00";
}
else
{
	$mes_begin = date(m);
	$mes_end = date(m);
	$anyo_begin = date(Y);
	$anyo_end = date(Y);
	if ($mes_end == 1)
	{
		$mes_begin = 12;
		$mes_end=intval($mes_end);
		
		$anyo_begin=(intval($anyo_begin)-1);
		$anyo_end=intval($anyo_end);
	}
	else
	{
		$mes_begin=(intval($mes_begin)-1);
		$mes_end=intval($mes_end);
		$anyo_begin=intval($anyo_begin);
		$anyo_end=intval($anyo_end);
	}
	$dia_begin = 1;
	$dia_end = intval(date(t));

	$fecha_begin = $anyo_begin."-".$mes_begin."-0".$dia_begin." 00:00:00";
	$fecha_end = $anyo_end."-".$mes_end."-".$dia_end." 23:59:59";
}
//echo "Anyo begin".$anyo_begin."<br>";


//echo $fecha_begin." y termina ".$fecha_end."<br>";	
	
$query = sprintf("select cliente_gateways.gw_id AS gw_id,cliente_gateways.instalacion_id as instalacion_id,et_calculo AS calculo,et_temp_max as temp_max, et_temp_min as temp_min, et_hum_media as hum_media, et_velocidad as velocidad, et_rad_media as rad_media, et_pluviometro as pluviometro, et_referencia as referencia, cliente_gateways.gw_nombre AS nombre, et_fecha AS fecha from cliente_gateways inner join %s on cliente_gateways.gw_id = %s.gw_id where %s.instalacion_id='%s'", $tabla_name_et, $tabla_name_et,$tabla_name_et, $instalacion);

if ($gw_id!='000')
{
	$query .= " AND ".$tabla_name_et.".gw_id='".$gw_id."'";
}
if ($fecha_begin != "0")
{
	$query .= " AND et_fecha>'".$fecha_begin."'";
}
if ($fecha_end != "0")
{
	$query .= " AND et_fecha<'".$fecha_end."'";
}			
//			$query.=" ORDER BY evento_fecha)";
//echo $query_final."<br>";
	
$query .= " ORDER BY fecha ASC";

//		echo $query.'<br>';
//		echo $query2.'<br>';
$result = mysql_query($query,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
	
$datos = utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general145'].";".$idiomas[$_SESSION['opcion_idioma']]['general128'].";".$idiomas[$_SESSION['opcion_idioma']]['general317'].";".$idiomas[$_SESSION['opcion_idioma']]['general316'].";".$idiomas[$_SESSION['opcion_idioma']]['general321'].";".$idiomas[$_SESSION['opcion_idioma']]['general319'].";".$idiomas[$_SESSION['opcion_idioma']]['sensor_type21'].";".$idiomas[$_SESSION['opcion_idioma']]['general315'].";ET0;ETc;\r\n");

if($result)
{
	while ($row = mysql_fetch_array($result))
	{
		$datos .= $row['fecha'].";";
				
		if ($row['nombre']=='')
		{
			$datos .= $idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id'].";";
		}
		else
		{
			$datos .= utf8_encode($row['nombre']).";";
		}
				
		$datos .=utf8_encode(round($row['temp_min'], 2))." ºC;".utf8_encode(round($row['temp_max'], 2))." ºC;".utf8_encode(round($row['hum_media'], 2))." %;";
		$datos .=utf8_encode(round($row['velocidad'], 2))." km/h;".utf8_encode(round($row['rad_media'], 3))." W/m2;".utf8_encode(round($row['pluviometro'], 2))." mm;";
		$datos .=utf8_encode(round($row['referencia'], 3))." mm;".utf8_encode(round($row['calculo'], 3))." mm;\r\n";
	}
}
//echo $query_final."<br>";
if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);

header('Content-Type: application/x-octet-stream');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename='.$idiomas[$_SESSION['opcion_idioma']]['general124'].'_'. date('Ymd')  .'.csv');
header("Content-Length: ".strlen($datos));
echo $datos;
?>
