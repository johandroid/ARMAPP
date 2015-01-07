<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/idiomas.inc';	
	include 'inc/datos_db.inc';
	include 'inc/funciones_sensores.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	$iTodos=$_GET['iTodosEnable'];
	
	mysql_select_db($cliente_db, $link);
	
	if ($iTodos == 0)
	{
		echo "<option id='X'>".$idiomas[$_SESSION['opcion_idioma']]['general111']."</option>";
	}
	
	//AMB 12/03/2012 Primero veremos que tipo de GW es.
	$query_tipo_gw = sprintf("SELECT gw_tipo 
							    FROM %s
							   WHERE gw_id = '%s'", $tabla_name_gateways, $gw_id);
		
	//AMB 12/03/2012 Según el tipo de GW seleccionaremos sus sensores para ver su valor y obtener los tipos existentes.
	if ($gw_id!='000')
	{
		$result_tipo_gw = mysql_query($query_tipo_gw,$link);
		
		if(!$result_tipo_gw)
		{
			echo "ERROR";
		}
		else
		{
			if($row_tipo_gw = mysql_fetch_array($result_tipo_gw))
			{
				if($row_tipo_gw['gw_tipo'] == '0')
				{
					$query = sprintf("SELECT gw_id,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9,gw_SN1,gw_SN2,gw_SN3,gw_SN4,gw_SN5,gw_SN6,gw_SN7,gw_SN8,gw_SN9 FROM %s",$tabla_name_params_gateways);
					if ($gw_id!='000')
					{
						$query .= sprintf(" WHERE gw_id='%s'",$gw_id);
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
								for ($iInd=1;$iInd<10;$iInd++)
								{
									//echo $row['gw_TS'.$iInd]." ";
									$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_TS'.$iInd]);
									//echo $sNombreSensor." ";
									switch ($sNombreSensor)
									{
										default:
											if ($row['gw_SN'.$iInd] != '')
											{
												echo "<option id='".$iInd."'>".$row['gw_SN'.$iInd]." (S".$iInd.")</option>";
											}
											else 
												{
												echo "<option id='".$iInd."'>".$sNombreSensor." (S".$iInd.")</option>";
											}

											break;
										case "NO":
											break;
									}
								}
							}
						}
					}					
				}
				elseif($row_tipo_gw['gw_tipo'] == '1')
				{
					
					$query = sprintf("SELECT gw_id");
					
					for($iI = 0; $iI<23; $iI++)
					{
						if($iI < 7)
						{
							$query .= sprintf(", gw_A".$iI."K ");
							
						}	
						if($iI<16)
						{					
							$query .= sprintf(", gw_D".dechex($iI)."K ");
						}		
						$query .= sprintf(", gw_SN".($iI)." ");					
						
					}
					$query .= sprintf("FROM %s",$tabla_name_params_gateways_low);
					
					if ($gw_id!='000')
					{
						$query .= sprintf(" WHERE gw_id='%s'",$gw_id);
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
								for ($iInd=0;$iInd<7;$iInd++)
								{
									$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_A'.$iInd.'K']);
									if($sNombreSensor!= 'NO')
									{
										switch ($iInd)
										{
											case 0:
											case 1:
											case 2:
												if ($row['gw_SN'.($iInd)] != '')
												{
													//echo "<option id='".($iInd+1)."'>".$row['gw_SN'.$NumSensTemp]." (S".$iInd.")</option>";
													echo "<option id='".($iInd+1)."'> ".$row['gw_SN'.($iInd)]." </option>";
												}
												else 
												{
													echo "<option id='".($iInd+1)."'>  S".($iInd+1)." - ".$sNombreSensor." </option>";												
												}
												break;
											default:
												if ($row['gw_SN'.($iInd)] != '')
												{
													//echo "<option id='".($iInd+1)."'>".$row['gw_SN'.$NumSensTemp]." (S".$iInd.")</option>";
													echo "<option id='".($iInd+1)."'> ".$row['gw_SN'.($iInd)]." </option>";
												}
												else 
												{
													echo "<option id='".($iInd+1)."'> A".($iInd-2)." - ".$sNombreSensor." </option>";
												}

												break;										
										}
									}								
								}
								for ($iInd=0;$iInd<16;$iInd++)
								{								
									$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_D'.dechex($iInd).'K']);
									if($sNombreSensor!= 'NO')
									{									
										switch ($iInd)
										{
											case 0:
											case 1:
												if ($row['gw_SN'.($iInd+7)] != '')
												{
													//echo "<option id='".($iInd+1)."'>".$row['gw_SN'.$NumSensTemp]." (S".$iInd.")</option>";
													echo "<option id='".($iInd+8)."'> ".$row['gw_SN'.($iInd+7)]." </option>";
												}
												else 
												{
													echo "<option id='".($iInd+8)."'>  P".($iInd+1)." - ".$sNombreSensor." </option>";
												}
												break;
											case 12:
											case 13:
											case 14:
											case 15:		
												if ($row['gw_SN'.($iInd+7)] != '')
												{
													//echo "<option id='".($iInd+1)."'>".$row['gw_SN'.$NumSensTemp]." (S".$iInd.")</option>";
													echo "<option id='".($iInd+8)."'> ".$row['gw_SN'.($iInd+7)]." </option>";
												}
												else 
												{
													echo "<option id='".($iInd+8)."'> D".($iInd-11)." - ".$sNombreSensor." </option>";
												}										
												
												break;
											case "NO":
											default:
												break;
									
										}
									}								
								}
							}
						}
					}										
				}
				elseif($row_tipo_gw['gw_tipo'] == '2')
				{
					$query = sprintf("SELECT gw_id,gw_TI1,gw_TI2,gw_TI3,gw_TI4,gw_TI5,gw_TI6 FROM %s",$tabla_name_params_gateways_lowt);
					if ($gw_id!='000')
					{
						$query .= sprintf(" WHERE gw_id='%s'",$gw_id);
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
								for ($iInd=1;$iInd<7;$iInd++)
								{
									$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($iInd);
									switch ($sNombreSensor)
									{
										default:
											echo "<option id='".$iInd."'>".$sNombreSensor."</option>";
											break;
										case "NO":
											break;
									}
								}
							}
						}
					}									
				}
			}
		}
	}
	mysql_free_result($result);
	mysql_close($link);
?>
