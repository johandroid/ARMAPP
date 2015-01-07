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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_submenu.js?time=<?php echo(filemtime("js/funciones_submenu.js"));?>"></script>
	<script type="text/javascript">
		var tabbar;
		var caET;
		var iET;
		var iaHab = new Array(3);
		var saAlias = new Array(3);
		var saGW = new Array(3);
		//var iHora = new Array(3);
		var iaAltMar = new Array(3);
		var iaAltZ = new Array(3);
		var iaCoefCul = new Array(3);
		var iaLat = new Array(3);
		function OnLimpiarControlesET()
		{
			caET = 'a1';
		    iET = iAsignar_Tab(caET);
			tabbar.setTabActive("a1");
			for (var iIndice = 0; iIndice < 3; iIndice++)
			{
				iaHab[iET] = -1;
				saAlias[iET] = "";
				saGW[iET] = -1;
				//iHora[iET] = -1;
				iaAltMar[iET] = 0;
				iaAltZ[iET] = 0;
				iaCoefCul[iET] = 0;
				iaLat[iET] = 0;
			}
			document.getElementById('calculo_enable').selectedIndex = -1;
			document.getElementById('calculo_alias').value = "";
			document.getElementById('calculo_gw').selectedIndex = -1;
			document.getElementById('calculo_alturamar').value = 0;
			document.getElementById('calculo_alturaz').value = 0;
			document.getElementById('calculo_coefcultivo').value = 0;
			document.getElementById('calculo_latitud').value = 0;
		}
		function vActualizar_procesado()
		{
			if (vActualizar_Datos_ET())
			{
				vGuardar_Datos_ET();
			}
		}
		function vGuardar_Datos_ET()
		{
			var url = "modifica_procesado.php?cliente_db="+top.document.getElementById("db_cliente").value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
			var datos = vSerializar_Parametros_ET();
			url+= datos;
			xmlHttpgrReadNode= GetXmlHttpObject();
			xmlHttpgrReadNode.open("GET",url,true);
			xmlHttpgrReadNode.onreadystatechange=function()
			{
				if (xmlHttpgrReadNode.readyState==4)
				{
					if ((xmlHttpgrReadNode.responseText.substr(0,5)=='ERROR'))
					{
						alert(xmlHttpgrReadNode.responseText);
					}
					else
					{
						alert(iObtener_Cadena_AJAX('general22'));		
					}	
				}
			}
			xmlHttpgrReadNode.send(null);
			
		}
		function vSerializar_Parametros_ET()
		{
			var datos = "";
			for(iContador = 0; iContador < 3 ; iContador++)
			{
				datos += '&calculo_enable'+(iContador+1)+ "=" + iaHab[iContador];
				datos += '&calculo_alias'+(iContador+1)+ "=" + saAlias[iContador];
				if(saGW[iContador] != -1)
					datos += '&calculo_gw'+(iContador+1)+ "=" + saGW[iContador];
				else
					datos += '&calculo_gw'+(iContador+1)+ "=0000";
				datos += '&calculo_alturamar'+(iContador+1)+ "=" + iaAltMar[iContador];
				datos += '&calculo_alturaz'+(iContador+1)+ "=" +iaAltZ[iContador];
				datos += '&calculo_coefcultivo'+(iContador+1)+ "=" + iaCoefCul[iContador];
				datos += '&calculo_latitud'+(iContador+1)+ "=" + iaLat[iContador];
			}
			return datos;
		}
		function vRellenar_Valores_ET()
		{
			document.getElementById('calculo_enable').selectedIndex = iaHab[iET];
			document.getElementById('calculo_alias').value = saAlias[iET];
			document.getElementById("calculo_gw").selectedIndex = -1;	
			for (var iIndice=0; iIndice < document.getElementById("calculo_gw").length; iIndice++)
			{								
				if (document.getElementById("calculo_gw").options[iIndice].id == saGW[iET])
				{
					document.getElementById("calculo_gw").selectedIndex=iIndice;
				}
			}
			document.getElementById('calculo_alturamar').value = iaAltMar[iET];
			document.getElementById('calculo_alturaz').value = iaAltZ[iET];
			document.getElementById('calculo_coefcultivo').value = iaCoefCul[iET];
			document.getElementById('calculo_latitud').value = iaLat[iET];
		}
		function vActualizar_Datos_ET()
		{
			if(document.getElementById('calculo_enable').selectedIndex > 0)
			{
				if(document.getElementById('calculo_gw').selectedIndex < 0 || document.getElementById('calculo_gw').selectedIndex>document.getElementById("calculo_gw").length)
				{
					alert(iObtener_Cadena_AJAX('error_et9'));
					return false;
				}
				
				if (document.getElementById("calculo_alias").value.length == 0)
				{
					alert(iObtener_Cadena_AJAX('error_et1'));
					return false;
				}
			}
			if (iComprobar_Decimal(document.getElementById("calculo_alturamar").value,6) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_et2'));
				return false;
			}
			if (iComprobar_Decimal(document.getElementById("calculo_alturaz").value,6) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_et3'));
				return false;
			}
			if (iComprobar_Decimal(document.getElementById("calculo_coefcultivo").value,6) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_et4'));
				return false;
			}
			if (iComprobar_Decimal(document.getElementById("calculo_latitud").value,20) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_et7'));
				return false;
			}
			
			iaHab[iET] = document.getElementById('calculo_enable').selectedIndex;
			saAlias[iET] = document.getElementById('calculo_alias').value;
			if(document.getElementById('calculo_gw').selectedIndex>=0)
			{
				saGW[iET] = document.getElementById('calculo_gw').options[document.getElementById('calculo_gw').selectedIndex].id;
			}
			else
			{
				saGW[iET] = -1;
			}
			iaAltMar[iET] = document.getElementById('calculo_alturamar').value;
			iaAltZ[iET] = document.getElementById('calculo_alturaz').value;
			iaCoefCul[iET] = document.getElementById('calculo_coefcultivo').value;
			iaLat[iET] = document.getElementById('calculo_latitud').value;
			return true;
		}
		
		function Parsear_Trama_ET(xml)
		{
			var xmlrespuesta = parsear_xml(xml);
			sPrincipalNode=xmlrespuesta.getElementsByTagName("evapotranspiracion");
			if (sPrincipalNode != null)
			{
				
				sNodoHijo = sPrincipalNode[0].firstChild;
				if(sNodoHijo.childNodes.length > 0)
					iaHab[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaHab[0] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saAlias[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					saAlias[0] = "";
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saGW[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					saGW[0] = -1;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltMar[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltMar[0] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltZ[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltZ[0] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaCoefCul[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaCoefCul[0] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaLat[0] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaLat[0] = 0;
					
				sNodoHijo = sNodoHijo.nextSibling;
				
				if(sNodoHijo.childNodes.length > 0)
					iaHab[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaHab[1] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saAlias[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					saAlias[1] = "";
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saGW[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					saGW[1] = -1;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltMar[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltMar[1] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltZ[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltZ[1] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaCoefCul[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaCoefCul[1] = 0;
				
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaLat[1] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaLat[1] = 0;
					
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaHab[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaHab[2] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saAlias[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					saAlias[2] = "";
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					saGW[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					saGW[2] = -1;
				
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltMar[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltMar[2] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaAltZ[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaAltZ[2] = 0;
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaCoefCul[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaCoefCul[2] = 0;
				
				sNodoHijo = sNodoHijo.nextSibling;
				if(sNodoHijo.childNodes.length > 0)
					iaLat[2] = sNodoHijo.childNodes[0].nodeValue;
				else
					iaLat[2] = 0;
			}
		}
		function iAsignar_Tab(sNombreTab)
		{
			switch (sNombreTab)
			{
				case 'a2':
					return 1;
				case 'a3':
					return 2;	
				case 'a1':
				default:
					return 0;  
			}
		}		
		function OnTabETChange(data)
		{
			if (!vActualizar_Datos_ET())
				return false;
			caET = data[0];
		    iET = iAsignar_Tab(caET); 
		    vRellenar_Valores_ET();
		    return true;
		}
		
		function vCargar_Parametros_ET(inst)
		{
			var url = "carga_procesado.php?cliente_db="+top.document.getElementById("db_cliente").value+"&instalacion_id="+inst;
			//OnLimpiarControlesNodo();
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
						Parsear_Trama_ET(xmlHttpgrReadNode.responseText);						
						vRellenar_Valores_ET();
					}	
				}
			}
			xmlHttpgrReadNode.send(null);
		}
		
		function vComprobar_Gw()
		{
			var url = "comprueba_gw_estacion.php?cliente_db="+top.document.getElementById("db_cliente").value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+document.getElementById('calculo_gw').options[document.getElementById('calculo_gw').selectedIndex].id;
			xmlHttpgrReadNode= GetXmlHttpObject();
			xmlHttpgrReadNode.open("GET",url,false);
			xmlHttpgrReadNode.send(null);
			if ((xmlHttpgrReadNode.responseText=='NO'))
			{
				alert(iObtener_Cadena_AJAX('error_et9'));
				document.getElementById('calculo_gw').selectedIndex = -1;
				
			}
			else
			{
				vCargar_Coordenadas_GW();
			}	
			
			
		}
		function vCargar_Coordenadas_GW()
		{
			var url = "carga_coordenadas_gw.php?cliente_db="+top.document.getElementById("db_cliente").value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+document.getElementById('calculo_gw').options[document.getElementById('calculo_gw').selectedIndex].id;
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
						document.getElementById('calculo_latitud').value = xmlHttpgrReadNode.responseText;
					}	
				}
			}
			xmlHttpgrReadNode.send(null);	
		}
	</script>
</head>

<body>
<form method="post">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr style="height:20px">
			<td></td>
		</tr>
		<tr>
			<td align="center">
				<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general251']?></span>
			</td>
		</tr>
		<tr>
			<td align="center">
				<div class="rounded-big-box" style="width:75%">
				    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
				    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
				    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
				    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
					<div class="box-contents">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="5">
									<div id="a_tabbar" style="width:570px; height:20px;"/>
									<div id='html_1'></div>
									<div id='html_2'></div>
									<div id='html_3'></div>
									<script>
										tabbar = new dhtmlXTabBar("a_tabbar", "top");
										tabbar.setSkin('dark_blue');
										tabbar.setImagePath("codebase/imgs/");
										tabbar.addTab("a1", iObtener_Cadena_AJAX('general252')+" 1", "180px");
										tabbar.addTab("a2", iObtener_Cadena_AJAX('general252')+" 2", "180px");
										tabbar.addTab("a3", iObtener_Cadena_AJAX('general252')+" 3", "180px");
										tabbar.setContent("a1", "html_1");
										tabbar.setContent("a2", "html_2");
										tabbar.setContent("a3", "html_3");
										tabbar.setTabActive("a1");
										tabbar.attachEvent("onSelect", function() {
											return OnTabETChange(arguments);
										});
									</script>
								</td>
							</tr>
							<tr>
								<td colspan="5"><br/></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param54']?></span>
								</td>
								<td colspan="2" align="center">
									<select name="calculo_enable" id="calculo_enable" style="width:50px;text-align:center" class="texto_valores">
										<option id='enable_no' name='enable_no'><?php echo $idiomas[$_SESSION['opcion_idioma']]['general_no']?></option>
										<option id='enable_si' name='enable_si'><?php echo $idiomas[$_SESSION['opcion_idioma']]['general_si']?></option>
									</select>
								</td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param55']?></span>
								</td>
								<td colspan="2" align="center">
									<input type="text" name="calculo_alias" id="calculo_alias" style="width:160px;text-align:center" class="texto_valores" maxlength="20"/>
								</td>							
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20']?></span>
								</td>
								<td colspan="2" align="center">
									<select name="calculo_gw" id="calculo_gw" style="width:160px;text-align:center" class="texto_valores" onchange="vComprobar_Gw()"/>
								</td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param57']?></span>
								</td>
								<td style="width:25%" align="right">
									<input type="text" name="calculo_alturamar" id="calculo_alturamar" style="width:60px;text-align:center" class="texto_valores" maxlength="4"/>
								</td>
								<td style="width:10%">
									&nbsp;<span class="texto_parametros">m</span>
								</td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param58']?></span>
								</td>
								<td style="width:25%" align="right">
									<input type="text" name="calculo_alturaz" id="calculo_alturaz" style="width:60px;text-align:center" class="texto_valores" maxlength="4"/>
								</td>
								<td style="width:10%">
									&nbsp;<span class="texto_parametros">m</span>
								</td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param59']?></span>
								</td>
								<td align="right">
									<input type="text" name="calculo_coefcultivo" id="calculo_coefcultivo" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
								</td>
								<td></td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
							<tr style="width:100%">
								<td style="width:10%"></td>
								<td style="width:45%" align="center">
									<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param62']?></span>
								</td>
								<td style="width:25%" align="right">
									<input type="text" name="calculo_latitud" id="calculo_latitud" style="width:60px;text-align:center" class="texto_valores" maxlength="15" disabled="disabled"/>
								</td>
								<td style="width:10%">
									&nbsp;<span class="texto_parametros">º</span>
								</td>
								<td style="width:10%"></td>
							</tr>
							<tr style="width:100%;height:5px;">
								<td colspan="5"></td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<table border="0" style="width:100%">
		<tr style="width:100%">
			<td colspan="5"><br/></td>
		</tr>
		<tr style="width:100%">
			<td style="width:10%"><br/></td>
			<td style="width:25%"></td>
			<td style="width:30%"><br/></td>
			<td style="width:25%" align="center">
				<input type="button" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" id="boton_upload" onclick="return vActualizar_procesado();" class="boton_fino"/>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	cargar_all_gateways('calculo_gw',top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
	OnLimpiarControlesET();
	vCargar_Parametros_ET(top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
</script>
</body>
</html>