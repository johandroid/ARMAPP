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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vCargar_Params_Eventos_Admin()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_admin_eventos.php";
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");
					document.getElementById('eventos_cobertura_nodo').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue;
					document.getElementById('eventos_bateria_nodo').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue;
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue == 0)
					{
						document.getElementById('eventos_alimentacion_gw').checked = false;
					}
					else
					{
						document.getElementById('eventos_alimentacion_gw').checked = true;
					}
					document.getElementById('eventos_bateria_gw').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue;
					document.getElementById('eventos_bateria_gw_low').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vInsertarEnSelect(sId,sGateway,sMAC,sEvento)
		{
			var sInsercion;

			sInsercion='<option id="'+sId+'" name="'+sMAC+'" value="'+sEvento+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+sGateway+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+sMAC+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+sEvento+'</option>';
			document.getElementById('comboBlacklist').innerHTML+=sInsercion;
		}
		function vCargar_Params_Blacklist_Admin()
		{
			var iCuenta;
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_admin_blacklist.php";
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("blacklisted");
					for (iCuenta=0;iCuenta<x.length;iCuenta++)
					{
						vInsertarEnSelect(xmlrespuesta.getElementsByTagName("blacklisted")[iCuenta].attributes[0].nodeValue,xmlrespuesta.getElementsByTagName("blacklisted")[iCuenta].attributes[1].nodeValue,xmlrespuesta.getElementsByTagName("blacklisted")[iCuenta].attributes[2].nodeValue,xmlrespuesta.getElementsByTagName("blacklisted")[iCuenta].attributes[4].nodeValue)
					}
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vActualizar_params()
		{
			if (document.getElementById('eventos_cobertura_nodo').value.length > 3)
			{
				alert(iObtener_Cadena_AJAX('error_evento1')+' '+document.getElementById('eventos_cobertura_nodo').value.length);
				return false;
			}
			else if (iComprobar_Entero(document.getElementById("eventos_cobertura_nodo").value,10) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_evento2'));
				return false;
			}
			if (document.getElementById('eventos_bateria_nodo').value.length > 10)
			{
				alert(iObtener_Cadena_AJAX('error_evento3')+' '+document.getElementById('eventos_bateria_nodo').value.length);
				alert('ERROR: Ha introducido '+document.getElementById('eventos_bateria_nodo').value.length+' caracteres en el nivel mínimo de batería de nodo y el máximo es de 10');
				return false;
			}
			else if (iComprobar_Decimal(document.getElementById("eventos_bateria_nodo").value,10) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_evento4'));
				return false;
			}
			if (document.getElementById('eventos_bateria_gw').value.length > 10)
			{
				alert(iObtener_Cadena_AJAX('error_evento5')+' '+document.getElementById('eventos_bateria_gw').value.length);
				alert('ERROR: Ha introducido '+document.getElementById('eventos_bateria_gw').value.length+' caracteres en el nivel mínimo de batería y el máximo es de 10');
				return false;
			}
			else if (iComprobar_Decimal(document.getElementById("eventos_bateria_gw").value,10) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_evento6'));
				return false;
			}
			if (document.getElementById('eventos_bateria_gw_low').value.length > 10)
			{
				alert(iObtener_Cadena_AJAX('error_evento5')+' '+document.getElementById('eventos_bateria_gw_low').value.length);
				alert('ERROR: Ha introducido '+document.getElementById('eventos_bateria_gw_low').value.length+' caracteres en el nivel mínimo de batería y el máximo es de 10');
				return false;
			}
			else if (iComprobar_Decimal(document.getElementById("eventos_bateria_gw_low").value,10) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_evento6'));
				return false;
			}
			return true;
		}
		function vEliminar_Blacklisted()
		{
			if (document.getElementById('comboBlacklist').selectedIndex > 0)
			{
				vEliminar_Evento_Admin(document.getElementById("comboBlacklist").options[document.getElementById("comboBlacklist").selectedIndex].id);
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_evento7'));
			}
		}
		function vEliminar_Evento_Admin(sIDEvento)
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "elimina_admin_evento_blacklist.php?id_evento="+sIDEvento;
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					if (xmlHttpParam.responseText == "OK")
					{
						alert(iObtener_Cadena_AJAX('evento_text1'));
					}
					else
					{
						alert(iObtener_Cadena_AJAX('error_evento8'));
					}
					document.getElementById("comboBlacklist").innerHTML='<option disabled="true" id="titulo_bl" name="titulo_bl" value="titulo_bl">&nbsp;&nbsp;&nbsp;&nbsp;Gateway&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Evento</option>';
					vCargar_Params_Blacklist_Admin();
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vAnyadir_Blacklisted()
		{
			top.rellenar_div_principal(64,"");
		}
	</script>
</head>

<body>
<form method="post">
<?php
	if ($_POST['Actualizar'])
	{
		include 'inc/datos_db.inc';
				
		$eventos_cobertura_nodo=$_POST['eventos_cobertura_nodo'];
		$eventos_bateria_nodo=$_POST['eventos_bateria_nodo'];
		if ($_POST['eventos_alimentacion_gw'] == 'on')
		{
			$eventos_alimentacion_gw='1';
		}
		else
		{
			$eventos_alimentacion_gw='0';
		}
		$eventos_bateria_gw=$_POST['eventos_bateria_gw'];
		$eventos_bateria_gw_low=$_POST['eventos_bateria_gw_low'];

		$link7 = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($db_name_general, $link7);
		
		$query="UPDATE rfreenet_config_eventos SET eventos_cobertura_nodo='".$eventos_cobertura_nodo."', eventos_bateria_nodo='".$eventos_bateria_nodo."', eventos_alimentacion_gw='".$eventos_alimentacion_gw."', eventos_bateria_gw='".$eventos_bateria_gw."', eventos_bateria_gw_low='".$eventos_bateria_gw_low."'";
		//echo $query;
		mysql_query($query) or die(mysql_error());
		echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link7);
	}
?>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general5']?></span>
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
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center" class="bottom_tborder">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general66']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" class="bottom_tborder">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general67']?></span>
							</td>
							<td style="width:23%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general68']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" name="eventos_cobertura_nodo" id="eventos_cobertura_nodo" style="width:60px;text-align:center" class="texto_valores" maxlength="3"/>
							</td>
							<td style="width:23%"></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general69']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" name="eventos_bateria_nodo" id="eventos_bateria_nodo" style="width:60px;text-align:center" class="texto_valores" maxlength="10"/>
							</td>
							<td style="width:23%"></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general70']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="checkbox" name="eventos_alimentacion_gw" id="eventos_alimentacion_gw" class="texto_valores"/>
							</td>
							<td style="width:23%"></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general71']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" name="eventos_bateria_gw" id="eventos_bateria_gw" style="width:60px;text-align:center" class="texto_valores" maxlength="10"/>
							</td>
							<td style="width:23%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:20%"></td>
							<td style="width:35%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general71']?> Datalogger</span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" name="eventos_bateria_gw_low" id="eventos_bateria_gw_low" style="width:60px;text-align:center" class="texto_valores" maxlength="10"/>
							</td>
							<td style="width:23%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5" align="center">
								<span class="texto_parametros">(<?php echo $idiomas[$_SESSION['opcion_idioma']]['general72']?>)</span>
							</td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5" align="center">
								<span class="texto_parametros">&nbsp;&nbsp;&nbsp;Blacklist</span>
							</td>
						</tr>
						<tr style="width:100%">
							<td colspan="5" align="left">
								<select id="comboBlacklist" size="18" style="width:100%;height:150px;margin:0px 0 5px 0;">
									<option disabled="disabled" id="titulo_bl" name="titulo_bl" value="titulo_bl">&nbsp;&nbsp;&nbsp;&nbsp;Gateway&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Evento</option>
								</select>
							</td>
						</tr>
					</table>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
								<td style="width:20%"></td>
								<td style="width:22%" align="center">
									<input type="button" onclick="vAnyadir_Blacklisted()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general50']?>" name="blacklist_anyadir" id="blacklist_anyadir" style="width:60px;text-align:center" class="boton_fino_medio"/>
								</td>
								<td style="width:2%"></td>
								<td style="width:22%" align="center">
									<input type="button" onclick="vEliminar_Blacklisted()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56']?>" name="blacklist_eliminar" id="blacklist_eliminar" style="width:60px;text-align:center" class="boton_fino_medio"/>
								</td>
								<td style="width:24%"></td>														
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<table border="0" style="width:100%">
		<tr style="width:100%">
			<td style="width:10%"><br/></td>
			<td style="width:25%"></td>
			<td style="width:30%"><br/></td>
			<td style="width:25%" align="center">
				<input type="submit" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" id="boton_upload" onclick="return vActualizar_params();" class="boton_fino"/>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	vCargar_Params_Eventos_Admin();
	vCargar_Params_Blacklist_Admin();
</script>
</body>
</html>