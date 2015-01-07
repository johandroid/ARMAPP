<?session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
</head>

<body>

<?php
include 'inc/datos_db.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_medidas.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_SESSION["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = "SELECT cliente_nodos.gw_id, cliente_nodos.nodo_ip, cliente_nodos.nodo_mac,cliente_nodos.nodo_nombre,cliente_nodos.nodo_tipo_s1,cliente_nodos.nodo_last_s1,cliente_nodos.nodo_lasttipo_s1,cliente_nodos.nodo_tipo_s2,cliente_nodos.nodo_last_s2,cliente_nodos.nodo_lasttipo_s2,cliente_nodos.nodo_tipo_s3,cliente_nodos.nodo_last_s3,cliente_nodos.nodo_lasttipo_s3,cliente_nodos.nodo_tipo_s4,cliente_nodos.nodo_last_s4,cliente_nodos.nodo_lasttipo_s4,cliente_nodos.nodo_tipo_s5,cliente_nodos.nodo_last_s5,cliente_nodos.nodo_lasttipo_s5,cliente_nodos.nodo_tipo_s6,cliente_nodos.nodo_last_s6,cliente_nodos.nodo_lasttipo_s6,nodo_aux_operacion1,nodo_aux_constante1,nodo_aux_operacion2,nodo_aux_constante2,nodo_aux_operacion3,nodo_aux_constante3,nodo_aux_operacion4,nodo_aux_constante4,nodo_aux_operacion5,nodo_aux_constante5,nodo_aux_operacion6,nodo_aux_constante6 FROM cliente_nodos  inner join cliente_params_nodo on cliente_nodos.nodo_mac=cliente_params_nodo.nodo_mac WHERE cliente_nodos.instalacion_id='".$instalacion."' order by gw_id,nodo_nombre,nodo_mac ASC";
//echo $query;

$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);

$ancho_1 = '10%';
$ancho_2 = '10%';
$ancho_3 = '10%';
$ancho_4 = '6%';
$ancho_5 = '10%';
$ancho_6 = '5%';
$ancho_7 = '10%';

echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">ID</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general38']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general30']."</td>";
//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">Puerto</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 1</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 2</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 3</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 4</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 5</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 6</td>";
echo "</tr>";

if(!$result)
{
	//echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"></td></tr>";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td>";
	//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "</tr>";
	
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
		echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtext\">".$row['gw_id']."</td>";
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtext\">".$row['nodo_nombre']."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">".$row['nodo_mac']."</td>";
		//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".$row['gw_port']."</td>";
		if ($row['nodo_tipo_s1'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s1']), $row['nodo_tipo_s1'],0,$row['nodo_lasttipo_s1'],1,$row['nodo_aux_operacion1'],$row['nodo_aux_constante1'], $row['gw_id'], $row['nodo_ip'], 1)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['nodo_tipo_s2'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s2']), $row['nodo_tipo_s2'],0,$row['nodo_lasttipo_s2'],1,$row['nodo_aux_operacion2'],$row['nodo_aux_constante2'], $row['gw_id'], $row['nodo_ip'], 2)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['nodo_tipo_s3'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s3']), $row['nodo_tipo_s3'],0,$row['nodo_lasttipo_s3'],1,$row['nodo_aux_operacion3'],$row['nodo_aux_constante3'], $row['gw_id'], $row['nodo_ip'], 3)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['nodo_tipo_s4'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s4']), $row['nodo_tipo_s4'],0,$row['nodo_lasttipo_s4'],1,$row['nodo_aux_operacion4'],$row['nodo_aux_constante4'], $row['gw_id'], $row['nodo_ip'], 4)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['nodo_tipo_s5'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s5']), $row['nodo_tipo_s5'],0,$row['nodo_lasttipo_s5'],1,$row['nodo_aux_operacion5'],$row['nodo_aux_constante5'], $row['gw_id'], $row['nodo_ip'], 5)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['nodo_tipo_s6'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_Nodo(hexdec($row['nodo_last_s6']), $row['nodo_tipo_s6'],0,$row['nodo_lasttipo_s6'],1,$row['nodo_aux_operacion6'],$row['nodo_aux_constante6'], $row['gw_id'], $row['nodo_ip'], 6)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		
		echo "</tr>";
		$cuenta_filas++;
	}
}

echo "</table>";

if ($query != "")
{
	mysql_free_result($result);
}
mysql_close($link);
?>

</body>
</html>