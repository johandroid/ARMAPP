<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	include 'inc/funciones_sensores.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$instalacion = $_GET["instalacion_id"];
	$restoparams = $_GET["restoparams"];
	$grafica = $_GET["grafica"];
	
	mysql_select_db($cliente_db, $link);

	//AMB 13/03/2012 Realizamos una consulta por tipo de GW posible y buscamos los tipos de sensores existentes
	
	//GW NORMAL
	//$query = sprintf("SELECT gw_id,gw_nombre,gw_GPH,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9 FROM %s WHERE instalacion_id='%s'",$tabla_name_params_gateways, $instalacion);
	$query = sprintf("SELECT gw_id, gw_nombre, gw_GPH");
	
	for($iI = 1; $iI<10; $iI++)
	{
		$query .= sprintf(", gw_TS".$iI);
		$query .= sprintf(", gw_A".$iI."UND ");
		$query .= sprintf(", gw_SN".$iI." ");
		$query .= sprintf(", tabla_ud".$iI.".magnitud as unidad_s".$iI." ");
	}
	$query .= sprintf("FROM %s",$tabla_name_params_gateways);
	
	for($iI = 1; $iI<10; $iI++)
	{
		$query .= sprintf(" LEFT OUTER JOIN %s.%s as tabla_ud".$iI." ON gw_A".$iI."UND=tabla_ud".$iI.".cod_unidad", $db_name_general, $tabla_uds_sensores_genericos);
	}
	$query .= sprintf(" WHERE instalacion_id='%s'", $instalacion);
	echo $query;
	
	$result = mysql_query($query,$link);
	if(!$result)
	{
		if(mysql_error($link) != "")
		{
			echo "ERROR ".mysql_error($link);
		}
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			//if ($restoparams == 1)
			//{
			//	echo "<option ID='B".$row['gw_id'].($iInd-1)."' title='Bateria de Gateway ".$row['gw_id']."'>Bateria de ".$nombre_gw."</option>";
			//}
			if ($row['gw_nombre'] !='')
			{
				$nombre_gw=$row['gw_nombre'];
			}
			else
			{
				$nombre_gw=$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$row['gw_id'];
			}
			for ($iInd=1;$iInd<10;$iInd++)
			{
				$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_TS'.$iInd]);
				/*
				if ($row['gw_TS'.$iInd] == "2")
				{
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_TS'.$iInd].pad_izquierda($row["gw_A".$iInd."UND"],2,'0')).$row['gw_TS'.$iInd];
				}
				else 
				{
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_TS'.$iInd]);	
				}
				*/
				$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_TS'.$iInd]);
				if ($sMagnitud == "GENERICO")
				{
					$sMagnitud = $row['unidad_s'.$iInd];
				}
				
				if ($row['gw_nombre'] !='')
				{
					$nombre_gw=$row['gw_nombre'];
				}
				else
				{
					$nombre_gw=$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$row['gw_id'];
				}
				switch ($sNombreSensor)
				{
					default:
						if ($row['gw_SN'.$iInd] != '')
						{
							echo "<option title='".$sNombreSensor." (".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".$iInd.") ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd-1, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$row['gw_SN'.$iInd]."</option>";
						}
						else 
						{
							echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".$iInd." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd-1, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.")</option>";
						}
						
						break;
					case "NO":
						break;
				}
			}
			if($grafica==1)
			{
				echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."00000000000099BAT'>".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_gw."</option>";
				if ($row['gw_GPH'] == '1')
				{
					echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['event_cob_gprs']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."00000000000098COG'>".$idiomas[$_SESSION['opcion_idioma']]['event_cob_gprs']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_gw."</option>";	
				}
			}
		}
	}
	mysql_free_result($result);
	//echo $query;
	
	//GW LOW POWER
	$query = sprintf("SELECT gw_id, gw_nombre");
	
	for($iI = 0; $iI<23; $iI++)
	{
		if($iI < 7)
		{
			$query .= sprintf(", gw_A".$iI."K ");
			
		}		
		if($iI < 3)
		{
			$query .= sprintf(", gw_A".$iI."UND ");
			$query .= sprintf(", tabla_ud".$iI.".magnitud as unidad_s".$iI." ");
		}	
		if($iI<16)
		{			
			$query .= sprintf(", gw_D".dechex($iI)."K ");
		}					
		$query .= sprintf(", gw_SN".$iI." ");		
	}
	$query .= sprintf("FROM %s",$tabla_name_params_gateways_low);
	
	for($iI = 0; $iI<3; $iI++)
	{
		$query .= sprintf(" LEFT OUTER JOIN %s.%s as tabla_ud".$iI." ON gw_A".$iI."UND=tabla_ud".$iI.".cod_unidad", $db_name_general, $tabla_uds_sensores_genericos);
	}

	$query .= sprintf(" WHERE instalacion_id='%s'", $instalacion);
	echo $query;
	$result = mysql_query($query,$link);
	//echo $query;
	if(!$result)
	{	
		echo "ERROR";
	}
	else
	{	
		while($row = mysql_fetch_array($result))
		{
			for ($iInd=0;$iInd<7;$iInd++)
			{		
				$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_A'.$iInd.'K']);
				/*
				if($iInd < 3)
				{
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_A'.$iInd.'K'].$row['gw_A'.$iInd.'UND']);
				}				
				else 
				{
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_A'.$iInd.'K']);
				}
				*/
				$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_A'.$iInd.'K']);
				if ($sMagnitud == "GENERICO")
				{
					$sMagnitud = $row['unidad_s'.$iInd];
				}
				
				
				if ($row['gw_nombre'] !='')
				{
					$nombre_gw=$row['gw_nombre'];
				}
				else
				{
					$nombre_gw=$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$row['gw_id'];
				}				
				switch ($sNombreSensor)
				{
					case "NO":
						break;					
					default:
						if($iInd < 3)
						{
							if ($row['gw_SN'.$iInd] != '')
							{
								echo "<option title='".$sNombreSensor." 0..10V/4-20mA ".($iInd+1)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$row['gw_SN'.$iInd]."</option>";
							}
							else 
							{
								echo "<option title='0..10V/4-20mA ".($iInd+1)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.") ".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".($iInd+1)."</option>";
							}
							
						}
						else 
						{
							if ($row['gw_SN'.$iInd] != '')
							{
								echo "<option title='".$sNombreSensor." ".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".($iInd-2)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$row['gw_SN'.$iInd]."</option>";
							}
							else 
							{
								echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".($iInd-2)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.")</option>";							
							}

						}	
											
						break;
				}								
			}			
			for ($iInd=0;$iInd<16;$iInd++)
			{					
				$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_D'.dechex($iInd).'K']);
				$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_D'.dechex($iInd).'K']);
				
				if ($row['gw_nombre'] !='')
				{
					$nombre_gw=$row['gw_nombre'];
				}
				else
				{
					$nombre_gw=$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$row['gw_id'];
				}						
				switch ($sNombreSensor)
				{
					case "NO":
						break;
					default:
						if($iInd < 2)
						{
							if ($row['gw_SN'.($iInd+7)] != '')
							{
								echo "<option title='".$sNombreSensor." ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." ".($iInd+1)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd+7, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$row['gw_SN'.($iInd+7)]."</option>";
							}
							else 
							{
								echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." ".($iInd+1)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd+7, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.")</option>";							
							}
						}						
						elseif($iInd >= 12 && $iInd <=15)
						{
							if ($row['gw_SN'.($iInd+7)] != '')
							{
								echo "<option title='".$sNombreSensor." ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." ".($iInd-11)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd+7, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$row['gw_SN'.($iInd+7)]."</option>";
							}
							else 
							{
								echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." ".($iInd-11)." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd+7, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.")</option>";
							}											
						}									
						break;

				}								
			}
			if($grafica==1)
				echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."00000000000099BAT'>".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_gw."</option>";
		}
	}

		
	//GW LOW POWER DE TRAGSA
	/*$query = sprintf("SELECT gw_id,gw_nombre,gw_TI1,gw_TI2,gw_TI3,gw_TI4,gw_TI5,gw_TI6 FROM %s WHERE instalacion_id='%s'",$tabla_name_params_gateways_lowt, $instalacion);

	//echo $query;
	$result = mysql_query($query,$link);
	//echo $query;
	if(!$result)
	{
		if(mysql_error($link) != "")
			echo "ERROR ".mysql_error($link);
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			for ($iInd=1;$iInd<7;$iInd++)
			{
				$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_TI'.$iInd]);
				$sMagnitud = sObtener_Cadena_Magnitud_Sensor_GW($row['gw_TI'.$iInd]);
				
				if ($row['gw_nombre'] !='')
				{
					$nombre_gw=$row['gw_nombre'];
				}
				else
				{
					$nombre_gw=$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$row['gw_id'];
				}
				switch ($sNombreSensor)
				{
					default:
						echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".$iInd." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."000000000000".str_pad($iInd-1, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$sNombreSensor." (".$nombre_gw.")</option>";
						break;
					case "NO":
						break;
				}
			}
			if($grafica==1)
				echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$row['gw_id']."' value='G".$row['gw_id']."00000000000099BAT'>".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_gw."</option>";			
		}
	}
									
	
	
	mysql_free_result($result);
 */
			
	//$query = sprintf("SELECT gw_id,nodo_mac,nodo_nombre,nodo_SEN,nodo_NN1,nodo_TS1,nodo_A1UND,nodo_NN2,nodo_TS2,nodo_A2UND,nodo_NN3,nodo_TS3,nodo_A3UND,nodo_NN4,nodo_TS4,nodo_A4UND,nodo_NN5,nodo_TS5,nodo_A5UND,nodo_NN6,nodo_TS6,nodo_A6UND FROM %s WHERE instalacion_id='%s'",$tabla_name_params_nodos, $instalacion);
	$query = sprintf("SELECT gw_id,nodo_mac,nodo_nombre,nodo_SEN,nodo_NN1,nodo_TS1,nodo_A1UND,nodo_NN2,nodo_TS2,nodo_A2UND,nodo_NN3,nodo_TS3,nodo_A3UND,nodo_NN4,nodo_TS4,nodo_A4UND,nodo_NN5,nodo_TS5,nodo_A5UND,nodo_NN6,nodo_TS6,nodo_A6UND, tabla_ud1.magnitud as unidad_s1, tabla_ud2.magnitud as unidad_s2, tabla_ud3.magnitud as unidad_s3, tabla_ud4.magnitud as unidad_s4, tabla_ud5.magnitud as unidad_s5, tabla_ud6.magnitud as unidad_s6  FROM %s LEFT OUTER JOIN %s.%s as tabla_ud1 ON nodo_A1UND=tabla_ud1.cod_unidad LEFT OUTER JOIN %s.%s as tabla_ud2 ON nodo_A2UND=tabla_ud2.cod_unidad LEFT OUTER JOIN %s.%s as tabla_ud3 ON nodo_A3UND=tabla_ud3.cod_unidad LEFT OUTER JOIN %s.%s as tabla_ud4 ON nodo_A4UND=tabla_ud4.cod_unidad LEFT OUTER JOIN %s.%s as tabla_ud5 ON nodo_A5UND=tabla_ud5.cod_unidad LEFT OUTER JOIN %s.%s as tabla_ud6 ON nodo_A6UND=tabla_ud6.cod_unidad WHERE instalacion_id='%s'", $tabla_name_params_nodos, $db_name_general, $tabla_uds_sensores_genericos, $db_name_general, $tabla_uds_sensores_genericos, $db_name_general, $tabla_uds_sensores_genericos, $db_name_general, $tabla_uds_sensores_genericos, $db_name_general, $tabla_uds_sensores_genericos, $db_name_general, $tabla_uds_sensores_genericos, $instalacion);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		if(mysql_error($link) != "")
			echo "ERROR ".mysql_error($link);
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			if ($row['nodo_nombre'] !='')
			{
				$nombre_nodo=$row['nodo_nombre'];
			}
			else
			{
				$nombre_nodo=$row['nodo_mac'];
			}			
					
			//if ($restoparams == 1)
			//{
			//	echo "<option ID='b".$row['nodo_mac'].$NumSensTemp."' title='Cobertura de Nodo ".$nombre_nodo."'>Cobertura de nodo ".$nombre_nodo."</option>";
			//	echo "<option ID='C".$row['nodo_mac'].$NumSensTemp."' title='Cobertura de Nodo ".$nombre_nodo."'>Cobertura de nodo ".$nombre_nodo."</option>";
			//}
			$iAcum=intval($row['nodo_SEN']);
			//echo "_".$iAcum."_";
			for ($iInd=0;$iInd<6;$iInd++)
			{
				$iNumSensATemporal=dechex(5-$iInd);
				$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
				$iResto=$iAcum%(pow(2,(5-$iInd)));
				//echo '('.$iAcum.'/'.(pow(2,(5-$iInd))).')';
				//echo '_'.$iParcial.'_';
				//echo '<'.$iResto.'>';
				$NumSensTemp = sConvertirCharSensor(5-$iInd+1);
				$NumSensIndice = sConvertirCharSensor(5-$iInd);
							
				if ($iParcial!=0)
				{
					if ($row['nodo_NN'.$NumSensTemp] != '')
					{
						$nombre_sensor=$row['nodo_NN'.$NumSensTemp];
					}
					else
					{
						$nombre_sensor = $idiomas[$_SESSION['opcion_idioma']]['general102']." ".(5-$iInd+1)." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_nodo;
					}
					
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor($row['nodo_TS'.$NumSensTemp], $row['nodo_A'.$NumSensTemp."UND"]);
					if ($sMagnitud == "GENERICO")
					{
						$sMagnitud = $row['unidad_s'.$NumSensTemp];
					}
					
					$saVectorSensores[5-$iInd] = "<option title='".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".sObtener_Cadena_Tipo_Sensor($row['nodo_TS'.(5-$iInd+1)])." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$nombre_nodo."' value='N".$row['gw_id'].$row['nodo_mac'].str_pad($NumSensIndice, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$nombre_sensor."</option>";
					//$saVectorSensores[5-$iInd] = "<option title='".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".$row['nodo_TS'.(5-$iInd+1)]."(".(5-$iInd+1).") ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$nombre_nodo."' value='N".$row['gw_id'].$row['nodo_mac'].$NumSensIndice.$sMagnitud."'>".$nombre_sensor."</option>";
				}
				else
				{
					$saVectorSensores[5-$iInd] = '';
				}
				$iAcum=$iResto;
			}
			
			for ($iInd=0;$iInd<6;$iInd++)
			{
				echo $saVectorSensores[$iInd];
			}
			if($grafica==1)
				echo "<option title='".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac']."' value='N".$row['gw_id'].$row['nodo_mac']."99BAT'>".$idiomas[$_SESSION['opcion_idioma']]['supply2']." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_nodo."</option>";
		}
		mysql_free_result($result);
	}
	
	$query = sprintf("SELECT gw_id,analizador_nombre,analizador_id,analizador_vector_magnitudes,modbus_vector_magnitudes,analizador_direccion,analizador_tipo FROM %s INNER JOIN %s.%s ON %s.modbus_id=%s.analizador_tipo  WHERE instalacion_id='%s'",$tabla_name_utcs, $db_name_general, $tabla_name_modbus, $tabla_name_modbus, $tabla_name_utcs, $instalacion);
	
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		if(mysql_error($link) != "")
			echo "ERROR ".mysql_error($link);		
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			if ($row['analizador_nombre'] !='')
			{
				$nombre_utc=$row['analizador_nombre'];
			}
			else
			{
				$nombre_utc=$row['analizador_direccion'];
			}	
			
			$iIndiceSelect = 0;
			$vMagnitudesGuardadas=$row['analizador_vector_magnitudes'];
			$vMagnitudes=$row['modbus_vector_magnitudes'];
			$saVectorSensores = array();
			//echo "_".$vMagnitudesGuardadas."_";
			for ($iInd=0;$iInd<strlen($vMagnitudesGuardadas);$iInd++)
			{
				//echo $iInd."_".substr($vMagnitudesGuardadas,$iInd,1)."_<br>";
				if(substr($vMagnitudesGuardadas,$iInd,1) == '1' && ($iInd<4 || ($iInd>=4 && $_SESSION['perfil']< 3) || ($iInd>=4 && $row['analizador_tipo']!=3)))
				{
					$nombreMagnitud = sObtener_Cadena_Tipo_Sensor_UTC(substr($vMagnitudes,($iInd*4+1),2),substr($vMagnitudes,($iInd*4+3),1));
					//echo $nombreMagnitud;
					/*if(substr($row['modbus_vector_magnitudes'],($iInd*4+3),1) != '0')
					{
						$nombreMagnitud .= " ".substr($vMagnitudes,($iInd*4+3),1);
					}*/
					
					$sMagnitud = sObtener_Cadena_Magnitud_Sensor_UTC(substr($vMagnitudes,($iInd*4+1),2));			
					$saVectorSensores[$iIndiceSelect] = "<option title='".$nombreMagnitud." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$nombre_utc."' value='U".$row['gw_id']."0000000000".$row['analizador_direccion'].str_pad($iInd, 2, "0", STR_PAD_LEFT).$sMagnitud."'>".$nombreMagnitud." ".$idiomas[$_SESSION['opcion_idioma']]['general156']." ".$nombre_utc."</option>";
					
					$iIndiceSelect++;
				}
				
			}
			for ($iInd=0;$iInd<count($saVectorSensores);$iInd++)
			{
				echo $saVectorSensores[$iInd];
			}
		}
		mysql_free_result($result);
	}
		


	mysql_close($link);
?>
