<?php session_start(); //continuamos session o la creamos si no hay
	include "inc/idiomas.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>	
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<link rel="stylesheet" href="js/datepicker/datepicker.css" type="text/css"/>
	<link rel="stylesheet" href="js/timepicker/timepicker.css" type="text/css"/>
	<link rel="stylesheet" href="css/protoplasm.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/protoplasm2.js"></script>
	<script type="text/javascript" src="js/datepicker/datepicker.js"></script>
	<script type="text/javascript" src="js/timepicker/timepicker.js"></script>
	<script type="text/javascript">
		var Pagina_Actual;
		var Total_Paginas;
		function Rellenar_Tabla_Datos()
		{
			var url = "carga_diario.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;

			url+="&pagina="+Pagina_Actual;
			
			if(top.document.getElementById("FechaInicial").value != "" && top.document.getElementById("FechaFinal").value != "")				
			{
				if (top.document.getElementById("FechaInicial").value >= top.document.getElementById("FechaFinal").value)
				{
					alert(iObtener_Cadena_AJAX('error_datos2'));
					return;
				}
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
			xmlHttp2= GetXmlHttpObject();
			xmlHttp2.open("GET",url,false);
			xmlHttp2.send(null);
			Total_Paginas = parseFloat(xmlHttp2.responseText.substring(0,8));
			document.getElementById("tabla_datos").innerHTML = xmlHttp2.responseText.substring(8);
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});				
		}

		<?php 
		if (!$_GET['pagina'])
		{
			echo "Pagina_Actual=1;";
		}
		?>

		function vActualizarTodo()
		{
			Pagina_Actual = 1;
			vRellenar_Num_Paginas();
						
		}
		function vEnviar()
		{
			Pagina_Actual = 1;
			if(document.getElementById("Operador").value != "" && document.getElementById("FechaDiario").value != "" && document.getElementById("FechaDiario").value !="" )
			{
				//alert(document.getElementById("FechaDiario").value);

				var url = "actualizar_diario.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
				
				url+="&operador="+document.getElementById("Operador").value+"&mensaje="+document.getElementById("Mensaje").value+"&fecha="+document.getElementById("FechaDiario").value;

				xmlHttp2= GetXmlHttpObject();
				xmlHttp2.open("GET",url,false);
				xmlHttp2.send(null);
				
				vRellenar_Num_Paginas();								
				
			}
			else
			{
				//AMB 05/06/12 Si no hay ningún dato completado no consideramos el alta
				if(!(document.getElementById("Operador").value == "" && document.getElementById("FechaDiario").value == "" && document.getElementById("FechaDiario").value =="") )
				{
					alert(iObtener_Cadena_AJAX('error_datos5'));
				}
				else
				{
					vRellenar_Num_Paginas();					
				}
			}
		
						
		}		

		function vRellenar_Num_Paginas()
		{
			//alert(Pagina_Actual+" de "+Total_Paginas);
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
		function borrar_comando(id_comando)
		{
			var answer = confirm(iObtener_Cadena_AJAX('confirm_text1'));
			if (answer){
				var url = "diario_eliminar.php?diario_id="+id_comando+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
				xmlHttp2= GetXmlHttpObject();
				xmlHttp2.open("GET",url,false);
				xmlHttp2.send(null);
	
				if(xmlHttp2.responseText.substring(0,5)=="ERROR")
				{
					alert("Error eliminando comando");
				}
			}
			vRellenar_Num_Paginas();
		}
	</script>
</head>

<body>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<form method="post">
	<table border="0" width="100%">

	<tr>
		<td align="center">
			<span><?=$idiomas[$_SESSION['opcion_idioma']]['general301']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			 <!-- <iframe width='650px' height='350px' marginheight="0" marginwidth="0"  frameborder="0" name="tabla_vista" id="tabla_vista" src='carga_cola_envios.html.php?instalacion_id=<?php echo $_GET['instalacion_id']?>&cliente_db=<?php echo $_SESSION['cliente_db']?>'></iframe>-->
			 <div id="tabla_datos">
			 </div>
		</td>
	</tr>
	<tr>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="center" style="width:30%"><br/></td>
					<td align="center" style="width:35%">
						<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" id="Boton_Enviar" onclick="vEnviar()" style="text-align:center;width:90px" class="boton_fino"/>
					</td>
					<td align="left" style="width:30%" colspan="2" rowspan="2" valign="top">
						<table border="0" width="100%">
						<tr>
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
	</tr>
	</table>
</form>
<script type="text/javascript">	
	vRellenar_Num_Paginas();
</script>
</body>
</html>