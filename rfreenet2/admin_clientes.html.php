<?php session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_indice.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_submenu_admin.js?time=<?php echo(filemtime("js/funciones_submenu_admin.js"));?>"></script>
	<script type="text/javascript">
		function vCargar_Cliente()
		{			
			var sPrincipalNode;
			var sListaValores;
			var sListaNombres;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var xmlHttpParam;
			
			xmlHttpParam= GetXmlHttpObject();
			if (top.document.getElementById("comboClientes").selectedIndex != -1)
			{
				var url = "carga_datos_cliente.php?cliente_id="+top.document.getElementById("comboClientes").options[top.document.getElementById("comboClientes").selectedIndex].id;
				xmlHttpParam.onreadystatechange=function()
				{
					if (xmlHttpParam.readyState==4)
					{
						sPrincipalNode=parsear_xml(xmlHttpParam.responseText);
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
								if(sNombreParam.indexOf('cliente_notificacion')!=-1)
								{
									if(sValorParam==1)
									{
										sChecked = true;
									}
									else
									{
										sChecked = false;
									}
									switch(sNombreParam)
									{
										case 'cliente_notificacion_gwoff':
											document.getElementById('016').checked = sChecked;
											break;
										case 'cliente_notificacion_utroff':
											document.getElementById('006').checked = sChecked;
											break;	
										case 'cliente_notificacion_utcoff':
											document.getElementById('020').checked = sChecked;
											break;	
										case 'cliente_notificacion_gwbat':
											document.getElementById('008').checked = sChecked;
											break;		
										case 'cliente_notificacion_utrbat':
											document.getElementById('009').checked = sChecked;
											break;		
										case 'cliente_notificacion_utrcob':
											document.getElementById('007').checked = sChecked;
											break;	
													
									}
								}
								else if(sNombreParam.indexOf('_on')!=-1)
								{
									if(sValorParam==1)
									{
										sChecked = true;
									}
									else
									{
										sChecked = false;
									}
									
									document.getElementById(sNombreParam).checked = sChecked;
								}
								else if(sNombreParam.indexOf('_idioma')!=-1)
								{
									vSeleccionar_Idioma_Combo(sNombreParam, sValorParam);
								}
								else
								{
									document.getElementById(sNombreParam).value=sValorParam;
								}
							}
						}
					}
				}
				xmlHttpParam.open("GET",url,true);
				xmlHttpParam.send(null);
			}
		}
		function vBorrar_Cliente()
		{
			var url;
			var xmlHttpuser;
			if (top.document.getElementById("comboClientes").selectedIndex != -1)
			{
				if (confirm(iObtener_Cadena_AJAX('client_text2')+" "+top.document.getElementById("comboClientes").options[top.document.getElementById("comboClientes").selectedIndex].innerHTML + "\r\n "+iObtener_Cadena_AJAX('general0')))
				{
					if (confirm(iObtener_Cadena_AJAX('client_text3')+" \r\n "+iObtener_Cadena_AJAX('general0')))
					{
						xmlHttpuser= GetXmlHttpObject();
						url = "cliente_elimina.php?cliente_id=" + top.document.getElementById("comboClientes").options[top.document.getElementById("comboClientes").selectedIndex].id;
						xmlHttpuser.onreadystatechange=function()
						{
							if (xmlHttpuser.readyState==4)
							{
								alert(xmlHttpuser.responseText);
								window.parent.rellenar_div_submenu(52,"");
								window.parent.cargar_clientes(52);
							}
						}
						xmlHttpuser.open("GET",url,true);
						xmlHttpuser.send(null);
					}					
				}
			}
		}
		function vModificar_Cliente()
		{
			window.parent.rellenar_div_principal(60,"&cliente_id=" + top.document.getElementById("comboClientes").options[top.document.getElementById("comboClientes").selectedIndex].id);
			window.parent.rellenar_div_submenu(99,"");
		}
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general58']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-big-box">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:8%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general39']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general330']?> 1</span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_nombre" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_telefono" style="width:150px;text-align:center" class="texto_valores" maxlength="15" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_email_comercial1" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<select id="email1_idioma" name="email1_idioma" style="width:100px;text-align:center" disabled="disabled">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center">
								<input type="checkbox" name="email1_on" id="email1_on" class="texto_valores" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general40']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general41']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general330']?> 2</span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>				
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_direccion" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_contacto" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" id="cliente_email_comercial2" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<select id="email2_idioma" name="email2_idioma" style="width:100px;text-align:center" disabled="disabled">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center">
								<input type="checkbox" name="email2_on" id="email2_on" class="texto_valores" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general42']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top"> 
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general43']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:52%" align="center" colspan="5">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general331']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_localidad" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" id="cliente_email" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:52%" align="center" rowspan="4" colspan="5">
								<table border="0" width="60%" cellpadding="0" cellspacing="0">
									<?php 
										$eventos = RellenarEventosNotificacion(); 
										for ($i=0;$i<count($eventos);$i++)
										{
									?>
									<tr>
										<td width="90%">
											<span class="texto_parametros" ><?php echo $eventos[$i][1]?></span>
										</td>
										<td width="10%">
											<input type="checkbox" id="<?php echo $eventos[$i][0]?>" name="evento_<?php echo $i?>"  disabled="disabled"/>
										</td>
									</tr> 
									<?php } ?>
								</table>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general44']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general45']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_provincia" style="width:150px;text-align:center" class="texto_valores" maxlength="20" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" id="cliente_web" style="width:150px;text-align:center" class="texto_valores" maxlength="50" disabled="disabled"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:2%"></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center">
				<input type="button" name="Eliminar Cliente" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56'].' '.$idiomas[$_SESSION['opcion_idioma']]['general1']?>" id="boton_delete" onclick="vBorrar_Cliente()" class="boton_fino_largo"/>
			</td>
			<td style="width:25%">					
				<input type="button" name="Cambiar logo" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general299']?>" id="boton_logo" onclick="OnClickConfigLogo(top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id);" class="boton_fino"/>
			</td>			
			<td style="width:40%" align="center">
				<input type="button" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general54']?>" id="boton_upload" onclick="vModificar_Cliente();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
<script type="text/javascript">		
	vCargar_Cliente();
</script>
</body>
</html>