<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';

function vCalculo_Valor($evento, $medidas, &$datos,  $dato_diario)
{
	//echo 'Convirtiendo '.$evento.' es: '.print_r($medidas);
	$dato_magnitud = array();
	foreach($medidas as $c=>$v)
	{
		if(strstr($v, ' ', true) != "")
		{
			$dato_magnitud[$c] = (float)strstr($v, ' ', true);	
		}
		else 
		{
			$dato_magnitud[$c] = (float)$v;	
		}	
	}
	list($valor,$conversion) = explode(" ",$medidas[0]);
	switch ($evento) 
	{		
		case '9':
			//Calculo de minimo
			$indice = array_keys($dato_magnitud,min($dato_magnitud));
			$datos = array(min($dato_magnitud)." ".$conversion,$dato_diario[$indice[0]][1],$dato_diario[$indice[0]][2],$dato_diario[$indice[0]][3]);
			//echo "Minimo ".$datos[0]." en el indice ".$indice[0]." con fechas ".$dato_diario[$indice[0]][1]." ".$dato_diario[$indice[0]][2]." ".$dato_diario[$indice[0]][3]." <br>";
			//echo "Minimo ".$datos[$indice_dia][0]." de ".$indice_dia." en el indice ".$indice[0]."<br>";
			break;
		case '10':
			//Calculo de promedio
			//$datos[$indice_dia] = ((array_sum($medidas))/(count($medidas)));
			$datos = array((round((array_sum($dato_magnitud))/(count($dato_magnitud)),3))." ".$conversion,date("Y-m-d 00:00:00",strtotime($dato_diario[0][1])),$dato_diario[0][2],$dato_diario[0][3]);
			//echo "Media ".$datos[$indice_dia][0]." de ".$indice_dia." <br>";
			break;
		case '11':
			//Calculo de acumulado
			//$datos[$indice_dia] = (array_sum($medidas));			
			$datos = array((array_sum($dato_magnitud))." ".$conversion,date("Y-m-d 00:00:00",strtotime($dato_diario[0][1])),$dato_diario[0][2],$dato_diario[0][3]);
			//echo "Acumulado ".$datos[$indice_dia][0]." de ".$indice_dia." <br>";
			break;
		default:
		case '8':
			//Calculo de maximo
			//foreach($medidas as $c=>$v)
			//$mifirePHP -> log("Indice ".$c." valor -> ".$v);
			//$mifirePHP -> log("Máximo ".max($dato_magnitud));
			//$mifirePHP -> log("Conversión ".$conversion);
			$indice = array_keys($dato_magnitud,max($dato_magnitud));
			$datos = array(max($dato_magnitud)." ".$conversion,$dato_diario[$indice[0]][1],$dato_diario[$indice[0]][2],$dato_diario[$indice[0]][3]);
			//echo "Maximo ".$medidas[0]." ".$datos[0]." en el indice ".$indice[0]." con fechas ".$dato_diario[$indice[0]][1]." ".$dato_diario[$indice[0]][2]." ".$dato_diario[$indice[0]][3]." <br>";
			break;

	}
	//$datos[$indice_dia] = '';
	//$indice_dia ++;
}


$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

$gw_id = $_GET["gw_id"];
$ipnodo = $_GET["nodo_ip"];
$sensorGW = $_GET["GWSensor"];
$sensorNodo = $_GET["NodeSensor"];
$evento = $_GET["evento"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$ver_gw = $_GET["ver_gw"];
$ver_nodo = $_GET["ver_nodo"];
$ver_utc = $_GET["ver_utc"];
$sensorUTC = $_GET["UTCSensor"];
$utc_id = $_GET["utc_id"];
$tablaParamsGw="cliente_params_gw";
$pagina = $_GET["pagina"];
$nombre = "";
$texto_evento = "";

switch ($evento) 
{
	case '9':
		$texto_evento = ($idiomas[$_SESSION['opcion_idioma']]['event_minimo_de'])." ";
		break;
	case '10':
		$texto_evento = ($idiomas[$_SESSION['opcion_idioma']]['event_promedio_de'])." ";
		break;
	case '11':
		$texto_evento = ($idiomas[$_SESSION['opcion_idioma']]['event_acumulado_de'])." ";
		break;
	default:
	case '8':
		$texto_evento = ($idiomas[$_SESSION['opcion_idioma']]['event_maximo_de'])." ";
		break;
}

if($ver_gw == 1)
{
	$nombre = $_GET['gw_nombre'];
	
	$gw_tipo = iObtenerTipoGW($gw_id, $cliente_db);
	
	if ($gw_tipo == $tipo_gw_low)
	{
		$sensor = "";
		//AMB 02/04/2012 Vamos a analizar a que intervalo pertenece el código de evento recibido, para saber si es un sensor analógico o digital
		if($sensorGW >= 4 && $sensorGW <= 7)
		{
			$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type4']." A".($sensorGW-3).")";
			//$mifirePHP -> log($sensor);
		}				
		else if($sensorGW >= 1 && $sensorGW <= 3)
		{
			$sensor = " (0..10V/4-20mA S".$sensorGW.")";
			//$mifirePHP -> log($sensor);
		}
		else if($sensorGW >= 8 && $sensorGW <= 9)
		{
			$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." P".($sensorGW-7).")";
			//$mifirePHP -> log($sensor);
		}	
		else if($sensorGW >= 20 && $sensorGW <= 23)
		{
			$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." D".($sensorGW-19).")";
			//$mifirePHP -> log($sensor);
		}	
		$texto_evento .= $idiomas[$_SESSION['opcion_idioma']]['general20'].$sensor;		
	}
	else
	{
		$texto_evento .= $idiomas[$_SESSION['opcion_idioma']]['general20']." S".$sensorGW;
	}					
	
}
else if($ver_nodo == 1)
{
	$nombre = $_GET['nodo_nombre'];
	$texto_evento .= $idiomas[$_SESSION['opcion_idioma']]['general21']." S".$sensorNodo;
}
else
{
	$nombre = $_GET['utc_nombre'];
	$texto_evento .= $idiomas[$_SESSION['opcion_idioma']]['general255'];
}
//echo $nombre." ".$texto_evento;

$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
if ($fecha_begin != "0")
{
	$fecha_begin_server = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_begin,$zona_horaria);
	$fecha_begin_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_begin);
	$fecha_begin_server_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_begin_server);
}
else 
{
	$fecha_begin = date_create();
	$fecha_begin = date_format($fecha_begin, 'Y-m-d H:i:s');
	//Con esto tenemos la fecha begin en la zona horaria de la instalacion
	$fecha_begin = sObtener_Fecha_Desde_String($cliente_db, $instalacion, $fecha_begin, $zona_horaria);
	//Se pone la fecha begin con dia 1 a las 00
	$fecha_begin = date_create_from_format('Y-m-01 00:00:00',$fecha_begin);
	//Finalmente se pasa a string
	$fecha_begin = date_format($fecha_begin, 'Y-m-d H:i:s');
	
	$fecha_begin_server = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_begin,$zona_horaria);
	$fecha_begin_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_begin);
	$fecha_begin_server_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_begin_server);
}
if ($fecha_end != "0")
{
	$fecha_end_server = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_end,$zona_horaria);
	$fecha_end_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_end);
	$fecha_end_server_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_end_server);
}
else
{
	$fecha_end_server = date_create();
	$fecha_end_server = date_format($fecha_end_server, 'Y-m-d H:i:s');
	$fecha_end = sObtener_Fecha_Desde_String($cliente_db, $instalacion, $fecha_end_server, $zona_horaria);
	$fecha_end_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_end);
	$fecha_end_server_datetime = date_create_from_format('Y-m-d H:i:s',$fecha_end_server);
}

$num_filas_tabla=15;

//Se calcula el dia final segun la pagina en la que estemos
$dias = ($pagina-1)*$num_filas_tabla;
//echo $dias." y pagina ".$pagina."<br>";
if($dias>0)
{
	$restar = $dias.' days';
	date_sub($fecha_end_datetime, date_interval_create_from_date_string($restar));
} 
$cuenta_filas = 0;

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

//Se prepara la query
if (($evento != "F") && (($ver_gw != 0) || ($ver_nodo != 0) || ($ver_utc != 0)))
{
	$error_datos = 0;
	
	$query = sprintf("select cliente_eventos.gw_id AS gw_id,
									  cliente_eventos.instalacion_id as instalacion_id,
									  cliente_eventos.nodo_ip AS nodo_ip,
									  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,
									  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
									  cliente_params_gw.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_params_nodo.nodo_nombre)) AS nombre,
									  cliente_eventos.evento_codigo AS evento_codigo,
									  %s.rfreenet_texto_eventos_%s.evento_texto AS texto,
									  cliente_eventos.evento_valor_raw AS valor,
									  cliente_eventos.evento_tiposensor as tiposensor, 
									  cliente_eventos.evento_fecha AS fecha,", $db_name_general, $_SESSION['opcion_idioma']); 
									  
	//AMB 13/03/2012 Según el tipo de GW cambiamos los campos a buscar dentro del IF, sólo en la parte de GW
	if($gw_tipo == $tipo_gw)
	{
		$query .= sprintf("	  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
				  cliente_params_gw.gw_TS%d,cliente_params_nodo.nodo_TS%d) AS tipo_sensor_config", ($sensorGW!="F"? $sensorGW:1), ($sensorNodo!="F"? $sensorNodo: 1));
	}
	elseif($gw_tipo == $tipo_gw_low)
	{
		//AMB 13/03/2012 En low power distinguiremos de analógico o digital según  el número						  			
		if($sensorGW <= 7)
		{
			$query .= sprintf("	  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
				  cliente_params_gw_low.gw_A%dK,cliente_params_nodo.nodo_TS%d) AS tipo_sensor_config", $sensorGW-1, ($sensorNodo!="F"? $sensorNodo: 1));	
		}
		else
		{
			$query .= sprintf("	  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
				  cliente_params_gw_low.gw_D%sK,cliente_params_nodo.nodo_TS%d) AS tipo_sensor_config", strtoupper(dechex($sensorGW-8)), ($sensorNodo!="F"? $sensorNodo: 1));					
		}
	}
	elseif($gw_tipo == $tipo_gw_lowT)
	{
		$query .= sprintf("	  IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), 
				   cliente_params_gw_lowt.gw_TI%d,cliente_params_nodo.nodo_TS%d) AS tipo_sensor_config", ($sensorGW!="F"? $sensorGW:1), ($sensorNodo!="F"? $sensorNodo: 1));
			
	}
	
	// Y añadimos la version de hw		  
	  	$query .= sprintf(", (CASE cliente_gateways.gw_tipo WHEN '%u' THEN cliente_params_gw.gw_versionHW
                          									WHEN '%u' THEN cliente_params_gw_low.gw_versionHW
                          									ELSE '12' END) AS versionHW", $tipo_gw, $tipo_gw_low);		
		  			
	//AMB 13/03/2012 Final de la query, utilizando la tabla de parámetros correspondiente segñun el tipo de GW 
	$query .= sprintf("	, IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,cliente_params_nodo.nodo_aux_operacion%u as operacion,cliente_params_nodo.nodo_aux_constante%u as constante,
											
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
	 from cliente_gateways 
                    left outer join ", ($sensorNodo!="F"? $sensorNodo: 1),($sensorNodo!="F"? $sensorNodo: 1));
	
	$query_dos = sprintf(" cliente_eventos on (cliente_gateways.gw_id = cliente_eventos.gw_id)
                    left outer join cliente_params_gw  on (cliente_params_gw.gw_id = cliente_eventos.gw_id)
                    left outer join cliente_params_gw_low on (cliente_eventos.gw_id  = cliente_params_gw_low.gw_id)
                    left outer join cliente_params_nodo  on (cliente_eventos.nodo_mac = cliente_params_nodo.nodo_mac)
                    left outer join cliente_analizadores on (cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND 
                                                             cliente_eventos.evento_codigo>'299' AND cliente_eventos.evento_codigo<'400')                                     
                    left outer join %s.rfreenet_modbus_conversion   on (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND 
                                                                     rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)						                                                   
                    left outer join %s.rfreenet_texto_eventos_%s on (cliente_eventos.evento_codigo = %s.rfreenet_texto_eventos_%s.evento_codigo AND 
							   	    (%s.rfreenet_texto_eventos_%s.evento_tipo = cliente_gateways.gw_tipo OR
                                                              %s.rfreenet_texto_eventos_%s.evento_tipo = -1))  								  								  
                    left outer join %s.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico on (%s.rfreenet_uds_sensor_generico.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) 
                                    WHEN 0 THEN cliente_params_gw.gw_A1UND
                                    WHEN 1 THEN cliente_params_gw.gw_A2UND
                                    WHEN 2 THEN cliente_params_gw.gw_A3UND
                                    WHEN 3 THEN cliente_params_gw.gw_A4UND
                                    WHEN 4 THEN cliente_params_gw.gw_A5UND
                                    WHEN 5 THEN cliente_params_gw.gw_A6UND
                                    WHEN 6 THEN cliente_params_gw.gw_A7UND
                                    WHEN 7 THEN cliente_params_gw.gw_A8UND
                                    WHEN 8 THEN cliente_params_gw.gw_A9UND ELSE 0 END))
                    left outer join %s.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_gen  on (%s.rfreenet_uds_sensor_generico_gen.cod_unidad = (case MOD(cliente_eventos.evento_codigo, 25) WHEN 0 THEN cliente_params_gw_low.gw_A0UND
                                          WHEN 1 THEN cliente_params_gw_low.gw_A1UND
                                          WHEN 2 THEN cliente_params_gw_low.gw_A2UND ELSE 0 END))
                    left outer join %s.rfreenet_uds_sensor_generico rfreenet_uds_sensor_generico_nodo on (%s.rfreenet_uds_sensor_generico_nodo.cod_unidad = (case MOD(cliente_eventos.evento_codigo-500, 6) 
                                        WHEN 0 THEN cliente_params_nodo.nodo_A1UND
                                        WHEN 1 THEN cliente_params_nodo.nodo_A2UND
                                        WHEN 2 THEN cliente_params_nodo.nodo_A3UND
                                        WHEN 3 THEN cliente_params_nodo.nodo_A4UND
                                        WHEN 4 THEN cliente_params_nodo.nodo_A5UND
                                        WHEN 5 THEN cliente_params_nodo.nodo_A6UND ELSE 0 END))	
								where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $db_name_general, $db_name_general, $_SESSION['opcion_idioma'],
																														 $db_name_general,  $_SESSION['opcion_idioma'], 
																														  $db_name_general, $_SESSION['opcion_idioma'],
																														   $db_name_general, $_SESSION['opcion_idioma'],
																														 $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general,  $instalacion);
	if ($gw_id!='000')
	{
		$queryaux .= " AND cliente_eventos.gw_id='".$gw_id."'";
	}
		
	if (($ver_gw == 0) && ($ver_nodo == 1))
	{
		if ($ipnodo!='F')
		{
			$queryaux .= " AND cliente_eventos.nodo_mac='".$ipnodo."'";
		}
		else
		{
			//echo "ERROR1";
			$error_datos = 1;
			continue;
		}
		
		switch ($sensorNodo)
		{
			case "1":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='500') OR (cliente_eventos.evento_codigo='506')";
				break;
			case "2":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='501') OR (cliente_eventos.evento_codigo='507')";
				break;
			case "3":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='502') OR (cliente_eventos.evento_codigo='508')";
				break;
			case "4":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='503') OR (cliente_eventos.evento_codigo='509')";
				break;
			case "5":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='504') OR (cliente_eventos.evento_codigo='510')";
				break;
			case "6":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='505') OR (cliente_eventos.evento_codigo='511')";
				break;
			default:
				//echo "ERROR2";
				$error_datos = 1;
				continue;
				break;							
		}
	}
	else if (($ver_gw == 1) && ($ver_nodo == 0))
	{
		$queryaux .= " AND ((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001'))";
		switch ($sensorGW)
		{
			case "1":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='600') OR (cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650') OR (cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700') OR (cliente_eventos.evento_codigo='725')";
				break;
			case "2":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='601') OR (cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651') OR (cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701') OR (cliente_eventos.evento_codigo='726')";
				break;
			case "3":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='602') OR (cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652') OR (cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702') OR (cliente_eventos.evento_codigo='727')";
				break;
			case "4":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='603') OR (cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653') OR (cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703') OR (cliente_eventos.evento_codigo='728')";
				break;
			case "5":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='604') OR (cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654') OR (cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704') OR (cliente_eventos.evento_codigo='729')";
				break;
			case "6":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='605') OR (cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655') OR (cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705') OR (cliente_eventos.evento_codigo='730')";
				break;
			case "7":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='606') OR (cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656') OR (cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706') OR (cliente_eventos.evento_codigo='731')";
				break;
			case "8":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='607') OR (cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657') OR (cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707') OR (cliente_eventos.evento_codigo='732')";
				break;
			case "9":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='608') OR (cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658') OR (cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708') OR (cliente_eventos.evento_codigo='733')";
				break;
			case "10":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='609') OR (cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659') OR (cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709') OR (cliente_eventos.evento_codigo='734')";
				break;
			case "11":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='610') OR (cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660') OR (cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710') OR (cliente_eventos.evento_codigo='735')";
				break;
			case "12":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='611') OR (cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661') OR (cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711') OR (cliente_eventos.evento_codigo='736')";
				break;
			case "13":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='612') OR (cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662') OR (cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712') OR (cliente_eventos.evento_codigo='737')";
				break;
			case "14":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='613') OR (cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663') OR (cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713') OR (cliente_eventos.evento_codigo='738')";
				break;
			case "15":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='614') OR (cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664') OR (cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714') OR (cliente_eventos.evento_codigo='739')";
				break;
			case "16":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='615') OR (cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665') OR (cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715') OR (cliente_eventos.evento_codigo='740')";
				break;
			case "17":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='616') OR (cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666') OR (cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716') OR (cliente_eventos.evento_codigo='741')";
				break;
			case "18":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='617') OR (cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667') OR (cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717') OR (cliente_eventos.evento_codigo='742')";
				break;
			case "19":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='618') OR (cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668') OR (cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718') OR (cliente_eventos.evento_codigo='743')";
				break;
			case "20":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='619') OR (cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669') OR (cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719') OR (cliente_eventos.evento_codigo='744')";
				break;
			case "21":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='620') OR (cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670') OR (cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720') OR (cliente_eventos.evento_codigo='745')";
				break;
			case "22":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='621') OR (cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671') OR (cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721') OR (cliente_eventos.evento_codigo='746')";
				break;
			case "23":
				$queryaux .= " AND ((cliente_eventos.evento_codigo='622') OR (cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672') OR (cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722') OR (cliente_eventos.evento_codigo='747')";
				break;
			default:
				//echo "ERROR3";
				$error_datos = 1;
				continue;
				break;							
		}
	}
	else if ($ver_utc == 1)
	{
		if ($utc_id!='0000')
		{
			$queryaux .= " AND cliente_eventos.nodo_mac='".$utc_id."'";
		}
		else
		{
			//echo "ERROR4";
			$error_datos = 1;
			continue;
		}
		//echo $sensorUTC;
		if ($sensorUTC!='F')
		{
			$numsensorUTC = 300 + $sensorUTC;	
			$queryaux .= " AND (cliente_eventos.evento_codigo='".$numsensorUTC."' ";	
		}
		else 
		{
			$error_datos = 1;
			continue;
		}
	}
	else
	{
		//echo "ERROR5";
		$error_datos = 1;
		continue;
		break;
	}
	$queryaux .=")";
	
	if($error_datos == 1)
	{
		echo pad_izquierda(1,8,'0');
		
		$ancho_1 = '25%';
		$ancho_2 = '35%';
		$ancho_3 = '25%';
		$ancho_4 = '15%';
		
		$alto='25px';
		//echo $query_final."<br>";
		echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
		echo "<tr>";
		echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general145']."</td>";
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general128']."</td>";
		echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general146']."</td>";
		
		echo "</tr>";
		for ($indice = 0; $indice<$num_filas_tabla; $indice++)
		{
			if ((($cuenta_filas)%2) == 0)
			{
				echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
			}
			else
			{
				 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
			}
			$cuenta_filas++;
		}
	}
	else
	{
		//Se calculan cuantas paginas habra
		$intervalo = date_diff($fecha_begin_server_datetime,$fecha_end_server_datetime);
		//var_dump($intervalo);
		if($intervalo!=false)
		{
			$dias_totales = $intervalo->format("%a");
		}
		else 
		{
			$dias_totales = 1;
		}
		
		//echo $query_aux."<br>";
		//echo pad_izquierda((ceil($dias_totales/$num_filas_tabla)),8,'0');
		
		$ancho_1 = '25%';
		$ancho_2 = '35%';
		$ancho_3 = '25%';
		$ancho_4 = '15%';
		
		$alto='25px';
		//echo $query_final."<br>";
		echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
		echo "<tr>";
		echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general145']."</td>";
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general128']."</td>";
		echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general146']."</td>";
		
		echo "</tr>";
		$dia_nuevo = 0;
		for ($indice = 0; $indice<$num_filas_tabla; $indice++)
		{
			//Creamos los formatos para el dia, con sus horas iniciales y finales
			$dia_inicio = date_format($fecha_end_datetime, 'Y-m-d 00:00:00');
			$dia_fin = date_format($fecha_end_datetime, 'Y-m-d 23:59:59');
			
			//Ahora se pasan a hora del servidor
			$dia_inicio_server = sObtener_Fecha_Inversa($cliente_db,$instalacion,$dia_inicio,$zona_horaria);
			$dia_fin_server = sObtener_Fecha_Inversa($cliente_db,$instalacion,$dia_fin,$zona_horaria);
			
			$dia_inicio_server_datetime = date_create_from_format('Y-m-d H:i:s',$dia_inicio_server);
			
			if ($dia_inicio_server_datetime >= $fecha_begin_server_datetime)
			{
				$indice_medidas = 0;
				$medidas = array();
				$dato_diario = array();
				$NombreTabla = "cliente_eventos_".date_format($dia_inicio_server_datetime,'m').date_format($dia_inicio_server_datetime,'Y');
				$NombreTabla2 = "cliente_eventos_".date_format($dia_inicio_server_datetime,'m').date_format($dia_inicio_server_datetime,'Y');
				
				$query_final = $query.$NombreTabla.$query_dos." AND evento_fecha>='".$fecha_begin_server."' AND evento_fecha>='".$dia_inicio_server."' AND evento_fecha<='".$fecha_end_server."' AND evento_fecha<='".$dia_fin_server."'".$queryaux;
				
				//echo "<br/>".$query_final."<br/>";
				if (table_exists($NombreTabla, $link))
				{
					$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
					
					if(!$result)
					{
						if ((($cuenta_filas)%2) == 0)
						{
							echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
						}
						else
						{
							 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
						}
					}
					else
					{
						while ($row = mysql_fetch_array($result))
						{
							if(($row['tipo_sensor_config'] != $row['tiposensor']) && (($row['evento_codigo']<300) || ($row['evento_codigo']>399)))
							{
								//La medida no es valida porque no tiene el sensor configurado como toca (excepto si es un analizador)
								//echo "Medida no valida <br>";
								continue;
							}
							if(($dia_nuevo == 0) && ($row['evento_codigo']>299) && ($row['evento_codigo']<400))
							{
								$texto_evento .= " ".sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1));
							}
							$dia_nuevo = 1;
							if (($row['nodo_ip'] === "000") || ($row['nodo_ip'] === "001"))
							{
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
								//echo $row['nodo_ip']." tipo ".$row['tiposensor']."<br/>";
								if(($row['tiposensor'] == 35) || ($row['tiposensor'] == 36))
								{							
									$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo_gen'], $row['minimo_gen'], $row['nombre_unidad_gen'], $iResGW2);	
								}
								else if (($row['tiposensor'] == 16) || ($row['tiposensor'] == 2))
								{
									$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW2);
								}
								else if (($row['tiposensor'] > 20) && ($row['tiposensor'] < 27))
								{
									$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW1);
								}
								else 
								{
									//echo intval($row['evento_codigo']).' de '.$row['gw_id'];
									$valor = sConvertir_Datos_GW(hexdec($row['valor']), $row['tiposensor'], 0, $row['gw_id'], (intval($row['evento_codigo'])%25), 0, $row['versionHW']);
								}
							}
							else if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
							{
								$valor = sConvertir_Datos_UTC(hexdec($row['valor']), $row['tiposensor'],0,$row['modbus_operacion'],$row['modbus_operando'],1);
								//$mifirePHP -> log("VALOR CONVERTIDO ".$valor);
							}	
							// Si es un nodo
							else
							{
								//$valor = sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',0,$row['operacion'],$row['constante']);
								if((substr($row['tiposensor'], 0, 1) == '4' || 
								  substr($row['tiposensor'], 0, 1) == 'D' ||
								  substr($row['tiposensor'], 0, 1) == 'd' ||
								  substr($row['tiposensor'], 0, 1) == 'C' ||
								  substr($row['tiposensor'], 0, 1) == 'c') &&
								  substr($row['tiposensor'], 2, 1) == '0')
								{
									$valor = sConvertir_Datos_Nodo_Generico(hexdec($row['valor']), $row['tiposensor'],0, $row['maximo_nodo'], $row['minimo_nodo'], $row['nombre_unidad_nodo']);
								}
								else 
								{
									$valor = sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',0,$row['operacion'],$row['constante']);
								}
							}
							//echo "Guardamos ".hexdec($row['valor'])." = ".$valor." de tipo ".$row['tiposensor']."<br>";
							//echo "Guardamos ".hexdec($row['valor'])." = ".$valor." de fecha ".$row['fecha']." con texto ".utf8_encode($row['texto'])." nombre ".$nombre." en ".$indice_medidas."<br>";
							$medidas[$indice_medidas] = $valor;
							$dato_diario[$indice_medidas] = array($valor, sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['fecha'],$zona_horaria), $texto_evento, $nombre);
							//echo " Dato ".$dato_diario[$indice_medidas][0]." con fecha ".$row['fecha']." vs ".$dato_diario[$indice_medidas][1]." e indice ".$indice_medidas."<br>";
							$indice_medidas++;
						}
					}
				}

				if($NombreTabla!=$NombreTabla2)
				{
					$query_final =$query.$NombreTabla2.$query_dos." AND evento_fecha>='".$fecha_begin_server."' AND evento_fecha>='".$dia_inicio_server."' AND evento_fecha<='".$fecha_end_server."' AND evento_fecha<='".$dia_fin_server."'".$queryaux;
				
					//echo "Segunda query: ".$query_final."<br>";
					if (table_exists($NombreTabla2, $link))
					{
						$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
						
						if(!$result)
						{
							if ((($cuenta_filas)%2) == 0)
							{
								echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
							}
							else
							{
								 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
							}
						}
						else 
						{
							while ($row = mysql_fetch_array($result))
							{
								if(($row['tipo_sensor_config'] != $row['tiposensor']) && (($row['evento_codigo']<300) || ($row['evento_codigo']>399)))
								{
									//La medida no es valida porque no tiene el sensor configurado como toca (excepto si es un analizador)
									//echo "Medida no valida <br>";
									continue;
								}
								if(($dia_nuevo == 0) && ($row['evento_codigo']>299) && ($row['evento_codigo']<400))
								{
									$texto_evento .= " ".sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1));
								}
								$dia_nuevo = 1;
								if (($row['nodo_ip'] === "000") || ($row['nodo_ip'] === "001"))
								{
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
										$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo_gen'], $row['minimo_gen'], $row['nombre_unidad_gen'], $iResGW2);	
									}
									else if(($row['tiposensor'] == 16)||($row['tiposensor'] == 2))
									{
										$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW2);
									}
									else if(($row['tiposensor'] > 20)&&($row['tiposensor'] < 27))
									{
										$valor = sConvertir_Datos_GW_Generico(hexdec($row['valor']), $row['tiposensor'], 0, $row['maximo'], $row['minimo'], $row['nombre_unidad'], $iResGW1);
									}
									else 
									{
										$valor = sConvertir_Datos_GW(hexdec($row['valor']), $row['tiposensor'], 0, $row['gw_id'], (intval($row['evento_codigo'])%25), 0, $row['versionHW']);
									}
								}
								else if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
								{
									$valor = sConvertir_Datos_UTC(hexdec($row['valor']), $row['tiposensor'],0,$row['modbus_operacion'],$row['modbus_operando'],1);
									//$mifirePHP -> log("VALOR CONVERTIDO ".$valor);
								}	
								// Si es un nodo
								else
								{
									//$valor = sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',0,$row['operacion'],$row['constante']);
									if((substr($row['tiposensor'], 0, 1) == '4' || 
									  substr($row['tiposensor'], 0, 1) == 'D' ||
									  substr($row['tiposensor'], 0, 1) == 'd' ||
									  substr($row['tiposensor'], 0, 1) == 'C' ||
									  substr($row['tiposensor'], 0, 1) == 'c') &&
									  substr($row['tiposensor'], 2, 1) == '0')
									{										
										$valor = sConvertir_Datos_Nodo_Generico(hexdec($row['valor']), $row['tiposensor'],0, $row['maximo_nodo'], $row['minimo_nodo'], $row['nombre_unidad_nodo']);
									}
									else 
									{
										$valor = sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',0,$row['operacion'],$row['constante']);
									}
								}
								//echo "Guardamos ".$valor." de fecha ".$row['fecha']." con texto ".utf8_encode($row['texto'])." nombre ".$nombre." en ".$indice_medidas."<br>";
								$medidas[$indice_medidas] = $valor;
								$dato_diario[$indice_medidas] = array($valor, sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['fecha'],$zona_horaria), $texto_evento, $nombre);
								$indice_medidas++;
							}
						}
					}
				}

				//Y ahora se calcula el valor del dia
				if($indice_medidas>0)
				{
					//echo "Calculo final del dia ".$dia_inicio."<br>";
					//print_r(&$datos);
					//echo "<br/>";
					vCalculo_Valor($evento, $medidas, $datos, $dato_diario);
					
					//Y se saca el valor por pantalla
					if ((($cuenta_filas)%2) == 0)
					{
						echo "<tr class=\"tipo_fila_2\" height=\"$alto\">";
					}
					else
					{
						 echo "<tr class=\"tipo_fila_1\" height=\"$alto\">";
					}
					echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$datos[1]."</td>";
		
					/*if(1)
					{*/
						echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$datos[2]."</td>";	
					/*
					}
					elseif ($gw_tipo == $tipo_gw_low)
					{
						//$mifirePHP -> log($sensorGW);
						$sensor = "";
						//AMB 02/04/2012 Vamos a analizar a que intervalo pertenece el código de evento recibido, para saber si es un sensor analógico o digital				
						if($sensorGW <= 7)
						{
							$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type4']." ".$sensorGW.")";
						}
						elseif($sensorGW > 7)
						{				
							$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." ".($sensorGW - 7).")";						
						}
						if($datos[$cuenta_filas][2] <> "")
						{
							echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$datos[2].$sensor."</td>";
						}
						else
						{
							echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td>";
						}			
					}		
					*/
					
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$datos[3]."</td>";
			
					echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$datos[0]."</td>";
					
					echo "</tr>";
					
				}
				else 
				{
					//echo "No hay datos en el dia ".$dia_inicio."<br>";
					if ((($cuenta_filas)%2) == 0)
					{
						echo "<tr class=\"tipo_fila_2\" height=\"$alto\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$dia_inicio."</td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$texto_evento."</td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$nombre."</td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general143']."</td></tr>";
					}
					else
					{
						 echo "<tr class=\"tipo_fila_1\" height=\"$alto\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$dia_inicio."</td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$texto_evento."</td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$nombre."</td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general143']."</td></tr>";
					}
				}
				
			}
			else
			{
				if ((($cuenta_filas)%2) == 0)
				{
					echo "<tr class=\"tipo_fila_2\" height=\"$alto\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
				}
				else
				{
					 echo "<tr class=\"tipo_fila_1\" height=\"$alto\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
				}
			}
			
			$fecha_end_datetime = date_sub($fecha_end_datetime, date_interval_create_from_date_string('1 days'));
			$cuenta_filas++;
		}
	}
}
else 
{
	echo pad_izquierda(1,8,'0');
	
	$ancho_1 = '25%';
	$ancho_2 = '35%';
	$ancho_3 = '25%';
	$ancho_4 = '15%';
	
	$alto='25px';
	//echo $query_final."<br>";
	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general145']."</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general128']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general146']."</td>";
	
	echo "</tr>";
	for ($indice = 0; $indice<$num_filas_tabla; $indice++)
	{
		if ((($cuenta_filas)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		$cuenta_filas++;
	}
}

echo "</table>";
if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);
?>
