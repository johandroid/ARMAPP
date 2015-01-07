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
		function vCargar_Params_RX_Admin()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_admin_sms.php";
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue == 0)
					{
						document.getElementById('telf1_on').checked = false;
					}
					else
					{
						document.getElementById('telf1_on').checked = true;
					}				
					document.getElementById('telf1').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue;
					vSeleccionar_Idioma_Combo('telf1_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue);
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue == 0)
					{
						document.getElementById('telf2_on').checked = false;
					}
					else
					{
						document.getElementById('telf2_on').checked = true;
					}				
					document.getElementById('telf2').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
					vSeleccionar_Idioma_Combo('telf2_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue);
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vActualizar_params()
		{
			if (document.getElementById('telf1').value.length > 24)
			{
				alert(iObtener_Cadena_AJAX('error_sms1')+' '+document.getElementById('telf1').value.length);
				return false;
			}
			else if ((document.getElementById('telf1_on').checked == true) && (document.getElementById('telf1').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_sms2'));
				return false;
			}
			else if ((document.getElementById('telf1').value.length > 0) && (iComprobar_Telefono(document.getElementById("telf1").value,16) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_sms3'));
				return false;
			}
			if (document.getElementById('telf2').value.length > 24)
			{
				alert(iObtener_Cadena_AJAX('error_sms4')+' '+document.getElementById('telf2').value.length);
				return false;
			}
			else if ((document.getElementById('telf2_on').checked == true) && (document.getElementById('telf2').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_sms5'));
				return false;
			}
			else if ((document.getElementById('telf2').value.length > 0) && (iComprobar_Telefono(document.getElementById("telf2").value,16) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_sms6'));
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
<form method="post">
<?php
	if ($_POST['Actualizar'])
	{
		include 'inc/datos_db.inc';

		$telf1=$_POST['telf1'];
		
		if ($_POST['telf1_on'] == 'on')
		{
			$telf1_on='1';
		}
		else
		{
			$telf1_on='0';
		}
		$telf1_idioma=$_POST['telf1_idioma'];
		$telf2=$_POST['telf2'];
		if ($_POST['telf2_on'] == 'on')
		{
			$telf2_on='1';
		}
		else
		{
			$telf2_on='0';
		}
		$telf2_idioma=$_POST['telf2_idioma'];
		$link7 = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($db_name_general, $link7);
		
		$query="UPDATE rfreenet_config_sms SET sms_telf1_on='".$telf1_on."', sms_telf1='".$telf1."',sms_telf1_idioma='".$telf1_idioma."',sms_telf2_on='".$telf2_on."',sms_telf2='".$telf2."',sms_telf2_idioma='".$telf2_idioma."'";
		//echo $query;
		mysql_query($query) or die(mysql_error());
		echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link7);
	}
?>
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general3']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-little-box" style="width:70%">
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
							<td style="width:5%"></td>
							<td style="width:30%" align="left"></td>
							<td style="width:20%" align="left"></td>
							<td style="width:30%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:10%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:30%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general39']?> 1</span>
							</td>							
							<td style="width:20%" align="center">
								<input type="text" name="telf1" id="telf1" style="width:130px;text-align:center" class="texto_valores" maxlength="24"/>
							</td>
							<td style="width:20%" align="center">
								<select id="telf1_idioma" name="telf1_idioma" style="width:100px;text-align:center">
									<?php
										include "inc/funciones_indice.inc"; 
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%" align="center">
								<input type="checkbox" name="telf1_on" id="telf1_on" class="texto_valores"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="5"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:30%" align="left">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general39']?> 2</span>
							</td>							
							<td style="width:30%" align="center">
								<input type="text" name="telf2" id="telf2" style="width:130px;text-align:center" class="texto_valores" maxlength="24"/>
							</td>
							<td style="width:20%" align="center">
								<select id="telf2_idioma" name="telf2_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%" align="center">
								<input type="checkbox" name="telf2_on" id="telf2_on" class="texto_valores"/>
							</td>
							<td style="width:5%"></td>
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
	vCargar_Params_RX_Admin();
</script>
</body>
</html>