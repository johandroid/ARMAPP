<?php session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
	<script  src="codebase/dhtmlxcommon.js"></script>
	<script  src="codebase/dhtmlxtabbar.js"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_nodos.js?time=<?php echo(filemtime("js/funciones_nodos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>	
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		var iSensor;
		var caSensor;
		var caNNO;
		var iTNO;
		var iHMR;
		var iaSEN = new Array(6);
		var iaTMN = new Array(6);
		var iaTEN = new Array(6);
		var iaUMN = new Array(6);
		var iaUNN = new Array(6);
		var iaTGN = new Array(6);
		var iaGMN = new Array(6);
		var caaTSN = new Array(6);
		var caaSNN = new Array(6);
		var caNNO2;
		var iTNO2;
		var iaSEN2 = new Array(6);
		var iaTMN2 = new Array(6);
		var iaTEN2 = new Array(6);
		var iaUMN2 = new Array(6);
		var iaUNN2 = new Array(6);
		var iaTGN2 = new Array(6);
		var iaGMN2 = new Array(6);
		var caaTSN2 = new Array(6);
		var caaSNN2 = new Array(6);
		var iaNOTIFICA_EMAIL = new Array(6);
		var iaNOTIFICA_SMS = new Array(6);
		var caaVALOR = new Array(6);
		var iaOPERACION = new Array(6);
		var iaMAXIMO = new Array(6);
		var iaMINIMO = new Array(6);
		var iaUNIDAD = new Array(6);		
		var iaMAXIMO2 = new Array(6);
		var iaMINIMO2 = new Array(6);
		var iaUNIDAD2 = new Array(6);

		function OnLimpiarControlesNodo()
		{
			document.getElementById('xml_params').value='';
			caSensor = 'a1';
		    iSensor = iAsignar_Tab(caSensor);
			tabbar.setTabActive("a1");
			caNNO = '';
			iTNO = -1;
			iHMR = -1;
			caNNO2 = '';
			iTNO2 = -1;
			for (var iIndice = 0; iIndice < 6; iIndice++)
			{
				iaSEN[iIndice] = -1;
				iaTMN[iIndice] = -1;
				iaTEN[iIndice] = -1;
				iaUMN[iIndice] = -1;
				iaUNN[iIndice] = -1;
				iaTGN[iIndice] = -1;
				iaGMN[iIndice] = -1;
				caaTSN[iIndice] = '';
				caaSNN[iIndice] = '';			

				iaSEN2[iIndice] = -1;
				iaTMN2[iIndice] = -1;
				iaTEN2[iIndice] = -1;
				iaUMN2[iIndice] = -1;
				iaUNN2[iIndice] = -1;
				iaTGN2[iIndice] = -1;
				iaGMN2[iIndice] = -1;
				caaTSN2[iIndice] = '';
				caaSNN2[iIndice] = '';	

				iaNOTIFICA_EMAIL[iIndice] = -1;
				iaNOTIFICA_SMS[iIndice] = -1;		
				
				caaVALOR[iIndice] = '';
				iaOPERACION[iIndice] = -1;	
				iaMAXIMO[iIndice] = -1;
				iaMINIMO[iIndice] = -1;
				iaUNIDAD[iIndice] = -1;
				iaMAXIMO2[iIndice] = -1;
				iaMINIMO2[iIndice] = -1;
				iaUNIDAD2[iIndice] = -1;
			}
			vRellenar_Valores_Sensor();
			document.getElementById('NNO').value="";
			document.getElementById('TNO').selectedIndex=-1;
			document.getElementById('SEN').selectedIndex=-1;
			document.getElementById('SNO').value="";
			document.getElementById('UMS').value="";
			document.getElementById('UNS').value="";
			document.getElementById('GMS').value="";
			document.getElementById('TGS').value="";
			document.getElementById('TES').value="";
			document.getElementById('TMS').value="";
			document.getElementById('PSE').selectedIndex=-1;
			document.getElementById('TSE').selectedIndex=-1;
			document.getElementById('ISE').selectedIndex=-1;

			document.getElementById('email_on').selectedIndex = -1;
			document.getElementById('sms_on').selectedIndex = -1;
			document.getElementById('MAX').value="";
			document.getElementById('MIN').value="";
			document.getElementById('UND').selectedIndex=-1;
			document.getElementById('HMR').selectedIndex=-1;
			
			document.getElementById('OPE').selectedIndex=-1;
			document.getElementById('CON').value="";
		}
		
		function vParsear_Trama_Nodo(sParametrosNode,iOut)
		{
			var sPrincipalNode;
			var sListaValores;
			var sListaNombres;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var iSubContador;
			var sParcial;
			var sTotal;
			var sUMAux;
			var sUNAux;

			sPrincipalNode=parsear_xml(sParametrosNode);
			if (sPrincipalNode != null)
			{
				sListaNombres=sPrincipalNode.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipalNode.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					if (sListaValores[iContador].childNodes[0])
					{
						sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
					}
					else
					{
						sValorParam='';
					}
					if (sNombreParam.length==3)
					{
						if (sNombreParam=='GHW')
						{
							caVGWHW = sValorParam;
						}
						else if (sNombreParam=='GSW')
						{
							caVGWSW = sValorParam;
						}
						else if (sNombreParam=='GTI')
						{
							caGWTIPO = sValorParam;
						}
						else if (sNombreParam=='NNO')
						{
							if (iOut==0)
							{
								caNNO=sValorParam;
							}
							else
							{
								caNNO2=sValorParam;
							}
								
						}
						else if (sNombreParam=='TNO')
						{
							if (iOut==0)
							{
								iTNO=sValorParam;
							}
							else
							{
								iTNO2=sValorParam;
							}
						}
						else if (sNombreParam=='SEN')
						{
							sTotal = sValorParam;
							for(iSubContador=1;iSubContador<7;iSubContador++)
							{
								sParcial = sTotal%Math.pow(2,iSubContador);
								if (sParcial > 0)
								{
									if (iOut==0)
									{
										iaSEN[iSubContador-1] = '1';
									}
									else
									{
										iaSEN2[iSubContador-1] = '1';
									}
								}
								else
								{
									if (iOut==0)
									{
										iaSEN[iSubContador-1] = '0';
									}
									else
									{
										iaSEN2[iSubContador-1] = '0';
									}
								}
								sTotal -= sParcial;
							}
						}
						else if (sNombreParam=='HMR')
						{
							iHMR = sValorParam;
						}
						else if ((sNombreParam.charAt(2) < 7) && (sNombreParam.charAt(2) > 0))
						{
							if ((sNombreParam.charAt(0)=='T') && (sNombreParam.charAt(1)=='E'))
							{
								if (iOut==0)
								{
									iaTEN[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
								else
								{
									iaTEN2[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
							}
							else if ((sNombreParam.charAt(0)=='T') && (sNombreParam.charAt(1)=='M'))
							{
								if (iOut==0)
								{
									iaTMN[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
								else
								{
									iaTMN2[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
							}
							else if ((sNombreParam.charAt(0)=='U') && (sNombreParam.charAt(1)=='M'))
							{
								if (iOut==0)
								{
									iaUMN[sNombreParam.charAt(2)-1] = sValorParam;
								}
								else
								{
									iaUMN2[sNombreParam.charAt(2)-1] = sValorParam;
								}
							}
							else if ((sNombreParam.charAt(0)=='U') && (sNombreParam.charAt(1)=='N'))
							{
								if (iOut==0)
								{
									iaUNN[sNombreParam.charAt(2)-1] = sValorParam;
								}
								else
								{
									iaUNN2[sNombreParam.charAt(2)-1] = sValorParam;
								}
							}
							else if ((sNombreParam.charAt(0)=='T') && (sNombreParam.charAt(1)=='G'))
							{
								if (iOut==0)
								{
									iaTGN[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
								else
								{
									iaTGN2[sNombreParam.charAt(2)-1] = parseFloat(sValorParam);
								}
							}
							else if ((sNombreParam.charAt(0)=='G') && (sNombreParam.charAt(1)=='M'))
							{
								if (iOut==0)
								{
									iaGMN[sNombreParam.charAt(2)-1] = sValorParam;
								}
								else
								{
									iaGMN2[sNombreParam.charAt(2)-1] = sValorParam;
								}
							}
							else if ((sNombreParam.charAt(0)=='T') && (sNombreParam.charAt(1)=='S'))
							{	//AMB 07/11/12 Modificamos el valor del puerto según si es decagon o no. (Decagon = puerto - 4)										
								sValorParam = sActualizarValorParam(sValorParam);																						
										
								if (iOut==0)
								{
									caaTSN[sNombreParam.charAt(2)-1] = sValorParam.toUpperCase();
								}
								else
								{
									caaTSN2[sNombreParam.charAt(2)-1] = sValorParam.toUpperCase();
								}
							}
							else if ((sNombreParam.charAt(0)=='S') && (sNombreParam.charAt(1)=='N'))
							{
								if (iOut==0)
								{
									caaSNN[sNombreParam.charAt(2)-1] = sValorParam;
								}
								else
								{
									caaSNN2[sNombreParam.charAt(2)-1] = sValorParam;
								}
							}
							else if ((sNombreParam.charAt(0)=='S') && (sNombreParam.charAt(1)=='H'))
							{
								iaNOTIFICA_SMS[sNombreParam.charAt(2)-1] = sValorParam;
							}
							else if ((sNombreParam.charAt(0)=='E') && (sNombreParam.charAt(1)=='H'))
							{
								iaNOTIFICA_EMAIL[sNombreParam.charAt(2)-1] = sValorParam;
							}
							else if ((sNombreParam.charAt(0)=='C') && (sNombreParam.charAt(1)=='O'))
							{
								caaVALOR[sNombreParam.charAt(2)-1] = sValorParam;
							}
							else if ((sNombreParam.charAt(0)=='O') && (sNombreParam.charAt(1)=='P'))
							{
								iaOPERACION[sNombreParam.charAt(2)-1] = sValorParam;
							}
						}
						else if ((sNombreParam.charAt(0)=='M') && (sNombreParam.charAt(2)=='X'))
						{
							if (iOut==0)
							{
								iaMAXIMO[sNombreParam.charAt(1)-1] = sValorParam;
							}
							else
							{
								iaMAXIMO2[sNombreParam.charAt(1)-1] = sValorParam;
							}
						}
						else if ((sNombreParam.charAt(0)=='M') && (sNombreParam.charAt(2)=='N'))
						{
							if (iOut==0)
							{
								iaMINIMO[sNombreParam.charAt(1)-1] = sValorParam;
							}
							else
							{
								iaMINIMO2[sNombreParam.charAt(1)-1] = sValorParam;
							}
						}	
						else if ((sNombreParam.charAt(0)=='U') && (sNombreParam.charAt(2)=='D'))
						{
							if (iOut==0)
							{
								iaUNIDAD[sNombreParam.charAt(1)-1] = sValorParam;
							}
							else
							{
								iaUNIDAD2[sNombreParam.charAt(1)-1] = sValorParam;
							}
						}																			
					}
				}
			}
		}
		function sActualizarValorParam(sValorParam)
		{
			var sPuerto;
			if(((sValorParam.charAt(0) == '8') && ((sValorParam.charAt(2) == '4') || (sValorParam.charAt(2) == '5')))
				|| ((sValorParam.charAt(0) == '9') && (sValorParam.charAt(2) == '1')) 
				|| (((sValorParam.charAt(0) == 'A') || (sValorParam.charAt(0) == 'a')) && (sValorParam.charAt(2) == '1')))
			{
				sPuerto = sValorParam.charAt(1);
				
				switch(sPuerto)
				{
					case '5':
						sPuerto = '1';
						break;
					case '6':					
						sPuerto = '2';
						break;
					case '7':
						sPuerto = '3';
						break;
					case '8':
						sPuerto = '4';
						break;		
					default:
						sPuerto = sPuerto;
						break;					
				}
				sValorParam = sValorParam.charAt(0) + sPuerto +sValorParam.charAt(2);
			}
			else if(((sValorParam.charAt(0) == '8') && (sValorParam.charAt(2) == '6')) 
				|| ((sValorParam.charAt(0) == '9') && (sValorParam.charAt(2) == '2')) 
				|| (((sValorParam.charAt(0) == 'A') || (sValorParam.charAt(0) == 'a')) && (sValorParam.charAt(2) == '2')))
			{
				sPuerto = sValorParam.charAt(1);
				
				switch(sPuerto)
				{
					case '9':
						sPuerto = '1';
						break;
					case 'A':					
						sPuerto = '2';
						break;
					case 'B':
						sPuerto = '3';
						break;
					case 'C':
						sPuerto = '4';
						break;		
					default:
						sPuerto = sPuerto;
						break;					
				}
				sValorParam = sValorParam.charAt(0) + sPuerto +sValorParam.charAt(2);				
			}
			return sValorParam;
		}
		
		var xmlHttpgrReadNode;
		function OnLeerNodo()
		{
			var caComando;
			var url;
			$('#imagen_espera').attr("class", 'mostrado');
			caComando = "L"+document.getElementById('gw_id').value+"N"+document.getElementById('object_ip').value;			
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>))
			{
				OnLimpiarControlesNodo();				
				url = "nodo_lectura.php?comando="+caComando;				
				xmlHttpgrReadNode= GetXmlHttpObject();
				xmlHttpgrReadNode.open("GET",url,true);
				xmlHttpgrReadNode.onreadystatechange=function()
				{
					if (xmlHttpgrReadNode.readyState==4)
					{
						$('#imagen_espera').attr("class", 'escondido');
						document.getElementById('boton_leer').disabled="";
						document.getElementById('boton_enviar').disabled="";
						document.getElementById('boton_limpiar').disabled="";
						document.getElementById('boton_av').disabled="";
			
						if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
						{
							alert(xmlHttpgrReadNode.responseText);
						}
						else
						{
							//alert(xmlHttpgrReadNode.responseText);
							document.getElementById('xml_params').value=xmlHttpgrReadNode.responseText;
							vParsear_Trama_Nodo(xmlHttpgrReadNode.responseText,0);
							vRellenar_Valores_Sensor();
							Cargar_Params_Nodo_DB_notifica();
						}
					}
				}
				document.getElementById('boton_leer').disabled="true";
				document.getElementById('boton_enviar').disabled="true";
				document.getElementById('boton_limpiar').disabled="true";
				document.getElementById('boton_av').disabled="false";				
				xmlHttpgrReadNode.send(null);
			}
			else
			{
				url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip="+document.getElementById('object_ip').value+"&comando="+caComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
				xmlHttpgrReadNode= GetXmlHttpObject();
				xmlHttpgrReadNode.open("GET",url,false);
				xmlHttpgrReadNode.send(null);
				caComando = "P"+document.getElementById('gw_id').value+"N"+document.getElementById('object_ip').value;
				url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip="+document.getElementById('object_ip').value+"&comando="+caComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
				xmlHttpgrReadNode= GetXmlHttpObject();
				xmlHttpgrReadNode.open("GET",url,false);
				xmlHttpgrReadNode.send(null);
				$('#imagen_espera').attr("class", 'escondido');
				alert(iObtener_Cadena_AJAX('general361'));
			}
		}

		function Cargar_Params_Nodo_DB()
		{
			var url = "nodo_lecturaDB.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value+"&nodo_mac="+document.getElementById('object_id').value;
			OnLimpiarControlesNodo();
			xmlHttpgrReadNode= GetXmlHttpObject();
			xmlHttpgrReadNode.open("GET",url,true);
			xmlHttpgrReadNode.onreadystatechange=function()
			{
				if (xmlHttpgrReadNode.readyState==4)
				{
					if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
					{
						alert(xmlHttpgrReadNode.responseText);
					}
					else
					{
						document.getElementById('xml_params').value=xmlHttpgrReadNode.responseText;
						vParsear_Trama_Nodo(xmlHttpgrReadNode.responseText,0);
						vRellenar_Valores_Sensor();				
					}	
				}
			}
			xmlHttpgrReadNode.send(null);
		}

		function Cargar_Params_Nodo_DB_notifica()
		{
			var url = "nodo_lecturaDB_notifica.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value+"&nodo_mac="+document.getElementById('object_id').value;
			xmlHttpgrReadNode= GetXmlHttpObject();
			xmlHttpgrReadNode.open("GET",url,true);
			xmlHttpgrReadNode.onreadystatechange=function()
			{
				if (xmlHttpgrReadNode.readyState==4)
				{
					if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
					{
						alert(xmlHttpgrReadNode.responseText);
					}
					else
					{
						//document.getElementById('xml_params').value=xmlHttpgrReadNode.responseText;
						vParsear_Trama_Nodo(xmlHttpgrReadNode.responseText,0);
						vRellenar_Valores_Sensor();
					}	
				}
			}
			xmlHttpgrReadNode.send(null);
		}

		function vGuarda_Params_Notificacion_DB()
		{
			var iContador;
			var iNumero;
			var sTipoSensAux;
			var sCadenaParams;
			var iContador;
			sCadenaParams = "MAC"+document.getElementById('object_id').value+";";
			
			for (iContador = 0; iContador < 6; iContador++)
			{
				if ((iaNOTIFICA_EMAIL[iContador] != -1) && (iaNOTIFICA_EMAIL[iContador] < 2))
				{
					sCadenaParams += "EH"+(iContador+1) + iaNOTIFICA_EMAIL[iContador]+";";
				}
				
				if ((iaNOTIFICA_SMS[iContador] != -1) && (iaNOTIFICA_SMS[iContador] < 2))
				{
					sCadenaParams += "SH"+(iContador+1) + iaNOTIFICA_SMS[iContador]+";";
				}				
				if((caaTSN[iContador] != null) && (iaOPERACION[iContador] != null))
				{
					if (((iaOPERACION[iContador] != -1) && (iaOPERACION[iContador] < 2)) || ((caaTSN[iContador].length != 0) &&  (caaTSN[iContador].substr(0,1)!='C')))
					{
						sCadenaParams += "OP"+(iContador+1) + iaOPERACION[iContador]+";";
					}					
				}
				if ((iaMAXIMO[iContador] != -1) && (iaMAXIMO2[iContador]!=iaMAXIMO[iContador]) && (iComprobar_Decimal(iaMAXIMO[iContador],5)!=-1))
				{
					sCadenaParams += "M"+(iContador+1) + "X" + iaMAXIMO[iContador]+";";
				}
				if ((iaMINIMO[iContador] != -1) && (iaMINIMO2[iContador]!=iaMINIMO[iContador]) && (iComprobar_Decimal(iaMINIMO[iContador],5)!=-1))
				{
					sCadenaParams += "M"+(iContador+1) + "N" + iaMINIMO[iContador]+";";
				}
				if ((iaUNIDAD[iContador] != -1) && (iaUNIDAD2[iContador]!=iaUNIDAD[iContador-1]) && (iComprobar_Entero(iaUNIDAD[iContador],2) == 0))
				{
					sCadenaParams += "U"+(iContador+1) + "D" + iaUNIDAD[iContador]+";";
				}
				if((caaTSN[iContador] != null) && (caaVALOR[iContador] != null))
				{
					if ((((caaVALOR[iContador].length != 0) && iComprobar_Decimal(caaVALOR[iContador],3)!=-1)) || (caaTSN != null &&  (caaTSN[iContador].length != 0) && (caaTSN[iContador].substr(0,1)=='C')))
					{
						sCadenaParams += "CO"+(iContador+1) + caaVALOR[iContador]+";";
					}
				}
				
			}
			//alert(sCadenaParams);
			var url = "nodo_modificacionDB.php";
			sValores = "paramsNodo="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value;
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange = function() 
			{
				if (xmlHttpDB.readyState==4)
				{
					//alert(xmlHttpDB.responseText);
				}
			}
			xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpDB.send(sValores);
		}

		function iAsignar_Tab(sNombreTab)
		{
			switch (sNombreTab)
			{
				case 'a2':
					return 1;
				case 'a3':
					return 2;			
				case 'a4':
					return 3;
				case 'a5':
					return 4;
				case 'a6':
					return 5;
				case 'a1':
				default:
					return 0;  
			}
		}
		function vRellenar_Valores_Sensor()
		{
			document.getElementById('NNO').value = caNNO;
			if (iTNO != -1)
			{
				document.getElementById('TNO').selectedIndex = iTNO;
			}
			else
			{
				document.getElementById('TNO').selectedIndex = -1;
			}
			
			if (iaSEN[iSensor] != -1)
			{
				document.getElementById('SEN').selectedIndex = iaSEN[iSensor];
			}
			else
			{
				document.getElementById('SEN').selectedIndex = -1;
			}
			if (iaTMN[iSensor] != -1)
			{
				document.getElementById('TMS').value = iaTMN[iSensor];
			}
			else
			{
				document.getElementById('TMS').value = "";
			}
			if (iaTEN[iSensor] != -1)
			{
				document.getElementById('TES').value = iaTEN[iSensor];
			}
			else
			{
				document.getElementById('TES').value = "";
			}
			if (iaUMN[iSensor] != -1)
			{
				document.getElementById('UMS').value = iaUMN[iSensor];
			}
			else
			{
				document.getElementById('UMS').value = "";
			}
			if (iaUNN[iSensor] != -1)
			{
				document.getElementById('UNS').value = iaUNN[iSensor];
			}
			else
			{
				document.getElementById('UNS').value = "";
			}
			if (iaTGN[iSensor] != -1)
			{
				document.getElementById('TGS').value = iaTGN[iSensor];
			}
			else
			{
				document.getElementById('TGS').value = "";
			}
			if (iaGMN[iSensor] != -1)
			{
				document.getElementById('GMS').value = iaGMN[iSensor];
			}
			else
			{
				document.getElementById('GMS').value = "";
			}
			if (caaTSN[iSensor].length == 3)
			{
				vRellenar_Combos_Tipo_Sensor(caaTSN[iSensor], 'ISE', 'PSE', 'TSE');
			}
			else
			{
				document.getElementById('PSE').selectedIndex=-1;
				document.getElementById('TSE').selectedIndex=-1;
				document.getElementById('ISE').selectedIndex=-1;
			}
			document.getElementById('SNO').value = caaSNN[iSensor];
			document.getElementById('email_on').selectedIndex = iaNOTIFICA_EMAIL[iSensor];
			document.getElementById('sms_on').selectedIndex = iaNOTIFICA_SMS[iSensor];
			document.getElementById('HMR').selectedIndex = iHMR;
			document.getElementById('OPE').selectedIndex = iaOPERACION[iSensor];
			document.getElementById('CON').value = caaVALOR[iSensor];
			document.getElementById('MAX').value = iaMAXIMO[iSensor];
			document.getElementById('MIN').value = iaMINIMO[iSensor];
			document.getElementById('UND').value = iaUNIDAD[iSensor];
			
			vActualizar_Unidades('ISE','PSE','TSE');
			vOnChangeSensorType('ISE','PSE','TSE');
		}
		function vActualizar_Datos_Sensor()
		{
			caNNO=document.getElementById('NNO').value;
			iTNO=document.getElementById('TNO').selectedIndex;
			iaSEN[iSensor] = document.getElementById('SEN').selectedIndex;
			if ((document.getElementById('ISE').selectedIndex != -1) && (document.getElementById('ISE').selectedIndex != -1) && (document.getElementById('ISE').selectedIndex != -1))
			{
				caaTSN[iSensor] = sPreparar_Tipo_Sensor('ISE', 'PSE', 'TSE');
			}
			else
			{
				document.getElementById('PSE').selectedIndex=-1;
				document.getElementById('TSE').selectedIndex=-1;
				document.getElementById('ISE').selectedIndex=-1;
				caaTSN[iSensor]="";
			}
			iaOPERACION[iSensor] = document.getElementById('OPE').selectedIndex;								
			iaMAXIMO[iSensor] = document.getElementById('MAX').value;			
			iaMINIMO[iSensor] = document.getElementById('MIN').value;
			iaUNIDAD[iSensor] = document.getElementById('UND').value;
			if (document.getElementById('CON').value)
			{
				caaVALOR[iSensor] = document.getElementById('CON').value;				
			}
			else
			{
				caaVALOR[iSensor]=1;
			}
			if (document.getElementById('TMS').value)
			{
				iaTMN[iSensor] = parseFloat(document.getElementById('TMS').value);
			}
			else
			{
				iaTMN[iSensor]=-1;
			}
			if (document.getElementById('TES').value)
			{
				iaTEN[iSensor] = parseFloat(document.getElementById('TES').value);
			}
			else
			{
				iaTEN[iSensor]=-1;
			}
			if (document.getElementById('UMS').value)
			{
				iaUMN[iSensor] = document.getElementById('UMS').value;
			}
			else
			{
				iaUMN[iSensor]=-1;
			}
			if (document.getElementById('UNS').value)
			{
				iaUNN[iSensor] = document.getElementById('UNS').value;			
			}
			else
			{
				iaUNN[iSensor]=-1;
			}
			if (document.getElementById('TGS').value)
			{
				iaTGN[iSensor] = parseFloat(document.getElementById('TGS').value);
			}
			else
			{
				iaTGN[iSensor]=-1;
			}
			if (document.getElementById('GMS').value)
			{
				iaGMN[iSensor] = document.getElementById('GMS').value;				
			}
			else
			{
				iaGMN[iSensor]=-1;
			}			
			caaSNN[iSensor] = document.getElementById('SNO').value;

			iHMR = document.getElementById('HMR').selectedIndex;
			iaNOTIFICA_EMAIL[iSensor] = document.getElementById('email_on').selectedIndex;
			iaNOTIFICA_SMS[iSensor] = document.getElementById('sms_on').selectedIndex;			
		}
		function OnTabSensorChange(data)
		{
			vActualizar_Datos_Sensor();
		    caSensor = data[0];
		    iSensor = iAsignar_Tab(caSensor);	
		    caaTSN[iSensor] = sActualizarValorParam(caaTSN[iSensor]);	   
		    vRellenar_Valores_Sensor();
		}
		function Guardar()
		{
			var sCadenaParams;
			var url;
			var iContador;
			var iSubContador;
			var iCambios;
			var iCambiosNom;
			var iCambiosDB;
			var iNumero;
			var caComando;

			vActualizar_Datos_Sensor();

			iCambios = 0;
			iCambiosDB = 0;
			if ((caNNO!='') || (iTNO!=-1))
			{
				iCambios++;
			}
			for (iContador = 0; iContador < 6; iContador++)
			{
				if ((iaSEN[iContador]!=-1) || (iaTMN[iContador]!=-1) || (iaTEN[iContador]!=-1) || (iaUMN[iContador]!=-1) || (iaUNN[iContador]!=-1) || (iaTGN[iContador]!=-1)
						 || (iaGMN[iContador]!=-1) || (caaTSN[iContador]!='') || (caaSNN[iContador]!=''))
				{
					iCambios++;
				}
			}
			if (iCambios > 0)
			{
				if (iComprobar_Valores_Nodo() == 0)
				{
					$('#imagen_espera_mod').attr("class", 'mostrado');
					caComando = "L"+document.getElementById('gw_id').value+"N"+document.getElementById('object_ip').value;
					if (((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_offline;?>))
						|| (caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw_low;?>))
					{
						url = "nodo_lecturaDB.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value+"&nodo_mac="+document.getElementById('object_id').value+"&comando="+caComando;
					}
					else
					{
						url = "nodo_lectura.php?comando="+caComando;
					}
					//alert(url);
					xmlHttpgrReadNode= GetXmlHttpObject();
					xmlHttpgrReadNode.open("GET",url,true);
					xmlHttpgrReadNode.onreadystatechange=function()
					{
						if (xmlHttpgrReadNode.readyState==4)
						{
							if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
							{
								alert(xmlHttpgrReadNode.responseText);
								$('#imagen_espera_mod').attr("class", 'escondido');
								document.getElementById('boton_leer').disabled="";
								document.getElementById('boton_enviar').disabled="";
								document.getElementById('boton_limpiar').disabled="";
								document.getElementById('boton_av').disabled="";
							}
							else
							{
								//document.getElementById('xml_params').value=xmlHttpgrReadNode.responseText;
								vParsear_Trama_Nodo(xmlHttpgrReadNode.responseText,1);
								iCambios = 0;
								iCambiosNom = 0;
								sCadenaParams = "M" + document.getElementById('gw_id').value + "N" + document.getElementById('object_ip').value + ";";
								sCadenaParamsNom = "N" + document.getElementById('gw_id').value + "D" + document.getElementById('object_ip').value;
		
								if ((caNNO != '') && (caNNO2 != caNNO))
								{
									sCadenaParamsNom += caNNO;
									iCambiosNom++;
								}
								else
								{
									sCadenaParamsNom += caNNO2;
								}
								sCadenaParamsNom += ";";
		
								if ((iTNO != -1) && (iTNO2 != iTNO))
								{
									sCadenaParamsNom += iTNO;
									iCambiosNom++;
								}
								else
								{
									sCadenaParamsNom += iTNO2;
								}
	
								iNumero=0;
								if (((iaSEN[0]!=-1)&&(iaSEN2[0]!=iaSEN[0]))
										|| ((iaSEN[1]!=-1)&&(iaSEN2[1]!=iaSEN[1]))
										|| ((iaSEN[2]!=-1)&&(iaSEN2[2]!=iaSEN[2]))
										|| ((iaSEN[3]!=-1)&&(iaSEN2[3]!=iaSEN[3]))
										|| ((iaSEN[4]!=-1)&&(iaSEN2[4]!=iaSEN[4]))
										|| ((iaSEN[5]!=-1)&&(iaSEN2[5]!=iaSEN[5])))
								{
									for(iSubContador=0;iSubContador<6;iSubContador++)
									{
										if (iaSEN[iSubContador]!=-1)
										{
											if (iaSEN[iSubContador] == '1')
											{
												iNumero+=Math.pow(2,iSubContador);									
											}
										}
										else
										{
											if (iaSEN2[iSubContador] == '1')
											{
												iNumero+=Math.pow(2,iSubContador);									
											}
										}
									}
									sCadenaParams += "SEN" + pad_izquierda(iNumero.toString(),3,'0')+";";
									iCambios++;
								}
								else
								{
									for(iSubContador=0;iSubContador<6;iSubContador++)
									{
										if (iaSEN2[iSubContador] == '1')
										{
											iNumero+=Math.pow(2,iSubContador);									
										}
									}
								}
								sCadenaParamsNom += pad_izquierda(iNumero.toString(),3,'0');
		
								for (iContador = 1; iContador < 7; iContador++)
								{
									if (iaSEN[iContador-1]=='1')
									{
										if ((iaTMN[iContador-1] != -1) && (iaTMN2[iContador-1]!=iaTMN[iContador-1]))
										{
											sCadenaParams += "TM"+iContador  + iaTMN[iContador-1] + ";";
											iCambios++;
										}
										if ((iaTEN[iContador-1] != -1) && (iaTEN2[iContador-1]!=iaTEN[iContador-1]))
										{
											sCadenaParams += "TE"+iContador + iaTEN[iContador-1]+";";
											iCambios++;
										}
										
										if ((iaUMN[iContador-1] != -1) && (iaUMN2[iContador-1]!=iaUMN[iContador-1]))
										{
											if (caaTSN[iContador-1] != "")
											{
												sCadenaParams += "UM"+iContador + sConvertir_Inversa_Datos_Nodo(iaUMN[iContador-1], caaTSN[iContador-1],'D',iaOPERACION[iContador-1],caaVALOR[iContador-1], iaMAXIMO[iContador-1], iaMINIMO[iContador-1])+";";
											}
											else
											{
												sCadenaParams += "UM"+iContador + iaUMN[iContador-1]+";";
											}
											iCambios++;
										}
										if ((iaUNN[iContador-1] != -1) && (iaUNN2[iContador-1]!=iaUNN[iContador-1]))
										{
											if (caaTSN[iContador-1] != "")
											{
												sCadenaParams += "UN"+iContador + sConvertir_Inversa_Datos_Nodo(iaUNN[iContador-1], caaTSN[iContador-1],'D',iaOPERACION[iContador-1],caaVALOR[iContador-1], iaMAXIMO[iContador-1], iaMINIMO[iContador-1])+";";
											}
											else
											{
												sCadenaParams += "UN"+iContador + iaUNN[iContador-1]+";";
											}									
											iCambios++;
										}
										if ((iaGMN[iContador-1] != -1) && (iaGMN2[iContador-1]!=iaGMN[iContador-1]))
										{
											if (caaTSN[iContador-1] != "")
											{
												sCadenaParams += "GM"+iContador + sConvertir_Inversa_Datos_Nodo(iaGMN[iContador-1], caaTSN[iContador-1],'G',iaOPERACION[iContador-1],caaVALOR[iContador-1], iaMAXIMO[iContador-1], iaMINIMO[iContador-1])+";";
											}
											else
											{
												sCadenaParams += "GM"+iContador + iaGMN[iContador-1]+";";
											}									
											iCambios++;
										}								
										if ((iaTGN[iContador-1] != -1) && (iaTGN2[iContador-1]!=iaTGN[iContador-1]))
										{
											sCadenaParams += "TG"+iContador + iaTGN[iContador-1]+";";
											iCambios++;
										}
																	
										if ((caaTSN[iContador-1] != '') && (caaTSN2[iContador-1]!=caaTSN[iContador-1]))
										{
											sCadenaParams += "TS"+iContador + caaTSN[iContador-1]+";";
											iCambios++;
											sCadenaParamsNom += caaTSN[iContador-1];
											iCambiosNom++;
										}
										else if (caaTSN2[iContador-1]!='')
										{
											sCadenaParamsNom += caaTSN2[iContador-1];									
										}
										else
										{
											sCadenaParamsNom += '110';
										}							
										if ((caaSNN[iContador-1] != '') && (caaSNN2[iContador-1]!=caaSNN[iContador-1]))
										{
											sCadenaParamsNom += caaSNN[iContador-1];
											iCambiosNom++;
										}
										else
										{
											sCadenaParamsNom += caaSNN2[iContador-1];
										}
									}
									else if ((iaSEN[iContador-1]!='0') && (iaSEN2[iContador-1]=='1'))
									{
										if ((caaTSN[iContador-1] != '') && (caaTSN2[iContador-1]!=caaTSN[iContador-1]))
										{
											sCadenaParamsNom += caaTSN[iContador-1];
											iCambiosNom++;
										}
										else if (caaTSN2[iContador-1]!='')
										{
											sCadenaParamsNom += caaTSN2[iContador-1];									
										}
										else
										{
											sCadenaParamsNom += '110';
										}							
										if ((caaSNN[iContador-1] != '') && (caaSNN2[iContador-1]!=caaSNN[iContador-1]))
										{
											sCadenaParamsNom += caaSNN[iContador-1];
											iCambiosNom++;
										}
										else
										{
											sCadenaParamsNom += caaSNN2[iContador-1];
										}										
									}
									sCadenaParamsNom += ';';
									
									if ((iaMAXIMO[iContador-1] != '') && (iaMAXIMO2[iContador-1]!=iaMAXIMO[iContador-1]))
									{
										iCambiosDB++;
									}
									if ((iaMINIMO[iContador-1] != '') && (iaMINIMO2[iContador-1]!=iaMINIMO[iContador-1]))
									{
										iCambiosDB++;
									}
									if ((iaUNIDAD[iContador-1] != '') && (iaUNIDAD2[iContador-1]!=iaUNIDAD[iContador-1]))
									{
										iCambiosDB++;
									}
								}
								
								if ((iCambios > 0) || (iCambiosNom > 0) || (iCambiosDB > 0))
								{
									if (iComprobar_Davis(0) == 0)
									{
										if (confirm(iObtener_Cadena_AJAX('nodo_text2')+" \r\n"+iObtener_Cadena_AJAX('general0')))
										{
											$('#imagen_espera_mod').attr("class", 'mostrado');
											if (((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_offline;?>))
												|| (caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw_low;?>))
											{
												if (iCambios > 0)
											    {
												    url = "nodo_modificacion_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip="+document.getElementById('object_ip').value+"&comando="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
												    var rn= Math.floor(Math.random()*10000);
													url += "&indicetrama="+('0000'+rn).slice(-4);
												    xmlHttpgrReadNode= GetXmlHttpObject();
												    xmlHttpgrReadNode.open("GET",url,false);
												    xmlHttpgrReadNode.send(null);
												    if (xmlHttpgrReadNode.responseText=='ERROR')
												    {
													    alert(xmlHttpgrReadNode.responseText);
													    $('#imagen_espera_mod').attr("class", 'escondido');
													    return;
												    }
											    }
											    if (iCambiosNom > 0)
											    {
												    url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip="+document.getElementById('object_ip').value+"&comando="+sCadenaParamsNom+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
												    xmlHttpgrReadNode= GetXmlHttpObject();
												    xmlHttpgrReadNode.open("GET",url,false);
												    xmlHttpgrReadNode.send(null);
												    if (xmlHttpgrReadNode.responseText=='ERROR')
												    {
													    alert(xmlHttpgrReadNode.responseText);
													    $('#imagen_espera_mod').attr("class", 'escondido');
													    return;
												    }
											    }
											    alert(iObtener_Cadena_AJAX('general360'));
											}
											else
											{
												if (iCambios > 0)
												{
													url = "nodo_modificacion.php?comando="+sCadenaParams;
													xmlHttpgrReadNode= GetXmlHttpObject();
													xmlHttpgrReadNode.open("GET",url,false);
													xmlHttpgrReadNode.send(null);
													if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
													{
														alert(xmlHttpgrReadNode.responseText);
														$('#imagen_espera_mod').attr("class", 'escondido');
														return;
													}
												}
												if (iCambiosNom > 0)
												{
													url = "nodo_modificacion_nombre.php?comando="+sCadenaParamsNom;
													xmlHttpgrReadNode= GetXmlHttpObject();
													xmlHttpgrReadNode.open("GET",url,false);
													xmlHttpgrReadNode.send(null);
													if ((xmlHttpgrReadNode.responseText=='ERROR')||(xmlHttpgrReadNode.responseText=='Timeout'))
													{
														alert(xmlHttpgrReadNode.responseText);
														$('#imagen_espera_mod').attr("class", 'escondido');
														return;
													}
												}
												alert(iObtener_Cadena_AJAX('general22'));
											}
											vGuarda_Params_Notificacion_DB();
											$('#imagen_espera_mod').attr("class", 'escondido');
										}
									}
								}
								else
								{
									alert(iObtener_Cadena_AJAX('general188'));
								}
								$('#imagen_espera_mod').attr("class", 'escondido');
								document.getElementById('boton_leer').disabled="";
								document.getElementById('boton_enviar').disabled="";
								document.getElementById('boton_limpiar').disabled="";
								document.getElementById('boton_av').disabled="";
							}
						}
					}
					$('#imagen_espera_mod').attr("class", 'mostrado');
					document.getElementById('boton_leer').disabled="true";
					document.getElementById('boton_enviar').disabled="true";
					document.getElementById('boton_limpiar').disabled="true";
					document.getElementById('boton_av').disabled="false";
					xmlHttpgrReadNode.send(null);
				}
				else
				{
					alert(iObtener_Cadena_AJAX('general96'));
				}
			}
			else
			{
				alert(iObtener_Cadena_AJAX('general188'));				
			}
		}

		function GuardarDB()
		{
			var sCadenaParams;
			var url;
			var sValores;
			var xmlHttpDB;

			vActualizar_Datos_Sensor();

			if (iComprobar_Todos_Valores_Nodo() == 0)
			{
				sCadenaParams = sPrepararCadenaNodo();

				if (iComprobar_Davis(1) == 0)
				{
					if (confirm(iObtener_Cadena_AJAX('general189')+" \r\n"+iObtener_Cadena_AJAX('general0')))
					{
						$('#imagen_espera_modDB').attr("class", 'mostrado');
						url = "nodo_modificacionDB.php";
						sValores = "paramsNodo="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value;
						xmlHttpDB= GetXmlHttpObject();
						xmlHttpDB.open("POST",url,true);
						xmlHttpDB.onreadystatechange = function() 
						{
							if (xmlHttpDB.readyState==4)
							{
								$('#imagen_espera_modDB').attr("class", 'escondido');
								alert(xmlHttpDB.responseText);
							}
						}
						xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
						xmlHttpDB.send(sValores);
						return;
					}
				}
			}
			else
			{
				alert(iObtener_Cadena_AJAX('general96'));
			}
		}
	</script>
</head>

<body>	
	<table border="0" width="100%">
		<tr style="width:100%">
			<td></td>
			<td align="left" valign="bottom">
				<table border="0" width="100%">
					<tr>
						<td style="width:10%"></td>
						<?php 
						if ($_GET['objeto_id'])
						{
						?>
						<td style="width:80" align="center"><span><?echo $idiomas[$_SESSION['opcion_idioma']]['general207'].' '.$_GET['objeto_id']?></span></td>
						<?php
						}
						else
						{
						?>
						<td style="width:80" align="center"><span><?echo $idiomas[$_SESSION['opcion_idioma']]['general207'].' '.$_POST['object_id']?></span></td>
						<?php 
						} 
						?>
						<td style="width:10%"></td>
					</tr>
				</table>
			</td>
			<td></td>
		</tr>
		<tr style="width:100%">
			<td></td>
			<td align="left">
			<table border="0" width="100%">
					<tr>
						<td style="width:5%"></td>
						<td style="width:90">
							<div class="rounded-middle-box">
							    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
							    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
							    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
							    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
								<div class="box-contents">
									<table border="0" width="100%">
										<tr>
											<td style="width:20%" align="center"><span style="align;center" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span></td>
											<td style="width:2"></td>
											<td style="width:20%" align="center"><span style="align:center" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param38']?></span></td>
											<td style="width:2"></td>
											<td style="width:30%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general326']?></span></td>
										</tr>
										<tr>
											<td style="width:20%" align="center"><input type="text" name="NNO" id="NNO" style="text-align:center" maxlength="20"/></td>
											<td style="width:2%"></td>
											<td style="width:20%" align="center"><select name="TNO" id="TNO" style="text-align:center"/></td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center"><select name="HMR" id="HMR" style="width:50px;text-align:center"/></td>
										</tr>
									</table>
								</div>
							</div>
						</td>
						<td style="width:5%"></td>
					</tr>
				</table>
			</td>
			<td>
				<form action="configuracion_nodo_avanzada.html.php" method="post" name="config_nodo_form">
				<table border="0" width="50%">
					<tr>
						<td style="width:45%"></td>
						<td style="width:5%"></td>
						<td style="width:45%" align="center">
							<input type="submit" name="boton_config_imagen_nodo" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general191']?>" class="boton_fino_largo" id="boton_imagen"  onclick="config_nodo_form.action='configuracion_nodo_imagen.html.php';return true;"/>
						</td>
						<td style="width:5%"></td>
					</tr>
					<tr>						
						<td style="width:45%"></td>
						<td style="width:5%">							
						</td>
						<td style="width:45%" align="center">
							<?php 
								if ($_GET['gw_id'])
								{
									?>
									<input type="hidden" id="object_id" name="object_id" value="<?php echo $_GET['objeto_id']?>"/>
									<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $_GET['objeto_ip']?>"/>
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $_GET['gw_id']?>"/>
									<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $_GET['gw_tipo']?>"/>
									<input type="hidden" id="xml_params" name="xml_params" value=''/>
									<?php 
								}
								else
								{
									?>
									<input type="hidden" id="object_id" name="object_id" value="<?php echo $_POST['object_id']?>"/>
									<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $_POST['object_ip']?>"/>
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $_POST['gw_id']?>"/>
									<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $_POST['gw_tipo']?>"/>
									<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $_POST['xml_params']?>"/>										
									<?php 
								}
								?>	
								<input type="submit" name="boton_config_avanzada_nodo" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general84']?>" class="boton_fino_largo" id="boton_av"  onclick="config_nodo_form.action='configuracion_nodo_avanzada.html.php';return true;"/>															
						</td>
						<td style="width:5%"></td>						
					</tr>
					<tr>
						<td style="width:45%"></td>
						<td style="width:5%"></td>
						<td style="width:45%" align="center"></td>
						<td style="width:5%"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	    
	<table border="0" width="100%">
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center">
				<span style="align:center"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general208'].' '.$_GET['objeto_id']?></span>
			</td>
			<td><br/></td>
		</tr>
	</table>
	    
	<div class="rounded-big-box">
		    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
		    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
		    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
		    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
		
	<table border="0" width="100%">
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center">
				<div id="a_tabbar" style="width:450px; height:20px;"/>
				<div id='html_1'></div>
				<div id='html_2'></div>
				<div id='html_3'></div>
				<div id='html_4'></div>
				<div id='html_5'></div>
				<div id='html_6'></div>
				<script>
					tabbar = new dhtmlXTabBar("a_tabbar", "top");
					tabbar.setSkin('dark_blue');
					tabbar.setImagePath("codebase/imgs/");
					tabbar.addTab("a1", iObtener_Cadena_AJAX('general102')+" 1", "70px");
					tabbar.addTab("a2", iObtener_Cadena_AJAX('general102')+" 2", "70px");
					tabbar.addTab("a3", iObtener_Cadena_AJAX('general102')+" 3", "70px");
					tabbar.addTab("a4", iObtener_Cadena_AJAX('general102')+" 4", "70px");
					tabbar.addTab("a5", iObtener_Cadena_AJAX('general102')+" 5", "70px");
					tabbar.addTab("a6", iObtener_Cadena_AJAX('general102')+" 6", "70px");
					tabbar.setContent("a1", "html_1");
					tabbar.setContent("a2", "html_2");
					tabbar.setContent("a3", "html_3");
					tabbar.setContent("a4", "html_4");
					tabbar.setContent("a5", "html_5");
					tabbar.setContent("a6", "html_6");
					tabbar.setTabActive("a1");
					tabbar.attachEvent("onSelect", function() {
						OnTabSensorChange(arguments);
					    return true;
					});
				</script>
			</td>
			<td><br/></td>
		</tr>
		<tr  style="width:90%">
			<td></td>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general209']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center"  colspan="5"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param48']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param49']?></span></td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center">
							<select id="SEN" style="margin:0px 0 5px 0;text-align:center"/>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center" colspan="5"><input type="text" name="SNO" id="SNO" style="width:180px;text-align:center" maxlength="20"></input></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center"><input type="text" name="GMS" id="GMS" style="width:70px;text-align:center" maxlength="5"/></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center">
							<input type="text" name="TGS" id="TGS" style="width:70px;text-align:center" maxlength="5"/>
							<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
							</td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center">
							<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general6']?></span>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center" colspan="5"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param50']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span></td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center" class="top_tborder right_tborder left_tborder bottom_tborder" rowspan="3">
							<span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?></span>
							<select id="email_on" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
								<option>OFF</option>
								<option>ON</option>
							</select>
							<span style="align:left" class="texto_parametros">SMS</span>
							<select id="sms_on" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
								<option>OFF</option>
								<option>ON</option>
							</select>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center" colspan="5">
							<select id="ISE" style="margin:0px 0 5px 0;text-align:center" onchange="OnChangeInterfaz('ISE','PSE','TSE')"/>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center">
							<input type="text" name="UMS" id="UMS" style="width:70px;text-align:center" maxlength="5"/>
							<span id="UM_unit" class="texto_valores"></span>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center">
							<input type="text" name="TMS" id="TMS" style="width:70px;text-align:center" maxlength="5"/>
							<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
						</td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center" colspan="5">
							<table border="0" width="100%">
								<tr>
									<td style="width:25%">
										<span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param52']?></span>
									</td>
									<td style="width:15%"></td>
									<td style="width:50%">
										<span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
									</td>
								</tr>
							</table>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span></td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:35%" align="center" colspan="5">
							<table border="0" width="100%">
								<tr>
									<td style="width:25%">
										<select id="PSE" style="margin:0px 0 5px 0;text-align:center" onchange="vOnChangeSensorType('ISE','PSE','TSE')"/>
									</td>
									<td style="width:15%"></td>
									<td style="width:50%">
										<select id="TSE" style="margin:0px 0 5px 0;text-align:center" onchange="vOnChangeSensorType('ISE','PSE','TSE')"/>
									</td>
								</tr>
							</table>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center">
							<input type="text" name="UNS" id="UNS" style="width:70px;text-align:center" maxlength="5"/>
							<span id="UN_unit" class="texto_valores"></span>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center">
							<input type="text" name="TES" id="TES" style="width:70px;text-align:center" maxlength="5"/>
							<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
						</td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center">							
						</td>							
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center"><span style="align:left" class="texto_parametros" id="texto_max"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_maximo']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:13%" align="center"><span style="align:left" class="texto_parametros" id="texto_min"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_minimo']?></span></td>
						<td style="width:2%" align="center"><br/></td>						
						<td style="width:10%" align="center"><span style="align:left" class="texto_parametros" id="texto_und"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:29%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param68']?></span></td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param69']?></span></td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center">							
						</td>						
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center">
							<input type="text" name="MAX" id="MAX" style="width:50px;text-align:center" class="texto_valores escondido" maxlength="5"/>
						</td>
						<td style="width:2%"><br/></td>
						<td style="width:13%" align="center">
							<input type="text" name="MIN" id="MIN" style="width:50px;text-align:center" class="texto_valores escondido" maxlength="5"/>
						</td>
						<td style="width:2%"><br/></td>
						<td style="width:10%" align="center">
							<select name="UND" id="UND" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2" onchange="vActualizar_Unidades('ISE','PSE','TSE');"/>
						</td>						
						<td style="width:2%"><br/></td>
						<td style="width:29%" align="center">
							<select id="OPE" style="margin:0px 0 5px 0;text-align:center" disabled="disabled"/>
						</td>
						<td style="width:2%" align="center"><br/></td>
						<td style="width:20%" align="center"><input type="text" name="CON" id="CON" style="width:70px;text-align:center" maxlength="5" disabled="disabled"/></td>
					</tr>
					<tr>
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center"></td>						
						<td style="width:2%"><br/></td>
						<td style="width:8%" align="center"></td>
						<td style="width:2%"><br/></td>
						<td style="width:13%"><br/></td>
						<td style="width:2%"><br/></td>
						<td style="width:10%"><br/></td>						
						<td style="width:2%"><br/></td>
						<td style="width:29%"><br/></td>
						<td style="width:2%"><br/></td>
						<td style="width:20%"><br/></td>
					</tr>
				</table>
			</td>
			<td></td>
		</tr>
	</table>
	</div> 
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:20%" align="right">
				<input type="button" onclick="window.parent.OnBotonMapa(iObtener_Modo_Offline())" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general192']?>" class="boton_fino"/>
			</td>
			<td style="width:20%" align="right">
				<input type="button" onclick="OnLimpiarControlesNodo()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general193']?>" class="boton_fino" id='boton_limpiar'/>
			</td>
			<td style="width:30%" align="right">
				<input type="button" onclick="Cargar_Params_Nodo_DB()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general194']?>" class="boton_fino_medio" id='boton_leerDB'/>
			</td>
			<td style="width:30%" align="right">
				<input type="button" onclick="OnLeerNodo()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general213']?>" class="boton_fino_medio" id='boton_leer'/>
				<img id="imagen_espera" src="images/wait_circle.gif" class="escondido"/>
			</td>
		</tr>
		<tr style="width:100%">
			<td style="width:20%" align="right"></td>
			<td style="width:20%" align="right"></td>
			<td style="width:30%" align="right">
				<img id="imagen_espera_modDB" src="images/wait_circle.gif" class="escondido"/>
				<input type="button" onclick="GuardarDB();" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general196']?>" class="boton_fino_medio" id='boton_enviar'/>				
			</td>
			<td style="width:30%" align="right">
				<input type="button" onclick="Guardar()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general214']?>" class="boton_fino_medio" id='boton_enviarDB'/>
				<img id="imagen_espera_mod" src="images/wait_circle.gif" class="escondido"/>
			</td>
		</tr>
	</table>
	<script>
		Rellenar_CombosYN("HMR");
		Rellenar_Controles_Nodo('TNO','SEN','ISE','PSE','TSE','OPE');
		Rellenar_Uds_Sensor_Generico("UND", 2);
		OnLimpiarControlesNodo();
		Cargar_Params_Nodo_DB();
	</script>
</body>
</html>