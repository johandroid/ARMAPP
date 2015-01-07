<?session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		function vActualizarConsumo()
		{
			document.getElementById('tabla_email').innerHTML="";
			document.getElementById('tabla_sms').innerHTML="";
			vCargar_Params_Consumo_Admin();
			vCargar_Tabla_Consumo_SMS();
			vCargar_Tabla_Consumo_Email();
		}
	
		function vCargar_Params_Consumo_Admin()
		{
			var xmlHttpParam6;
			var sNombreCombo;
			xmlHttpParam6= GetXmlHttpObject();
			var url = "carga_params_saldo_cliente.php?cliente_id="+top.document.getElementById('id_cliente').value;
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

		function vCargar_Tabla_Consumo_SMS()
		{
			var xmlHttpParam;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_sms_cliente.php?cliente_id="+top.document.getElementById('id_cliente').value;

			url += "&cliente_db="+top.document.getElementById('db_cliente').value;
			
			if (top.document.getElementById('comboInstalaciones').selectedIndex>-1)
			{
				url += "&instalacion_id="+top.document.getElementById('comboInstalaciones').options[top.document.getElementById('comboInstalaciones').selectedIndex].value;
			}
			else
			{
				url += "&instalacion_id=0";
			}
			if (top.document.getElementById('Filtro_combo_GW').selectedIndex>0)
			{
				url += "&filtro_gw="+top.document.getElementById('Filtro_combo_GW').options[top.document.getElementById('Filtro_combo_GW').selectedIndex].id;
			}
			else
			{
				url += "&filtro_gw=0";
			}
			if (top.document.getElementById('Filtro_combo_Nodo').selectedIndex>0)
			{
				url += "&filtro_nodo="+top.document.getElementById('Filtro_combo_Nodo').options[top.document.getElementById('Filtro_combo_Nodo').selectedIndex].id;
			}
			else
			{
				url += "&filtro_nodo=0";
			}
			if (top.document.getElementById('Filtro_combo_UTC').selectedIndex>0)
			{
				url += "&filtro_utc="+top.document.getElementById('Filtro_combo_UTC').options[top.document.getElementById('Filtro_combo_UTC').selectedIndex].id;
			}
			else
			{
				url += "&filtro_utc=0";
			}
			if (top.document.getElementById('Filtro_combo_Evento').selectedIndex!= -1)
			{
				url += "&filtro_evento="+top.document.getElementById('Filtro_combo_Evento').selectedIndex;
			}
			else
			{
				url += "&filtro_evento=0";
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
					if (document.getElementById('tabla_email').innerHTML!= "")
					{
						$('#imagen_espera_db').attr("class", 'escondido');
					}
				}
			}
			$('#imagen_espera_db').attr("class", 'mostrado');
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vCargar_Tabla_Consumo_Email()
		{
			var xmlHttpParam2;
			xmlHttpParam2= GetXmlHttpObject();
			var url = "carga_email_cliente.php?cliente_id="+top.document.getElementById('id_cliente').value;

			url += "&cliente_db="+top.document.getElementById('db_cliente').value;

			if (top.document.getElementById('comboInstalaciones').selectedIndex>-1)
			{
				url += "&instalacion_id="+top.document.getElementById('comboInstalaciones').options[top.document.getElementById('comboInstalaciones').selectedIndex].value;
			}
			else
			{
				url += "&instalacion_id=0";
			}
			if (top.document.getElementById('Filtro_combo_GW').selectedIndex>0)
			{
				url += "&filtro_gw="+top.document.getElementById('Filtro_combo_GW').options[top.document.getElementById('Filtro_combo_GW').selectedIndex].id;
			}
			else
			{
				url += "&filtro_gw=0";
			}
			if (top.document.getElementById('Filtro_combo_Nodo').selectedIndex>0)
			{
				url += "&filtro_nodo="+top.document.getElementById('Filtro_combo_Nodo').options[top.document.getElementById('Filtro_combo_Nodo').selectedIndex].id;
			}
			else
			{
				url += "&filtro_nodo=0";
			}
			if (top.document.getElementById('Filtro_combo_UTC').selectedIndex>0)
			{
				url += "&filtro_utc="+top.document.getElementById('Filtro_combo_UTC').options[top.document.getElementById('Filtro_combo_UTC').selectedIndex].id;
			}
			else
			{
				url += "&filtro_utc=0";
			}
			if (top.document.getElementById('Filtro_combo_Evento').selectedIndex!= -1)
			{
				url += "&filtro_evento="+top.document.getElementById('Filtro_combo_Evento').selectedIndex;
			}
			else
			{
				url += "&filtro_evento=0";
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
			xmlHttpParam2.onreadystatechange=function()
			{
				if (xmlHttpParam2.readyState==4)
				{
					document.getElementById('tabla_email').innerHTML=xmlHttpParam2.responseText;
					if (document.getElementById('tabla_sms').innerHTML!= "")
					{
						$('#imagen_espera_db').attr("class", 'escondido');
					}
				}
			}
			$('#imagen_espera_db').attr("class", 'mostrado');
			xmlHttpParam2.open("GET",url,true);
			xmlHttpParam2.send(null);
		}

		function vBorrar_Fecha(iCampo)
		{
			switch (iCampo)
			{
				case 1:
					top.document.getElementById("FechaFinal").value="";
					break;
					
				default:
					top.document.getElementById("FechaInicial").value="";
				break;
			}
		}
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="left" colspan="7">
			<span>SMS</span>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="7">
			<div style="overflow:auto;width:97%;height:180px;marginheight:0;marginwidth:0;" id="tabla_sms"></div>
		</td>
	</tr>
	<tr>
		<td style="width:5%"></td>
		<td style="width:20%" align="center">
			<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general88']?></span>
		</td>
		<td style="width:15%" align="center">
			<input type="text" name="sms_enviados" id="sms_enviados" style="width:60px;text-align:center" class="texto_valores" maxlength="10" disabled="disabled"/>			
		</td>
		<td style="width:15%" align="center"></td>
		<td style="width:20%" align="center">
			<span class="texto_parametros" id="coste_total_label"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general83']?></span>
		</td>
		<td style="width:15%" align="center">
			<input type="text" name="saldo_total" id="saldo_total" style="width:60px;text-align:center" class="texto_valores" maxlength="10" disabled="disabled"/>
		</td>
		<td style="width:5%"></td>
	</tr>
	<tr>
		<td align="left" colspan="7"><br/></td>
	</tr>
	<tr>
		<td align="left" colspan="7">
			<span>Email</span>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="7">
			<div style="overflow:auto;width:97%;height:180px;marginheight:0;marginwidth:0;" id="tabla_email"></div>
		</td>
	</tr>
	<tr>
		<td style="width:10%"></td>
		<td colspan="2" align="center"></td>
		<td style="width:10%"></td>
		<td colspan="2" align="center"></td>
		<td style="width:10%"></td>
	</tr>
	</table>
<script type="text/javascript">
	vActualizarConsumo();
</script>	
</body>
</html>