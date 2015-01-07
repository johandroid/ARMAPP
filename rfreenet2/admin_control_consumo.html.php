<?session_start();
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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vCargar_Params_Consumo_Admin()
		{
			if (top.document.getElementById('comboClientes').selectedIndex > 0)
			{
				var xmlHttpParam6;
				var sNombreCombo;
				xmlHttpParam6= GetXmlHttpObject();
				var url = "carga_params_saldo_cliente.php?cliente_id="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
				xmlHttpParam6.onreadystatechange=function()
				{
					if (xmlHttpParam6.readyState==4)
					{
						var doc=xmlHttpParam6.responseText;
						var xmlrespuesta = parsear_xml(doc);
						x=xmlrespuesta.getElementsByTagName("configuracion");
						document.getElementById('saldo_total').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue;
					}
				}
				xmlHttpParam6.open("GET",url,true);
				xmlHttpParam6.send(null);
			}
			else
			{
				document.getElementById('saldo_total').value="";
			}
		}

		function vCargar_Tabla_Consumo_SMS()
		{
			var xmlHttpParam;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_consumo_sms.php";
			
			if (top.document.getElementById('comboClientes').selectedIndex>-1)
			{
				url += "?cliente_id="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
			}
			else
			{
				url += "?cliente_id=0";
			}
			if (top.document.getElementById('comboInst').selectedIndex>-1)
			{
				url += "&instalacion_id="+top.document.getElementById('comboInst').options[top.document.getElementById('comboInst').selectedIndex].id;
			}
			else
			{
				url += "&instalacion_id=0";
			}
			if (top.document.getElementById('FechaInicial').value.length > 0)
			{
				url += "&fecha_begin="+top.document.getElementById('FechaInicial').value+" 00:00:00";
			}
			else
			{
				url += "&fecha_begin=0";
			}
			if (top.document.getElementById('FechaFinal').value.length > 0)
			{
				url += "&fecha_end="+top.document.getElementById('FechaFinal').value+" 00:00:00";
			}
			else
			{
				url += "&fecha_end=0";
			}
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					document.getElementById('sms_enviados').value = parseFloat(xmlHttpParam.responseText.substring(0,12));
					document.getElementById('tabla_sms').innerHTML=xmlHttpParam.responseText.substring(12);					
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vCargar_Tabla_Consumo_Email()
		{
			var xmlHttpParam;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_consumo_email.php";
			
			if (top.document.getElementById('comboClientes').selectedIndex>-1)
			{
				url += "?cliente_id="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
			}
			else
			{
				url += "?cliente_id=0";
			}
			if (top.document.getElementById('comboInst').selectedIndex>-1)
			{
				url += "&instalacion_id="+top.document.getElementById('comboInst').options[top.document.getElementById('comboInst').selectedIndex].id;
			}
			else
			{
				url += "&instalacion_id=0";
			}
			if (top.document.getElementById('FechaInicial').value.length > 0)
			{
				url += "&fecha_begin="+top.document.getElementById('FechaInicial').value+" 00:00:00";
			}
			else
			{
				url += "&fecha_begin=0";
			}
			if (top.document.getElementById('FechaFinal').value.length > 0)
			{
				url += "&fecha_end="+top.document.getElementById('FechaFinal').value+" 00:00:00";
			}
			else
			{
				url += "&fecha_end=0";
			}
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					document.getElementById('tabla_email').innerHTML=xmlHttpParam.responseText;
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		
		function vRecargarSaldo()
		{
			if (top.document.getElementById('comboClientes').selectedIndex > 0)
			{
				if ((document.getElementById('saldo_nuevo').value.length > 0) && (document.getElementById('saldo_nuevo').value > 0))
				{
					if (iComprobar_Port(document.getElementById('saldo_nuevo').value) == 0)
					{
						if (confirm(iObtener_Cadena_AJAX('config_text4')+' '+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].value+' '+ document.getElementById('saldo_nuevo').value + ' SMS?'))
						{
							var xmlHttpParam;
							var sNombreCombo;
							xmlHttpParam= GetXmlHttpObject();
							var url = "modifica_saldo_sms_cliente.php?cliente_id=" + top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id + "&nuevo_saldo="+document.getElementById('saldo_nuevo').value + "&operacion=S";
							xmlHttpParam.onreadystatechange=function()
							{
								if (xmlHttpParam.readyState==4)
								{
									alert(xmlHttpParam.responseText);
									document.getElementById('saldo_nuevo').value = "";
									vCargar_Params_Consumo_Admin();									
								}
							}
							xmlHttpParam.open("GET",url,true);
							xmlHttpParam.send(null);
						}
					}
					else
					{
						alert(iObtener_Cadena_AJAX('error_config5')+" (1-65535)");
					}
				}
				else
				{
					alert(iObtener_Cadena_AJAX('error_config6'));
				}
			}
			else
			{
				document.getElementById('saldo_total').value="";
			}
		}
		function vQuitarSaldo()
		{
			if (top.document.getElementById('comboClientes').selectedIndex > 0)
			{
				if ((document.getElementById('saldo_quitar').value.length > 0) && (document.getElementById('saldo_quitar').value > 0))
				{
					if (iComprobar_Port(document.getElementById('saldo_quitar').value) == 0)
					{
						if (confirm(iObtener_Cadena_AJAX('config_text5')+' '+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].value+' '+ document.getElementById('saldo_nuevo').value + ' SMS?'))
						{
							var xmlHttpParam;
							var sNombreCombo;
							xmlHttpParam= GetXmlHttpObject();
							var url = "modifica_saldo_sms_cliente.php?cliente_id=" + top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id + "&nuevo_saldo="+document.getElementById('saldo_quitar').value + "&operacion=R";
							xmlHttpParam.onreadystatechange=function()
							{
								if (xmlHttpParam.readyState==4)
								{
									alert(xmlHttpParam.responseText);
									document.getElementById('saldo_quitar').value = "";
									vCargar_Params_Consumo_Admin();									
								}
							}
							xmlHttpParam.open("GET",url,true);
							xmlHttpParam.send(null);
						}
					}
					else
					{
						alert(iObtener_Cadena_AJAX('error_config5')+" (1-65535)");
					}
				}
				else
				{
					alert(iObtener_Cadena_AJAX('error_config7'));
				}
			}
			else
			{
				document.getElementById('saldo_total').value="";
			}
		}
		function vGenerarInformeConsumo()
		{
			var url = "carga_informe_consumo.php?tipo_informe="+document.getElementById("Tipo_Informe").options[document.getElementById("Tipo_Informe").selectedIndex].id;
				
			if (top.document.getElementById('comboClientes').selectedIndex>-1)
			{
				url += "&cliente_id="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
				url += "&cliente_nombre="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].value;
			}
			else
			{
				url += "&cliente_id=0";
			}
			if (top.document.getElementById('comboInst').selectedIndex>-1)
			{
				url += "&instalacion_id="+top.document.getElementById('comboInst').options[top.document.getElementById('comboInst').selectedIndex].id;
				url += "&instalacion_nombre="+top.document.getElementById('comboInst').options[top.document.getElementById('comboInst').selectedIndex].text;
			}
			else
			{
				url += "&instalacion_id=0";
			}
			if (top.document.getElementById('FechaInicial').value.length > 0)
			{
				url += "&fecha_begin="+top.document.getElementById('FechaInicial').value;
			}
			else
			{
				url += "&fecha_begin=0";
			}
			if (top.document.getElementById('FechaFinal').value.length > 0)
			{
				url += "&fecha_end="+top.document.getElementById('FechaFinal').value;
			}
			else
			{
				url += "&fecha_end=0";
			}
			window.open(url,'Download'); 
		}
		function vAnularSMSPendientes()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text6')+' '+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].value+'?'))
			{
				var xmlHttpParam;
				var sNombreCombo;
				xmlHttpParam= GetXmlHttpObject();
				var url = "elimina_sms_pendientes_cliente.php?cliente_id=" + top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
				xmlHttpParam.onreadystatechange=function()
				{
					if (xmlHttpParam.readyState==4)
					{
						alert(xmlHttpParam.responseText);
						document.getElementById('saldo_nuevo').value = "";
						vCargar_Params_Consumo_Admin();
						vCargar_SMS_Pendientes();
					}
				}
				xmlHttpParam.open("GET",url,true);
				xmlHttpParam.send(null);
			}
		}
		function vCargar_SMS_Pendientes()
		{			
			var xmlHttpParam;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_sms_pendientes.php";
			if (top.document.getElementById('comboClientes').selectedIndex > 0)
			{	
				if (top.document.getElementById('comboClientes').selectedIndex>-1)
				{
					url += "?cliente_id="+top.document.getElementById('comboClientes').options[top.document.getElementById('comboClientes').selectedIndex].id;
				}
				else
				{
					url += "?cliente_id=0";
				}
				if (top.document.getElementById('comboInst').selectedIndex>-1)
				{
					url += "&instalacion_id="+top.document.getElementById('comboInst').options[top.document.getElementById('comboInst').selectedIndex].id;
				}
				else
				{
					url += "&instalacion_id=0";
				}
				if (top.document.getElementById('FechaInicial').value.length > 0)
				{
					url += "&fecha_begin="+top.document.getElementById('FechaInicial').value+" 00:00:00";
				}
				else
				{
					url += "&fecha_begin=0";
				}
				if (top.document.getElementById('FechaFinal').value.length > 0)
				{
					url += "&fecha_end="+top.document.getElementById('FechaFinal').value+" 00:00:00";
				}
				else
				{
					url += "&fecha_end=0";
				}
				xmlHttpParam.onreadystatechange=function()
				{
					if (xmlHttpParam.readyState==4)
					{
						document.getElementById('sms_pendientes').value = parseFloat(xmlHttpParam.responseText);
					}
				}
				xmlHttpParam.open("GET",url,true);
				xmlHttpParam.send(null);
			}
			else
			{
				document.getElementById('sms_pendientes').value="";
			}
		}
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="left" colspan="8">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general80']?></span>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="8">
			<div style="overflow:auto;width:650px;height:150px;marginheight:0;marginwidth:0;" id="tabla_sms"></div>
		</td>
	</tr>
	<tr>
		<td style="width:5%"></td>
		<td style="width:15%" align="center">
			<span class="texto_valores"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general81']?></span>
		</td>
		<td style="width:10%">
			<input type="text" name="sms_pendientes" id="sms_pendientes" style="width:60px;text-align:center" class="texto_valores" maxlength="10" disabled="disabled"/>			
		</td>
		<td style="width:15%" align="center">
			<span class="texto_valores"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general82']?></span>
		</td>
		<td style="width:10%" align="center">
			<input type="text" name="sms_enviados" id="sms_enviados" style="width:60px;text-align:center" class="texto_valores" maxlength="10" disabled="disabled"/></td>
		<td style="width:15%" align="center">
			<span class="texto_valores" id="coste_total_label"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general83']?></span>
		</td>
		<td style="width:10%" align="center">
			<input type="text" name="saldo_total" id="saldo_total" style="width:60px;text-align:center" class="texto_valores" maxlength="10" disabled="disabled"/>
		</td>
		<td style="width:5%"></td>
	</tr>
	<tr>
		<td style="width:5%"></td>
		<td colspan="2" align="center">
			<input type="button" onclick="vAnularSMSPendientes()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56'].' '.$idiomas[$_SESSION['opcion_idioma']]['general81']?>" name="Anular_Pendientes" id="Anular_Pendientes" style="width:150px;text-align:center" class="boton_fino_largo" disabled="disabled"/>
		</td>
		<td style="width:15%" align="center"></td>
		<td style="width:10%" align="center"></td>
		<td style="width:15%" align="center">
			<input type="button" onclick="vRecargarSaldo()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general85']?>" name="recarga_saldo" id="recarga_saldo" style="width:120px;text-align:center" class="boton_fino_largo" disabled="disabled"/>
		</td>
		<td style="width:10%" align="center">
			<input type="text" name="saldo_nuevo" id="saldo_nuevo" style="width:60px;text-align:center" class="texto_valores" maxlength="5" disabled="disabled"/>
		</td>
		<td style="width:5%"></td>
	</tr>
	<tr>
		<td style="width:5%"></td>
		<td colspan="2" align="center"></td>
		<td style="width:15%" align="center"></td>
		<td style="width:10%" align="center"></td>
		<td style="width:15%" align="center">
			<input type="button" onclick="vQuitarSaldo()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general86']?>" name="quita_saldo" id="quita_saldo" style="width:120px;text-align:center" class="boton_fino_largo" disabled="disabled"/>
		</td>
		<td style="width:10%" align="center">
			<input type="text" name="saldo_quitar" id="saldo_quitar" style="width:60px;text-align:center" class="texto_valores" maxlength="5" disabled="disabled"/>
		</td>
		<td style="width:5%"></td>
	</tr>
	<tr>
		<td align="left" colspan="8">
			<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general90']?></span>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="8">
			<div style="overflow:auto;width:650px;height:150px;marginheight:0;marginwidth:0;" id="tabla_email"></div>
		</td>
	</tr>
	<tr>
		<td style="width:10%"></td>
		<td colspan="4" align="center">
			<span class="texto_valores"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general87']?>:&nbsp;&nbsp;</span>
			<select id="Tipo_Informe" class="RFNETtextINV">
				<option selected="selected" id="PDF">PDF</option>
				<option id="CSV">CSV</option>
			</select>
		</td>
		<td colspan="2" align="center">
			<input type="button" onclick="vGenerarInformeConsumo()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general89']?>" name="genera_informe" id="genera_informe" style="width:145px;text-align:center" class="boton_fino_largo"/>
		</td>
		<td style="width:10%"></td>
	</tr>
	</table>
<script type="text/javascript">
	vCargar_Params_Consumo_Admin();
	vCargar_Tabla_Consumo_SMS();
	vCargar_Tabla_Consumo_Email();
	vCargar_SMS_Pendientes();
</script>	
</body>
</html>