<?php
ini_set('memory_limit','500M');
ini_set('max_execution_time','600');
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';

$cliente_db = $_POST["cliente_db"];
$instalacion = $_POST["instalacion_id"];
$fecha_begin = $_POST["fecha_begin"];
$fecha_end = $_POST["fecha_end"];

$datosgraf = $_POST["datosgraf"];
//echo $datosgraf.'<br/>';
$xmlgraf = simplexml_load_string($datosgraf);

$cadena_ids = '';
$cadena_magnitudes = '';
$acumulado_horario = 0;
$acumulado_diario = 0;
//echo 'Se dibujaran '.$xmlgraf->graf->curve->count().' curvas<br/>';
for ($j=0;$j<$xmlgraf->graf->curve->count();$j++)
{
	$ids_disp[$j]=$xmlgraf->graf->curve[$j]->data;
	$magnitudes_disp[$j]=$xmlgraf->graf->curve[$j]->mag;
	$tipo_graficas[$j]=$xmlgraf->graf->curve[$j]->tipo;
	//MPT para saber si hay que restar un dia/hora si no es lineal alguna
	if($tipo_graficas[$j]==1)
	{
		$acumulado_diario=1;
	}
	elseif($tipo_graficas[$j]==2)
	{
		$acumulado_horario=1;
	}
	//echo 'Insertando curva '.$j.' de '.$xmlgraf->graf->curve[$j]->data.' de tipo '.$xmlgraf->graf->curve[$j]->mag.'<br/>';
	if ($j==0)
	{
		$mag_inicial=$xmlgraf->graf->curve[$j]->mag;
	}
}

/* Convertir aqui las horas a su correspondiente zona horaria*/
$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
if($fecha_end == '0')
{
	$timeout = $fecha_begin;
	//echo $timeout."<br>";
	$fecha_actual = date_create();
	$ts_actual = date_timestamp_get($fecha_actual);
	$ts_anterior = $ts_actual - $timeout;
	$fecha_end = strftime ("%Y-%m-%d %H:%M:%S",$ts_actual);
	$fecha_begin = strftime ("%Y-%m-%d %H:%M:%S",$ts_anterior);
	
	//$fecha_end = sObtener_Fecha_Desde_String($cliente_db, $instalacion_id, $fecha_end, $zona_horaria);
	//$fecha_begin = sObtener_Fecha_Desde_String($cliente_db, $instalacion_id, $fecha_begin, $zona_horaria);
}
else 
{
	
	$fecha_begin = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_begin,$zona_horaria);
	$fecha_end = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_end,$zona_horaria);
}

//$link = mysql_connect($db_host, $db_user, $db_pass);
$link = mysqli_connect($db_host, $db_user, $db_pass);
//mysql_select_db($cliente_db, $link);
mysqli_select_db($link, $cliente_db);


//Como hay que hacer acumulados horarios es mejor cambiar la hora de mysql temporalmente a la que queremos nosotros
$timezone_server = date_default_timezone_get();
//echo date('P');
date_default_timezone_set($zona_horaria);
//echo date('P');
$query = ("SET `time_zone` = '".date('P')."'");
$result = mysqli_query($link, $query) or die('DIE:'.mysqli_error()."<br>".$query);
if(!$result)
{
	mysqli_close($link);
	return;
}
date_default_timezone_set($timezone_server);
 
//echo "Begin: ".$fecha_begin." end ".$fecha_end."<br>";
/**/

list($fecha_begin_ex,$hora_init_ex)= explode (" ",$fecha_begin);
list($fecha_end_ex,$hora_end_ex)= explode (" ",$fecha_end);

list($anyo_begin,$mes_begin,$pipo)= explode ("-",$fecha_begin_ex);
list($anyo_end,$mes_end,$pipo)= explode("-",$fecha_end_ex);

//echo "Mes inicio ".intval($mes_begin)." Mes fin ".intval($mes_end)."<br>";
//echo "Anyo inicio ".intval($anyo_begin)." Anyo fin ".intval($anyo_end)."<br>";

$mes_begin=intval($mes_begin);
$mes_end=intval($mes_end);
$anyo_begin=intval($anyo_begin);
$anyo_end=intval($anyo_end);

// Primero de todo definimos el vector temporal
$timestamp_inicio = strtotime($fecha_begin);
$timestamp_final = strtotime($fecha_end);
//echo $acumulado_diario." y ".$acumulado_horario."<br>";
//MPT Si se ha seleccionado acumulado hay que cambiar el tiempo de inicio
if($acumulado_diario==1)
{
	$timestamp_inicio_diario = strtotime("-1 day",$timestamp_inicio);
	$mes_begin_diario = intval(date("m",$timestamp_inicio_diario));
	$anyo_begin_diario = intval(date("Y",$timestamp_inicio_diario));
	$fecha_begin_acum_diario = date("Y-m-d H:i:s",$timestamp_inicio_diario);
	$anyo_begin = min($anyo_begin, $anyo_begin_diario);
	$mes_begin = min($mes_begin, $mes_begin_diario);
		
}
if($acumulado_horario==1)
{
	$timestamp_inicio_horario = strtotime("-1 hour",$timestamp_inicio);
	$mes_begin_horario = intval(date("m",$timestamp_inicio_horario));
	$anyo_begin_horario = intval(date("Y",$timestamp_inicio_horario));
	$fecha_begin_acum_horario = date("Y-m-d H:i:s",$timestamp_inicio_horario);
	$anyo_begin = min($anyo_begin, $anyo_begin_horario);
	$mes_begin = min($mes_begin, $mes_begin_horario);
}

// Y generamos el vector de abscisas
//$abscisas = range($timestamp_inicio,$timestamp_final,1);
//echo "Long total: ".count($abscisas).'<br/>';
//echo "TS =".$fecha_begin." to ".$fecha_end."<br/>";
//echo "Probando ts desde ".$timestamp_inicio." (".date('Y:m:d H:i:s',$timestamp_inicio).") a ".$timestamp_final." (".date('Y:m:d H:i:s',$timestamp_final).")<br/>";


$data_output = array();
for ($ii=0;$ii<4;$ii++)
{
	$data_series = array();
	if (strlen($ids_disp[$ii])>0)
	{
		$tipo_dispositivo[$ii] = substr($ids_disp[$ii],0,1);
		$gw_id[$ii] = substr($ids_disp[$ii],1,4);
		$nodo_mac[$ii] = substr($ids_disp[$ii],5,12);
		$num_sensor_informe[$ii] = substr($ids_disp[$ii],17,2);
		$tipo_sensor_informe[$ii] = substr($ids_disp[$ii],19,3);
		//echo 'Insertando curva '.($ii+1).' de '.$ids_disp[$ii].' de tipo '.$tipo_sensor_informe[$ii].'<br/>';

		// Preparamos la query para cada grafica
		$query = "";
		$query_final = "select * from (";
		
		$mes_actual=$mes_begin;
		$anyo_actual=$anyo_begin;
		
		$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_begin);
		$cadena_final=sprintf("%02u%04u",$anyo_actual,$anyo_end);
		$cadena_actual=$cadena_inicial;
		$primero = 1;
		
		while($cadena_actual!='FIN')
		{	
			$NombreTabla = "cliente_eventos_".$cadena_actual;
			//echo "ENTRA TRAS FIN ".table_exists($NombreTabla,$link);
			//echo "Vamos a ver si la tabla ".$NombreTabla." existe<br>";
			if (table_exists_i($NombreTabla,$link))
			{//echo "ENTRA TRAS TABLA EXISTE";
				if($primero!=1)
				{//echo "ENTRA TRAS CONSULTA NO PRIMERA";
					$query_final .= " UNION ";
				}
				//echo $magnitudes_disp[$ii];
				//MPT si el tipo de gráfica es continua se hace como siempre
				if($tipo_graficas[$ii]=='0')
				{					
					$query = sprintf("(select cliente_eventos.gw_id AS gw_id,
					                          cliente_eventos.nodo_ip as nodo_ip, 
					                          IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,
					                          IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), cliente_gateways.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
					                          cliente_eventos.evento_codigo AS evento_codigo,
					                          (CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
					                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
					                          									ELSE '12' END) AS versionHW,
					                          (CASE cliente_eventos.evento_codigo WHEN '500' THEN cliente_nodos.nodo_nombre_s1 
					                          									  WHEN '506' THEN cliente_nodos.nodo_nombre_s1 
					                          									  WHEN '512' THEN cliente_nodos.nodo_nombre_s1 
					                          									  WHEN '501' THEN cliente_nodos.nodo_nombre_s2 
					                          									  WHEN '507' THEN cliente_nodos.nodo_nombre_s2 
					                          									  WHEN '513' THEN cliente_nodos.nodo_nombre_s2 
					                          									  WHEN '502' THEN cliente_nodos.nodo_nombre_s3 
					                          									  WHEN '508' THEN cliente_nodos.nodo_nombre_s3 
					                          									  WHEN '514' THEN cliente_nodos.nodo_nombre_s3 
					                          									  WHEN '503' THEN cliente_nodos.nodo_nombre_s4 
					                          									  WHEN '509' THEN cliente_nodos.nodo_nombre_s4 
					                          									  WHEN '515' THEN cliente_nodos.nodo_nombre_s4 
					                          									  WHEN '504' THEN cliente_nodos.nodo_nombre_s5 
					                          									  WHEN '510' THEN cliente_nodos.nodo_nombre_s5 
					                          									  WHEN '516' THEN cliente_nodos.nodo_nombre_s5 
					                          									  WHEN '505' THEN cliente_nodos.nodo_nombre_s6 
					                          									  WHEN '511' THEN cliente_nodos.nodo_nombre_s6 
					                          									  WHEN '517' THEN cliente_nodos.nodo_nombre_s6 
					                          									  WHEN '600' THEN cliente_gateways.gw_nombre_s1 
					                          									  WHEN '625' THEN cliente_gateways.gw_nombre_s1
					                          									  WHEN '650' THEN cliente_gateways.gw_nombre_s1  
					                          									  WHEN '601' THEN cliente_gateways.gw_nombre_s2 
					                          									  WHEN '626' THEN cliente_gateways.gw_nombre_s2
					                          									  WHEN '651' THEN cliente_gateways.gw_nombre_s2  
					                          									  WHEN '602' THEN cliente_gateways.gw_nombre_s3 
					                          									  WHEN '627' THEN cliente_gateways.gw_nombre_s3
					                          									  WHEN '652' THEN cliente_gateways.gw_nombre_s3  
					                          									  WHEN '603' THEN cliente_gateways.gw_nombre_s4 
					                          									  WHEN '628' THEN cliente_gateways.gw_nombre_s4
					                          									  WHEN '653' THEN cliente_gateways.gw_nombre_s4   
					                          									  WHEN '604' THEN cliente_gateways.gw_nombre_s5 
					                          									  WHEN '629' THEN cliente_gateways.gw_nombre_s5
					                          									  WHEN '654' THEN cliente_gateways.gw_nombre_s5  
					                          									  WHEN '605' THEN cliente_gateways.gw_nombre_s6 
					                          									  WHEN '630' THEN cliente_gateways.gw_nombre_s6
					                          									  WHEN '655' THEN cliente_gateways.gw_nombre_s6  
					                          									  WHEN '606' THEN cliente_gateways.gw_nombre_s7 
					                          									  WHEN '631' THEN cliente_gateways.gw_nombre_s7
					                          									  WHEN '656' THEN cliente_gateways.gw_nombre_s7  
					                          									  WHEN '607' THEN cliente_gateways.gw_nombre_s8 
					                          									  WHEN '632' THEN cliente_gateways.gw_nombre_s8
					                          									  WHEN '657' THEN cliente_gateways.gw_nombre_s8  
					                          									  WHEN '608' THEN cliente_gateways.gw_nombre_s9 
					                          									  WHEN '633' THEN cliente_gateways.gw_nombre_s9
					                          									  WHEN '658' THEN cliente_gateways.gw_nombre_s9  
					                          									  WHEN '609' THEN cliente_gateways.gw_nombre_s10 
					                          									  WHEN '634' THEN cliente_gateways.gw_nombre_s10
					                          									  WHEN '659' THEN cliente_gateways.gw_nombre_s10  
					                          									  WHEN '610' THEN cliente_gateways.gw_nombre_s11 
					                          									  WHEN '635' THEN cliente_gateways.gw_nombre_s11
					                          									  WHEN '660' THEN cliente_gateways.gw_nombre_s11   
					                          									  WHEN '611' THEN cliente_gateways.gw_nombre_s12 
					                          									  WHEN '636' THEN cliente_gateways.gw_nombre_s12
					                          									  WHEN '661' THEN cliente_gateways.gw_nombre_s12  
					                          									  WHEN '612' THEN cliente_gateways.gw_nombre_s13 
					                          									  WHEN '637' THEN cliente_gateways.gw_nombre_s13
					                          									  WHEN '662' THEN cliente_gateways.gw_nombre_s13  
					                          									  WHEN '613' THEN cliente_gateways.gw_nombre_s14 
					                          									  WHEN '638' THEN cliente_gateways.gw_nombre_s14
					                          									  WHEN '663' THEN cliente_gateways.gw_nombre_s14  
					                          									  WHEN '614' THEN cliente_gateways.gw_nombre_s15 
					                          									  WHEN '639' THEN cliente_gateways.gw_nombre_s15
					                          									  WHEN '664' THEN cliente_gateways.gw_nombre_s15  
					                          									  WHEN '615' THEN cliente_gateways.gw_nombre_s16 
					                          									  WHEN '640' THEN cliente_gateways.gw_nombre_s16
					                          									  WHEN '665' THEN cliente_gateways.gw_nombre_s16  
					                          									  WHEN '616' THEN cliente_gateways.gw_nombre_s17 
					                          									  WHEN '641' THEN cliente_gateways.gw_nombre_s17
					                          									  WHEN '666' THEN cliente_gateways.gw_nombre_s17  
					                          									  WHEN '617' THEN cliente_gateways.gw_nombre_s18 
					                          									  WHEN '642' THEN cliente_gateways.gw_nombre_s18
					                          									  WHEN '667' THEN cliente_gateways.gw_nombre_s18  
					                          									  WHEN '618' THEN cliente_gateways.gw_nombre_s19 
					                          									  WHEN '643' THEN cliente_gateways.gw_nombre_s19
					                          									  WHEN '668' THEN cliente_gateways.gw_nombre_s19  
					                          									  WHEN '619' THEN cliente_gateways.gw_nombre_s20 
					                          									  WHEN '644' THEN cliente_gateways.gw_nombre_s20
					                          									  WHEN '669' THEN cliente_gateways.gw_nombre_s20  
					                          									  WHEN '620' THEN cliente_gateways.gw_nombre_s21 
					                          									  WHEN '645' THEN cliente_gateways.gw_nombre_s21
					                          									  WHEN '670' THEN cliente_gateways.gw_nombre_s21  
					                          									  WHEN '621' THEN cliente_gateways.gw_nombre_s22 
					                          									  WHEN '646' THEN cliente_gateways.gw_nombre_s22
					                          									  WHEN '671' THEN cliente_gateways.gw_nombre_s22  
					                          									  WHEN '622' THEN cliente_gateways.gw_nombre_s23 
					                          									  WHEN '647' THEN cliente_gateways.gw_nombre_s23
					                          									  WHEN '672' THEN cliente_gateways.gw_nombre_s23 
					                          									  ELSE '-' END) AS sensor_nombre,
					                          cliente_eventos.evento_valor_raw AS valor,
					                          cliente_eventos.evento_tiposensor as tiposensor,
					                          1000*unix_timestamp(cliente_eventos.evento_fecha) AS fecha,
					                          IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
					                          rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
					                          IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
					                          cliente_params_nodo.nodo_aux_operacion%u as operacion,
					                          cliente_params_nodo.nodo_aux_constante%u as constante,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MAX
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MAX
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MAX
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MAX
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MAX
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MAX ELSE 0 END) as maximo_nodo,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MIN
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MIN
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MIN
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MIN
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MIN
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MIN ELSE 0 END) as minimo_nodo,						                          
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MAX
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MAX
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MAX
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MAX
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MAX
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MAX
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MAX
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MAX
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MAX ELSE 0 END) as maximo,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MIN
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MIN
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MIN
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MIN
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MIN
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MIN
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MIN
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MIN
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MIN ELSE 0 END) as minimo,											
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MAX
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MAX
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MAX ELSE 0 END) as maximo_gen,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MIN
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MIN
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MIN ELSE 0 END) as minimo_gen,	
													rfreenet_uds_sensor_generico.nombre nombre_unidad,
													rfreenet_uds_sensor_generico_nodo.nombre nombre_unidad_nodo,
													rfreenet_uds_sensor_generico_gen.nombre nombre_unidad_gen 			                                             
						from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion 
												  right join (%s.cliente_analizadores 
												  right join (%s.cliente_instalaciones 
												  inner join (%s.cliente_gateways join (%s.cliente_nodos right join %s.%s as cliente_eventos on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac AND cliente_eventos.gw_id=cliente_nodos.gw_id)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.gw_id=cliente_analizadores.gw_id AND cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.nodo_ip=cliente_analizadores.analizador_direccion AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_params_nodo.nodo_mac=cliente_eventos.nodo_mac AND cliente_eventos.gw_id=cliente_params_nodo.gw_id)) 
                   left outer join cliente_params_gw on (cliente_eventos.gw_id  = cliente_params_gw.gw_id)                   
                   left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (rfreenet_general.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw.gw_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw.gw_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw.gw_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_gw.gw_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_gw.gw_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_gw.gw_A6UND
                                                                                                                                            WHEN 6 THEN cliente_params_gw.gw_A7UND
                                                                                                                                            WHEN 7 THEN cliente_params_gw.gw_A8UND
                                                                                                                                            WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen on (rfreenet_general.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (rfreenet_general.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                                                                                                                            WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))																																																		    
				                     where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $tipo_gw, $tipo_gw_low, (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1), (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1),$db_name_general,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$NombreTabla, $instalacion);
					$query .= " AND evento_fecha>'".$fecha_begin."'  AND evento_fecha<'".$fecha_end."'";
				}
				elseif ($tipo_graficas[$ii]=='1')
				{
					if($magnitudes_disp[$ii]=='PLU' || $magnitudes_disp[$ii]=='PUL')
					{
						$query = sprintf("(select cliente_eventos.gw_id AS gw_id,
												cliente_eventos.nodo_ip as nodo_ip, 
												IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
												'000',
												cliente_eventos.nodo_mac) AS nodo_mac,
												IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
												cliente_gateways.gw_nombre,												
												IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
												cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
												(CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
					                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
					                          									ELSE '12' END) AS versionHW,
												cliente_eventos.evento_codigo AS evento_codigo,
												(CASE cliente_eventos.evento_codigo WHEN '500' THEN cliente_nodos.nodo_nombre_s1 
														    WHEN '506' THEN cliente_nodos.nodo_nombre_s1 
														    WHEN '512' THEN cliente_nodos.nodo_nombre_s1 
														    WHEN '501' THEN cliente_nodos.nodo_nombre_s2 
														    WHEN '507' THEN cliente_nodos.nodo_nombre_s2 
														    WHEN '513' THEN cliente_nodos.nodo_nombre_s2 
														    WHEN '502' THEN cliente_nodos.nodo_nombre_s3 
														    WHEN '508' THEN cliente_nodos.nodo_nombre_s3 
														    WHEN '514' THEN cliente_nodos.nodo_nombre_s3 
														    WHEN '503' THEN cliente_nodos.nodo_nombre_s4 
														    WHEN '509' THEN cliente_nodos.nodo_nombre_s4 
														    WHEN '515' THEN cliente_nodos.nodo_nombre_s4 
														    WHEN '504' THEN cliente_nodos.nodo_nombre_s5 
														    WHEN '510' THEN cliente_nodos.nodo_nombre_s5 
														    WHEN '516' THEN cliente_nodos.nodo_nombre_s5 
														    WHEN '505' THEN cliente_nodos.nodo_nombre_s6 
														    WHEN '511' THEN cliente_nodos.nodo_nombre_s6 
														    WHEN '517' THEN cliente_nodos.nodo_nombre_s6 
														    WHEN '600' THEN cliente_gateways.gw_nombre_s1 
                      									  WHEN '625' THEN cliente_gateways.gw_nombre_s1
                      									  WHEN '650' THEN cliente_gateways.gw_nombre_s1  
                      									  WHEN '601' THEN cliente_gateways.gw_nombre_s2 
                      									  WHEN '626' THEN cliente_gateways.gw_nombre_s2
                      									  WHEN '651' THEN cliente_gateways.gw_nombre_s2  
                      									  WHEN '602' THEN cliente_gateways.gw_nombre_s3 
                      									  WHEN '627' THEN cliente_gateways.gw_nombre_s3
                      									  WHEN '652' THEN cliente_gateways.gw_nombre_s3  
                      									  WHEN '603' THEN cliente_gateways.gw_nombre_s4 
                      									  WHEN '628' THEN cliente_gateways.gw_nombre_s4
                      									  WHEN '653' THEN cliente_gateways.gw_nombre_s4   
                      									  WHEN '604' THEN cliente_gateways.gw_nombre_s5 
                      									  WHEN '629' THEN cliente_gateways.gw_nombre_s5
                      									  WHEN '654' THEN cliente_gateways.gw_nombre_s5  
                      									  WHEN '605' THEN cliente_gateways.gw_nombre_s6 
                      									  WHEN '630' THEN cliente_gateways.gw_nombre_s6
                      									  WHEN '655' THEN cliente_gateways.gw_nombre_s6  
                      									  WHEN '606' THEN cliente_gateways.gw_nombre_s7 
                      									  WHEN '631' THEN cliente_gateways.gw_nombre_s7
                      									  WHEN '656' THEN cliente_gateways.gw_nombre_s7  
                      									  WHEN '607' THEN cliente_gateways.gw_nombre_s8 
                      									  WHEN '632' THEN cliente_gateways.gw_nombre_s8
                      									  WHEN '657' THEN cliente_gateways.gw_nombre_s8  
                      									  WHEN '608' THEN cliente_gateways.gw_nombre_s9 
                      									  WHEN '633' THEN cliente_gateways.gw_nombre_s9
                      									  WHEN '658' THEN cliente_gateways.gw_nombre_s9  
                      									  WHEN '609' THEN cliente_gateways.gw_nombre_s10 
                      									  WHEN '634' THEN cliente_gateways.gw_nombre_s10
                      									  WHEN '659' THEN cliente_gateways.gw_nombre_s10  
                      									  WHEN '610' THEN cliente_gateways.gw_nombre_s11 
                      									  WHEN '635' THEN cliente_gateways.gw_nombre_s11
                      									  WHEN '660' THEN cliente_gateways.gw_nombre_s11   
                      									  WHEN '611' THEN cliente_gateways.gw_nombre_s12 
                      									  WHEN '636' THEN cliente_gateways.gw_nombre_s12
                      									  WHEN '661' THEN cliente_gateways.gw_nombre_s12  
                      									  WHEN '612' THEN cliente_gateways.gw_nombre_s13 
                      									  WHEN '637' THEN cliente_gateways.gw_nombre_s13
                      									  WHEN '662' THEN cliente_gateways.gw_nombre_s13  
                      									  WHEN '613' THEN cliente_gateways.gw_nombre_s14 
                      									  WHEN '638' THEN cliente_gateways.gw_nombre_s14
                      									  WHEN '663' THEN cliente_gateways.gw_nombre_s14  
                      									  WHEN '614' THEN cliente_gateways.gw_nombre_s15 
                      									  WHEN '639' THEN cliente_gateways.gw_nombre_s15
                      									  WHEN '664' THEN cliente_gateways.gw_nombre_s15  
                      									  WHEN '615' THEN cliente_gateways.gw_nombre_s16 
                      									  WHEN '640' THEN cliente_gateways.gw_nombre_s16
                      									  WHEN '665' THEN cliente_gateways.gw_nombre_s16  
                      									  WHEN '616' THEN cliente_gateways.gw_nombre_s17 
                      									  WHEN '641' THEN cliente_gateways.gw_nombre_s17
                      									  WHEN '666' THEN cliente_gateways.gw_nombre_s17  
                      									  WHEN '617' THEN cliente_gateways.gw_nombre_s18 
                      									  WHEN '642' THEN cliente_gateways.gw_nombre_s18
                      									  WHEN '667' THEN cliente_gateways.gw_nombre_s18  
                      									  WHEN '618' THEN cliente_gateways.gw_nombre_s19 
                      									  WHEN '643' THEN cliente_gateways.gw_nombre_s19
                      									  WHEN '668' THEN cliente_gateways.gw_nombre_s19  
                      									  WHEN '619' THEN cliente_gateways.gw_nombre_s20 
                      									  WHEN '644' THEN cliente_gateways.gw_nombre_s20
                      									  WHEN '669' THEN cliente_gateways.gw_nombre_s20  
                      									  WHEN '620' THEN cliente_gateways.gw_nombre_s21 
                      									  WHEN '645' THEN cliente_gateways.gw_nombre_s21
                      									  WHEN '670' THEN cliente_gateways.gw_nombre_s21  
                      									  WHEN '621' THEN cliente_gateways.gw_nombre_s22 
                      									  WHEN '646' THEN cliente_gateways.gw_nombre_s22
                      									  WHEN '671' THEN cliente_gateways.gw_nombre_s22  
                      									  WHEN '622' THEN cliente_gateways.gw_nombre_s23 
                      									  WHEN '647' THEN cliente_gateways.gw_nombre_s23
                      									  WHEN '672' THEN cliente_gateways.gw_nombre_s23
														    ELSE '-' END) AS sensor_nombre,
												hex(sum(conv(cliente_eventos.evento_valor_raw,16,10))) AS valor,
												cliente_eventos.evento_tiposensor as tiposensor, 
												max(1000*(floor((unix_timestamp(cliente_eventos.evento_fecha))/86400)*86400)) AS fecha,
												IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
												rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
												IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
												rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
												cliente_params_nodo.nodo_aux_operacion%u as operacion,
												cliente_params_nodo.nodo_aux_constante%u as constante, 
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MAX
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MAX
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MAX
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MAX
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MAX
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MAX ELSE 0 END) as maximo_nodo,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MIN
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MIN
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MIN
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MIN
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MIN
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MIN ELSE 0 END) as minimo_nodo,													
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MAX
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MAX
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MAX
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MAX
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MAX
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MAX
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MAX
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MAX
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MAX ELSE 0 END) as maximo,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MIN
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MIN
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MIN
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MIN
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MIN
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MIN
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MIN
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MIN
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MIN ELSE 0 END) as minimo,											
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MAX
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MAX
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MAX ELSE 0 END) as maximo_gen,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MIN
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MIN
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MIN ELSE 0 END) as minimo_gen,	
													rfreenet_uds_sensor_generico.nombre nombre_unidad,
													rfreenet_uds_sensor_generico_nodo.nombre nombre_unidad_nodo,
													rfreenet_uds_sensor_generico_gen.nombre nombre_unidad_gen 			                                             
						from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion 
												  right join (%s.cliente_analizadores 
												  right join (%s.cliente_instalaciones 
												  inner join (%s.cliente_gateways join (%s.cliente_nodos right join %s.%s as cliente_eventos on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac AND cliente_eventos.gw_id=cliente_nodos.gw_id)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.gw_id=cliente_analizadores.gw_id AND cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.nodo_ip=cliente_analizadores.analizador_direccion AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_params_nodo.nodo_mac=cliente_eventos.nodo_mac AND cliente_eventos.gw_id=cliente_params_nodo.gw_id)) 
                   left outer join cliente_params_gw on (cliente_eventos.gw_id  = cliente_params_gw.gw_id)                   
                   left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (rfreenet_general.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw.gw_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw.gw_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw.gw_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_gw.gw_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_gw.gw_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_gw.gw_A6UND
                                                                                                                                            WHEN 6 THEN cliente_params_gw.gw_A7UND
                                                                                                                                            WHEN 7 THEN cliente_params_gw.gw_A8UND
                                                                                                                                            WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen on (rfreenet_general.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (rfreenet_general.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                                                                                                                            WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))																																			 
      						    where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $tipo_gw, $tipo_gw_low, (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1), (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1),$db_name_general,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$NombreTabla, $instalacion);
						$query .= " AND evento_fecha>'".$fecha_begin."'  AND evento_fecha<'".$fecha_end."'";			
					}
					else 
					{
						$query = sprintf("(select cliente_eventos.gw_id AS gw_id,
													cliente_eventos.nodo_ip as nodo_ip, 
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
													cliente_gateways.gw_nombre,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
													cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
													cliente_eventos.evento_codigo AS evento_codigo,
													(CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
					                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
					                          									ELSE '12' END) AS versionHW,
													(CASE cliente_eventos.evento_codigo 
															WHEN '500' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '506' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '512' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '501' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '507' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '513' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '502' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '508' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '514' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '503' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '509' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '515' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '504' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '510' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '516' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '505' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '511' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '517' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '600' THEN cliente_gateways.gw_nombre_s1 
								  					      WHEN '625' THEN cliente_gateways.gw_nombre_s1
	                  									  WHEN '650' THEN cliente_gateways.gw_nombre_s1  
	                  									  WHEN '601' THEN cliente_gateways.gw_nombre_s2 
	                  									  WHEN '626' THEN cliente_gateways.gw_nombre_s2
	                  									  WHEN '651' THEN cliente_gateways.gw_nombre_s2  
	                  									  WHEN '602' THEN cliente_gateways.gw_nombre_s3 
	                  									  WHEN '627' THEN cliente_gateways.gw_nombre_s3
	                  									  WHEN '652' THEN cliente_gateways.gw_nombre_s3  
	                  									  WHEN '603' THEN cliente_gateways.gw_nombre_s4 
	                  									  WHEN '628' THEN cliente_gateways.gw_nombre_s4
	                  									  WHEN '653' THEN cliente_gateways.gw_nombre_s4   
	                  									  WHEN '604' THEN cliente_gateways.gw_nombre_s5 
	                  									  WHEN '629' THEN cliente_gateways.gw_nombre_s5
	                  									  WHEN '654' THEN cliente_gateways.gw_nombre_s5  
	                  									  WHEN '605' THEN cliente_gateways.gw_nombre_s6 
	                  									  WHEN '630' THEN cliente_gateways.gw_nombre_s6
	                  									  WHEN '655' THEN cliente_gateways.gw_nombre_s6  
	                  									  WHEN '606' THEN cliente_gateways.gw_nombre_s7 
	                  									  WHEN '631' THEN cliente_gateways.gw_nombre_s7
	                  									  WHEN '656' THEN cliente_gateways.gw_nombre_s7  
	                  									  WHEN '607' THEN cliente_gateways.gw_nombre_s8 
	                  									  WHEN '632' THEN cliente_gateways.gw_nombre_s8
	                  									  WHEN '657' THEN cliente_gateways.gw_nombre_s8  
	                  									  WHEN '608' THEN cliente_gateways.gw_nombre_s9 
	                  									  WHEN '633' THEN cliente_gateways.gw_nombre_s9
	                  									  WHEN '658' THEN cliente_gateways.gw_nombre_s9  
	                  									  WHEN '609' THEN cliente_gateways.gw_nombre_s10 
	                  									  WHEN '634' THEN cliente_gateways.gw_nombre_s10
	                  									  WHEN '659' THEN cliente_gateways.gw_nombre_s10  
	                  									  WHEN '610' THEN cliente_gateways.gw_nombre_s11 
	                  									  WHEN '635' THEN cliente_gateways.gw_nombre_s11
	                  									  WHEN '660' THEN cliente_gateways.gw_nombre_s11   
	                  									  WHEN '611' THEN cliente_gateways.gw_nombre_s12 
	                  									  WHEN '636' THEN cliente_gateways.gw_nombre_s12
	                  									  WHEN '661' THEN cliente_gateways.gw_nombre_s12  
	                  									  WHEN '612' THEN cliente_gateways.gw_nombre_s13 
	                  									  WHEN '637' THEN cliente_gateways.gw_nombre_s13
	                  									  WHEN '662' THEN cliente_gateways.gw_nombre_s13  
	                  									  WHEN '613' THEN cliente_gateways.gw_nombre_s14 
	                  									  WHEN '638' THEN cliente_gateways.gw_nombre_s14
	                  									  WHEN '663' THEN cliente_gateways.gw_nombre_s14  
	                  									  WHEN '614' THEN cliente_gateways.gw_nombre_s15 
	                  									  WHEN '639' THEN cliente_gateways.gw_nombre_s15
	                  									  WHEN '664' THEN cliente_gateways.gw_nombre_s15  
	                  									  WHEN '615' THEN cliente_gateways.gw_nombre_s16 
	                  									  WHEN '640' THEN cliente_gateways.gw_nombre_s16
	                  									  WHEN '665' THEN cliente_gateways.gw_nombre_s16  
	                  									  WHEN '616' THEN cliente_gateways.gw_nombre_s17 
	                  									  WHEN '641' THEN cliente_gateways.gw_nombre_s17
	                  									  WHEN '666' THEN cliente_gateways.gw_nombre_s17  
	                  									  WHEN '617' THEN cliente_gateways.gw_nombre_s18 
	                  									  WHEN '642' THEN cliente_gateways.gw_nombre_s18
	                  									  WHEN '667' THEN cliente_gateways.gw_nombre_s18  
	                  									  WHEN '618' THEN cliente_gateways.gw_nombre_s19 
	                  									  WHEN '643' THEN cliente_gateways.gw_nombre_s19
	                  									  WHEN '668' THEN cliente_gateways.gw_nombre_s19  
	                  									  WHEN '619' THEN cliente_gateways.gw_nombre_s20 
	                  									  WHEN '644' THEN cliente_gateways.gw_nombre_s20
	                  									  WHEN '669' THEN cliente_gateways.gw_nombre_s20  
	                  									  WHEN '620' THEN cliente_gateways.gw_nombre_s21 
	                  									  WHEN '645' THEN cliente_gateways.gw_nombre_s21
	                  									  WHEN '670' THEN cliente_gateways.gw_nombre_s21  
	                  									  WHEN '621' THEN cliente_gateways.gw_nombre_s22 
	                  									  WHEN '646' THEN cliente_gateways.gw_nombre_s22
	                  									  WHEN '671' THEN cliente_gateways.gw_nombre_s22  
	                  									  WHEN '622' THEN cliente_gateways.gw_nombre_s23 
	                  									  WHEN '647' THEN cliente_gateways.gw_nombre_s23
	                  									  WHEN '672' THEN cliente_gateways.gw_nombre_s23
														ELSE '-' END) AS sensor_nombre,
													max(cliente_eventos.evento_valor_raw) AS valor,
													cliente_eventos.evento_tiposensor as tiposensor, 
													max(1000*(floor((unix_timestamp(cliente_eventos.evento_fecha))/86400)*86400)) AS fecha,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
													cliente_params_nodo.nodo_aux_operacion%u as operacion,cliente_params_nodo.nodo_aux_constante%u as constante,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MAX
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MAX
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MAX
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MAX
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MAX
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MAX ELSE 0 END) as maximo_nodo,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MIN
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MIN
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MIN
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MIN
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MIN
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MIN ELSE 0 END) as minimo_nodo,														
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MAX
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MAX
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MAX
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MAX
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MAX
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MAX
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MAX
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MAX
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MAX ELSE 0 END) as maximo,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MIN
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MIN
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MIN
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MIN
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MIN
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MIN
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MIN
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MIN
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MIN ELSE 0 END) as minimo,											
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MAX
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MAX
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MAX ELSE 0 END) as maximo_gen,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MIN
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MIN
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MIN ELSE 0 END) as minimo_gen,	
													rfreenet_uds_sensor_generico.nombre nombre_unidad,
													rfreenet_uds_sensor_generico_nodo.nombre nombre_unidad_nodo,
													rfreenet_uds_sensor_generico_gen.nombre nombre_unidad_gen 			                                             
						from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion 
												  right join (%s.cliente_analizadores 
												  right join (%s.cliente_instalaciones 
												  inner join (%s.cliente_gateways join (%s.cliente_nodos right join %s.%s as cliente_eventos on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac AND cliente_eventos.gw_id=cliente_nodos.gw_id)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.gw_id=cliente_analizadores.gw_id AND cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.nodo_ip=cliente_analizadores.analizador_direccion AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_params_nodo.nodo_mac=cliente_eventos.nodo_mac AND cliente_eventos.gw_id=cliente_params_nodo.gw_id)) 
                   left outer join cliente_params_gw on (cliente_eventos.gw_id  = cliente_params_gw.gw_id)                   
                   left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (rfreenet_general.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw.gw_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw.gw_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw.gw_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_gw.gw_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_gw.gw_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_gw.gw_A6UND
                                                                                                                                            WHEN 6 THEN cliente_params_gw.gw_A7UND
                                                                                                                                            WHEN 7 THEN cliente_params_gw.gw_A8UND
                                                                                                                                            WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen on (rfreenet_general.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (rfreenet_general.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                                                                                                                            WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))																																																				 
										  where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $tipo_gw, $tipo_gw_low, (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1), (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1),$db_name_general,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$NombreTabla, $instalacion);
						$query .= " AND evento_fecha>'".$fecha_begin_acum_diario."'  AND evento_fecha<'".$fecha_end."'";						
					}
				}
				else 
				{
					if($magnitudes_disp[$ii]=='PLU' || $magnitudes_disp[$ii]=='PUL')
					{
						$query = sprintf("(select cliente_eventos.gw_id AS gw_id,
													cliente_eventos.nodo_ip as nodo_ip, 
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), cliente_gateways.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
													cliente_eventos.evento_codigo AS evento_codigo,
													(CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
					                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
					                          									ELSE '12' END) AS versionHW,
													(CASE cliente_eventos.evento_codigo 
													WHEN '500' THEN cliente_nodos.nodo_nombre_s1 
													WHEN '506' THEN cliente_nodos.nodo_nombre_s1 
													WHEN '512' THEN cliente_nodos.nodo_nombre_s1 
													WHEN '501' THEN cliente_nodos.nodo_nombre_s2 
													WHEN '507' THEN cliente_nodos.nodo_nombre_s2 
													WHEN '513' THEN cliente_nodos.nodo_nombre_s2 
													WHEN '502' THEN cliente_nodos.nodo_nombre_s3 
													WHEN '508' THEN cliente_nodos.nodo_nombre_s3 
													WHEN '514' THEN cliente_nodos.nodo_nombre_s3 
													WHEN '503' THEN cliente_nodos.nodo_nombre_s4 
													WHEN '509' THEN cliente_nodos.nodo_nombre_s4 
													WHEN '515' THEN cliente_nodos.nodo_nombre_s4 
													WHEN '504' THEN cliente_nodos.nodo_nombre_s5 
													WHEN '510' THEN cliente_nodos.nodo_nombre_s5 
													WHEN '516' THEN cliente_nodos.nodo_nombre_s5 
													WHEN '505' THEN cliente_nodos.nodo_nombre_s6 
													WHEN '511' THEN cliente_nodos.nodo_nombre_s6 
													WHEN '517' THEN cliente_nodos.nodo_nombre_s6 
													WHEN '600' THEN cliente_gateways.gw_nombre_s1 
	              									  WHEN '625' THEN cliente_gateways.gw_nombre_s1
	              									  WHEN '650' THEN cliente_gateways.gw_nombre_s1  
	              									  WHEN '601' THEN cliente_gateways.gw_nombre_s2 
	              									  WHEN '626' THEN cliente_gateways.gw_nombre_s2
	              									  WHEN '651' THEN cliente_gateways.gw_nombre_s2  
	              									  WHEN '602' THEN cliente_gateways.gw_nombre_s3 
	              									  WHEN '627' THEN cliente_gateways.gw_nombre_s3
	              									  WHEN '652' THEN cliente_gateways.gw_nombre_s3  
	              									  WHEN '603' THEN cliente_gateways.gw_nombre_s4 
	              									  WHEN '628' THEN cliente_gateways.gw_nombre_s4
	              									  WHEN '653' THEN cliente_gateways.gw_nombre_s4   
	              									  WHEN '604' THEN cliente_gateways.gw_nombre_s5 
	              									  WHEN '629' THEN cliente_gateways.gw_nombre_s5
	              									  WHEN '654' THEN cliente_gateways.gw_nombre_s5  
	              									  WHEN '605' THEN cliente_gateways.gw_nombre_s6 
	              									  WHEN '630' THEN cliente_gateways.gw_nombre_s6
	              									  WHEN '655' THEN cliente_gateways.gw_nombre_s6  
	              									  WHEN '606' THEN cliente_gateways.gw_nombre_s7 
	              									  WHEN '631' THEN cliente_gateways.gw_nombre_s7
	              									  WHEN '656' THEN cliente_gateways.gw_nombre_s7  
	              									  WHEN '607' THEN cliente_gateways.gw_nombre_s8 
	              									  WHEN '632' THEN cliente_gateways.gw_nombre_s8
	              									  WHEN '657' THEN cliente_gateways.gw_nombre_s8  
	              									  WHEN '608' THEN cliente_gateways.gw_nombre_s9 
	              									  WHEN '633' THEN cliente_gateways.gw_nombre_s9
	              									  WHEN '658' THEN cliente_gateways.gw_nombre_s9  
	              									  WHEN '609' THEN cliente_gateways.gw_nombre_s10 
	              									  WHEN '634' THEN cliente_gateways.gw_nombre_s10
	              									  WHEN '659' THEN cliente_gateways.gw_nombre_s10  
	              									  WHEN '610' THEN cliente_gateways.gw_nombre_s11 
	              									  WHEN '635' THEN cliente_gateways.gw_nombre_s11
	              									  WHEN '660' THEN cliente_gateways.gw_nombre_s11   
	              									  WHEN '611' THEN cliente_gateways.gw_nombre_s12 
	              									  WHEN '636' THEN cliente_gateways.gw_nombre_s12
	              									  WHEN '661' THEN cliente_gateways.gw_nombre_s12  
	              									  WHEN '612' THEN cliente_gateways.gw_nombre_s13 
	              									  WHEN '637' THEN cliente_gateways.gw_nombre_s13
	              									  WHEN '662' THEN cliente_gateways.gw_nombre_s13  
	              									  WHEN '613' THEN cliente_gateways.gw_nombre_s14 
	              									  WHEN '638' THEN cliente_gateways.gw_nombre_s14
	              									  WHEN '663' THEN cliente_gateways.gw_nombre_s14  
	              									  WHEN '614' THEN cliente_gateways.gw_nombre_s15 
	              									  WHEN '639' THEN cliente_gateways.gw_nombre_s15
	              									  WHEN '664' THEN cliente_gateways.gw_nombre_s15  
	              									  WHEN '615' THEN cliente_gateways.gw_nombre_s16 
	              									  WHEN '640' THEN cliente_gateways.gw_nombre_s16
	              									  WHEN '665' THEN cliente_gateways.gw_nombre_s16  
	              									  WHEN '616' THEN cliente_gateways.gw_nombre_s17 
	              									  WHEN '641' THEN cliente_gateways.gw_nombre_s17
	              									  WHEN '666' THEN cliente_gateways.gw_nombre_s17  
	              									  WHEN '617' THEN cliente_gateways.gw_nombre_s18 
	              									  WHEN '642' THEN cliente_gateways.gw_nombre_s18
	              									  WHEN '667' THEN cliente_gateways.gw_nombre_s18  
	              									  WHEN '618' THEN cliente_gateways.gw_nombre_s19 
	              									  WHEN '643' THEN cliente_gateways.gw_nombre_s19
	              									  WHEN '668' THEN cliente_gateways.gw_nombre_s19  
	              									  WHEN '619' THEN cliente_gateways.gw_nombre_s20 
	              									  WHEN '644' THEN cliente_gateways.gw_nombre_s20
	              									  WHEN '669' THEN cliente_gateways.gw_nombre_s20  
	              									  WHEN '620' THEN cliente_gateways.gw_nombre_s21 
	              									  WHEN '645' THEN cliente_gateways.gw_nombre_s21
	              									  WHEN '670' THEN cliente_gateways.gw_nombre_s21  
	              									  WHEN '621' THEN cliente_gateways.gw_nombre_s22 
	              									  WHEN '646' THEN cliente_gateways.gw_nombre_s22
	              									  WHEN '671' THEN cliente_gateways.gw_nombre_s22  
	              									  WHEN '622' THEN cliente_gateways.gw_nombre_s23 
	              									  WHEN '647' THEN cliente_gateways.gw_nombre_s23
	              									  WHEN '672' THEN cliente_gateways.gw_nombre_s23
													ELSE '-' END) AS sensor_nombre,
													hex(sum(conv(cliente_eventos.evento_valor_raw,16,10))) AS valor,
													cliente_eventos.evento_tiposensor as tiposensor, 
													max(1000*(floor((unix_timestamp(cliente_eventos.evento_fecha))/3600)*3600)) AS fecha,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
													cliente_params_nodo.nodo_aux_operacion%u as operacion,
													cliente_params_nodo.nodo_aux_constante%u as constante, 
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MAX
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MAX
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MAX
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MAX
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MAX
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MAX ELSE 0 END) as maximo_nodo,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MIN
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MIN
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MIN
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MIN
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MIN
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MIN ELSE 0 END) as minimo_nodo,														
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MAX
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MAX
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MAX
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MAX
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MAX
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MAX
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MAX
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MAX
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MAX ELSE 0 END) as maximo,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MIN
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MIN
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MIN
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MIN
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MIN
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MIN
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MIN
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MIN
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MIN ELSE 0 END) as minimo,											
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MAX
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MAX
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MAX ELSE 0 END) as maximo_gen,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MIN
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MIN
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MIN ELSE 0 END) as minimo_gen,	
													rfreenet_uds_sensor_generico.nombre nombre_unidad,
													rfreenet_uds_sensor_generico_nodo.nombre nombre_unidad_nodo,
													rfreenet_uds_sensor_generico_gen.nombre nombre_unidad_gen 			                                             
						from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion 
												  right join (%s.cliente_analizadores 
												  right join (%s.cliente_instalaciones 
												  inner join (%s.cliente_gateways join (%s.cliente_nodos right join %s.%s as cliente_eventos on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac AND cliente_eventos.gw_id=cliente_nodos.gw_id)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.gw_id=cliente_analizadores.gw_id AND cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.nodo_ip=cliente_analizadores.analizador_direccion AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_params_nodo.nodo_mac=cliente_eventos.nodo_mac AND cliente_eventos.gw_id=cliente_params_nodo.gw_id)) 
                   left outer join cliente_params_gw on (cliente_eventos.gw_id  = cliente_params_gw.gw_id)                   
                   left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (rfreenet_general.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw.gw_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw.gw_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw.gw_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_gw.gw_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_gw.gw_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_gw.gw_A6UND
                                                                                                                                            WHEN 6 THEN cliente_params_gw.gw_A7UND
                                                                                                                                            WHEN 7 THEN cliente_params_gw.gw_A8UND
                                                                                                                                            WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen on (rfreenet_general.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (rfreenet_general.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                                                                                                                            WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))																																															   
						where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $tipo_gw, $tipo_gw_low, (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1), (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1),$db_name_general,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$NombreTabla, $instalacion);
						$query .= " AND evento_fecha>'".$fecha_begin."'  AND evento_fecha<'".$fecha_end."'";	
					}
					else 
					{
						$query = sprintf("(select cliente_eventos.gw_id AS gw_id,
													cliente_eventos.nodo_ip as nodo_ip,
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,
													IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), cliente_gateways.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
													cliente_eventos.evento_codigo AS evento_codigo,
													(CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
					                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
					                          									ELSE '12' END) AS versionHW,
													(CASE cliente_eventos.evento_codigo 
															WHEN '500' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '506' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '512' THEN cliente_nodos.nodo_nombre_s1 
															WHEN '501' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '507' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '513' THEN cliente_nodos.nodo_nombre_s2 
															WHEN '502' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '508' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '514' THEN cliente_nodos.nodo_nombre_s3 
															WHEN '503' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '509' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '515' THEN cliente_nodos.nodo_nombre_s4 
															WHEN '504' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '510' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '516' THEN cliente_nodos.nodo_nombre_s5 
															WHEN '505' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '511' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '517' THEN cliente_nodos.nodo_nombre_s6 
															WHEN '600' THEN cliente_gateways.gw_nombre_s1 
                          									  WHEN '625' THEN cliente_gateways.gw_nombre_s1
                          									  WHEN '650' THEN cliente_gateways.gw_nombre_s1  
                          									  WHEN '601' THEN cliente_gateways.gw_nombre_s2 
                          									  WHEN '626' THEN cliente_gateways.gw_nombre_s2
                          									  WHEN '651' THEN cliente_gateways.gw_nombre_s2  
                          									  WHEN '602' THEN cliente_gateways.gw_nombre_s3 
                          									  WHEN '627' THEN cliente_gateways.gw_nombre_s3
                          									  WHEN '652' THEN cliente_gateways.gw_nombre_s3  
                          									  WHEN '603' THEN cliente_gateways.gw_nombre_s4 
                          									  WHEN '628' THEN cliente_gateways.gw_nombre_s4
                          									  WHEN '653' THEN cliente_gateways.gw_nombre_s4   
                          									  WHEN '604' THEN cliente_gateways.gw_nombre_s5 
                          									  WHEN '629' THEN cliente_gateways.gw_nombre_s5
                          									  WHEN '654' THEN cliente_gateways.gw_nombre_s5  
                          									  WHEN '605' THEN cliente_gateways.gw_nombre_s6 
                          									  WHEN '630' THEN cliente_gateways.gw_nombre_s6
                          									  WHEN '655' THEN cliente_gateways.gw_nombre_s6  
                          									  WHEN '606' THEN cliente_gateways.gw_nombre_s7 
                          									  WHEN '631' THEN cliente_gateways.gw_nombre_s7
                          									  WHEN '656' THEN cliente_gateways.gw_nombre_s7  
                          									  WHEN '607' THEN cliente_gateways.gw_nombre_s8 
                          									  WHEN '632' THEN cliente_gateways.gw_nombre_s8
                          									  WHEN '657' THEN cliente_gateways.gw_nombre_s8  
                          									  WHEN '608' THEN cliente_gateways.gw_nombre_s9 
                          									  WHEN '633' THEN cliente_gateways.gw_nombre_s9
                          									  WHEN '658' THEN cliente_gateways.gw_nombre_s9  
                          									  WHEN '609' THEN cliente_gateways.gw_nombre_s10 
                          									  WHEN '634' THEN cliente_gateways.gw_nombre_s10
                          									  WHEN '659' THEN cliente_gateways.gw_nombre_s10  
                          									  WHEN '610' THEN cliente_gateways.gw_nombre_s11 
                          									  WHEN '635' THEN cliente_gateways.gw_nombre_s11
                          									  WHEN '660' THEN cliente_gateways.gw_nombre_s11   
                          									  WHEN '611' THEN cliente_gateways.gw_nombre_s12 
                          									  WHEN '636' THEN cliente_gateways.gw_nombre_s12
                          									  WHEN '661' THEN cliente_gateways.gw_nombre_s12  
                          									  WHEN '612' THEN cliente_gateways.gw_nombre_s13 
                          									  WHEN '637' THEN cliente_gateways.gw_nombre_s13
                          									  WHEN '662' THEN cliente_gateways.gw_nombre_s13  
                          									  WHEN '613' THEN cliente_gateways.gw_nombre_s14 
                          									  WHEN '638' THEN cliente_gateways.gw_nombre_s14
                          									  WHEN '663' THEN cliente_gateways.gw_nombre_s14  
                          									  WHEN '614' THEN cliente_gateways.gw_nombre_s15 
                          									  WHEN '639' THEN cliente_gateways.gw_nombre_s15
                          									  WHEN '664' THEN cliente_gateways.gw_nombre_s15  
                          									  WHEN '615' THEN cliente_gateways.gw_nombre_s16 
                          									  WHEN '640' THEN cliente_gateways.gw_nombre_s16
                          									  WHEN '665' THEN cliente_gateways.gw_nombre_s16  
                          									  WHEN '616' THEN cliente_gateways.gw_nombre_s17 
                          									  WHEN '641' THEN cliente_gateways.gw_nombre_s17
                          									  WHEN '666' THEN cliente_gateways.gw_nombre_s17  
                          									  WHEN '617' THEN cliente_gateways.gw_nombre_s18 
                          									  WHEN '642' THEN cliente_gateways.gw_nombre_s18
                          									  WHEN '667' THEN cliente_gateways.gw_nombre_s18  
                          									  WHEN '618' THEN cliente_gateways.gw_nombre_s19 
                          									  WHEN '643' THEN cliente_gateways.gw_nombre_s19
                          									  WHEN '668' THEN cliente_gateways.gw_nombre_s19  
                          									  WHEN '619' THEN cliente_gateways.gw_nombre_s20 
                          									  WHEN '644' THEN cliente_gateways.gw_nombre_s20
                          									  WHEN '669' THEN cliente_gateways.gw_nombre_s20  
                          									  WHEN '620' THEN cliente_gateways.gw_nombre_s21 
                          									  WHEN '645' THEN cliente_gateways.gw_nombre_s21
                          									  WHEN '670' THEN cliente_gateways.gw_nombre_s21  
                          									  WHEN '621' THEN cliente_gateways.gw_nombre_s22 
                          									  WHEN '646' THEN cliente_gateways.gw_nombre_s22
                          									  WHEN '671' THEN cliente_gateways.gw_nombre_s22  
                          									  WHEN '622' THEN cliente_gateways.gw_nombre_s23 
                          									  WHEN '647' THEN cliente_gateways.gw_nombre_s23
                          									  WHEN '672' THEN cliente_gateways.gw_nombre_s23
															ELSE '-' END) AS sensor_nombre,
													max(cliente_eventos.evento_valor_raw) AS valor,
													cliente_eventos.evento_tiposensor as tiposensor, 
													max(1000*(floor((unix_timestamp(cliente_eventos.evento_fecha))/3600)*3600)) AS fecha,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
													rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
													IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),
													rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
													cliente_params_nodo.nodo_aux_operacion%u as operacion,
													cliente_params_nodo.nodo_aux_constante%u as constante, 
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MAX
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MAX
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MAX
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MAX
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MAX
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MAX ELSE 0 END) as maximo_nodo,
													(case MOD(cliente_eventos.evento_codigo-500, 6) WHEN 0 THEN cliente_params_nodo.nodo_A1MIN
													                                             WHEN 1 THEN cliente_params_nodo.nodo_A2MIN
													                                             WHEN 2 THEN cliente_params_nodo.nodo_A3MIN
													                                             WHEN 3 THEN cliente_params_nodo.nodo_A4MIN
													                                             WHEN 4 THEN cliente_params_nodo.nodo_A5MIN
													                                             WHEN 5 THEN cliente_params_nodo.nodo_A6MIN ELSE 0 END) as minimo_nodo,														
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MAX
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MAX
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MAX
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MAX
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MAX
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MAX
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MAX
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MAX
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MAX ELSE 0 END) as maximo,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw.gw_A1MIN
													                                             WHEN 1 THEN cliente_params_gw.gw_A2MIN
													                                             WHEN 2 THEN cliente_params_gw.gw_A3MIN
													                                             WHEN 3 THEN cliente_params_gw.gw_A4MIN
													                                             WHEN 4 THEN cliente_params_gw.gw_A5MIN
													                                             WHEN 5 THEN cliente_params_gw.gw_A6MIN
													                                             WHEN 6 THEN cliente_params_gw.gw_A7MIN
													                                             WHEN 7 THEN cliente_params_gw.gw_A8MIN
													                                             WHEN 8 THEN cliente_params_gw.gw_A9MIN ELSE 0 END) as minimo,											
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MAX
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MAX
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MAX ELSE 0 END) as maximo_gen,
													(case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0MIN
													                                             WHEN 1 THEN cliente_params_gw_low.gw_A1MIN
													                                             WHEN 2 THEN cliente_params_gw_low.gw_A2MIN ELSE 0 END) as minimo_gen,	
													rfreenet_uds_sensor_generico.nombre nombre_unidad,
													rfreenet_uds_sensor_generico_nodo.nombre nombre_unidad_nodo,
													rfreenet_uds_sensor_generico_gen.nombre nombre_unidad_gen 			                                             
						from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion 
												  right join (%s.cliente_analizadores 
												  right join (%s.cliente_instalaciones 
												  inner join (%s.cliente_gateways join (%s.cliente_nodos right join %s.%s as cliente_eventos on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac AND cliente_eventos.gw_id=cliente_nodos.gw_id)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.gw_id=cliente_analizadores.gw_id AND cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.nodo_ip=cliente_analizadores.analizador_direccion AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_params_nodo.nodo_mac=cliente_eventos.nodo_mac AND cliente_eventos.gw_id=cliente_params_nodo.gw_id)) 
                   left outer join cliente_params_gw on (cliente_eventos.gw_id  = cliente_params_gw.gw_id)                   
                   left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (rfreenet_general.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw.gw_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw.gw_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw.gw_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_gw.gw_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_gw.gw_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_gw.gw_A6UND
                                                                                                                                            WHEN 6 THEN cliente_params_gw.gw_A7UND
                                                                                                                                            WHEN 7 THEN cliente_params_gw.gw_A8UND
                                                                                                                                            WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen on (rfreenet_general.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                                                                                                                            WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                                                                                                                            WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                                                                                                                            WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))															    
                   left outer join rfreenet_general.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (rfreenet_general.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                                                                                                                            WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                                                                                                                            WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                                                                                                                            WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                                                                                                                            WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                                                                                                                            WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                                                                                                                            WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))												   
						where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $tipo_gw, $tipo_gw_low, (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99)) ?($num_sensor_informe[$ii]+1):1), (((($tipo_dispositivo[$ii] == 'N' || $tipo_dispositivo[$ii] == 'n')) && ($num_sensor_informe[$ii]!=99))?($num_sensor_informe[$ii]+1):1),$db_name_general,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$cliente_db,$NombreTabla, $instalacion);
						$query .= " AND evento_fecha>'".$fecha_begin_acum_horario."'  AND evento_fecha<'".$fecha_end."'";
					}
				}
				
				
				switch ($tipo_dispositivo[$ii])
				{
					case 'G':
					case 'g':
						//echo "Informe de gw ".$gw_id." del sensor ".$num_sensor_informe.'<br/>';				
						$query .= " AND cliente_eventos.gw_id='".$gw_id[$ii]."'";
						switch ($num_sensor_informe[$ii])
						{
							case "0":
								$query .= " AND ((cliente_eventos.evento_codigo='600') OR (cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650') OR (cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700'))";
								break;
							case "1":
								$query .= " AND ((cliente_eventos.evento_codigo='601') OR (cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651') OR (cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701'))";
								break;
							case "2":
								$query .= " AND ((cliente_eventos.evento_codigo='602') OR (cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652') OR (cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702'))";
								break;
							case "3":
								$query .= " AND ((cliente_eventos.evento_codigo='603') OR (cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653') OR (cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703'))";
								break;
							case "4":
								$query .= " AND ((cliente_eventos.evento_codigo='604') OR (cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654') OR (cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704'))";
								break;
							case "5":
								$query .= " AND ((cliente_eventos.evento_codigo='605') OR (cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655') OR (cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705'))";
								break;
							case "6":
								$query .= " AND ((cliente_eventos.evento_codigo='606') OR (cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656') OR (cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706'))";
								break;
							case "7":
								$query .= " AND ((cliente_eventos.evento_codigo='607') OR (cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657') OR (cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707'))";
								break;
							case "8":
								$query .= " AND ((cliente_eventos.evento_codigo='608') OR (cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658') OR (cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708'))";
								break;
							case "9":
								$query .= " AND ((cliente_eventos.evento_codigo='609') OR (cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659') OR (cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709'))";
								break;
							case "10":
								$query .= " AND ((cliente_eventos.evento_codigo='610') OR (cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660') OR (cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710'))";
								break;
							case "11":
								$query .= " AND ((cliente_eventos.evento_codigo='611') OR (cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661') OR (cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711'))";
								break;
							case "12":
								$query .= " AND ((cliente_eventos.evento_codigo='612') OR (cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662') OR (cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712'))";
								break;
							case "13":
								$query .= " AND ((cliente_eventos.evento_codigo='613') OR (cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663') OR (cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713'))";
								break;
							case "14":
								$query .= " AND ((cliente_eventos.evento_codigo='614') OR (cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664') OR (cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714'))";
								break;
							case "15":
								$query .= " AND ((cliente_eventos.evento_codigo='615') OR (cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665') OR (cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715'))";
								break;
							case "16":
								$query .= " AND ((cliente_eventos.evento_codigo='616') OR (cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666') OR (cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716'))";
								break;
							case "17":
								$query .= " AND ((cliente_eventos.evento_codigo='617') OR (cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667') OR (cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717'))";
								break;
							case "18":
								$query .= " AND ((cliente_eventos.evento_codigo='618') OR (cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668') OR (cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718'))";
								break;
							case "19":
								$query .= " AND ((cliente_eventos.evento_codigo='619') OR (cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669') OR (cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719'))";
								break;
							case "20":
								$query .= " AND ((cliente_eventos.evento_codigo='620') OR (cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670') OR (cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720'))";
								break;
							case "21":
								$query .= " AND ((cliente_eventos.evento_codigo='621') OR (cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671') OR (cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721'))";
								break;
							case "22":
								$query .= " AND ((cliente_eventos.evento_codigo='622') OR (cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672') OR (cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722'))";
								break;
							case "98":
								$query .= " AND (cliente_eventos.evento_codigo='807')";
								break;	
							case "99":
								$query .= " AND (cliente_eventos.evento_codigo='805')";
								break;															
							default:
								$query .= "AND (((cliente_eventos.evento_codigo>'599') AND (cliente_eventos.evento_codigo<'748'))";
								break;						
						}
						break;
						
					case 'N':
					case 'n':
						//echo "Informe de nodo ".$nodo_mac." del sensor ".$num_sensor_informe.'<br/>';
						$query .= " AND cliente_eventos.nodo_mac='".$nodo_mac[$ii]."' AND cliente_eventos.gw_id='".$gw_id[$ii]."'";
						switch ($num_sensor_informe[$ii])
						{
							case "0":
								$query .= " AND ((cliente_eventos.evento_codigo='500') OR (cliente_eventos.evento_codigo='506') OR (cliente_eventos.evento_codigo='513'))";
								break;
							case "1":
								$query .= " AND ((cliente_eventos.evento_codigo='501') OR (cliente_eventos.evento_codigo='507') OR (cliente_eventos.evento_codigo='514'))";
								break;
							case "2":
								$query .= " AND ((cliente_eventos.evento_codigo='502') OR (cliente_eventos.evento_codigo='508') OR (cliente_eventos.evento_codigo='515'))";
								break;
							case "3":
								$query .= " AND ((cliente_eventos.evento_codigo='503') OR (cliente_eventos.evento_codigo='509') OR (cliente_eventos.evento_codigo='516'))";
								break;
							case "4":
								$query .= " AND ((cliente_eventos.evento_codigo='504') OR (cliente_eventos.evento_codigo='510') OR (cliente_eventos.evento_codigo='517'))";
								break;
							case "5":
								$query .= " AND ((cliente_eventos.evento_codigo='505') OR (cliente_eventos.evento_codigo='511') OR (cliente_eventos.evento_codigo='518'))";
								break;
							case "99":
								$query .= " AND (cliente_eventos.evento_codigo='801')";
								break;
							default:
								$query .= " AND ((cliente_eventos.evento_codigo>499) AND (cliente_eventos.evento_codigo<520))";
								break;							
						}
						break;
					case 'U':
					case 'u':
						$query .= " AND cliente_eventos.nodo_ip='".substr($nodo_mac[$ii],10,2)."' AND cliente_eventos.gw_id='".$gw_id[$ii]."'";
						$numsensorUTC = 300 + $num_sensor_informe[$ii];	
						$query .= " AND cliente_eventos.evento_codigo='".$numsensorUTC."' ";	
						break;
						
					default:
						break;
				}
							
				$query .= " AND year(evento_fecha)>2000 and year(evento_fecha)<2100 ";
				if($tipo_graficas[$ii]=='1')
				{
					$query .= " group by day(cliente_eventos.evento_fecha)";
				}
				elseif ($tipo_graficas[$ii]=='2') 
				{
					$query .= " group by day(cliente_eventos.evento_fecha),hour(cliente_eventos.evento_fecha)";
				}
				$query .=" ORDER BY evento_fecha)";
				$query_final .= $query;
				$primero = 0;
				//echo "HOOOOOOLAAAAAAAAAAAAA";
			}
			
			if ($anyo_actual<$anyo_end)
			{
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
			}
			else if ($anyo_actual==$anyo_end)
			{
				if ($mes_actual<$mes_end)
				{
					$mes_actual++;
					$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
				}
				else
				{
					$cadena_actual='FIN';
				}
			}
		}
		$query_final .= ") as tabla order by fecha";		
				
		$result = false;
		
		if (($query_final != "") && ($primero != 1))
		{
			$result = mysqli_query($link, $query_final) or die('DIE:'.mysqli_error()."<br>".$query_final);
			
		}
		//echo $query_final;
		if($result)
		{			
			//$iTotalResultados=mysql_num_rows($result);
			$ijResults = 0;
			$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['general143'];
			$inicio = 0;
			$valor_anterior = 0;
			
			while ($row = mysqli_fetch_array($result))
			{
				$valores_raw[$ijResults] = hexdec($row['valor']);
				$valores_fechas[$ijResults] = $row['fecha'];				
				switch ($tipo_dispositivo[$ii])
				{
					case 'N':
					case 'n':
						// Si es un gradiente, la conversion es diferente
						if((substr($row['tiposensor'], 0, 1) == '4' || 
						   substr($row['tiposensor'], 0, 1) == 'D' ||
						   substr($row['tiposensor'], 0, 1) == 'd' ||
						   substr($row['tiposensor'], 0, 1) == 'C' ||
						   substr($row['tiposensor'], 0, 1) == 'c') &&
						   substr($row['tiposensor'], 2, 1) == '0')
						{
							$valores_conv[$ijResults] = sConvertir_Datos_Nodo_Generico(hexdec($row['valor']), $row['tiposensor'],1, $row['maximo_nodo'], $row['minimo_nodo'], $row['nombre_unidad_nodo']);
						}			            	
						else 
						{
							if (($row['evento_codigo']>511) && ($row['evento_codigo']<518))
							{
								$valores_conv[$ijResults]=sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],1,'G',0,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6));
							}
							else
							{
								$valores_conv[$ijResults]=sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],1,'D',0,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6));
							}	
						}
														
						if (($row['evento_codigo']==801))
						{
							if ($row['sensor_nombre'] != "")
							{
								$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$row['nombre'];
							}
							else
							{
								$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac'];	
							}
						}
						else if ($row['sensor_nombre'] != "")
						{
							$nombre_curva = $row['sensor_nombre'];
						}
						else
						{
							$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['general102'].' '.sObtener_Cadena_Numero_Sensor($row['evento_codigo']).' ('.sObtener_Cadena_Tipo_Sensor($row['tiposensor']).') '.$idiomas[$_SESSION['opcion_idioma']]['general144'].' '.$row['nodo_mac'];
						}
						break;
				
					case 'G':
					case 'g':
						switch (intval($row['versionHW'], 10))
						{		
							case 12:
								$iResGW1 = 4096;
								$iResGW2 = 4096;
								break;
							case 11:
								$iResGW1 = 256;
								$iResGW2 = 4096;
								break;
							case 10:
							default:
								$iResGW1 = 256;
								$iResGW2 = 256;		
								break;
						}
						if($row['tiposensor'] == 35 || $row['tiposensor'] == 36)
						{							
							$valores_conv[$ijResults] = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 1, $row['maximo_gen'], $row['minimo_gen'], $row['nombre_unidad_gen'], $iResGW2);	
						}
						else if(($row['tiposensor'] == 16)||($row['tiposensor'] == 2))
						{
							$valores_conv[$ijResults] = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 1, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW2);
						}
						else if(($row['tiposensor'] > 20)&&($row['tiposensor'] < 27))
						{
							$valores_conv[$ijResults] = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 1, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW1);
						}
						else
						{
							$valores_conv[$ijResults] = sConvertir_Datos_GW(hexdec($row['valor']), $row['tiposensor'], 1, $row['gw_id'], (intval($row['evento_codigo'])%25), 0, $row['versionHW']);
						}																			
						
						if (($row['evento_codigo']==805))
						{
							$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id'];
						}
						else if (($row['evento_codigo']==807))
						{
							$nombre_curva = $idiomas[$_SESSION['opcion_idioma']]['event_cob_gprs']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id'];
						}
						else if ($row['sensor_nombre'] != "")
						{						
							$nombre_curva = $row['sensor_nombre'];
						}
						else
						{							
							$nombre_curva = sObtener_Cadena_Tipo_Sensor_GW($row['tiposensor']);
						}
						
						break;
					case 'U':
					case 'u':
						$valores_conv[$ijResults] = sConvertir_Datos_UTC(hexdec($row['valor']), $row['tiposensor'],1,$row['modbus_operacion'],$row['modbus_operando'],0);
						/*$numero_magnitud = "";
						if(substr($row['tiposensor'],2,1) != '0')
						{
							$numero_magnitud = substr($row['tiposensor'],2,1);
						}*/
						$nombre_curva = sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1))." de UTC ".$row['nodo_ip'];
						break;
				}
				/* Convertir los ts en ts de otra zona horaria*/
				//echo "Vuelta ".$ijResults." ".$row['fecha']."<br>";
				//$fecha_ts = sObtener_TimeStamp($cliente_db, $instalacion, $valores_fechas[$ijResults]/1000,$zona_horaria);
				//date_default_timezone_set($timezone_server);
				
				$fecha = date_create();
				//Se crea un datetime con la zona horaria del servidor
			 	date_timestamp_set ($fecha, $valores_fechas[$ijResults]/1000);
				//Pasamos ese datetime a la zona horaria de la instalacion
				date_timezone_set($fecha,timezone_open($zona_horaria));
				$fecha_formateada = date_create_from_format('Y-m-d H:i:s',date_format($fecha, 'Y-m-d H:i:s'),timezone_open($zona_horaria));
				//creamos un datetime nuevo a partir de la fecha con la zona horaria de la instalacion, diciendole que pertenece a la zona horaria del servidor
				$fecha_formateada = date_create_from_format('Y-m-d H:i:s',date_format($fecha_formateada, 'Y-m-d H:i:s'));
				
				date_timezone_set($fecha_formateada,timezone_open($zona_horaria));
				$fecha_formateada = date_create_from_format('Y-m-d H:i:s',date_format($fecha_formateada, 'Y-m-d H:i:s'),timezone_open('UTC'));
				$fecha_ts = date_timestamp_get($fecha_formateada);
				

				if(($tipo_graficas[$ii]=='0'))
				{
					//$pair = array( (float)($valores_fechas[$ijResults]+(date('Z')*1000)), (float)$valores_conv[$ijResults] );
					$pair = array( (float)($fecha_ts*1000), (float)$valores_conv[$ijResults] );
					//$pair = array( (float)$valores_fechas[$ijResults], (float)$valores_conv[$ijResults] );
					array_push($data_series, $pair);
				}
				elseif (($magnitudes_disp[$ii]=='PLU')  || ($magnitudes_disp[$ii]=='PUL')) 
				{
					if($valores_conv[$ijResults]!=0)
					{
						//$pair = array( (float)($valores_fechas[$ijResults]+(date('Z')*1000)), (float)$valores_conv[$ijResults] );
						$pair = array( (float)($fecha_ts*1000), (float)$valores_conv[$ijResults] );
						//$pair = array( (float)$valores_fechas[$ijResults], (float)$valores_conv[$ijResults] );
						array_push($data_series, $pair);
					}
				}
				else
				{
					if($inicio==0)
					{
						$inicio = 1;
						$valor_anterior = $valores_conv[$ijResults];
						//echo "Es el primer valor y es ".$valor_anterior."</br>";
					}
					else
					{
						if((($valores_conv[$ijResults]-$valor_anterior))!=0)
						{
							$pair = array( (float)($fecha_ts*1000), (float)($valores_conv[$ijResults]-$valor_anterior) );
							//$pair = array( (float)($valores_fechas[$ijResults]), (float)($valores_conv[$ijResults]-$valor_anterior) );
							//echo "A ".$valores_conv[$ijResults]." le restamos ".$valor_anterior." y da ".$pair[1]."</br>";
							$valor_anterior = $valores_conv[$ijResults];
							array_push($data_series, $pair);
						}
					}
				}
			    $ijResults++;
			}
			mysqli_free_result($result);
						
			//echo "TOTAL medidas ".$ijResults." desde ".$timestamp_inicio." a ".$timestamp_final." es ".count($valores_conv)."<br/>";
			//echo "TOTAL puntos ".($timestamp_final-$timestamp_inicio+1)."<br/>";
			//echo 'Comparando mag '.$ii.' de '.$magnitudes_disp[$ii].' con 0 de tipo '.$mag_inicial.'<br/>';
			if (($ii == 0) || (strcmp($magnitudes_disp[$ii], $mag_inicial)==0))
			{
				//echo 'Eje 1<br/>';
				if($tipo_graficas[$ii]=='0')
				{
					$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'spline',/*pointInterval=> 3600 * 1000,*/ yAxis=> 0, zIndex=>3);
				}
				elseif($tipo_graficas[$ii]=='1')				
				{
					if($acumulado_horario==1)
						$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',/*pointInterval=> 3600 * 1000,*/ yAxis=> 0, zIndex=>1, pointPadding => -10, groupPadding => 0);
					else
						$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',/*pointInterval=> 3600 * 1000,*/ yAxis=> 0, zIndex=>1, pointPadding => 0,groupPadding => 0);
				}
				else	
				{
					$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',/*pointInterval=> 3600 * 1000,*/ yAxis=> 0, zIndex=>2, groupPadding => 0);
				}
				
			}
			else
			{ 
				//echo 'Eje 2<br/>';
				if($tipo_graficas[$ii]=='0')
				{
					$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'spline',/*pointInterval=> 3600 * 1000,*/ yAxis=> 1, zIndex=>3);
				}
				elseif($tipo_graficas[$ii]=='1')			
				{
					if($acumulado_horario==1)
						$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',/*pointInterval=> 3600 * 1000,*/ yAxis=> 1, zIndex=>1, pointPadding => -10, groupPadding => 0);
					else
						$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',/*pointInterval=> 3600 * 1000,*/ yAxis=> 1, zIndex=>1, pointPadding => 0, groupPadding => 0);
				}
				else
				{
					$data_temp[$ii] = array(name=> $nombre_curva, data=>$data_series, type=> 'column',pointInterval=> 3600 * 1000, yAxis=> 1, zIndex=>2, groupPadding => 0);
				}
				
			}			
			
			array_push($data_output, $data_temp[$ii]);
		}
		else
		{
			$data_temp[$ii] = 0;
		}
	}
	else
	{
		$data_temp[$ii] = 0;
	}
	
	
}	
//$data_output = array ($data_temp[0], $data_temp[1], $data_temp[2], $data_temp[3]);
echo json_encode($data_output);
mysqli_close($link);
?>
