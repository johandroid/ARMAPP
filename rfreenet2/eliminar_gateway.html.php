<?php session_start();
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
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		function OnConfirmarEliminar()
		{
			if (confirm(iObtener_Cadena_AJAX('gw_text4')+" <?php echo $_GET['objeto_id']?>\r\n"+iObtener_Cadena_AJAX('general0')))
			{
				$('#imagen_espera_mod').attr("class", 'mostrado');
				document.getElementById('boton_enviar').disabled="disabled";
				var url = "gw_eliminar.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id=<?php echo $_GET['objeto_id']?>";
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("GET",url,false);
				xmlHttpgrRead.send(null);
				$('#imagen_espera_mod').attr("class", 'escondido');
				document.getElementById('boton_enviar').disabled="";
				alert(xmlHttpgrRead.responseText);
				window.parent.rellenar_div_principal(7,"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
				window.parent.cargar_gateways("comboGateways",top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
			}
		}
	</script>
</head>

<body>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3" style="height:100px"><br/></td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general56'].' '.$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$_GET['objeto_id']?></span>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="height:50px"><br/></td>
		</tr>
		<tr>
			<td style="width:15%"></td>
			<td style="width:70%" align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['gw_text5'].'.'?></span>
			</td>
			<td style="width:15%"></td>
		</tr>
		<tr>
			<td colspan="3" style="height:50px"><br/></td>
		</tr>
		<tr>
			<td style="width:15%" align="center"></td>
			<td style="width:70%" align="center">
				<input type="button" onclick="OnConfirmarEliminar()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general56']?>" class="boton_fino" id="boton_enviar"/>
				<img id="imagen_espera_mod" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:15%" align="center"></td>
		</tr>
	</table>
</body>
</html>