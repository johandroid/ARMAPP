<?php session_start(); //continuamos session o la creamos si no hay
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
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function Rellenar_Actuacion_GW(sParametrosGW)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;

			sPrincipal=parsear_xml(sParametrosGW.responseText);
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
			}
		}

		var xmlHttpgrActGW;
		function OnActuandoGW()
		{	
			var alta_offline;
			var sSalidaGW = '';
			var sSendGW = '';
			$('#imagen_espera').attr("class", 'mostrado');
			for (iContador = 1; iContador < 4; iContador++)
			{
				if (document.getElementById('show_s'+iContador).selectedIndex == 1)
				{
					sSalidaGW += "1";
				}
				else
				{
					sSalidaGW += "0";
				}
			}
			for (iContador = 1; iContador < 4; iContador++)
			{
				if (document.getElementById('send_s'+iContador).checked)
				{
					sSendGW += "1";
				}
				else
				{
					sSendGW += "0";
				}
			}
			
			document.getElementById('send_s1').disabled="disabled";
			document.getElementById('send_s2').disabled="disabled";
			document.getElementById('send_s3').disabled="disabled";
			document.getElementById('show_s1').disabled="disabled";
			document.getElementById('show_s2').disabled="disabled";
			document.getElementById('show_s3').disabled="disabled";
			
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>))
			{
				alta_offline = 0;
			}
			else
			{
				alta_offline = 1;
			}
			
			var url = "gw_actuacion.php?gw_id="+document.getElementById('gw_id').value+"&gw_out="+sSalidaGW+"&gw_send="+sSendGW+"&offline="+alta_offline;
			xmlHttpgrActGW= GetXmlHttpObject();
			xmlHttpgrActGW.open("GET",url,true);

			xmlHttpgrActGW.onreadystatechange=function()
			{
				if (xmlHttpgrActGW.readyState==4)
				{
					if ((xmlHttpgrActGW.responseText=='ERROR') || (xmlHttpgrActGW.responseText=='Timeout'))
					{
						alert(xmlHttpgrActGW.responseText);
					}
					else
					{
						document.getElementById('send_s1').checked=false;
						document.getElementById('send_s2').checked=false;
						document.getElementById('send_s3').checked=false;
						Rellenar_Actuacion_GW(xmlHttpgrActGW);
						if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>))
						{
							alert(iObtener_Cadena_AJAX('general27'));
						}
						else
						{
							alert(iObtener_Cadena_AJAX('general366'));
						}						
					}					
					document.getElementById('send_s1').disabled="";
					document.getElementById('send_s2').disabled="";
					document.getElementById('send_s3').disabled="";
					document.getElementById('show_s1').disabled="";
					document.getElementById('show_s2').disabled="";
					document.getElementById('show_s3').disabled="";
					$('#imagen_espera').attr("class", 'escondido');
				}				
			}
			xmlHttpgrActGW.send(null);			
		}
	</script>
</head>

<body>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center" colspan="3"><br/></td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td  align="center" colspan="3">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['gw_text1']." ".$id_gateway?></span>
			</td>
		</tr>
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center" colspan="3">
				<table border="0" width="98%" cellpadding="0" cellspacing="0">
					<tr>					
						<td style="width:5%"></td>	
						<td style="width:45%"><br/></td>								
						<td style="width:45%" align="right">
							<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $_GET['objeto_id']?>"/>
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
							</table>
						</div>
				</div>
			</td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td  align="center" colspan="3"><br/></td>
		</tr>
		<tr>	
			<td style="width:5%"></td>				
			<td style="width:90%" align="center">
				<input type="button" name="Actualizar_Param" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" class="boton_fino_medio" id="boton_update" onclick="OnActuandoGW()"/>
				<img id="imagen_espera" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:5%"></td>
		</tr>
	</table>
	<script type="text/javascript">
		vCargar_Versiones_GW_DB(top.document.getElementById("comboGateways").options[top.document.getElementById("comboGateways").selectedIndex].id);
	</script>
</body>
</html>