<?session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		var instalacion_id='<?php echo $_GET['objeto_id']?>';
		function vCargar()
		{
			var vvx;
			var xmlHttpGw;
			var xmlHttpNodo;
			var xmlHttpUTC;
			var sNombreCombo;
			xmlHttpGw= GetXmlHttpObject();
			xmlHttpNodo= GetXmlHttpObject();
			xmlHttpUTC= GetXmlHttpObject();
			var url = "carga_vista_general_medidas_gw.html.php?instalacion_id="+instalacion_id;
			xmlHttpGw.onreadystatechange=function()
			{
				if (xmlHttpGw.readyState==4)
				{
					var doc=xmlHttpGw.responseText;
					document.getElementById("tabla_vista_gw").innerHTML = doc;
				}
			}
			xmlHttpGw.open("GET",url,true);
			xmlHttpGw.send(null);
			
			var url2 = "carga_vista_general_medidas_nodo.html.php?instalacion_id="+instalacion_id;
			xmlHttpNodo.onreadystatechange=function()
			{
				if (xmlHttpNodo.readyState==4)
				{
					var doc=xmlHttpNodo.responseText;
					document.getElementById("tabla_vista_nodo").innerHTML = doc;
				}
			}
			xmlHttpNodo.open("GET",url2,true);
			xmlHttpNodo.send(null);
			
			/*var url3 = "carga_vista_general_medidas_utc.html.php?instalacion_id="+instalacion_id;
			xmlHttpUTC.onreadystatechange=function()
			{
				if (xmlHttpUTC.readyState==4)
				{
					var doc=xmlHttpUTC.responseText;
					document.getElementById("tabla_vista_utc").innerHTML = doc;
				}
			}
			xmlHttpUTC.open("GET",url3,true);
			xmlHttpUTC.send(null);*/
			
			setTimeout("vCargar()",300000);
		}
		
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general19'].' '.sObtener_Nombre_Instalación($_GET['objeto_id'], $_SESSION['cliente_db'])?></span>
		</td>
	</tr>
	<tr>
		<td align="left">
			<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general11']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div width='650px' marginheight="0" marginwidth="0"  frameborder="0" id="tabla_vista_gw" style="height:180px;overflow-y: scroll"></div>
		</td>
	</tr>
	<tr>
		<td align="left">
			<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general12']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div width='650px' marginheight="0" marginwidth="0"  frameborder="0" id="tabla_vista_nodo" style="height:180px;overflow-y: scroll"></div>
		</td>
	</tr>
	<!--<tr>
		<td align="left">
			<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general254']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div width='650px' marginheight="0" marginwidth="0"  frameborder="0" id="tabla_vista_utc" style="height:120px;overflow-y: scroll"></div>
		</td>
	</tr>-->
	</table>
	<script type="text/javascript">
		vCargar();
	</script>
</body>
</html>