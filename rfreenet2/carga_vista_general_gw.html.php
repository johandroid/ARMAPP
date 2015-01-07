<?session_start();
include 'inc/idiomas.inc';

include 'inc/datos_db.inc';
include 'inc/funciones_sensores.inc';
//include 'inc/funciones_db.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
//$instalacion = $_GET["instalacion_id"];
$instalacion = $_GET["objeto_id"];
$cliente_db = $_SESSION["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = "SELECT cliente_gateways.gw_id,
				 cliente_gateways.gw_nombre,
				 cliente_gateways.gw_ip,
				 cliente_gateways.gw_port,
				 cliente_gateways.gw_onoff,
				 cliente_gateways.gw_ultima_rx,
				 cliente_gateways.gw_tipo
			FROM cliente_gateways 		  			  
		   WHERE cliente_gateways.instalacion_id='".$instalacion."'";
		   
//echo $query;

$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);

$ancho_1 = '10%';
$ancho_2 = '10%';
$ancho_3 = '5%';
$ancho_4 = '6%';
$ancho_5 = '6%';
$ancho_6 = '5%';
$ancho_7 = '10%';

		
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">ID</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general38']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general66']."</td>";
//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">Puerto</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general264']."</td>";
echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general152']."</td>";
echo "<td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general153']."</td>";
echo "</tr>";

if(!$result)
{
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td>";
	//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtextborder\"></td>";
	echo "<td align=\"center\" width=\"$ancho_7\" class=\"RFNETtextborder\"></td>";
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
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtext\">".$row['gw_nombre']."</td>";
		if($row['gw_tipo'] == $tipo_gw)
		{
			echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">AC</td>";	
		}
		else if($row['gw_tipo'] == $tipo_gw_low)
		{
			echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">DL</td>";
		}
		else if($row['gw_tipo'] == $tipo_gw_lowT)
		{
			echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">LP</td>";
		}		
		//echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".$row['gw_port']."</td>";
		echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\"><img style=\"width:20px;height:20px\"id='imagen".$row['gw_id']."' src=\"images/flecha_derecha.png\" onmouseover=\"xstooltip_show('".$row['gw_id']."','".$row['gw_tipo']."')\" onmouseout=\"xstooltip_hide('".$row['gw_id']."')\" />";
		if ($row['gw_onoff'] == 0)
		{
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtext\">OFF</td>";
		}
		else
		{
			echo "<td align=\"center\" width=\"$ancho_6\" class=\"RFNETtext\">ON</td>";
		}
		$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
		echo "<td align=\"center\" width=\"$ancho_7\" class=\"RFNETtext\">"./*$row['gw_ultima_rx']*/sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['gw_ultima_rx'],$zona_horaria)."</td>";			
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
