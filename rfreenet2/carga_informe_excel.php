<?php
ini_set('memory_limit','300M');
ini_set('max_execution_time','600');
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';


$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$tipo_informe = $_GET["tipo_informe"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$evento = $_GET["evento"];
$id_dispositivo = $_GET["id_dispositivo"];

$tipo_dispositivo = substr($id_dispositivo,0,1);
$gw_id = substr($id_dispositivo,1,4);
$nodo_mac = substr($id_dispositivo,5,12);
$num_sensor_informe = substr($id_dispositivo,17,2);
//echo $num_sensor_informe;

// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
$array_versiones = sObtener_Versiones_GW($gw_id, $cliente_db);
$caGWVersionHW = $array_versiones[0];

/*Se convierte la hora a la del servidor*/
$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
//echo $zona_horaria."<br>";
$fecha_begin = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_begin,$zona_horaria);
//echo $fecha_begin."<br>";
$fecha_end = sObtener_Fecha_Inversa($cliente_db,$instalacion,$fecha_end,$zona_horaria);
//echo $fecha_end."<br>";

/**/

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

$query = "";

list($fecha_begin_ex,$hora_init_ex)= explode(" ",$fecha_begin);
list($fecha_end_ex,$hora_end_ex)= explode(" ",$fecha_end);

list($anyo_begin,$mes_begin,$pipo)= explode("-",$fecha_begin_ex);
list($anyo_end,$mes_end,$pipo)= explode("-",$fecha_end_ex);		

//echo "Mes inicio ".intval($mes_begin)." Mes fin ".intval($mes_end)."<br>";
////echo "Anyo inicio ".intval($anyo_begin)." Anyo fin ".intval($anyo_end)."<br>";

$query_final = "select * from (";
$i=0;

$mes_begin=intval($mes_begin);
$mes_end=intval($mes_end);
$anyo_begin=intval($anyo_begin);
$anyo_end=intval($anyo_end);

$mes_actual=$mes_begin;
$anyo_actual=$anyo_begin;

$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_begin);
$cadena_final=sprintf("%02u%04u",$anyo_actual,$anyo_end);
$cadena_actual=$cadena_inicial;
$primero = 1;

while($cadena_actual!='FIN')
{
	$NombreTabla = "cliente_eventos_".$cadena_actual;
	//echo "Vamos a ver si la tabla ".$NombreTabla." existe<br>";
	if (table_exists($NombreTabla,$link))
	{
		if($primero!=1)
		{
			$query_final .= " UNION ";
			$queryaux = "";
		}
		//$query = sprintf("(select cliente_eventos.gw_id AS gw_id,cliente_instalaciones.instalacion_nombre as instalacion_nombre,cliente_eventos.nodo_ip as nodo_ip, IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), cliente_gateways.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,cliente_eventos.evento_codigo AS evento_codigo,(CASE cliente_eventos.evento_codigo WHEN '500' THEN cliente_nodos.nodo_nombre_s1 WHEN '506' THEN cliente_nodos.nodo_nombre_s1 WHEN '512' THEN cliente_nodos.nodo_nombre_s1 WHEN '501' THEN cliente_nodos.nodo_nombre_s2 WHEN '507' THEN cliente_nodos.nodo_nombre_s2 WHEN '513' THEN cliente_nodos.nodo_nombre_s2 WHEN '502' THEN cliente_nodos.nodo_nombre_s3 WHEN '508' THEN cliente_nodos.nodo_nombre_s3 WHEN '514' THEN cliente_nodos.nodo_nombre_s3 WHEN '503' THEN cliente_nodos.nodo_nombre_s4 WHEN  '509' THEN cliente_nodos.nodo_nombre_s4 WHEN '515' THEN cliente_nodos.nodo_nombre_s4 WHEN '504' THEN cliente_nodos.nodo_nombre_s5 WHEN '510' THEN cliente_nodos.nodo_nombre_s5 WHEN '516' THEN cliente_nodos.nodo_nombre_s5 WHEN '505' THEN cliente_nodos.nodo_nombre_s6 WHEN '511' THEN cliente_nodos.nodo_nombre_s6 WHEN '517' THEN cliente_nodos.nodo_nombre_s6 ELSE '-' END) AS sensor_nombre,cliente_eventos.evento_valor_raw AS valor,cliente_eventos.evento_tiposensor as tiposensor, 1000*unix_timestamp(cliente_eventos.evento_fecha) AS fecha from (cliente_analizadores right join (cliente_instalaciones inner join (cliente_gateways join (cliente_nodos right join ((%s as cliente_eventos)) on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $NombreTabla, $instalacion);
		$query = sprintf("(select cliente_eventos.gw_id AS gw_id,cliente_instalaciones.instalacion_nombre as instalacion_nombre,cliente_eventos.nodo_ip as nodo_ip, IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), '000',cliente_eventos.nodo_mac) AS nodo_mac,IF (((cliente_eventos.nodo_ip = '000') OR (cliente_eventos.nodo_ip = '001')), cliente_gateways.gw_nombre,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,cliente_eventos.evento_codigo AS evento_codigo,%s.rfreenet_texto_eventos_%s.evento_texto AS texto,(CASE cliente_eventos.evento_codigo WHEN '500' THEN cliente_nodos.nodo_nombre_s1 WHEN '506' THEN cliente_nodos.nodo_nombre_s1 WHEN '512' THEN cliente_nodos.nodo_nombre_s1 WHEN '501' THEN cliente_nodos.nodo_nombre_s2 WHEN '507' THEN cliente_nodos.nodo_nombre_s2 WHEN '513' THEN cliente_nodos.nodo_nombre_s2 WHEN '502' THEN cliente_nodos.nodo_nombre_s3 WHEN '508' THEN cliente_nodos.nodo_nombre_s3 WHEN '512' THEN cliente_nodos.nodo_nombre_s3 WHEN '503' THEN cliente_nodos.nodo_nombre_s4 WHEN '509' THEN cliente_nodos.nodo_nombre_s4 WHEN '515' THEN cliente_nodos.nodo_nombre_s4 WHEN '504' THEN cliente_nodos.nodo_nombre_s5 WHEN '510' THEN cliente_nodos.nodo_nombre_s5 WHEN '516' THEN cliente_nodos.nodo_nombre_s5 WHEN '505' THEN cliente_nodos.nodo_nombre_s6 WHEN '511' THEN cliente_nodos.nodo_nombre_s6 WHEN '517' THEN cliente_nodos.nodo_nombre_s6 WHEN '600' THEN cliente_gateways.gw_nombre_s1 WHEN '625' THEN cliente_gateways.gw_nombre_s1 WHEN '601' THEN cliente_gateways.gw_nombre_s2 WHEN '626' THEN cliente_gateways.gw_nombre_s2 WHEN '602' THEN cliente_gateways.gw_nombre_s3 WHEN '627' THEN cliente_gateways.gw_nombre_s3 WHEN '603' THEN cliente_gateways.gw_nombre_s4 WHEN '628' THEN cliente_gateways.gw_nombre_s4 WHEN '604' THEN cliente_gateways.gw_nombre_s5 WHEN '629' THEN cliente_gateways.gw_nombre_s5 WHEN '605' THEN cliente_gateways.gw_nombre_s6 WHEN '630' THEN cliente_gateways.gw_nombre_s6 WHEN '606' THEN cliente_gateways.gw_nombre_s7 WHEN '631' THEN cliente_gateways.gw_nombre_s7 WHEN '607' THEN cliente_gateways.gw_nombre_s8 WHEN '632' THEN cliente_gateways.gw_nombre_s8 WHEN '608' THEN cliente_gateways.gw_nombre_s9 WHEN '633' THEN cliente_gateways.gw_nombre_s9 WHEN '609' THEN cliente_gateways.gw_nombre_s10 WHEN '634' THEN cliente_gateways.gw_nombre_s10 WHEN '610' THEN cliente_gateways.gw_nombre_s11 WHEN '635' THEN cliente_gateways.gw_nombre_s11 WHEN '611' THEN cliente_gateways.gw_nombre_s12 WHEN '636' THEN cliente_gateways.gw_nombre_s12 WHEN '612' THEN cliente_gateways.gw_nombre_s13 WHEN '637' THEN cliente_gateways.gw_nombre_s13 WHEN '613' THEN cliente_gateways.gw_nombre_s14 WHEN '638' THEN cliente_gateways.gw_nombre_s14 WHEN '614' THEN cliente_gateways.gw_nombre_s15 WHEN '639' THEN cliente_gateways.gw_nombre_s15 WHEN '615' THEN cliente_gateways.gw_nombre_s16 WHEN '640' THEN cliente_gateways.gw_nombre_s16 WHEN '616' THEN cliente_gateways.gw_nombre_s17 WHEN '641' THEN cliente_gateways.gw_nombre_s17 WHEN '617' THEN cliente_gateways.gw_nombre_s18 WHEN '642' THEN cliente_gateways.gw_nombre_s18 WHEN '618' THEN cliente_gateways.gw_nombre_s19 WHEN '643' THEN cliente_gateways.gw_nombre_s19 WHEN '619' THEN cliente_gateways.gw_nombre_s20 WHEN '644' THEN cliente_gateways.gw_nombre_s20 WHEN '620' THEN cliente_gateways.gw_nombre_s21 WHEN '645' THEN cliente_gateways.gw_nombre_s21 WHEN '621' THEN cliente_gateways.gw_nombre_s22 WHEN '646' THEN cliente_gateways.gw_nombre_s22 WHEN '622' THEN cliente_gateways.gw_nombre_s23 WHEN '647' THEN cliente_gateways.gw_nombre_s23 ELSE '-' END) AS sensor_nombre,cliente_eventos.evento_valor_raw AS valor,cliente_eventos.evento_tiposensor as tiposensor, unix_timestamp(cliente_eventos.evento_fecha) AS fecha,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,IF(((cliente_eventos.evento_codigo > 299) AND (cliente_eventos.evento_codigo<400)),rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,cliente_params_nodo.nodo_aux_operacion%u as operacion,cliente_params_nodo.nodo_aux_constante%u as constante from (cliente_params_nodo right join (%s.rfreenet_modbus_conversion right join (cliente_analizadores right join (cliente_instalaciones inner join (cliente_gateways join (cliente_nodos right join (%s as cliente_eventos ) on (cliente_eventos.nodo_mac = cliente_nodos.nodo_mac)) on (cliente_gateways.gw_id = cliente_eventos.gw_id)) on (cliente_instalaciones.instalacion_id=cliente_eventos.instalacion_id)) on (cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) on (%s.rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND %s.rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo)) on (cliente_eventos.nodo_mac = cliente_params_nodo.nodo_mac)) left join %s.rfreenet_texto_eventos_%s on (cliente_eventos.evento_codigo = %s.rfreenet_texto_eventos_%s.evento_codigo AND (%s.rfreenet_texto_eventos_%s.evento_tipo = cliente_gateways.gw_tipo OR
                                                                                 %s.rfreenet_texto_eventos_%s.evento_tipo = -1)) where (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s')", $db_name_general, $_SESSION['opcion_idioma'], (((($tipo_dispositivo == 'N' || $tipo_dispositivo == 'n')) && ($num_sensor_informe!=99)) ?($num_sensor_informe+1):1),(((($tipo_dispositivo == 'N' || $tipo_dispositivo == 'n')) && ($num_sensor_informe!=99)) ?($num_sensor_informe+1):1),$db_name_general,$NombreTabla, $db_name_general,$db_name_general, $db_name_general, $_SESSION['opcion_idioma'], $db_name_general, $_SESSION['opcion_idioma'], $db_name_general, $_SESSION['opcion_idioma'], $db_name_general, $_SESSION['opcion_idioma'],$instalacion );
		$query .= " AND evento_fecha>'".$fecha_begin."'  AND evento_fecha<'".$fecha_end."'";
		
		switch ($tipo_dispositivo)
		{
			case 'G':
			case 'g':
				//echo "Informe de gw ".$gw_id." del sensor ".$num_sensor_informe.'<br/>';				
				$queryaux .= " AND cliente_eventos.gw_id='".$gw_id."'";
				switch ($evento)
				{
					// Si piden datos:
					case 0:
						switch ($num_sensor_informe)
						{
							case "0":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='600') OR (cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650') OR (cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700'))";
								break;
							case "1":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='601') OR (cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651') OR (cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701'))";
								break;
							case "2":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='602') OR (cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652') OR (cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702'))";
								break;
							case "3":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='603') OR (cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653') OR (cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703'))";
								break;
							case "4":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='604') OR (cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654') OR (cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704'))";
								break;
							case "5":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='605') OR (cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655') OR (cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705'))";
								break;
							case "6":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='606') OR (cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656') OR (cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706'))";
								break;
							case "7":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='607') OR (cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657') OR (cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707'))";
								break;
							case "8":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='608') OR (cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658') OR (cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708'))";
								break;
							case "9":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='609') OR (cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659') OR (cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709'))";
								break;
							case "10":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='610') OR (cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660') OR (cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710'))";
								break;
							case "11":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='611') OR (cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661') OR (cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711'))";
								break;
							case "12":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='612') OR (cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662') OR (cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712'))";
								break;
							case "13":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='613') OR (cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663') OR (cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713'))";
								break;
							case "14":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='614') OR (cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664') OR (cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714'))";
								break;
							case "15":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='615') OR (cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665') OR (cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715'))";
								break;
							case "16":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='616') OR (cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666') OR (cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716'))";
								break;
							case "17":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='617') OR (cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667') OR (cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717'))";
								break;
							case "18":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='618') OR (cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668') OR (cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718'))";
								break;
							case "19":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='619') OR (cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669') OR (cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719'))";
								break;
							case "20":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='620') OR (cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670') OR (cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720'))";
								break;
							case "21":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='621') OR (cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671') OR (cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721'))";
								break;
							case "22":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='622') OR (cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672') OR (cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722'))";
								break;																
							default:
								$queryaux .= "AND (((cliente_eventos.evento_codigo>'599') AND (cliente_eventos.evento_codigo<'748'))";
								break;										
						}
						break;
						
					// Si piden cobertura, error
					case 1:
						break;
						
					// Si piden alimentacion, solo bateria y 220
					case 2:
						$queryaux .= " AND ((cliente_eventos.evento_codigo='805') OR (cliente_eventos.evento_codigo='806'))";
						break;
						
					// Si piden cobertura GPRS
					case 3:
						$queryaux .= " AND (cliente_eventos.evento_codigo='807')";
						break;
						
					// Si piden umbrales
					case 4:
						switch ($num_sensor_informe)
						{

							case "0":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650'))";
								break;
							case "1":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651'))";
								break;
							case "2":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652'))";
								break;
							case "3":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653'))";
								break;
							case "4":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654'))";
								break;
							case "5":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655'))";
								break;
							case "6":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656'))";
								break;
							case "7":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657'))";
								break;
							case "8":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658'))";
								break;
							case "9":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659'))";
								break;
							case "10":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660'))";
								break;
							case "11":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661'))";
								break;
							case "12":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662'))";
								break;
							case "13":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663'))";
								break;
							case "14":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664'))";
								break;
							case "15":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665'))";
								break;
							case "16":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666'))";
								break;
							case "17":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667'))";
								break;	
							case "18":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668'))";
								break;
							case "19":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669'))";
								break;
							case "20":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670'))";
								break;
							case "21":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671'))";
								break;
							case "22":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672'))";
								break;															
							default:
								$queryaux .= "AND ((cliente_eventos.evento_codigo>'624') AND (cliente_eventos.evento_codigo<'673'))";
								break;																	
						}
						break;
						
					// Si piden gradientes
					case 5:
						switch ($num_sensor_informe)
						{
							case "0":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700'))";
								break;
							case "1":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701'))";
								break;
							case "2":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702'))";
								break;
							case "3":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703'))";
								break;
							case "4":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704'))";
								break;
							case "5":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705'))";
								break;
							case "6":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706'))";
								break;
							case "7":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707'))";
								break;
							case "8":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708'))";
								break;
							case "9":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709'))";
								break;
							case "10":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710'))";
								break;
							case "11":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711'))";
								break;
							case "12":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712'))";
								break;
							case "13":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713'))";
								break;
							case "14":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714'))";
								break;
							case "15":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715'))";
								break;
							case "16":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716'))";
								break;
							case "17":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717'))";
								break;		
							case "18":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718'))";
								break;
							case "19":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719'))";
								break;
							case "20":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720'))";
								break;
							case "21":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721'))";
								break;
							case "22":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722'))";
								break;														
							default:
								break;							
						}
						break;
						
					default:
						break;
				}
				break;
				
			case 'N':
			case 'n':
				//echo "Informe de nodo ".$nodo_mac." del sensor ".$num_sensor_informe.'<br/>';
				$queryaux .= " AND cliente_eventos.nodo_mac='".$nodo_mac."' AND cliente_eventos.gw_id='".$gw_id."'";
				switch ($evento)
				{
					// Si piden datos:
					case 0:
						switch ($num_sensor_informe)
						{
							case "0":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='500') OR (cliente_eventos.evento_codigo='506') OR (cliente_eventos.evento_codigo='513'))";
								break;
							case "1":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='501') OR (cliente_eventos.evento_codigo='507') OR (cliente_eventos.evento_codigo='514'))";
								break;
							case "2":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='502') OR (cliente_eventos.evento_codigo='508') OR (cliente_eventos.evento_codigo='515'))";
								break;
							case "3":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='503') OR (cliente_eventos.evento_codigo='509') OR (cliente_eventos.evento_codigo='516'))";
								break;
							case "4":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='504') OR (cliente_eventos.evento_codigo='510') OR (cliente_eventos.evento_codigo='517'))";
								break;
							case "5":
								$queryaux .= " AND ((cliente_eventos.evento_codigo='505') OR (cliente_eventos.evento_codigo='511') OR (cliente_eventos.evento_codigo='518'))";
								break;
							default:
								$queryaux .= " AND ((cliente_eventos.evento_codigo>499) AND (cliente_eventos.evento_codigo<520))";
								break;							
						}
						break;
						
					// Si piden cobertura, solo mostraremos eventos de cobertura
					case 1:
						$queryaux .= " AND (cliente_eventos.evento_codigo='800')";
						break;
						
					// Si piden alimentacion, solo bateria
					case 2:
						$queryaux .= " AND (cliente_eventos.evento_codigo='801')";
						break;
						
					// Si piden cobertura GPRS, error
					case 3:
						break;

					// Si piden umbrales
					case 4:
						switch ($num_sensor_informe)
						{
							case "0":
								$queryaux .= " AND (cliente_eventos.evento_codigo='506')";
								break;
							case "1":
								$queryaux .= " AND (cliente_eventos.evento_codigo='507')";
								break;
							case "2":
								$queryaux .= " AND (cliente_eventos.evento_codigo='508')";
								break;
							case "3":
								$queryaux .= " AND (cliente_eventos.evento_codigo='509')";
								break;
							case "4":
								$queryaux .= " AND (cliente_eventos.evento_codigo='510')";
								break;
							case "5":
								$queryaux .= " AND (cliente_eventos.evento_codigo='511')";
								break;
							default:
								break;							
						}
						break;
						
					// Si piden gradientes
					case 4:
						switch ($num_sensor_informe)
						{
							case "0":
								$queryaux .= " AND (cliente_eventos.evento_codigo='513')";
								break;
							case "1":
								$queryaux .= " AND (cliente_eventos.evento_codigo='514')";
								break;
							case "2":
								$queryaux .= " AND (cliente_eventos.evento_codigo='515')";
								break;
							case "3":
								$queryaux .= " AND (cliente_eventos.evento_codigo='516')";
								break;
							case "4":
								$queryaux .= " AND (cliente_eventos.evento_codigo='517')";
								break;
							case "5":
								$queryaux .= " AND (cliente_eventos.evento_codigo='518')";
								break;
							default:
								break;							
						}
						break;
						
					default:
						break;
				}
				break;
			case 'U':
			case 'u':
				$query .= " AND cliente_eventos.nodo_ip='".substr($nodo_mac,10,2)."' AND cliente_eventos.gw_id='".$gw_id."'";
				$numsensorUTC = 300 + $num_sensor_informe;	
				$query .= " AND cliente_eventos.evento_codigo='".$numsensorUTC."' ";	
				break;
			default:
				break;
		}
					
		$query.=$queryaux;
		$query .= " AND year(evento_fecha)>2000 and year(evento_fecha)<2100 ORDER BY evento_fecha)";		
		$query_final .= $query;
		$primero = 0;
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
//echo $query_final;

if (($query_final != "") && ($primero != 1))
{
	$result = mysql_query($query_final,$link) or die('DIE:'.mysql_error()."<br>".$query_final);
}
else
{
	$result = false;
}

if(!$result)
{
	//echo "No se han encontrado resultados";
	//$img = file_get_contents("images/sin_datos.jpg");
	//echo $img;
}
else
{
	//$datos = utf8_decode("Instalación;Gateway;Origen;MAC;Nombre;Tipo;Evento;SensorNum;SensorNombre;");
	//$datos .= utf8_decode("SensorTipo;Hora;Minuto;Segundo;Dia;Mes;Año;ValorRAW;ValorCONVERTIDO;Unidades;\r\n");
	$datos = utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7'].";".$idiomas[$_SESSION['opcion_idioma']]['general20'].";".$idiomas[$_SESSION['opcion_idioma']]['general128'].";".$idiomas[$_SESSION['opcion_idioma']]['general30'].";".$idiomas[$_SESSION['opcion_idioma']]['general38'].";".$idiomas[$_SESSION['opcion_idioma']]['general66'].";".$idiomas[$_SESSION['opcion_idioma']]['general31'].";".$idiomas[$_SESSION['opcion_idioma']]['general131'].";".$idiomas[$_SESSION['opcion_idioma']]['general132'].";");
	$datos .= utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general133'].";".$idiomas[$_SESSION['opcion_idioma']]['general134'].";".$idiomas[$_SESSION['opcion_idioma']]['general135'].";".$idiomas[$_SESSION['opcion_idioma']]['general136'].";".$idiomas[$_SESSION['opcion_idioma']]['general137'].";".$idiomas[$_SESSION['opcion_idioma']]['general138'].";".$idiomas[$_SESSION['opcion_idioma']]['general139'].";".$idiomas[$_SESSION['opcion_idioma']]['general140'].";".$idiomas[$_SESSION['opcion_idioma']]['general141'].";".$idiomas[$_SESSION['opcion_idioma']]['general142'].";\r\n");
	
	while ($row = mysql_fetch_array($result))
	{
		
		$datos .= $row["instalacion_nombre"].";".$row['gw_id'].";";
		if($row['nodo_ip']=== "000" || $row['nodo_ip']=== "001")
		{
			$datos .= "G;";	
			$conv = sConvertir_Datos_GW(hexdec($row['valor']), $row['tiposensor'],0,$row['gw_id'], (intval($row['evento_codigo'])%25),1, $caGWVersionHW);
			$tipo_sensor = sObtener_Cadena_Tipo_Sensor_GW($row['tiposensor']);
		}
		else if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
		{
			$datos .= "U;";	
			$tipo_sensor = sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1));	
			$conv=sConvertir_Datos_UTC(hexdec($row['valor']), substr($row['tiposensor'],0,2),0,$row['modbus_operacion'],$row['modbus_operando'],1);
		}
		else
		{
			$datos .= "N;";	
			$tipo_sensor = sObtener_Cadena_Tipo_Sensor($row['tiposensor']);	
			if (($row['evento_codigo']>511) && ($row['evento_codigo']<518))
				{
					/*if((substr($row['evento_tiposensor'],0,1) == 'C') || substr($row['evento_tiposensor'],1,1) == 'c')
					{
						
					}*/
					$conv=sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'G',1,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6));
				}
				else
				{
					$conv=sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',1,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6));
				}
		}
		list($valor,$unidades)=explode(" ",$conv);
		
		$datos .= $row['nodo_mac'].";".utf8_decode($row['nombre']).";";
		$datos .= utf8_decode(sObtener_Cadena_Tipo_Evento($row['evento_codigo'])).";".$row['texto'].";";
		//echo $row['evento_codigo']."<br>";
		$datos .= sObtener_Cadena_Numero_Sensor($row['evento_codigo']).";".utf8_decode($row['sensor_nombre']).";".utf8_decode($tipo_sensor).";";
		$fecha = sObtener_Fecha($cliente_db, $instalacion, $row['fecha'],$zona_horaria);
		//echo $fecha;
		$fecha_formateada = date_create_from_format('Y-m-d H:i:s',$fecha);
		$hora = date_format($fecha_formateada, 'H');
		$minuto = date_format($fecha_formateada, 'i');
		$segundo = date_format($fecha_formateada, 's');
		$dia = date_format($fecha_formateada, 'd');
		$mes = date_format($fecha_formateada, 'm');
		$anyo = date_format($fecha_formateada, 'Y');
		/*$hora = date('H',$fecha);
		$minuto = date('i',$fecha);
		$segundo = date('s',$fecha);
		$dia = date('d',$fecha);
		$mes = date('m',$fecha);
		$anyo = date('Y',$fecha);*/
		$datos .= $hora.";".$minuto.";".$segundo.";".$dia.";".$mes.";".$anyo.";".$row['valor'].";";
		$datos .= str_replace(".",",",$valor).";".$unidades.";\r\n";
	}
	header('Content-Type: application/x-octet-stream');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.date('D, d M Y H:i:s'));
	header('Content-Disposition: attachment; filename='.$idiomas[$_SESSION['opcion_idioma']]['general124'].'_'. date('Ymd')  .'.csv');
	header("Content-Length: ".strlen($datos));
	echo $datos;
	mysql_free_result($result);
}
mysql_close($link);
?>
