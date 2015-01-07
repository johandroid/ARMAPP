<?php session_start();
include 'inc/idiomas.inc';
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
	<script type="text/javascript">
		function vCargar_Instalaciones()
		{
			var vvx;
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_instalaciones.php?cliente_id="+top.document.getElementById("id_cliente").value;
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					vvx=xmlrespuesta.getElementsByTagName("instalacion");
					document.getElementById("comboInstalaciones").length = 0;
					for(i=0;i<vvx.length;i++)
					{
						insertarOptionComboValue("comboInstalaciones",xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[3].nodeValue, '',xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[1].nodeValue);
					}
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vBorrar_Dispositivos(instalacion_id_borrada,instalacion_nombre_borrada)
		{
			var url = "instalacion_elimina_dispositivos.php?instalacion_id="+instalacion_id_borrada+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_nombre="+instalacion_nombre_borrada+"&cliente_id="+top.document.getElementById('id_cliente').value;
			var xmlHttppipr= GetXmlHttpObject();
			xmlHttppipr.onreadystatechange=function()
			{
				if (xmlHttppipr.readyState==4)
				{
					alert(xmlHttppipr.responseText);
				}						
			}
			xmlHttppipr.open("GET",url,true);
			xmlHttppipr.send(null);	
		}
		function vBorrar_Instalacion()
		{			
			var instalacion_id_borrada;
			var cliente_db_borrada;
			var instalacion_nombre_borrada;
			
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{				
				instalacion_id_borrada = document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].id;
				cliente_db_borrada = top.document.getElementById('db_cliente').value;
				instalacion_nombre_borrada = document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].innerHTML; 
				if (confirm(iObtener_Cadena_AJAX('instala_text7')+" '"+instalacion_nombre_borrada+"' \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					url = "instalacion_elimina.php?instalacion_id="+instalacion_id_borrada+"&cliente_db="+cliente_db_borrada+"&instalacion_nombre="+instalacion_nombre_borrada+"&cliente_id="+top.document.getElementById('id_cliente').value;
					var xmlHttppipr= GetXmlHttpObject();
					xmlHttppipr.onreadystatechange=function()
					{
						if (xmlHttppipr.readyState==4)
						{
							vCargar_Instalaciones();
							window.parent.rellenar_lista_instalaciones(top.document.getElementById("db_cliente").value);
							if (xmlHttppipr.responseText == "ERROR")
							{
								alert(xmlHttppipr.responseText);
							}							
							else if (confirm(iObtener_Cadena_AJAX('instala_text8')+" \r\n'"+instalacion_nombre_borrada+"'?\r\n"+iObtener_Cadena_AJAX('instala_text9')+"."))
							{
								window.parent.rellenar_div_principal(58,"&instalacion_id="+instalacion_id_borrada+"&cliente_id="+top.document.getElementById('id_cliente').value+"&instalacion_nombre="+instalacion_nombre_borrada);
								window.parent.rellenar_div_submenu(99,"");
							}
							else
							{								
								vBorrar_Dispositivos(instalacion_id_borrada,instalacion_nombre_borrada);
								//alert(xmlHttppipr.responseText);						
							}							
						}						
					}
					xmlHttppipr.open("GET",url,true);
					xmlHttppipr.send(null);	
				}
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_instala14'));
			}
		}
		function vModificar_Instalacion()
		{
			var cliente_db_borrada = top.document.getElementById('db_cliente').value;
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{				
				window.parent.rellenar_div_principal(57,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].id+"&cliente_db="+cliente_db_borrada + "&instalacion_nombre="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].innerHTML+ "&instalacion_zona_horaria="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
				window.parent.rellenar_div_submenu(99,"");		
				window.parent.rellenar_lista_instalaciones(top.document.getElementById("db_cliente").value);
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_instala15'));
			}
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general91']?></span>
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
						<tr style="width:100%">
							<td style="width:25%"></td>
							<td style="width:50%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general234']?></span>
							</td>
							<td style="width:25%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:25%"><br/></td>
							<td style="width:50%" align="center" valign="top">
								<select id="comboInstalaciones" size="18" style="width:90%;height:300px;margin:0px 0 5px 0;"/>
							</td>
							<td style="width:25%"><br/></td>
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
				<input type="button" name="Eliminar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56']?>" id="boton_delete" onclick="vBorrar_Instalacion();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>			
			<td style="width:40%" align="center">
				<input type="button" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general54']?>" id="boton_upload" onclick="vModificar_Instalacion();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
<script type="text/javascript">
	vCargar_Instalaciones();
	if (document.getElementById("comboInstalaciones").length > 0)
	{
		document.getElementById("comboInstalaciones").selectedIndex=0;
	}
</script>
</body>
</html>