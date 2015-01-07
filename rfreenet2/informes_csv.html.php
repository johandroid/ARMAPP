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
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_informes.js?time=<?php echo(filemtime("js/funciones_informes.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function iComprobar_Controles_Informe()
		{
			if (top.document.getElementById("FechaInicial").value == "")
			{
				alert(iObtener_Cadena_AJAX('error_graf6'));
				return 1;
			}
			else if (top.document.getElementById("FechaFinal").value == "")
			{
				alert(iObtener_Cadena_AJAX('error_graf7'));
				return 1;
			}
			else if ((top.document.getElementById("Filtro_combo_Dispositivo").options.length == 0) || (top.document.getElementById("Filtro_combo_Dispositivo").selectedIndex == -1))
			{
				alert(iObtener_Cadena_AJAX('error_graf8'));
				return 1;
			}
			else if ((top.document.getElementById("Filtro_combo_Evento").options.length == 0) || (top.document.getElementById("Filtro_combo_Evento").selectedIndex == -1))
			{
				alert(iObtener_Cadena_AJAX('error_graf9'));
				return 1;
			}
			else
			{
				return 0;
			}
		}
		function Rellenar_Informe()
		{
			var now = new Date();
			if (iComprobar_Controles_Informe() == 0)
			{ 				
				var url = "carga_informe_excel.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById("db_cliente").value;
				url+="&"+now.getTime();
				url+="&fecha_begin="+top.document.getElementById('FechaInicial').value;
				url+="&fecha_end="+top.document.getElementById('FechaFinal').value;
				url+="&id_dispositivo="+top.document.getElementById("Filtro_combo_Dispositivo").options[top.document.getElementById("Filtro_combo_Dispositivo").selectedIndex].value;
				url+="&evento="+top.document.getElementById("Filtro_combo_Evento").selectedIndex;
				window.open(url,'Download');			
			}	
		}

	</script>
</head>

<body>
	<div id='caja_instrucciones'>
		<table border="0" style="height:400px" width='100%'>
			<tr>
				<td style="width:20%"></td>
				<td align="center" style="width:60%">
					<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['report_text6']?></span>
				</td>
				<td style="width:20%"></td>
			</tr>
		</table>
	</div>
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<img id="informe" src=""></img>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general219']?>" id="Boton_Actualizar" onclick="Rellenar_Informe()" style="text-align:center;width:90px" class="boton_fino"/>
		</td>
	</tr>
	</table>
<script type="text/javascript">
</script>
</body>
</html>