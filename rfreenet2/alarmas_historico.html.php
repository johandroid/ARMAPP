<?php session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_alarmas.js?time=<?php echo(filemtime("js/funciones_alarmas.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		var Pagina_Actual;
		var Total_Paginas;
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
			Rellenar_Tabla_Alarmas(0);
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