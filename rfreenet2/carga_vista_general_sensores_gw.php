<?php
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';
	include 'inc/funciones_sensores.inc';
	include 'inc/funciones_aux.inc';
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$instalacion = $_GET["instalacion_id"];
	$gw_id = $_GET["gw_id"];
	$gw_tipo = $_GET["gw_tipo"];
	
	//AMB 14/03/2012 Según el tipo de Gw seleccionaremos los sensores de la tabla correspondiente
	if($gw_tipo == $tipo_gw) //GW Normal
	{
		
		$query = sprintf("SELECT gw_id,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9,gw_SN1,gw_SN2,gw_SN3,gw_SN4,gw_SN5,gw_SN6,gw_SN7,gw_SN8,gw_SN9 FROM %s
						   WHERE gw_id='%s'", $tabla_name_params_gateways, $gw_id);
			
	}
	elseif ($gw_tipo == $tipo_gw_low) //GW Low Power
	{
		$query = sprintf("SELECT gw_id");
		
		for($iI = 0; $iI<23; $iI++)
		{
			if($iI < 7)
			{
				$query .= sprintf(", gw_A".$iI."K ");
				
			}	
			if($iI < 16)
			{					
				$query .= sprintf(", gw_D".dechex($iI)."K ");			
			}		
			$query .= sprintf(", gw_SN".($iI)." ");				
		}
		$query .= sprintf("FROM %s",$tabla_name_params_gateways_low);
		
		$query .= sprintf(" WHERE gw_id='%s'",$gw_id);		
	}
	elseif ($gw_tipo == $tipo_gw_lowT) //GW Tragsa
	{
		$query = sprintf("SELECT gw_id,gw_TI1,gw_TI2,gw_TI3,gw_TI4,gw_TI5,gw_TI6 FROM %s",$tabla_name_params_gateways_lowt);

		$query .= sprintf(" WHERE gw_id='%s'",$gw_id);		
	}
		
	mysql_select_db($cliente_db, $link);

	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			echo "<table id=\"sensores\" border=\"1\" style=\"line-height:1em;padding-top:0px;margin-right:0%;\" bgcolor=\"white\">";

			//AMB 14/03/2012 Según el tipo de Gw rellenaremos la tabla de la forma más correcta
			if($gw_tipo == $tipo_gw) //GW Normal
			{
				for($iI = 1; $iI<10; $iI++)
				{
					echo "<tr class=\"RFNETtextborderBold\">";
					echo "<td width=\"100px\" class=\"RFNETtextBold\">Sensor ".($iI)."</td>";		
					if ($row['gw_SN'.$iI] == "")
					{						
						echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor_GW($row['gw_TS'.$iI])."</td>";
					}
					else
					{
						echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".$row['gw_SN'.$iI]."</td>";	
					}
					echo "</tr>";
				}
			}		
			elseif ($gw_tipo == $tipo_gw_low) //GW Low Power
			{
					
					
					for($iI = 0; $iI<13; $iI++)
					{
						echo "<tr class=\"RFNETtextborderBold\">";
						if($iI < 7)
						{
							if($iI < 3)
							{
								echo "<td width=\"100px\" class=\"RFNETtextBold\">0..10V/4-20mA  ".($iI+1)."</td>";	
							}
							else 
							{
								echo "<td width=\"100px\" class=\"RFNETtextBold\">".$idiomas[$_SESSION['opcion_idioma']]['sensor_type4']." ".($iI-2)."</td>";
							}
							
							if ($row['gw_SN'.$iI] == "")
							{
								echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor_GW($row['gw_A'.$iI.'K'])."</td>";		
							}
							else
							{
								echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".$row['gw_SN'.$iI]."</td>";	
							}	
						}
						else
					    {
					    	if($iI < 9)
							{
								echo "<td width=\"100px\" class=\"RFNETtextBold\">".$idiomas[$_SESSION['opcion_idioma']]['sensor_type91']." ".($iI-6)."</td>";
								
								if ($row['gw_SN'.$iI] == "")
								{
									echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor_GW($row['gw_D'.dechex($iI-7).'K'])."</td>";					
								}
								else
								{
									echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".$row['gw_SN'.$iI]."</td>";	
								}	
							}
							else 
							{
								echo "<td width=\"100px\" class=\"RFNETtextBold\">".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." ".($iI-8)."</td>";
								if ($row['gw_SN'.($iI+10)] == "")
								{
									echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor_GW($row['gw_D'.dechex($iI+3).'K'])."</td>";					
								}
								else
								{
									echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".$row['gw_SN'.($iI+10)]."</td>";	
								}	
							}							
														
						}	
						echo "</tr>";			
					}										
					
			}			
			elseif ($gw_tipo == $tipo_gw_lowT) //GW Low Power
			{
				for($iI = 0; $iI<6; $iI++)
				{
					echo "<tr class=\"RFNETtextborderBold\">";
					echo "<td width=\"100px\" class=\"RFNETtextBold\">Sensor ".($iI+1)."</td>";			
					echo "<td align=\"center\" width=\"$ancho_5\" class=\"RFNETtext\">".sObtener_Cadena_Tipo_Sensor_GW($row['gw_TI'.($iI+1)])."</td>";
					echo "</tr>";
				}			
			}			
			
			echo "</table>";
		}
		mysql_free_result($result);
	}	
	mysql_close($link);
?>
