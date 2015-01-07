<?php session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		var Pagina_Actual;
		var Total_Paginas;
		function Rellenar_Tabla_Datos()
		{
			var url;
			var url_datos;
			if((top.document.getElementById("Filtro_combo_Evento").selectedIndex<7) || (top.document.getElementById("Filtro_combo_Evento").selectedIndex==12))
			{
				url_datos = "carga_tabla_datos.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById("db_cliente").value;
			}
			else if (top.document.getElementById("Filtro_combo_Evento").selectedIndex==7)
			{
				url_datos = "carga_tabla_imagenes.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById("db_cliente").value;
			}
			else
			{
				url_datos = "carga_tabla_datos_diarios.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById("db_cliente").value+"&gw_nombre="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].value+"&nodo_nombre="+top.document.getElementById("Filtro_combo_Nodo").options[top.document.getElementById("Filtro_combo_Nodo").selectedIndex].value+"&utc_nombre="+top.document.getElementById("Filtro_combo_UTC").options[top.document.getElementById("Filtro_combo_UTC").selectedIndex].value;
			}
			if (top.document.getElementById("Ver_GW_Check").checked == true)
			{
				url="&ver_gw=1";
			}
			else
			{
				url="&ver_gw=0";
			}

			if (top.document.getElementById("Filtro_combo_GW").selectedIndex==0)
			{
				url+="&gw_id=0000";
			}
			else
			{
				url+="&gw_id="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].id;
			}

			if (top.document.getElementById("Filtro_GWSensor_Check").checked == true)
			{
				if (top.document.getElementById("Filtro_combo_GWSensor").selectedIndex!=-1)
				{
					url+="&GWSensor="+top.document.getElementById("Filtro_combo_GWSensor").options[top.document.getElementById("Filtro_combo_GWSensor").selectedIndex].id;	
				}
				else
				{
					url+="&GWSensor=F";	
				}
			}
			else
			{
				url+="&GWSensor=F";
			}
	
			if (top.document.getElementById("Ver_Nodo_Check").checked == true)
			{
				url+="&ver_nodo=1";
			}
			else
			{
				url+="&ver_nodo=0";
			}

			if (top.document.getElementById("Filtro_combo_Evento").selectedIndex==12)
			{
				url+="&nodo_ip=XXX";
			}
			else if ((top.document.getElementById("Filtro_combo_Nodo").selectedIndex==0) || (top.document.getElementById("Filtro_combo_Nodo").selectedIndex==-1))
			{
				url+="&nodo_ip=F";
			}
			else
			{
				url+="&nodo_ip="+top.document.getElementById("Filtro_combo_Nodo").options[top.document.getElementById("Filtro_combo_Nodo").selectedIndex].id;
			}

			if (top.document.getElementById("Filtro_NodeSensor_Check").checked == true)
			{
				if (top.document.getElementById("Filtro_combo_NodeSensor").selectedIndex!=-1)
				{
					url+="&NodeSensor="+top.document.getElementById("Filtro_combo_NodeSensor").options[top.document.getElementById("Filtro_combo_NodeSensor").selectedIndex].id;	
				}
				else
				{
					url+="&NodeSensor=F";	
				}
			}
			else
			{
				url+="&NodeSensor=F";
			}
			if (top.document.getElementById("Ver_UTC_Check").checked == true)
			{
				url+="&ver_utc=1";
			}
			else
			{
				url+="&ver_utc=0";
			}

			if (top.document.getElementById("Filtro_combo_UTC").selectedIndex==0)
			{
				url+="&utc_id=0000";
			}
			else
			{
				url+="&utc_id="+top.document.getElementById("Filtro_combo_UTC").options[top.document.getElementById("Filtro_combo_UTC").selectedIndex].id;
			}

			if (top.document.getElementById("Filtro_UTCSensor_Check").checked == true)
			{
				if (top.document.getElementById("Filtro_combo_UTCSensor").selectedIndex>0)
				{
					url+="&UTCSensor="+top.document.getElementById("Filtro_combo_UTCSensor").options[top.document.getElementById("Filtro_combo_UTCSensor").selectedIndex].id;	
				}
				else
				{
					url+="&UTCSensor=F";	
				}
			}
			else
			{
				url+="&UTCSensor=F";
			}
			if((top.document.getElementById("Filtro_combo_Evento").selectedIndex>7) && (top.document.getElementById("Filtro_combo_Evento").selectedIndex!=12))
			{
				if(((top.document.getElementById("Ver_GW_Check").checked == true) && (top.document.getElementById("Ver_Nodo_Check").checked == true)) || ((top.document.getElementById("Ver_UTC_Check").checked == true) && (top.document.getElementById("Ver_Nodo_Check").checked == true))  || ((top.document.getElementById("Ver_UTC_Check").checked == true) && (top.document.getElementById("Ver_GW_Check").checked == true)))
				{
					alert(iObtener_Cadena_AJAX('error_datos4'));
					return;
				}
				if(((top.document.getElementById("Ver_GW_Check").checked == true) && ((top.document.getElementById("Filtro_combo_GW").selectedIndex < 1) || (top.document.getElementById("Filtro_GWSensor_Check").checked == false) || (top.document.getElementById("Filtro_combo_GWSensor").selectedIndex<1))) || ((top.document.getElementById("Ver_Nodo_Check").checked == true) && ((top.document.getElementById("Filtro_combo_Nodo").selectedIndex < 1) || (top.document.getElementById("Filtro_NodeSensor_Check").checked == false) || (top.document.getElementById("Filtro_combo_NodeSensor").selectedIndex<1)))  || ((top.document.getElementById("Ver_UTC_Check").checked == true) && ((top.document.getElementById("Filtro_combo_UTC").selectedIndex < 1) || (top.document.getElementById("Filtro_UTCSensor_Check").checked == false) || (top.document.getElementById("Filtro_combo_UTCSensor").selectedIndex<1))) )
				{
					alert(iObtener_Cadena_AJAX('error_datos3'));
					return;
				}
			}
			url+="&evento="+top.document.getElementById("Filtro_combo_Evento").selectedIndex;

			if (top.document.getElementById("Filtro_Fecha_Check").checked == true)
			{
				if ((top.document.getElementById("FechaInicial").value == "") || (top.document.getElementById("FechaFinal").value == ""))
				{
					alert(iObtener_Cadena_AJAX('error_datos1'));
					return;
				}
				if (top.document.getElementById("FechaInicial").value >= top.document.getElementById("FechaFinal").value)
				{
					alert(iObtener_Cadena_AJAX('error_datos2'));
					return;
				}
				if (top.document.getElementById("FechaInicial").value != "")
				{
					url+="&fecha_begin="+top.document.getElementById('FechaInicial').value;
				}
				else
				{
					url+="&fecha_begin=0";
				}
				if (top.document.getElementById("FechaFinal").value != "")
				{
					url+="&fecha_end="+top.document.getElementById('FechaFinal').value;
				}
				else
				{
					url+="&fecha_end=0";
				}				
			}
			else
			{
				url+="&fecha_begin=0&fecha_end=0";
			}

			url+="&pagina="+Pagina_Actual;
			$('#imagen_espera_db').attr("class", 'mostrado');
			xmlHttp2= GetXmlHttpObject();
			urltotal = url_datos+url;
			xmlHttp2.open("GET",urltotal,false);
			xmlHttp2.send(null);
			Total_Paginas = parseFloat(xmlHttp2.responseText.substring(0,8));
			document.getElementById("tabla_datos").innerHTML = xmlHttp2.responseText.substring(8);
			$('#imagen_espera_db').attr("class", 'escondido');
		}

		<?php 
		if ($_GET['pagina'])
		{
			echo "Pagina_Actual=1;";
		}
		?>

		function vActualizarTodo()
		{
			Pagina_Actual = 1;
			vRellenar_Num_Paginas();
		}

		function vRellenar_Num_Paginas()
		{
			Rellenar_Tabla_Datos();
			document.getElementById("span_pagina_actual").innerHTML = Pagina_Actual+" de "+Total_Paginas;			
		}

		function OnClick_Right()
		{
			if (Pagina_Actual < Total_Paginas)
			{
				Pagina_Actual++;
				vRellenar_Num_Paginas();
			}
		}

		function OnClick_Left()
		{
			if (Pagina_Actual > 1)
			{
				Pagina_Actual--;
				vRellenar_Num_Paginas();
			}
		}

		function OnClick_DRight()
		{
			if (Pagina_Actual < Total_Paginas)
			{
				Pagina_Actual = Total_Paginas;
				vRellenar_Num_Paginas();
			}
		}

		function OnClick_DLeft()
		{
			if (Pagina_Actual > 1)
			{
				Pagina_Actual = 1;
				vRellenar_Num_Paginas();
			}
		}
	</script>
</head>

<body>
	<script type="text/javascript" src="js/wz_tooltip.js"></script>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<div id="tabla_datos"></div>
		</td>
	</tr>
	</table>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<input type="hidden" id="PaginaMedidas"></input>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="center" style="width:30%"><br/></td>
					<td align="center" style="width:35%">
						<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="Boton_Actualizar" onclick="vActualizarTodo()" style="text-align:center;width:90px" class="boton_fino"/>
					</td>
					<td align="left" style="width:30%" colspan="2" rowspan="2" valign="top">
						<table border="0" width="100%">
						<tr>
						<td align="left">
							<img id="imagen_espera_db" src="images/wait_circle.gif" class="escondido"/>
						</td>
						<td align="center">
							<img src="images/dflecha_izquierda.png" width="31" height="31" onclick="OnClick_DLeft();"/>
						</td>
						<td align="center">
							<img src="images/flecha_izquierda.png" width="23" height="23" onclick="OnClick_Left();"/>
						</td>
						<td align="center">
							<span id="span_pagina_actual" class="RFNETtextINV"></span>
						</td>
						<td align="center">
							<img src="images/flecha_derecha.png" width="23" height="23" onclick="OnClick_Right();"/>
						</td>
						<td align="center">
							<img src="images/dflecha_derecha.png" width="31" height="31" onclick="OnClick_DRight();"/>
						</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<script>
		vRellenar_Num_Paginas();
	</script>
</body>
</html>