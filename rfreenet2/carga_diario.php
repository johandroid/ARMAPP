<?session_start();

include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';
include 'inc/idiomas.inc';

$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];

$link = mysql_connect($db_host, $db_user,$db_pass);
mysql_select_db($cliente_db, $link);
	
require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();
$mifirePHP = FirePHP::getInstance(true); 	
$mifirePHP->log('HOLA MUNDO');
$pagina = $_GET["pagina"];

$num_filas_tabla=14;

$query2 = "SELECT count(cliente_diario.id) 
			from cliente_diario 
			WHERE cliente_diario.instalacion_id='".$instalacion_id."'";			
			
$query="SELECT  cliente_diario.id,
				cliente_diario.instalacion_id,
				cliente_diario.fecha,
				cliente_diario.operador, 
				cliente_diario.mensaje
		  from cliente_diario 
		 WHERE cliente_diario.instalacion_id='".$instalacion_id."'";
		 
if($fecha_begin != 0)
{
	$query_aux.=" AND cliente_diario.fecha >= '".$fecha_begin."'";	
}
if($fecha_end != 0)
{
	$query_aux.=" AND cliente_diario.fecha <= '".$fecha_end."'";	
}
$query.=$query_aux;		  
$query2.=$query_aux;

$query2.=" order by cliente_diario.fecha desc";
$query.=" order by cliente_diario.fecha desc LIMIT ";
		 
if ($pagina > 1)
{
	$query .= (($pagina-1)*$num_filas_tabla).",";		
}
$query .= "$num_filas_tabla";

$mifirePHP->log('QUERY '.$query);

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
echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general8']."</td>";
echo "<td align=\"center\" width=\"30%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['user_oper']."</td>";
echo "<td align=\"center\" width=\"50%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general300']."</td>";
echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general56']."</td>";	
echo "</tr>";
 
//AMB 04/06/12 Línea de alta de mensaje 
echo "<td align=\"center\" class=\"RFNETtextborder\"><input valign=\"top\" align=\"center\" type=\"text\" id=\"FechaDiario\"  class=\"datepicker\" style=\"text-align:center;width:140px\"></td>";
echo "<td align=\"center\" width=\"30%\" class=\"RFNETtextborder\"><input valign=\"top\" align=\"center\" type=\"text\" id=\"Operador\" style=\"text-align:center; width:98%;\" maxlength=\"80\" ></td>";
echo "<td align=\"center\" width=\"50%\" class=\"RFNETtextborder\"><input valign=\"top\" align=\"center\" type=\"text\" id=\"Mensaje\" style=\"text-align:center; width:98%;\" maxlength=\"140\" ></td>";
echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborder\"></td>"; 
 
 if(!$result)
{
	//echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"></td></tr>";
	echo "<tr>";
	echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"30%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"50%\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"10%\" class=\"RFNETtextborder\"></td>";	
	echo "</tr>";
}
else
{
	$cuenta_filas = 0;
	while ($row = mysql_fetch_array($result))
	{
		$mifirePHP->log('ENTRA '.$row['id']);
		
		if ((($cuenta_filas)%2) != 0)
		{
			echo "<tr class=\"tipo_fila_2\">";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\">";
		}
		echo "<td align=\"center\" width=\"13%\" class=\"RFNETtext\">".$row['fecha']."</td>";
		echo "<td align=\"center\" width=\"30%\" class=\"RFNETtext\">".utf8_encode($row['operador'])."</td>";
		//echo "<td align=\"center\" width=\"18%\" class=\"RFNETtext\">".$row['mensaje']."</td>";
			//echo "<td align=\"center\" width=\"33%\" class=\"RFNETtext\" onmouseout=\"UnTip()\" onmouseover=\"Tip('<html><div>".wordwrap($row['comandos_trama'],50,"<br>",true)."</div></html>',CLOSEBTN,true,CLOSEBTNCOLORS, ['#6F6F6F','#2F2F2F','',''],PADDING,10,SHADOW,true,BGCOLOR,'#EEEEEE',BORDERCOLOR,'#aaaaaa',FONTCOLOR,'#222222',STICKY, true, WIDTH, 380)\">".substr($row['comandos_trama'],0,35)."...</td>";
		if(strlen($row['mensaje']) > 50){
			$mensaje=utf8_encode(substr($row['mensaje'], 0, 50)).".....";
		}
		else
		{
			$mensaje=utf8_encode(substr($row['mensaje'], 0, 50));
		}
		echo "<td align=\"center\" width=\"50%\" class=\"RFNETtext\" onmouseout=\"UnTip()\" onmouseover=\"Tip('<html><div>".wordwrap(utf8_encode($row['mensaje']),60,"<br>",true)."</div></html>',TITLE,'".$idiomas[$_SESSION['opcion_idioma']]['general300']." ".$row['fecha']."',CLOSEBTN,true,CLOSEBTNCOLORS, ['#6F6F6F','#2F2F2F','',''],PADDING,10,SHADOW,true,BGCOLOR,'#EEEEEE',BORDERCOLOR,'#aaaaaa',FONTCOLOR,'#222222',STICKY, true, WIDTH, 380)\"><div style=\"overflow:hidden;\">".$mensaje."</div></td>";
		echo "<td align=\"center\" width=\"10%\" class=\"RFNETtext\">";
			echo " <img src=\"images/off.png\" onclick=\"borrar_comando(".$row["id"].")\"></img> ";
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
		echo "<td align=\"center\" width=\"30%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"50%\" class=\"RFNETtext\"></td>";
		echo "<td align=\"center\" width=\"10%\" class=\"RFNETtext\"><img src=\"images/off.png\" style=\"opacity:0.0;filter:alpha(opacity=0)\"></img></td>";
		echo "</tr>";
		$cuenta_filas++;
	}
}
echo "</table>";
mysql_close($link);
?>
