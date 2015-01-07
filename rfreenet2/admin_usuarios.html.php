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
		var saEmail = new Array(256);
		function vRellenenar_Usuario(iNumUser)
		{
			document.getElementById("nombre_user").value=document.getElementById("comboUsuarios").options[iNumUser].text;
			document.getElementById("comboPerfil").selectedIndex=document.getElementById("comboUsuarios").options[iNumUser].value.substring(0,1);
			document.getElementById("usuario_email").value=saEmail[iNumUser];
		}
		function vCargar_Usuarios()
		{			
			var vvx;
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			if (top.document.getElementById("comboClientes").selectedIndex != -1)
			{
				var url = "carga_usuarios.php?cliente_id="+top.document.getElementById("comboClientes").options[top.document.getElementById("comboClientes").selectedIndex].id;
				xmlHttpParam.onreadystatechange=function()
				{
					if (xmlHttpParam.readyState==4)
					{
						var doc=xmlHttpParam.responseText;
						var xmlrespuesta = parsear_xml(doc);
						vvx=xmlrespuesta.getElementsByTagName("usuario");
						document.getElementById("comboUsuarios").length = 0;
						for(i=0;i<vvx.length;i++)
						{
							insertarOptionComboValue("comboUsuarios",xmlrespuesta.getElementsByTagName("usuario")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("usuario")[i].attributes[2].nodeValue+xmlrespuesta.getElementsByTagName("usuario")[i].attributes[4].nodeValue, '',xmlrespuesta.getElementsByTagName("usuario")[i].attributes[1].nodeValue);
							saEmail[i] = xmlrespuesta.getElementsByTagName("usuario")[i].attributes[3].nodeValue;
						}
					}
				}
				xmlHttpParam.open("GET",url,true);
				xmlHttpParam.send(null);
			}
		}
		function OnChangeUsuario()
		{
			if (document.getElementById("comboUsuarios").selectedIndex != -1)
			{
				vRellenenar_Usuario(document.getElementById("comboUsuarios").selectedIndex);
			}
		}
		function vBorrar_user()
		{
			var url;
			var xmlHttpuser;
			if (document.getElementById("comboUsuarios").selectedIndex != -1)
			{
				if (confirm(iObtener_Cadena_AJAX('user_text2')+" "+document.getElementById("comboUsuarios").options[document.getElementById("comboUsuarios").selectedIndex].text+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					xmlHttpuser= GetXmlHttpObject();
					url = "usuario_elimina.php?usuario_id=" + document.getElementById("comboUsuarios").options[document.getElementById("comboUsuarios").selectedIndex].id;
					xmlHttpuser.onreadystatechange=function()
					{
						if (xmlHttpuser.readyState==4)
						{
							alert(xmlHttpuser.responseText);
							vCargar_Usuarios();
						}
					}
					xmlHttpuser.open("GET",url,true);
					xmlHttpuser.send(null);					
				}
			}
		}
		function vModificar_user()
		{
			if (document.getElementById("comboUsuarios").selectedIndex != -1)
			{
				window.parent.rellenar_div_principal(55,"&usuario_id="+document.getElementById("comboUsuarios").options[document.getElementById("comboUsuarios").selectedIndex].id+"&usuario_nombre=" + document.getElementById("nombre_user").value + "&usuario_perfil=" + document.getElementById("comboPerfil").selectedIndex + "&usuario_email=" + document.getElementById("usuario_email").value + "&cliente_id=" + document.getElementById("comboUsuarios").options[document.getElementById("comboUsuarios").selectedIndex].value.substring(1));
				window.parent.rellenar_div_submenu(99,"");
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_user8'));
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general92']?></span>
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
							<td style="width:5%"></td>
							<td style="width:40%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general93']?></span>
							</td>
							<td style="width:10%"></td>
							<td style="width:40%" align="center"></td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"><br/></td>
							<td style="width:40%" align="center" valign="top">
								<select id="comboUsuarios" onclick="OnChangeUsuario()" onchange="OnChangeUsuario" size="18" style="width:100%;height:300px;margin:0px 0 5px 0;"/>
							</td>
							<td style="width:10%"></td>
							<td style="width:40%" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td colspan="3" class="left_tborder top_tborder right_tborder bottom_tborder"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general94']?></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="nombre_user" style="width:150px;text-align:center" class="texto_valores" maxlength="20" disabled="disabled"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general43']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="usuario_email" style="width:150px;text-align:center" class="texto_valores" maxlength="100" disabled="disabled"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general48']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<select id="comboPerfil" disabled="disabled">
												<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['user_superadmin']?></option>
												<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['user_admin']?></option>
												<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['user_oper']?></option>
												<option><?php echo $idiomas[$_SESSION['opcion_idioma']]['user_visit']?></option>
											</select>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder bottom_tborder"><br/></td>
									</tr>
								</table>
							</td>
							<td style="width:5%"><br/></td>
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
				<input type="button" name="Eliminar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56']?>" id="boton_delete" onclick="vBorrar_user();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>			
			<td style="width:40%" align="center">
				<input type="button" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general54']?>" id="boton_upload" onclick="vModificar_user();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
<script type="text/javascript">		
	document.getElementById("comboPerfil").selectedIndex=-1;	
	vCargar_Usuarios();
	if (document.getElementById("comboUsuarios").length > 0)
	{
		document.getElementById("comboUsuarios").selectedIndex=0;
		OnChangeUsuario();
	}	
</script>
</body>
</html>