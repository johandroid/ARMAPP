<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';

$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

$gw_id = $_GET["gw_id"];
$ipnodo = $_GET["nodo_ip"];
$utc_id = $_GET["utc_id"];
$sensorGW = $_GET["GWSensor"];
$sensorNodo = $_GET["NodeSensor"];
$sensorUTC = $_GET["UTCSensor"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$ver_gw = $_GET["ver_gw"];
$ver_nodo = $_GET["ver_nodo"];
$ver_utc = $_GET["ver_utc"];

$pagina = isset($_GET["pagina"]) ? $_GET["pagina"]: 1;

$num_filas_tabla=13;

/*Se convierte la hora a la del servidor*/
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

/**/

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

$query = "";
if (($ver_gw != 0) || ($ver_nodo != 0) || ($ver_utc != 0))
{
	// Primero definimos la cadena WHERE para las querys
	$querynodo = "";
	$querygw = "";
	$queryutc = "";
	if ($ver_nodo == 1)
	{
		if($ipnodo!='F')
			$querynodo .= " AND (((cliente_eventos.nodo_mac='".$ipnodo."') ";
		else
			$querynodo .= " AND ((((cliente_eventos.nodo_ip!='000') AND (cliente_eventos.nodo_ip!='001')) ";
		
		// Solo gradientes o umbrales
		switch ($sensorNodo)
		{
			case "1":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='506') OR (cliente_eventos.evento_codigo='512'))";
				break;
			case "2":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='507') OR (cliente_eventos.evento_codigo='513'))";
				break;
			case "3":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='508') OR (cliente_eventos.evento_codigo='514'))";
				break;
			case "4":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='509') OR (cliente_eventos.evento_codigo='515'))";
				break;
			case "5":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='510') OR (cliente_eventos.evento_codigo='516'))";
				break;
			case "6":
				$querynodo .= " AND ((cliente_eventos.evento_codigo='511') OR (cliente_eventos.evento_codigo='517'))";
				break;
			default:
				$querynodo .= " AND (((cliente_eventos.evento_codigo>'505') AND (cliente_eventos.evento_codigo<'512')) OR ((cliente_eventos.evento_codigo>'511') AND (cliente_eventos.evento_codigo<'518')))";
				break;							
		}

		$queryaux .= $querynodo.")";
	}
	//$queryaux .= " AND (";
	if ($ver_gw == 1)
	{
		if ($ver_nodo == 1)
		{
			if ($gw_id!='000')
			{
				$queryaux .= " OR ((cliente_eventos.gw_id='".$gw_id."') AND ((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001'))";
			}
			else {
				$querygw .= " OR (((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001'))";
			}
		}
		else 
		{
			if ($gw_id!='000')
			{
				$queryaux .= " AND (((cliente_eventos.gw_id='".$gw_id."') AND ((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001'))";
			}
			else 
			{
				$querygw .= " AND ((((cliente_eventos.nodo_ip='000') OR (cliente_eventos.nodo_ip='001'))";
			}
			
		}
		
		// Solo umbrales o gradientes
		switch ($sensorGW)
		{
			case "1":
				$querygw .= " AND ((cliente_eventos.evento_codigo='625') OR (cliente_eventos.evento_codigo='650') OR (cliente_eventos.evento_codigo='675') OR (cliente_eventos.evento_codigo='700') OR (cliente_eventos.evento_codigo='725'))";
				break;
			case "2":
				$querygw .= " AND ((cliente_eventos.evento_codigo='626') OR (cliente_eventos.evento_codigo='651') OR (cliente_eventos.evento_codigo='676') OR (cliente_eventos.evento_codigo='701') OR (cliente_eventos.evento_codigo='726'))";
				break;
			case "3":
				$querygw .= " AND ((cliente_eventos.evento_codigo='627') OR (cliente_eventos.evento_codigo='652') OR (cliente_eventos.evento_codigo='677') OR (cliente_eventos.evento_codigo='702') OR (cliente_eventos.evento_codigo='727'))";
				break;
			case "4":
				$querygw .= " AND ((cliente_eventos.evento_codigo='628') OR (cliente_eventos.evento_codigo='653') OR (cliente_eventos.evento_codigo='678') OR (cliente_eventos.evento_codigo='703') OR (cliente_eventos.evento_codigo='728'))";
				break;
			case "5":
				$querygw .= " AND ((cliente_eventos.evento_codigo='629') OR (cliente_eventos.evento_codigo='654') OR (cliente_eventos.evento_codigo='679') OR (cliente_eventos.evento_codigo='704') OR (cliente_eventos.evento_codigo='729'))";
				break;
			case "6":
				$querygw .= " AND ((cliente_eventos.evento_codigo='630') OR (cliente_eventos.evento_codigo='655') OR (cliente_eventos.evento_codigo='680') OR (cliente_eventos.evento_codigo='705') OR (cliente_eventos.evento_codigo='730'))";
				break;
			case "7":
				$querygw .= " AND ((cliente_eventos.evento_codigo='631') OR (cliente_eventos.evento_codigo='656') OR (cliente_eventos.evento_codigo='681') OR (cliente_eventos.evento_codigo='706') OR (cliente_eventos.evento_codigo='731'))";
				break;
			case "8":
				$querygw .= " AND ((cliente_eventos.evento_codigo='632') OR (cliente_eventos.evento_codigo='657') OR (cliente_eventos.evento_codigo='682') OR (cliente_eventos.evento_codigo='707') OR (cliente_eventos.evento_codigo='732'))";
				break;
			case "9":
				$querygw .= " AND ((cliente_eventos.evento_codigo='633') OR (cliente_eventos.evento_codigo='658') OR (cliente_eventos.evento_codigo='683') OR (cliente_eventos.evento_codigo='708') OR (cliente_eventos.evento_codigo='733'))";
				break;
			case "10":
				$querygw .= " AND ((cliente_eventos.evento_codigo='634') OR (cliente_eventos.evento_codigo='659') OR (cliente_eventos.evento_codigo='684') OR (cliente_eventos.evento_codigo='709') OR (cliente_eventos.evento_codigo='734'))";
				break;
			case "11":
				$querygw .= " AND ((cliente_eventos.evento_codigo='635') OR (cliente_eventos.evento_codigo='660') OR (cliente_eventos.evento_codigo='685') OR (cliente_eventos.evento_codigo='710') OR (cliente_eventos.evento_codigo='735'))";
				break;
			case "12":
				$querygw .= " AND ((cliente_eventos.evento_codigo='636') OR (cliente_eventos.evento_codigo='661') OR (cliente_eventos.evento_codigo='686') OR (cliente_eventos.evento_codigo='711') OR (cliente_eventos.evento_codigo='736'))";
				break;
			case "13":
				$querygw .= " AND ((cliente_eventos.evento_codigo='637') OR (cliente_eventos.evento_codigo='662') OR (cliente_eventos.evento_codigo='687') OR (cliente_eventos.evento_codigo='712') OR (cliente_eventos.evento_codigo='737'))";
				break;
			case "14":
				$querygw .= " AND ((cliente_eventos.evento_codigo='638') OR (cliente_eventos.evento_codigo='663') OR (cliente_eventos.evento_codigo='688') OR (cliente_eventos.evento_codigo='713') OR (cliente_eventos.evento_codigo='738'))";
				break;
			case "15":
				$querygw .= " AND ((cliente_eventos.evento_codigo='639') OR (cliente_eventos.evento_codigo='664') OR (cliente_eventos.evento_codigo='689') OR (cliente_eventos.evento_codigo='714') OR (cliente_eventos.evento_codigo='739'))";
				break;
			case "16":
				$querygw .= " AND ((cliente_eventos.evento_codigo='640') OR (cliente_eventos.evento_codigo='665') OR (cliente_eventos.evento_codigo='690') OR (cliente_eventos.evento_codigo='715') OR (cliente_eventos.evento_codigo='740'))";
				break;
			case "17":
				$querygw .= " AND ((cliente_eventos.evento_codigo='641') OR (cliente_eventos.evento_codigo='666') OR (cliente_eventos.evento_codigo='691') OR (cliente_eventos.evento_codigo='716') OR (cliente_eventos.evento_codigo='741'))";
				break;
			case "18":
				$querygw .= " AND ((cliente_eventos.evento_codigo='642') OR (cliente_eventos.evento_codigo='667') OR (cliente_eventos.evento_codigo='692') OR (cliente_eventos.evento_codigo='717') OR (cliente_eventos.evento_codigo='742'))";
				break;	
			case "19":
				$querygw .= " AND ((cliente_eventos.evento_codigo='643') OR (cliente_eventos.evento_codigo='668') OR (cliente_eventos.evento_codigo='693') OR (cliente_eventos.evento_codigo='718') OR (cliente_eventos.evento_codigo='743'))";
				break;
			case "20":
				$querygw .= " AND ((cliente_eventos.evento_codigo='644') OR (cliente_eventos.evento_codigo='669') OR (cliente_eventos.evento_codigo='694') OR (cliente_eventos.evento_codigo='719') OR (cliente_eventos.evento_codigo='744'))";
				break;
			case "21":
				$querygw .= " AND ((cliente_eventos.evento_codigo='645') OR (cliente_eventos.evento_codigo='670') OR (cliente_eventos.evento_codigo='695') OR (cliente_eventos.evento_codigo='720') OR (cliente_eventos.evento_codigo='745'))";
				break;
			case "22":
				$querygw .= " AND ((cliente_eventos.evento_codigo='646') OR (cliente_eventos.evento_codigo='671') OR (cliente_eventos.evento_codigo='696') OR (cliente_eventos.evento_codigo='721') OR (cliente_eventos.evento_codigo='746'))";
				break;
			case "23":
				$querygw .= " AND ((cliente_eventos.evento_codigo='647') OR (cliente_eventos.evento_codigo='672') OR (cliente_eventos.evento_codigo='697') OR (cliente_eventos.evento_codigo='722') OR (cliente_eventos.evento_codigo='747'))";
				break;							
			default:
				$querygw .= "AND (((cliente_eventos.evento_codigo>'624') AND (cliente_eventos.evento_codigo<'673')) OR ((cliente_eventos.evento_codigo>'674') AND (cliente_eventos.evento_codigo<'748')))";
				break;							
		}						
		$queryaux .= $querygw.")";
	}
	
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
		
		// Si piden alarmas en UTC
		if($sensorUTC!='F')
		{
			$queryutc .= " AND (cliente_eventos.evento_codigo='".($sensorUTC+300)."')";
		}
		else
		{
			$queryutc .= " AND ((cliente_eventos.evento_codigo>299) AND (cliente_eventos.evento_codigo<400))";
		}
		
		$queryaux .= $queryutc.")";
	}
	$queryaux .= ")";

	if ($fecha_begin != "0")
	{
		$queryaux .= " AND alarma_fecha_recibida>='".$fecha_begin."'";
	}
	if ($fecha_end != "0")
	{
		$queryaux .= " AND alarma_fecha_recibida<='".$fecha_end."'";
	}
	//echo $queryaux.'<br/>';

      


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
//	echo $query_final."<br>";
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
		$NombreTabla = "cliente_alarmas_".$cadena_actual;
		if (table_exists($NombreTabla, $link))
		{
		    $query_basica_count = sprintf("SELECT COUNT(*) FROM %s as cliente_eventos right join cliente_gateways  on (cliente_gateways.gw_id = cliente_eventos.gw_id) WHERE (cliente_eventos.alarma_repuesta='0') AND (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s') %s", $NombreTabla, $instalacion, $queryaux);
		    $query_basica = sprintf("(SELECT cliente_eventos.gw_id,cliente_eventos.alarma_id,cliente_eventos.alarma_fecha_recibida,cliente_eventos.alarma_repuesta, cliente_eventos.alarma_fecha_repuesta, cliente_eventos.alarma_usuario_repuesta, cliente_eventos.instalacion_id, cliente_eventos.nodo_ip,cliente_eventos.nodo_mac, cliente_eventos.evento_codigo, cliente_eventos.evento_tiposensor FROM %s as cliente_eventos right join cliente_gateways  on (cliente_gateways.gw_id = cliente_eventos.gw_id) WHERE (cliente_eventos.alarma_repuesta='0') AND (cliente_eventos.evento_codigo>'000') AND (cliente_eventos.instalacion_id='%s') %s ORDER BY alarma_fecha_recibida DESC", $NombreTabla, $instalacion, $queryaux);
		    //echo $query_basica_count.'<br/>';
		    //echo 'offset='.$offset.'<br/>';
		    $result = mysql_query($query_basica_count,$link);
		    if ($result)
		    {
			    if($row = mysql_fetch_array($result))
			    {
				    $count_parcial = $row[0];
				    $count_total += $count_parcial;
				    //echo $count_total.'+='.$count_parcial.'<br/>';
				    if($count_parcial>0)
					{
					    if ($count_mostrar == 0)
					    {
						  //echo 'if1<br/>';
						  if ($count_total >= $offset)
						  {
							//echo 'if2<br/>';
							$query_total .= $query_basica . ' LIMIT '.($offset-($count_total-$count_parcial)).','.$num_filas_tabla.')';
							$count_mostrar += $count_total - $offset;
						  }
					    }
					    else if ($count_mostrar < $num_filas_tabla)
					    {
						  //echo 'else1<br/>';
						  $query_total .= " UNION ".$query_basica." LIMIT 0,".$num_filas_tabla.")";
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

	$query_final = sprintf("select cliente_eventos1.gw_id AS gw_id,
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
								   cliente_eventos1.alarma_id,
								   CONCAT(LPAD(MONTH(cliente_eventos1.alarma_fecha_recibida),2,'0'),YEAR(cliente_eventos1.alarma_fecha_recibida)) AS alarma_tabla,
								   cliente_eventos1.alarma_fecha_recibida AS fecha,
								   cliente_eventos1.evento_tiposensor as tiposensor,
								   cliente_eventos1.alarma_repuesta,
								   cliente_eventos1.alarma_fecha_repuesta,
								   cliente_eventos1.alarma_usuario_repuesta 
							   from (cliente_analizadores right join 
							   		(cliente_gateways inner join 
							   	    (cliente_params_nodo right join 
							   	    ((%s) as cliente_eventos1) on 
							   	    ((cliente_eventos1.nodo_mac = cliente_params_nodo.nodo_mac) AND 
							   	    (cliente_eventos1.gw_id = cliente_params_nodo.gw_id))) on
							   	    (cliente_gateways.gw_id = cliente_eventos1.gw_id)) on 
							   	    (cliente_eventos1.nodo_mac=cliente_analizadores.analizador_id AND 
							   	    cliente_eventos1.evento_codigo>299 AND cliente_eventos1.evento_codigo<400))
									left join %s.rfreenet_texto_eventos_%s on 
							   	    (cliente_eventos1.evento_codigo = %s.rfreenet_texto_eventos_%s.evento_codigo AND 
							   	    (%s.rfreenet_texto_eventos_%s.evento_tipo = cliente_gateways.gw_tipo OR
                                                              %s.rfreenet_texto_eventos_%s.evento_tipo = -1))
							   ORDER BY fecha DESC LIMIT %s", $db_name_general, $_SESSION['opcion_idioma'], $query_total, $db_name_general, 
					   				$_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma'], $db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma'],$num_filas_tabla);

	//echo $query_final;

	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
		
	if ($result)
	{
		$num_total_filas= $count_total;
		//echo pad_izquierda($num_total_filas,$num_filas_tabla,'0').'<br>';
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

$ancho_1 = '20%';
$ancho_2 = '20%';
$ancho_3 = '25%';
$ancho_4 = '20%';
$ancho_5 = '15%';

$alto='25px';

//echo $query_final."<br>";
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general128']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general324']."</td>";
echo "</tr>";

if(!$result)
{
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"4\"><br/></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"4\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"4\"><br/></td></tr>";
}
else
{
	if (mysql_num_rows($result)==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"4\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"4\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"4\"><br/></td></tr>";
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
				// si es un gateway
				if (($row['nodo_ip'] === "000") || ($row['nodo_ip'] === "001"))
				{			
					echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."</td>";
				}
				// Si es un analizador
				else if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
				{
					echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general255']." ".$row['nodo_ip']."</td>";
				}		
				else 
				{
					echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac']."</td>";	
				}
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".utf8_encode($row['nombre'])."</td>";
			}
			
			//Si es un analizador se hace distinto
			if (($row['evento_codigo']>299) && ($row['evento_codigo']<400))
			{
				$numero_magnitud = "";
				if(substr($row['tiposensor'],2,1) != '0')
				{
					$numero_magnitud = substr($row['tiposensor'],2,1);
				}
				echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".sObtener_Cadena_Tipo_Sensor_UTC(substr($row['tiposensor'],0,2),substr($row['tiposensor'],2,1))."</td>";
			}
			else
			{
				if($row['gw_tipo'] == $tipo_gw or $row['gw_tipo'] == $tipo_gw_lowT)
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".utf8_encode($row['texto'])."</td>";	
				}
				elseif ($row['gw_tipo'] == $tipo_gw_low)
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
						$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." P".($row['evento_codigo']%25-7).")";
						//$mifirePHP -> log("SENSOR---->".$sensor);						
					}
					else if(($row['evento_codigo'] >= 619 && $row['evento_codigo'] <= 622) || //DIGITAL
					   ($row['evento_codigo'] >= 633 && $row['evento_codigo'] <= 647) ||
					   ($row['evento_codigo'] >= 670 && $row['evento_codigo'] <= 673) ||
					   ($row['evento_codigo'] >= 694 && $row['evento_codigo'] <= 697) ||
					   ($row['evento_codigo'] >= 719 && $row['evento_codigo'] <= 722) ||
					   ($row['evento_codigo'] >= 744 && $row['evento_codigo'] <= 747))
					{				
						$sensor = " (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." D".($row['evento_codigo']%25-18).")";
						//$mifirePHP -> log("SENSOR---->".$sensor);						
					}
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".utf8_encode($row['texto']).$sensor."</td>";				
				}				
			}
			echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">";
			echo "<input type='button' id='Al".$row['alarma_id']."' align=\"center\" onclick='OnReponerAlarma(".$row['alarma_id'].",\"".$row['alarma_tabla']."\")' value='".$idiomas[$_SESSION['opcion_idioma']]['general325']."')'></input>";
			echo "<img id='imagen_esperaDB".$row['alarma_id']."' src='images/wait_circle.gif' style='visibility:hidden;'/>";
			echo "</td>";
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
