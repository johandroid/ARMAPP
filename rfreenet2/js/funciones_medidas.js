
function sConvertir_Inversa_Datos_Nodo(sDatosAux, sTipoSensorAux, sTipoEvento, sOperacion, sConstante, sMaximo, sMinimo)
{
	var dPreCalculador=0.0;
    var dCalculador=0.0;
    var iEnteroAux=0;
    var sResultado="0";

    if (sDatosAux.length > 0)
    {
	    if (sTipoSensorAux.length == 3)
	    {
	        if ((sTipoSensorAux != "BAT") && (sTipoSensorAux != "COB"))
	        {
	            switch (sTipoSensorAux[0])
	            {
	                // si es analogica
	                case '1':
	                    switch (sTipoSensorAux[2])
	                    {
	                        // ECHO-5
	                        case '1':
                                dPreCalculador = parseFloat(sDatosAux);
                                dPreCalculador = dPreCalculador / 100;
                                if (sTipoEvento == 'G')
                                {
                                	dCalculador = (dPreCalculador) / 0.00116;	
                                }
                                else
                                {
                                	dCalculador = (dPreCalculador + 0.48) / 0.00116;	
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // ECHO-10
	                        case '2':
	                           	dPreCalculador = parseFloat(sDatosAux);
                                dPreCalculador = dPreCalculador / 100;
                                if (sTipoEvento == 'G')
                                {
                                	dCalculador = (dPreCalculador) / 0.00078;
                                }
                                else
                                {
                                	dCalculador = (dPreCalculador + 0.376) / 0.00078;	
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // ECHO-20
	                        case '3':
	                            dPreCalculador = parseFloat(sDatosAux);
                                dPreCalculador = dPreCalculador / 100;
                                if (sTipoEvento == 'G')
                                {
                                	dCalculador = (dPreCalculador) / 0.000579;
                                }
                                else
                                {
                                	dCalculador = (dPreCalculador + 0.29) / 0.000579;	
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // 10HS
	                        case '4':
                                dPreCalculador = parseFloat(sDatosAux);
                                //dPreCalculador = dPreCalculador / 100;
                                if (sTipoEvento == 'G')
                                {
                                	//dCalculador = (Math.sqrt((0.000201*0.000201)+(4*0.000000584*(0.0582+dPreCalculador))))/(2*0.000000584);
                                	if (dPreCalculador<21)
                                	{
										dCalculador = ((dPreCalculador)/0.092);
									}
									else if (dPreCalculador<42)
									{
										dCalculador = ((dPreCalculador)/0.071);
									}
									else 
									{
										dCalculador = ((dPreCalculador)/0.13);
									}
                                }
                                else
                                {
                                	//dCalculador = (0.000201+Math.sqrt((0.000201*0.000201)+(4*0.000000584*(0.0582+dPreCalculador))))/(2*0.000000584);
                                	if (dPreCalculador<21)
                                	{
										dCalculador = ((dPreCalculador+48)/0.092);
									}
									else if (dPreCalculador<42)
									{
										dCalculador = ((dPreCalculador+33.5)/0.071);
									}
									else 
									{
										dCalculador = ((dPreCalculador+94.53)/0.13);
									}
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
								break;
								
	                        // LM61
	                        case '5':
	                           	dPreCalculador = parseFloat(sDatosAux);
	                           	if (sTipoEvento == 'G')
                                {
                                	dCalculador = (dPreCalculador) / 0.1;
                                }
                                else
                                {
                                	dCalculador = (dPreCalculador + 60) / 0.1;	
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // DSFW (FLUJO AIRE)
	                        case '6':
	                            dPreCalculador = parseFloat(sDatosAux);
	                            if (sTipoEvento == 'G')
                                {
                                	dCalculador = (Math.exp(dPreCalculador)*1024)/3;
                                }
                                else
                                {
                                	dCalculador = (Math.exp(dPreCalculador + 0.621)*1024)/3;	
                                }
                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        // Temperatura del agua 107
	                        case '7':
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	if (dPreCalculador == 162)
	                        	{
                                	sResultado = "00819";
                                }
                                else if (dPreCalculador == -42)
                                {
                                	sResultado = "00170";
                                }
                                else
                                {
                                	sResultado = "00000";
                                }	
	                            break;
	                            
	                         // Radiación Solar SRS100
	                        case '8':
	                            dCalculador = parseFloat(sDatosAux);
	                            iEnteroAux = parseInt(Math.round(((dCalculador * 1024)/3000)*1.67, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
							// HI 98143 pH
							case '9':
								dCalculador = parseFloat(sDatosAux);
				                iEnteroAux = parseInt(Math.round(((dCalculador * 1024)/3)/14, 0));
				                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
							// Conductividad 98143 pH
							case 'A':
								dCalculador = parseFloat(sDatosAux);
				                iEnteroAux = parseInt(Math.round(((dCalculador * 1024)/3)/10, 0));
				                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
								break;
								
							// Watermark 200TS
	                        case 'B':
							// ECT-Decagon
	                        case 'C':
	                            dPreCalculador = parseFloat(sDatosAux);
	                            if (dPreCalculador == 0)
	                            {
	                            	iEnteroAux = 0;
	                            }
	                            else
	                            {
									if (dPreCalculador<-32.85)
									{
										dCalculador = ((dPreCalculador+59.78)/0.1995);
									}
									else if (dPreCalculador<-16.98)
									{
										dCalculador = ((dPreCalculador+44.01)/0.0827);
									}
									else if (dPreCalculador<-1.83)
									{
										dCalculador = ((dPreCalculador+32.13)/0.0463);
									}
									else if (dPreCalculador<26.49)
									{
										dCalculador = ((dPreCalculador+22.5473)/0.0317);
									}
									else if (dPreCalculador<45)
									{
										dCalculador = ((dPreCalculador+26.67)/0.0343);
									}
									else if (dPreCalculador<60.66)
									{
										dCalculador = ((dPreCalculador+54.95)/0.0479);
									}
									else
									{
										dCalculador = ((dPreCalculador+120)/0.0748);
									}
	                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3000, 0));
	                            }
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
	                         // Generico
	                        default:
	                        	iMaximo = parseFloat(sMaximo);
								iMinimo = parseFloat(sMinimo);
								dPreCalculador = parseFloat(sDatosAux);
								if(iMaximo == 0 && iMinimo == 0)
								{
									sResultado = '00000';
								}
								else
								{
									dCalculador = Math.round(((dPreCalculador-iMinimo) / iMaximo), 3)
	                                iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3, 0));
    	                            sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
    	                        }
	                            break;
	                    }
	                    break;
	                    
	                // Si es veleta Davis
	                case 'B':
	    	        case 'b':
	    			    switch (sTipoSensorAux[2])
	                    {
	                        default:
	                        	dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	    	            break;
	                
	
	                // si es digital
	                case '2':
	                    switch (sTipoSensorAux[2])
	                    {
	                        // Presencia
	                        case '1':
	                        	iEnteroAux = parseInt(sDatosAux);
	                        	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // Pulsador
	                        case '2':
	                        	iEnteroAux = parseInt(sDatosAux);
	                        	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        // Nivel
	                        case '3':
	                        	iEnteroAux = parseInt(sDatosAux);
	                        	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // Generico
	                        default:
	                        	iEnteroAux = parseInt(sDatosAux);
	                        	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	
	                // si es Watermark
	                case '3':
	                    switch (sTipoSensorAux[2])
	                    {
	                    	// Conductividad del agua CS547A
	                    	case '1':
	                        	dPreCalculador = parseFloat(sDatosAux);
                                dCalculador = dPreCalculador/((1.408*0.99124)+dPreCalculador);
                                iEnteroAux = parseInt(Math.round(((dCalculador * 1024) / 3), 0),10);
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        default:
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	dCalculador = ((3*(dPreCalculador))+(7.407*0.55))/(dPreCalculador+(7.407));
	                        	iEnteroAux = parseInt(Math.round((dCalculador * 1024) / 3, 0),10);
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	
	                // si es 4-20
	                case '4':
	                case 'D':
	                case 'd':
	                    switch (sTipoSensorAux[2])
	                    {	
	                    	// Genérico
	                    	case '0':		                    			  
	                    		dCalculador = parseFloat(sDatosAux);
								iMaximo = parseFloat(sMaximo);
								iMinimo = parseFloat(sMinimo);
								if(iMaximo == 0 && iMinimo == 0)
								{
									sResultado = '00000';
								}
								else
								{
									dCalculador = Math.round(((dCalculador-iMinimo) / ((iMaximo - iMinimo)/ 16)+4), 2)
				                	dPreCalculador = (dCalculador*4096*6)/125;
                                    iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
				                	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				                }
								break;
	                    	// pH
	                    	case '1':
								dPreCalculador = parseFloat(sDatosAux);                                
                                if (sTipoEvento == 'G')
                                {
                                	dCalculador = (dPreCalculador-3)/0.875;
                                }
                                else
                                {
                                	dCalculador = ((dPreCalculador-3)/0.875)+4;	
                                }                                
                                dPreCalculador = (dCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
							// Oxigeno disuelto
	                    	case '2':
								dPreCalculador = parseFloat(sDatosAux);
                                if (sTipoEvento == 'G')
                                {
                                	dCalculador = dPreCalculador/(2*6.25);
                                }
                                else
                                {
                                	dCalculador = (dPreCalculador/(2*6.25))+4;	
                                }
                                dPreCalculador = (dCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dPreCalculador, 0));                                
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
                            // Oxigeno disuelto HI 8410
	                        case '3':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
	                        	{
	                        		dCalculador = dPreCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dCalculador = dPreCalculador*sConstante;
	                        	}
	                        		                        	
	                        	if (sTipoEvento == 'G')
                                {
                                	dPreCalculador = (dCalculador)*16/600;
                                }
                                else
                                {
                                	dPreCalculador = (dCalculador + 150)*16/600;	
                                }
                                dCalculador = (dPreCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
								
	                            break;
								
							 // Conductividad HI 8936DL
	                        case '4':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
	                        	{
	                        		dCalculador = dPreCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dCalculador = dPreCalculador*sConstante;
	                        	}
								if (sTipoEvento == 'G')
                                {
                                	dPreCalculador = dCalculador/(12.5);
                                }
                                else
                                {
                                	dPreCalculador = (dCalculador+50)/12.5;	
                                }
                                dCalculador = (dPreCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
							 // "HI 8711 pH"
	                        case '5':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
								{
									dCalculador = dPreCalculador/sConstante;
								}
								else
								{
									dCalculador = dPreCalculador*sConstante;
								}
								if (sTipoEvento == 'G')
								{
									dPreCalculador = dCalculador/(0.875);
								}
								else
								{
									dPreCalculador = (dCalculador+3.5)/0.875;	
								}
								dCalculador = (dPreCalculador*4096*6)/125;
								iEnteroAux = parseInt(Math.round(dCalculador, 0));
								sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
								break;
								
							// Turbidez 7685
	                        case '6':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
								{
								    dCalculador = dPreCalculador/sConstante;
								}
								else
								{
								    dCalculador = dPreCalculador*sConstante;
								}
								if (sTipoEvento == 'G')
								{
								    dPreCalculador = dCalculador/(25);
								}
								else
								{
								    dPreCalculador = ((dCalculador)+100)/25;	
								}
							    dCalculador = (dPreCalculador*4096*6)/125;
							    iEnteroAux = parseInt(Math.round(dCalculador, 0));
							    sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
							// HI 8615L ORP
	                        case '7':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
	                        	{
	                        		dCalculador = dPreCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dCalculador = dPreCalculador*sConstante;
	                        	}
								if (sTipoEvento == 'G')
                                {
                                	dPreCalculador = dCalculador/(0.125);
                                }
                                else
                                {
                                	dPreCalculador = (dCalculador+1.5)/0.125;	
                                }
                                dCalculador = (dPreCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        // Jumo Midas Presión 0..10 Ba
	                        case '8':
								dPreCalculador = parseFloat(sDatosAux);
								if(sOperacion == '0')
	                        	{
	                        		dCalculador = dPreCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dCalculador = dPreCalculador*sConstante;
	                        	}
								if (sTipoEvento == 'G')
                                {
                                	dPreCalculador = dCalculador/(0.625);
                                }
                                else
                                {
                                	dPreCalculador = (dCalculador+2.5)/0.625;	
                                }
                                dCalculador = (dPreCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        default:
	                        	dPreCalculador = parseFloat(sDatosAux);
                        		dCalculador = (dPreCalculador*4096*6)/125;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	                    
	                 // si es 0..10
	    			case 'C':
	    	        case 'c':
	    			    switch (sTipoSensorAux[2])
	                    {
	                    	case '0':	  	                    		                	  
	                    		dCalculador = parseFloat(sDatosAux);
								iMaximo = parseFloat(sMaximo);
								iMinimo = parseFloat(sMinimo);
								if(iMaximo == 0 && iMinimo == 0)
								{
									sResultado = '00000';
								}
								else
								{
									dCalculador = (dCalculador-iMinimo) / ((iMaximo - iMinimo)/10);				
				                	dPreCalculador = dCalculador*1024/3;
                                    iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
				                	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				                }
								break;	                    	
							//NO2 uGard
	                    	case '1':
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	dCalculador = (dPreCalculador*1024)/(3*3.3*20.3*2);
	                        	if(sOperacion == '0')
	                        	{
	                        		dPreCalculador = dCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dPreCalculador = dCalculador*sConstante;
	                        	}
                                iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
                           //NO uGard
	                    	case '2':
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	dCalculador = (dPreCalculador*1024)/(3*3.3*1.32*2.5);
	                        	if(sOperacion == '0')
	                        	{
	                        		dPreCalculador = dCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dPreCalculador = dCalculador*sConstante;
	                        	}
                                iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                        //CO uGard
	                    	case '3':
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	dCalculador = (dPreCalculador*1024)/(3*3.3*1.23*30);
	                        	if(sOperacion == '0')
	                        	{
	                        		dPreCalculador = dCalculador/sConstante;
	                        	}
	                        	else
	                        	{
	                        		dPreCalculador = dCalculador*sConstante;
	                        	}
                                iEnteroAux = parseInt(Math.round(dPreCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                        default:
	                        	dPreCalculador = parseFloat(sDatosAux);
	                        	dCalculador = (dPreCalculador *4096*4)/43.0;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	    	            break;
	
	                // si es salida digital
	                case '5':
	                    switch (sTipoSensorAux[2])
	                    {
	                        default:
	                        	dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	                    
	                 // si es contador de pulsos
	                 case '7':
	                    switch (sTipoSensorAux[2])
	                    {
	                    	// Pluviómetro
	                    	case '1':
	                    		dCalculador = parseFloat(sDatosAux);
				                iEnteroAux = parseInt(Math.round((dCalculador / 0.2), 0));
				                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
								
							// Anemómetro Davis
	                    	case '2':
	                    		dCalculador = parseFloat(sDatosAux);
				                iEnteroAux = parseInt(Math.round((dCalculador / (1.006*3.6/100)), 0));
				                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                            
	                        default:
	                        	dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	
	                // Si es sensirion
	                case '6':
	                    switch (sTipoSensorAux[1])
	                    {
	                        // SENSIRION SHT1X (Humedad)
	                        case '2':
	                        case '4':
	                        case '6':
	                        	dCalculador = parseFloat(sDatosAux)*100;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	
	                        // SENSIRION SHT1X (Temperatura)
	                        case '1':
	                        case '3':
	                        case '5':
	                        	dCalculador = (parseFloat(sDatosAux)+100)*100;
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                        // Generico
	                        default:
	                            dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	                
	                // Rotación de motor    
					case 'E':
					case 'e':
	                    switch (sTipoSensorAux[2])
	                    {
	                        default:
	                        	dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	                    
	                 // Humedad Digital
                    case '8':
                    	switch (sTipoSensorAux[2])
	                    {
	                    	// 5TE Turba  
							case '1':
								dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{
									if (dPreCalculador < 0.28)
									{
										dCalculador = (dPreCalculador+0.18)/0.048;
									}
									else if (dPreCalculador < 0.52)
									{
										dCalculador = (dPreCalculador-0.0052)/0.02883;
									}
									else
									{
										dCalculador = (dPreCalculador-0.292)/0.013;
									}
								}
								dCalculador=dCalculador*50;
								break;
								
							// 5TE Lana Roca
							case '2':
								dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{									
									dCalculador = (0.0656+Math.sqrt(0.004482112-(0.00672*dPreCalculador)))/0.00336;									
								}
								dCalculador=dCalculador*50;								
								break;
								
							// 5TE Perlite
							case '3':
								dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{
									dCalculador = (0.0525-Math.sqrt(0.00246307-(0.00428*dPreCalculador)))/0.00214;	
								}								
								dCalculador=dCalculador*50;								
								break;
								
							// GS3 Suelo Mineral
							case '4':
								dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{
									if (dPreCalculador <= 0.3)
									{
										dCalculador = (dPreCalculador*40)+2;
									}
									else if (dPreCalculador <=0.5)
									{
										dCalculador = (dPreCalculador*80)-10;
									}
									else if (dPreCalculador <= 0.7)
									{
										dCalculador = (dPreCalculador*170)-55;
									}
									else
									{
										dCalculador = (dPreCalculador*(16/0.3))+(128/4.8);
									}
								}			
								dCalculador=dCalculador*100;						
								break;	
								
							//GS3 Turba/Perlite							
							case '5':
								dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{	
									dCalculador = Math.pow((dPreCalculador + 0.117)/0.118, 2);									
								}
								dCalculador=dCalculador*100;	
								break;
								
							//VP3 Humedad							
							case '6':
								dCalculador=parseFloat(sDatosAux)*100;	
								break;

							// Suelo Mineral
							case '0':
	                    	default:
	                    		dPreCalculador = parseFloat(sDatosAux)/100;
								if (sTipoEvento == 'G')
								{
									dCalculador = dPreCalculador;
								}
								else 
								{
									if (dPreCalculador < 0.2)
									{
										dCalculador = (dPreCalculador+0.044)/0.0229;
									}
									else if (dPreCalculador < 0.4187)
									{
										dCalculador = (dPreCalculador-0.057)/0.0134;
									}
									else if (dPreCalculador < 0.6348)
									{
										dCalculador = (dPreCalculador-0.23459)/0.00683;
									}
									else
									{
										dCalculador = (dPreCalculador+0.0651)/0.01195;
									}
								}
								dCalculador=dCalculador*50;
								break;
	                    }
	                    iEnteroAux = parseInt(Math.round(dCalculador, 0));
                    	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                        break;

                    // Conductividad Digital / Presión Atm.
                    case '9':
                    	switch (sTipoSensorAux[2])
	                    {
	                    	//GS3
							case '1':
									dPreCalculador = parseFloat(sDatosAux);
			               			if (dPreCalculador < 0)
			                        {
			                            dPreCalculador = 0;
			                        }	
			                        if (dPreCalculador > 6.55)
			                        {
			                            dPreCalculador = 6.55;
			                        }									                        
									dCalculador = Math.round(dPreCalculador * 10000, 0);
								break;
								
							//VP3 Presión							
							case '2':
								dPreCalculador = parseFloat(sDatosAux);
								dCalculador = Math.round(dPreCalculador * 100, 0);
								break;
								
							// 5TE
							case '0':
		                    	dPreCalculador = parseFloat(sDatosAux);
		               			if (dPreCalculador < 0)
		                        {
		                            dPreCalculador = 0;
		                        }	
		                        if (dPreCalculador > 23.1)
		                        {
		                            dPreCalculador = 23.1;
		                        }
		                        if (dPreCalculador <= 7)
		                        {
		                            dCalculador = Math.round(dPreCalculador * 100, 0);
		                        }
		                        else
		                        {
		                        	if (sTipoEvento == 'G')
		                            {
		                            	dCalculador = Math.round((20 * dPreCalculador), 0);
		                            }
		                            else
		                            {
		                            	dCalculador = Math.round(((20 * dPreCalculador) + 560), 0);	
		                            }           
		                        }							
								break;
						}                    

                        iEnteroAux = parseInt(Math.round(dCalculador, 0));
                        sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                        break;

                    // Temperatura Digital
                    case 'A':
                    case 'a':
                    	switch (sTipoSensorAux[2])
	                    {
	                    	//GS3
							case '1':
			                    	dPreCalculador = parseFloat(sDatosAux);
			                        if (dPreCalculador < -40)
			                        {
			                            dPreCalculador = -40;
			                        }
			                        if (dPreCalculador > 50)
			                        {
			                            dPreCalculador = 50;
			                        }							
									dCalculador = dPreCalculador*100;
									iEnteroAux = parseInt(Math.round(dCalculador, 0));
								break;
								
							//VP3							
							case '2':
								dPreCalculador = parseFloat(sDatosAux);
								dCalculador = Math.round(dPreCalculador * 100, 0);
								iEnteroAux = parseInt(Math.round(dCalculador, 0));
								break;
								
							// 5TE
							case '0':                    
		                    	dPreCalculador = parseFloat(sDatosAux);
		                        if (dPreCalculador < -40)
		                        {
		                            dPreCalculador = -40;
		                        }
		                        if (dPreCalculador > 62.2)
		                        {
		                            dPreCalculador = 62.2;
		                        }
		                        if (sTipoEvento == 'G')
		                        {
		                        	iEnteroAux = Math.round((10*dPreCalculador), 0);
		                        }
		                        else
		                        {
		                        	iEnteroAux = Math.round((10*dPreCalculador) + 400, 0);	
		                        }
								break;
						} 		                
						        
                        sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                        break;
                        
                     // si es AMR
	                case 'F':
	                case 'f':
	                    switch (sTipoSensorAux[2])
	                    {
	                        default:
	                        	dCalculador = parseFloat(sDatosAux);
                                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                            break;
	                    }
	                    break;
	
	                // en caso de no ser ninguno conocido
	                default:
	                	dCalculador = parseFloat(sDatosAux);
                        iEnteroAux = parseInt(Math.round(dCalculador, 0));
                        sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
	                    break;
	            }
	        }
	    }
	    else
	    {
	    	sResultado = sDatosAux;	
	    }
    }
    //alert('Convertido TS='+sTipoSensorAux+' VALOR='+sDatosAux+' TOTAL='+sResultado);
    return sResultado;
}

function sConvertir_Inversa_Datos_Sensor_GW(sValorConvertido, sTipoSensorAux, sMaximo, sMinimo, caVersionHWIN)
{
    var dCalculador=0.0;
    var iMaximo = 0;
    var iMinimo = 0;
    var iMaximoFloat = 0;
    var iMinimoFloat = 0;
    var dCalculador=0.0;
    var iEnteroAux=0;
    var iFloatAux=0.0;
    var sResultado="0";
    var iResGW1;
    var iResGW2;
    var iResGW3;

    switch (parseInt(caVersionHWIN))
	{		
		case 12:
			iResGW1 = 4096;
			iResGW2 = 4096;
			break;
		case 11:
			iResGW1 = 256;
			iResGW2 = 4096;
			break;
		case 10:
		default:
			iResGW1 = 256;
			iResGW2 = 256;		
			break;
	}

    if (sValorConvertido.length > 0)
    {
        switch (parseInt(sTipoSensorAux))
        {
        	//Humedad
			case 7:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(((dCalculador * (iResGW1))/(3.3*40)), 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
				
            //Pluviometro
            case 8:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round((dCalculador / 0.2), 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
                    
            // Anemometro Davis
			case 9:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round((dCalculador / (1.006*3.6/1000)), 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
				
			// Veleta Davis
			case 10:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
                    
			//Temperatura			
			case 11:			
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(((((dCalculador+40)) * iResGW1)/(3.3*48)), 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
				
			// PYR
			case 12:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(((dCalculador * iResGW1)/3300)*1.67, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
        	//Humedad
			case 30:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(dCalculador * 100 / 4, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;		
			//Temperatura Low Power		
			case 31:			
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round((dCalculador+40)/48*1000, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;									
			// PYR Low Power
			case 32:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round(dCalculador*1.67, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break; 	
			// Veleta Low Power
			case 33:
				dCalculador = parseFloat(sValorConvertido);
                //iEnteroAux = parseInt(Math.round(dCalculador*25/3.3, 0));
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;     			
             // Anemometro Davis
			case 34:
				dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round((dCalculador / (1.006*3.6/60)), 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
			case 35:
				dCalculador = parseFloat(sValorConvertido);
				iMaximo = parseInt(sMaximo);
				iMinimo = parseInt(sMinimo);
				if(iMaximo == 0 && iMinimo == 0)
				{
					sResultado = '00000';
				}
				else
				{
					iEnteroAux = parseInt(Math.round(((dCalculador-iMinimo) / ((iMaximo - iMinimo)/ 16)+4)*100, 0));
                	
                	if(iEnteroAux <= 0)
					{
						iEnteroAux = 0;
					}
                	
                	sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                }
				break;
			case 36:
				dCalculador = parseFloat(sValorConvertido);
				iMaximo = parseInt(sMaximo);
				iMinimo = parseInt(sMinimo);				
				if(iMaximo == 0 && iMinimo == 0)
				{
					sResultado = '00000';
				}
				else
				{
					iFloatAux = parseInt(Math.round(((dCalculador-iMinimo) / ((iMaximo - iMinimo)/10000)), 0));
					if(iFloatAux <= 0)
					{
						iFloatAux = 0;
					}
	                sResultado = pad_izquierda(iFloatAux.toString(),5,'0');
				}
                
				break;	
			// Analogicos genericos
        	case 2:        	
        	// Evaporimetro
			case 16:	
				dCalculador = parseFloat(sValorConvertido);
				iMaximoFloat = parseFloat(sMaximo);
				iMinimoFloat = parseFloat(sMinimo);	
				
				if((iMaximoFloat == 0) || (dCalculador == 0))
				{
					sResultado = '00000';					
				}
				else
				{
					iFloatAux = parseFloat(Math.round((dCalculador-iMinimoFloat)/iMaximoFloat * iResGW2/3.3), 0);	
	                sResultado = pad_izquierda(iFloatAux.toString(),5,'0');	
				}
				break;
			// Resto Analogicos genericos
			case 21:
        	case 22:
        	case 23:
        	case 24:
        	case 25:
        	case 26:
        		dCalculador = parseFloat(sValorConvertido);
				iMaximoFloat = parseFloat(sMaximo);
				iMinimoFloat = parseFloat(sMinimo);	
				
				if((iMaximoFloat == 0) || (dCalculador == 0))
				{
					sResultado = '00000';					
				}
				else
				{
					iFloatAux = parseFloat(Math.round((dCalculador-iMinimoFloat)/iMaximoFloat * iResGW1/3.3), 0);	
	                sResultado = pad_izquierda(iFloatAux.toString(),5,'0');	
				}
				break;
        	
			// ECHO-5
            case 37:
                dPreCalculador = parseFloat(sValorConvertido);
                dPreCalculador = dPreCalculador / 100;
                dCalculador = (dPreCalculador  + 0.48) / (0.00116 * 0.85);	
				iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;

            // ECHO-10
            case 38:
               	dPreCalculador = parseFloat(sValorConvertido);
                dPreCalculador = dPreCalculador / 100;
                dCalculador = (dPreCalculador + 0.376) / (0.00078 * 0.85);	
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;

            // ECHO-20
            case 39:
                dPreCalculador = parseFloat(sValorConvertido);
                dPreCalculador = dPreCalculador / 100;
                dCalculador = (dPreCalculador + 0.29) / (0.000579 * 0.85);	
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;

            // 10HS
            case 40:
                dPreCalculador = parseFloat(sValorConvertido);
            	if (dPreCalculador<21)
            	{
					dCalculador = ((dPreCalculador+48)/0.092);
				}
				else if (dPreCalculador<42)
				{
					dCalculador = ((dPreCalculador+33.5)/0.071);
				}
				else 
				{
					dCalculador = ((dPreCalculador+94.53)/0.13);
				}
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
				
            // LM61
            case 41:
               	dPreCalculador = parseFloat(sValorConvertido);
               	dCalculador = (dPreCalculador + 60) / 0.1;	
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;

            // DSFW (FLUJO AIRE)
            case 42:
                dPreCalculador = parseFloat(sValorConvertido);
                dCalculador = (Math.exp(dPreCalculador/0.621)*1000);	
                iEnteroAux = parseInt(Math.round(dCalculador, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;
                
            // Temperatura del agua 107
            case 43:
            	dPreCalculador = parseFloat(sValorConvertido);
            	if (dPreCalculador == 162)
            	{
                	sResultado = "00819";
                }
                else if (dPreCalculador == -42)
                {
                	sResultado = "00170";
                }
                else
                {
                	sResultado = "00000";
                }	
                break;
                
             // Radiación Solar SRS100
            case 44:
                dCalculador = parseFloat(sValorConvertido);
                iEnteroAux = parseInt(Math.round((dCalculador)*1.67, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;
			// HI 98143 pH
			case 45:
				dCalculador = parseFloat(sValorConvertido);
				iEnteroAux = parseInt(Math.round((dCalculador * 1000)/14, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
                break;
				
			// Conductividad 98143 pH
			case 46:
				dCalculador = parseFloat(sValorConvertido);
				iEnteroAux = parseInt(Math.round((dCalculador * 1000)/10, 0));
                sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;						          									                   
            // Digital
            case 3:
            case 4:
            case 5:
            case 6:
            case 17:
            case 18:
            case 19:
            case 20:
            //Cont.Pulsos
			case 13:
			case 14:
			case 15:
			case 0:
			default:
				iEnteroAux = parseInt(sValorConvertido);
				sResultado = pad_izquierda(iEnteroAux.toString(),5,'0');
				break;
        }
    }
    return sResultado;
}
