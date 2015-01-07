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
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/dhtmlxcontainer.js"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		function Rellenar_Params_GW_Defecto()
		{
			var iContador;
			document.getElementById("VHW").selectedIndex=0;
			document.getElementById("VSW").selectedIndex=0;
			document.getElementById("NGW").value='';
			document.getElementById("CTA").value='300';
			document.getElementById("CIS").value='89.140.230.109';
			document.getElementById("CID").value='89.140.230.109';
			document.getElementById("CIP").value='6011';
			document.getElementById("CIT").value='6011';
			for (iContador = 0; iContador < 10; iContador++)
			{
				if(iContador < 7)
				{
					document.getElementById("A"+iContador+"K").selectedIndex=0;
					document.getElementById("A"+iContador+"T").value='300';
					document.getElementById("A"+iContador+"W").value='0';
					document.getElementById("A"+iContador+"M").value='10';
					document.getElementById("A"+iContador+"N").value='10';
					document.getElementById("A"+iContador+"P").selectedIndex=0;
					document.getElementById("A"+iContador+"V").selectedIndex=0;
					document.getElementById("A"+iContador+"E").selectedIndex=0;
					document.getElementById("A"+iContador+"U").value='0';
					document.getElementById("A"+iContador+"U_unit").value='';
					document.getElementById("A"+iContador+"L").value='0';
					document.getElementById("A"+iContador+"L_unit").value='';
				}
				if(iContador < 3)
				{
					document.getElementById("M"+iContador+"X").value='0';
					document.getElementById("M"+iContador+"N").value='0';
					document.getElementById("U"+iContador+"D").selectedIndex=0;
				}
				document.getElementById("D"+iContador+"K").selectedIndex=0;
				document.getElementById("D"+iContador+"T").value='300';
				document.getElementById("D"+iContador+"U").value='0';
				document.getElementById("D"+iContador+"C").selectedIndex=0;
				document.getElementById("D"+iContador+"E").selectedIndex=0;
					
				document.getElementById("EH"+iContador).selectedIndex=0;
				document.getElementById("SH"+iContador).selectedIndex=0;
			}
			
			document.getElementById("DAK").selectedIndex=0;
			document.getElementById("DAT").value='300';
			document.getElementById("DAU").value='0';
			document.getElementById("DAC").selectedIndex=0;
			document.getElementById("DAE").selectedIndex=0;
			
			document.getElementById("DBK").selectedIndex=0;
			document.getElementById("DBT").value='300';
			document.getElementById("DBU").value='0';
			document.getElementById("DBC").selectedIndex=0;
			document.getElementById("DBE").selectedIndex=0;
			
			document.getElementById("DCK").selectedIndex=0;
			document.getElementById("DCT").value='300';
			document.getElementById("DCU").value='0';
			document.getElementById("DCC").selectedIndex=0;
			document.getElementById("DCE").selectedIndex=0;
			
			document.getElementById("DDK").selectedIndex=0;
			document.getElementById("DDT").value='300';
			document.getElementById("DDU").value='0';
			document.getElementById("DDC").selectedIndex=0;
			document.getElementById("DDE").selectedIndex=0;
			
			document.getElementById("DEK").selectedIndex=0;
			document.getElementById("DET").value='300';
			document.getElementById("DEU").value='0';
			document.getElementById("DEC").selectedIndex=0;
			document.getElementById("DEE").selectedIndex=0;
			
			document.getElementById("DFK").selectedIndex=0;
			document.getElementById("DFT").value='300';
			document.getElementById("DFU").value='0';
			document.getElementById("DFC").selectedIndex=0;
			document.getElementById("DFE").selectedIndex=0;
				
			for (iContador = 10; iContador < 23; iContador++)
			{
				document.getElementById("EH"+iContador).selectedIndex=0;
				document.getElementById("SH"+iContador).selectedIndex=0;
				document.getElementById("SN"+iContador).value='';
			}
			document.getElementById("HMR").selectedIndex=0;
		}
		
		function Guardar()
		{
			var sCadenaParams;
			var url;

			if (iComprobar_Todos_Valores_Low() == 0)
			{
				if (confirm(iObtener_Cadena_AJAX('gw_text2')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					$('#imagen_espera_mod').attr("class", 'mostrado');
					url = "gw_nuevo_low.php";
					sCadenaParams="paramsGW="+sPrepararCadenaGWLow("NO")+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
					//alert(sCadenaParams);
					xmlHttpgrRead= GetXmlHttpObject();
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
		function OnTabGroupChange(datab)
		{
			caGrupoSensor = datab[0];
			//alert(caGrupoSensor);
			switch(caGrupoSensor)
			{
				case "a2":
					tabbardigital.enableContentZone(false);
					tabbaranalog.enableContentZone(true); 
					tabbaranalog.setTabActive("analog1");
					break;
				case "a3":
					tabbaranalog.enableContentZone(false);
					tabbardigital.enableContentZone(true); 
					tabbardigital.setTabActive("digital1");
					break;
				case "a1":
				default:
					tabbaranalog.enableContentZone(false);
					tabbardigital.enableContentZone(false);
					break; 
			}
		}
	</script>
</head>

<body>
<?php
	if ($_GET['objeto_id'])
	{
		$id_gateway=$_GET['objeto_id']; 
	}
	else
	{
		$id_gateway=$_POST['gw_id']; 
	}
	$iVersiones = 1;
	
	include 'estructura_conf_gw_low.php';
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
			<td colspan="4"></td>
		</tr>
	</table>
	<script type="text/javascript">
		Rellenar_Todos_Tipos_Sensor_GW_LOWA();
		Rellenar_Todos_Tipos_Sensor_GW_LOWD();
		Rellenar_Todos_Tipos_Sensor_GW_LOWALI();
		Rellenar_Todas_Uds_Sensor_GWLOW();		
		Rellenar_CombosYN("HMR");
		Rellenar_Params_GW_Defecto();
	</script>
</body>
</html>
