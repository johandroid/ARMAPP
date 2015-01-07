<?
include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);

$min_filas_tabla = 7;
$cifras_num_sms = 12;

$instalacion = $_GET["instalacion_id"];
$cliente = $_GET["cliente_id"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];

mysql_select_db($db_name_clientes, $link);

$query = "";

//$NombreTabla="cliente_eventos_".date(mY);
if($fecha_begin !=0 && $fecha_end!=0)
{
	//echo "Fecha inicio ".$fecha_begin." Fecha fin ".$fecha_end."<br>";
	list($fecha_begin_ex,$hora_init_ex)= explode (" ",$fecha_begin);
	list($fecha_end_ex,$hora_end_ex)= explode (" ",$fecha_end);
	
	list($anyo_begin,$mes_begin,$pipo)= explode ("-",$fecha_begin_ex);
	list($anyo_end,$mes_end,$pipo)= explode("-",$fecha_end_ex);		
}
else
{
	$mes_begin = date(m);
	$mes_end = date(m);
	$anyo_begin = date(Y);
	$anyo_end = date(Y);
}	

//echo "Mes inicio ".intval($mes_begin)." Mes fin ".intval($mes_end)."<br>";
//echo "Anyo inicio ".intval($anyo_begin)." Anyo fin ".intval($anyo_end)."<br>";

$query_final = "select count(*) from (";
$i=0;	
//echo $query_final."<br>";
if(($fecha_begin ==0) || ($fecha_end==0))
{
	if ($mes_begin == 1)
	{
		$mes_begin = 12;
		$mes_end=intval($mes_end);
		$anyo_begin=intval($anyo_begin)-1;
		$anyo_end=intval($anyo_end);
	}
	else
	{
		$mes_begin=intval($mes_begin)-1;
		$mes_end=intval($mes_end);
		$anyo_begin=intval($anyo_begin);
		$anyo_end=intval($anyo_end);
	}	
}
else
{
	$mes_begin=intval($mes_begin);
	$mes_end=intval($mes_end);
	$anyo_begin=intval($anyo_begin);
	$anyo_end=intval($anyo_end);
}
//echo "Mes inicio ".$mes_begin." Mes fin ".$mes_end."<br>";
//echo "Anyo inicio ".$anyo_begin." Anyo fin ".$anyo_end."<br>";
$mes_actual=$mes_begin;
$anyo_actual=$anyo_begin;

$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_begin);
$cadena_final=sprintf("%02u%04u",$anyo_actual,$anyo_end);
$cadena_actual=$cadena_inicial;
$primero = 1;

while($cadena_actual!='FIN')
{
	$NombreTabla = "clientes_sms_".$cadena_actual;
	$queryaux='';
	if (table_exists($NombreTabla, $link)) 
	{

		if($primero!=1)
		{
			$query_final .= " UNION ";
			//echo $query_final."<br>";
			$queryaux = "";
		}
		//echo $query_final."<br>";		
		//echo $NombreTabla.'<br>';
		$query = sprintf("(select * from %s  WHERE sms_enviado='0' ", $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla);

		if ($cliente != '0000')
		{
			$queryaux .= " AND ".$NombreTabla.".cliente_id='".$cliente."' ";
		}
		if ($instalacion != '0000')
		{
			 $queryaux .= " AND ".$NombreTabla.".instalacion_id='".$instalacion."' ";
		}
		if ($fecha_begin != 0)
		{
			$queryaux .= " AND sms_fecha_out>='".$fecha_begin."' ";
		}
		if ($fecha_end != 0)
		{
			$queryaux .= " AND sms_fecha_out<='".$fecha_end."' ";
		}
		
		$query.=$queryaux;
		$query.=")";
		$query_final.=$query;
		//echo $query_final."<br>";
		$primero = 0;
	}
	
	if ($anyo_actual<$anyo_end)
	{
		//echo 'ActualY='.$anyo_actual.' ENDY='.$anyo_end.'<br>';
		if ($mes_actual<12)
		{
			$mes_actual++;
		}
		else
		{
			$mes_actual=1;
			$anyo_actual++;
		}
		$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
		//echo $cadena_actual.'<br>';
	}
	else if ($anyo_actual==$anyo_end)
	{
		//echo 'ActualM='.$mes_actual.' ENDM='.$mes_end.'<br>';
		if ($mes_actual<$mes_end)
		{
			$mes_actual++;
			$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
		}
		else
		{
			$cadena_actual='FIN';
		}
		//echo $cadena_actual.'<br>';
	}
}
if (($query_final != "") && ($primero != 1))
{
	$query_final .= ") AS tabla_final";	
	//echo $query_final.'<br>';
	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
}
else
{
	echo pad_izquierda(0,$cifras_num_sms,'0');
	$result = false;
}

if(!$result)
{	
	echo pad_izquierda(0,$cifras_num_sms,'0');
	$result = false;
}
else
{
	//$numero_sms = mysql_num_rows($result);
	//echo pad_izquierda($numero_sms,$cifras_num_sms,'0');
	if ($row = mysql_fetch_array($result))
	{
		echo pad_izquierda($row[0],$cifras_num_sms,'0');
	}
	else
	{
		echo pad_izquierda(0,$cifras_num_sms,'0');
		$result = false;		
	}
}
echo $query_final.'<br>'; 

if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);
?>
