<?php
session_start();
function sObtener_Cadena_Tipo_Sensor_GW($sEntrada)
{
	include 'inc/idiomas.inc';
 	switch ($sEntrada)
	{
		//Analogico
		case 2:
		case 21:
		case 22:
		case 23:
		case 24:
		case 25:
		case 26:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type4'];
			break;
		//Digitales
		case 3:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 1 (D0) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general337'].")";
			break;
		case 4:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 2 (D1) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general337'].")";
			break;
		case 5:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 3 (D2) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general337'].")";
			break;
		case 6:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 4 (D3) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general337'].")";
			break;
		case 17:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 1B (D0) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general338'].")";
			break;
		case 18:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 2B (D1) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general338'].")";
			break;
		case 19:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 3B (D2) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general338'].")";
			break;
		case 20:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']." 4B (D3) (0: ".$idiomas[$_SESSION['opcion_idioma']]['general338'].")";
			break;
		//Humedad
        case 7:
		case 30:	
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type1'];
			break;
		//Pluviometro
        case 8:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type6'];
			break;
                    
        // Anemometro
		case 9:
		case 34:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_anem_davis'];
			break;
			
		// Veleta Davis
		case 10:
		case 33:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_vel_davis'];
			break;	
                    
		//Temperatura		
		case 11:
		case 31:			
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type2'];
			break;
			
		// PYR
		case 12:
		case 32:			
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type21'];
			break;
                    
        //Cont.Pulsos
		case 13:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." 2";
			break;
		case 14:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." 3";
			break;
		case 15:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']." 4";
			break;
		//Veleta
		case "H01":
		case "H02":
            $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type23'];
			break;
                    
		//Pluviometro
        case "H04":
		case "H05":
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type12'];
			break;
                    
            // Anemometro
		case "H03":
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type24'];
			break;
                    
		//Analogico
		case "AN1":
		case "AN2":
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type4'];
			break;
		//4-20 mA
		case 35:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type84'];
			break;
		//0-10 V
		case 36:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type85'];
			break;   
		//EVAPORÍMETRO
		case 16:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type86'];
			break; 	
		// ECHO-5
        case 37:
            $sResultado = "ECHO-5";
            break;

        // ECHO-10
        case 38:
           $sResultado = "ECHO-10";
            break;

        // ECHO-20
        case 39:
            $sResultado = "ECHO-20";
            break;

        // 10HS
        case 40:
            $sResultado = "10HS";
			break;
			
        // LM61
        case 41:
           	$sResultado = "LM61";
            break;

        // DSFW (FLUJO AIRE)
        case 42:
             $sResultado = "DSFW";
            break;
            
        // Temperatura del agua 107
        case 43:
        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type16']." 107";
            break;
            
         // Radiación Solar SRS100
        case 44:
            $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type21']." SRS100";
            break;
		// HI 98143 pH
		case 45:
			$sResultado = "HI 98143 pH";
            break;
			
		// Conductividad 98143 pH
		case 46:
			$sResultado = "HI 98143 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type3'];
			break;		
			
		// Salida de Telemando
        case 27:
		case 28:
		case 29:
        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['general291'].' '.($sEntrada-26);
            break;
			                 					                    		
		case 0:
		default:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];
			//$sResultado="NO";
			break;
	}
	return $sResultado;
}

function sObtener_Cadena_Tipo_Sensor($sTipoSensorAux)
{
	include 'inc/idiomas.inc';
    if (strlen($sTipoSensorAux) == 3)
    {
            switch (substr($sTipoSensorAux, 0, 1))
            {
                // si es analogica
                case '1':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {
                        // ECHO-5
                        case '1':
                       		$sResultado = "ECHO-5";
                            break;

                        // ECHO-10
                        case '2':
                            $sResultado = "ECHO-10";
                            break;

                        // ECHO-20
                        case '3':
                            $sResultado = "ECHO-20";
                            break;

                        // 10HS
                        case '4':
                            $sResultado = "10HS";
                            break;

                        // LM61
                        case '5':
                            $sResultado = "LM61";
                            break;

                        // DSFW (FLUJO AIRE)
                        case '6':
                            $sResultado = "DSFW";
                            break;
                        
						// Temperatura del Agua 107
						case '7':
                            $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type16']." 107";
                            break;
							
						// Radiación Solar SRS100
						case '8':
                            $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type21']." SRS100";
                            break;
							
						// HI pH
						case '9':
                            $sResultado = "HI 98143 pH";
                            break;
							
						// Conductividad
						case 'A':
                            $sResultado = "HI 98143 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type3'];
                            break;
							
						// Temperatura Watermark 200TS
						case 'B':
                            $sResultado = "Watermark 200TS";
                            break;
							
						// Temperatura EC-T Decagon
						case 'C':
                            $sResultado = "EC-T Decagon";
                            break;
                            
                        // Generico
                        default:
                        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type4'];
                            break;
                    }
                    if (substr($sTipoSensorAux, 0, 1) == '8')
                    {
                    	$sResultado += " P";
                    }
                    break;

                // si es entrada digital
                case '2':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {
                        // Presencia
                        case '1':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type15'];
                            break;

                        // Pulsador
                        case '2':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type11'];
                            break;
							
						// Sensor de Nivel
                        case '3':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type17'];
                            break;

                        // Generico
                        default:
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type5'];
                            break;
                    }
                    break;

                // si es Watermark
                case '3':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
                    	// Conductividad CS547A
                        case '1':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type18']." CS547A";
                            break;

                        // Generico
                        default:
                        $sResultado = "Watermark";
                            break;
					}
                    break;
					
				// Si es veleta Davis
				case 'B':
                case 'b':
					$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_vel_davis'];
                    break;

                // si es 4-20
                case '4':
				case 'D':
                case 'd':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
                        // pH
                        case '1':
                        $sResultado = "WQ201 pH";
                            break;

                        // Oxigeno disuelto
                        case '2':
                        $sResultado = "WQ401 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type20'];
                            break;
							
						 // Oxigeno disuelto HI 8410
                        case '3':
                        $sResultado = "HI 8410 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type20'];
                            break;
							
						 // Conductividad HI 8936DL
                        case '4':
                        $sResultado = "HI 8936DL ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type3'];
                            break;
							
						 // "HI 8711 pH"
                        case '5':
                        $sResultado = "HI 8711 pH";
                            break;
							
						// Turbidez 7685
                        case '6':
                        $sResultado = "TU 7685 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type23'];
                            break;
							
						// HI 8615L ORP
                        case '7':
                        $sResultado = "HI 8615L ORP";
                            break;
							
						// JUMO MIDAS Presión 0..10Ba
                        case '8':
                        	$sResultado = "JUMO "+$idiomas[$_SESSION['opcion_idioma']]['sensor_type22']+" 0..10 Ba";
                            break;

                        // Generico
                        default:
                        $sResultado = "4-20 mA";
                            break;
                    }     
					if ((substr($sTipoSensorAux, 1, 1) == 'd') || (substr($sTipoSensorAux, 1, 1) == 'D'))
                    {
                    	$sResultado += " P";
                    }           	
                    break;
                    
                // Si es 0..10V
				case 'C':
                case 'c':
                	switch (substr($sTipoSensorAux, 2, 1))
                    {
               			 // pH
                        case '1':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type48'];
                            break;

                        // Oxigeno disuelto
                        case '2':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type49'];
                            break;
							
						 // Oxigeno disuelto HI 8410
                        case '3':
                        $sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type50'];
                            break;
						default:
				    		$sResultado = "0..10V";
		           	        break;
					}            	
                    break;

                // si es salida digital
                case '5':
               		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type12'];
                    break;
					
                // si es contador de pulsos    
                case '7':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
                        // Pluviometro
                        case '1':
                        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type6'];
                            break;

                        // Anemómetro Davis
                        case '2':
                        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_anem_davis'];
                            break;

                        // Generico
                        default:
                        	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type9'];
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
                        	$sResultado = "Sensirion ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_hum'];
                            break;

                        // SENSIRION SHT1X (Temperatura)
                        case '1':
						case '3':
						case '5':
                        	$sResultado = "Sensirion ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_temp'];
                            break;
                        // Generico
                        default:
                            $sResultado = "Sensirion";
                            break;
                    }    				
                    break;
					
				// Si es rotación de motor
				case 'E':
                case 'e':
					$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type19'];
					break;
                   
                // Humedad Digital
                case '8':
                	switch (substr($sTipoSensorAux, 2, 1))
                    {
                    	case '1':
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_5TE_turba'];
                    		break;
                    		
                    	case '2':
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_5te_lanaroca'];
                    		break;
                    		
                    	case '3':
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_5te_perlite'];
                    		break;
							
                    	case '4':
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_gs3_mineral'];
                    		break;
														
                    	case '5':
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_gs3_turba'];
                    		break;
                    		
                    	case '6':
                    		$sResultado = "VP3 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type1'];
                    		break;

                    	case '0':
                    	default:
                    		$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_5te_mineral'];
                    		break;
                    }
					break;

				// Conductividad Digital / Presión Atm.
				case '9':
                	switch (substr($sTipoSensorAux, 2, 1))
                    {
                    	case '1':
                    		$sResultado = "GS3 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_cond'];
                    		break;
								
						case '2':
                    		$sResultado = "VP3 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type22'];
                    		break;
							
                    	case '0':
                    	default:
                    		$sResultado = "5TE ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_cond'];
                    		break;											
					}
					break;

				// Temperatura Digital
				case 'A':
				case 'a':
                	switch (substr($sTipoSensorAux, 2, 1))
                    {
                    	case '1':
                    		$sResultado = "GS3 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_temp'];
                    		break;
						case '2':
                    		$sResultado = "VP3 ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_temp'];
                    		break;	
                    	case '0':
                    	default:
                    		$sResultado = "5TE ".$idiomas[$_SESSION['opcion_idioma']]['sensor_sens_temp'];
                    		break;											
					}
					break;
					
				case 'F':
                case 'f':
                    $sResultado = "AMR";
                    break;

                // en caso de no ser ninguno conocido
                default:
                	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_desc'];
                    break;
        }
    }
    else
    {
    	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];	
    }
    return $sResultado;
}

function sObtener_Cadena_Tipo_Sensor_UTC($sEntrada,$numSensor)
{
	include 'inc/idiomas.inc';
	$numero_magnitud = "";
	if($numSensor != '0')
	{
		$numero_magnitud = $numSensor;
	}
 	switch ($sEntrada)
	{
        case 30:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type24']." ".$numero_magnitud;
			break;
        case 31:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type25']." ".$numero_magnitud;
			break;
		case 32:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type26']." ".$numero_magnitud;
			break;
		case 33:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type27']." ".$numero_magnitud;
			break;		
		case 34:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type28']." ".$numero_magnitud;
			break;
		case 35:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type29']." ".$numero_magnitud;
			break;
		case 36:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type24']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 37:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type25']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 38:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type26']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 39:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type27']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 40:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type28']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 41:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type29']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 42:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type31']." ".$numero_magnitud;
			break;
		case 43:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type32']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 44:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type33']." ".$numero_magnitud;
			break;
		case 45:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type34']." ".$numero_magnitud;
			break;
		case 46:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type35']." ".$numero_magnitud;
			break;
		case 47:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type36']." (".$idiomas[$_SESSION['opcion_idioma']]['sensor_type30'].")"." ".$numero_magnitud;
			break;
		case 48:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type37']." ".$numero_magnitud;
			break;
		case 49:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type38']." ".$numero_magnitud;
			break;
		case 50:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type39']." ".$numero_magnitud;
			break;
		case 51:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type40']." ".$numero_magnitud;
			break;
		case 52:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type37']." ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type41']." ".$numero_magnitud;
			break;
		case 53:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type38']." ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type41']." ".$numero_magnitud;
			break;
		case 54:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type39']." ".$idiomas[$_SESSION['opcion_idioma']]['sensor_type41']." ".$numero_magnitud;
			break;
		case 55:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type42']." ".$numero_magnitud;
			break;
		case 56:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type43']." ".$numero_magnitud;
			break;
		case 57:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type44']." ".$numero_magnitud;
			break;
		case 58:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type52']." ".$numero_magnitud;
			break;
		case 59:
			$sResultado = "pH"." ".$numero_magnitud;
			break;
		case 60:
			$sResultado = "ORP"." ".$numero_magnitud;
			break;
		case 61:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type2']." ".$numero_magnitud;
			break;
		case 62:
			switch($numSensor)
			{
				case 1:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type53'];
					break;
				case 2:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type54'];
					break;
				case 3:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type55'];
					break;
				case 4:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type56'];
					break;
				case 5:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type57'];
					break;
				case 6:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type58'];
					break;
				case 7:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type59'];
					break;
				default:
					$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];
					break;
			}
			
			break;
		case 63:
			//$sResultado = "Alarma"." ".$numero_magnitud;
			switch($numSensor)
			{
				case 1:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type60'];
					break;
				case 2:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type61'];
					break;
				case 3:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type62'];
					break;
				case 4:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type63'];
					break;
				case 5:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type64'];
					break;
				case 6:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type65'];
					break;
				case 7:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type66'];
					break;
				case 8:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type67'];
					break;
				default:
					$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];
					break;
			}
			break;
		case 64:
			//$sResultado = "Warning"." ".$numero_magnitud;
			switch($numSensor)
			{
				case 1:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type68'];
					break;
				case 2:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type69'];
					break;
				case 3:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type70'];
					break;
				case 4:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type71'];
					break;
				case 5:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type72'];
					break;
				case 6:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type73'];
					break;
				case 7:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type74'];
					break;
				case 8:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type75'];
					break;
				case 9:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type76'];
					break;
				case A:
				case 10:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type77'];
					break;
				case B:
				case 11:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type78'];
					break;
				case C:
				case 12:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type79'];
					break;
				case D:
				case 13:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type80'];
					break;
				case E:
				case 14:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type81'];
					break;
				case F:
				case 15:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type82'];
					break;
				case G:
				case 16:
				 	$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_type83'];
					break;
				default:
					$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];
					break;
			}
			break;
		case 0:
		default:
			$sResultado = $idiomas[$_SESSION['opcion_idioma']]['sensor_no'];
			break;
	}
	return $sResultado;
}

function sObtener_Cadena_Numero_Sensor($sEntrada)
{
 	switch ($sEntrada)
	{
		//Veleta
		case 500:
		case 506:
		case 512:
		case 600:
		case 625:
		case 650:
		case 675:
		case 700:
		case 725:
		case 750:
		case 775:
		case 900:
		case 925:
            $sResultado = "1";
			break;
                    
		case 501:
		case 507:
		case 513:
		case 601:
		case 626:
		case 651:
		case 676:
		case 701:
		case 726:
		case 751:
		case 776:
		case 901:
		case 926:
            $sResultado = "2";
			break;
			
		case 502:
		case 508:
		case 514:
		case 602:
		case 627:
		case 652:
		case 677:
		case 702:
		case 727:
		case 752:
		case 777:
		case 902:
		case 927:
            $sResultado = "3";
			break;
			
		case 503:
		case 509:
		case 515:
		case 603:
		case 628:
		case 653:
		case 678:
		case 703:
		case 728:
		case 753:
		case 778:
		case 903:
		case 928:
            $sResultado = "4";
			break;
			
		case 504:
		case 510:
		case 516:
		case 604:
		case 629:
		case 654:
		case 679:
		case 704:
		case 729:
		case 754:
		case 779:
		case 904:
		case 929:
            $sResultado = "5";
			break;
			
		case 505:
		case 511:
		case 517:
		case 605:
		case 630:
		case 655:
		case 680:
		case 705:
		case 730:
		case 755:
		case 780:
		case 905:
		case 930:
            $sResultado = "6";
			break;
			
		case 606:
		case 631:
		case 656:
		case 681:
		case 706:
		case 731:
		case 756:
		case 781:
		case 906:
		case 931:
            $sResultado = "7";
			break;
			
		case 607:
		case 632:
		case 657:
		case 682:
		case 707:
		case 732:
		case 757:
		case 782:
		case 907:
		case 932:
            $sResultado = "8";
			break;
			
		case 608:
		case 633:
		case 658:
		case 683:
		case 708:
		case 733:
		case 758:
		case 783:
		case 908:
		case 933:
            $sResultado = "9";
			break;
		default:
			$sResultado = "";
			//$sResultado = $sEntrada;
			break;
	}
	return $sResultado;
}

function sObtener_Cadena_Magnitud_Sensor_GW($sEntrada)
{
	include 'inc/idiomas.inc';
 	switch ($sEntrada)
	{
		//Analogico		
		case 2:
		case 21:
		case 22:
		case 23:
		case 24:
		case 25:
		case 26:
			$sResultado = "GENERICO";
			//$sResultado = "ANA";
			break;
		//Humedad
        case 7:
		case 30:
		// ECHO-5
        case 37:
        // ECHO-10
        case 38:
        // ECHO-20
        case 39:
        // 10HS
        case 40:
			$sResultado = "HUM";
			break;
		//Pluviometro
        case 8:
			$sResultado = "PLU";
			break;
                    
        // Anemometro
		case 9:
		case 34:
			$sResultado = "ANE";
			break;
			
		// Veleta Davis
		case 10:
		case 33:
			$sResultado = "VEL";
			break;	
                    
		//Temperatura	
		case 11:
		case 31:	
		// LM61
        case 41:	
		// Temp Agua 107
        case 43:
			$sResultado = "TEM";
			break;
			
		// Radiación Solar
		case 12:
		case 32:		
		// Radiación Solar SRS100
        case 44:	
			$sResultado = "PYR";
			break;
                    
        //Cont.Pulsos
		case 13:
		case 14:
		case 15:
			$sResultado = "PUL";
			break;		
		case 3:
		case 4:
		case 5:
		case 6:
		case 17:
		case 18:
		case 19:
		case 20:
			$sResultado = "DIG";
			break;
			
		// 0..10 y 4-20 genericos
		case 35:
		case 36:
			$sResultado = "GENERICO";
			break;

		case 16:
			$sResultado = "EVA";
			break;	
		// DSFW (FLUJO AIRE)
        case 42:
            $sResultado = "FLU";
            break;				
		// Conductividad 98143
        case 46:
            $sResultado = "CON";
            break;
		default:
			$sResultado = "NO";
			break;
	}
	return $sResultado;
}

function sObtener_Cadena_Magnitud_Sensor_UTC($sEntrada)
{
	include 'inc/idiomas.inc';
 	switch ($sEntrada)
	{
        case 30:
		case 36:
		case 44:
		case 45:
		case 46:
		case 47:
			$sResultado = "ANA";
			break;
        case 31:
		case 37:
			$sResultado = "COR";
			break;
		case 32:
		case 33:
		case 34:
		case 38:
		case 39:
		case 40:
		case 43:
		case 51:
			$sResultado = "POT";
			break;
		case 35:
		case 41:
			$sResultado = "FPO";
			break;
		case 42:
			$sResultado = "FRE";
			break;
		case 48:
		case 49:
		case 50:
		case 52:
		case 53:
		case 54:
		case 57:
			$sResultado = "ENE";
			break;
		case 55:
		case 56:
			$sResultado = "THD";
			break;
		case 58:
			$sResultado = "CLO";
			break;
		case 59:
			$sResultado = "SPH";
			break;
		case 60:
			$sResultado = "ORP";
			break;
		case 61:
			$sResultado = "TEM";
			break;
		case 62:
			$sResultado = "ERR";
			break;
		case 63:
			$sResultado = "ALA";
			break;
		case 64:
			$sResultado = "WAR";
			break;
		default:
			$sResultado = "NO";
			break;
	}
	return $sResultado;
}

function sObtener_Cadena_Magnitud_Sensor($sTipoSensorAux, $iUnidad)
{
	include 'inc/idiomas.inc';
    if (strlen($sTipoSensorAux) == 3)
    {
            switch (substr($sTipoSensorAux, 0, 1))
            {
                // si es analogica
                case '1':
                    switch (substr($sTipoSensorAux, 2, 1))
                    {
                        // ECHO-5
                        case '1':
                        // ECHO-10
                        case '2':
                        // ECHO-20
                        case '3':
                        // 10HS
                        case '4':
                            $sResultado = "HUM";
                            break;

                        // LM61
                        case '5':
						// Temperatura Watermark 200TS
						case 'B':
						// Temperatura EC-T Decagon
						case 'C':
                            $sResultado = "TEM";
                            break;

                        // DSFW (FLUJO AIRE)
                        case '6':
                            $sResultado = "FLU";
                            break;
							
						// Temp Agua 107
                        case '7':
                            $sResultado = "TEM";
                            break;
							
						// Radiación Solar SRS100
                        case '8':
                            $sResultado = "PYR";
                            break;
							
						// pH
                        case '9':
                            $sResultado = "SPH";
                            break;
							
						// Conductividad 98143
                        case 'A':
                            $sResultado = "CON";
                            break;                     
                
		        		// Generico
                        default:
	                        //$sResultado = "ANA";
	                        $sResultado = "GENERICO";
                            break;
                    }
                    break;
					
				// Veleta Davis
				case 'B':
                case 'b':
					$sResultado = "VEL";
					break;	

                // si es entrada digital
                case '2':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
						// Sensor de Nivel
                        case '3':
                        $sResultado = "NIV";
                            break;

                        // Generico
                        case '1':
						case '2':
                        default:
                        $sResultado = "DIG";
                            break;
                    }               	
                    break;

                // si es Watermark
                case '3':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
						// Conductividad CS547A
                        case '1':
							$sResultado = "CON";
                            break;

                        // Generico
                        default:
                        	$sResultado = "PRE";
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
							$sResultado = "GENERICO";
							/*
							if($iUnidad == 3)
							{
								$sResultado = "MMS";							
							}
							else 
							{
								$sResultado = "420";
							}
							*/
							break;
						// pH
                        case '1':
							$sResultado = "SPH";
                            break;
							
						// Oxigeno disuelto
                        case '2':
							$sResultado = "OXI";
                            break;
							
						// Oxigeno disuelto HI 8410
                        case '3':
							$sResultado = "OXD";
                            break;
							
						// HI 8936DL Conductividad
                        case '4':
							$sResultado = "COU";
                            break;
							
						// OHI 8711 pH
                        case '5':
							$sResultado = "SPH";
                            break;
							
						// TU 7685 Turbidez
                        case '6':
							$sResultado = "TUR";
                            break;
							
						// HI 8615L ORP
                        case '7':
							$sResultado = "ORP";
                            break;
							
						// JUMO MIDAS Presión 0..10 Ba
                        case '8':
							$sResultado = "PRB";
                            break;

                        // Generico
                        default:
                        $sResultado = "420";
                            break;
                    }                    
                    break;
                    
                // Si es 0..10V
				case 'C':
                case 'c':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
						case '0':
							$sResultado = "GENERICO";
							/*
							if($iUnidad == 3)
							{
								$sResultado = "MMS";							
							}
							else 
							{
								$sResultado = "010";
							}
							*/
							break;                    	
						// NO2, NO, CO
                        case '1':
						case '2':
						case '3':
							$sResultado = "AIR";
                            break;
						default:
				    		$sResultado = "010";
		           	        break;
					}
					break;

                // si es salida digital
                case '5':
               		$sResultado = "DOU";
                    break;
                    
				// si es contador de pulsos
                case '7':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
						// Pluviómetro
                        case '1':
							$sResultado = "PLU";
                            break;
							
						// Anemómetro Davis
                        case '2':
							$sResultado = "ANE";
                            break;

                        // Generico
                        default:
                        	$sResultado = "PUL";
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
                        	$sResultado = "HUM";
                            break;

                        // SENSIRION SHT1X (Temperatura)
                        case '1':
						case '3':
						case '5':
                        	$sResultado = "TEM";
                            break;
                        // Generico
                        default:
                            $sResultado = "NO";
                            break;
                    }
                    break;
					
				// rotacion del motor
				case 'E':
                case 'e':
					$sResultado = "ROT";
					break;
                   
                // Humedad Digital
                case '8':
                	$sResultado = "HUM";
					break;

				// Conductividad Digital / Presión
				case '9':
					switch (substr($sTipoSensorAux, 2, 1))
                    {
						case '2':
							$sResultado = "PRE";
							break;
							
                    	// Generico
                        default:
							$sResultado = "CON";
							break;
					}
					break;

				// Temperatura Digital
				case 'A':
				case 'a':
					$sResultado = "TEM";
					break;
					
				// AMR
				case 'F':
                case 'f':
                    $sResultado = "AMR";
                    break;

                // en caso de no ser ninguno conocido
                default:
                	$sResultado = "NO";
                    break;
        }
    }
    else
    {
    	$sResultado = "NO";
    }
    return $sResultado;
}

function sObtener_Tipo_Sensor_Unidad($magnitud)
{
	include 'inc/idiomas.inc';
	switch ($magnitud)
	{
		case 'HUM':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type1']."\r\n%\r\n";
			break;
		case 'TEM':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type2']."\r\nºC\r\n";
			break;
		case 'COU':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type3']."\r\nuS/cm\r\n";
			break;
		case 'CON':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type3']."\r\ndS/m\r\n";
			break;
		case 'ANA':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']."\r\nV\r\n";
			break;
		case 'DIG':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']."\r\n \r\n";
			break;
		case 'PLU':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type6']."\r\nmm\r\n";
			break;
		case 'ANE':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type7']."\r\nkm/h\r\n";
			break;
		case 'VEL':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type8']."\r\nº\r\n";
			break;
		case 'PUL':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']."\r\n \r\n";
			break;
		case '420':
			return "4-20mA\r\nmA\r\n";
			break;
		case '010':
			return "0..10V\r\nV\r\n";
			break;
		case 'DOU':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type12']."\r\n \r\n";
			break;
		case 'FLU':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type13']."\r\nm/s\r\n";
			break;
		case 'ROT':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type19']."\r\n \r\n";
			break;
		case 'SPH':
			return "pH\r\n \r\n";
			break;
		case 'OXI':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type20']."\r\n%\r\n";
			break;
		case 'NIV':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type17']."\r\n \r\n";
			break;
		case 'PYR':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type21']."\r\nW/m2\r\n";
			break;
		case 'PRE':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type22']."\r\nkPa\r\n";
			break;
		case 'PRB':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type22']."\r\nBa\r\n";
			break;
		case 'COR':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type25']."\r\nmA\r\n";
			break;
		case 'POT':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type45']."\r\nW\r\n";
			break;
		case 'FPO':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type29']."\r\nFP\r\n";
			break;
		case 'FRE':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type31']."\r\nHz\r\n";
			break;	
		case 'ENE':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type46']."\r\nWh\r\n";
			break;
		case 'THD':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type47']."\r\nTHD\r\n";
			break;
		case 'OXD':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type47']."\r\nmg/l\r\n";
			break;
		case 'TUR':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type23']."\r\nNTU\r\n";
			break;
		case 'ORP':
			return "ORP\r\nmV\r\n";
			break;
		case 'AIR':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type51']."\r\nmg/m3\r\n";
			break;
		case 'AMR':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']."\r\n \r\n";
			break;
		case 'BAT':
			return $idiomas[$_SESSION['opcion_idioma']]['supply2']."\r\nV\r\n";
			break;
		case 'COB':
			return $idiomas[$_SESSION['opcion_idioma']]['event_cobertura']."\r\n \r\n";
			break;
		case 'COG':
			return $idiomas[$_SESSION['opcion_idioma']]['event_cob_gprs']."\r\n \r\n";
			break;
			
		//AMB Sensores genéricos
		case 'CAU':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type87']."\r\nl/s\r\n";
			break;
		case 'MTS':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type90']."\r\nm\r\n";
			break;
		case 'MMS':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type89']."\r\nmm\r\n";
			break;
		case 'EVA':
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type88']."\r\nmm\r\n";
			break;
		default:
			return $idiomas[$_SESSION['opcion_idioma']]['sensor_type14']."\r\n \r\n";
			break;
	}
}
?>
