<?php session_start();
include 'inc/idiomas.inc';
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
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.dualListBox-1.3.min_kta.js"></script>
	<script type="text/javascript" src="js/dhtmlxcontainer.js"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript">
		var caVersionHW;
		var caVersionSW;
		var xmlHttpgrRead;
		function vGuarda_ParamsGW_Notificacion_DB()
		{
			var iContador;
			var iNumero;
			var sTipoSensAux;
			var sCadenaParams;
			var iContador;
			sCadenaParams = "SUS"+document.getElementById('gw_id').value+";";
			
			if (document.getElementById("HMR").selectedIndex != -1)	
			{
				sCadenaParams += "HMR" + document.getElementById("HMR").selectedIndex+";";
			}
						
			for (iContador = 0; iContador < 23; iContador++)
			{	
				if(iContador < 10)
				{
					if ((document.getElementById("EH"+iContador).selectedIndex != -1) && (document.getElementById("EH"+iContador).selectedIndex < 2))
					{
						sCadenaParams += "EH"+(iContador) + document.getElementById("EH"+iContador).selectedIndex+";";
					}
					if ((document.getElementById("SH"+iContador).selectedIndex != -1) && (document.getElementById("SH"+iContador).selectedIndex < 2))
					{
						sCadenaParams += "SH"+(iContador) + document.getElementById("SH"+iContador).selectedIndex+";";
					}		
					sCadenaParams += "SN"+(iContador) + document.getElementById("SN"+iContador).value+";";
															
				}
				else
				{
					if ((document.getElementById("EH"+iContador).selectedIndex != -1) && (document.getElementById("EH"+iContador).selectedIndex < 2))
					{
						sCadenaParams += "EH"+String.fromCharCode(iContador+55) + document.getElementById("EH"+iContador).selectedIndex+";";
					}
					if ((document.getElementById("SH"+iContador).selectedIndex != -1) && (document.getElementById("SH"+iContador).selectedIndex < 2))
					{
						sCadenaParams += "SH"+String.fromCharCode(iContador+55) + document.getElementById("SH"+iContador).selectedIndex+";";
					}			
					sCadenaParams += "SN"+String.fromCharCode(iContador+55) + document.getElementById("SN"+iContador).value+";";													
				}

				if(iContador < 3)
				{					
					if ((document.getElementById("M"+(iContador)+"X").value != '') && (iComprobar_Decimal(document.getElementById("M"+(iContador)+"X").value,5)!=-1))
					{
						sCadenaParams += "M"+(iContador) + "X" + document.getElementById("M"+(iContador)+"X").value+";";
					}					
					if ((document.getElementById("M"+(iContador)+"N").value != '') && (iComprobar_Decimal(document.getElementById("M"+(iContador)+"N").value,5)!=-1))
					{
						sCadenaParams += "M"+(iContador) + "N" + document.getElementById("M"+(iContador)+"N").value+";";
					}
					if (document.getElementById("U"+(iContador) + "D").selectedIndex != -1)	
					{
						sCadenaParams += "U"+(iContador) + "D" + document.getElementById("U"+(iContador) + "D").selectedIndex+";";
					}
				}
			}
			var url = "gw_modificacionDB_low.php";
			sValores = "paramsGW="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value;
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange = function() 
			{
				if (xmlHttpDB.readyState==4)
				{
					//$('#imagen_espera_modDB').attr("class", 'escondido');
				}
			}
			xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpDB.send(sValores);
		}
		function Guardar()
		{
			var sCadenaParams;
			var url;
			var iContador;
			var iCambios;
			var sCadenaParamsNom;
			var iCambiosNom;
			var sTipoSensAux;
			var sMaximo;
			var sMinimo;
			
			if (iComprobar_Valores_low() == 0)
			{
				iCambios = 0;
				iCambiosNom = 0;
				var rn= Math.floor(Math.random()*10000);			
				sCadenaParams = "M" + document.getElementById('gw_id').value + "IDT"+('0000'+rn).slice(-4)+";";
				sCadenaParams2 = '';
				
				$(':input', '#a_tabbar').each(function()
				{
					if (sCadenaParams.length > 750)
					{
						sCadenaParams2 = sCadenaParams;
						sCadenaParams = "M" + document.getElementById('gw_id').value + "IDT"+('0000'+rn+1).slice(-4)+";";
					}
					
					var type = this.type; 
					var tag = this.tagName.toLowerCase();
					if (type == 'text' || type == 'password' || tag == 'textarea'){	
						if(this.value != "" && this.id != 'NGW' && this.id != 'NGW' 
						&& this.id != 'M0X' && this.id != 'M1X' && this.id != 'M2X'
						&& this.id != 'M0N' && this.id != 'M1N' && this.id != 'M2N'
						&& this.id != 'U0D' && this.id != 'U1D' && this.id != 'U2D'
						&& this.id != 'SN0' && this.id != 'SN0' && this.id != 'SN1' && this.id != 'SN2' && this.id != 'SN3' && this.id != 'SN4' && this.id != 'SN5' && this.id != 'SN6')
						{
							if((this.id.substring(0,1) == 'A'|| this.id.substring(0,1) == 'D') && (this.id.substring(2,3) == 'U' || this.id.substring(2,3) == 'L'))														
							{	
								if(this.id.substring(1,2) < 3 && this.id.substring(0,1) == 'A')
								{									
									sCadenaParams += this.id + sConvertir_Inversa_Datos_Sensor_GW(this.value,parseInt(document.getElementById(this.id.substring(0,1)+this.id.substring(1,2)+"K").options[document.getElementById(this.id.substring(0,1)+this.id.substring(1,2)+"K").selectedIndex].id), document.getElementById('M'+this.id.substring(1,2)+'X').value, document.getElementById('M'+this.id.substring(1,2)+'N').value, "12") +";";	
								}
								else
								{
									sCadenaParams += this.id + sConvertir_Inversa_Datos_Sensor_GW(this.value,parseInt(document.getElementById(this.id.substring(0,1)+this.id.substring(1,2)+"K").options[document.getElementById(this.id.substring(0,1)+this.id.substring(1,2)+"K").selectedIndex].id), 0, 0, "12") +";";
								}
							}
							else
							{
								sCadenaParams += this.id + this.value+";";	
							}
						}						
					}
					else if (tag == 'select')
					{
						if(this.selectedIndex != -1 && this.id.substring(0, 2) != 'SH' && this.id.substring(0, 2) != 'EH'  						
						&& !(this.id.substring(0, 1) == 'U' && this.id.substring(2, 3) == 'D')  && this.id != 'HMR')
						{
							sCadenaParams += this.id + this.options[this.selectedIndex].id +";";						
						}
					}
					else if (type == 'checkbox')
					{
						if((this.id.substring(0, 3) == 'MIN') && (this.id.length==5) && (document.getElementById(this.id).checked))
						{
							tipo1 = document.getElementById(this.id+"1").checked?1:0;
							tipo2 = document.getElementById(this.id+"2").checked?1:0;
							tipo3 = document.getElementById(this.id+"3").checked?1:0;
							sCadenaParams += this.id.substring(3,5)+"A" + tipo1+ tipo2 + tipo3+";";						
						}
						else if((this.id.substring(0, 3) == 'MAX') && (this.id.length==5) && (document.getElementById(this.id).checked))
						{
							tipo1 = document.getElementById(this.id+"1").checked?1:0;
							tipo2 = document.getElementById(this.id+"2").checked?1:0;
							tipo3 = document.getElementById(this.id+"3").checked?1:0;
							sCadenaParams += this.id.substring(3,5) +"B"+ tipo1+ tipo2 + tipo3+";";							
						}
					}
					iCambios++;	
				});				
				if (document.getElementById('NGW').value != '')
				{
					sCadenaParamsNom = "N" + document.getElementById('gw_id').value + "G";
					sCadenaParamsNom += document.getElementById('NGW').value + ";";
					iCambiosNom++;
				}

				if ((iCambios > 0) || (iCambiosNom > 0))
				{
					if (confirm(iObtener_Cadena_AJAX('gw_text3')+" \r\n"+iObtener_Cadena_AJAX('general0')))
					{
						$('#imagen_espera_mod').attr("class", 'mostrado');
						if (iCambios > 0)
						{
							url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
							xmlHttpgrRead= GetXmlHttpObject();
							xmlHttpgrRead.open("GET",url,false);
							xmlHttpgrRead.send(null);
							
							if (sCadenaParams2.length > 0)
							{
								url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+sCadenaParams2+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
								xmlHttpgrRead= GetXmlHttpObject();
								xmlHttpgrRead.open("GET",url,false);
								xmlHttpgrRead.send(null);
							}
						}
						if (iCambiosNom > 0)
						{
							url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+sCadenaParamsNom+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
							xmlHttpgrRead= GetXmlHttpObject();
							xmlHttpgrRead.open("GET",url,false);
							xmlHttpgrRead.send(null);
						}
						$('#imagen_espera_mod').attr("class", 'escondido');
						alert(iObtener_Cadena_AJAX('general360'));
						
						vGuarda_ParamsGW_Notificacion_DB();
					}
				}
				else
				{
					alert(iObtener_Cadena_AJAX('general188'));
				}
			}
			else
			{
				alert(iObtener_Cadena_AJAX('general96'));
			}
		}
		function Rellenar_Version_Gateway(sParametrosGW)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var iSubContador;
			var sCadenaAux;

			sPrincipal=parsear_xml(sParametrosGW.responseText);
			if (sPrincipal != null)
			{
				sListaNombres=sPrincipal.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipal.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					switch (sListaNombres[iContador].childNodes[0].nodeValue)
					{
						case "VHW":
							caVersionHW = sListaValores[iContador].childNodes[0].nodeValue;
							document.getElementById(sListaNombres[iContador].childNodes[0].nodeValue).innerHTML=caVersionHW;
							break;
						case "VSW":
							caVersionSW = sListaValores[iContador].childNodes[0].nodeValue;
							document.getElementById(sListaNombres[iContador].childNodes[0].nodeValue).innerHTML=caVersionSW;
							break;
						default:
							break;
					}
				}
			}
		}

		function Cargar_Params_GW_DB()
		{	
			var url = "gw_lecturaDB_low.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value;

			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,true);
			xmlHttpgrRead.onreadystatechange=function()
			{
				if (xmlHttpgrRead.readyState==4)
				{
					if ((xmlHttpgrRead.responseText=='ERROR')||(xmlHttpgrRead.responseText=='Timeout'))
					{
						alert(xmlHttpgrRead.responseText);
					}
					else
					{
						Rellenar_Controles_Gateway(xmlHttpgrRead);
						Rellenar_Version_Gateway(xmlHttpgrRead);
					}
				}
			}
			xmlHttpgrRead.send(null);
		}

		function Cargar_Params_GW_DB_notifica()
		{
			var url = "gw_lecturaDB_notifica.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value;
			//alert(url);
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,true);
			xmlHttpgrRead.onreadystatechange=function()
			{
				if (xmlHttpgrRead.readyState==4)
				{
					if ((xmlHttpgrRead.responseText=='ERROR')||(xmlHttpgrRead.responseText=='Timeout'))
					{
						alert(xmlHttpgrRead.responseText);
					}
					else
					{
						Rellenar_Controles_Gateway(xmlHttpgrRead);
					}		
				}
			}
			xmlHttpgrRead.send(null);
		}
		
		function OnLimpiarControles() //Función jquery para limpiar todos los datos contenidos en el div
		{
			$(':input', '#a_tabbar').each(function() {
				var type = this.type;
				var tag = this.tagName.toLowerCase();
				if (type == 'text' || type == 'password' || tag == 'textarea')
				this.value = "";
				else if (type == 'checkbox' || type == 'radio')
				this.checked = false;			
				else if (tag == 'select')
				this.selectedIndex = -1;
			});
		}

		function Rellenar_Controles_Gateway(sParametrosGW)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var iSubContador;
			var sCadenaAux;			
			
			sPrincipal=parsear_xml(sParametrosGW.responseText);
			if (sPrincipal != null)
			{
							
				sListaNombres=sPrincipal.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipal.childNodes[0].getElementsByTagName("valor");
	
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{

					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					
					if (sListaValores[iContador].childNodes.length>0)
					{
						sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
					}
					else
					{
						sValorParam='';
					}
					switch (sNombreParam)
					{
						case "A0P":case "A0K":case "A0V":case "A0E":case "U0D":
						case "A1P":case "A1K":case "A1V":case "A1E":case "U1D":
						case "A2P":case "A2K":case "A2V":case "A2E":case "U2D":
						case "A3P":case "A3K":case "A3V":case "A3E":
						case "A4P":case "A4K":case "A4V":case "A4E":
						case "A5P":case "A5K":case "A5V":case "A5E":		
						case "A6P":case "A6K":case "A6V":case "A6E":
						case "D0C":case "D0E":case "D0K":
						case "D1C":case "D1E":case "D1K":
						case "DCC":case "DCE":case "DCK":
						case "DDC":case "DDE":case "DDK":
						case "DEC":case "DEE":case "DEK":
						case "DFC":case "DFE":case "DFK":						
							$("#"+sNombreParam+" option[id='"+sValorParam+"']").attr("selected", true); //Buscamos la opción cuya id corresponde con el valor buscado y la seleccionamos.							
							break;
						case "D2C":case "D2E":case "D2K":
						case "D3C":case "D3E":case "D3K":
						case "D4C":case "D4E":case "D4K":
						case "D5C":case "D5E":case "D5K":
						case "D6C":case "D6E":case "D6K":
						case "D7C":case "D7E":case "D7K":
						case "D8C":case "D8E":case "D8K":
						case "D9C":case "D9E":case "D9K":
						case "DAC":case "DAE":case "DAK":
						case "DBC":case "DBE":case "DBK":
							$("#"+sNombreParam+" option[id='0']").attr("selected", true); //Seleccionamos la opción 0 siempre en estos que están ocultos							
							break;		
						case "EH0": case "EH1":	case "EH2":	case "EH3":	case "EH4":	case "EH5":	case "EH6":	case "EH7":	case "EH8":	case "EH9":	case "EH10":
						case "EH11":case "EH12":case "EH13":case "EH14":case "EH15":case "EH16":case "EH17":case "EH18":case "EH19":case "EH20":case "EH21": case "EH22":
						case "SH0": case "SH1":	case "SH2":	case "SH3":	case "SH4":	case "SH5": case "SH6":	case "SH7":	case "SH8":	case "SH9":	case "SH10":case "SH11": case "SH12":
						case "SH13":case "SH14":case "SH15":case "SH16":case "SH17":case "SH18":case "SH19":case "SH20":case "SH21":case "SH22":
						case "HMR":
							if (sValorParam=="0")
							{
								document.getElementById(sNombreParam).selectedIndex=0;
							}
							else
							{
								document.getElementById(sNombreParam).selectedIndex=1;
							}
							break;
							
						case "A0A": case "A1A": case "A2A": case "A3A": case "A4A": case "A5A": case "A6A":
							sCadenaAux1='MIN'+sNombreParam.substring(0,2);
							for (iSubContador=0;iSubContador<3;iSubContador++)
							{
								sCadenaAux2='MIN'+sNombreParam.substring(0,2)+(iSubContador+1);
								if (sValorParam.substring(iSubContador,iSubContador+1)=='1')
								{
									document.getElementById(sCadenaAux2).checked=true;
									document.getElementById(sCadenaAux1).checked = true;
									OnClickActuacion(sCadenaAux1,sCadenaAux1+'1',sCadenaAux1+'2',sCadenaAux1+'3');
								}
								else
								{
									document.getElementById(sCadenaAux2).checked=false;	
								}
							}
							break;
							
						case "A0B": case "A1B": case "A2B": case "A3B": case "A4B": case "A5B": case "A6B": case "D0B": case "D1B": case "D2B": 
							sCadenaAux1='MAX'+sNombreParam.substring(0,2);
							//console.log(sCadenaAux1);
							for (iSubContador=0;iSubContador<3;iSubContador++)
							{
								sCadenaAux2='MAX'+sNombreParam.substring(0,2)+(iSubContador+1);
								//console.log(sCadenaAux2);
								if (sValorParam.substring(iSubContador,iSubContador+1)=='1')
								{
									document.getElementById(sCadenaAux2).checked=true;
									document.getElementById(sCadenaAux1).checked = true;
									OnClickActuacion(sCadenaAux1,sCadenaAux1+'1',sCadenaAux1+'2',sCadenaAux1+'3');
								}
								else
								{
									document.getElementById(sCadenaAux2).checked=false;	
								}
							}
							break;
							
						default:
							if (document.getElementById(sNombreParam))
							{
								document.getElementById(sNombreParam).value=sValorParam;
							}
							break;						
					}
				}
			}
			for(iContador=0;iContador<16;iContador++)
			{				
				if(iContador < 7)
				{
					vActualizar_Unidades_lowA(iContador.toString(16));					
				}				
				vActualizar_Unidades_lowD(iContador.toString(16).toUpperCase());
			}
		}

		function OnLeerGW()
		{
			var url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando=L"+document.getElementById('gw_id').value+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
			$('#imagen_espera').attr("class", 'mostrado');
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,true);

			xmlHttpgrRead.onreadystatechange=function()
			{
				if (xmlHttpgrRead.readyState==4)
				{
					//Lectura de nombre tambien
					url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando=P"+document.getElementById('gw_id').value+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
					xmlHttpgrRead= GetXmlHttpObject();
					xmlHttpgrRead.open("GET",url,false);
					xmlHttpgrRead.send(null);
					$('#imagen_espera').attr("class", 'escondido');
					document.getElementById('boton_leer').disabled="";
					document.getElementById('boton_enviar').disabled="";
					document.getElementById('boton_limpiar').disabled="";

					if ((xmlHttpgrRead.responseText!='OK'))
					{
						alert(xmlHttpgrRead.responseText);
					}
					else
					{
						alert(iObtener_Cadena_AJAX('general361'));
					}
				}
			}
			document.getElementById('boton_leer').disabled="true";
			document.getElementById('boton_enviar').disabled="true";
			document.getElementById('boton_limpiar').disabled="true";
			xmlHttpgrRead.send(null);			
		}
		function GuardarDB()
		{
			var sCadenaParams;
			var url;
			var sValores;
			var xmlHttpDB;

			if (iComprobar_Todos_Valores_Low() == 0)
			{
				sCadenaParams = sPrepararCadenaGWLow(document.getElementById('gw_id').value);
				//alert(sCadenaParams);
				if (confirm(iObtener_Cadena_AJAX('general189')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					$('#imagen_espera_modDB').attr("class", 'mostrado');
					url = "gw_modificacionDB_low.php";
					sValores = "paramsGW="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value;
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
			else
			{
				alert(iObtener_Cadena_AJAX('general96'));
			}
		}		
		function OnTabGroupChange(datab)
		{
			caGrupoSensor = datab[0];
			//alert(caGrupoSensor);
			switch(caGrupoSensor)
			{
				case "a2":
					tabbardigital.enableContentZone(false);
					tabbaranalog.enableContentZone(true); 
					tabbaranalog.setTabActive("analog1");
					break;
				case "a3":
					tabbaranalog.enableContentZone(false);
					tabbardigital.enableContentZone(true); 
					tabbardigital.setTabActive("digital1");
					break;
				case "a1":
				default:
					tabbaranalog.enableContentZone(false);
					tabbardigital.enableContentZone(false);
					break; 
			}
		}		
	</script>
</head>

<body>
<?php
	if ($_GET['objeto_id'])
	{
		$id_gateway=$_GET['objeto_id']; 
	}
	else
	{
		$id_gateway=$_POST['gw_id']; 
	}
	$iVersiones = 0;
	
	include 'estructura_conf_gw_low.php';
?>	
	<table width="100%" border="0">
		<tr>
			<td style="width:18%" align="right">
				<input type="button" onclick="window.parent.OnBotonMapa(iObtener_Modo_Offline())" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general192']?>" class="boton_fino"/>
			</td>
			<td style="width:18%" align="right">
				<input type="button" onclick="OnLimpiarControles()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general193']?>" class="boton_fino" id="boton_limpiar"/>
			</td>
			<td style="width:31%" align="right">
				<input type="button" onclick="Cargar_Params_GW_DB()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general194']?>" class="boton_fino_medio" id="boton_leerDB"/>
				<img id="imagen_esperaDB" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:33%" align="right">
				<input type="button" onclick="OnLeerGW()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general195']?>" class="boton_fino_largo" id="boton_leer"/>

				<img id="imagen_espera" src="images/wait_circle.gif" class="escondido"/>							
			</td>
		</tr>
		<tr>
			<td style="width:18%" align="right"></td>
			<td style="width:18%" align="right"></td>
			<td style="width:31%" align="right">
				
				<input type="button" onclick="GuardarDB()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general196']?>" class="boton_fino_medio" id="boton_enviarDB"/>
				<img id="imagen_espera_modDB" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:33%" align="right">
				<input type="button" onclick="Guardar()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general197']?>" class="boton_fino_largo" id="boton_enviar"/>
				<img id="imagen_espera_mod" src="images/wait_circle.gif" class="escondido"/>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		Rellenar_Todos_Tipos_Sensor_GW_LOWA();
		Rellenar_Todos_Tipos_Sensor_GW_LOWD();
		Rellenar_Todos_Tipos_Sensor_GW_LOWALI();
		Rellenar_Todas_Uds_Sensor_GWLOW();
		Rellenar_CombosYN("HMR");
		Cargar_Params_GW_DB();
	</script>
</body>
</html>
