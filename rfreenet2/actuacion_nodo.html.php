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
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		var iHab = new Array(6);
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function Rellenar_Actuacion_Nodo(sParametrosNodo)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;

			sPrincipal=parsear_xml(sParametrosNodo.responseText);
			if (sPrincipal != null)
			{
				sListaNombres=sPrincipal.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipal.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					sValorParam=sListaValores[iContador].childNodes[0].nodeValue;

					switch (sNombreParam.substring(0,2))
					{
						case "OU":
							
							if (sValorParam==1)
							{
								document.getElementById('show_s'+sNombreParam.substring(2)).selectedIndex = 1;
							}
							else
							{
								document.getElementById('show_s'+sNombreParam.substring(2)).selectedIndex = 0;	
							}
							break;
							
						default:
							break;						
					}
				}
				for (iContador = 1; iContador < 7; iContador++)
				{
					if (iHab[iContador-1] == 0)
					{
						document.getElementById('show_s'+iContador).disabled="";
						document.getElementById('send_s'+iContador).disabled="";
					}
					else
					{
						document.getElementById('show_s'+iContador).disabled="disabled";
						document.getElementById('send_s'+iContador).disabled="disabled";
					}
				}
			}
		}

		var xmlHttpgrActNodo;
		function OnActuandoNodo()
		{
			var alta_offline;
			var iContador;
			var sSalidaNodo = '';
			var sSendNodo = '';
			$('#imagen_espera').attr("class", 'mostrado');
			for (iContador = 1; iContador < 7; iContador++)
			{
				if (document.getElementById('show_s'+iContador).selectedIndex == 1)
				{
					sSalidaNodo += "1";
				}
				else
				{
					sSalidaNodo += "0";
				}
			}
			for (iContador = 1; iContador < 7; iContador++)
			{
				if (document.getElementById('send_s'+iContador).checked)
				{
					sSendNodo += "1";
				}
				else
				{
					sSendNodo += "0";
				}
			}
			for (iContador = 1; iContador < 7; iContador++)
			{
				if (document.getElementById('show_s'+iContador).disabled == "")
				{
					iHab[iContador-1]=0;
				}
				else
				{
					iHab[iContador-1]=1;
				}
			}
			
			document.getElementById('send_s1').disabled="disabled";
			document.getElementById('send_s2').disabled="disabled";
			document.getElementById('send_s3').disabled="disabled";
			document.getElementById('send_s4').disabled="disabled";
			document.getElementById('send_s5').disabled="disabled";
			document.getElementById('send_s6').disabled="disabled";
			document.getElementById('show_s1').disabled="disabled";
			document.getElementById('show_s2').disabled="disabled";
			document.getElementById('show_s3').disabled="disabled";
			document.getElementById('show_s4').disabled="disabled";
			document.getElementById('show_s5').disabled="disabled";
			document.getElementById('show_s6').disabled="disabled";
			
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>))
			{
				alta_offline = 0;
			}
			else
			{
				alta_offline = 1;
			}
			
			var url = "nodo_actuacion.php?gw_id="+document.getElementById('gw_id').value+"&nodo_out="+sSalidaNodo+"&nodo_send="+sSendNodo+"&nodo_ip="+document.getElementById('nodo_ip').value+"&offline="+alta_offline;
			xmlHttpgrActNodo= GetXmlHttpObject();
			xmlHttpgrActNodo.open("GET",url,true);

			xmlHttpgrActNodo.onreadystatechange=function()
			{
				if (xmlHttpgrActNodo.readyState==4)
				{
					if ((xmlHttpgrActNodo.responseText=='ERROR') || (xmlHttpgrActNodo.responseText=='Timeout'))
					{
						alert(xmlHttpgrActNodo.responseText);
						document.getElementById('send_s1').disabled="";
						document.getElementById('send_s2').disabled="";
						document.getElementById('send_s3').disabled="";
						document.getElementById('send_s4').disabled="";
						document.getElementById('send_s5').disabled="";
						document.getElementById('send_s6').disabled="";
						document.getElementById('show_s1').disabled="";
						document.getElementById('show_s2').disabled="";
						document.getElementById('show_s3').disabled="";
						document.getElementById('show_s4').disabled="";
						document.getElementById('show_s5').disabled="";
						document.getElementById('show_s6').disabled="";
						OnDBUpdateSensores();
					}
					else
					{
						document.getElementById('send_s1').checked=false;
						document.getElementById('send_s2').checked=false;
						document.getElementById('send_s3').checked=false;
						document.getElementById('send_s4').checked=false;
						document.getElementById('send_s5').checked=false;
						document.getElementById('send_s6').checked=false;
						Rellenar_Actuacion_Nodo(xmlHttpgrActNodo);
						if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>))
						{
							alert(iObtener_Cadena_AJAX('general27'));
						}
						else
						{
							alert(iObtener_Cadena_AJAX('general366'));
						}
					}					
					$('#imagen_espera').attr("class", 'escondido');
				}				
			}
			xmlHttpgrActNodo.send(null);	
		}

		function Rellenar_Salidas_Nodo(sParametrosNodo)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var iSubContador;
			var sParcial;
			var sTotal;
			var iSensorAct;
			var iTSN = new Array(6);
			var iaSEN = new Array(6);

			for(iContador=0;iContador<6;iContador++)
			{
				iTSN[iContador]=0;
			}

			sPrincipal=parsear_xml(sParametrosNodo.responseText);
			if (sPrincipal != null)
			{
				sListaNombres=sPrincipal.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipal.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
									
					if (sNombreParam.length==3)
					{
						if (sNombreParam=='SEN')
						{
							sTotal = sValorParam;
							for(iSubContador=1;iSubContador<7;iSubContador++)
							{
								sParcial = sTotal%Math.pow(2,iSubContador);
								if (sParcial > 0)
								{
									iaSEN[iSubContador-1] = '1';
								}
								else
								{
									iaSEN[iSubContador-1] = '0';
								}
								sTotal -= sParcial;
							}
							caVGWHW = sValorParam;
						}						
						else if ((sNombreParam.charAt(0)=='T') && (sNombreParam.charAt(1)=='S'))
						{
							iSensorAct = sNombreParam.charAt(2);
							iTSN[iSensorAct-1]=1;
							if (iaSEN[iSensorAct-1] == '1')
							{
								document.getElementById('send_s'+iSensorAct).checked=false;
								//document.getElementById('show_s'+iSensorAct).selectedIndex=0;
								if (sValorParam.charAt(0)=='5')
								{
									document.getElementById('send_s'+iSensorAct).disabled="";
									document.getElementById('show_s'+iSensorAct).disabled="";
								}
								else
								{
									document.getElementById('send_s'+iSensorAct).disabled="disabled";
									document.getElementById('show_s'+iSensorAct).disabled="disabled";
								}
							}
							else
							{
								document.getElementById('send_s'+iSensorAct).disabled="disabled";
								document.getElementById('show_s'+iSensorAct).disabled="disabled";
							}
						}					
					}
				}
			}
			for(iContador=1;iContador<7;iContador++)
			{
				if (iTSN[iContador-1] == 0)
				{
					document.getElementById('send_s'+iContador).checked=false;
					document.getElementById('show_s'+iContador).selectedIndex=0;
					document.getElementById('send_s'+iContador).disabled="disabled";
					document.getElementById('show_s'+iContador).disabled="disabled";
				}
			}
		}

		function OnDBUpdateSensores()
		{
			var sSalidaGW = '';
			var sSendGW = '';
			
			document.getElementById('send_s1').disabled="disabled";
			document.getElementById('send_s2').disabled="disabled";
			document.getElementById('send_s3').disabled="disabled";
			document.getElementById('send_s4').disabled="disabled";
			document.getElementById('send_s5').disabled="disabled";
			document.getElementById('send_s6').disabled="disabled";
			document.getElementById('show_s1').disabled="disabled";
			document.getElementById('show_s2').disabled="disabled";
			document.getElementById('show_s3').disabled="disabled";
			document.getElementById('show_s4').disabled="disabled";
			document.getElementById('show_s5').disabled="disabled";
			document.getElementById('show_s6').disabled="disabled";
			
			var url = "nodo_lecturaDB_param.php?gw_id="+document.getElementById('gw_id').value+"&nodo_mac="+document.getElementById('nodo_mac').value+"&cliente_db=<?php echo $_SESSION['cliente_db'];?>";
			//alert(url);
			xmlHttpgrActNodo= GetXmlHttpObject();
			xmlHttpgrActNodo.open("GET",url,true);

			xmlHttpgrActNodo.onreadystatechange=function()
			{
				if (xmlHttpgrActNodo.readyState==4)
				{
					if ((xmlHttpgrActNodo.responseText=='ERROR') || (xmlHttpgrActNodo.responseText=='Timeout'))
					{
						document.getElementById('send_s1').disabled="";
						document.getElementById('send_s2').disabled="";
						document.getElementById('send_s3').disabled="";
						document.getElementById('send_s4').disabled="";
						document.getElementById('send_s5').disabled="";
						document.getElementById('send_s6').disabled="";
						document.getElementById('show_s1').disabled="";
						document.getElementById('show_s2').disabled="";
						document.getElementById('show_s3').disabled="";
						document.getElementById('show_s4').disabled="";
						document.getElementById('show_s5').disabled="";
						document.getElementById('show_s6').disabled="";
					}
					else
					{
						document.getElementById('send_s1').checked=false;
						document.getElementById('send_s2').checked=false;
						document.getElementById('send_s3').checked=false;
						document.getElementById('send_s4').checked=false;
						document.getElementById('send_s5').checked=false;
						document.getElementById('send_s6').checked=false;
						Rellenar_Salidas_Nodo(xmlHttpgrActNodo);
					}					
				}				
			}
			xmlHttpgrActNodo.send(null);	
		}
	</script>
</head>

<body onload="OnDBUpdateSensores()">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center" colspan="3"><br/></td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td  align="center" colspan="3">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['nodo_text1']." ".$_GET['objeto_id']?></span>
			</td>
		</tr>
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center" colspan="3">
				<table border="0" width="98%" cellpadding="0" cellspacing="0">
					<tr>					
						<td style="width:5%"></td>	
						<td style="width:45%"><br/></td>								
						<td style="width:45%" align="right">
							<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $_GET['gw_id']?>"/>
							<input type="hidden" id="nodo_ip" name="nodo_ip" value="<?php echo $_GET['objeto_ip']?>"/>
							<input type="hidden" id="nodo_mac" name="nodo_mac" value="<?php echo $_GET['objeto_id']?>"/>
						</td>
						<td style="width:5%"></td>						
					</tr>
				</table>
				<div class="rounded-big-box">
					    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
					    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
					    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
					    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
						<div class="box-contents">
							<table border="0" cellspacing="0" width="60%">
								<tr>
									<td class="bottom_tborder"></td>
									<td align="center" class="left_tborder top_tborder bottom_tborder">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general54']?></span>
									</td>
									<td align="center" class="right_tborder top_tborder bottom_tborder">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general23']?></span>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 1</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s1" id="send_s1" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s1" id="show_s1" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 2</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s2" id="send_s2" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s2" id="show_s2" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 3</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s3" id="send_s3" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s3" id="show_s3" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 4</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s4" id="send_s4" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s4" id="show_s4" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 5</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s5" id="send_s5" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s5" id="show_s5" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="left_tborder bottom_tborder" align="center">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24']?> 6</span>
									</td>
									<td class="bottom_tborder left_tborder" align="center">														
										<input type="checkbox" name="send_s6" id="send_s6" style="width:20px;text-align:center"/>
									</td>
									<td class="right_tborder bottom_tborder" align="center">
										<select name="show_s6" id="show_s6" style="width:120px;text-align:center" class="texto_valores">
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general25']?></option>
											<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['general26']?></option>
										</select>
									</td>
								</tr>
							</table>
						</div>
				</div>
			</td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td style="width:5%"></td>
			<td  align="right" style="width:90%"></td>
			<td style="width:5%"></td>
		</tr>
		<tr>	
			<td style="width:5%"></td>				
			<td style="width:90%" align="center">
				<input type="button" name="Actualizar_Param" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" class="boton_fino_medio" id="boton_update" onclick="OnActuandoNodo()"/>
				<img id="imagen_espera" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:5%"></td>
		</tr>
	</table>
	<script type="text/javascript">
		vCargar_Versiones_GW_DB(top.document.getElementById("comboNodos").options[top.document.getElementById("comboNodos").selectedIndex].value.substring(3));
	</script>
</body>
</html>