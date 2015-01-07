<?
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
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

$pagina = $_GET["pagina"];

$num_filas_tabla=6;

mysql_select_db($cliente_db, $link);



$query = "";
if ($ver_nodo != 0)
{
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
	$mes_actual=$mes_begin;
	$anyo_actual=$anyo_begin;
	
	$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_begin);
	$cadena_final=sprintf("%02u%04u",$anyo_actual,$anyo_end);
	$cadena_actual=$cadena_inicial;
	$primero = 1;
	
	while($cadena_actual!='FIN')
	{
//		if($primero!=1)
//		{
//			$query_final .= " UNION ";
//			$query2 .= " UNION ";
//		}
		$NombreTabla = "cliente_imagenes_".$cadena_actual;
		$queryaux='';
		if (table_exists($NombreTabla, $link)) 
		{

			if($primero!=1)
			{
				$query_final .= " UNION ";
				$query2 .= " UNION ";
				//echo $query_final."<br>";
				$queryaux = "";
			}
			//echo $query_final."<br>";		
			//echo $NombreTabla.'<br>';
			$query = sprintf("(select cliente_imagenes.gw_id AS gw_id,cliente_imagenes.nodo_ip AS nodo_ip, cliente_nodos.nodo_mac AS nodo_mac,cliente_nodos.nodo_nombre AS nombre,cliente_imagenes.imagen_size AS size,cliente_imagenes.imagen_timestamp AS imagen_fecha,cliente_imagenes.imagen_id AS imagen_id from cliente_nodos inner join (%s as cliente_imagenes) on cliente_nodos.nodo_ip = cliente_imagenes.nodo_ip and cliente_nodos.gw_id=cliente_imagenes.gw_id where (cliente_nodos.instalacion_id='%s')", $NombreTabla, $instalacion);
			
			if ($gw_id!='000')
			{
				$queryaux .= " AND cliente_imagenes.gw_id='".$gw_id."'";
			}
				
			if ($ipnodo!='F')
			{
				$queryaux .= " AND cliente_nodos.nodo_mac='".$ipnodo."'";
			}
			
			if ($fecha_begin != "0")
			{
				$queryaux .= " AND imagen_timestamp>'".$fecha_begin."'";
			}
			if ($fecha_end != "0")
			{
				$queryaux .= " AND imagen_timestamp<'".$fecha_end."'";
			}			
			$query.=$queryaux;
			$query2.=$query;
//			$query.=" ORDER BY evento_fecha)";
			$query.=")";
			$query2.=")";
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
		$query_final .= ") AS tabla_final ORDER BY imagen_fecha DESC LIMIT ";
		$query2.=") AS tabla_final";
		if ($pagina > 1)
		{
			$query_final .= (($pagina-1)*$num_filas_tabla).",";		
		}
		$query_final .= "$num_filas_tabla";
		$query_final .= ";";
		$query2.=";";
	
		//echo $query_final.'<br>';
//		echo $query2.'<br>';
		$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
		
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
$ancho_1 = '35%';
$ancho_2 = '25%';
$ancho_3 = '40%';

$alto='25px';
//echo $query_final."<br>";
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">Fecha y Hora</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">Id Origen</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">Imagen Recibida</td>";

echo "</tr>";

if(!$result2)
{
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"3\"><br/></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"3\"><span>No hay eventos que cumplan los requisitos en los dos últimos meses</span></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"3\"><br/></td></tr>";
	$cuenta_filas = $num_filas_tabla;
}
else if(!$result)
{
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
}
else
{
	if (mysql_num_rows($result)==0)
	{
		echo "<tr class=\"tipo_fila_1\"><td align=\"center\" colspan=\"5\"><br/></td></tr>";
		echo "<tr class=\"tipo_fila_2\"><td align=\"center\" colspan=\"5\"><span>No hay eventos que cumplan los requisitos en los dos últimos meses</span></td></tr>";
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
			
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$row['imagen_fecha']."</td>";
			
			if ($row['nombre']=='')
			{
				$name = "Concentrador ".$row['nodo_mac'];
				
			}
			else
			{
				$name = utf8_encode($row['nombre']);
			}	
			echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$name."</td>";
			$tabla = "cliente_imagenes_".substr($row['imagen_fecha'],5,2).substr($row['imagen_fecha'],0,4);	
			echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">";
			//echo $row['size'];
			switch($row['size'])
			{
				case 3:
					$width="160px";
					$height="128px";
					$width2= "180";
					break;
				case 5:
					$width="320px";
					$height="240px";
					$width2= "340";
					break;
				case 7:
					$width="640px";
					$height="480px";
					$width2= "650";
					break;
				default:
				case 1:
					$width="80px";
					$height="60px";
					$width2= "100";
					break;
			}
			//echo "<a href=\"descargar_imagen_camara.php?imagen_id=".$row["imagen_id"]."&tabla=".$tabla."&instalacion_id=".$instalacion."&cliente_db=".$cliente_db."?KeepThis=true&TB_iframe=true&height=400&width=600\" class=\"thickbox\"><img src=\"descargar_imagen_camara.php?imagen_id=".$row["imagen_id"]."&tabla=".$tabla."&instalacion_id=".$instalacion."&cliente_db=".$cliente_db."\" width=\"80px\" height=\"60px\"></img></a></td>";
			echo "<img src=\"descargar_imagen_camara.php?imagen_id=".$row["imagen_id"]."&tabla=".$tabla."&instalacion_id=".$instalacion."&cliente_db=".$cliente_db."\" width=\"80px\" height=\"60px\" onclick=\"Tip('<html><table width=\'100%\'><tr><td align=\'center\'><img src=\'descargar_imagen_camara.php?imagen_id=".$row["imagen_id"]."&tabla=".$tabla."&instalacion_id=".$instalacion."&cliente_db=".$cliente_db."\' width=\'".$width."\' height=\'".$height."\'></img></td></tr></table></html>',CLOSEBTN,true,CLOSEBTNCOLORS,['#aaaaaa', '#222222', '', ''],PADDING,10,SHADOW,true,BGCOLOR,'#EEEEEE',BORDERCOLOR,'#aaaaaa',FONTCOLOR,'#222222',STICKY, true)\"></img></td>";
		
			echo "</tr>";
			$cuenta_filas++;
		}
	}

	while ($cuenta_filas < $num_filas_tabla)
	{
		if ((($cuenta_filas)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"><br></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"><br></td></tr>";
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
