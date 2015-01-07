function Actualizar_Lista_Puertos(m_ISE,m_PSE)
{
	switch (document.getElementById(m_ISE).selectedIndex)
    {
        // si es analogica o digital o Watermark o salida o contador de pulsos (y promediados)
        case 0:
        case 1:
        case 2:
        case 4:
        case 6:
        case 7:
        case 8:
        case 9:
        case 10:
        case 14:
        	document.getElementById(m_PSE).length = 0;
        	insertarOptionCombo(m_PSE,"PSE0","1");
        	insertarOptionCombo(m_PSE,"PSE1","2");
        	insertarOptionCombo(m_PSE,"PSE2","3");
        	insertarOptionCombo(m_PSE,"PSE3","4");
            document.getElementById(m_PSE).selectedIndex = 0;
            break;

        // si es 4-20
        case 3:
        case 12:
       	// o 0-10V
    	case 11:
        	document.getElementById(m_PSE).length = 0;
        	insertarOptionCombo(m_PSE,"PSE0","1");
        	insertarOptionCombo(m_PSE,"PSE1","2");
        	insertarOptionCombo(m_PSE,"PSE2","3");
        	insertarOptionCombo(m_PSE,"PSE3","4");
            document.getElementById(m_PSE).selectedIndex = 0;
            break;

        // si es Sensirion
        case 5:        
        	document.getElementById(m_PSE).length = 0;
        	insertarOptionCombo(m_PSE,"PSE0",iObtener_Cadena_AJAX("sensor_mag_temp")+" i2c");
        	insertarOptionCombo(m_PSE,"PSE1",iObtener_Cadena_AJAX("sensor_mag_hum")+" i2c");
        	insertarOptionCombo(m_PSE,"PSE2",iObtener_Cadena_AJAX("sensor_mag_temp")+" A1");
        	insertarOptionCombo(m_PSE,"PSE3",iObtener_Cadena_AJAX("sensor_mag_hum")+" A1");
        	insertarOptionCombo(m_PSE,"PSE4",iObtener_Cadena_AJAX("sensor_mag_temp")+" A4");
        	insertarOptionCombo(m_PSE,"PSE5",iObtener_Cadena_AJAX("sensor_mag_hum")+" A4");
            document.getElementById(m_PSE).selectedIndex = 0;
            break;
            
		// si es de rotación de motor		            
		case 13:
			document.getElementById(m_PSE).length = 0;
        	insertarOptionCombo(m_PSE,"PSE0","1");
        	insertarOptionCombo(m_PSE,"PSE1","2");
        	insertarOptionCombo(m_PSE,"PSE2","3");
        	insertarOptionCombo(m_PSE,"PSE3","4");
            document.getElementById(m_PSE).selectedIndex = 0;
			break;

        // en caso de no ser ninguno conocido
        default:
        	document.getElementById(m_PSE).length = 0;
        	insertarOptionCombo(m_PSE,"PSE0","1");
            document.getElementById(m_PSE).selectedIndex = -1;
            break;
    }
}
function Actualizar_Lista_Sensores(m_ISE,m_TSE)
{
	switch (document.getElementById(m_ISE).selectedIndex)
    {
        // si es analogica
        case 0:
        	document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
        	insertarOptionCombo(m_TSE,"TSE1","ECHO-5");
        	insertarOptionCombo(m_TSE,"TSE2","ECHO-10");
        	insertarOptionCombo(m_TSE,"TSE3","ECHO-20");
        	insertarOptionCombo(m_TSE,"TSE4","10HS");
        	insertarOptionCombo(m_TSE,"TSE5","LM61");
        	insertarOptionCombo(m_TSE,"TSE6","DSFW "+iObtener_Cadena_AJAX("sensor_type13"));
        	insertarOptionCombo(m_TSE,"TSE7",iObtener_Cadena_AJAX("sensor_type16") + " 107");
        	insertarOptionCombo(m_TSE,"TSE8",iObtener_Cadena_AJAX("sensor_type21") + " SRS100");
        	insertarOptionCombo(m_TSE,"TSE9","HI 98143 pH");
        	insertarOptionCombo(m_TSE,"TSEA","HI 98143 "+iObtener_Cadena_AJAX("sensor_type3"));
        	insertarOptionCombo(m_TSE,"TSEB","Watermark 200TS");
        	insertarOptionCombo(m_TSE,"TSEC","EC-T Decagon");        	
            document.getElementById(m_TSE).selectedIndex = 0;
            break;

        // si es digital
        case 1:
        	document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
        	insertarOptionCombo(m_TSE,"TSE1",iObtener_Cadena_AJAX("sensor_type15"));
        	insertarOptionCombo(m_TSE,"TSE2",iObtener_Cadena_AJAX("sensor_type11"));
        	insertarOptionCombo(m_TSE,"TSE3",iObtener_Cadena_AJAX("sensor_type17"));        	
            document.getElementById(m_TSE).selectedIndex = 0;
            break;

        // Si es Humedad Digital
        case 7:
        	document.getElementById(m_TSE).length = 0;
            insertarOptionCombo(m_TSE,"TSE0","5TE " + iObtener_Cadena_AJAX("sensor_soil1"));
        	insertarOptionCombo(m_TSE,"TSE1","5TE " + iObtener_Cadena_AJAX("sensor_soil2"));
        	insertarOptionCombo(m_TSE,"TSE2","5TE " + iObtener_Cadena_AJAX("sensor_soil3"));
        	insertarOptionCombo(m_TSE,"TSE3","5TE " + iObtener_Cadena_AJAX("sensor_soil4"));
            insertarOptionCombo(m_TSE,"TSE4","GS3 " + iObtener_Cadena_AJAX("sensor_soil1"));
        	insertarOptionCombo(m_TSE,"TSE5","GS3 " + iObtener_Cadena_AJAX("sensor_soil5"));
        	insertarOptionCombo(m_TSE,"TSE6","VP3 " + iObtener_Cadena_AJAX("sensor_type1"));
        	document.getElementById(m_TSE).selectedIndex = 0;
        	break;
           
       	// si es 4-20
        case 3:
        case 12:
        	document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
        	insertarOptionCombo(m_TSE,"TSE1","WQ201 pH");
        	insertarOptionCombo(m_TSE,"TSE2","WQ401 "+iObtener_Cadena_AJAX("sensor_type20"));
        	insertarOptionCombo(m_TSE,"TSE3","HI 8410 "+iObtener_Cadena_AJAX("sensor_type20"));
        	insertarOptionCombo(m_TSE,"TSE4","HI 8936DL "+iObtener_Cadena_AJAX("sensor_type3"));
        	insertarOptionCombo(m_TSE,"TSE5","HI 8711 pH");
        	insertarOptionCombo(m_TSE,"TSE6","TU 7685 "+iObtener_Cadena_AJAX("sensor_type23"));
        	insertarOptionCombo(m_TSE,"TSE7","HI 8615L ORP");
        	insertarOptionCombo(m_TSE,"TSE8","JUMO "+iObtener_Cadena_AJAX('sensor_type22')+" 0..10 Ba");
            document.getElementById(m_TSE).selectedIndex = 0;
        	break;
        
        // o Watermark
    	case 2:
    		document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
        	insertarOptionCombo(m_TSE,"TSE1",iObtener_Cadena_AJAX("sensor_type18") + " CS547A");
            document.getElementById(m_TSE).selectedIndex = 0;
    		break;
    		
    	// o contador de pulsos
    	case 6:
    		document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
    		insertarOptionCombo(m_TSE,"TSE1",iObtener_Cadena_AJAX("sensor_type6"));
        	insertarOptionCombo(m_TSE,"TSE2",iObtener_Cadena_AJAX("sensor_anem_davis"));
        	document.getElementById(m_TSE).selectedIndex = 0;
        	break;
		// 0-10V
    	case 11:  
    		document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
        	insertarOptionCombo(m_TSE,"TSE1",iObtener_Cadena_AJAX("sensor_type48"));
        	insertarOptionCombo(m_TSE,"TSE2",iObtener_Cadena_AJAX("sensor_type49"));
        	insertarOptionCombo(m_TSE,"TSE3",iObtener_Cadena_AJAX("sensor_type50"));
            document.getElementById(m_TSE).selectedIndex = 0;
            break;
    	// Si es Conductividad Digital / Presión
        case 8:
			document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0","5TE " + iObtener_Cadena_AJAX("sensor_type3"));
        	insertarOptionCombo(m_TSE,"TSE1","GS3 " + iObtener_Cadena_AJAX("sensor_type3"));
        	insertarOptionCombo(m_TSE,"TSE2","VP3 " + iObtener_Cadena_AJAX("sensor_type22"));
        	document.getElementById(m_TSE).selectedIndex = 0;        
        	break;
        // Si es Temperatura Digital
        case 9:        
			document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0","5TE " + iObtener_Cadena_AJAX("sensor_type2"));
        	insertarOptionCombo(m_TSE,"TSE1","GS3 " + iObtener_Cadena_AJAX("sensor_type2"));
        	insertarOptionCombo(m_TSE,"TSE2","VP3 " + iObtener_Cadena_AJAX("sensor_type2"));
        	document.getElementById(m_TSE).selectedIndex = 0;
			break;            
        // Si es de rotación de motor
        case 13:
        // si es salida digital 
        case 4:
        // Si es sensirion
        case 5:        

         // si es AMR
        case 14:
        // si es Veleta Davis
        case 10:  
        // en caso de no ser ninguno conocido
        default:
        	document.getElementById(m_TSE).length = 0;
        	insertarOptionCombo(m_TSE,"TSE0",iObtener_Cadena_AJAX("sensor_type14"));
            document.getElementById(m_TSE).selectedIndex = 0;
            break;
    }
}

function Rellenar_Controles_Nodo(m_TNO,m_SEN,m_ISE,m_PSE,m_TSE,m_OPE)
{
	insertarOptionCombo(m_TNO,"TNO0",iObtener_Cadena_AJAX("supply1"));
	insertarOptionCombo(m_TNO,"TNO1",iObtener_Cadena_AJAX("supply2"));
	insertarOptionCombo(m_TNO,"TNO2",iObtener_Cadena_AJAX("supply3"));
	//insertarOptionCombo(m_TNO,"TNO3",iObtener_Cadena_AJAX("supply4"));
	
	insertarOptionCombo(m_SEN,"SEN0",iObtener_Cadena_AJAX("general_no"));
	insertarOptionCombo(m_SEN,"SEN1",iObtener_Cadena_AJAX("general_si"));

	insertarOptionCombo(m_ISE,"ISE0",iObtener_Cadena_AJAX("sensor_type4"));
	insertarOptionCombo(m_ISE,"ISE1",iObtener_Cadena_AJAX("sensor_type5"));
	insertarOptionCombo(m_ISE,"ISE2","Watermark");
	insertarOptionCombo(m_ISE,"ISE3","4-20mA");
	insertarOptionCombo(m_ISE,"ISE4",iObtener_Cadena_AJAX("sensor_type12"));
	insertarOptionCombo(m_ISE,"ISE5","Sensirion");
	insertarOptionCombo(m_ISE,"ISE6",iObtener_Cadena_AJAX("sensor_type9"));
	insertarOptionCombo(m_ISE,"ISE7",iObtener_Cadena_AJAX("sensor_hum_digital"));
	insertarOptionCombo(m_ISE,"ISE8",iObtener_Cadena_AJAX("sensor_cond_digital"));
	insertarOptionCombo(m_ISE,"ISE9",iObtener_Cadena_AJAX("sensor_temp_digital"));
	insertarOptionCombo(m_ISE,"ISEA",iObtener_Cadena_AJAX("sensor_vel_davis"));
	insertarOptionCombo(m_ISE,"ISEB","0..10V");
	insertarOptionCombo(m_ISE,"ISEC","4-20mA "+iObtener_Cadena_AJAX("sensor_sens_promedio"));
	insertarOptionCombo(m_ISE,"ISED",iObtener_Cadena_AJAX("sensor_type19"));
	insertarOptionCombo(m_ISE,"ISEE","AMR");

	Actualizar_Lista_Puertos(m_ISE,m_PSE);
	Actualizar_Lista_Sensores(m_ISE,m_TSE);
	
	insertarOptionCombo(m_OPE,"OPE0",iObtener_Cadena_AJAX("param70"));
	insertarOptionCombo(m_OPE,"OPE1",iObtener_Cadena_AJAX("param71"));
}

function vOnChangeSensorType(m_ISE,m_PSE,m_TSE)
{
	if (document.getElementById(m_ISE).selectedIndex != -1)
	{
		// Si se trata de temperatura de agua 107, bloqueamos los umbrales y grandientes
		if ((document.getElementById(m_ISE).selectedIndex==0) && (document.getElementById(m_TSE).selectedIndex == 7))
		{
			document.getElementById('UMS').disabled="disabled";
			document.getElementById('UNS').disabled="disabled";
			document.getElementById('GMS').disabled="disabled";
			document.getElementById('TGS').disabled="disabled";
			document.getElementById('UMS').value="162";
			document.getElementById('UNS').value="-42";
			document.getElementById('GMS').value="0";
			document.getElementById('TGS').value="0";
		}
		// Si el sensor es 10HS, 5TE Humedad o Watermark, no podremos configurar gradientes
		else if ((((document.getElementById(m_ISE).selectedIndex==0)
					|| (document.getElementById(m_ISE).selectedIndex==10))
				&& (document.getElementById(m_TSE).selectedIndex == 4))
				|| (document.getElementById(m_ISE).selectedIndex==2)
				|| (document.getElementById(m_ISE).selectedIndex==7))
		{
			document.getElementById('UMS').disabled="";
			document.getElementById('UNS').disabled="";
			document.getElementById('GMS').disabled="disabled";
			document.getElementById('GMS').value='0';
			document.getElementById('TGS').disabled="disabled";
			document.getElementById('TGS').value='0';
		}
		else
		{
			document.getElementById('UMS').disabled="";
			document.getElementById('UNS').disabled="";
			document.getElementById('GMS').disabled="";
			document.getElementById('TGS').disabled="";
		}
		
		//Si es un 0..10V o 4-20mA hay que permitir en cambio en constante y operacion
		if (((document.getElementById(m_ISE).selectedIndex==11)
				&& (document.getElementById(m_TSE).selectedIndex>0) && (document.getElementById(m_TSE).selectedIndex<4))
			|| (((document.getElementById(m_ISE).selectedIndex==3) || (document.getElementById(m_ISE).selectedIndex==12))
				&& (document.getElementById(m_TSE).selectedIndex>2) && (document.getElementById(m_TSE).selectedIndex<9)))
		{
			document.getElementById('OPE').disabled="";
			document.getElementById('CON').disabled="";
		}
		else
		{
			document.getElementById('OPE').disabled="disabled";
			document.getElementById('CON').disabled="disabled";
		}
		
		
		vActualizar_Unidades(m_ISE,m_PSE,m_TSE);
	}
}

function vActualizar_Unidades(m_ISE, m_PSE, m_TSE)
{
    switch (document.getElementById(m_ISE).selectedIndex)
    {
	    // si es analogica
	    case 0:	    
	        switch (document.getElementById(m_TSE).selectedIndex)
	        {
	            // ECHO-5
	            case 1:
	            // ECHO-10
	            case 2:
	            // ECHO-20
	            case 3:
	            // 10HS
	            case 4:
	            	document.getElementById('UM_unit').innerHTML="%";
					document.getElementById('UN_unit').innerHTML="%";
	                break;
	
	            // LM61
	            case 5:
	           	// Temperatura del agua 107
	            case 7:
	           	// Temperatura Watermark 200TS
				case 11:
				// Temperatura EC-T Decagon
				case 12:
	            	document.getElementById('UM_unit').innerHTML="ºC";
					document.getElementById('UN_unit').innerHTML="ºC";
					break;
	
	            // DSFW (FLUJO AIRE)
	            case 6:
	            	document.getElementById('UM_unit').innerHTML="m/s";
					document.getElementById('UN_unit').innerHTML="m/s";
	                break;
	                
	            // Radiación Solar SRS100
	            case 8:
	            	document.getElementById('UM_unit').innerHTML="W/m2";
					document.getElementById('UN_unit').innerHTML="W/m2";
	                break;
	            //HI 98143 pH
	            case 9:
	            	document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	            //HI 98143 Conductividad
	            case 10:
	            	document.getElementById('UM_unit').innerHTML="dS/m";
					document.getElementById('UN_unit').innerHTML="dS/m";
	                break;
	
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="V";
					document.getElementById('UN_unit').innerHTML="V";
	                break;
	        }
	        break;
	        
	    // Si es veleta davis
	    case 10:
	    switch (document.getElementById(m_TSE).selectedIndex)
        {
            // Generico
            default:
            	document.getElementById('UM_unit').innerHTML="º";
				document.getElementById('UN_unit').innerHTML="º";
                break;
        }
        break;
	
	    // si es digital
	    case 1:
	    	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	            // Presencia
	            case 1:
		            document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	
	            // Pulsador
	            case 2:
		            document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	                
	            // Nivel
	            case 3:
		            document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	        }
	        break;
	
	    // si es Watermark
	    case 2:
        	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	        	// Conductividad CS547A
	            case 1:
		            document.getElementById('UM_unit').innerHTML="dS/m";
					document.getElementById('UN_unit').innerHTML="dS/m";
	                break;

	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="kPa";
					document.getElementById('UN_unit').innerHTML="kPa";
	                break;
	        }
	        break;
	
	    // si es 4-20
	    case 3:
	    case 12:
	    	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	        	// pH
	            case 1:
		            document.getElementById('UM_unit').innerHTML="pH";
					document.getElementById('UN_unit').innerHTML="pH";
	                break;
	
	            // Oxigeno disuelto
	            case 2:
		            document.getElementById('UM_unit').innerHTML="%";
					document.getElementById('UN_unit').innerHTML="%";
	                break;
	                
	            //HI 8410 Oxigeno disuelto
	            case 3:
		            document.getElementById('UM_unit').innerHTML="%";
					document.getElementById('UN_unit').innerHTML="%";
	                break;
	                
	            //HI 8936DL Conductividad
	            case 4:
		            document.getElementById('UM_unit').innerHTML="uS/cm";
					document.getElementById('UN_unit').innerHTML="uS/cm";
	                break;
	                
	            //HI 8711 pH
	            case 5:
		            document.getElementById('UM_unit').innerHTML="pH";
					document.getElementById('UN_unit').innerHTML="pH";
	                break;
	                
	            //TU 7685 Turbidez
	            case 6:
		            document.getElementById('UM_unit').innerHTML="NTU";
					document.getElementById('UN_unit').innerHTML="NTU";
	                break;
	                
	            //HI 8615L ORP
	            case 7:
		            document.getElementById('UM_unit').innerHTML="mV";
					document.getElementById('UN_unit').innerHTML="mV";
	                break;
	                
	            // Jumo Presión 0..10 Ba
	            case 8:
		            document.getElementById('UM_unit').innerHTML="Ba";
					document.getElementById('UN_unit').innerHTML="Ba";
	                break;
	                
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="mA";
					document.getElementById('UN_unit').innerHTML="mA";
	                break;
	        }
	        break;
	        
	    // Si es 0-10V
	    case 11:
	    	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	        	case 1:
	        	case 2:
	        	case 3:
		            document.getElementById('UM_unit').innerHTML="mg/m3";
					document.getElementById('UN_unit').innerHTML="mg/m3";
	                break;
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="V";
					document.getElementById('UN_unit').innerHTML="V";
	                break;
	        }
	        break;
	        
	    // si es contador de pulsos
		case 6:
	    	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	        	// Pluviómetro
	            case 1:
		            document.getElementById('UM_unit').innerHTML="mm";
					document.getElementById('UN_unit').innerHTML="mm";
	                break;
	
	            // Anemómetro Davis
	            case 2:
		            document.getElementById('UM_unit').innerHTML="km/h";
					document.getElementById('UN_unit').innerHTML="km/h";
	                break;
	                
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	        }
	        break;
	
	    // si es salida digital
	    case 4:
	    	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	        }
	        break;
	
		// Si es rotación de motor
		case 13:
			switch (document.getElementById(m_TSE).selectedIndex)
	        {
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="rpm";
					document.getElementById('UN_unit').innerHTML="rpm";
	                break;
	        }
			break;
			
	    // Si es sensirion
	    case 5:	    
	        switch (document.getElementById(m_PSE).selectedIndex)
	        {
	            // SENSIRION SHT1X (Humedad)
	            case 1:
	            case 3:
	            case 5:
	            	document.getElementById('UM_unit').innerHTML="%";
					document.getElementById('UN_unit').innerHTML="%";
	                break;
	
	            // SENSIRION SHT1X (Temperatura)
	            case 0:
	            case 4:
	            case 6:
	            	document.getElementById('UM_unit').innerHTML="ºC";
					document.getElementById('UN_unit').innerHTML="ºC";
	                break;
	            // Generico
	            default:
	            	document.getElementById('UM_unit').innerHTML="";
					document.getElementById('UN_unit').innerHTML="";
	                break;
	        }
	        break;
	
	     // Humedad Digital
        case 7:
            document.getElementById('UM_unit').innerHTML="%";
			document.getElementById('UN_unit').innerHTML="%";
            break;

        // Conductividad Digital / Presión Atmosf
        case 8:
        	switch (document.getElementById(m_TSE).selectedIndex)
	        {
	        	case 2:
        			document.getElementById('UM_unit').innerHTML="kPa";
					document.getElementById('UN_unit').innerHTML="kPa";
				break;
				
	        	default:
        			document.getElementById('UM_unit').innerHTML="dS/m";
					document.getElementById('UN_unit').innerHTML="dS/m";
				break;
			}
            break;

        // Temperatura Digital
        case 9:
        	document.getElementById('UM_unit').innerHTML="ºC";
			document.getElementById('UN_unit').innerHTML="ºC";
            break;
            
         // AMR
        case 14:
	    	document.getElementById('UM_unit').innerHTML="";
			document.getElementById('UN_unit').innerHTML="";
	        break;
            
	    // en caso de no ser ninguno conocido
	    default:
	    	document.getElementById('UM_unit').innerHTML="";
			document.getElementById('UN_unit').innerHTML="";
	        break;
    }   
	//AMB 26/10/2012 Mostramos máximo, mínimo y unidad
	if(((document.getElementById(m_ISE).selectedIndex == 3) && (document.getElementById(m_TSE).selectedIndex == 0)) ||
		((document.getElementById(m_ISE).selectedIndex == 0) && (document.getElementById(m_TSE).selectedIndex == 0)) || 
	   	((document.getElementById(m_ISE).selectedIndex == 11) && (document.getElementById(m_TSE).selectedIndex == 0)) || 
	   	((document.getElementById(m_ISE).selectedIndex == 12) && (document.getElementById(m_TSE).selectedIndex == 0)))
	{
		$('#MAX').attr("class", 'mostrado');
		$('#MIN').attr("class", 'mostrado');
		$('#UND').attr("class", 'mostrado');
		$('#texto_max').attr("class", 'texto_parametros mostrado');
		$('#texto_min').attr("class", 'texto_parametros mostrado');
		$('#texto_und').attr("class", 'texto_parametros mostrado');

		document.getElementById('MAX').disabled=false;
		document.getElementById('MIN').disabled=false;
		document.getElementById('UND').disabled=false;
		document.getElementById('texto_max').disabled=false;
		document.getElementById('texto_min').disabled=false;
		document.getElementById('texto_und').disabled=false;
					
		if(document.getElementById('UND').selectedIndex > -1)
		{			
			document.getElementById('UM_unit').innerHTML=document.getElementById('UND').options[document.getElementById('UND').selectedIndex].text;
			document.getElementById('UN_unit').innerHTML=document.getElementById('UND').options[document.getElementById('UND').selectedIndex].text;
		}
	}
	else
	{
		$('#MAX').attr("class", 'escondido');
		$('#MIN').attr("class", 'escondido');
		$('#UND').attr("class", 'escondido');
		$('#texto_max').attr("class", 'texto_parametros escondido');
		$('#texto_min').attr("class", 'texto_parametros escondido');
		$('#texto_und').attr("class", 'texto_parametros escondido');
		
		document.getElementById('MAX').disabled=true;
		document.getElementById('MIN').disabled=true;
		document.getElementById('UND').disabled=true;
		document.getElementById('texto_max').disabled=true;
		document.getElementById('texto_min').disabled=true;
		document.getElementById('texto_und').disabled=true;
	}
	
	if((document.getElementById(m_ISE).selectedIndex == 0) && (document.getElementById(m_TSE).selectedIndex == 0))
	{
		$('#texto_max').text(iObtener_Cadena_AJAX('event_pendiente'));
		$('#texto_min').text(iObtener_Cadena_AJAX('event_offset'));
	}
	else
	{
		$('#texto_max').text(iObtener_Cadena_AJAX('event_maximo'));
		$('#texto_min').text(iObtener_Cadena_AJAX('event_minimo'));
	}
}

function OnChangeInterfaz(m_ISE,m_PSE,m_TSE)
{
	Actualizar_Lista_Puertos(m_ISE,m_PSE);
	Actualizar_Lista_Sensores(m_ISE,m_TSE);
	vActualizar_Unidades(m_ISE, m_PSE,m_TSE);
	vOnChangeSensorType(m_ISE,m_PSE,m_TSE);
}

function sPreparar_Tipo_Sensor(m_ISE, m_PSE, m_TSE)
{
    var sResultado = '';
    switch (document.getElementById(m_ISE).selectedIndex)
    {
        // si es analogica
        case 0:
            sResultado += "1";
            break;

        // si es digital
        case 1:
            sResultado += "2";
            break;

        // si es Watermark
        case 2:
            sResultado += "3";
            break;

        // si es 4-20
        case 3:
            sResultado += "4";
            break;

        // si es salida digital
        case 4:
            sResultado += "5";
            break;

        // si es sensirion
        case 5:
            sResultado += "6";
            break;

        // si es contador pulsos
        case 6:
            sResultado += "7";
            break;
            
         // si es Humedad Digital
        case 7:
            sResultado += "8";
            break;
            
         // si Conductividad Digital / Presión Atm.
        case 8:
            sResultado += "9";
            break;
            
         // si es Temperatura Digital
        case 9:
            sResultado += "A";
            break;

        // si es veleta davis
        case 10:
            sResultado += "B";
            break;

        // si es 0..10V
        case 11:
            sResultado += "C";
            break;

        // si es 4-20 promediado
        case 12:
            sResultado += "D";
            break;

        // si es rotación de motor
        case 13:
            sResultado += "E";
            break;
            
         // si es AMR
        case 14:
            sResultado += "F";
            break;

        // en caso de no ser ninguno conocido
        default:
            sResultado += "1";
            break;
    }

	//GS3
	if(((document.getElementById(m_ISE).selectedIndex == 7)
			&& ((document.getElementById(m_TSE).selectedIndex == 4) || (document.getElementById(m_TSE).selectedIndex == 5)))
		 || ((document.getElementById(m_ISE).selectedIndex == 8) && (document.getElementById(m_TSE).selectedIndex == 1)) 
		 || ((document.getElementById(m_ISE).selectedIndex == 9) && (document.getElementById(m_TSE).selectedIndex == 1)))
	{
		switch (document.getElementById(m_PSE).selectedIndex)
	    {
	        case 1:
	            sResultado += "6";
	            break;
	
	        case 2:
	            sResultado += "7";
	            break;
	
	        case 3:
	            sResultado += "8";
	            break;
	            
	        default:
	        case 0:
	            sResultado += "5";
	            break;
	    }
	}
	// VP3
	else if(((document.getElementById(m_ISE).selectedIndex == 7) && (document.getElementById(m_TSE).selectedIndex == 6))
		 || ((document.getElementById(m_ISE).selectedIndex == 8) && (document.getElementById(m_TSE).selectedIndex == 2)) 
		 || ((document.getElementById(m_ISE).selectedIndex == 9) && (document.getElementById(m_TSE).selectedIndex == 2)))
	{
		switch (document.getElementById(m_PSE).selectedIndex)
	    {
	        case 1:
	            sResultado += "A";
	            break;
	
	        case 2:
	            sResultado += "B";
	            break;
	
	        case 3:
	            sResultado += "C";
	            break;
	            
	        default:
	        case 0:
	            sResultado += "9";
	            break;
	    }
	}
	else
	{
		switch (document.getElementById(m_PSE).selectedIndex)
	    {
	        case 0:
	            sResultado += "1";
	            break;
	
	        case 1:
	            sResultado += "2";
	            break;
	
	        case 2:
	            sResultado += "3";
	            break;
	
	        case 3:
	            sResultado += "4";
	            break;
	
	        case 4:
	            sResultado += "5";
	            break;
	
	        case 5:
	            sResultado += "6";
	            break;
	
	        case 6:
	            sResultado += "7";
	            break;
	
	        case 7:
	            sResultado += "8";
	            break;
	
	        case 8:
	            sResultado += "9";
	            break;
	
	        case 9:
	            sResultado += "A";
	            break;
	
	        case 11:
	            sResultado += "B";
	            break;
	
	        case 12:
	            sResultado += "C";
	            break;
	
	        case 13:
	            sResultado += "D";
	            break;
	
	        case 14:
	            sResultado += "E";
	            break;
	
	        case 15:
	            sResultado += "F";
	            break;
	
	        default:
	            sResultado += "1";
	            break;
	    }
	}

	switch (document.getElementById(m_TSE).selectedIndex)
    {
        case 1:
            sResultado += "1";
            break;

        case 2:
            sResultado += "2";
            break;

        case 3:
            sResultado += "3";
            break;

        case 4:
            sResultado += "4";
            break;

        case 5:
            sResultado += "5";
            break;

        case 6:
            sResultado += "6";
            break;

        case 7:
            sResultado += "7";
            break;

        case 8:
            sResultado += "8";
            break;

        case 9:
            sResultado += "9";
            break;
            
        case 10:
            sResultado += "A";
            break;
            
        case 11:
            sResultado += "B";
            break;
            
        case 12:
            sResultado += "C";
            break;
            
        case 13:
            sResultado += "D";
            break;
            
        case 14:
            sResultado += "E";
            break;
            
        case 15:
            sResultado += "F";
            break;
            
        case 0:
        default:
            sResultado += "0";
            break;
    }
    return sResultado;
}

function vRellenar_Combos_Tipo_Sensor(sCadenaTipo, m_ISE, m_PSE, m_TSE)
{
    if (sCadenaTipo.length == 3)
    {
        switch (sCadenaTipo.charAt(0))
        {
            // si es analogica
            case '1':
                document.getElementById(m_ISE).selectedIndex = 0;
                break;

            // si es digital
            case '2':
                document.getElementById(m_ISE).selectedIndex = 1;
                break;

            // si es Watermark
            case '3':
                document.getElementById(m_ISE).selectedIndex = 2;
                break;

            // si es 4-20
            case '4':
                document.getElementById(m_ISE).selectedIndex = 3;
                break;

            // si es salida digital
            case '5':
                document.getElementById(m_ISE).selectedIndex = 4;
                break;

            // si es sensirion
            case '6':
                document.getElementById(m_ISE).selectedIndex = 5;
                break;

            // si es contador pulsos
            case '7':
                document.getElementById(m_ISE).selectedIndex = 6;
                break;
                
             // si es 5TE Humedad
            case '8':
            	document.getElementById(m_ISE).selectedIndex = 7;
                break;
                
             // si 5TE Cond
            case '9':
            	document.getElementById(m_ISE).selectedIndex = 8;
                break;
                
             // si es 5TE Temp
            case 'A':
            case 'a':
            	document.getElementById(m_ISE).selectedIndex = 9;
                break;

            // si es veleta davis
            case 'B':
            case 'b':
                document.getElementById(m_ISE).selectedIndex = 10;
                break;

            // si 0..10V
            case 'C':
            case 'c':
                document.getElementById(m_ISE).selectedIndex = 11;
                break;

            // si es 4-0 promedio
            case 'D':
            case 'd':
                document.getElementById(m_ISE).selectedIndex = 12;
                break;

            // si es rotación de motor
            case 'E':
            case 'e':
                document.getElementById(m_ISE).selectedIndex = 13;
                break;
                
             // si es AMR
            case 'F':
            case 'f':
                document.getElementById(m_ISE).selectedIndex = 14;
                break;

            // en caso de no ser ninguno conocido
            default:
                document.getElementById(m_ISE).selectedIndex = 0;
                break;
        }

        Actualizar_Lista_Puertos(m_ISE,m_PSE);
    	Actualizar_Lista_Sensores(m_ISE,m_TSE);

        // Comprobamos si hay algun error de tipo de sensor
        if ((sCadenaTipo.charAt(0) == '1')
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
            alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_type4").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == 'B') || (sCadenaTipo.charAt(0) == 'b'))
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
            alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_vel_davis").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if ((sCadenaTipo.charAt(0) == '2')
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_type5").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == '8') || (sCadenaTipo.charAt(0) == '9') || (sCadenaTipo.charAt(0) == 'A') || (sCadenaTipo.charAt(0) == 'a'))
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
            alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" 5TE");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if ((sCadenaTipo.charAt(0) == '3')
                && (sCadenaTipo.charAt(1) != '1')
                && (sCadenaTipo.charAt(1) != '2')
                && (sCadenaTipo.charAt(1) != '3')
                && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" WATERMARK");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == '4') || (sCadenaTipo.charAt(0) == 'D') || (sCadenaTipo.charAt(0) == 'd'))
            && (sCadenaTipo.charAt(1) != '1') && (sCadenaTipo.charAt(1) != '2') && (sCadenaTipo.charAt(1) != '3')  && (sCadenaTipo.charAt(1) != '4') && (sCadenaTipo.charAt(1) != 'x') && (sCadenaTipo.charAt(1) != 'X'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" 4-20mA");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == 'C') || (sCadenaTipo.charAt(0) == 'c'))
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" 0..10V");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if ((sCadenaTipo.charAt(0) == '5')
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_type12").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == '6'))
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4')
            && (sCadenaTipo.charAt(1) != '5')
            && (sCadenaTipo.charAt(1) != '6'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" SENSIRION");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == 'E') || (sCadenaTipo.charAt(0) == 'e'))
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_type19").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if ((sCadenaTipo.charAt(0) == '7')
            && (sCadenaTipo.charAt(1) != '1')
            && (sCadenaTipo.charAt(1) != '2')
            && (sCadenaTipo.charAt(1) != '3')
            && (sCadenaTipo.charAt(1) != '4'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" "+iObtener_Cadena_AJAX("sensor_type9").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
        }
        else if (((sCadenaTipo.charAt(0) == 'F') || (sCadenaTipo.charAt(0) == 'f'))
                && (sCadenaTipo.charAt(1) != '1')
                && (sCadenaTipo.charAt(1) != '2')
                && (sCadenaTipo.charAt(1) != '3')
                && (sCadenaTipo.charAt(1) != '4'))
            {
            	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo1")+" AMR");
                document.getElementById(m_TSE).selectedIndex = 0;
                sCadenaTipo = sCadenaTipo.substr(0, 1) + "1" + sCadenaTipo.substr(2);
            }
        else
        {
            switch (sCadenaTipo.charAt(1))
            {
                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                case '6':
                case '7':
                case '8':
                case '9':
                    iIndicePuerto = sCadenaTipo.substr(1, 1) - 1;
                    break;

                case 'A':
                case 'a':
                    iIndicePuerto = 9;
                    break;

                case 'B':
                case 'b':
                    iIndicePuerto = 10;
                    break;

                case 'C':
                case 'c':
                    iIndicePuerto = 11;
                    break;

                case 'D':
                case 'd':
                    iIndicePuerto = 12;
                    break;

                case 'E':
                case 'e':
                    iIndicePuerto = 13;
                    break;

                case 'F':
                case 'f':
                    iIndicePuerto = 14;
                    break;

                case 'X':
                case 'x':
                default:
                    iIndicePuerto = 0;
                    break;
            }
            document.getElementById(m_PSE).selectedIndex = iIndicePuerto;
        }        
        // Comprobamos si hay algun error de tipo de sensor
        if ((sCadenaTipo.charAt(0) == '1')
            && (sCadenaTipo.charAt(2) != '0')
            && (sCadenaTipo.charAt(2) != '1')
            && (sCadenaTipo.charAt(2) != '2')
            && (sCadenaTipo.charAt(2) != '3')
            && (sCadenaTipo.charAt(2) != '4')
            && (sCadenaTipo.charAt(2) != '5')
            && (sCadenaTipo.charAt(2) != '6')
            && (sCadenaTipo.charAt(2) != '7')
            && (sCadenaTipo.charAt(2) != '8')
            && (sCadenaTipo.charAt(2) != '9')
            && (sCadenaTipo.charAt(2) != 'A')
            && (sCadenaTipo.charAt(2) != 'B')
            && (sCadenaTipo.charAt(2) != 'C'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_type4").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == 'B') || (sCadenaTipo.charAt(0) == 'b'))
            && (sCadenaTipo.charAt(2) != '0'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_vel_davis").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '8')
	        && (sCadenaTipo.charAt(2) != '0')
	        && (sCadenaTipo.charAt(2) != '1')
	        && (sCadenaTipo.charAt(2) != '2')
	        && (sCadenaTipo.charAt(2) != '3')
	        && (sCadenaTipo.charAt(2) != '4')
	        && (sCadenaTipo.charAt(2) != '5')
	        && (sCadenaTipo.charAt(2) != '6'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_hum_digital"));
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '9')
	        && (sCadenaTipo.charAt(2) != '0')
	        && (sCadenaTipo.charAt(2) != '1')
	        && (sCadenaTipo.charAt(2) != '2'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_cond_digital"));
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == 'A') || (sCadenaTipo.charAt(0) == 'a'))
	        && (sCadenaTipo.charAt(2) != '0')
	        && (sCadenaTipo.charAt(2) != '1')
	        && (sCadenaTipo.charAt(2) != '2'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_temp_digital"));
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '2')
            && (sCadenaTipo.charAt(2) != '0')
            && (sCadenaTipo.charAt(2) != '1')
            && (sCadenaTipo.charAt(2) != '2')
            && (sCadenaTipo.charAt(2) != '3')
            && (sCadenaTipo.charAt(2) != '4')
            && (sCadenaTipo.charAt(2) != '5')
            && (sCadenaTipo.charAt(2) != '6')
            && (sCadenaTipo.charAt(2) != '7')
            && (sCadenaTipo.charAt(2) != '8'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_type5").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '3')
                && (sCadenaTipo.charAt(2) != '0')
                && (sCadenaTipo.charAt(2) != '1'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" WATERMARK", "ERROR");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == '4') || (sCadenaTipo.charAt(0) == 'D') || (sCadenaTipo.charAt(0) == 'd'))
            && (sCadenaTipo.charAt(2) != '0') && (sCadenaTipo.charAt(2) != '1') && (sCadenaTipo.charAt(2) != '2') && (sCadenaTipo.charAt(2) != '3') 
            && (sCadenaTipo.charAt(2) != '4') && (sCadenaTipo.charAt(2) != '5') && (sCadenaTipo.charAt(2) != '6') && (sCadenaTipo.charAt(2) != '7') && (sCadenaTipo.charAt(2) != '8'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" 4-20mA", "ERROR");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == 'C') || (sCadenaTipo.charAt(0) == 'c'))
            && (sCadenaTipo.charAt(2) != '0') && (sCadenaTipo.charAt(2) != '1') && (sCadenaTipo.charAt(2) != '2') && (sCadenaTipo.charAt(2) != '3'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" 0-10V", "ERROR");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '5')
            && (sCadenaTipo.charAt(2) != '0'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_type12").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '6')
            && (sCadenaTipo.charAt(2) != '0'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" SENSIRION");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == 'E') || (sCadenaTipo.charAt(0) == 'e'))
            && (sCadenaTipo.charAt(2) != '0'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_type19").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if ((sCadenaTipo.charAt(0) == '7')
            && (sCadenaTipo.charAt(2) != '0')
            && (sCadenaTipo.charAt(2) != '1')
            && (sCadenaTipo.charAt(2) != '2'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" "+iObtener_Cadena_AJAX("sensor_type9").toUpperCase());
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else if (((sCadenaTipo.charAt(0) == 'F') || (sCadenaTipo.charAt(0) == 'f'))
            && (sCadenaTipo.charAt(2) != '0'))
        {
        	alert("ERROR " + sCadenaTipo + ": "+iObtener_Cadena_AJAX("error_nodo2")+" AMR");
            document.getElementById(m_TSE).selectedIndex = 0;
            sCadenaTipo = sCadenaTipo.substr(0, 1) + sCadenaTipo.substr(2) + "0";
        }
        else
        {
            switch (sCadenaTipo.charAt(2))
            {
                case '0':
                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                case '6':
                case '7':
                case '8':
                case '9':
                    iIndicePuerto = sCadenaTipo.substr(2, 1);
                    break;

                case 'A':
                case 'a':
                    iIndicePuerto = 10;
                    break;

                case 'B':
                case 'b':
                    iIndicePuerto = 11;
                    break;

                case 'C':
                case 'c':
                    iIndicePuerto = 12;
                    break;

                case 'D':
                case 'd':
                    iIndicePuerto = 13;
                    break;

                case 'E':
                case 'e':
                    iIndicePuerto = 14;
                    break;

                case 'F':
                case 'f':
                    iIndicePuerto = 15;
                    break;

                default:
                    iIndicePuerto = 0;
                    break;
            }
            document.getElementById(m_TSE).selectedIndex = iIndicePuerto;
        }                
    }
    else
    {
    	document.getElementById(m_ISE).selectedIndex=-1;
    	document.getElementById(m_PSE).selectedIndex=-1;
    	document.getElementById(m_TSE).selectedIndex=-1;
    }
}

function iComprobar_Todos_Valores_Nodo()
{
	var iCN;
	var iCNAux;
	
	if (caNNO.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_nodo3"));
		return -1;
	}
	else if (iComprobar_Nombre(caNNO) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_nodo4"));
		return -1;
	}
	if ((iTNO == -1) || (iTNO > 2))
	{
		alert(iObtener_Cadena_AJAX("error_nodo5"));
		return -1;
	}
	for (iCN=0; iCN < 6; iCN++)
	{
		iCNAux=iCN+1;
		if ((iaSEN[iCN] == -1) || (iaSEN[iCN] > 1)) 
		{
			alert(iObtener_Cadena_AJAX("error_nodo6")+' '+ iCNAux);
			return -1;
		}
		if (iaSEN[iCN] == '1')
		{
			if (caaTSN[iCN].length != 3)
			{
				alert(iObtener_Cadena_AJAX("error_nodo13")+' '+ iCNAux );
				return -1;
			}
			if (((iaOPERACION[iCN] == -1) || (iaOPERACION[iCN] > 2)) && (caaTSN[iCN].substr(0,1)=='C'))
			{
				alert(iObtener_Cadena_AJAX("error_nodo25")+' '+iCNAux);
				return -1;
			}
			if (((caaVALOR[iCN].length == 0) || iComprobar_Decimal(caaVALOR[iCN],3)==-1) && (caaTSN[iCN].substr(0,1)=='C'))
			{
				alert(iObtener_Cadena_AJAX("error_nodo26")+' '+iCNAux);
				return -1;
			}
			if ((iaTMN[iCN] == -1) || (iaTMN[iCN].length == 0)) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo7")+' '+ iCNAux);
				return -1;
			}
			if ((iaTEN[iCN] == -1) || (iaTEN[iCN].length == 0)) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo8")+' '+ iCNAux);
				return -1;
			}
			if ((iaUMN[iCN] == -1) || (iaUMN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaUMN[iCN], caaTSN[iCN],'D',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) > 65535),0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo9")+' '+ iCNAux);
				return -1;
			}
			if ((iaUNN[iCN] == -1) || (iaUNN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaUNN[iCN], caaTSN[iCN],'D',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) > 65535),0)) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo10")+' '+ iCNAux);
				return -1;
			}
			if ((iaTGN[iCN] == -1) || (iaTGN[iCN].length == 0)) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo11")+' '+ iCNAux);
				return -1;
			}
			if ((iaGMN[iCN] == -1) || (iaGMN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaGMN[iCN], caaTSN[iCN],'G',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) > 65535),0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo12")+' '+ iCNAux);
				return -1;
			}
			if (caaSNN[iCN].length > 20)
			{
				alert(iObtener_Cadena_AJAX("error_nodo14")+' '+ iCNAux);
				return -1;
			}
			else if (iComprobar_Nombre(caaSNN[iCN]) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_nodo15")+' '+ iCNAux);
				return -1;
			}
			
			if ((iaNOTIFICA_EMAIL[iCN] == -1) || (iaNOTIFICA_EMAIL[iCN] > 2))
			{
				alert(iObtener_Cadena_AJAX("error_nodo16")+' '+iCNAux);
				return -1;
			}
			
			if ((iaNOTIFICA_SMS[iCN] == -1) || (iaNOTIFICA_SMS[iCN] > 2))
			{
				alert(iObtener_Cadena_AJAX("error_nodo17")+' '+iCNAux);
				return -1;
			}
			if (((((iaUMN[iCN] != -1) && (iaUMN[iCN].length != 0)) || ((iaUNN[iCN] != -1) && (iaUNN[iCN].length != 0)) || ((iaGMN[iCN] != -1) && (iaGMN[iCN].length != 0))) && (caaTSN[iCN].substr(0,1)=='C')) && ((((iaOPERACION[iCN] == -1) || (iaOPERACION[iCN] > 2))) || ((caaVALOR[iCN].length == 0) || iComprobar_Decimal(caaVALOR[iCN],3)==-1))) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo27")+' '+ iCNAux);
				return -1;
			}
		}
	}
	return 0;
}


function iComprobar_Valores_Nodo()
{
	var iCN;
	var iCNAux;
	
	if (caNNO.length > 0)
	{
		if (caNNO.length > 20)
		{
			alert(iObtener_Cadena_AJAX("error_nodo3"));
			return -1;
		}
		else if (iComprobar_Nombre(caNNO) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_nodo4"));
			return -1;
		}
	}
	if ((iTNO != -1) && (iTNO > 2))
	{
		alert(iObtener_Cadena_AJAX("error_nodo5"));
		return -1;
	}
	for (iCN=0; iCN < 6; iCN++)
	{
		iCNAux=iCN+1;
		if ((iaSEN[iCN] != -1) && (iaSEN[iCN] > 1))
		{
			alert(iObtener_Cadena_AJAX("error_nodo6")+' '+ iCNAux);
			return -1;
		}
		if (iaSEN[iCN] == '1')
		{
			if ((caaTSN[iCN].length > 0) && (caaTSN[iCN].length != 3))
			{
				alert(iObtener_Cadena_AJAX("error_nodo13")+' '+ iCNAux);
				return -1;
			}
			if (((iaOPERACION[iCN] == -1) || (iaOPERACION[iCN] > 2)) && (caaTSN[iCN].substr(0,1)=='C'))
			{
				alert(iObtener_Cadena_AJAX("error_nodo25")+' '+iCNAux);
				return -1;
			}
			if (((caaVALOR[iCN].length == 0) || iComprobar_Decimal(caaVALOR[iCN],3)==-1) && (caaTSN[iCN].substr(0,1)=='C'))
			{
				alert(iObtener_Cadena_AJAX("error_nodo26")+' '+iCNAux);
				return -1;
			}
			if ((iaTMN[iCN] != -1) && (iaTMN[iCN].length == 0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo7")+' '+ iCNAux);
				return -1;
			}
			if ((iaTEN[iCN] != -1) && (iaTEN[iCN].length == 0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo8")+' '+ iCNAux);
				return -1;
			}
			if ((iaUMN[iCN] != -1) && (iaUMN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaUMN[iCN], caaTSN[iCN],'D',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) < 65535),0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo9")+' '+ iCNAux);
				return -1;
			}
			if ((iaUNN[iCN] != -1) && (iaUNN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaUNN[iCN], caaTSN[iCN],'D',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) < 65535),0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo10")+' '+ iCNAux);
				return -1;
			}
			if ((iaTGN[iCN] != -1) && (iaTGN[iCN].length == 0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo11")+' '+ iCNAux);
				return -1;
			}
			if ((iaGMN[iCN] != -1) && (iaGMN[iCN].length == 0) || (parseInt(sConvertir_Inversa_Datos_Nodo(iaGMN[iCN], caaTSN[iCN],'G',iaOPERACION[iCN],caaVALOR[iCN],iaMAXIMO[iCN],iaMINIMO[iCN]) < 65535),0))
			{
				alert(iObtener_Cadena_AJAX("error_nodo12")+' '+ iCNAux);
				return -1;
			}
			if ((caaSNN[iCN].length > 0) && (caaSNN[iCN].length > 20))
			{
				alert(iObtener_Cadena_AJAX("error_nodo14")+' '+ iCNAux);
				return -1;
			}
			else if (iComprobar_Nombre(caaSNN[iCN]) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_nodo15")+' '+ iCNAux);
				return -1;
			}
			
			if ((iaNOTIFICA_EMAIL[iCN] != -1) && (iaNOTIFICA_EMAIL[iCN] > 2))
			{
				alert(iObtener_Cadena_AJAX("error_nodo16")+' '+ iCNAux);
				return -1;
			}
			
			if ((iaNOTIFICA_SMS[iCN] != -1) && (iaNOTIFICA_SMS[iCN] > 2))
			{
				alert(iObtener_Cadena_AJAX("error_nodo17")+' '+ iCNAux);
				return -1;
			}
			if (((((iaUMN[iCN] != -1) && (iaUMN[iCN].length != 0)) || ((iaUNN[iCN] != -1) && (iaUNN[iCN].length != 0)) || ((iaGMN[iCN] != -1) && (iaGMN[iCN].length != 0))) && (caaTSN[iCN].substr(0,1)=='C')) && ((((iaOPERACION[iCN] == -1) || (iaOPERACION[iCN] > 2))) || ((caaVALOR[iCN].length == 0) || iComprobar_Decimal(caaVALOR[iCN],3)==-1))) 
			{
				alert(iObtener_Cadena_AJAX("error_nodo27")+' '+ iCNAux);
				return -1;
			}
		}
	}
	return 0;
}

function sPrepararCadenaNodo()
{
	var iContador;
	var iNumero;
	var sTipoSensAux;
	var sCadenaParams;
	
	sCadenaParams = "MAC"+document.getElementById('object_id').value+";";
	sCadenaParams += "NNO"+caNNO+";";
	sCadenaParams += "TNO"+iTNO+";";
	sCadenaParams += "HMR"+iHMR+";";
	iNumero=0;
	for(iContador=0;iContador<6;iContador++)
	{
		if (iaSEN[iContador] == '1')
		{
			iNumero+=Math.pow(2,iContador);									
		}
	}
	sCadenaParams += "SEN"+pad_izquierda(iNumero.toString(),3,'0')+";";

	for (iContador = 1; iContador < 7; iContador++)
	{
		if (iaSEN[iContador-1] == '1')
		{
			sCadenaParams += "TM"+iContador  + iaTMN[iContador-1] + ";";
			sCadenaParams += "TE"+iContador + iaTEN[iContador-1]+";";
			sCadenaParams += "UM"+iContador + sConvertir_Inversa_Datos_Nodo(iaUMN[iContador-1], caaTSN[iContador-1],'D',iaOPERACION[iContador-1],caaVALOR[iContador-1],iaMAXIMO[iContador-1],iaMINIMO[iContador-1])+";";
			sCadenaParams += "UN"+iContador + sConvertir_Inversa_Datos_Nodo(iaUNN[iContador-1], caaTSN[iContador-1],'D',iaOPERACION[iContador-1],caaVALOR[iContador-1],iaMAXIMO[iContador-1],iaMINIMO[iContador-1])+";";
			sCadenaParams += "GM"+iContador + sConvertir_Inversa_Datos_Nodo(iaGMN[iContador-1], caaTSN[iContador-1],'G',iaOPERACION[iContador-1],caaVALOR[iContador-1],iaMAXIMO[iContador-1],iaMINIMO[iContador-1])+";";
			sCadenaParams += "TG"+iContador + iaTGN[iContador-1]+";";
			sCadenaParams += "TS"+iContador + caaTSN[iContador-1]+";";
			sCadenaParams += "SN"+iContador + caaSNN[iContador-1]+";";
			sCadenaParams += "SH"+iContador + iaNOTIFICA_SMS[iContador-1]+";";
			sCadenaParams += "EH"+iContador + iaNOTIFICA_EMAIL[iContador-1]+";";
			sCadenaParams += "OP"+iContador + iaOPERACION[iContador-1]+";";
			sCadenaParams += "M" +iContador + "X" + iaMAXIMO[iContador-1]+";";
			sCadenaParams += "M" +iContador + "N" + iaMINIMO[iContador-1]+";";
			sCadenaParams += "U" +iContador + "D" + iaUNIDAD[iContador-1]+";";
			sCadenaParams += "CO"+iContador + caaVALOR[iContador-1]+";";
		}
	}
	return sCadenaParams;
}

function iComprobar_Davis(iObjetivo)
{
	var iResultadoDavis;
	var iCN;
	var iCNAux;
	var iPuertoVeleta;
	var iPuertoAnem;
	
	iResultadoDavis = 0;
	iPuertoVeleta = -1;
	iPuertoAnem = -1;
	for (iCN=0; ((iCN < 6) && (iResultadoDavis==0)); iCN++)
	{
		// para DB o UTR
		if (iaSEN[iCN] == 1)
		{
			if ((caaTSN[iCN].substr(0, 1) == 'B') || (caaTSN[iCN].substr(0, 1) == 'b'))
			{
				if (iPuertoVeleta == -1)
				{
					iPuertoVeleta = parseInt(caaTSN[iCN].substr(1, 1));
				}
				else
				{
					iResultadoDavis = 1;
				}
			}
			else if ((caaTSN[iCN].substr(0, 1) == '7') && (caaTSN[iCN].substr(2, 1) == '2'))
			{
				if (iPuertoAnem == -1)
				{
					iPuertoAnem = parseInt(caaTSN[iCN].substr(1, 1));
				}
				else
				{
					iResultadoDavis = 2;
				}
			}
		}
		// para UTR
		else if ((iObjetivo == 0) && (iaSEN2[iCN] == 1))
		{
			if ((caaTSN2[iCN].substr(0, 1) == 'B') || (caaTSN2[iCN].substr(0, 1) == 'b'))
			{
				if (iPuertoVeleta == -1)
				{
					iPuertoVeleta = parseInt(caaTSN2[iCN].substr(1, 1));
				}
				else
				{
					iResultadoDavis = 1;
				}
			}
			else if ((caaTSN2[iCN].substr(0, 1) == '7') && (caaTSN2[iCN].substr(2, 1) == '2'))
			{
				if (iPuertoAnem == -1)
				{
					iPuertoAnem = parseInt(caaTSN2[iCN].substr(1, 1));
				}
				else
				{
					iResultadoDavis = 2;
				}
			}
		}
	}
	switch (iResultadoDavis)
	{
		case 1:
			alert("ERROR: "+iObtener_Cadena_AJAX("error_nodo20"));
			iResultadoDavis = 1;
			break;
		case 2:
			alert("ERROR: "+iObtener_Cadena_AJAX("error_nodo21"));
			iResultadoDavis = 1;
			break;
		case 0:
		default:
			if ((iPuertoAnem != -1) && (iPuertoVeleta == -1))
			{
				alert("ERROR: "+iObtener_Cadena_AJAX("error_nodo23"));
				iResultadoDavis = 1;
			}
			else if ((iPuertoAnem == -1) && (iPuertoVeleta != -1))
			{
				alert("ERROR: "+iObtener_Cadena_AJAX("error_nodo22"));
				iResultadoDavis = 1;
			}
			else if ((iPuertoAnem !=-1) && (iPuertoAnem !=-1))
			{
				if (iPuertoAnem == iPuertoVeleta)
				{
					iResultadoDavis = 0;
				}
				else
				{
					alert("ERROR: "+iObtener_Cadena_AJAX("error_nodo24"));
					iResultadoDavis = 1;	
				}
			}
			else
			{
				iResultadoDavis = 0;
			}
			break;
	}
	return iResultadoDavis;
}
