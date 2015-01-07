
<?session_start();

$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["objeto_id"];
$cliente_db = $_SESSION["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = "SELECT ".$tabla_name_utcs.".gw_id,".$tabla_name_utcs.".analizador_nombre,".$tabla_name_utcs.".analizador_direccion,".$tabla_name_utcs.".analizador_estado,".$tabla_name_utcs.".analizador_ultima_rx,".$tabla_name_modbus.".modbus_nombre FROM ".$tabla_name_utcs." INNER JOIN ".$db_name_general.".".$tabla_name_modbus." ON ".$tabla_name_utcs.".analizador_tipo=".$tabla_name_modbus.".modbus_id WHERE ".$tabla_name_utcs.".instalacion_id='".$instalacion."'";

$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);

$ancho_1 = '14%';
$ancho_2 = '14%';
$ancho_3 = '24%';
$ancho_4 = '24%';
$ancho_5 = '14%';
$ancho_6 = '10%';

echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general20']."</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['param64']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general38']."</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['param65']."</td>";
echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general23']."</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general153']."</td>";
echo "</tr>";

if(!$result)
{
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td></tr>";
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
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtext\">".$row['analizador_direccion']."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">".$row['analizador_nombre']."</td>";
		echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".$row['modbus_nombre']."</td>";
		if ($row['analizador_estado'] == 0)
		{
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtext\">OFF</td>";
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtext\">ON</td>";
		}
		$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
		echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">"./*$row['analizador_ultima_rx']*/sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['analizador_ultima_rx'],$zona_horaria)."</td>";			
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
