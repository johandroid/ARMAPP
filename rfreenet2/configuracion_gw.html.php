<?php session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_db.inc';
	if ($_GET['objeto_id'])
	{
		$id_gateway=$_GET['objeto_id']; 
	}
	else
	{
		$id_gateway=$_POST['gw_id']; 
	}
	list($iHabUTC, $iHabModbusTCP) = iComprobar_Hab_Params_GW_Version($id_gateway, $_SESSION['cliente_db']);
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
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
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
			
			for (iContador = 1; iContador < 10; iContador++)
			{
				if ((document.getElementById("EH"+iContador).selectedIndex != -1) && (document.getElementById("EH"+iContador).selectedIndex < 2))
				{
					sCadenaParams += "EH"+(iContador) + document.getElementById("EH"+iContador).selectedIndex+";";
				}
				if ((document.getElementById("SH"+iContador).selectedIndex != -1) && (document.getElementById("SH"+iContador).selectedIndex < 2))
				{
					sCadenaParams += "SH"+(iContador) + document.getElementById("SH"+iContador).selectedIndex+";";
				}
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
				if (document.getElementById("SN"+(iContador)).value != '')	
				{
					
					sCadenaParams += "SN"+(iContador) + document.getElementById("SN"+(iContador)).value+";";
				}
			}
			var url = "gw_modificacionDB.php";
			sValores = "paramsGW="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value;
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange = function() 
			{
				if (xmlHttpDB.readyState==4)
				{
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

			if (iComprobar_Valores() == 0)
			{
				iCambios = 0;
				iCambiosNom = 0;
				if (caVersionSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
				{
					sCadenaParams = "M" + document.getElementById('SUS').value;
				}
				else
				{
					var rn= Math.floor(Math.random()*10000);			
					sCadenaParams = "M" + document.getElementById('gw_id').value + "IDT"+('0000'+rn).slice(-4)+";";
				}
	
				if (document.getElementById('TCH').selectedIndex != -1)
				{
					sCadenaParams += "TCH"+document.getElementById('TCH').selectedIndex;
					iCambios++;
				}
				if (document.getElementById('DHP').selectedIndex != -1)
				{
					sCadenaParams += "DHP"+document.getElementById('DHP').selectedIndex;
					iCambios++;
				}
				if (document.getElementById('IPX').value != "")
				{
					sCadenaParams += "IPX" + document.getElementById('IPX').value;
					iCambios++;
				}
				if (document.getElementById('IPY').value != "")
				{
					sCadenaParams += "IPY" + document.getElementById('IPY').value;
					iCambios++;
				}
				if (document.getElementById('PRX').value != "")
				{
					sCadenaParams += "PRX" + document.getElementById('PRX').value;
					iCambios++;
				}
				if (document.getElementById('PRY').value != "")
				{
					sCadenaParams += "PRY" + document.getElementById('PRY').value;
					iCambios++;
				}
				if (document.getElementById('ITC').value != "")
				{
					sCadenaParams += "ITC" + document.getElementById('ITC').value;
					iCambios++;
				}
				if (document.getElementById('PGT').value != "")
				{
					sCadenaParams += "PGT" + document.getElementById('PGT').value;
					iCambios++;
				}
				if (document.getElementById('PGU').value != "")
				{
					sCadenaParams += "PGU" + document.getElementById('PGU').value;
					iCambios++;
				}
				if (document.getElementById('IPP').value != "")
				{
					sCadenaParams += "IPP" + document.getElementById('IPP').value;
					iCambios++;
				}
				if (document.getElementById('MSK').value != "")
				{
					sCadenaParams += "MSK" + document.getElementById('MSK').value;
					iCambios++;
				}
				if (document.getElementById('PDE').value != "")
				{
					sCadenaParams += "PDE" + document.getElementById('PDE').value;
					iCambios++;
				}
				if (document.getElementById('TPP').value != "")
				{
					sCadenaParams += "TPP" + document.getElementById('TPP').value;
					iCambios++;
				}
				if (document.getElementById('GPH').selectedIndex != -1)
				{
					sCadenaParams += "GPH"+document.getElementById('GPH').selectedIndex;
					iCambios++;
				}
				if (document.getElementById('IPW').value != "")
				{
					sCadenaParams += "IPW" + document.getElementById('IPW').value;
					iCambios++;
				}
				if (document.getElementById('IPZ').value != "")
				{
					sCadenaParams += "IPZ" + document.getElementById('IPZ').value;
					iCambios++;
				}
				if (document.getElementById('GSH').selectedIndex != -1)
				{
					sCadenaParams += "GSH"+document.getElementById('GSH').selectedIndex;
					iCambios++;
				}
				if (document.getElementById('GSX').value != "")
				{
					sCadenaParams += "GSX" + document.getElementById('GSX').value;
					iCambios++;
				}
				if (document.getElementById('GSY').value != "")
				{
					sCadenaParams += "GSY" + document.getElementById('GSY').value;
					iCambios++;
				}
				if (document.getElementById('KEY').value != "")
				{
					sCadenaParams += "KEY" + document.getElementById('KEY').value;
					iCambios++;
				}
	
				for (iContador = 1; iContador < 10; iContador++)
				{
					iTSTemp = iObtener_TSGW_Select("TS"+iContador);
					if (iTSTemp == -1)
					{
						sTipoSensAux = "0";
					}
					else
					{
						sTipoSensAux = iTSTemp;
					}

					if (document.getElementById('T'+iContador+'M').value != "")
					{
						sCadenaParams += "T"+iContador+"M" + document.getElementById('T'+iContador+'M').value;
						iCambios++;
					}
					if (document.getElementById('T'+iContador+'S').value != "")
					{
						sCadenaParams += "T"+iContador+"S" + document.getElementById('T'+iContador+'S').value;
						iCambios++;
					}
					if (document.getElementById('P'+iContador+'X').value != "")
					{
						sCadenaParams += "P"+iContador+"X" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('P'+iContador+'X').value,sTipoSensAux, document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, caVersionHW);
						iCambios++;
					}
					if (document.getElementById('P'+iContador+'N').value != "")
					{
						sCadenaParams += "P"+iContador+"N" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('P'+iContador+'N').value,sTipoSensAux, document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, caVersionHW);
						iCambios++;
					}
					iTSTemp = iObtener_TSGW_Select("TS"+iContador);
					if (iTSTemp !=-1)
					{
						sCadenaParams += "TS"+iContador+sTipoSensAux;
						iCambios++;
					}
				}
				if (document.getElementById('HPS').selectedIndex != -1)
				{
					sCadenaParams += "HPS"+document.getElementById('HPS').selectedIndex;
					iCambios++;
				}
				if (document.getElementById('MAXS1T').checked)
				{
					sCadenaParams += "S1X";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MAXS1O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}
					iCambios++;
				}
				if (document.getElementById('MINS1T').checked)
				{
					sCadenaParams += "S1N";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MINS1O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}					
					iCambios++;
				}
				if (document.getElementById('MAXS2T').checked)
				{
					sCadenaParams += "S2X";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MAXS2O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}
					iCambios++;
				}
				if (document.getElementById('MINS2T').checked)
				{
					sCadenaParams += "S2N";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MINS2O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}
					iCambios++;
				}
				if (document.getElementById('MAXS3T').checked)
				{
					sCadenaParams += "S3X";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MAXS3O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}
					iCambios++;
				}
				if (document.getElementById('MINS3T').checked)
				{
					sCadenaParams += "S3N";
					for (iContador = 1; iContador < 4; iContador++)
					{
						if (document.getElementById('MINS3O'+iContador).checked)
						{
							sCadenaParams += "1";
						}
						else
						{
							sCadenaParams += "0";
						}
					}
					iCambios++;
				}
<?php
		if ($iHabModbusTCP == 1)
		{
?>
					if (document.getElementById('MTP').selectedIndex != -1)
					{
						sCadenaParams += "MTP" + document.getElementById('MTP').selectedIndex;
						iCambios++;
					}
<?php
		}
		if ($iHabUTC == 1)
		{
?>					
					if (document.getElementById('ITP').value != "")
					{
						sCadenaParams += "ITP" + document.getElementById('ITP').value;
						iCambios++;
					}
<?php
		}
?>					
	
				if (document.getElementById('NGW').value != '')
				{
					sCadenaParamsNom = "N" + document.getElementById('SUS').value + "G";
					sCadenaParamsNom += document.getElementById('NGW').value + ";";
					iCambiosNom++;
				}
	
				if ((iCambios > 0) || (iCambiosNom > 0))
				{
					if (confirm(iObtener_Cadena_AJAX('gw_text3')+" \r\n"+iObtener_Cadena_AJAX('general0')))
					{
						$('#imagen_espera_modif').attr("class", 'mostrado');
						iModNombre = 0;
						iModParam = 0;
						if (caVersionSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
						{
							document.getElementById('boton_leer').disabled="true";
							document.getElementById('boton_enviar').disabled="true";
							document.getElementById('boton_limpiar').disabled="true";
							document.getElementById('boton_enviarDB').disabled="true";
							document.getElementById('boton_leerDB').disabled="true";
							if (iCambios > 0)
							{
								iModParam = 1;
								url = "gw_modificacion.php?";
								xmlHttpgrRead= GetXmlHttpObject();
								xmlHttpgrRead.open("POST",url,true);
								xmlHttpgrRead.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
								xmlHttpgrRead.onreadystatechange=function()
								{
									if (xmlHttpgrRead.readyState==4)
									{
										iModParam = 0;
										if (iModNombre == 0)
										{
											document.getElementById('boton_leer').disabled="";
											document.getElementById('boton_enviar').disabled="";
											document.getElementById('boton_limpiar').disabled="";
											document.getElementById('boton_enviarDB').disabled="";
											document.getElementById('boton_leerDB').disabled="";
											vGuarda_ParamsGW_Notificacion_DB();
											$('#imagen_espera_modif').attr("class", 'escondido');
											alert(xmlHttpgrRead.responseText);
										}
									}
								}
								xmlHttpgrRead.send("comando="+sCadenaParams);
							}
							if (iCambiosNom > 0)
							{
								iModNombre = 1;
								url = "gw_modificacion_nombre.php?comando="+sCadenaParamsNom;
								xmlHttpgrRead2= GetXmlHttpObject();
								xmlHttpgrRead2.open("GET",url,true);
								xmlHttpgrRead2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
								xmlHttpgrRead2.onreadystatechange=function()
								{
									if (xmlHttpgrRead2.readyState==4)
									{
										iModNombre = 0;
										if (iModParam == 0)
										{
											document.getElementById('boton_leer').disabled="";
											document.getElementById('boton_enviar').disabled="";
											document.getElementById('boton_limpiar').disabled="";
											document.getElementById('boton_enviarDB').disabled="";
											document.getElementById('boton_leerDB').disabled="";
											vGuarda_ParamsGW_Notificacion_DB();
											$('#imagen_espera_modif').attr("class", 'escondido');
											alert(xmlHttpgrRead2.responseText);
										}
									}
								}
								xmlHttpgrRead2.send(null);
							}
							
				
						}
						else
						{
							if (iCambios > 0)
							{
								url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
								xmlHttpgrRead= GetXmlHttpObject();
								xmlHttpgrRead.open("GET",url,false);
								xmlHttpgrRead.send(null);
							}
							if (iCambiosNom > 0)
							{
								url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+sCadenaParamsNom+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
								xmlHttpgrRead= GetXmlHttpObject();
								xmlHttpgrRead.open("GET",url,false);
								xmlHttpgrRead.send(null);
							}
							if ((xmlHttpgrRead.responseText!='OK'))
							{
								alert(xmlHttpgrRead.responseText);
							}
							else
							{
								alert(iObtener_Cadena_AJAX('general360'));
							}		
							vGuarda_ParamsGW_Notificacion_DB();
							$('#imagen_espera_modif').attr("class", 'escondido');
						}
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

		function Cargar_Params_GW_DB()
		{
			var url = "gw_lecturaDB.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value;
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
						Rellenar_Version_Gateway(xmlHttpgrRead);
						Rellenar_Todos_Tipos_Sensor_GW(caVersionHW, caVersionSW);
						Rellenar_Controles_Gateway(xmlHttpgrRead);
					}
				}
			}
			xmlHttpgrRead.send(null);
		}

		function Cargar_Params_GW_DB_notifica()
		{
			var url = "gw_lecturaDB_notifica.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+document.getElementById('gw_id').value;
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
		
		function OnLimpiarControles()
		{
			document.getElementById('NGW').value="";
			document.getElementById('KEY').value="";
			document.getElementById('DHP').selectedIndex=-1;
			document.getElementById('IPP').value="";
			document.getElementById('MSK').value="";
			document.getElementById('PDE').value="";
			document.getElementById('TPP').value="";
			document.getElementById('ITC').value="";
			document.getElementById('ITP').value="";
			document.getElementById('HPS').selectedIndex=-1;
			document.getElementById('TCH').selectedIndex=-1;
			document.getElementById('HMR').selectedIndex=-1;
			document.getElementById('IPX').value="";
			document.getElementById('IPY').value="";
			document.getElementById('PRX').value="";
			document.getElementById('PRY').value="";
			document.getElementById('PGT').value="";
			document.getElementById('PGU').value="";
			document.getElementById('GSH').selectedIndex=-1;
			document.getElementById('GSX').value="";
			document.getElementById('GSY').value="";
			document.getElementById('GPH').selectedIndex=-1;
			document.getElementById('IPZ').value="";
			document.getElementById('IPW').value="";
			document.getElementById('MTP').selectedIndex=-1;
			for (iContador = 1; iContador < 10; iContador++)
			{
				if (iContador < 4)
				{
					document.getElementById('MINS'+iContador+'T').checked=false;
					document.getElementById('MAXS'+iContador+'T').checked=false;
					switch (iContador)
					{
						case 3:
							OnClickMAXS3();
							OnClickMINS3();
							break;
						case 2:
							OnClickMAXS2();
							OnClickMINS2();
							break;
						case 1:
						default:
							OnClickMAXS1();
							OnClickMINS1();
							break;
					}
				}
				document.getElementById('TS'+iContador).selectedIndex=-1;
				document.getElementById('T'+iContador+'S').value="";
				document.getElementById('T'+iContador+'M').value="";
				document.getElementById('P'+iContador+'N').value="";
				document.getElementById('P'+iContador+'X').value="";
				document.getElementById('M'+iContador+'X').value="";
				document.getElementById('M'+iContador+'N').value="";
				document.getElementById('U'+iContador+'D').selectedIndex=-1;

				document.getElementById('EH'+iContador).selectedIndex=-1;
				document.getElementById('SH'+iContador).selectedIndex=-1;
				document.getElementById('SN'+iContador).value="";
			}

			for (var iIndex = 1; iIndex < 7; iIndex++)
			{
				document.getElementById('P'+iIndex+'X_unit').innerHTML="";
				document.getElementById('P'+iIndex+'N_unit').innerHTML="";
			} 
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
						case "S1X":
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MAXS1O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MAXS1T').checked = true;
										OnClickMAXS1();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
							
						case "S1N":
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MINS1O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MINS1T').checked = true;
										OnClickMINS1();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
						case "S2X":
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MAXS2O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MAXS2T').checked = true;
										OnClickMAXS2();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
						case "S2N":
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MINS2O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MINS2T').checked = true;
										OnClickMINS2();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
						case "S3X":
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MAXS3O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MAXS3T').checked = true;
										OnClickMAXS3();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
						case "S3N":	
							if (sValorParam.length==3)
							{
								for(iSubContador=0;iSubContador<3;iSubContador++)
								{
									sCadenaAux='MINS3O'+(iSubContador+1);
									if (sValorParam[iSubContador]=='1')
									{
										document.getElementById(sCadenaAux).checked=true;
										document.getElementById('MINS3T').checked = true;
										OnClickMINS3();
									}
									else
									{
										document.getElementById(sCadenaAux).checked=false;	
									}
								}
							}
							break;
						
						case "DHP":
						case "TCH":
						case "HPS":
						case "GPH":
						case "GSH":
						case "MTP":
						case "HMR":
							document.getElementById(sNombreParam).selectedIndex=sValorParam;
							break;

						case "TS1":
						case "TS2":
						case "TS3":
						case "TS4":
						case "TS5":
						case "TS6":
						case "TS7":
						case "TS8":
						case "TS9":
							iAsignar_TSGW_Select(sNombreParam,sValorParam);
							break;

						case "EH1":
						case "EH2":
						case "EH3":
						case "EH4":
						case "EH5":
						case "EH6":
						case "EH7":
						case "EH8":
						case "EH9":
						case "SH1":
						case "SH2":
						case "SH3":
						case "SH4":
						case "SH5":
						case "SH6":
						case "SH7":
						case "SH8":
						case "SH9":
							if (sValorParam=="0")
							{
								document.getElementById(sNombreParam).selectedIndex=0;
							}
							else
							{
								document.getElementById(sNombreParam).selectedIndex=1;
							}
							break;
						case "U1D":
						case "U2D":
						case "U3D":
						case "U4D":
						case "U5D":
						case "U6D":
						case "U7D":
						case "U8D":
						case "U9D":
							document.getElementById(sNombreParam).selectedIndex=sValorParam;
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
			for(iContador=1;iContador<10;iContador++)
			{
				vActualizar_Unidades(iContador);
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

		var xmlHttpgrReadGW;
		function OnLeerGW()
		{
			var caComando;
			var url;
			$('#imagen_espera').attr("class", 'mostrado');
			caComando = "L"+document.getElementById('gw_id').value;
			if (caVersionSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
			{
				OnLimpiarControles();
				url = "gw_lectura.php?comando="+caComando;
				xmlHttpgrReadGW= GetXmlHttpObject();
				xmlHttpgrReadGW.open("GET",url,true);
				xmlHttpgrReadGW.onreadystatechange=function()
				{
					if (xmlHttpgrReadGW.readyState==4)
					{
						$('#imagen_espera').attr("class", 'escondido');
						document.getElementById('boton_leer').disabled="";
						document.getElementById('boton_enviar').disabled="";
						document.getElementById('boton_limpiar').disabled="";
						document.getElementById('boton_enviarDB').disabled="";
						document.getElementById('boton_leerDB').disabled="";
						if ((xmlHttpgrReadGW.responseText=='ERROR')||(xmlHttpgrReadGW.responseText=='Timeout'))
						{
							alert(xmlHttpgrReadGW.responseText);
						}
						else
						{
							Rellenar_Controles_Gateway(xmlHttpgrReadGW);
							Cargar_Params_GW_DB_notifica();
						}
					}
				}
				document.getElementById('boton_leer').disabled="true";
				document.getElementById('boton_enviar').disabled="true";
				document.getElementById('boton_limpiar').disabled="true";
				document.getElementById('boton_enviarDB').disabled="true";
				document.getElementById('boton_leerDB').disabled="true";
				xmlHttpgrReadGW.send(null);				
			}
			else
			{
				url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+caComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("GET",url,false);
				xmlHttpgrRead.send(null);
				caComando = "P"+document.getElementById('gw_id').value;
				url = "enviar_comando_offline.php?gw_id="+document.getElementById('gw_id').value+"&nodo_ip=000&comando="+caComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("GET",url,false);
				xmlHttpgrRead.send(null);
				$('#imagen_espera').attr("class", 'escondido');
				alert(iObtener_Cadena_AJAX('general361'));
			}
		}
		function GuardarDB()
		{
			var sCadenaParams;
			var url;
			var sValores;
			var xmlHttpDB;

			if (iComprobar_Todos_Valores() == 0)
			{
				sCadenaParams = sPrepararCadenaGW(document.getElementById('SUS').value, caVersionHW);
				if (confirm(iObtener_Cadena_AJAX('general189')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					$('#imagen_espera_modDB').attr("class", 'mostrado');
					url = "gw_modificacionDB.php";
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
	</script>
</head>

<body>
<?php
	$iVersiones = 0;
	include 'estructura_conf_gw.php';
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
				<img id="imagen_espera_modDB" src="images/wait_circle.gif" class="escondido"/>			
				<input type="button" onclick="GuardarDB()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general196']?>" class="boton_fino_medio" id="boton_enviarDB"/>
			</td>
			<td style="width:33%" align="right">
				<input type="button" onclick="Guardar()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general197']?>" class="boton_fino_largo" id="boton_enviar"/>
				<img id="imagen_espera_modif" src="images/wait_circle.gif" class="escondido"/>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		sRellenar_CombosYN(vRellenar_Combos_YN_GW);
		Rellenar_Todas_Uds_Sensor_GW();
		Cargar_Params_GW_DB();	
	</script>
</body>
</html>
