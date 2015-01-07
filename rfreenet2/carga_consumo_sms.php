<?
session_start();
include 'inc/idiomas.inc';
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
		$query = sprintf("(select %s.rfreenet_texto_eventos_%s.evento_texto,clientes_datos.cliente_nombre,%s.instalacion_id,%s.instalacion_nombre,%s.nodo_mac,%s.cliente_id,%s.sms_evento,%s.sms_fecha_out from %s inner join clientes_datos 
                                    on (%s.cliente_id=clientes_datos.cliente_id) 
                         inner join clientes_suscriptores on (%s.gw_id = clientes_suscriptores.gw_id AND
                                                           %s.instalacion_id = clientes_suscriptores.instalacion_id)
                         inner join %s.rfreenet_texto_eventos_%s 
                                    on (%s.rfreenet_texto_eventos_%s.evento_codigo=%s.sms_evento AND 
                                        (%s.rfreenet_texto_eventos_%s.evento_tipo = clientes_suscriptores.gw_tipo OR %s.rfreenet_texto_eventos_%s.evento_tipo = -1))
                                        WHERE sms_enviado='1' AND %s.gw_id!='0000' ", $db_name_general, $_SESSION['opcion_idioma'], $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,
                                        											 $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$db_name_general,$_SESSION['opcion_idioma'],$db_name_general,$_SESSION['opcion_idioma'],$NombreTabla,
                                        											 $db_name_general,$_SESSION['opcion_idioma'],$db_name_general,$_SESSION['opcion_idioma'],$NombreTabla);
		/*		
		$query = sprintf("(select %s.sms_id, %s.rfreenet_texto_eventos_%s.evento_texto,clientes_datos.cliente_nombre,%s.instalacion_id,%s.instalacion_nombre,%s.nodo_mac,%s.cliente_id,%s.sms_evento,%s.sms_fecha_out from ((%s inner join clientes_datos on %s.cliente_id=clientes_datos.cliente_id) inner join %s.rfreenet_texto_eventos_%s on %s.rfreenet_texto_eventos_%s.evento_codigo=%s.sms_evento)  WHERE sms_enviado='1' ", $NombreTabla, $db_name_general, $_SESSION['opcion_idioma'], $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla, $db_name_general, $_SESSION['opcion_idioma'],$db_name_general, $_SESSION['opcion_idioma'],$NombreTabla);*/
		
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
	$query_final .= ") AS tabla_final ORDER BY tabla_final.sms_fecha_out DESC";	
	//echo $query_final.'<br>';
	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
}
else
{
	echo pad_izquierda(0,$cifras_num_sms,'0');
	$result = false;
}

$ancho_1 = '15%';
$ancho_2 = '30%';
$ancho_3 = '30%';
$ancho_4 = '25%';

$alto='25px';

if(!$result)
{
	echo pad_izquierda(0,$cifras_num_sms,'0');
	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general1']."</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general7']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
	echo "</tr>";
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
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general1']."</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general7']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general31']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
	echo "</tr>";
	if ($numero_sms==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"5\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"5\"><span>".$idiomas[$_SESSION['opcion_idioma']]['general129']."</span></td></tr>";
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"5\"><br/></td></tr>";
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
			//echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$row['cliente_id']."</td>";
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$row['cliente_nombre']."</td>";
			//echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$row['instalacion_id']."</td>";
			echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$row['instalacion_nombre']."</td>";
			//echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$row['sms_evento']."</td>";
			if ($row['sms_evento'] == 806)
			{
				if ($row['nodo_mac'] == '000000000000')
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">Recuperada ".$row['evento_texto']."</td>";
				}
				else
				{
					echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">Perdida ".$row['evento_texto']."</td>";	
				}
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$row['evento_texto']."</td>";	
			}	
			//echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">".$row['texto']."</td>";
			echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">".$row['sms_fecha_out']."</td>";
			echo "</tr>";
			$cuenta_filas++;
		}
	}

	while ($cuenta_filas < $min_filas_tabla)
	{
		if ((($cuenta_filas)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"><br></td></tr>";
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
