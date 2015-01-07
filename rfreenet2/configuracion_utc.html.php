<?php session_start();
include 'inc/funciones_indice.inc';
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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/funciones_submenu.js?time=<?php echo(filemtime("js/funciones_submenu.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_utc.js?time=<?php echo(filemtime("js/funciones_utc.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>	
	<script type="text/javascript">
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function Guardar(id_disp)
		{
			var sCadenaParams;
			var url;
			var alta_offline;

			if (iComprobar_Valores_UTC() == 0)
			{
				if (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
				{
					alta_offline = 0;
				}
				else
				{
					alta_offline = 1;
				}
					
				$('#imagen_espera_mod').attr("class", 'mostrado');
				url = "utc_modificacion.php";
				var nombre = document.getElementById("nombre_disp").value;
				var gw_id = document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id;
				var direccion = document.getElementById("direccion_485").value;
				var reposicion = document.getElementById("HMR").selectedIndex;
				var tipo_utc = document.getElementById("tipo_dispositivo").options[document.getElementById("tipo_dispositivo").selectedIndex].id;
				sCadenaParams="id_disp="+id_disp+"&HMR="+reposicion+"&nombre="+nombre+"&gw_id="+gw_id+"&direccion="+direccion+"&tipo_utc="+tipo_utc+"&magnitudes="+sPrepararCadenaMagnitudes("magnitudes")+"&magnitudesSMS="+sPrepararCadenaMagnitudes("magnitudesSMS")+"&magnitudesEMAIL="+sPrepararCadenaMagnitudes("magnitudesEMAIL")+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value+"&offline="+alta_offline;
				
				if(tipo_utc==3)
				{
					if (iComprobar_Parametros_UTC() == 0)
					{
						var tiempo_medida = document.getElementById("tiempo_medida").value;
						var setpoint =  Math.round(document.getElementById("setpoint").value*100);
						var delta = document.getElementById("delta").selectedIndex;
						var lowpoint =  Math.round(document.getElementById("punto_bajo").value*100);
						var lowpoint_habilitado = document.getElementById("habilita_punto_bajo").selectedIndex;
						var max = document.getElementById("tiempo_maximo").value;
						var max_habilitado = document.getElementById("habilita_tiempo_maximo").selectedIndex;
						var alarma_alta_cloro =  Math.round(document.getElementById("alarma_alta_cloro").value*100);
						var alarma_alta_cloro_habilitado = document.getElementById("habilita_alarma_alta_cloro").selectedIndex;
						var alarma_baja_cloro =  Math.round(document.getElementById("alarma_baja_cloro").value*100);
						var alarma_baja_cloro_habilitado = document.getElementById("habilita_alarma_baja_cloro").selectedIndex;
						var password = document.getElementById("password").value;
						sCadenaParams += "&tiempo_medida="+tiempo_medida+"&setpoint="+setpoint+"&delta="+delta+"&lowpoint="+lowpoint+"&lowpoint_habilitado="+lowpoint_habilitado;
						sCadenaParams += "&max="+max+"&max_habilitado="+max_habilitado+"&alarma_alta_cloro="+alarma_alta_cloro+"&alarma_alta_cloro_habilitado="+alarma_alta_cloro_habilitado;
						sCadenaParams += "&alarma_baja_cloro="+alarma_baja_cloro+"&alarma_baja_cloro_habilitado="+alarma_baja_cloro_habilitado+"&password="+password;
					}
					else
					{
						alert(iObtener_Cadena_AJAX('general96'));
						$('#imagen_espera_mod').attr("class", 'escondido');
						return;
					}
				}
				
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("POST",url,true);
				xmlHttpgrRead.onreadystatechange = function()
				{
					if (xmlHttpgrRead.readyState==4)
					{
						$('#imagen_espera_mod').attr("class", 'escondido');
						if (xmlHttpgrRead.responseText.substring(0,5) != "ERROR")
						{
							alert(iObtener_Cadena_AJAX('general22'));
						}
						else
						{
							alert(xmlHttpgrRead.responseText);
						}
					}
				}
				xmlHttpgrRead.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xmlHttpgrRead.send(sCadenaParams);
			}
			else
			{
				alert(iObtener_Cadena_AJAX('general96'));
			}
		}
		
		function Rellenar_Valores(id_utc)
		{
			var url = "carga_params_utc.php?cliente_db="+top.document.getElementById("db_cliente").value+"&utc_id="+id_utc;
			//alert(url);
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,false);
			xmlHttpgrRead.send(null);
			
			if ((xmlHttpgrRead.responseText=='ERROR'))
			{
				alert(xmlHttpgrRead.responseText);
			}
			else
			{
				var docUTC=xmlHttpgrRead.responseText;
				var xmlrespuestaUTC = parsear_xml(docUTC);
				var vvxUTC=xmlrespuestaUTC.getElementsByTagName("utc");
				
				if (vvxUTC.length >= 1)
				{
					
					var nombre = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[0].nodeValue;
					var direccion = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[1].nodeValue;
					var tipo = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[2].nodeValue;
					var gw_id = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[3].nodeValue;
					var magnitudes = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[4].nodeValue;
					var magnitudesSMS = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[5].nodeValue;
					var magnitudesEMAIL = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[6].nodeValue;
					var reposicion = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[7].nodeValue;
					
					//alert("El analizador de nombre "+nombre+" y direccion "+direccion+" tipo "+tipo + " del gateway "+gw_id+" las magnitudes "+magnitudes);
					document.getElementById("nombre_disp").value = nombre;
					document.getElementById("direccion_485").value = direccion;
					for (i=0; i< document.getElementById("selectGateways").length ; i++)
					{
						if (document.getElementById("selectGateways").options[i].id == gw_id)
						{
							document.getElementById("selectGateways").selectedIndex = i;
						}
					}
					
					for (i=0; i< document.getElementById("tipo_dispositivo").length ; i++)
					{
						if (document.getElementById("tipo_dispositivo").options[i].id == tipo)
						{
							document.getElementById("tipo_dispositivo").selectedIndex = i;
						}
					}
					vCambiar_Magnitudes();
					
					document.getElementById("HMR").selectedIndex = reposicion;
					
					vAsignaMagnitudes(magnitudes,"magnitudes");
					vAsignaMagnitudes(magnitudesSMS,"magnitudesSMS");
					vAsignaMagnitudes(magnitudesEMAIL,"magnitudesEMAIL");
					
					if(tipo==3)
					{
						var tiempo_medida = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[8].nodeValue;
						var setpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[9].nodeValue;
						var delta = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[10].nodeValue;
						var lowpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[11].nodeValue;
						var lowpoint_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[12].nodeValue;
						var max = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[13].nodeValue;
						var max_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[14].nodeValue;
						var alarma_alta_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[15].nodeValue;
						var alarma_alta_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[16].nodeValue;
						var alarma_baja_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[17].nodeValue;
						var alarma_baja_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[18].nodeValue;
						var password = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[19].nodeValue;
						
						document.getElementById("tiempo_medida").value = tiempo_medida;
						document.getElementById("setpoint").value = setpoint/100;
						document.getElementById("delta").selectedIndex = delta;
						document.getElementById("habilita_punto_bajo").selectedIndex = lowpoint_habilitado;
						document.getElementById("habilita_tiempo_maximo").selectedIndex = max_habilitado;
						document.getElementById("habilita_alarma_alta_cloro").selectedIndex = alarma_alta_cloro_habilitado;
						document.getElementById("habilita_alarma_baja_cloro").selectedIndex = alarma_baja_cloro_habilitado;
						document.getElementById("punto_bajo").value = lowpoint/100;
						document.getElementById("tiempo_maximo").value = max;
						document.getElementById("alarma_alta_cloro").value = alarma_alta_cloro/100;
						document.getElementById("alarma_baja_cloro").value = alarma_baja_cloro/100;
						document.getElementById("password").value = password;
					}
					else
					{
						tabbar.disableTab("u4");
					}
				}
			}
		}
			
		function vLeer_Params()
		{
			var sCadenaParams;
			var url;
			var alta_offline;

			if (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
			{
				alta_offline = 0;				
			}
			else
			{
				alta_offline = 1;
			}
			$('#imagen_espera').attr("class", 'mostrado');
			url = "utc_lectura_params.php";			
			var gw_id = document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id;
			var direccion = document.getElementById("direccion_485").value;
			url+="?gw_id="+gw_id+"&direccion="+direccion+"&offline="+alta_offline;
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,true);
			xmlHttpgrRead.onreadystatechange = function()
			{
				if (xmlHttpgrRead.readyState==4)
				{
					$('#imagen_espera').attr("class", 'escondido');
					if (xmlHttpgrRead.responseText.substring(0,5) != "ERROR")
					{
						if (alta_offline == 0)
						{
							var docUTC=xmlHttpgrRead.responseText;
							var xmlrespuestaUTC = parsear_xml(docUTC);
							var vvxUTC=xmlrespuestaUTC.getElementsByTagName("utc");
							
							var alarma_alta_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[0].nodeValue;
							var alarma_baja_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[1].nodeValue;
							var delta = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[2].nodeValue;
							var lowpoint_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[3].nodeValue;
							var max_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[4].nodeValue;
							var alarma_alta_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[5].nodeValue;
							var alarma_baja_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[6].nodeValue;
							var setpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[7].nodeValue;
							var lowpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[8].nodeValue;
							var tiempo_medida = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[9].nodeValue;
							var max = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[10].nodeValue;
												
							
							document.getElementById("tiempo_medida").value = tiempo_medida;
							document.getElementById("setpoint").value = setpoint/100;
							document.getElementById("delta").selectedIndex = delta;
							document.getElementById("habilita_punto_bajo").selectedIndex = lowpoint_habilitado;
							document.getElementById("habilita_tiempo_maximo").selectedIndex = max_habilitado;
							document.getElementById("habilita_alarma_alta_cloro").selectedIndex = alarma_alta_cloro_habilitado;
							document.getElementById("habilita_alarma_baja_cloro").selectedIndex = alarma_baja_cloro_habilitado;
							document.getElementById("punto_bajo").value = lowpoint/100;
							document.getElementById("tiempo_maximo").value = max;
							document.getElementById("alarma_alta_cloro").value = alarma_alta_cloro/100;
							document.getElementById("alarma_baja_cloro").value = alarma_baja_cloro/100;
						}
						else
						{
							alert(iObtener_Cadena_AJAX('general361'));
						}
					}
					else
					{
						alert(xmlHttpgrRead.responseText);
					}
				}
			}
			xmlHttpgrRead.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpgrRead.send(null);
		}
		
		function vModificar_Params()
		{
			var sCadenaParams;
			var url;
			var alta_offline;
			
			if (iComprobar_Parametros_UTC() == 0)
			{
				if (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
				{
					alta_offline = 0;
					url = "utc_lectura_params.php";
				}
				else
				{
					alta_offline = 1;
					url = "utc_lecturaDB_params.php";
				}
			
				$('#imagen_espera_mod_params').attr("class", 'mostrado');				
				var gw_id = document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id;
				var direccion = document.getElementById("direccion_485").value;
				url+="?gw_id="+gw_id+"&direccion="+direccion;
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("GET",url,true);
				xmlHttpgrRead.onreadystatechange = function()
				{
					if (xmlHttpgrRead.readyState==4)
					{
						if (xmlHttpgrRead.responseText.substring(0,5) != "ERROR")
						{
							var docUTC=xmlHttpgrRead.responseText;
							var xmlrespuestaUTC = parsear_xml(docUTC);
							var vvxUTC=xmlrespuestaUTC.getElementsByTagName("utc");
							var alarma_alta_cloro_habilitado_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[0].nodeValue;
							var alarma_baja_cloro_habilitado_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[1].nodeValue;
							var delta_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[2].nodeValue;
							var lowpoint_habilitado_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[3].nodeValue;
							var max_habilitado_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[4].nodeValue;
							var alarma_alta_cloro_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[5].nodeValue;
							var alarma_baja_cloro_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[6].nodeValue;
							var setpoint_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[7].nodeValue;
							var lowpoint_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[8].nodeValue;
							var tiempo_medida_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[9].nodeValue;
							var max_lectura = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[10].nodeValue;
							
							url = "utc_modificacion_params.php";
							var gw_id = document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id;
							var direccion = document.getElementById("direccion_485").value;
							url+="?gw_id="+gw_id+"&direccion="+direccion+"&offline="+alta_offline;
							var tiempo_medida = document.getElementById("tiempo_medida").value;
							var setpoint =  document.getElementById("setpoint").value;
							var delta = document.getElementById("delta").selectedIndex;
							var lowpoint =  document.getElementById("punto_bajo").value;
							var lowpoint_habilitado = document.getElementById("habilita_punto_bajo").selectedIndex;
							var max = document.getElementById("tiempo_maximo").value;
							var max_habilitado = document.getElementById("habilita_tiempo_maximo").selectedIndex;
							var alarma_alta_cloro =  document.getElementById("alarma_alta_cloro").value;
							var alarma_alta_cloro_habilitado = document.getElementById("habilita_alarma_alta_cloro").selectedIndex;
							var alarma_baja_cloro =  document.getElementById("alarma_baja_cloro").value;
							var alarma_baja_cloro_habilitado = document.getElementById("habilita_alarma_baja_cloro").selectedIndex;
							var password = document.getElementById("password").value;
							
							if(parseInt(tiempo_medida)!=parseInt(tiempo_medida_lectura) && tiempo_medida!=="")
							{
								url += "&tiempo_medida="+tiempo_medida;
							}
							if(Math.round(setpoint*100)!=setpoint_lectura && setpoint!=="")
							{
								url += "&setpoint="+Math.round(setpoint*100);
							}
							if(parseInt(delta)!=parseInt(delta_lectura) && delta!=="")
							{
								url += "&delta="+delta;
							}
							if(Math.round(lowpoint*100)!=lowpoint_lectura && lowpoint!=="")
							{
								url += "&lowpoint="+Math.round(lowpoint*100);
							}
							if(parseInt(lowpoint_habilitado)!=parseInt(lowpoint_habilitado_lectura) && lowpoint_habilitado!=="")
							{
								url += "&lowpoint_habilitado="+lowpoint_habilitado;
							}
							if(parseInt(max)!=parseInt(max_lectura) && max!=="")
							{
								url += "&max="+max;
							}
							if(parseInt(max_habilitado)!=parseInt(max_habilitado_lectura) && max_habilitado!=="")
							{
								url += "&max_habilitado="+max_habilitado;
							}
							if(Math.round(alarma_alta_cloro*100)!=alarma_alta_cloro_lectura && alarma_alta_cloro!=="")
							{
								url += "&alarma_alta_cloro="+Math.round(alarma_alta_cloro*100);
							}
							if(parseInt(alarma_alta_cloro_habilitado)!=parseInt(alarma_alta_cloro_habilitado_lectura) && alarma_alta_cloro_habilitado!=="")
							{
								url += "&alarma_alta_cloro_habilitado="+alarma_alta_cloro_habilitado;
							}
							if(Math.round(alarma_baja_cloro*100)!=alarma_baja_cloro_lectura && alarma_baja_cloro!=="")
							{
								url += "&alarma_baja_cloro="+Math.round(alarma_baja_cloro*100);
							}
							if(parseInt(alarma_baja_cloro_habilitado)!=parseInt(alarma_baja_cloro_habilitado_lectura) && alarma_baja_cloro_habilitado!=="")
							{
								url += "&alarma_baja_cloro_habilitado="+alarma_baja_cloro_habilitado
							}
							url += "&password="+password;
							xmlHttpgrMod= GetXmlHttpObject();
							xmlHttpgrMod.open("GET",url,true);
							xmlHttpgrMod.onreadystatechange = function()
							{
								if (xmlHttpgrMod.readyState==4)
								{
									$('#imagen_espera_mod_params').attr("class", 'escondido');
									if (xmlHttpgrMod.responseText.substring(0,5) != "ERROR")
									{
										if (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
										{
											var docUTC=xmlHttpgrMod.responseText;
											var xmlrespuestaUTC = parsear_xml(docUTC);
											var vvxUTC=xmlrespuestaUTC.getElementsByTagName("utc");
											var alarma_alta_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[0].nodeValue;
											var alarma_baja_cloro_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[1].nodeValue;
											var delta = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[2].nodeValue;
											var lowpoint_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[3].nodeValue;
											var max_habilitado = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[4].nodeValue;
											var alarma_alta_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[5].nodeValue;
											var alarma_baja_cloro = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[6].nodeValue;
											var setpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[7].nodeValue;
											var lowpoint = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[8].nodeValue;
											var tiempo_medida = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[9].nodeValue;
											var max = xmlrespuestaUTC.getElementsByTagName("utc")[0].attributes[10].nodeValue;
																
											if(tiempo_medida!="")
											{
												document.getElementById("tiempo_medida").value = tiempo_medida;
											}
											if(setpoint!="")
											{
												document.getElementById("setpoint").value = setpoint/100;
											}
											if(delta!="")
											{	
												document.getElementById("delta").selectedIndex = delta;
											}
											if(lowpoint_habilitado!="")
											{
												document.getElementById("habilita_punto_bajo").selectedIndex = lowpoint_habilitado;
											}
											if(max_habilitado!="")
											{
												document.getElementById("habilita_tiempo_maximo").selectedIndex = max_habilitado;
											}
											if(alarma_alta_cloro_habilitado!="")
											{
												document.getElementById("habilita_alarma_alta_cloro").selectedIndex = alarma_alta_cloro_habilitado;
											}
											if(alarma_baja_cloro_habilitado!="")
											{
												document.getElementById("habilita_alarma_baja_cloro").selectedIndex = alarma_baja_cloro_habilitado;
											}
											if(lowpoint!="")
											{
												document.getElementById("punto_bajo").value = lowpoint/100;
											}
											if(max!="")
											{
												document.getElementById("tiempo_maximo").value = max;
											}
											if(alarma_alta_cloro!="")
											{
												document.getElementById("alarma_alta_cloro").value = alarma_alta_cloro/100;
											}
											if(alarma_baja_cloro!="")
											{
												document.getElementById("alarma_baja_cloro").value = alarma_baja_cloro/100;
											}
											
											alert(iObtener_Cadena_AJAX('general22'));
										}
										else
										{
											alert(iObtener_Cadena_AJAX('general360'));
										}
									}
									else
									{
										alert(xmlHttpgrMod.responseText);
									}
								}
							}
							xmlHttpgrMod.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
							xmlHttpgrMod.send();
						}
						else
						{
							alert(xmlHttpgrRead.responseText);
							$('#imagen_espera_mod_params').attr("class", 'escondido');
						}
					}
				}
				xmlHttpgrRead.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xmlHttpgrRead.send();
				
			}
		
		}	
	</script>
</head>

<body>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general14'].' '.$idiomas[$_SESSION['opcion_idioma']]['general255'].' '.$_GET["objeto_ip"]?></span>
			</td>
			<td  align="center">
				<form action="configuracion_utc_imagen.html.php" method="post" name="config_utc_form">
					<input type="hidden" name="disp_id" id="disp_id" value="<?php echo $_GET["objeto_id"]?>">
					<input type="hidden" name="disp_ip" id="disp_ip" value="<?php echo $_GET["objeto_ip"]?>">
					<input type="submit" name="boton_config_imagen_utc" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general191']?>" class="boton_fino_largo" id="boton_imagen"/>
				</form>
			</td>
		</tr>
	</table>
	<div class="rounded-big-box">
	    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
	    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
	    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
	    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
		<div class="box-contents">
		<table border="0" width="98%" cellpadding="0" cellspacing="0" >
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param63']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param64']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param65']?></span>
				</td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center">
					<input type="text" name="nombre_disp" id="nombre_disp" style="width:180px;text-align:center" class="texto_valores" maxlength="20"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<select id="selectGateways" style="margin:0px 0 5px 0;text-align:center" disabled="disabled"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<input type="text" name="direccion_485" id="direccion_485" style="width:80px;text-align:center" class="texto_valores" maxlength="2" disabled="disabled"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<select id="tipo_dispositivo" style="margin:0px 0 5px 0;text-align:center" onchange="vCambiar_Magnitudes()" disabled="disabled"/>
				</td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%;height:5px">
				<td colspan="9"></td>
			</tr>	
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center"></td>
				<td style="width:2%"></td>
				<td colspan="3" align="center">
					<span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general326']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center"></td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center"></td>
				<td style="width:2%"></td>
				<td colspan="3" align="center">
					<select name="HMR" id="HMR" style="width:50px;text-align:center"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center"></td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%;height:10px">
				<td colspan="9"></td>
			</tr>			
		</table>
		<div id="u_tabbar" style="width:98%; height:290px;">
		<div id='params_utc_1'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_magnitudes" name="tipo_magnitudes" style="width:100%;height:260px;overflow:auto"></div>			
					</td>
				</tr>
			</table>
		</div>		
		<div id='params_utc_2'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_notsms" name="tipo_notsms" style="width:100%;height:260px;overflow:auto"></div>			
					</td>
				</tr>
			</table>
		</div>
		<div id='params_utc_3'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_notemail" name="tipo_notemail" style="width:100%;height:320px;overflow:auto"></div>			
					</td>
				</tr>
			</table>	
		</div>
		<div id='params_utc_4'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_config" name="tipo_config" style="width:100%;height:320px;overflow:auto">
							<table style="width:100%">
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general339']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general340']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%"></td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="tiempo_medida" id="tiempo_medida" style="width:30px;text-align:center" class="texto_valores" maxlength="4"/>
										<span class="texto_parametros"> mins</span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="setpoint" id="setpoint" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
										<span class="texto_parametros"> mg/L</span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<select name="delta" id="delta" style="width:60px;text-align:center" class="texto_valores" maxlength="2">
											<option value="0">0.1</option>
											<option value="1">0.2</option>
											<option value="2">0.3</option>
											<option value="3">0.4</option>
											<option value="4">0.5</option>
											<option value="5">0.6</option>
											<option value="6">0.7</option>
											<option value="7">0.8</option>
											<option value="8">0.9</option>
											<option value="9">1.0</option>
											<option value="10">1.5</option>
											<option value="11">2.0</option>
											<option value="12">3.0</option>
											<option value="13">4.0</option>
											<option value="14">5.0</option>
										</select>
										<span class="texto_parametros"> mg/L</span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%"></td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general342']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general344']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general346']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general348']?></span>
									</td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<select name="habilita_punto_bajo" id="habilita_punto_bajo" style="width:60px;text-align:center" class="texto_valores" maxlength="3"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<select name="habilita_tiempo_maximo" id="habilita_tiempo_maximo" style="width:60px;text-align:center" class="texto_valores" maxlength="3"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<select name="habilita_alarma_baja_cloro" id="habilita_alarma_baja_cloro" style="width:60px;text-align:center" class="texto_valores" maxlength="3"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<select name="habilita_alarma_alta_cloro" id="habilita_alarma_alta_cloro" style="width:60px;text-align:center" class="texto_valores" maxlength="3"/>
									</td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general343']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general345']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general347']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general349']?></span>
									</td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="punto_bajo" id="punto_bajo" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
										<span class="texto_parametros"> mg/L</span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="tiempo_maximo" id="tiempo_maximo" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
										<span class="texto_parametros"> </span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="alarma_baja_cloro" id="alarma_baja_cloro" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
										<span class="texto_parametros"> mg/L</span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="text" name="alarma_alta_cloro" id="alarma_alta_cloro" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
										<span class="texto_parametros"> mg/L</span>
									</td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:100%" colspan="9">&nbsp;</td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
									</td>
									<td style="width:2%"></td>
									<td style="width:22%;" align="right">
										<span class="texto_parametros" align="right"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general33']?></span>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%;align:left">
										<input type="text" name="password" id="password" style="width:50px;text-align:center" class="texto_valores" maxlength="4"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
									</td>
									<td style="width:2%"></td>
								</tr>
								<tr style="width:100%">
									<td style="width:100%" colspan="9">&nbsp;</td>
								</tr>
								<tr style="width:100%">
									<td style="width:2%"></td>
									<td style="width:22%">
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="button" onclick="vLeer_Params()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general341']?>" class="boton_fino_medio" id="boton_leerDB"/>
										<img id="imagen_espera" src="images/wait_circle.gif" class="escondido"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%">
										<input type="button" onclick="vModificar_Params()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general350']?>" class="boton_fino_medio" id="boton_leerDB"/>
										<img id="imagen_espera_mod_params" src="images/wait_circle.gif" class="escondido"/>
									</td>
									<td style="width:2%"></td>
									<td style="width:22%"></td>
									<td style="width:2%"></td>
								</tr>
							</table>
						</div>			
					</td>
				</tr>
			</table>	
		</div>
		</div>
		</div>
	</div>
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:25%" align="center">
				<input type="button" onclick="vMarkAll()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general166']?>" class="boton_fino" id="boton_marcar"/>
			</td>
			<td style="width:25%" align="center">
				<input type="button" onclick="vUnMarkAll()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general177']?>" class="boton_fino_medio" id="boton_desmarcar"/>
			</td>
			<td style="width:25%" align="center"></td>
			<td style="width:25%" align="center">
				<input type="button" onclick="Guardar(<?php echo $_GET["objeto_id"]?>)" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general196']?>" class="boton_fino_medio" id="boton_enviar"/>
				<img id="imagen_espera_mod" src="images/wait_circle.gif" class="escondido"/>
			</td>
		</tr>
		<tr style="width:100%">
			<td style="width:25%"></td>
			<td style="width:25%"></td>
			<td style="width:25%"></td>
			<td style="width:25%"></td>
		</tr>
	</table>
	<script type="text/javascript">
		tabbar = new dhtmlXTabBar("u_tabbar", "top");
		tabbar.setSkin('dark_blue');
		tabbar.setImagePath("codebase/imgs/");
		AnchoTabAux=document.getElementById('u_tabbar').offsetWidth/6;
		tabbar.addTab("u1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general104']?>", 0.8*AnchoTabAux);
		tabbar.addTab("u2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general6'].' SMS'?>", 1.6*AnchoTabAux);
		tabbar.addTab("u3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general6'].' '.$idiomas[$_SESSION['opcion_idioma']]['general64']?>", 1.8*AnchoTabAux);
		tabbar.addTab("u4", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general14']?>", 1.2*AnchoTabAux);
		tabbar.setContent("u1", "params_utc_1");
		tabbar.setContent("u2", "params_utc_2");
		tabbar.setContent("u3", "params_utc_3");
		tabbar.setContent("u4", "params_utc_4");
		tabbar.setTabActive("u1");
		Rellenar_CombosYN("HMR");
		Rellenar_CombosYN("habilita_punto_bajo");
		Rellenar_CombosYN("habilita_tiempo_maximo");
		Rellenar_CombosYN("habilita_alarma_baja_cloro");
		Rellenar_CombosYN("habilita_alarma_alta_cloro");
		cargar_tipo_utcs("tipo_dispositivo");
		cargar_gateways("selectGateways",top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
		Rellenar_Valores(<?php echo $_GET["objeto_id"]?>);
		vCargar_Versiones_GW_DB(document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id);
	</script>
</body>
</html>
