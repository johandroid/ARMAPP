<?session_start();

include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';
include 'inc/idiomas.inc';
include 'inc/funciones_db.inc';
	
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$link = mysql_connect($db_host, $db_user,$db_pass);
mysql_select_db($cliente_db, $link);
	
//require_once('FirePHPCore/FirePHP.class.php'); 
//ob_start();
//$mifirePHP = FirePHP::getInstance(true); 	

$pagina = $_GET["pagina"];

$num_filas_tabla=14;

$query2 = "SELECT count(cliente_comandos.gw_id) 
			from cliente_nodos RIGHT JOIN (cliente_comandos INNER JOIN cliente_gateways ON cliente_comandos.gw_id=cliente_gateways.gw_id) 
									   ON (cliente_comandos.nodo_ip=cliente_nodos.nodo_ip and 
									       cliente_comandos.gw_id=cliente_nodos.gw_id) 
			WHERE cliente_gateways.instalacion_id='".$instalacion_id."' 
			order by cliente_comandos.comandos_fecha desc";
			
$query="SELECT  cliente_comandos.comandos_id,
				cliente_comandos.gw_id,
				cliente_nodos.nodo_mac,
				cliente_comandos.comandos_trama,
				cliente_comandos.comandos_enviado,
				cliente_comandos.comandos_ack,
				cliente_comandos.comandos_fecha 
		  from cliente_nodos RIGHT JOIN (cliente_comandos INNER JOIN cliente_gateways ON cliente_comandos.gw_id=cliente_gateways.gw_id) 
		  							 ON (cliente_comandos.nodo_ip=cliente_nodos.nodo_ip and cliente_comandos.gw_id=cliente_nodos.gw_id) 
		 WHERE cliente_gateways.instalacion_id='".$instalacion_id."' 
		 order by cliente_comandos.comandos_enviado,cliente_comandos.comandos_ack,cliente_comandos.comandos_fecha desc,cliente_comandos.comandos_id LIMIT ";
		 
if ($pagina > 1)
{
	$query .= (($pagina-1)*$num_filas_tabla).",";		
}
$query .= "$num_filas_tabla";

//$mifirePHP->log('QUERY '.$query);

$result = mysql_query($query) or die(mysql_error());

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
//echo $query;

echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general265']."</td>";
echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general266']."</td>";
echo "<td align=\"center\" width=\"18%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general267']."</td>";
echo "<td align=\"center\" width=\"33%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general268']."</td>";
echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general269']."</td>";
echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general270']."</td>";
echo "</tr>";
 
 if(!$result)
{
	//echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"></td></tr>";
	echo "<tr>";
	echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"18%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"33%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"13%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborder\"></td>";
	echo "</tr>";
}
else
{
	$cuenta_filas = 0;
	while ($row = mysql_fetch_array($result))
	{
		//$mifirePHP->log('ENTRA '.$row['gw_id']);
		
		if ((($cuenta_filas)%2) != 0)
		{
			echo "<tr class=\"tipo_fila_2\">";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\">";
		}
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">".$row['gw_id']."</td>";
		switch (substr($row['comandos_trama'],0,1))
		{
			case 'K':
				echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">".substr($row['comandos_trama'],13,12)."</td>";
				break;
				
			case 'i':
				echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">".substr($row['comandos_trama'],12,12)."</td>";
				break;
			default:
				echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">".$row['nodo_mac']."</td>";
				break;
		}
		$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion_id);
		echo "<td align=\"center\" width=\"18%\" class=\"RFNETtext\">".sObtener_Fecha_Desde_String($cliente_db, $instalacion_id, $row['comandos_fecha'],$zona_horaria)."</td>";
		echo "<td align=\"center\" width=\"33%\" class=\"RFNETtext\" onmouseout=\"UnTip()\" onmouseover=\"Tip('<html><div>".wordwrap($row['comandos_trama'],60,"<br>",true)."</div></html>',TITLE,'".$idiomas[$_SESSION['opcion_idioma']]['general272']." ".$row['gw_id']."',CLOSEBTN,true,CLOSEBTNCOLORS, ['#6F6F6F','#2F2F2F','',''],PADDING,10,SHADOW,true,BGCOLOR,'#EEEEEE',BORDERCOLOR,'#aaaaaa',FONTCOLOR,'#222222',STICKY, true, WIDTH, 380)\">".trama_corto($row['comandos_trama'])."</td>";
		//}
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">";
		if(intval($row["comandos_ack"])==1)
			echo $idiomas[$_SESSION['opcion_idioma']]['general369'];
		else if(intval($row["comandos_enviado"])==1)
			echo $idiomas[$_SESSION['opcion_idioma']]['general130'];
		else
			echo $idiomas[$_SESSION['opcion_idioma']]['general271'];
		echo "</td>";
		echo "<td align=\"center\" width=\"10%\" class=\"RFNETtext\">";
		if(intval($row["comandos_ack"])==0 && intval($row["comandos_enviado"])==0)
			echo " <img src=\"images/off.png\" onclick=\"borrar_comando(".$row["comandos_id"].")\"></img> ";
		else
			echo " <img src=\"images/off.png\" style=\"opacity:0.0;filter:alpha(opacity=0)\"></img> ";
		echo "</td>";
		echo "</tr>";
		$cuenta_filas++;
	}
	while($cuenta_filas<$num_filas_tabla)
	{
		if ((($cuenta_filas)%2) != 0)
		{
			echo "<tr class=\"tipo_fila_2\">";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\">";
		}
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">&nbsp;</td>";
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"18%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"33%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"10%\" class=\"RFNETtext\"><img src=\"images/off.png\" style=\"opacity:0.0;filter:alpha(opacity=0)\"></img></td>";
		echo "</tr>";
		$cuenta_filas++;
	}
}
echo "</table>";
mysql_close($link);
?>
