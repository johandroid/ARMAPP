<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';

//require_once('FirePHPCore/FirePHP.class.php'); 

//ob_start();

//$mifirePHP = FirePHP::getInstance(true);	

$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

$gw_id = $_GET["gw_id"];
$ipnodo = $_GET["nodo_ip"];
$utc_id = $_GET["utc_id"];
$sensorGW = $_GET["GWSensor"];
$sensorNodo = $_GET["NodeSensor"];
$sensorUTC = $_GET["UTCSensor"];
$evento = $_GET["evento"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$ver_gw = $_GET["ver_gw"];
$ver_nodo = $_GET["ver_nodo"];
$ver_utc = $_GET["ver_utc"];

$pagina = $_GET["pagina"];

$num_filas_tabla=15;

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

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

$query = "";
if (($evento != "F") && (($ver_gw != 0) || ($ver_nodo != 0) || ($ver_utc != 0)))
{
	// Primero definimos la cadena WHERE para las querys
	$querynodo = "";
	$querygw = "";
	$queryutc = "";
	if ($ver_nodo == 1)
	{
		if($ipnodo!='F')
		{
			$querynodo .= " AND (((cliente_eventos.nodo_mac='".$ipnodo."') ";
		}
		else
		{
			$querynodo .= " AND ((((cliente_eventos.nodo_ip!='000') AND (cliente_eventos.nodo_ip!='001')) ";
		}
		switch ($evento)
		{
			case 12:
				$querynodo .= " AND ((cliente_eventos.evento_codigo>'199') && (cliente_eventos.evento_codigo<'300'))";
				break;
				
			// Si piden cobertura GPRS, no mostraremos nada en nodo (si ponemos el evento de gprs no se mostrara nada)
			case 4:
				$querynodo .= " AND (cliente_eventos.evento_codigo='807')";
				break;
				
			// Si piden cobertura, solo mostraremos eventos de cobertura
			case 2:
				$querynodo .= " AND (cliente_eventos.evento_codigo='800')";
				break;
				
			// Si piden alimentacion, solo bateria de nodo
			case 3:
				$querynodo .= " AND (cliente_eventos.evento_codigo='801')";
				break;
				
			// Si piden umbrales
			case 5:
				switch ($sensorNodo)
				{
					case "1":
						$querynodo .= " AND (cliente_eventos.evento_codigo='506')";
						break;
					case "2":
						$querynodo .= " AND (cliente_eventos.evento_codigo='507')";
						break;
					case "3":
						$querynodo .= " AND (cliente_eventos.evento_codigo='508')";
						break;
					case "4":
						$querynodo .= " AND (cliente_eventos.evento_codigo='509')";
						break;
					case "5":
						$querynodo .= " AND (cliente_eventos.evento_codigo='510')";
						break;
					case "6":
						$querynodo .= " AND (cliente_eventos.evento_codigo='511')";
						break;
					default:
						$querynodo .= " AND ((cliente_eventos.evento_codigo>'505') AND (cliente_eventos.evento_codigo<'512'))";
						break;							
				}
				break;
	
			// Si piden gradientes
			case 6:
				switch ($sensorNodo)
				{
					case "1":
						$querynodo .= " AND (cliente_eventos.evento_codigo='512')";
						break;
					case "2":
						$querynodo .= " AND (cliente_eventos.evento_codigo='513')";
						break;
					case "3":
						$querynodo .= " AND (cliente_eventos.evento_codigo='514')";
						break;
					case "4":
						$querynodo .= " AND (cliente_eventos.evento_codigo='515')";
						break;
					case "5":
						$querynodo .= " AND (cliente_eventos.evento_codigo='516')";
						break;
					case "6":
						$querynodo .= " AND (cliente_eventos.evento_codigo='517')";
						break;
					default:
						$querynodo .= " AND ((cliente_eventos.evento_codigo>'511') AND (cliente_eventos.evento_codigo<'518'))";
						break;							
				}						
				break;
				
			// Si piden datos, mostraremos solo eventos de datos
			case 1:
				switch ($sensorNodo)
				{
					case "1":
						$querynodo .= " AND (cliente_eventos.evento_codigo='500')";
						break;
					case "2":
						$querynodo .= " AND (cliente_eventos.evento_codigo='501')";
						break;
					case "3":
						$querynodo .= " AND (cliente_eventos.evento_codigo='502')";
						break;
					case "4":
						$querynodo .= " AND (cliente_eventos.evento_codigo='503')";
						break;
					case "5":
						$querynodo .= " AND (cliente_eventos.evento_codigo='504')";
						break;
					case "6":
						$querynodo .= " AND (cliente_eventos.evento_codigo='505')";
						break;
					default:
						$querynodo .= " AND ((cliente_eventos.evento_codigo>'499') AND (cliente_eventos.evento_codigo<'506'))";
						break;							
				}
				break;
			
			default:
				switch ($sensorNodo)
				{
					case "1":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='500') OR (cliente_eventos.evento_codigo='506') OR (cliente_eventos.evento_codigo='512')";
						break;
					case "2":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='501') OR (cliente_eventos.evento_codigo='507') OR (cliente_eventos.evento_codigo='513')";
						break;
					case "3":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='502') OR (cliente_eventos.evento_codigo='508') OR (cliente_eventos.evento_codigo='514')";
						break;
					case "4":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='503') OR (cliente_eventos.evento_codigo='509') OR (cliente_eventos.evento_codigo='515')";
						break;
					case "5":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='504') OR (cliente_eventos.evento_codigo='510') OR (cliente_eventos.evento_codigo='516')";
						break;
					case "6":
						$querynodo .= " AND ((cliente_eventos.evento_codigo='505') OR (cliente_eventos.evento_codigo='511') OR (cliente_eventos.evento_codigo='517')";
						break;
					default:
						$querynodo .= " AND (((cliente_eventos.evento_codigo>499) AND (cliente_eventos.evento_codigo<518))";
						break;							
				}
				$querynodo .= " OR (cliente_eventos.evento_codigo='801') OR (cliente_eventos.evento_codigo='800'))";
				break;
		}
		$queryaux .= $querynodo.")";
	}
	//echo $querynodo.'<br/>';
	//$queryaux .= " AND (";
	if ($ver_gw == 1)
	{
		if ($ver_nodo == 1)
		{
			if ($gw_id!='000')
			{
				$queryaux .= " OR (cliente_eventos.gw_id='".$gw_id."' AND ((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001')) AND";
			}
			else 
			{
				$querygw .= " OR (((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001')) AND ";
			}
		}
		else 
		{
			if ($gw_id!='000')
			{
				$queryaux .= " AND (((cliente_eventos.gw_id='".$gw_id."') AND ";
			}
			else 
			{
				$querygw .= " AND ((";
			}
			if ($ipnodo != 'XXX')
			{
				$querygw .= "((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001')) AND";
			}
		}
		
		switch ($evento)
		{
			// Si es salida de Telemando
			case 12:
				$querygw .= " ((cliente_eventos.evento_codigo>'199') && (cliente_eventos.evento_codigo<'300'))";
				break;
				
			// Si piden cobertura GPRS, solo mostraremos eventos de cobertura
			case 4:
				$querygw .= " (cliente_eventos.evento_codigo='807')";
				break;
				
			// Si piden cobertura, solo mostraremos eventos de cobertura
			case 2:
				$querygw .= " (cliente_eventos.evento_codigo='800')";
				break;
				
			// Si piden alimentacion, solo bateria y 220
			case 3:
				$querygw .= " ((cliente_eventos.evento_codigo='805') OR (cliente_eventos.evento_codigo='806'))";
				break;
				
			// Si piden umbrales
			case 5:
				switch ($sensorGW)
				{
					case "1":
						$querygw .= " ((cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650'))";
						break;
					case "2":
						$querygw .= " ((cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651'))";
						break;
					case "3":
						$querygw .= " ((cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652'))";
						break;
					case "4":
						$querygw .= " ((cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653'))";
						break;
					case "5":
						$querygw .= " ((cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654'))";
						break;
					case "6":
						$querygw .= " ((cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655'))";
						break;
					case "7":
						$querygw .= " ((cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656'))";
						break;
					case "8":
						$querygw .= " ((cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657'))";
						break;
					case "9":
						$querygw .= " ((cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658'))";
						break;
					case "10":
						$querygw .= " ((cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659'))";
						break;
					case "11":
						$querygw .= " ((cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660'))";
						break;
					case "12":
						$querygw .= " ((cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661'))";
						break;
					case "13":
						$querygw .= " ((cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662'))";
						break;
					case "14":
						$querygw .= " ((cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663'))";
						break;
					case "15":
						$querygw .= " ((cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664'))";
						break;
					case "16":
						$querygw .= " ((cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665'))";
						break;
					case "17":
						$querygw .= " ((cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666'))";
						break;
					case "18":
						$querygw .= " ((cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667'))";
						break;	
					case "19":
						$querygw .= " ((cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668'))";
						break;
					case "20":
						$querygw .= " ((cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669'))";
						break;
					case "21":
						$querygw .= " ((cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670'))";
						break;
					case "22":
						$querygw .= " ((cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671'))";
						break;
					case "23":
						$querygw .= " ((cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672'))";
						break;							
					default:
						$querygw .= " ((cliente_eventos.evento_codigo>'624') AND (cliente_eventos.evento_codigo<'673'))";
						break;							
				}						
				break;
	
			// Si piden gradientes
			case 6:
				switch ($sensorGW)
				{
					case "1":
						$querygw .= " ((cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700') OR (cliente_eventos.evento_codigo='725'))";
						break;
					case "2":
						$querygw .= " ((cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701') OR (cliente_eventos.evento_codigo='726'))";
						break;
					case "3":
						$querygw .= " ((cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702') OR (cliente_eventos.evento_codigo='727'))";
						break;
					case "4":
						$querygw .= " ((cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703') OR (cliente_eventos.evento_codigo='728'))";
						break;
					case "5":
						$querygw .= " ((cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704') OR (cliente_eventos.evento_codigo='729'))";
						break;
					case "6":
						$querygw .= " ((cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705') OR (cliente_eventos.evento_codigo='730'))";
						break;
					case "7":
						$querygw .= " ((cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706') OR (cliente_eventos.evento_codigo='731'))";
						break;
					case "8":
						$querygw .= " ((cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707') OR (cliente_eventos.evento_codigo='732'))";
						break;
					case "9":
						$querygw .= " ((cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708') OR (cliente_eventos.evento_codigo='733'))";
						break;
					case "10":
						$querygw .= " ((cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709') OR (cliente_eventos.evento_codigo='734'))";
						break;
					case "11":
						$querygw .= " ((cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710') OR (cliente_eventos.evento_codigo='735'))";
						break;
					case "12":
						$querygw .= " ((cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711') OR (cliente_eventos.evento_codigo='736'))";
						break;
					case "13":
						$querygw .= " ((cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712') OR (cliente_eventos.evento_codigo='737'))";
						break;
					case "14":
						$querygw .= " ((cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713') OR (cliente_eventos.evento_codigo='738'))";
						break;
					case "15":
						$querygw .= " ((cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714') OR (cliente_eventos.evento_codigo='739'))";
						break;
					case "16":
						$querygw .= " ((cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715') OR (cliente_eventos.evento_codigo='740'))";
						break;
					case "17":
						$querygw .= " ((cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716') OR (cliente_eventos.evento_codigo='741'))";
						break;
					case "18":
						$querygw .= " ((cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717') OR (cliente_eventos.evento_codigo='742'))";
						break;			
					case "19":
						$querygw .= " ((cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718') OR (cliente_eventos.evento_codigo='743'))";
						break;
					case "20":
						$querygw .= " ((cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719') OR (cliente_eventos.evento_codigo='744'))";
						break;
					case "21":
						$querygw .= " ((cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720') OR (cliente_eventos.evento_codigo='745'))";
						break;
					case "22":
						$querygw .= " ((cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721') OR (cliente_eventos.evento_codigo='746'))";
						break;
					case "23":
						$querygw .= " ((cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722') OR (cliente_eventos.evento_codigo='747'))";
						break;													
					default:
						$querygw .= " ((cliente_eventos.evento_codigo>'674') AND (cliente_eventos.evento_codigo<'748'))";
						break;						
				}						
				break;
				
			// Si piden datos, mostraremos solo eventos de datos
			case 1:
				switch ($sensorGW)
				{
					case "1":
						$querygw .= " (cliente_eventos.evento_codigo='600')";
						break;
					case "2":
						$querygw .= " (cliente_eventos.evento_codigo='601')";
						break;
					case "3":
						$querygw .= " (cliente_eventos.evento_codigo='602')";
						break;
					case "4":
						$querygw .= " (cliente_eventos.evento_codigo='603')";
						break;
					case "5":
						$querygw .= " (cliente_eventos.evento_codigo='604')";
						break;
					case "6":
						$querygw .= " (cliente_eventos.evento_codigo='605')";
						break;
					case "7":
						$querygw .= " (cliente_eventos.evento_codigo='606')";
						break;
					case "8":
						$querygw .= " (cliente_eventos.evento_codigo='607')";
						break;
					case "9":
						$querygw .= " (cliente_eventos.evento_codigo='608')";
						break;
					case "10":
						$querygw .= " (cliente_eventos.evento_codigo='609')";
						break;
					case "11":
						$querygw .= " (cliente_eventos.evento_codigo='610')";
						break;
					case "12":
						$querygw .= " (cliente_eventos.evento_codigo='611')";
						break;
					case "13":
						$querygw .= " (cliente_eventos.evento_codigo='612')";
						break;
					case "14":
						$querygw .= " (cliente_eventos.evento_codigo='613')";
						break;
					case "15":
						$querygw .= " (cliente_eventos.evento_codigo='614')";
						break;
					case "16":
						$querygw .= " (cliente_eventos.evento_codigo='615')";
						break;
					case "17":
						$querygw .= " (cliente_eventos.evento_codigo='616')";
						break;
					case "18":
						$querygw .= " (cliente_eventos.evento_codigo='617')";
						break;
					case "19":
						$querygw .= " (cliente_eventos.evento_codigo='618')";
						break;
					case "20":
						$querygw .= " (cliente_eventos.evento_codigo='619')";
						break;
					case "21":
						$querygw .= " (cliente_eventos.evento_codigo='620')";
						break;
					case "22":
						$querygw .= " (cliente_eventos.evento_codigo='621')";
						break;	
					case "23":
						$querygw .= " (cliente_eventos.evento_codigo='622')";
						break;																								
					default:
						$querygw .= " ((cliente_eventos.evento_codigo>599) AND (cliente_eventos.evento_codigo<623))";
						break;							
				}
				break;
			
				// Si piden todos los eventos
			default:
				switch ($sensorGW)
				{
					case "1":
						$querygw .= " ((cliente_eventos.evento_codigo='600') OR (cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650') OR (cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700') OR (cliente_eventos.evento_codigo='725')";
						break;
					case "2":
						$querygw .= " ((cliente_eventos.evento_codigo='601') OR (cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651') OR (cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701') OR (cliente_eventos.evento_codigo='726')";
						break;
					case "3":
						$querygw .= " ((cliente_eventos.evento_codigo='602') OR (cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652') OR (cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702') OR (cliente_eventos.evento_codigo='727')";
						break;
					case "4":
						$querygw .= " ((cliente_eventos.evento_codigo='603') OR (cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653') OR (cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703') OR (cliente_eventos.evento_codigo='728')";
						break;
					case "5":
						$querygw .= " ((cliente_eventos.evento_codigo='604') OR (cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654') OR (cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704') OR (cliente_eventos.evento_codigo='729')";
						break;
					case "6":
						$querygw .= " ((cliente_eventos.evento_codigo='605') OR (cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655') OR (cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705') OR (cliente_eventos.evento_codigo='730')";
						break;
					case "7":
						$querygw .= " ((cliente_eventos.evento_codigo='606') OR (cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656') OR (cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706') OR (cliente_eventos.evento_codigo='731')";
						break;
					case "8":
						$querygw .= " ((cliente_eventos.evento_codigo='607') OR (cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657') OR (cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707') OR (cliente_eventos.evento_codigo='732')";
						break;
					case "9":
						$querygw .= " ((cliente_eventos.evento_codigo='608') OR (cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658') OR (cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708') OR (cliente_eventos.evento_codigo='733')";
						break;
					case "10":
						$querygw .= " ((cliente_eventos.evento_codigo='609') OR (cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659') OR (cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709') OR (cliente_eventos.evento_codigo='734')";
						break;
					case "11":
						$querygw .= " ((cliente_eventos.evento_codigo='610') OR (cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660') OR (cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710') OR (cliente_eventos.evento_codigo='735')";
						break;
					case "12":
						$querygw .= " ((cliente_eventos.evento_codigo='611') OR (cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661') OR (cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711') OR (cliente_eventos.evento_codigo='736')";
						break;
					case "13":
						$querygw .= " ((cliente_eventos.evento_codigo='612') OR (cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662') OR (cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712') OR (cliente_eventos.evento_codigo='737')";
						break;
					case "14":
						$querygw .= " ((cliente_eventos.evento_codigo='613') OR (cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663') OR (cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713') OR (cliente_eventos.evento_codigo='738')";
						break;
					case "15":
						$querygw .= " ((cliente_eventos.evento_codigo='614') OR (cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664') OR (cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714') OR (cliente_eventos.evento_codigo='739')";
						break;
					case "16":
						$querygw .= " ((cliente_eventos.evento_codigo='615') OR (cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665') OR (cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715') OR (cliente_eventos.evento_codigo='740')";
						break;
					case "17":
						$querygw .= " ((cliente_eventos.evento_codigo='616') OR (cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666') OR (cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716') OR (cliente_eventos.evento_codigo='741')";
						break;
					case "18":
						$querygw .= " ((cliente_eventos.evento_codigo='617') OR (cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667') OR (cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717') OR (cliente_eventos.evento_codigo='742')";
						break;
					case "19":
						$querygw .= " ((cliente_eventos.evento_codigo='618') OR (cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668') OR (cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718') OR (cliente_eventos.evento_codigo='743')";
						break;
					case "20":
						$querygw .= " ((cliente_eventos.evento_codigo='619') OR (cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669') OR (cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719') OR (cliente_eventos.evento_codigo='744')";
						break;
					case "21":
						$querygw .= " ((cliente_eventos.evento_codigo='620') OR (cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670') OR (cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720') OR (cliente_eventos.evento_codigo='745')";
						break;
					case "22":
						$querygw .= " ((cliente_eventos.evento_codigo='621') OR (cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671') OR (cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721') OR (cliente_eventos.evento_codigo='746')";
						break;
					case "23":
						$querygw .= " ((cliente_eventos.evento_codigo='622') OR (cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672') OR (cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722') OR (cliente_eventos.evento_codigo='747')";
						break;																
					default:
						$querygw .= " (((cliente_eventos.evento_codigo>'599') AND (cliente_eventos.evento_codigo<'748'))";
						break;													
				}
				$querygw .= " OR (cliente_eventos.evento_codigo='805') OR (cliente_eventos.evento_codigo='806') OR (cliente_eventos.evento_codigo='807'))";
				break;
		}
		$queryaux .= $querygw.")";
	}
	//echo $querygw.'<br/>';
	if ($ver_utc == 1)
	{
		if (($ver_nodo == 1) || ($ver_gw == 1))
		{
			if($utc_id!='0000')
				$queryutc .= " OR ((cliente_eventos.nodo_mac='".$utc_id."') ";
			else
				$queryutc .= " OR (((cliente_eventos.nodo_ip!='000') AND (cliente_eventos.nodo_ip!='001')) ";
		}
		else 
		{
			if($utc_id!='0000')
				$queryutc .= " AND (((cliente_eventos.nodo_mac='".$utc_id."') ";
			else
				$queryutc .= " AND ((((cliente_eventos.nodo_ip!='000') AND (cliente_eventos.nodo_ip!='001')) ";
		}
		switch ($evento)
		{
			// Si es salida de Telemando
			case 12:
				$queryutc .= " AND ((cliente_eventos.evento_codigo>'199') && (cliente_eventos.evento_codigo<'300'))";
				break;
			// Si piden cobertura GPRS, solo mostraremos eventos de cobertura
			case 4:
				$queryutc .= " AND (cliente_eventos.evento_codigo='807')";
				break;
				
			// Si piden cobertura, solo mostraremos eventos de cobertura
			case 2:
				//No hay cobertura en UTC
				$queryutc .= " AND (cliente_eventos.evento_codigo='000')";
				break;
				
			// Si piden alimentacion, solo bateria y 220
			case 3:
				//No hay alimentacion en UTC
				//$queryutc .= " AND ((cliente_eventos.evento_codigo='805') OR (cliente_eventos.evento_codigo='806') OR (cliente_eventos.evento_codigo='801'))";
				$queryutc .= " AND (cliente_eventos.evento_codigo='000')";
				break;
				
			// Si piden umbrales
			case 5:
				//Por ahora no hay umbrales en UTC
				$queryutc .= " AND (cliente_eventos.evento_codigo='000')";
				break;
	
			// Si piden gradientes
			case 6:
				$queryutc .= " AND (cliente_eventos.evento_codigo='000')";
				break;
				
			// Si piden datos, mostraremos solo eventos de datos o general solo tenemos datos para mostrar
			default:
			case 1:
				if ($sensorUTC!='F')
				{
					$numsensorUTC = 300 + $sensorUTC;	
					$queryutc .= " AND cliente_eventos.evento_codigo='".$numsensorUTC."' ";	
				}
				else 
				{
					if ($_SESSION['perfil']< 3)
					{
						$queryutc .= " AND ((cliente_eventos.evento_codigo>299) AND (cliente_eventos.evento_codigo<400))";
					}
					else 
					{
						$queryutc .= " AND ((cliente_eventos.evento_codigo>299) AND (cliente_eventos.evento_codigo<400) AND (evento_tiposensor<'620' OR evento_tiposensor>='650'))";
					}
				}
				break;
		}
		$queryaux .= $queryutc.")";
	}
	//$queryaux .= " AND (cliente_eventos.evento_codigo>'020'))";
	$queryaux .= ")";

	if ($fecha_begin != "0")
	{
		$queryaux .= " AND evento_fecha>='".$fecha_begin."'";
	}
	if ($fecha_end != "0")
	{
		$queryaux .= " AND evento_fecha<='".$fecha_end."'";
	}
	//echo '__'.$queryaux.'<br/>';

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
	
	$query_final = "select * from (";
	$query2 = "select count(*) from (";
	$i=0;	
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
	$mes_actual=$mes_end;
	$anyo_actual=$anyo_end;
	
	$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_actual);
	$cadena_actual=$cadena_inicial;

	$count_total = 0;
	$count_mostrar = 0;
	$query_total = '';
	$offset = ($pagina - 1)*$num_filas_tabla;
	
	while($cadena_actual!='FIN')
	{
		$NombreTabla = "cliente_eventos_".$cadena_actual;
		//echo $NombreTabla;
		//echo table_exists($NombreTabla, $link);
		if (table_exists($NombreTabla, $link))
		{
		    $query_basica_count = sprintf("SELECT COUNT(*) FROM %s as cliente_eventos right join cliente_gateways  on (cliente_gateways.gw_id = cliente_eventos.gw_id) WHERE (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s') %s", $NombreTabla, $instalacion, $queryaux);
		    $query_basica = sprintf("(SELECT cliente_eventos.evento_id, cliente_eventos.gw_id, cliente_eventos.instalacion_id, cliente_eventos.nodo_ip,cliente_eventos.nodo_mac, cliente_eventos.evento_codigo, cliente_eventos.evento_valor_raw, cliente_eventos.evento_tiposensor, cliente_eventos.evento_fecha  FROM %s as cliente_eventos right join cliente_gateways  on (cliente_gateways.gw_id = cliente_eventos.gw_id) WHERE (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s') %s ORDER BY evento_fecha DESC", $NombreTabla, $instalacion, $queryaux);
		    //echo $query_basica_count.'<br/>';
		    //echo 'offset='.$offset.'<br/>';
		    $result = mysql_query($query_basica_count,$link);
		    if ($result)
		    {
			    if($row = mysql_fetch_array($result))
			    {
				    $count_parcial = $row[0];
				    $count_total += $count_parcial;
				    //echo $NombreTabla.' => '.$count_total.'+='.$count_parcial.'<br/>';
				    if($count_parcial>0)
					{
					    if ($count_mostrar == 0)
					    {
						  //echo 'if1<br/>';
						  if ($count_total >= $offset)
						  {
							//echo 'if2<br/>';
							$query_total .= $query_basica . ' LIMIT '.($offset-($count_total-$count_parcial)).',15)';
							$count_mostrar += $count_total - $offset;
						  }
					    }
					    else if ($count_mostrar < 15)
					    {
						 // echo 'else1<br/>';
						  $query_total .= " UNION ".$query_basica." LIMIT 0,15)";
						  $count_mostrar += $count_parcial;
					    }
				    }
				    //echo 'mostrar '.$count_mostrar.'<br/>';
			    }
			    mysql_free_result($result);
		    }
		}

		if ($anyo_actual>$anyo_begin)
		{
			//echo 'ActualY='.$anyo_actual.' ENDY='.$anyo_begin.'<br>';
			if ($mes_actual>1)
			{
				$mes_actual--;
			}
			else
			{
				$mes_actual=12;
				$anyo_actual--;
			}
			$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
			//echo $cadena_actual.'<br>';
		}
		else if ($anyo_actual==$anyo_begin)
		{
			//echo 'ActualM='.$mes_actual.' ENDM='.$mes_begin.'<br>';
			if ($mes_actual>$mes_begin)
			{
				$mes_actual--;
				$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
			}
			else
			{
				$cadena_actual='FIN';
			}
			//echo $cadena_actual.'<br>';
		}
	}
	//echo '__?__'.$query_total;
	$query_final = sprintf("select cliente_eventos1.evento_id as evento, cliente_eventos1.gw_id AS gw_id,
								   cliente_eventos1.instalacion_id as instalacion_id,
								   cliente_eventos1.nodo_ip AS nodo_ip,
								   cliente_gateways.gw_tipo,   
								   IF (((cliente_eventos1.nodo_ip = '000') OR (cliente_eventos1.nodo_ip = '001')), '000',cliente_eventos1.nodo_mac) AS nodo_mac,
								   IF (((cliente_eventos1.nodo_ip = '000') OR (cliente_eventos1.nodo_ip = '001')),
								   		cliente_gateways.gw_nombre,
								  		IF(((cliente_eventos1.evento_codigo > 299) AND (cliente_eventos1.evento_codigo<400)),
								   		cliente_analizadores.analizador_nombre,cliente_params_nodo.nodo_nombre)) AS nombre,
								   cliente_eventos1.evento_codigo AS evento_codigo,
								   %s.rfreenet_texto_eventos_%s.evento_texto AS texto,
								   cliente_eventos1.evento_valor_raw AS valor,
								   cliente_eventos1.evento_tiposensor as tiposensor, 
								   unix_timestamp(cliente_eventos1.evento_fecha) AS fecha, 
								   IF(((cliente_eventos1.evento_codigo > 299) AND (cliente_eventos1.evento_codigo<400)),
								   rfreenet_modbus_conversion.modbus_operacion,0) as modbus_operacion,
								   IF(((cliente_eventos1.evento_codigo > 299) AND (cliente_eventos1.evento_codigo<400)),
								   rfreenet_modbus_conversion.modbus_operando,0) as modbus_operando,
								   (CASE cliente_eventos1.evento_codigo WHEN '500' THEN nodo_aux_operacion1 WHEN '506' THEN nodo_aux_operacion1 WHEN '512' THEN nodo_aux_operacion1 WHEN '501' THEN nodo_aux_operacion2 WHEN '507' THEN nodo_aux_operacion2 WHEN '513' THEN nodo_aux_operacion3 WHEN '502' THEN nodo_aux_operacion3 WHEN '508' THEN nodo_aux_operacion3 WHEN '514' THEN nodo_aux_operacion3 WHEN '503' THEN nodo_aux_operacion4 WHEN  '509' THEN nodo_aux_operacion4 WHEN '515' THEN nodo_aux_operacion4 WHEN '504' THEN nodo_aux_operacion5 WHEN '510' THEN nodo_aux_operacion5 WHEN '516' THEN nodo_aux_operacion5 WHEN '505' THEN nodo_aux_operacion6 WHEN '511' THEN nodo_aux_operacion6 WHEN '517' THEN nodo_aux_operacion6 ELSE '-' END) AS operacion,(CASE cliente_eventos1.evento_codigo WHEN '500' THEN nodo_aux_constante1 WHEN '506' THEN nodo_aux_constante1 WHEN '512' THEN nodo_aux_constante1 WHEN '501' THEN nodo_aux_constante2 WHEN '507' THEN nodo_aux_constante2 WHEN '513' THEN nodo_aux_constante2 WHEN '502' THEN nodo_aux_constante3 WHEN '508' THEN nodo_aux_constante3 WHEN '514' THEN nodo_aux_constante3 WHEN '503' THEN nodo_aux_constante4 WHEN  '509' THEN nodo_aux_constante4 WHEN '515' THEN nodo_aux_constante4 WHEN '504' THEN nodo_aux_constante5 WHEN '510' THEN nodo_aux_constante5 WHEN '516' THEN nodo_aux_constante5 WHEN '505' THEN nodo_aux_constante6 WHEN '511' THEN nodo_aux_constante6 WHEN '517' THEN nodo_aux_constante6 ELSE '-' END) AS constante 
							   from %s.rfreenet_modbus_conversion right join (cliente_analizadores right join 
							   		(cliente_gateways inner join 
							   	    (cliente_params_gw right join (cliente_params_nodo right join ((%s) as cliente_eventos1) on 
							   	    ((cliente_eventos1.nodo_mac = cliente_params_nodo.nodo_mac) AND 
							   	    (cliente_eventos1.gw_id = cliente_params_nodo.gw_id))) on 
							   	    (cliente_params_gw.gw_id = cliente_eventos1.gw_id)) on
							   	    (cliente_gateways.gw_id = cliente_eventos1.gw_id)) on 
							   	    (cliente_eventos1.nodo_mac=cliente_analizadores.analizador_id AND 
							   	    cliente_eventos1.evento_codigo>299 AND cliente_eventos1.evento_codigo<400)) on 
							   	    (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND 
							   	    rfreenet_modbus_conversion.modbus_evento=cliente_eventos1.evento_codigo) 
									left join %s.rfreenet_texto_eventos_%s on 
							   	    (cliente_eventos1.evento_codigo = %s.rfreenet_texto_eventos_%s.evento_codigo
									AND (%s.rfreenet_texto_eventos_%s.evento_tipo = cliente_gateways.gw_tipo OR
                                         %s.rfreenet_texto_eventos_%s.evento_tipo = -1))
							   ORDER BY fecha DESC,evento LIMIT 15", $db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $query_total, $db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma']);

	//echo $query_final;

	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
		
	if ($result)
	{
		$num_total_filas= $count_total;
		//echo pad_izquierda($num_total_filas,15,'0').'<br>';
		echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
	}
	else
	{
		$num_total_filas= $num_filas_tabla;
		echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
		$result = false;
	}
}
else
{
	$num_total_filas= $num_filas_tabla;
	echo pad_izquierda(ceil($num_total_filas/$num_filas_tabla),8,'0');
	$result = false;
}

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

if(!$result)
{
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
}
else
{
	if (mysql_num_rows($result)==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"5\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"5\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"5\"><br/></td></tr>";
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
			
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".sObtener_Fecha($cliente_db, $instalacion, $row['fecha'],$zona_horaria)."</td>";
			
			//Si es un analizador se hace distinto
			if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
			{
				$numero_magnitud = "";
				if(substr($row['tiposensor'],2,1) != '0')
				{
					$numero_magnitud = substr($row['tiposensor'],2,1);
				}
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1))."</td>";
			}
			else
			{
				if (($row['gw_tipo'] == $tipo_gw) or ($row['gw_tipo'] == $tipo_gw_lowT))
				{
					echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".utf8_encode($row['texto'])."</td>";	
				}
				else if ($row['gw_tipo'] == $tipo_gw_low)
				{
					$sensor = "";
					//AMB 02/04/2012 Vamos a analizar a que intervalo pertenece el código de evento recibido, para saber si es un sensor analógico o digital
					if(($row['evento_codigo'] >= 603 && $row['evento_codigo'] <= 606) || //ANALÓGICO
					   ($row['evento_codigo'] >= 628 && $row['evento_codigo'] <= 631) ||
					   ($row['evento_codigo'] >= 653 && $row['evento_codigo'] <= 656) ||
					   ($row['evento_codigo'] >= 678 && $row['evento_codigo'] <= 681) ||
					   ($row['evento_codigo'] >= 703 && $row['evento_codigo'] <= 706) ||
					   ($row['evento_codigo'] >= 728 && $row['evento_codigo'] <= 731))
					{
						$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type4']." A".($row['evento_codigo']%25-2).")";
						//$mifirePHP -> log($sensor);
					}				
					else if(($row['evento_codigo'] >= 600 && $row['evento_codigo'] <= 602) || //4-20mA
					   ($row['evento_codigo'] >= 625 && $row['evento_codigo'] <= 627) ||
					   ($row['evento_codigo'] >= 650 && $row['evento_codigo'] <= 652) ||
					   ($row['evento_codigo'] >= 675 && $row['evento_codigo'] <= 677) ||
					   ($row['evento_codigo'] >= 700 && $row['evento_codigo'] <= 702) ||
					   ($row['evento_codigo'] >= 725 && $row['evento_codigo'] <= 727))
					{
						$sensor = " (0..10V/4-20mA S".($row['evento_codigo']%25+1).")";
						//$mifirePHP -> log($sensor);
					}
					else if(($row['evento_codigo'] >= 607 && $row['evento_codigo'] <= 608) || //PULSOS
					   ($row['evento_codigo'] >= 632 && $row['evento_codigo'] <= 633) ||
					   ($row['evento_codigo'] >= 657 && $row['evento_codigo'] <= 658) ||
					   ($row['evento_codigo'] >= 682 && $row['evento_codigo'] <= 683) ||
					   ($row['evento_codigo'] >= 707 && $row['evento_codigo'] <= 708) ||
					   ($row['evento_codigo'] >= 732 && $row['evento_codigo'] <= 733))
					{				
						$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." P".($row['evento_codigo']%25-6).")";
						//$mifirePHP -> log("SENSOR---->".$sensor);						
					}
					else if(($row['evento_codigo'] >= 619 && $row['evento_codigo'] <= 622) || //DIGITAL
					   ($row['evento_codigo'] >= 644 && $row['evento_codigo'] <= 647) ||
					   ($row['evento_codigo'] >= 669 && $row['evento_codigo'] <= 672) ||
					   ($row['evento_codigo'] >= 694 && $row['evento_codigo'] <= 697) ||
					   ($row['evento_codigo'] >= 719 && $row['evento_codigo'] <= 722) ||
					   ($row['evento_codigo'] >= 744 && $row['evento_codigo'] <= 747))
					{				
						$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." D".($row['evento_codigo']%25-18).")";
						//$mifirePHP -> log("SENSOR---->".$sensor);						
					}
					echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".utf8_encode($row['texto']).$sensor."</td>";				
				}
			}		
			if ($row['nombre']=='')
			{
				// si es un gateway
				if (($row['nodo_ip'] === "000") || ($row['nodo_ip'] === "001"))
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."</td>";
				}
				// Si es un analizador
				else if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general255']." ".$row['nodo_ip']."</td>";
				}		
				else 
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac']."</td>";	
				}
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".utf8_encode($row['nombre'])."</td>";
			}		
			// si es un gateway
			if (($row['nodo_ip'] === "000") || ($row['nodo_ip'] === "001"))
			{
				// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
				$array_versiones = sObtener_Versiones_GW($row['gw_id'], $cliente_db);
				$caGWVersionHW = $array_versiones[0];
				echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".sConvertir_Datos_GW(hexdec($row['valor']), $row['tiposensor'], 0, $row['gw_id'], (intval($row['evento_codigo'])%25), 1, $caGWVersionHW)."</td>";
			}
			else if ((($row['evento_codigo']>199) && ($row['evento_codigo']<300)) || ($row['evento_codigo']>399))
			{
				// Si es un gradiente, la conversion es diferente
				if (($row['evento_codigo']>511) && ($row['evento_codigo']<518))
				{
					echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'G',1,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6))."</td>";
				}
				else
				{
					echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".sConvertir_Datos_Nodo(hexdec($row['valor']), $row['tiposensor'],0,'D',1,$row['operacion'],$row['constante'], $row['gw_id'], $row['nodo_ip'], ((intval($row['evento_codigo'])-499)%6))."</td>";
				}
			}
			else
			{
				//print_r($row);
				//echo $row['valor']." ".$row['tiposensor']." ".$row['modbus_operacion']." ".$row['modbus_operando'];
				echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".sConvertir_Datos_UTC(hexdec($row['valor']), $row['tiposensor'],0,$row['modbus_operacion'],$row['modbus_operando'],1)."</td>";
			}
			echo "</tr>";
			$cuenta_filas++;
		}
	}

	while ($cuenta_filas < $num_filas_tabla)
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
//echo $query_final."<br>";
if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);
?>
