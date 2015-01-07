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
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript">
		function Rellenar_Params_GW_Defecto()
		{
			var iContador;
			
			document.getElementById("VHW").selectedIndex=0;
			document.getElementById("VSW").selectedIndex=0;
			
			document.getElementById("TS1").selectedIndex=0;
			document.getElementById("TS2").selectedIndex=0;
			document.getElementById("TS3").selectedIndex=0;
			document.getElementById("TS4").selectedIndex=0;
			document.getElementById("TS5").selectedIndex=0;
			document.getElementById("TS6").selectedIndex=0;
			document.getElementById("TS7").selectedIndex=0;
			document.getElementById("TS8").selectedIndex=0;
			document.getElementById("TS9").selectedIndex=0;
			document.getElementById("HPS").selectedIndex=0;
			document.getElementById("DHP").selectedIndex=0;
			document.getElementById("TCH").selectedIndex=1;
			document.getElementById("GSH").selectedIndex=0;
			document.getElementById("GPH").selectedIndex=0;
			document.getElementById("MTP").selectedIndex=0;
			document.getElementById("HMR").selectedIndex=0;
			document.getElementById("KEY").value='00';
			document.getElementById("IPP").value='192.168.1.100';
			document.getElementById("MSK").value='255.255.255.0';
			document.getElementById("PDE").value='192.168.1.1';
			document.getElementById("TPP").value='0';
			document.getElementById("ITC").value='30';
			document.getElementById("ITP").value='300';
			document.getElementById("IPX").value='89.140.230.109';
			document.getElementById("IPY").value='89.140.230.109';
			document.getElementById("PRX").value='6011';
			document.getElementById("PRY").value='6001';
			document.getElementById("PGU").value='5011';
			document.getElementById("PGT").value='5001';
			document.getElementById("GSX").value='600000000';
			document.getElementById("GSY").value='600000000';
			document.getElementById("IPZ").value='89.140.230.109';
			document.getElementById("IPW").value='89.140.230.109';
			for (iContador = 1; iContador < 10; iContador++)
			{
				document.getElementById("T"+iContador+"M").value='300';
				document.getElementById("T"+iContador+"S").value='600';
				document.getElementById("P"+iContador+"X").value='5000';
				document.getElementById("P"+iContador+"N").value='0';
				document.getElementById("M"+iContador+"X").value='0';
				document.getElementById("M"+iContador+"N").value='0';				
				document.getElementById("EH"+iContador).selectedIndex=0;
				document.getElementById("SH"+iContador).selectedIndex=0;
			}
		}
		
		function Guardar()
		{
			var sCadenaParams;
			var url;

			if (iComprobar_Todos_Valores() == 0)
			{
				if (confirm(iObtener_Cadena_AJAX('gw_text2')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					$('#imagen_espera_mod').attr("class", 'mostrado');
					url = "gw_nuevo.php";
					sCadenaParams="paramsGW="+sPrepararCadenaGW("NO", document.getElementById("VHW").options[document.getElementById("VHW").selectedIndex].value)+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
					xmlHttpgrRead= GetXmlHttpObject();
					//alert(sCadenaParams);
					xmlHttpgrRead.open("POST",url,true);
					xmlHttpgrRead.onreadystatechange = function() 
					{
						if (xmlHttpgrRead.readyState==4)
						{
							$('#imagen_espera_mod').attr("class", 'escondido');
							if (xmlHttpgrRead.responseText.substring(0,5) != "ERROR")
							{
								<?php 
								if (iObtenerModoOffline() == 0)
								{
								?>
									window.parent.rellenar_div_principal(20,"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&objeto_id="+xmlHttpgrRead.responseText);
								<?php
								 }
								 else
								 {
								?>
									alert(iObtener_Cadena_AJAX('general20')+" "+xmlHttpgrRead.responseText+" "+iObtener_Cadena_AJAX('general95'));
								<?php
								 } 
								?>
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
			}
			else
			{
				alert(iObtener_Cadena_AJAX('general96'));
			}
		}
	</script>
</head>

<body>
<?php
	$iVersiones = 1;
	$iHabUTC = 1;
	$iHabModbusTCP = 1;
	include 'estructura_conf_gw.php';
?>	
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:25%" align="center"></td>
			<td style="width:25%" align="center"></td>
			<td style="width:25%" align="center"></td>
			<td style="width:25%" align="center">
				<input type="button" onclick="Guardar()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" class="boton_fino" id="boton_enviar"/>
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
		OnVersionChange(0);
		Rellenar_Todas_Uds_Sensor_GW();	
		sRellenar_CombosYN(vRellenar_Combos_YN_GW);
		Rellenar_Params_GW_Defecto();
	</script>
</body>
</html>
