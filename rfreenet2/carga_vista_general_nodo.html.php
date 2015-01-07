
<?php
session_start();
include 'inc/idiomas.inc';

$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["objeto_id"];
$cliente_db = $_SESSION["cliente_db"];

mysql_select_db($cliente_db, $link);
$query = "SELECT cliente_nodos.gw_id,
				 cliente_nodos.nodo_nombre,
				 cliente_nodos.nodo_mac,
				 cliente_nodos.nodo_nombre_s1,
				 cliente_nodos.nodo_nombre_s2,
				 cliente_nodos.nodo_nombre_s3,
				 cliente_nodos.nodo_nombre_s4,
				 cliente_nodos.nodo_nombre_s5,
				 cliente_nodos.nodo_nombre_s6,
				 cliente_params_nodo.gw_id,
				 cliente_params_nodo.nodo_SEN as SEN,
				 cliente_params_nodo.nodo_TS1,
				 cliente_params_nodo.nodo_TS2,
				 cliente_params_nodo.nodo_TS3,
				 cliente_params_nodo.nodo_TS4,
				 cliente_params_nodo.nodo_TS5,
				 cliente_params_nodo.nodo_TS6,
				 cliente_nodos.nodo_ultima_rx 
			FROM cliente_nodos 
	  INNER JOIN cliente_params_nodo ON cliente_params_nodo.nodo_mac=cliente_nodos.nodo_mac 
	  								AND cliente_nodos.gw_id=cliente_params_nodo.gw_id 
	  	   WHERE cliente_nodos.instalacion_id='".$instalacion."' and 
	  	         cliente_nodos.nodo_latitud!=0 and 
	  	         cliente_nodos.nodo_longitud!=0";
//echo $query;

$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);

$ancho_1 = '5%';
$ancho_2 = '10%';
$ancho_3 = '10%';
$ancho_4 = '10%';
$ancho_5 = '15%';
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tabula_datos\">";
echo "<tr>";
echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborderBold\">ID ".$idiomas[$_SESSION['opcion_idioma']]['general20']."</td>";
echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general30']."</td>";
echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general38']."</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 1</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 2</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 3</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 4</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 5</td>";
echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general102']." 6</td>";
echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborderBold\">".$idiomas[$_SESSION['opcion_idioma']]['general153']."</td>";
echo "</tr>";

if(!$result)
{
	echo "<tr class=\"tipo_fila_2\"><td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\"></td><td align=\"center\" width=\"$ancho_5\" class=\"RFNETtextborder\"></td></tr>";
}
else
{
	$vectorSEN=array('1','2','3','4','5','6');
	
	$cuenta_filas = 0;
	while ($row = mysql_fetch_array($result))
	{
		// Calculamos el vector de habilitaciones
		$iAcum=intval($row['SEN']);
		for ($iInd=0;$iInd<6;$iInd++)
		{
			$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
			$iResto=$iAcum%(pow(2,(5-$iInd)));
			if ($comaAux_name == 1)
			{
				$query_aux2.=',';
				$comaAux_name=0;
			}								
			if ($iParcial==0)
			{					
				$vectorSEN[5-$iInd]=0;
			}
			else
			{
				$vectorSEN[5-$iInd]=1;
			}
			$comaAux_name=1;
			$iAcum=$iResto;
}
							
		if ((($cuenta_filas)%2) != 0)
		{
			echo "<tr class=\"tipo_fila_2\">";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\">";
		}
		echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtext\">".$row['gw_id']."</td>";
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtext\">".$row['nodo_mac']."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtext\">".$row['nodo_nombre']."</td>";
		for ($iInd=1;$iInd<7;$iInd++)
		{
			if ($vectorSEN[$iInd-1]!=0)
			{
				if ($row['nodo_nombre_s'.$iInd] == "")
				{
					echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor($row['nodo_TS'.$iInd])."</td>";
				}
				else
				{	
					echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">".$row['nodo_nombre_s'.$iInd]."</td>";
				}
			}
			else
			{
				echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtext\">NO</td>";
			}
		}
		$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
		echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">"./*$row['nodo_ultima_rx']*/sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['nodo_ultima_rx'],$zona_horaria)."</td>";			
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
