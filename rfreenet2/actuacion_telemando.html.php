<?php
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';
include 'inc/funciones_indice.inc';

$instalacion = $_GET["instalacion_id"];
$gw_id = $_GET["objeto_id"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_telemando.js?time=<?php echo(filemtime("js/funciones_telemando.js"));?>"></script>
	<script type="text/javascript">
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function vLeerActTM(sGWID)
		{
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_telemando;?>))
			{
				var sUrl;
				var xmlHttpgrInstSensor;
				sUrl = "carga_actuacion_telemando.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+sGWID;
				xmlHttpgrInstSensor= GetXmlHttpObject();
				xmlHttpgrInstSensor.open("GET",sUrl,false);
				xmlHttpgrInstSensor.send(null);
				if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
				{
					alert(xmlHttpgrInstSensor.responseText);
				}
				else
				{
					$("#carga_actua_tm").html(xmlHttpgrInstSensor.responseText);
				}
			}
			else
			{
				document.getElementById('boton_UpdateTM').disabled = 'disabled';
				$('#boton_actua_tm').empty();
				alert(iObtener_Cadena_AJAX('error_gw81'));
			}
		}
		function vActuaTM()
		{
			var url;
			var iAccion;
			var xmlHttpgrTM;
			var caIP;
			iAccion = 0;
			$('#imagen_espera_leer').attr("class", 'mostrado');
			$('#carga_actua_tm input[type=checkbox], .sys select').each(function()
			{
				if (this.checked == true)
				{
					caIP = this.id.substring(0,3);
					if (caIP == '000')
					{
						sComando = "O<?php echo $gw_id;?>"+this.id.substring(3,4)+$('#S'+this.id).prop('selectedIndex');
					}
					else
					{
						sComando = "O<?php echo $gw_id;?>N"+caIP+this.id.substring(3,4)+$('#S'+this.id).prop('selectedIndex');
					}
					url = "enviar_comando_offline.php?gw_id=<?php echo $gw_id;?>&nodo_ip="+caIP+"&comando="+sComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
					xmlHttpgrTM= GetXmlHttpObject();
					xmlHttpgrTM.open("GET",url,false);
					xmlHttpgrTM.send(null);
					iAccion++;
				}
			});
			$('#imagen_espera_leer').attr("class", 'escondido');
			if (iAccion > 0)
			{
				alert(iObtener_Cadena_AJAX('general366'));
			}
		}
	</script>
</head>
<body>
	<div id="carga_actua_tm" style="height:440px;overflow-y: scroll"></div>
	<div id="boton_actua_tm" style="height:440px;overflow-y: scroll">
		<table width="100%" border="0">
			<tr>
				<td style="height:25px" colspan="3"></td>
			</tr>
			<tr>
				<td style="width:25%"></td>
				<td style="width:50%" align="center">
					<input type="button" onclick="vActuaTM()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" class="boton_fino" id="boton_UpdateTM"/>
					<img id="imagen_espera_leer" src="images/wait_circle.gif" class="escondido"/>
				</td>
				<td style="width:25%"></td>
			</tr>
		</table>
	</div>
	<script>
		vCargar_Versiones_GW_DB("<?php echo $gw_id;?>");
		vLeerActTM("<?php echo $gw_id;?>");
	</script>
</body>
</html>
