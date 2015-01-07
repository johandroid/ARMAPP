<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';


$min_filas_tabla = 10;
$cifras_num_sms = 12;

$instalacion = $_GET["instalacion_id"];
$cliente = $_GET["cliente_id"];
$cliente_database = $_GET["cliente_db"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$filtro_gw = $_GET["filtro_gw"];
$filtro_nodo = $_GET["filtro_nodo"];
$filtro_utc = $_GET["filtro_utc"];
$filtro_evento = $_GET["filtro_evento"];

/*Se convierte la hora a la del servidor*/
$zona_horaria = sObtener_TimeZone_Instalacion($cliente_database, $instalacion);
if ($fecha_begin != "0")
{
	$fecha_begin = sObtener_Fecha_Inversa($cliente_database,$instalacion,$fecha_begin,$zona_horaria);
	//echo $fecha_begin;
}
if ($fecha_end != "0")
{
	$fecha_end = sObtener_Fecha_Inversa($cliente_database,$instalacion,$fecha_end,$zona_horaria);
	//echo $fecha_end;
}

/**/

$link = mysql_connect($db_host, $db_user, $db_pass);
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

$query_final = "select * from (";
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

$cuenta_tablas = 1;
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
		$query = sprintf("(select tabla_sms_%u.sms_id,tabla_texto_eventos.evento_texto,tabla_texto_modbus.evento_texto as evento_texto_modbus,tabla_instalaciones.instalacion_nombre,tabla_sms_%u.gw_id,tabla_gw.gw_nombre,tabla_sms_%u.nodo_mac,tabla_nodos.nodo_nombre,tabla_sms_%u.instalacion_id,tabla_sms_%u.sms_evento,tabla_sms_%u.sms_fecha_out,tabla_sms_%u.sms_fecha_in,tabla_sms_%u.sms_enviado 
			from 
			 %s.%s as tabla_sms_%u inner join %s.clientes_datos as tabla_clientes on (tabla_sms_%u.cliente_id=tabla_clientes.cliente_id)			 
			 left join %s.rfreenet_texto_modbus_%s as tabla_texto_modbus on (tabla_texto_modbus.evento_codigo=tabla_sms_%u.sms_evento)
			 inner join %s.cliente_instalaciones as tabla_instalaciones on (tabla_instalaciones.instalacion_id=tabla_sms_%u.instalacion_id)
			 inner join %s.cliente_gateways as tabla_gw on (tabla_gw.gw_id=tabla_sms_%u.gw_id)
			 left join %s.cliente_nodos as tabla_nodos on (tabla_nodos.nodo_mac=tabla_sms_%u.nodo_mac)
			 left join %s.rfreenet_texto_eventos_%s as tabla_texto_eventos on (tabla_texto_eventos.evento_codigo=tabla_sms_%u.sms_evento AND (tabla_texto_eventos.evento_tipo = tabla_gw.gw_tipo OR tabla_texto_eventos.evento_tipo = -1))
			 left join %s.cliente_analizadores as tabla_analizadores on (tabla_analizadores.analizador_id=tabla_sms_%u.nodo_mac AND tabla_texto_eventos.evento_codigo>299 AND tabla_texto_eventos.evento_codigo<400)
		WHERE tabla_sms_%u.sms_externo!=0 AND tabla_sms_%u.cliente_id='%s' ",
		$cuenta_tablas, $cuenta_tablas, $cuenta_tablas, $cuenta_tablas, $cuenta_tablas, $cuenta_tablas,  $cuenta_tablas,  $cuenta_tablas,
		$db_name_clientes, $NombreTabla, $cuenta_tablas, $db_name_clientes, $cuenta_tablas,
		$db_name_general, $_SESSION['opcion_idioma'], $cuenta_tablas,
		$cliente_database, $cuenta_tablas,
		$cliente_database, $cuenta_tablas, 
		$cliente_database, $cuenta_tablas,		
		$db_name_general, $_SESSION['opcion_idioma'], $cuenta_tablas,
		$cliente_database, $cuenta_tablas,
		$cuenta_tablas,$cuenta_tablas,$cliente);
		//echo $query.'<br/>';
				
		if ($cliente != '0000')
		{
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".cliente_id='".$cliente."' ";
		}
		if ($instalacion != '0000')
		{
			 $queryaux .= " AND tabla_sms_".$cuenta_tablas.".instalacion_id='".$instalacion."' ";
		}
		if ($filtro_gw != '000')
		{
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".gw_id='".$filtro_gw."' ";
		}
		if ($filtro_nodo != '000')
		{
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".nodo_mac='".$filtro_nodo."' ";
		}
		if ($filtro_utc != '000')
		{
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".nodo_mac='".$filtro_utc."' ";
		}
		if ($fecha_begin != 0)
		{
			//$queryaux .= " AND tabla_sms_".$cuenta_tablas.".sms_fecha_out>='".$fecha_begin."' ";
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".sms_fecha_in>='".$fecha_begin."' ";
		}
		if ($fecha_end != 0)
		{
			$queryaux .= " AND tabla_sms_".$cuenta_tablas.".sms_fecha_out<='".$fecha_end."' ";
		}
		
		switch ($filtro_evento)
		{
			// Si piden cobertura, solo mostraremos eventos de cobertura
			case 2:
				$queryaux .= " AND (tabla_sms_".$cuenta_tablas.".sms_evento='800')";
				break;
				
			// Si piden alimentacion, solo bateria y 220
			case 3:
				$queryaux .= " AND ((tabla_sms_".$cuenta_tablas.".sms_evento='805') OR (tabla_sms_".$cuenta_tablas.".sms_evento='806') OR (tabla_sms_".$cuenta_tablas.".sms_evento='801'))";
				break;
				
			// Si piden umbrales
			case 4:
				$queryaux .= "AND (((tabla_sms_".$cuenta_tablas.".sms_evento>'505') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'512')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'624') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'673')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'299') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'400')))";
				break;
	
			// Si piden gradientes
			case 5:
				$queryaux .= "AND (((tabla_sms_".$cuenta_tablas.".sms_evento>'674') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'723')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'511') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'518')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'299') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'400')))";
				break;
				
			// Si piden datos, mostraremos solo eventos de datos
			case 1:
				$queryaux .= "AND (((tabla_sms_".$cuenta_tablas.".sms_evento>'499') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'506')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'599') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'623')) OR ((tabla_sms_".$cuenta_tablas.".sms_evento>'299') AND (tabla_sms_".$cuenta_tablas.".sms_evento<'400')))";
				break;
			
			default:
				break;
		}
		
		$query.=$queryaux;
		$query.=")";
		$query_final.=$query;
		//echo $query_final."<br>";
		$primero = 0;
		$cuenta_tablas++;
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
	$query_final .= ") AS tabla_final ORDER BY tabla_final.sms_fecha_in DESC;";	
	//echo $query_final.'<br>';
	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
}
else
{
	//$num_total_filas= $min_filas_tabla;
	//echo pad_izquierda($num_total_filas,$cifras_num_sms,'0');
	//echo pad_izquierda(0,$cifras_num_sms,'0');
	$result = false;
}

$ancho_1 = '6%';
$ancho_2 = '20%';
$ancho_3 = '20%';
$ancho_4 = '27%';
$ancho_5 = '7%';
$ancho_6 = '20%';

$alto='25px';

if(!$result)
{
	echo pad_izquierda(0,$cifras_num_sms,'0');
	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">Id</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general20']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general21']." / ".$idiomas[$_SESSION['opcion_idioma']]['general255']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general130']."</td>";
	echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
	echo "</tr>";
	$cuenta_filas = 0;
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"6\"><br/></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"6\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"6\"><br/></td></tr>";
}
else
{
	$numero_sms = mysql_num_rows($result);
	echo pad_izquierda($numero_sms,$cifras_num_sms,'0');
	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">Id</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general20']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general21']." / ".$idiomas[$_SESSION['opcion_idioma']]['general255']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general130']."</td>";
	echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
	echo "</tr>";
	if ($numero_sms==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"6\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"6\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"6\"><br/></td></tr>";
		$cuenta_filas = $min_filas_tabla;
	}
	else
	{
		$cuenta_filas = 0;
		while ($row = mysql_fetch_array($result))
		{
			if ((($cuenta_filas)%2) != 0)
			{
				echo "<tr class=\"tipo_fila_2\">";
			}
			else
			{
				 echo "<tr class=\"tipo_fila_1\">";
			}

			$redondeado=sprintf("%04u",$row['sms_id']);
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$redondeado."</td>";
			//echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$row['gw_id']."</td>";
			if ($row['gw_nombre'] == "")
			{
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$row['gw_nombre']."</td>";
			}
			if (strlen($row['nodo_mac']) == 2)
			{
				if (($row['nodo_nombre'] == "") || ($row['nodo_nombre'] == "NULL"))
				{
					if ($row['nodo_mac'] != '000000000000')
					{
						echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general255']." ".$row['nodo_mac']."</td>";
					}
					else
					{
						echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">-</td>";
					}
				}
				else
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$row['nodo_nombre']."</td>";
				}
				//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$row['sms_evento']."</td>";
				echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$row['evento_texto_modbus']."</td>";
			}
			else
			{
				if (($row['nodo_nombre'] == "") || ($row['nodo_nombre'] == "NULL"))
				{
					if ($row['nodo_mac'] != '000000000000')
					{
						echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac']."</td>";
					}
					else
					{
						echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">-</td>";
					}
				}
				else
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$row['nodo_nombre']."</td>";
				}
				//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$row['sms_evento']."</td>";
				echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$row['evento_texto']."</td>";
			}
			if ($row['sms_enviado']!=0)
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\">Sí</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\">No</td>";
			}
			//echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\">".$row['sms_fecha_out']."</td>";
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\">"./*$row['sms_fecha_in']*/sObtener_Fecha_Desde_String($cliente_database, $instalacion, $row['sms_fecha_in'],$zona_horaria)."</td>";
			echo "</tr>";
			$cuenta_filas++;
		}
	}

	while ($cuenta_filas < $min_filas_tabla)
	{
		if ((($cuenta_filas)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		
		$cuenta_filas++;
	}
}
echo "</table>";
//echo $query_final.'<br>'; 

if ($result)
{
	mysql_free_result($result);
}
mysql_close($link);
?>
