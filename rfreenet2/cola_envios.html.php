<?php session_start(); //continuamos session o la creamos si no hay
	include "inc/idiomas.inc";
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
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
	var Pagina_Actual;
	var Total_Paginas;
	var timerupdate;
	function Rellenar_Tabla_Datos()
		{
			var url = "carga_cola_envios.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;

			url+="&pagina="+Pagina_Actual;
			$('#imagen_espera_db').attr("class", 'mostrado');
			xmlHttp2= GetXmlHttpObject();
			xmlHttp2.open("GET",url,false);
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
			var url = "comando_eliminar.php?comando_id="+id_comando+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
			$('#imagen_espera_db').attr("class", 'mostrado');
			xmlHttp2= GetXmlHttpObject();
			xmlHttp2.open("GET",url,false);
			xmlHttp2.send(null);
			if(xmlHttp2.responseText.substring(0,5)=="ERROR")
			{
				alert("Error eliminando comando");
			}
			$('#imagen_espera_db').attr("class", 'escondido');
			vRellenar_Num_Paginas();
		}
		function vUpdate_Queue()
		{
			vRellenar_Num_Paginas();
			timerupdate=setTimeout("vUpdate_Queue()",5000);
		}
	</script>
</head>

<body onload="setTimeout('vUpdate_Queue()',5000)">
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<form method="post">
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?=$idiomas[$_SESSION['opcion_idioma']]['general284']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			 <div id="tabla_datos"></div>
		</td>
	</tr>
	<tr>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<input type="hidden" id="PaginaMedidas"></input>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="center" style="width:30%"><br/></td>
					<td align="center" style="width:35%">
						<!--<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="Boton_Actualizar" onclick="vActualizarTodo()" style="text-align:center;width:90px" class="boton_fino"/>-->
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
	</tr>
	</table>
</form>
<script type="text/javascript">
	
	vRellenar_Num_Paginas();
</script>
</body>
</html>