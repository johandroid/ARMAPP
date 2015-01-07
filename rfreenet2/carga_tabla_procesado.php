<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';


$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

$gw_id = $_GET["gw_id"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];


$num_filas_tabla=13;
$ancho_1 = '16%';
$ancho_2 = '10%';
$ancho_3 = '10%';
$ancho_4 = '10%';
$ancho_5 = '10%';
$ancho_6 = '10%';
$ancho_7 = '12%';
$ancho_8 = '12%';
$ancho_9 = '10%';

//Se convierte la hora a la del servidor

$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
if ($fecha_begin != "0")
{
	$fecha_begin = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_begin,$zona_horaria);
	//echo $fecha_begin;
}
if ($fecha_end != "0")
{
	$fecha_end = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_end,$zona_horaria);
	//echo $fecha_end;
}

$pagina = $_GET["pagina"];

$link = mysql_connect($db_host, $db_user, $db_pass);
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
	
	//$fecha_begin = $anyo_begin."-".$mes_begin."-".$dia_begin." 00:00:00";
	//$fecha_end = $anyo_end."-".$mes_end."-".$dia_end." 00:00:00";
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

	//$fecha_begin = $anyo_begin."-".$mes_begin."-0".$dia_begin." 00:00:00";
	//$fecha_end = $anyo_end."-".$mes_end."-".$dia_end." 00:00:00";
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
$query2 ="select count(*) from (".$query.") as cuenta";
//			$query.=" ORDER BY evento_fecha)";
//echo $query_final."<br>";
	
$query .= " ORDER BY fecha DESC LIMIT ";
if ($pagina > 1)
{
	$query .= (($pagina-1)*$num_filas_tabla).",";		
}
$query .= "$num_filas_tabla";

		//echo $query.'<br>';
		//echo $query2.'<br>';
$result = mysql_query($query,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
	
if ($query2 != "")
{
	//echo $query2.'<br>';
	$result2 = mysql_query($query2,$link);// or die('DIE:'.mysql_error()."<br>");
	if ($result2)
	{
		if($row = mysql_fetch_array($result2))
		{
			//echo $row[0].'<br>';
			$num_total_filas= $row[0];
			//echo pad_izquierda($num_total_filas,15,'0').'<br>';
			echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
		}
		mysql_free_result($result2);
	}
	else
	{
		$num_total_filas= $num_filas_tabla;
		echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
		$result2 = false;
	}
}
else
{
	$num_total_filas= $num_filas_tabla;
	echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
	$result = false;
}

$alto='25px';
//echo $query."<br>";
//echo $query2."<br>";
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" id=\"tabula_datos\" style=\"overflow:hidden;width:100%;whitespace:nowrap;text-overflow:ellipsis;table-layout:fixed;word-wrap:break-word;\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general145']."</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general128']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general317']."</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general316']."</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general321']."</td>";
echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general319']."</td>";
echo "<td align=\"center\" width=\"$ancho_7\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['sensor_type21']."</td>";
echo "<td align=\"center\" width=\"$ancho_8\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general315']."</td>";
echo "<td align=\"center\" width=\"$ancho_9\" class=\"RFNETBold\">ET0</td>";
echo "<td align=\"center\" width=\"$ancho_9\" class=\"RFNETBold\">ETc</td>";

echo "</tr>";

if(!$result2)
{
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"10\"><br/></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"10\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"10\"><br/></td></tr>";
	$cuenta_filas = $num_filas_tabla;
}
else if(!$result)
{
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
}
else
{
	if (mysql_num_rows($result)==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"10\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"10\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"10\"><br/></td></tr>";
		$cuenta_filas = $num_filas_tabla;
	}
	else
	{
		$cuenta_filas = 0;
		while ($row = mysql_fetch_array($result))
		{
			if ((($cuenta_filas)%2) == 0)
			{
				echo "<tr class=\"tipo_fila_2\" height=\"$alto\">";
			}
			else
			{
				 echo "<tr class=\"tipo_fila_1\" height=\"$alto\">";
			}
			
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">"./*$row['fecha']*/sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['fecha'],$zona_horaria)."</td>";
			
			if ($row['nombre']=='')
			{
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."</td>";
				
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".utf8_encode($row['nombre'])."</td>";
			}
			
			echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".utf8_encode(round($row['temp_min'], 2))." ºC</td>";
			echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".utf8_encode(round($row['temp_max'], 2))." ºC</td>";
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\">".utf8_encode(round($row['hum_media'], 2))." %</td>";
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\">".utf8_encode(round($row['velocidad'], 2))." km/h</td>";
			echo "<td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\">".utf8_encode(round($row['rad_media'], 3))." W/m2</td>";
			echo "<td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\">".utf8_encode(round($row['pluviometro'], 2))." mm</td>";
			echo "<td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\">".utf8_encode(round($row['referencia'], 3))." mm</td>";
			echo "<td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\">".utf8_encode(round($row['calculo'], 3))." mm</td>";
			
			echo "</tr>";
			$cuenta_filas++;
		}
	}

	while ($cuenta_filas < $num_filas_tabla)
	{
		if ((($cuenta_filas)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_8\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_9\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		
		$cuenta_filas++;
	}
}
echo "</table>";
//echo $query_final."<br>";
if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);
?>
