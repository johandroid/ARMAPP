<?php
session_start();
define('NUM_DECIMALES_HUMEDAD',3);
define('NUM_DECIMALES_BATERIA',2);
define('NUM_DECIMALES_TEMPERATURA',1);
define('NUM_DECIMALES_VOLTAJE',3);
define('NUM_DECIMALES_VELOCIDAD',2);
define('NUM_DECIMALES_CONDUCTIVIDAD',3);
define('NUM_DECIMALES_TENSION',3);
define('NUM_DECIMALES_VIENTO',1);
define('NUM_DECIMALES_LLUVIA',2);
define('NUM_DECIMALES_PRESION',1);
define('NUM_DECIMALES_DIRECCION_VIENTO',1);
define('NUM_DECIMALES_PH',2);
define('NUM_DECIMALES_OXIGENO_DISUELTO',1);
define('NUM_DECIMALES_PYR',3);
define('NUM_DECIMALES_TURBIDEZ',3);
define('NUM_DECIMALES_CLORO',2);
define('NUM_DECIMALES_GENERICO',2);
define('NUM_DECIMALES_COBERTURA',1);


function sConvertir_Datos_Nodo($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $sTipoMedida, $iSacarCadena, $sOperacion, $sConstante, $sGwId, $sNodoIP, $iNumSensor)
{
	include 'inc/idiomas.inc';
	$dPreCalculador=0.0;
    $dCalculador=0.0;
    $iEnteroAux=0;
    $sResultado="0";

    if (strlen($sDatosAux) > 0)
    {
	    if (strlen($sTipoSensorAux) == 3)
	    {
    	 	if ($sTipoSensorAux == "OUT")
			{
				if ($iSacarCadena == 0)
				{
					$sResultado = $sDatosAux;
				}
				else
				{
					if ($sDatosAux == 0)
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general378'];
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general377'];
					}
				}
			}
			else if ($sTipoSensorAux == "BAT")
	        {
	            $dPreCalculador = round(($sDatosAux * 3) / 1024, NUM_DECIMALES_BATERIA);
	            if ($iMostrarUnidades==0)
	            {
	            	$sResultado = $dPreCalculador." V";
	            }
	            else
	            {
	            	$sResultado = $dPreCalculador.'';
	            }
	        }
	        else if ($sTipoSensorAux == "COB")
	        {
	        	$sResultado = $sDatosAux;
	        	if ($iMostrarUnidades==0)
	            {
	            	$sResultado.=' %';
	            }
	        }
	        else
	        {
	            switch (substr($sTipoSensorAux, 0, 1))
	            {
	                // si es analogica
	                case '1':	                
	                    switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        // ECHO-5
	                        case '1':
	                        	//return "ECHO5";
	                            $dPreCalculador = ($sDatosAux * 3000) / 1024;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(($dPreCalculador * 0.00116), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									$dCalculador = round((($dPreCalculador * 0.00116) - 0.48), NUM_DECIMALES_HUMEDAD);	
								}	                           	
	                           	$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');     
	                            if ($dCalculador > 0)
	                            {
	                                $sResultado = $dCalculador."";
	                            }
	                            else
	                            {
	                                $sResultado = "0";
	                            }
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" %";
	            				}
	                            break;
	
	                        // ECHO-10
	                        case '2':
	                            $dPreCalculador = ($sDatosAux * 3000) / 1024;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(($dPreCalculador * 0.00078), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									$dCalculador = round((($dPreCalculador * 0.00078) - 0.376), NUM_DECIMALES_HUMEDAD);	
								}	                            
	                            $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
	                            if ($dCalculador > 0)
	                            {
	                                $sResultado = $dCalculador."";
	                            }
	                            else
	                            {
	                                $sResultado = "0";
	                            }
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" %";
	            				}
	                            break;
	
	                        // ECHO-20
	                        case '3':
	                            $dPreCalculador = ($sDatosAux * 3000) / 1024;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(($dPreCalculador * 0.000579), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									$dCalculador = round((($dPreCalculador * 0.000579) - 0.29), NUM_DECIMALES_HUMEDAD);	
								}	                            
	                            $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
	                            if ($dCalculador > 0)
	                            {
	                                $sResultado = $dCalculador."";                                        
	                            }
	                            else
	                            {
	                                $sResultado = "0";
	                            }
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" %";
	            				}
	                            break;
	
	                        // 10HS
	                        case '4':
	                            $dPreCalculador = ($sDatosAux * 3000) / 1024;
								if ($sTipoMedida == 'G')
								{
									//$dCalculador = round((($dPreCalculador * $dPreCalculador * 0.000000584) - (0.000201*$dPreCalculador)), NUM_DECIMALES_HUMEDAD);
									$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.00000000297) - ($dPreCalculador * $dPreCalculador * 0.00000737) + (0.00669*$dPreCalculador)), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									//$dCalculador = round((($dPreCalculador * $dPreCalculador * 0.000000584) - (0.000201*$dPreCalculador) - 0.0582), NUM_DECIMALES_HUMEDAD);	
									$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.00000000297) - ($dPreCalculador * $dPreCalculador * 0.00000737) + (0.00669*$dPreCalculador) - 1.92), NUM_DECIMALES_HUMEDAD);
								}	                            
	                            $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
	                            if ($dCalculador > 0)
	                            {
	                                $sResultado = $dCalculador."";
	                            }
	                            else
	                            {
	                                $sResultado = "0";
	                            }
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" %";
	            				}
	                            break;
	
	                        // LM61
	                        case '5':
	                            $dPreCalculador = ($sDatosAux * 3000) / 1024.0;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(($dPreCalculador * 0.1), NUM_DECIMALES_TEMPERATURA);
								}
								else 
								{
									$dCalculador = round(($dPreCalculador * 0.1) - 60, NUM_DECIMALES_TEMPERATURA);	
								}
	                            $sResultado = $dCalculador."";
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" ºC";
	            				}
	                            break;
	
	                        // DSFW (FLUJO AIRE)
	                        case '6':
	                            $dCalculador = round((0.621 * log((($sDatosAux * 3) / 1024.0), exp(1))), NUM_DECIMALES_VELOCIDAD);
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado = $dCalculador+ " m/s";
	            				}
			                    else
					            {
					            	$sResultado = $dCalculador.'';
					            }
	                            break;
								
							// Temperatura del agua 107
	                        case '7':
	                            $dPreCalculador = log((1000000*3/((($sDatosAux * 3) / 1024.0) + 0.065))-1249000,M_E);
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round((1/((0.0008271111+(0.000208802*$dPreCalculador)+(0.000000080592*$dPreCalculador*$dPreCalculador*$dPreCalculador)))), NUM_DECIMALES_TEMPERATURA);
								}
								else 
								{
									$dCalculador = round((1/((0.0008271111+(0.000208802*$dPreCalculador)+(0.000000080592*$dPreCalculador*$dPreCalculador*$dPreCalculador))))-273.15, NUM_DECIMALES_TEMPERATURA);	
								}
	                            $sResultado = $dCalculador."";
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado.=" ºC";
	            				}
	                            break;
								
							// Radiación Solar SRS100
	                        case '8':
								$dCalculador = round((($sDatosAux * 3000) / 1024.0)/1.67, NUM_DECIMALES_PYR);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' W/m2';
					            }
	                            break;
							// HI 98143 pH
							case '9':
	                            $dCalculador = round((14*($sDatosAux * 3 / 1024.0)), NUM_DECIMALES_PH);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' pH';
					            }
	                            break;
								
							// Conductividad 98143 pH
							case 'A':
	                            $dCalculador = round((10*($sDatosAux * 3 / 1024.0)), NUM_DECIMALES_CONDUCTIVIDAD);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' uS/cm';
					            }
	                            break;
							// Temperatura Watermark 200TS
							case 'B':
							// Temperatura EC-T Decagon
							case 'C':
								if ($sDatosAux == 0)
								{
									$dCalculador = 0;
								}
								else 
								{
									$dPreCalculador = log((3000/((1000*$sDatosAux * 3) / 1024.0))-1);
		                            $dCalculador = round((25.02-22.84*$dPreCalculador)+(1.532*$dPreCalculador*$dPreCalculador)-(0.08372*$dPreCalculador*$dPreCalculador*$dPreCalculador), NUM_DECIMALES_TEMPERATURA);
								}
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' ºC';
					            }
	                            break;
	                        // Generico
	                        default:
								$vDatosSensorGenerico = vObtenerDatosSensorGenericoNodo($sGwId, $sNodoIP, $iNumSensor); 
								$sResultado = sConvertir_Datos_Nodo_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $vDatosSensorGenerico[0], $vDatosSensorGenerico[1], $vDatosSensorGenerico[3]);
	                            break;
	                    }
	                    break;
	
	                // si es entrada digital
	                case '2':
	                    switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        // Presencia
	                        case '1':
	                        	$sResultado = $sDatosAux;
	                            break;
	
	                        // Pulsador
	                        case '2':
	                        	$sResultado = $sDatosAux;
	                            break;
								
							// Nivel
	                        case '3':
								$sResultado = $sDatosAux;
								if ($iSacarCadena != 0)
								{
									if (intval($sResultado) == 1)
									{
										$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general337'];
									}
									else 
									{
										$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general338'];
									}
								}
	                            break;
		
	                        // Generico
	                        default:
	                        	$sResultado = $sDatosAux;
	                            break;
	                    }
	                    break;
						
					// VELETA DAVIS
					case 'B':
	                case 'b':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        default:
								$dCalculador = round($sDatosAux, NUM_DECIMALES_DIRECCION_VIENTO);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' º';
					            }
	                            break;
	                    }
						break;
	
	                // WATERMARK
					case '3':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                    	// Conductividad del agua CS547A
	                    	case '1':
								$dPreCalculador = $sDatosAux / 1024.0;
								$dCalculador = round(1.408*0.99124*$dPreCalculador/(1-$dPreCalculador), NUM_DECIMALES_CONDUCTIVIDAD);
								if ($dCalculador < 0) $dCalculador=0;
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
		            			{
		                            $sResultado .= " dS/m";
		            			}
	                            break;
								
	                    	// Generico
	                        default:
								$dPreCalculador = ($sDatosAux * 3) / 1024.0;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(((7.407*($dPreCalculador-0.55))/(3-$dPreCalculador)), NUM_DECIMALES_PRESION);
								}
								else 
								{
									$dCalculador = round(((7.407*($dPreCalculador-0.55))/(3-$dPreCalculador))-3.704, NUM_DECIMALES_PRESION);	
								}
								if ($dCalculador < 0) $dCalculador=0;
								if ($dCalculador > 200) $dCalculador=200;
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
		            			{
		                            $sResultado .=" kPa";
		            			}
		                        break;
						}
						break;
	
	                // si es 4-20
	                case '4':
	                case 'D':
	                case 'd':
	                    switch (substr($sTipoSensorAux, 2, 1))
	                    {
							case '0':												
								$vDatosSensorGenerico = vObtenerDatosSensorGenericoNodo($sGwId, $sNodoIP, $iNumSensor); 
				    			
								$sResultado = sConvertir_Datos_Nodo_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $vDatosSensorGenerico[0], $vDatosSensorGenerico[1], $vDatosSensorGenerico[3]);
																
								break;							
	                    	// pH
	                    	case '1':
								$dPreCalculador =$sDatosAux * (125/(4096*6));
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(0.875*($dPreCalculador), NUM_DECIMALES_PH);
								}
								else 
								{
									$dCalculador = round(((0.875*($dPreCalculador-4))+3), NUM_DECIMALES_PH);	
								}
								if ($dCalculador < 0) $dCalculador=0;
				            		$sResultado = $dCalculador.'';
								if ($iMostrarUnidades==0)
						    	{
					    			$sResultado .= " pH";
						    	}
	                            break;
								
							// Oxigeno disuelto
	                    	case '2':
								$dPreCalculador =$sDatosAux * (125/(4096*6));
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(2*6.25*($dPreCalculador), NUM_DECIMALES_OXIGENO_DISUELTO);
								}
								else 
								{
									$dCalculador = round(2*6.25*($dPreCalculador-4), NUM_DECIMALES_OXIGENO_DISUELTO);	
								}
								if ($dCalculador < 0) $dCalculador=0;
								$sResultado = $dCalculador."";
				            	if ($iMostrarUnidades==0)
						    	{
					    			$sResultado .= " %";
						    	}
	                            break;
						 	// Oxigeno disuelto HI 8410
	                        case '3':
								$dPreCalculador =$sDatosAux * (125/(4096*6));
																
								if ($sTipoMedida == 'G')
								{
									$dCalculador = 600*($dPreCalculador)/16;
								}
								else 
								{
									$dCalculador = 600*($dPreCalculador)/16 - 150;	
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_OXIGENO_DISUELTO);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_OXIGENO_DISUELTO);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;
								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " %";
						    	}
	                            break;
								
							 // Conductividad HI 8936DL
	                        case '4':
	                        	$dPreCalculador =$sDatosAux * (125/(4096*6));
	                        	if ($sTipoMedida == 'G')
								{
									$dCalculador = (12.5*($dPreCalculador));
								}
								else 
								{
									$dCalculador = (12.5*$dPreCalculador)-50;	
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_CONDUCTIVIDAD);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_CONDUCTIVIDAD);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " uS/cm";
						    	}
	                            break;
								
							 // "HI 8711 pH"
	                        case '5':
								
	                        	$dPreCalculador =$sDatosAux * (125/(4096*6));
	                        	if ($sTipoMedida == 'G')
								{
									$dCalculador = (0.875*($dPreCalculador));
								}
								else 
								{									
									$dCalculador = (0.875*$dPreCalculador)-3.5;
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_PH);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_PH);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " pH";
						    	}
	                            break;
								
							// Turbidez 7685
	                        case '6':
	                       	 	$dPreCalculador =$sDatosAux * (125/(4096*6));
	                        	if ($sTipoMedida == 'G')
								{
									$dCalculador = (25*($dPreCalculador));
								}
								else 
								{
									$dCalculador = ((25*$dPreCalculador)-100);	
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_TURBIDEZ);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_TURBIDEZ);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " NTU";
						    	}
	                            break;
								
							// HI 8615L ORP
	                        case '7':
	                        	$dPreCalculador =$sDatosAux * (125/(4096*6));
	                        	if ($sTipoMedida == 'G')
								{
									$dCalculador = (0.125*($dPreCalculador));
								}
								else 
								{
									$dCalculador = (0.125*$dPreCalculador)-1.5;	
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_PH);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_PH);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " mV";
						    	}
	                            break;
								
							// Jumo Midas Presión 0..10 Ba
	                        case '8':
	                        	$dPreCalculador =$sDatosAux * (125/(4096*6));
	                        	if ($sTipoMedida == 'G')
								{
									$dCalculador = (0.625*($dPreCalculador));
								}
								else 
								{
									$dCalculador = (0.625*$dPreCalculador)-2.5;	
								}
								if($sOperacion == '0')
								{
									$dPreCalculador = round($dCalculador*$sConstante, NUM_DECIMALES_PRESION);
								}
								else 
								{
									$dPreCalculador = round($dCalculador/$sConstante, NUM_DECIMALES_PRESION);
								}
								if($dPreCalculador < 0) // AMB 22/05/12 No puede ser negativo
									$dPreCalculador = 0;								
								$sResultado = $dPreCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " Ba";
						    	}
	                            break;
								
	                        default:
								$dCalculador = round($sDatosAux * (125/(4096*6)), NUM_DECIMALES_VOLTAJE);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
							    {
					   				$sResultado .= " mA";
						    	}
								break;
	                    }
	                    break;

					// Si es 0..10V
					case 'C':
	                case 'c':
			    		switch (substr($sTipoSensorAux, 2, 1))
	                    {
							case '0':												
								$vDatosSensorGenerico = vObtenerDatosSensorGenericoNodo($sGwId, $sNodoIP, $iNumSensor); 
				    			
								$sResultado = sConvertir_Datos_Nodo_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $vDatosSensorGenerico[0], $vDatosSensorGenerico[1], $vDatosSensorGenerico[3]);
																
								break;	                    	
	                    	//NO2 uGard
							case '1':
								if($sOperacion == '0')
								{
									$dCalculador = round((20.3*2*($sDatosAux * (3/(1024))*3.3)*$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								else 
								{
									$dCalculador = round((20.3*2*($sDatosAux * (3/(1024))*3.3)/$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
							    {
					  				$sResultado .= " mg/m3";
								}
	                            break;
							//NO uGard
							case '2':
								if($sOperacion == '0')
								{
									$dCalculador = round((1.32*2.5*($sDatosAux * (3/(1024))*3.3)*$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								else 
								{
									$dCalculador = round((1.32*2.5*($sDatosAux * (3/(1024))*3.3)/$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
							    {
					  				$sResultado .= " mg/m3";
								}
	                            break;
							//CO uGard
							case '3':
								if($sOperacion == '0')
								{
									$dCalculador = round((1.23*30*($sDatosAux * (3/(1024))*3.3)*$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								else 
								{
									$dCalculador = round((1.23*30*($sDatosAux * (3/(1024))*3.3)/$sConstante), NUM_DECIMALES_TURBIDEZ);
								}
								
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
							    {
					  				$sResultado .= " mg/m3";
								}
	                            break;
	                        default:
								$dCalculador = round($sDatosAux * (43/(4096*4)), NUM_DECIMALES_VOLTAJE);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
							    {
					  				$sResultado .= " V";
								}
	                            break;
	                    }
	                    break;
	
	                // si es salida digital
	                case '5':	                
	                    switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        default:
	                        	$sResultado = $sDatosAux;
	                            break;
	                    }
	                    break;
						
					// si es contador de pulsos
					case '7':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
							// Pluviómetro
	                    	case '1':
								$dCalculador = round(($sDatosAux * 0.2), NUM_DECIMALES_LLUVIA);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' mm';
					            }
								break;
				                    
				            // Anemometro Davis
							case '2':
								$dCalculador = round(($sDatosAux * 1.006 * 3.6/100), NUM_DECIMALES_VIENTO);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
					            {
									$sResultado .= ' km/h';
					            }
	                            break;
							
	                        default:
								$sResultado = $sDatosAux;
								break;
						}
						break;
	
	                // Si es sensirion
	                case '6':
	                    switch (substr($sTipoSensorAux, 1, 1))
	                    {
	                        // SENSIRION SHT1X (Humedad)
	                        case '2':
							case '4':
							case '6':
	                            $dCalculador = round(($sDatosAux / 100.0), NUM_DECIMALES_HUMEDAD);
								$sResultado = $dCalculador."";
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado .= " %";
	            				}
	                            break;
	
	                        // SENSIRION SHT1X (Temperatura)
	                        case '1':
							case '3':
							case '5':
	                            $dCalculador = round(($sDatosAux / 100.0) - 100, NUM_DECIMALES_TEMPERATURA);
								if ($dCalculador > 100)
								{
									$dCalculador = 0;
								}
								$sResultado = $dCalculador."";
	                            if ($iMostrarUnidades==0)
	            				{
	                            	$sResultado .= " ºC";
	            				}
	                            break;
	                        // Generico
	                        default:
	                            $sResultado = $sDatosAux;
	                            break;
	                    }
	                    break;
						
					// Rotación de motor
					case 'E':
	                case 'e':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        default:
	                        	$sResultado = $sDatosAux;
	                            break;
	                    }
						if ($iMostrarUnidades==0)
						{
							$sResultado.=" rpm";
						}
						break;
	                    
	                // Humedad Digital
	                case '8':	                	
	                	switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                    	// GS3 Suelo Mineral
							case '4':
								$dPreCalculador = $sDatosAux / 100;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.00000589) - ($dPreCalculador * $dPreCalculador * 0.000762) + (0.0367 * $dPreCalculador)), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.00000589) - ($dPreCalculador * $dPreCalculador * 0.000762) + (0.0367 * $dPreCalculador) - 0.0753), NUM_DECIMALES_HUMEDAD);	
								}
								$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								break;	
																
	                    	// GS3 Turba/Perlite
							case '5':									
								$dPreCalculador = $sDatosAux / 100;
								if ($sTipoMedida == 'G')
								{
									$dCalculador = round(0.118*sqrt($dPreCalculador), NUM_DECIMALES_HUMEDAD);
								}
								else 
								{
									$dCalculador = round(0.118*sqrt($dPreCalculador) - 0.117, NUM_DECIMALES_HUMEDAD);	
								}
								$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								break;
								
							// VP3 Humedad
							case '6':
								$dCalculador = round($sDatosAux / 100, NUM_DECIMALES_HUMEDAD);									
								break;
									
	                    	// 5TE Turba
							case '1':
								if ($sDatosAux >= 4094)
								{
									$dCalculador = 0;
								}
								else
								{
									$dPreCalculador = $sDatosAux / 50;
									if ($sTipoMedida == 'G')
									{
										$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.0000225) - ($dPreCalculador * $dPreCalculador * 0.00206) + (0.0724 * $dPreCalculador)), NUM_DECIMALES_HUMEDAD);
									}
									else 
									{
										$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.0000225) - ($dPreCalculador * $dPreCalculador * 0.00206) + (0.0724 * $dPreCalculador) - 0.247), NUM_DECIMALES_HUMEDAD);	
									}
									$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								}
								break;
									
							// 5TE Lana Roca
							case '2':
								if ($sDatosAux >= 4094)
								{
									$dCalculador = 0;
								}
								else
								{
									$dPreCalculador = $sDatosAux / 50;
									if ($sTipoMedida == 'G')
									{
										$dCalculador = round((-($dPreCalculador * $dPreCalculador * 0.00168) + (0.0656 * $dPreCalculador)), NUM_DECIMALES_HUMEDAD);
									}
									else 
									{
										$dCalculador = round((-($dPreCalculador * $dPreCalculador * 0.00168) + (0.0656 * $dPreCalculador) + 0.0266), NUM_DECIMALES_HUMEDAD);	
									}
									$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								}
								break;
									
							// 5TE Perlite
							case '3':
								if ($sDatosAux >= 4094)
								{
									$dCalculador = 0;
								}
								else
								{	
									$dPreCalculador = $sDatosAux / 50;
									if ($sTipoMedida == 'G')
									{
										$dCalculador = round((-($dPreCalculador * $dPreCalculador * 0.00107) + (0.0525 * $dPreCalculador)), NUM_DECIMALES_HUMEDAD);
									}
									else 
									{
										$dCalculador = round((-($dPreCalculador * $dPreCalculador * 0.00107) + (0.0525 * $dPreCalculador) - 0.0685), NUM_DECIMALES_HUMEDAD);	
									}
									$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								}
								break;
									
							// 5TE Suelo Mineral
							case '0':
	                    	default:
								if ($sDatosAux >= 4094)
								{
									$dCalculador = 0;
								}
								else
								{
									$dPreCalculador = $sDatosAux / 50;
									if ($sTipoMedida == 'G')
									{
										$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.0000043) - ($dPreCalculador * $dPreCalculador * 0.00055) + (0.0292 * $dPreCalculador)), NUM_DECIMALES_HUMEDAD);
									}
									else 
									{
										$dCalculador = round((($dPreCalculador * $dPreCalculador * $dPreCalculador * 0.0000043) - ($dPreCalculador * $dPreCalculador * 0.00055) + (0.0292 * $dPreCalculador) - 0.053), NUM_DECIMALES_HUMEDAD);	
									}
									$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
								}
								break;
	                    }																						
						if ($dCalculador > 0)
						{
							$sResultado = $dCalculador."";
						}
						else
						{
							$sResultado = "0";
						}
						if ($iMostrarUnidades==0)
						{
							$sResultado.=" %";
						}
						break;
				
					// Conductividad Digital / Presión Atm.
					case '9':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                    	// VP3 Presión
							case '2':
								$dCalculador = round($sDatosAux / 100, NUM_DECIMALES_PRESION);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
			            		{
			                          $sResultado .= " kPa";
			            		}
								break;
									
	                    	//GS3
							case '1':
								if ($sDatosAux > 65536)
								{
									$sResultado = "0";
								}
								else
								{									
									$dCalculador = round($sDatosAux / 10000, NUM_DECIMALES_CONDUCTIVIDAD);
									
									$sResultado = $dCalculador."";
								}
								if ($iMostrarUnidades==0)
								{
									$sResultado .= " dS/m";
								}
								break;
							case '0':
							default:
								//5TE
								if ($sDatosAux >= 1023)
								{
									$sResultado = "0";
								}
								else
								{
									$dPreCalculador = $sDatosAux;
									if ($sDatosAux <= 700)
									{
										$dCalculador = round($dPreCalculador / 100, NUM_DECIMALES_CONDUCTIVIDAD);
									}
									else
									{
										if ($sTipoMedida == 'G')
										{
											$dCalculador = round(((5 * $dPreCalculador) / 100), NUM_DECIMALES_CONDUCTIVIDAD);
										}
										else 
										{
											$dCalculador = round((((5 * $dPreCalculador) - 2800) / 100), NUM_DECIMALES_CONDUCTIVIDAD);	
										}
									}
									$sResultado = $dCalculador."";
								}
								if ($iMostrarUnidades==0)
								{
									$sResultado .= " dS/m";
								}								
								break;
						}
					break;
					// 5TE Temperatura
					case 'A':
					case 'a':
						switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                    	//GS3
							case '1':
								if ($sDatosAux < -4000 || $sDatosAux > 5000)
								{
									$sResultado = "0";
								}
								else
								{								
									$dCalculador = round(($sDatosAux / 100), NUM_DECIMALES_TEMPERATURA);
									
									$sResultado = $dCalculador."";
								}
								if ($iMostrarUnidades==0)
			            		{
			                          $sResultado .= " ºC";
			            		}
								break;
								
							// VP3
							case '2':
								$dCalculador = round($sDatosAux / 100, NUM_DECIMALES_HUMEDAD);
								$sResultado = $dCalculador."";
								if ($iMostrarUnidades==0)
			            		{
			                          $sResultado .= " ºC";
			            		}									
								break;
								
							case '0':
							default:
								if ($sDatosAux >= 1023)
								{
									$sResultado = "0";
								}
								else
								{
									if ($sTipoMedida == 'G')
									{
										$dCalculador = round(($sDatosAux / 10), NUM_DECIMALES_TEMPERATURA);
									}
									else 
									{
										$dCalculador = round(($sDatosAux - 400) / 10, NUM_DECIMALES_TEMPERATURA);	
									}
									$sResultado = $dCalculador."";
								}
								if ($iMostrarUnidades==0)
			            		{
			                          $sResultado .= " ºC";
			            		}
								break;
						}						
					break;
						
					// si es AMR
	                case 'F':
	                case 'f':
	                    switch (substr($sTipoSensorAux, 2, 1))
	                    {
	                        // Generico
	                        default:
	                        	$sResultado = $sDatosAux;
	                            break;
	                    }
	                    break;
	
	                // en caso de no ser ninguno conocido
	                default:
	                	$sResultado = $sDatosAux;
	                    break;
	            }
	        }
	    }
	    else
	    {
	    	$sResultado = $sDatosAux;	
	    }
    }
    return $sResultado;
}

function sConvertir_Datos_GW($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $sGwId, $iNumSensor, $iSacarCadena, $caGWVersionHW)
{
	include 'inc/idiomas.inc';
	$dCalculador=0.0;
    $iEnteroAux=0;
    $sResultado="0";
	$vDatosSensorGenerico[4];
	
	switch (intval($caGWVersionHW, 10))
	{		
		case 12:
			$iResGW1 = 4096;
			$iResGW2 = 4096;
			break;
		case 11:
			$iResGW1 = 256;
			$iResGW2 = 4096;
			break;
		case 10:
		default:
			$iResGW1 = 256;
			$iResGW2 = 256;
			break;
	}
	
    if (strlen($sDatosAux) > 0)
    {
        switch ($sTipoSensorAux)
        {
			case "OUT":
				if($iSacarCadena==0)
				{
					$sResultado = $sDatosAux;
				}
				else
				{
					if($sDatosAux == 0)
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general378'];
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general377'];
					}
				}
				break;
				
			case "COB":
	        	$sResultado = round(($sDatosAux / (10.0)), NUM_DECIMALES_COBERTURA);
				break;
			
     		//Alimentacion
            case "ALI":
                $sResultado = $sDatosAux;
                break;

            // Bateria
            case "BAT":
                $dCalculador = round(($sDatosAux * 15.761) / $iResGW1, NUM_DECIMALES_BATERIA);
                $sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" V";
				}
                break;
			//Humedad
  			case "7":
				$dCalculador = round((($sDatosAux *(3.3*40)) / $iResGW1), NUM_DECIMALES_HUMEDAD);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" %";
				}
				break;
			//Humedad Low Power
  			case "30":
				
				$dCalculador = round($sDatosAux * 4 / 100, NUM_DECIMALES_HUMEDAD);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" %";
				}
				break;			
            //Pluviometro
            case "8":
				$dCalculador = round(($sDatosAux * 0.2), NUM_DECIMALES_LLUVIA);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" mm";
				}
				break;
                    
            // Anemometro Davis
			case "9":
				$dCalculador = round(($sDatosAux * 1.006 * 3.6/1000), NUM_DECIMALES_VIENTO);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" km/h";
				}	
				break;
            // Anemometro Low Power
			case "34":
				$dCalculador = round(($sDatosAux * 1.006 * 3.6 / 60), NUM_DECIMALES_VIENTO);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" km/h";
				}	
				break;                    
			// Veleta Davis
			case "10":
				$dCalculador = round($sDatosAux, NUM_DECIMALES_DIRECCION_VIENTO);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" º";
				}
				break;
			// Veleta Davis
			case "33":
				//$dCalculador = round($sDatosAux*3.3/25, NUM_DECIMALES_DIRECCION_VIENTO);
				$dCalculador = round($sDatosAux, NUM_DECIMALES_DIRECCION_VIENTO);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" º";
				}
				break;				
			// Temperatura
			case "11":
				$dCalculador = round(((($sDatosAux*3.3) / $iResGW1)*48 - 40), NUM_DECIMALES_TEMPERATURA);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ºC";
				}
				break;
			// Temperatura Low Power
			case "31":
				$dCalculador = round(($sDatosAux /1000 * 48 - 40), NUM_DECIMALES_TEMPERATURA);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ºC";
				}
				break;				
			// PYR
			case "12":
				$dCalculador = round((($sDatosAux *3300) / $iResGW1)/1.67, NUM_DECIMALES_PYR);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" W/m2";
				}
				break;
 			// PYR Low Power
			case "32":
				$dCalculador = round($sDatosAux /1.67, NUM_DECIMALES_PYR);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" W/m2";
				}
				break;  
			//Analogico Genérico A3
  			case "2":
			//Evaporimetro
			case "16":
			//4-20 y 0-10 de LowPower
			case "35":
			case "36":
				$vDatosSensorGenerico = vObtenerDatosSensorGenerico($sGwId, $iNumSensor); 
				$sResultado = sConvertir_Datos_GW_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $vDatosSensorGenerico[0], $vDatosSensorGenerico[1], $vDatosSensorGenerico[3], $iResGW2);
				break;
				
			//Resto Analógicos Genéricos
			case "21":
			case "22":
			case "23":
			case "24":
			case "25":
			case "26":
				$vDatosSensorGenerico = vObtenerDatosSensorGenerico($sGwId, $iNumSensor); 
				$sResultado = sConvertir_Datos_GW_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $vDatosSensorGenerico[0], $vDatosSensorGenerico[1], $vDatosSensorGenerico[3], $iResGW1);								
				break;
			//Echo-5
			case "37":
				$dCalculador = round((($sDatosAux * 0.00116 * 0.85) - 0.48), NUM_DECIMALES_HUMEDAD);	                           	
               	$dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');     
                if ($dCalculador > 0)
                {
                    $sResultado = $dCalculador."";
                }
                else
                {
                    $sResultado = "0";
                }
                if ($iMostrarUnidades==0)
				{
                	$sResultado.=" %";
				}
				break;
			//Echo-10
			case "38":
				//$dPreCalculador = ($sDatosAux * 3000) / 1024;
				$dCalculador = round((($sDatosAux * 0.00078 * 0.85) - 0.376), NUM_DECIMALES_HUMEDAD);	                            
	            $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
	            if ($dCalculador > 0)
	            {
	                $sResultado = $dCalculador."";
	            }
	            else
	            {
	                $sResultado = "0";
	            }
	            if ($iMostrarUnidades==0)
				{
	            	$sResultado.=" %";
				}
				break;
			//Echo-20
			case "39":
				//$dPreCalculador = ($sDatosAux * 3000) / 1024;
				$dCalculador = round((($sDatosAux * 0.000579 * 0.85) - 0.29), NUM_DECIMALES_HUMEDAD);	                           
                $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
                if ($dCalculador > 0)
                {
                    $sResultado = $dCalculador."";                                        
                }
                else
                {
                    $sResultado = "0";
                }
                if ($iMostrarUnidades==0)
				{
                	$sResultado.=" %";
				}
				break;
			//10HS
			case "40":
				//$dPreCalculador = ($sDatosAux * 3000) / 1024;
				$dCalculador = round((($sDatosAux * $sDatosAux * $sDatosAux * 0.00000000297) - ($sDatosAux * $sDatosAux * 0.00000737) + (0.00669*$sDatosAux) - 1.92), NUM_DECIMALES_HUMEDAD);                            
                $dCalculador = sConvertir_Unidades($dCalculador,'HUM','V','%');
                if ($dCalculador > 0)
                {
                    $sResultado = $dCalculador."";
                }
                else
                {
                    $sResultado = "0";
                }
                if ($iMostrarUnidades==0)
				{
                	$sResultado.=" %";
				}
				break;
			//LM61
			case "41":
				//$dPreCalculador = ($sDatosAux * 3000) / 1024.0;
				$dCalculador = round(($sDatosAux * 0.1) - 60, NUM_DECIMALES_TEMPERATURA);	
                $sResultado = $dCalculador."";
                if ($iMostrarUnidades==0)
				{
                	$sResultado.=" ºC";
				}
				break;
			//DFWS Flujo del Aire
			case "42":
				//$dCalculador = round((0.621 * log((($sDatosAux * 3) / 1024.0), exp(1))), NUM_DECIMALES_VELOCIDAD);
				$dCalculador = round((0.621 * log((($sDatosAux) / 1000.0), exp(1))), NUM_DECIMALES_VELOCIDAD);
                if ($iMostrarUnidades==0)
				{
                	$sResultado = $dCalculador+ " m/s";
				}
                else
	            {
	            	$sResultado = $dCalculador.'';
	            }
				break;
			//Temperatura del Agua 107
			case "43":
				//$dPreCalculador = log((1000000*3/((($sDatosAux * 3) / 1024.0) + 0.065))-1249000,M_E);
				$dPreCalculador = log((1000000*3/((($sDatosAux) / 1000.0) + 0.065))-1249000,M_E);
				$dCalculador = round((1/((0.0008271111+(0.000208802*$dPreCalculador)+(0.000000080592*$dPreCalculador*$dPreCalculador*$dPreCalculador))))-273.15, NUM_DECIMALES_TEMPERATURA);	
                $sResultado = $dCalculador."";
                if ($iMostrarUnidades==0)
				{
                	$sResultado.=" ºC";
				}
				break;
			//Radiacion Solar SRS100
			case "44":
				//$dCalculador = round((($sDatosAux * 3000) / 1024.0)/1.67, NUM_DECIMALES_PYR);
				$dCalculador = round(($sDatosAux)/1.67, NUM_DECIMALES_PYR);
				$sResultado = $dCalculador."";
				if ($iMostrarUnidades==0)
	            {
					$sResultado .= ' W/m2';
	            }
				break;
			//HI 98143 pH
			case "45":
				//$dCalculador = round((14*($sDatosAux * 3 / 1024.0)), NUM_DECIMALES_PH);
				$dCalculador = round((14*($sDatosAux / 1000.0)), NUM_DECIMALES_PH);
				$sResultado = $dCalculador."";
				if ($iMostrarUnidades==0)
	            {
					$sResultado .= ' pH';
	            }
				break;
			//HI 98143 Conductividad
			case "46":
				//$dCalculador = round((10*($sDatosAux * 3 / 1024.0)), NUM_DECIMALES_CONDUCTIVIDAD);
				$dCalculador = round((10*($sDatosAux / 1000.0)), NUM_DECIMALES_CONDUCTIVIDAD);
				$sResultado = $dCalculador."";
				if ($iMostrarUnidades==0)
	            {
					$sResultado .= ' uS/cm';
	            }
				break;
			// Digital (0:Cerrado)
			case "3":
			case "4":
			case "5":
			case "6":    
				if($sDatosAux == 0)
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 0 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general337'];
					}
				}
				else 
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 1 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general338'];
					}
				}
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ";
				}
				break;         
			// Digital (0:Abierto)
			case "17":
			case "18":
			case "19":
			case "20":    
				if($sDatosAux != 0)
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 0 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general337'];
					}
				}
				else 
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 1 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general338'];
					}
				}
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ";
				}
				break;                
            //Cont.Pulsos
			case "13":
			case "14":
			case "15":
			case "0":
			default:
				$sResultado = $sDatosAux;
				break;
        }
    }
    return $sResultado;
}

function sConvertir_Datos_GW_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $iMax, $iMin, $sNombre, $iResGW)
{
	$dCalculador=0.0;
    $iEnteroAux=0;
    $sResultado="0";
	$vDatosSensorGenerico[4];
		
    if (strlen($sDatosAux) > 0)
    {
        switch ($sTipoSensorAux)
        {
			case 35:				
				$dCalculador = round(($iMax - $iMin)/16*($sDatosAux/100-4)+$iMin, NUM_DECIMALES_GENERICO);
				
				$sResultado = $dCalculador."";
				
        		if ($iMostrarUnidades==0)
				{
					$sResultado.= " ".$sNombre;
				}								
				break;
			case 36:
				$dCalculador = round(($iMax - $iMin)/10000*$sDatosAux+$iMin, NUM_DECIMALES_GENERICO);

				$sResultado = $dCalculador."";
				//echo $sDatosAux." ";
        		if ($iMostrarUnidades==0)
				{
					
					$sResultado.= " ".$sNombre;
				}
				break;
			//Analogico Genérico
  			case 2:
			//Evaporimetro
			case 16:
			// Resto Analogicos genericos
			case 21:
        	case 22:
        	case 23:
        	case 24:
        	case 25:
        	case 26:
			default:
				if($sDatosAux == 0)
				{
					$dCalculador = 0;
				}
				else
				{ 
					$dCalculador = round($iMax*($sDatosAux/$iResGW*3.3) + $iMin, NUM_DECIMALES_GENERICO);
				}
				
				$sResultado = $dCalculador."";
				//echo $sGwId."           ".$sTipoSensorAux;
        		if ($iMostrarUnidades==0)
				{
					$sResultado.= " ".$sNombre;
				}	
				break;				      	
		}
	}
	return $sResultado;
}

function sConvertir_Datos_UTC($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $iOperacion, $iOperando, $iSacarCadena)
{
	include 'inc/idiomas.inc';	
	$dCalculador=0.0;
    $iEnteroAux=0;
    $sResultado="0";
	if($iOperando==0)
		$iOperando = 1;
    if (strlen($sDatosAux) > 0)
    {
        switch (substr($sTipoSensorAux,0,2))
        {
			case "30":
			case "36":
			case "44":
			case "45":
			case "46":
			case "47":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" V";
				}
				break;
			case "31":
			case "37":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" mA";
				}
				break;
			case "32":
			case "38":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" W";
				}
				break;
			case "33":
			case "39":
			case "49":				
			case "53":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" varL";
				}
				break;
			case "34":
			case "40":
			case "50":
			case "54":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" varC";
				}
				break;
			case "35":
			case "41":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" PF";
				}
				break;
			case "42":
				
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
					
				}				
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" Hz";
				}
				break;
			case "43":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" VA";
				}
				break;
			case "48":
			case "52":
			case "57":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" Wh";
				}
				break;
			case "51":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" Pd";
				}
				break;
			case "55":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" V";
				}
				break;
			case "56":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TENSION);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TENSION);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" A";
				}
				break;
			case "58":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_CLORO);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_CLORO);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" mg/l";
				}
				break;
			case "59":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_PH);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_PH);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" pH";
				}
				break;
			case "60":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_VOLTAJE);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_VOLTAJE);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" mV";
				}
				break;
			case "61":
				if($iOperacion == 0)
				{
					$dCalculador = round(($sDatosAux / $iOperando), NUM_DECIMALES_TEMPERATURA);
				}
				else 
				{
					$dCalculador = round(($sDatosAux * $iOperando), NUM_DECIMALES_TEMPERATURA);
				}
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ºC";
				}
				break;	
			case "62":
			case "63":
			case "64":
				if($sDatosAux == 0)
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 0 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general335'];
					}
				}
				else 
				{
					if($iSacarCadena==0)
					{
						$sResultado = " 1 ";
					}
					else
					{
						$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general336'];
					}
				}
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" ";
				}
				break;
			default:
				/*$dCalculador = round((($sDatosAux *(3.3*40)) / (255.0)), NUM_DECIMALES_HUMEDAD);
				$sResultado = $dCalculador."";
        		if ($iMostrarUnidades==0)
				{
					$sResultado.=" %";
				}*/
				$sResultado = $sDatosAux;
				break;
			
        }
    }
    return $sResultado;
}

function sConvertir_Datos_Nodo_Generico($sDatosAux, $sTipoSensorAux, $iMostrarUnidades, $iMax, $iMin, $sNombre)
{
	$vDatosSensorGenerico[4];
	$dPreCalculador=0.0;
    $dCalculador=0.0;
    $iEnteroAux=0;
    $sResultado="0";
	
    if (strlen($sDatosAux) > 0)
    {
	    if (strlen($sTipoSensorAux) == 3)
	    {
            switch (substr($sTipoSensorAux, 0, 1))
            {
                // si es 4-20
                case '4':
                case 'D':
                case 'd':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {
                        case '0':							
							$dCalculador = round(($iMax - $iMin)/16*($sDatosAux * 125/(4096*6)-4)+$iMin, NUM_DECIMALES_GENERICO);
							
							$sResultado = $dCalculador."";
							
			        		if ($iMostrarUnidades==0)
							{
								$sResultado.= " ".$sNombre;
							}
							break;							
						break;
					}
					break;
			    // Si es 0..10V
				case 'C':
                case 'c':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {
                        case '0':
							$dCalculador = round(($iMax - $iMin)/10*($sDatosAux * 3/1024)+$iMin, NUM_DECIMALES_GENERICO);
							
							$sResultado = $dCalculador."";
							
			        		if ($iMostrarUnidades==0)
							{
								$sResultado.= " ".$sNombre;
							}
						break;
					}
					break;
					
				// Analógico Genérico
				case '1':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {	                        
                        case '0':
							$dCalculador = round(($iMax*($sDatosAux * 3/1024))+$iMin, NUM_DECIMALES_VOLTAJE);
							$sResultado = $dCalculador."";
							
			        		if ($iMostrarUnidades==0)
							{
								$sResultado.= " ".$sNombre;
							}								
						break;
					}						
					break;
			}
		}
	}
	return $sResultado;
}
function sObtener_Cadena_Tipo_Evento($sEntrada)
{
 	if((intval($sEntrada)>=500 && intval($sEntrada)<506) || (intval($sEntrada)>=600 && intval($sEntrada)<625))
 	{
 		$sResultado='D';
 	}
 	else if((intval($sEntrada)>=506 && intval($sEntrada)<512) || (intval($sEntrada)>=625 && intval($sEntrada)<675))
 	{
 		$sResultado='U';
 	}
 	else if((intval($sEntrada)>=512 && intval($sEntrada)<518) || (intval($sEntrada)>=675 && intval($sEntrada)<725))
 	{
 		$sResultado='G';
 	}
 	else if($sEntrada=='801' || $sEntrada=='805')
 	{
 		$sResultado='B';
 	}
 	else
 	{
 		$sResultado='';
 	}
	return $sResultado;
}

function sConvertir_Unidades($sEntrada,$sTipoUnidad,$sUnidadIN,$sUnidadOUT)
{
	if ($sUnidadIN!=$sUnidadOUT)
	{
		switch ($sTipoUnidad)
		{
			case 'HUM':
				switch($sUnidadOUT)
				{
					case 'V':
						$sSalida = $sEntrada/100;
						break;
						
					case '%':
					default:
						$sSalida = $sEntrada*100;
						break;
				}
				break;
				
			case 'TEMP':
				switch($sUnidadOUT)
				{
					case 'F':
						$sSalida = ((1.8 * $sEntrada) + 32);
						break;
						
					case 'C':
					default:
						$sSalida = (($sEntrada-32)/1.8);
						break;
				}
				break;
				
			default:
				$sSalida = $sEntrada;
				break;
		}
	}
	else
	{
		$sSalida = $sEntrada;
	}
	return $sSalida;
}

function vObtenerDatosSensorGenerico($sGwId, $iNumSensor)
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	
	session_start();
	$sResultado = "";
	
	$mysql = mysqli_connect($db_host, $db_user, $db_pass);
	
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysqli_select_db($mysql, $_SESSION['cliente_db']);
	//echo $selected;
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysqli_close($mysql);
		return 'ERROR 2';
	}

	if(iObtenerTipoGW($sGwId, $_SESSION["cliente_db"]) == 0)
	{
		$tabla_params_gw = $tabla_name_params_gateways;
		$iNumSensor++;
	}
	else 
	{
		$tabla_params_gw = $tabla_name_params_gateways_low;
	}

	$query = sprintf("SELECT gw_A%sMAX, gw_A%sMIN, gw_A%sUND, nombre FROM %s INNER JOIN ".$db_name_general.".rfreenet_uds_sensor_generico ON (gw_A%sUND = cod_unidad) WHERE gw_id='%s' ", $iNumSensor, $iNumSensor, $iNumSensor, $tabla_params_gw, $iNumSensor, $sGwId);
	
	$result = mysqli_query($mysql, $query);
	
	if(!$result)
	{
		mysqli_close($mysql);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysqli_fetch_array($result);
		//echo mysql_num_rows($result);
		$sResultado = array($result_array[0], $result_array[1], $result_array[2], $result_array[3]);
		
		mysqli_free_result($result);
		mysqli_close($mysql);
	}
	return $sResultado;	
}

function vObtenerDatosSensorGenericoNodo($sGwId, $sNodoIp, $iNumSensor)
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	
	session_start();
	$sResultado = "";
	
	$mysql = mysqli_connect($db_host, $db_user, $db_pass);
	
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysqli_select_db($mysql, $_SESSION['cliente_db']);
	//echo $selected;
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysqli_close($mysql);
		return 'ERROR 2';
	}

	$query = sprintf("SELECT nodo_A%sMAX, nodo_A%sMIN, nodo_A%sUND, nombre FROM %s INNER JOIN ".$db_name_general.".rfreenet_uds_sensor_generico ON (nodo_A%sUND = cod_unidad) WHERE gw_id='%s' And nodo_ip='%s' ", $iNumSensor, $iNumSensor, $iNumSensor, $tabla_name_params_nodos, $iNumSensor, $sGwId, $sNodoIp);
	
	$result = mysqli_query($mysql, $query);
	
	if(!$result)
	{
		mysqli_close($mysql);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysqli_fetch_array($result);
		//echo mysql_num_rows($result);
		$sResultado = array($result_array[0], $result_array[1], $result_array[2], $result_array[3]);
		
		mysqli_free_result($result);
		mysqli_close($mysql);
	}
	return $sResultado;	
}

?>
