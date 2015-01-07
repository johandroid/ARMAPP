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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vCargar_Params_RX()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_rx.php?cliente_db=" + top.document.getElementById("db_cliente").value;
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");				
					document.getElementById('timeout_gw').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue;
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue <= 1)
					{
						document.getElementById('timeout_gw_unit').selectedIndex=0;
					}
					else
					{
						document.getElementById('timeout_gw_unit').selectedIndex=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue - 1;
					}
					document.getElementById('timeout_nodo').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue;
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue <= 1)
					{
						document.getElementById('timeout_nodo_unit').selectedIndex=0;
					}
					else
					{
						document.getElementById('timeout_nodo_unit').selectedIndex=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue - 1;
					}
					document.getElementById('timeout_trama').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue <= 1)
					{
						document.getElementById('timeout_trama_unit').selectedIndex=0;
					}
					else
					{
						document.getElementById('timeout_trama_unit').selectedIndex=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue - 1;
					}
					document.getElementById('timeout_utc').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[6].nodeValue;
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[7].nodeValue <= 1)
					{
						document.getElementById('timeout_utc_unit').selectedIndex=0;
					}
					else
					{
						document.getElementById('timeout_utc_unit').selectedIndex=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[7].nodeValue - 1;
					}
					document.getElementById('soap_habilitado').checked=(xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[8].nodeValue==1?true:false);
					document.getElementById('soap_ip').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[9].nodeValue;
					document.getElementById('soap_puerto').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[10].nodeValue;
					document.getElementById('soap_contexto').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[11].nodeValue;
				
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		
		function vActualizar_params()
		{
			if ((document.getElementById('timeout_gw').value.length > 0) && (document.getElementById('timeout_nodo').value.length>0))
			{
				if (iComprobar_Port(document.getElementById("timeout_gw").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config8')+' (1-65535)');
					return false;
				}
				else if (iComprobar_Port(document.getElementById("timeout_nodo").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config9')+' (1-65535)');
					return false;
				}
				else if (iComprobar_Port(document.getElementById("timeout_trama").value) == -1)
				{
					alert('El valor del timeout de Avisador es erróneo (1-65535)');
					return false;
				}
				else if (iComprobar_Port(document.getElementById("timeout_utc").value) == -1)
				{
					alert(iObtener_Cadena_AJAX('error_config10')+' (1-65535)');
					return false;
				}	
				else if ((document.getElementById('soap_habilitado').checked) && (iComprobar_Port(document.getElementById("soap_puerto").value) == -1))
				{
					alert(iObtener_Cadena_AJAX('error_config11')+' (1-65535)');
					return false;
				}	
				else if ((document.getElementById('soap_habilitado').checked) && (iComprobar_IP(document.getElementById("soap_ip").value) == -1))
				{
					alert(iObtener_Cadena_AJAX('error_config12'));
					return false;
				}				
				return true;
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_config4'));
				return false;
			}
		}

		function vRellenar_Combo_TO(m_COMBO)
		{
			document.getElementById(m_COMBO).length = 0;
        	//insertarOptionCombo(m_COMBO,"0",iObtener_Cadena_AJAX('general136'));
        	insertarOptionCombo(m_COMBO,"1",iObtener_Cadena_AJAX('general135'));
        	insertarOptionCombo(m_COMBO,"2",iObtener_Cadena_AJAX('general134'));
        	insertarOptionCombo(m_COMBO,"3",iObtener_Cadena_AJAX('general176'));
            document.getElementById(m_COMBO).selectedIndex = 0;
		}

		function vRellenar_Unidades_TO()
		{
			vRellenar_Combo_TO('timeout_gw_unit');
			vRellenar_Combo_TO('timeout_nodo_unit');
			vRellenar_Combo_TO('timeout_trama_unit');
			vRellenar_Combo_TO('timeout_utc_unit');
		}
	</script>
</head>

<body>
<form method="post">
<?php
	session_start();
	include 'inc/idiomas.inc';
	if ($_POST['Actualizar'])
	{
		$to_gw=$_POST['timeout_gw'];		
		$to_nodo=$_POST['timeout_nodo'];
		$to_trama=$_POST['timeout_trama'];
		$to_utc=$_POST['timeout_utc'];
		switch ($_POST['timeout_gw_unit'])
		{
			case $idiomas[$_SESSION['opcion_idioma']]['general135']:
				$to_gw_unit=1;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general134']:
				$to_gw_unit=2;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general176']:
				$to_gw_unit=3;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general136']:
				$to_gw_unit=0;
				break;
		}
		switch ($_POST['timeout_nodo_unit'])
		{
			case $idiomas[$_SESSION['opcion_idioma']]['general135']:
				$to_nodo_unit=1;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general134']:
				$to_nodo_unit=2;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general176']:
				$to_nodo_unit=3;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general136']:
				$to_nodo_unit=0;
				break;
		}
		switch ($_POST['timeout_trama_unit'])
		{
			case $idiomas[$_SESSION['opcion_idioma']]['general135']:
				$to_trama_unit=1;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general134']:
				$to_trama_unit=2;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general176']:
				$to_trama_unit=3;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general136']:
				$to_trama_unit=0;
				break;			
		}		
		switch ($_POST['timeout_utc_unit'])
		{
			case $idiomas[$_SESSION['opcion_idioma']]['general135']:
				$to_utc_unit=1;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general134']:
				$to_utc_unit=2;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general176']:
				$to_utc_unit=3;
				break;
			case $idiomas[$_SESSION['opcion_idioma']]['general136']:
				$to_utc_unit=0;
				break;
		}
		if($_POST['soap_habilitado'])
		{
			$soap_hab=1;
			$soap_ip=$_POST['soap_ip'];
			$soap_port=$_POST['soap_puerto'];
			$soap_contexto=$_POST['soap_contexto'];
			$query="UPDATE cliente_config SET config_timeout_gw='".$to_gw."', config_timeout_nodo='".$to_nodo."', config_timeout_trama='".$to_trama."', config_timeout_utc='".$to_utc."',config_timeout_gw_unit='".$to_gw_unit."', config_timeout_nodo_unit='".$to_nodo_unit."', config_timeout_trama_unit='".$to_trama_unit."', config_timeout_utc_unit='".$to_utc_unit."', config_soap_habilitado='".$soap_hab."', config_soap_ip='".$soap_ip."', config_soap_puerto='".$soap_port."',config_soap_contexto='".$soap_contexto."'";
		}
		else
		{
			$soap_hab=0;
			$query="UPDATE cliente_config SET config_timeout_gw='".$to_gw."', config_timeout_nodo='".$to_nodo."', config_timeout_trama='".$to_trama."', config_timeout_utc='".$to_utc."',config_timeout_gw_unit='".$to_gw_unit."', config_timeout_nodo_unit='".$to_nodo_unit."', config_timeout_trama_unit='".$to_trama_unit."', config_timeout_utc_unit='".$to_utc_unit."', config_soap_habilitado='".$soap_hab."'";
		}
		include 'inc/datos_db.inc';
		$link = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
		
		//$query="UPDATE cliente_config SET config_timeout_gw='".$to_gw."', config_timeout_nodo='".$to_nodo."', config_timeout_trama='".$to_trama."', config_timeout_utc='".$to_utc."',config_timeout_gw_unit='".$to_gw_unit."', config_timeout_nodo_unit='".$to_nodo_unit."', config_timeout_trama_unit='".$to_trama_unit."', config_timeout_utc_unit='".$to_utc_unit."', config_soap_habilitado='".$soap_hab."', config_soap_ip='".$soap_ip."', config_soap_puerto='".$soap_port."',config_soap_contexto='".$soap_contexto."'";
		//echo $query;
		mysql_query($query) or die(mysql_error());
		
		echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link);
	}
?>
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general75']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-little-box">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general178']?></span>
							</td>
							<td style="width:20%" align="center">
								<input type="text" name="timeout_gw" id="timeout_gw" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:15%">
								<select name="timeout_gw_unit" id="timeout_gw_unit" style="width:75px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general179']?></span>
							</td>
							<td style="width:20%" align="center">
								<input type="text" name="timeout_nodo" id="timeout_nodo" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:15%">
								<select name="timeout_nodo_unit" id="timeout_nodo_unit" style="width:75px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">							
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general283']?></span>
							</td>
							<td style="width:20%" align="center">
								<input type="text" name="timeout_trama" id="timeout_trama" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:15%">
								<select name="timeout_trama_unit" id="timeout_trama_unit" style="width:75px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">							
							<td colspan="5"><br/></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general261']?></span>
							</td>
							<td style="width:20%" align="center">
								<input type="text" name="timeout_utc" id="timeout_utc" style="width:60px;text-align:center" class="texto_valores" maxlength="5"/>
							</td>
							<td style="width:15%">
								<select name="timeout_utc_unit" id="timeout_utc_unit" style="width:75px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general307']?></span>
							</td>
							<td style="width:20%" align="left">
								<input type="checkbox" name="soap_habilitado" id="soap_habilitado" class="texto_valores"/>
							</td>
							<td style="width:15%">
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general308']?></span>
							</td>
							<td style="width:35%" colspan="2">
								<input type="text" name="soap_ip" id="soap_ip" style="width:120px;text-align:center" class="texto_valores" maxlength="20"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>					
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general309']?></span>
							</td>
							<td style="width:35%" colspan="2">
								<input type="text" name="soap_puerto" id="soap_puerto" style="width:120px;text-align:center" class="texto_valores" maxlength="6"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>						
						<tr style="width:100%">
							<td style="width:1%"></td>
							<td style="width:48%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general310']?></span>
							</td>
							<td style="width:35%" colspan="2">
								<input type="text" name="soap_contexto" id="soap_contexto" style="width:120px;text-align:center" class="texto_valores" maxlength="20"/>
							</td>
							<td style="width:1%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<table border="0" style="width:100%">
		<tr style="width:100%">
			<td style="width:10%"><br/></td>
			<td style="width:25%"></td>
			<td style="width:30%"><br/></td>
			<td style="width:25%"></td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr style="width:100%">
			<td style="width:10%"><br/></td>
			<td style="width:25%"></td>
			<td style="width:30%"><br/></td>
			<td style="width:25%" align="center">
				<input type="submit" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" id="boton_upload" onclick="return vActualizar_params();" class="boton_fino"/>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	vRellenar_Unidades_TO();
	vCargar_Params_RX();	
</script>
</body>
</html>