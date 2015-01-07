<?session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';
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

$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_SESSION["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = "SELECT gw_id,gw_nombre,gw_tipo,cliente_gateways.gw_tipo_sensor1,cliente_gateways.gw_last_sensor1,cliente_gateways.gw_lasttipo_sensor1,cliente_gateways.gw_tipo_sensor2,cliente_gateways.gw_last_sensor2,cliente_gateways.gw_lasttipo_sensor2,cliente_gateways.gw_tipo_sensor3,cliente_gateways.gw_last_sensor3,cliente_gateways.gw_lasttipo_sensor3,cliente_gateways.gw_tipo_sensor4,cliente_gateways.gw_last_sensor4,cliente_gateways.gw_lasttipo_sensor4,cliente_gateways.gw_tipo_sensor5,cliente_gateways.gw_last_sensor5,cliente_gateways.gw_lasttipo_sensor5,cliente_gateways.gw_tipo_sensor6,cliente_gateways.gw_last_sensor6,cliente_gateways.gw_lasttipo_sensor6,cliente_gateways.gw_tipo_sensor7,cliente_gateways.gw_last_sensor7,cliente_gateways.gw_lasttipo_sensor7,cliente_gateways.gw_tipo_sensor8,cliente_gateways.gw_last_sensor8,cliente_gateways.gw_lasttipo_sensor8,cliente_gateways.gw_tipo_sensor9,cliente_gateways.gw_last_sensor9,cliente_gateways.gw_lasttipo_sensor9,gw_tipo_sensor10,gw_last_sensor10,gw_lasttipo_sensor10,gw_tipo_sensor11,gw_last_sensor11,gw_lasttipo_sensor11,gw_tipo_sensor12,gw_last_sensor12,gw_lasttipo_sensor12,gw_tipo_sensor13,gw_last_sensor13,gw_lasttipo_sensor13,gw_tipo_sensor14,gw_last_sensor14,gw_lasttipo_sensor14,gw_tipo_sensor15,gw_last_sensor15,gw_lasttipo_sensor15,gw_tipo_sensor16,gw_last_sensor16,gw_lasttipo_sensor16,gw_tipo_sensor17,gw_last_sensor17,gw_lasttipo_sensor17,gw_tipo_sensor18,gw_last_sensor18,gw_lasttipo_sensor18,gw_tipo_sensor19,gw_last_sensor19,gw_lasttipo_sensor19,gw_tipo_sensor20,gw_last_sensor20,gw_lasttipo_sensor20,gw_tipo_sensor21,gw_last_sensor21,gw_lasttipo_sensor21,gw_tipo_sensor22,gw_last_sensor22,gw_lasttipo_sensor22,gw_tipo_sensor23,gw_last_sensor23,gw_lasttipo_sensor23 FROM cliente_gateways WHERE cliente_gateways.instalacion_id='".$instalacion."' order by gw_nombre,gw_id ASC";
//echo $query;

$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);

$ancho_1 = '5%';
$ancho_2 = '10%';
$ancho_3 = '10%';
$ancho_4 = '6%';
$ancho_5 = '6%';
$ancho_6 = '5%';
$ancho_7 = '10%';

echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">ID</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general38']."</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 1/11</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 2/12</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 3/13</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 4</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 5</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 6</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 7</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 8</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 9</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 10</td>";
echo "</tr>";

if(!$result)
{
	//echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"></td></tr>";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td>";
	//echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td>";
	//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
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
		// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
		if($row['gw_tipo']=="0")
		{
			$array_versiones = sObtener_Versiones_GW($row['gw_id'], $cliente_db);
			$caGWVersionHW = $array_versiones[0];
		}
		else
		{
			$caGWVersionHW = "12";
		}
		if($row['gw_tipo']=="0")
		{
			echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtext\">".$row['gw_id']."</td>";
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_1\" rowspan=\"2\" class=\"RFNETtext\">".$row['gw_id']."</td>";
		}
		if($row['gw_tipo']=="0")
		{
			echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtext\">".$row['gw_nombre']."</td>";
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_2\" rowspan=\"2\" class=\"RFNETtext\">".$row['gw_nombre']."</td>";
		}
		//echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">".$row['gw_ip']."</td>";
		//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".$row['gw_port']."</td>";
		if ($row['gw_tipo_sensor1'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor1']), $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor2'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor2']), $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor3'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor3']), $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor4'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor4']), $row['gw_tipo_sensor4'], 0, $row['gw_id'], 3, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor5'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor5']), $row['gw_tipo_sensor5'], 0, $row['gw_id'], 4, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor6'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor6']), $row['gw_tipo_sensor6'],0, $row['gw_id'], 5, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor7'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor7']), $row['gw_tipo_sensor7'], 0, $row['gw_id'], 6, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor8'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor8']), $row['gw_tipo_sensor8'], 0, $row['gw_id'], 7, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}
		if ($row['gw_tipo_sensor9'] != "0")
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor9']), $row['gw_tipo_sensor9'], 0, $row['gw_id'], 8, 1, $caGWVersionHW)."</td>";
					
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		}		
		
		if($row['gw_tipo']=="0")
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
		else
		{
			/*if ($row['gw_tipo_sensor10'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor10']), $row['gw_tipo_sensor10'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			echo "</tr>";
			if ((($cuenta_filas)%2) != 0)
			{
				echo "<tr class=\"tipo_fila_2\">";
			}
			else
			{
				 echo "<tr class=\"tipo_fila_1\">";
			}
			
			if ($row['gw_tipo_sensor11'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor11']), $row['gw_tipo_sensor11'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor12'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor12']), $row['gw_tipo_sensor12'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			
			if ($row['gw_tipo_sensor13'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor13']), $row['gw_tipo_sensor13'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor14'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor14']), $row['gw_tipo_sensor14'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor15'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor15']), $row['gw_tipo_sensor15'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor16'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor16']), $row['gw_tipo_sensor16'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor17'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor17']), $row['gw_tipo_sensor17'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor18'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor18']), $row['gw_tipo_sensor18'],0, '0', '0',1, $caGWVersionHW)."</td>";
						
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor19'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor19']), $row['gw_tipo_sensor19'],0, '0', '0',1, $caGWVersionHW)."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}*/
			if ($row['gw_tipo_sensor20'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor20']), $row['gw_tipo_sensor20'], 0, '0', '0', 1, $caGWVersionHW)."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			echo "</tr>";
			if ((($cuenta_filas)%2) != 0)
			{
				echo "<tr class=\"tipo_fila_2\">";
			}
			else
			{
				 echo "<tr class=\"tipo_fila_1\">";
			}
			if ($row['gw_tipo_sensor21'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor21']), $row['gw_tipo_sensor21'], 0, '0', '0', 1, $caGWVersionHW)."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor22'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor22']), $row['gw_tipo_sensor22'], 0, '0', '0', 1, $caGWVersionHW)."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			if ($row['gw_tipo_sensor23'] != "0")
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sConvertir_Datos_GW(hexdec($row['gw_last_sensor23']), $row['gw_tipo_sensor23'], 0, '0', '0', 1, $caGWVersionHW)."</td>";
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			}
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
			echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">-</td>";	
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