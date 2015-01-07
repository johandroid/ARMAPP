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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vCargar_Params_RX_Admin()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_admin_rx.php";
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");				
					document.getElementById('port_udp').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue;
					document.getElementById('port_tcp').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue;
					document.getElementById('port_tcp_tx').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue;
					switch (parseInt(xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue))
					{
						case 0:
							document.getElementById('modo_offline').checked = false;
							break;
						case 1:
							document.getElementById('modo_offline').checked = true;
							break;
					}	
					document.getElementById('port_soap').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
					document.getElementById('tiempo_sesion').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue;
					document.getElementById('tiempo_sesion_unit').selectedIndex=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[6].nodeValue;				
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		
		function vOperacion_Proceso(proceso)
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "operacion_proceso.php?proceso="+proceso;
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					switch(proceso)
					{
						case 'M':
							alert(iObtener_Cadena_AJAX('general73'));
							break;
						case 'D':
							alert(iObtener_Cadena_AJAX('general74'));
							break;
						case 'MR':
							alert(iObtener_Cadena_AJAX('general327'));
							break;
						case 'DR':
							alert(iObtener_Cadena_AJAX('general328'));
							break;							
						default:
							break;
					}
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		
		function vActualizar_params()
		{
			if ((document.getElementById('port_udp').value.length > 0) 
					&& (document.getElementById('port_tcp').value.length>0) 
					&& (document.getElementById('port_tcp_tx').value.length>0))
			{
				if (iComprobar_Port(document.getElementById("port_udp").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config1'));
					return false;
				}
				else if (iComprobar_Port(document.getElementById("port_tcp").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config2'));
					return false;
				}
				else if (iComprobar_Port(document.getElementById("port_tcp_tx").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config3'));
					return false;
				}
				else if (iComprobar_Port(document.getElementById("tiempo_sesion").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config13'));
					return false;
				}
				return true;
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_config4'));
				return false;
			}
		}
		function vReset_Demonio()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text1')+'.\r\n'+iObtener_Cadena_AJAX('config_text3')+'.\r\n'+iObtener_Cadena_AJAX('general0')))
			{
				vOperacion_Proceso('D');
			}
		}
		function vReset_Monitor()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text1')+'.\r\n'+iObtener_Cadena_AJAX('config_text3')+'.\r\n'+iObtener_Cadena_AJAX('general0')))
			{
				vOperacion_Proceso('M');
			}
		}
		function vReset_Demonio_Rutinas()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text1')+'.\r\n'+iObtener_Cadena_AJAX('config_text3')+'.\r\n'+iObtener_Cadena_AJAX('general0')))
			{
				vOperacion_Proceso('DR');
			}
		}
		function vReset_Monitor_Rutinas()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text1')+'.\r\n'+iObtener_Cadena_AJAX('config_text3')+'.\r\n'+iObtener_Cadena_AJAX('general0')))
			{
				vOperacion_Proceso('MR');
			}
		}		
		function vRellenar_Combo_TO(m_COMBO)
		{
			document.getElementById(m_COMBO).length = 0;
        	insertarOptionCombo(m_COMBO,"0",iObtener_Cadena_AJAX('general136'));
        	insertarOptionCombo(m_COMBO,"1",iObtener_Cadena_AJAX('general135'));
        	insertarOptionCombo(m_COMBO,"2",iObtener_Cadena_AJAX('general134'));
        	insertarOptionCombo(m_COMBO,"3",iObtener_Cadena_AJAX('general176'));
            document.getElementById(m_COMBO).selectedIndex = 0;
		}
	</script>
</head>

<body>
<form method="post">
<?php
	if ($_POST['Actualizar'])
	{
		include 'inc/datos_db.inc';
		
		$port_udp=$_POST['port_udp'];		
		$port_tcp=$_POST['port_tcp'];
		$port_tcp_tx=$_POST['port_tcp_tx'];
		$modo_offline=$_POST['modo_offline'];
		$port_soap=$_POST['port_soap'];
		
		$tiempo_sesion=$_POST['tiempo_sesion'];		
		switch ($_POST['tiempo_sesion_unit'])
		{
			case $idiomas[$_SESSION['opcion_idioma']]['general135']:
				$tiempo_sesion_unit=1;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general134']:
				$tiempo_sesion_unit=2;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general176']:
				$tiempo_sesion_unit=3;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general136']:
				$tiempo_sesion_unit=0;
				break;
		}

		$link7 = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($db_name_general, $link7);
		
		$query="UPDATE ".$tabla_name_config." SET config_port_udp='".$port_udp."', config_port_tcp='".$port_tcp."',config_port_tcp_tx='".$port_tcp_tx."', config_tiempo_sesion='".$tiempo_sesion."', config_tiempo_sesion_unit='".$tiempo_sesion_unit."',config_tcp_soap='".$port_soap."'";
		if ($modo_offline == 'check_offline')
		{
			$query.= ", config_offline='1'";
		}
		else
		{
			$query.= ", config_offline='0'";
		}
		//echo $query;
		mysql_query($query) or die(mysql_error());
		echo "<script>parent.rellenar_div_submenu(53,'');alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link7);
	}
?>
	<table border="0" width="100%">
	<tr>
		<td align="center"></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general75']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-little-box">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general76']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="checkbox" name="modo_offline" id="modo_offline" value="check_offline"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param1']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="text" name="port_udp" id="port_udp" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param2']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="text" name="port_tcp" id="port_tcp" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param3']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="text" name="port_tcp_tx" id="port_tcp_tx" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general309']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="text" name="port_soap" id="port_soap" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:40%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general311']?></span>
							</td>
							<td style="width:50%" align="center">
								<input type="text" name="tiempo_sesion" id="tiempo_sesion" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
								<select name="tiempo_sesion_unit" id="tiempo_sesion_unit" style="width:75px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
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
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general79']?></span>
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
					<table width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:45%" align="center">
								<input type="button" name="Reiniciar Demonio" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general77']?>" id="boton_upload1" onclick="vReset_Demonio();" class="boton_fino_largo"/>
							</td>
							<td style="width:45%" align="center">
								<input type="button" name="Reiniciar Monitor" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general78']?>" id="boton_upload2" onclick="vReset_Monitor();" class="boton_fino_largo"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:45%" align="center">
								<input type="button" name="Reiniciar Demonio Rutinas" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general77']?> <?php echo $idiomas[$_SESSION['opcion_idioma']]['title_rutinas']?>" id="boton_upload1" onclick="vReset_Demonio_Rutinas();" class="boton_fino_largo"/>
							</td>
							<td style="width:45%" align="center">
								<input type="button" name="Reiniciar Monitor Rutinas" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general78']?> <?php echo $idiomas[$_SESSION['opcion_idioma']]['title_rutinas']?>" id="boton_upload2" onclick="vReset_Monitor_Rutinas();" class="boton_fino_largo"/>
							</td>
							<td style="width:5%"></td>
						</tr>						
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
</form>
<script type="text/javascript">
	vRellenar_Combo_TO('tiempo_sesion_unit');
	vCargar_Params_RX_Admin();
</script>
</body>
</html>