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
		function vCargar_Params_Email()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_email.php?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById('db_cliente').value;
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue == 0)
					{
						document.getElementById('email1_on').checked = false;
					}
					else
					{
						document.getElementById('email1_on').checked = true;
					}				
					document.getElementById('email1').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue;
					vSeleccionar_Idioma_Combo('email1_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue);
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue == 0)
					{
						document.getElementById('email2_on').checked = false;
					}
					else
					{
						document.getElementById('email2_on').checked = true;
					}				
					document.getElementById('email2').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
					vSeleccionar_Idioma_Combo('email2_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue);
					document.getElementById('texto_email').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[6].nodeValue;
				}
			}
			xmlHttpParam.open("GET",url,true);
			xmlHttpParam.send(null);
		}
		function vActualizar_params()
		{
			if (document.getElementById('texto_email').value.length > 100)
			{
				alert(iObtener_Cadena_AJAX('error_email1')+' '+document.getElementById('texto_email').value.length);
				return false;
			}
			else if ((document.getElementById('email1_on').checked == true) && (iComprobar_Consulta(document.getElementById('texto_email').value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email2'));
				return false;
			}
			if (document.getElementById('email1').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email14')+' '+document.getElementById('email1').value.length);
				return false;
			}
			else if (iComprobar_Email(document.getElementById('email1').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_email16'));
				return false;
			}
			if (document.getElementById('email2').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email15')+' '+document.getElementById('email2').value.length);
				return false;
			}
			else if ((document.getElementById('email2_on').checked == true) && (iComprobar_Email(document.getElementById('email2').value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email17'));
				return false;
			}
			return true;
		}
		function vCheckTALength()
		{
			var iMax = 100;
			var iLong = document.getElementById('texto_email').value.length;
			if (iLong>iMax)
			{
				document.getElementById('texto_email').value = document.getElementById('texto_email').value.substring(0, iMax);
				return false;
			}
		}
	</script>
</head>

<body>
<form method="post">
<?php
	if ($_POST['Actualizar'])
	{
		include 'inc/datos_db.inc';
				
		$email1=$_POST['email1'];
		if ($_POST['email1_on'] == 'on')
		{
			$email1_on='1';
		}
		else
		{
			$email1_on='0';
		}
		$email1_idioma=$_POST['email1_idioma'];
		$email2=$_POST['email2'];
		if ($_POST['email2_on'] == 'on')
		{
			$email2_on='1';
		}
		else
		{
			$email2_on='0';
		}
		$email2_idioma=$_POST['email2_idioma'];
		$texto_email=$_POST['texto_email'];	

		$link7 = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($_POST['db_cliente'], $link7);
		
		$query="UPDATE cliente_instalaciones SET instalacion_email1='".$email1."', instalacion_email1_on='".$email1_on."', instalacion_email1_idioma='".$email1_idioma."', instalacion_email2_on='".$email2_on."', instalacion_email2='".$email2."', instalacion_email2_idioma='".$email2_idioma."', instalacion_email_texto='".$texto_email."' WHERE instalacion_id='".$_POST['id_instalacion']."'";
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general4']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-big-box">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr style="width:100%">
							<td colspan="8"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td style="width:13%"></td>
							<td style="width:15%" align="center"></td>
							<td style="width:25%" align="center"></td>
							<td style="width:20%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:10%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>							
							<td style="width:13%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td style="width:13%"></td>
							<td style="width:15%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 1:</span>
							</td>
							<td style="width:25%" align="center">
								<input type="text" name="email1" id="email1" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:20%" align="center">
								<select id="email1_idioma" name="email1_idioma" style="width:100px;text-align:center">
									<?php
										include "inc/funciones_indice.inc"; 
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%" align="center">
								<input type="checkbox" name="email1_on" id="email1_on" class="texto_valores"/>
							</td>							
							<td style="width:13%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="8"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td style="width:13%"></td>
							<td style="width:15%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 2:</span>
							</td>
							<td style="width:25%" align="center">
								<input type="text" name="email2" id="email2" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:20%" align="center">
								<select id="email2_idioma" name="email2_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%" align="center">
								<input type="checkbox" name="email2_on" id="email2_on" class="texto_valores"/>
							</td>							
							<td style="width:13%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="8"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td colspan="6" align="left">
								<span class="texto_parametros">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general65']?>:</span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td colspan="6" align="center">
								<textarea name="texto_email" id="texto_email" style="width: 95%" rows="5" cols="18" class="texto_valores" onkeydown="vCheckTALength()" ></textarea>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="8"><br/></td>
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
				<input type="hidden" id="db_cliente" name="db_cliente" value=""/>
				<input type="hidden" id="id_instalacion" name="id_instalacion" value=""/>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	vCargar_Params_Email();
	document.getElementById('db_cliente').value=top.document.getElementById('db_cliente').value;
	document.getElementById('id_instalacion').value=top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
</script>
</body>
</html>