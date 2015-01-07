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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript" src="js/funciones_submenu.js?time=<?php echo(filemtime("js/funciones_submenu.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_utc.js?time=<?php echo(filemtime("js/funciones_utc.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>		
	<script type="text/javascript">
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function Guardar()
		{
			var sCadenaParams;
			var url;
			var alta_offline;
			if (iComprobar_Valores_UTC() == 0)
			{
				if (confirm(iObtener_Cadena_AJAX('utc_text1')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					$('#imagen_espera_mod').attr("class", 'mostrado');
					var nombre = document.getElementById("nombre_disp").value;
					var gw_id = document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id;
					var direccion = document.getElementById("direccion_485").value;
					var reposicion = document.getElementById("HMR").selectedIndex;
					var tipo_utc = document.getElementById("tipo_dispositivo").options[document.getElementById("tipo_dispositivo").selectedIndex].id;
					if (caVGWSW < <?php include 'inc/datos_db.inc';echo $version_offline;?>)
					{
						alta_offline = 0;
					}
					else
					{
						alta_offline = 1;
					}
					url = "utc_nuevo.php";
					sCadenaParams="nombre="+nombre+"&gw_id="+gw_id+"&HMR="+reposicion+"&offline="+alta_offline+"&direccion="+direccion+"&tipo_utc="+tipo_utc+"&magnitudes="+sPrepararCadenaMagnitudes("magnitudes")+"&magnitudesSMS="+sPrepararCadenaMagnitudes("magnitudesSMS")+"&magnitudesEMAIL="+sPrepararCadenaMagnitudes("magnitudesEMAIL")+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
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
									window.parent.rellenar_div_principal(25,"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&objeto_id="+xmlHttpgrRead.responseText+"&objeto_ip="+document.getElementById("direccion_485").value);
								<?php
							 	}
								 else
							 	{
								?>
									alert(iObtener_Cadena_AJAX('general255')+" "+xmlHttpgrRead.responseText+" "+iObtener_Cadena_AJAX('general95'));
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
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general52'].' '.$idiomas[$_SESSION['opcion_idioma']]['general255']?></span>
			</td>
		</tr>
	</table>
	<div class="rounded-big-box">
	    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
	    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
	    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
	    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
		<div class="box-contents">
		<table border="0" width="98%" cellpadding="0" cellspacing="0" >
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param63']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param64']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param65']?></span>
				</td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center">
					<input type="text" name="nombre_disp" id="nombre_disp" style="width:180px;text-align:center" class="texto_valores" maxlength="20"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<select id="selectGateways" style="margin:0px 0 5px 0;text-align:center" onchange="vCargar_Versiones_GW_DB(document.getElementById('selectGateways').options[document.getElementById('selectGateways').selectedIndex].id)"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<input type="text" name="direccion_485" id="direccion_485" style="width:80px;text-align:center" class="texto_valores" maxlength="2"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center">
					<select id="tipo_dispositivo" style="margin:0px 0 5px 0;text-align:center" onchange="vCambiar_Magnitudes()"/>
				</td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%;height:5px">
				<td colspan="9"></td>
			</tr>	
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center"></td>
				<td style="width:2%"></td>
				<td colspan="3" align="center">
					<span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general326']?></span>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center"></td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%">
				<td style="width:2%"></td>
				<td style="width:30%" align="center"></td>
				<td style="width:2%"></td>
				<td colspan="3" align="center">
					<select name="HMR" id="HMR" style="width:50px;text-align:center"/>
				</td>
				<td style="width:2%"></td>
				<td style="width:20%" align="center"></td>
				<td style="width:2%"></td>
			</tr>
			<tr style="width:100%;height:10px">
				<td colspan="9"></td>
			</tr>			
		</table>
		<div id="u_tabbar" style="width:98%; height:290px;">
		<div id='params_utc_1'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_magnitudes" name="tipo_magnitudes" style="width:100%;height:260px;overflow:auto"></div>			
					</td>
				</tr>
			</table>
		</div>		
		<div id='params_utc_2'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_notsms" name="tipo_notsms" style="width:100%;height:260px;overflow:auto"></div>			
					</td>
				</tr>
			</table>
		</div>
		<div id='params_utc_3'>
			<table border="0" width="98%">
				<tr style="width:100%">
					<td style="width:100%">
						<div id="tipo_notemail" name="tipo_notemail" style="width:100%;height:320px;overflow:auto"></div>			
					</td>
				</tr>
			</table>	
		</div>
		</div>
		</div>
	</div>
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:25%" align="center">
				<input type="button" onclick="vMarkAll()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general166']?>" class="boton_fino" id="boton_marcar"/>
			</td>
			<td style="width:25%" align="center">
				<input type="button" onclick="vUnMarkAll()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general177']?>" class="boton_fino_medio" id="boton_desmarcar"/>
			</td>
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
		tabbar = new dhtmlXTabBar("u_tabbar", "top");
		tabbar.setSkin('dark_blue');
		tabbar.setImagePath("codebase/imgs/");
		AnchoTabAux=document.getElementById('u_tabbar').offsetWidth/6;
		tabbar.addTab("u1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general104']?>", 0.8*AnchoTabAux);
		tabbar.addTab("u2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general6'].' SMS'?>", 1.6*AnchoTabAux);
		tabbar.addTab("u3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general6'].' '.$idiomas[$_SESSION['opcion_idioma']]['general64']?>", 1.8*AnchoTabAux);
		tabbar.setContent("u1", "params_utc_1");
		tabbar.setContent("u2", "params_utc_2");
		tabbar.setContent("u3", "params_utc_3");
		tabbar.setTabActive("u1");
		Rellenar_CombosYN("HMR");
		cargar_tipo_utcs("tipo_dispositivo");
		vCambiar_Magnitudes();
		cargar_gateways("selectGateways",top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
		document.getElementById('HMR').selectedIndex = 0;
		vCargar_Versiones_GW_DB(document.getElementById("selectGateways").options[document.getElementById("selectGateways").selectedIndex].id);
	</script>
</body>
</html>
