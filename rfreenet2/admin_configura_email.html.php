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
		function vCargar_Params_Email_Admin()
		{
			var xmlHttpParam;
			var sNombreCombo;
			xmlHttpParam= GetXmlHttpObject();
			var url = "carga_params_admin_email.php";
			xmlHttpParam.onreadystatechange=function()
			{
				if (xmlHttpParam.readyState==4)
				{
					var doc=xmlHttpParam.responseText;
					var xmlrespuesta = parsear_xml(doc);
					x=xmlrespuesta.getElementsByTagName("configuracion");
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[0].nodeValue == 0)
					{
						document.getElementById('email_tecnico1_on').checked = false;
					}
					else
					{
						document.getElementById('email_tecnico1_on').checked = true;
					}
					document.getElementById('email_tecnico1').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[1].nodeValue;
					vSeleccionar_Idioma_Combo('email_tecnico1_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[2].nodeValue);
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[3].nodeValue == 0)
					{
						document.getElementById('email_tecnico2_on').checked = false;
					}
					else
					{
						document.getElementById('email_tecnico2_on').checked = true;
					}
					document.getElementById('email_tecnico2').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[4].nodeValue;
					vSeleccionar_Idioma_Combo('email_tecnico2_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[5].nodeValue);
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[6].nodeValue == 0)
					{
						document.getElementById('email_ventas1_on').checked = false;
					}
					else
					{
						document.getElementById('email_ventas1_on').checked = true;
					}				
					document.getElementById('email_ventas1').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[7].nodeValue;
					vSeleccionar_Idioma_Combo('email_ventas1_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[8].nodeValue);
					if (xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[9].nodeValue == 0)
					{
						document.getElementById('email_ventas2_on').checked = false;
					}
					else
					{
						document.getElementById('email_ventas2_on').checked = true;
					}				
					document.getElementById('email_ventas2').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[10].nodeValue;
					vSeleccionar_Idioma_Combo('email_ventas2_idioma', xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[11].nodeValue);
					document.getElementById('texto_email').value=xmlrespuesta.getElementsByTagName("configuracion")[0].attributes[12].nodeValue;
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
			else if (iComprobar_Nombre(document.getElementById("texto_email").value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_email2'));
				return false;
			}
			if (document.getElementById('email_tecnico1').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email3')+' '+document.getElementById('email_tecnico1').value.length);
				return false;
			}
			else if ((document.getElementById('email_tecnico1_on').checked == true) && (document.getElementById('email_tecnico1').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_email4'));
				return false;
			}
			else if ((document.getElementById('email_tecnico1').value.length > 0) && (iComprobar_Email(document.getElementById("email_tecnico1").value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email5'));
				return false;
			}
			if (document.getElementById('email_tecnico2').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email6')+' '+document.getElementById('email_tecnico2').value.length);
				return false;
			}
			else if ((document.getElementById('email_tecnico2_on').checked == true) && (document.getElementById('email_tecnico2').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_email7'));
				return false;
			}
			else if ((document.getElementById('email_tecnico2').value.length > 0) && (iComprobar_Email(document.getElementById("email_tecnico2").value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email8'));
				return false;
			}
			if (document.getElementById('email_ventas1').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email9')+' '+document.getElementById('email_ventas1').value.length);
				return false;
			}
			else if ((document.getElementById('email_ventas1_on').checked == true) && (document.getElementById('email_ventas1').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_email18'));
				return false;
			}
			else if ((document.getElementById('email_ventas1').value.length > 0) && (iComprobar_Email(document.getElementById("email_ventas1").value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email10'));
				return false;
			}
			if (document.getElementById('email_ventas2').value.length > 40)
			{
				alert(iObtener_Cadena_AJAX('error_email11')+' '+document.getElementById('email_ventas2').value.length);
				return false;
			}
			else if ((document.getElementById('email_ventas2_on').checked == true) && (document.getElementById('email_ventas2').value.length == 0))
			{
				alert(iObtener_Cadena_AJAX('error_email12'));
				return false;
			}
			else if ((document.getElementById('email_ventas2').value.length > 0) && (iComprobar_Email(document.getElementById("email_ventas2").value) == -1))
			{
				alert(iObtener_Cadena_AJAX('error_email13'));
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
				
		$email_tecnico1=$_POST['email_tecnico1'];
		if ($_POST['email_tecnico1_on'] == 'on')
		{
			$email_tecnico1_on='1';
		}
		else
		{
			$email_tecnico1_on='0';
		}
		$email_tecnico1_idioma=$_POST['email_tecnico1_idioma'];
		$email_tecnico2=$_POST['email_tecnico2'];
		if ($_POST['email_tecnico2_on'] == 'on')
		{
			$email_tecnico2_on='1';
		}
		else
		{
			$email_tecnico2_on='0';
		}
		$email_tecnico2_idioma=$_POST['email_tecnico2_idioma'];
		$email_ventas1=$_POST['email_ventas1'];
		if ($_POST['email_ventas1_on'] == 'on')
		{
			$email_ventas1_on='1';
		}
		else
		{
			$email_ventas1_on='0';
		}
		$email_ventas1_idioma=$_POST['email_ventas1_idioma'];
		$email_ventas2=$_POST['email_ventas2'];
		if ($_POST['email_ventas2_on'] == 'on')
		{
			$email_ventas2_on='1';
		}
		else
		{
			$email_ventas2_on='0';
		}
		$email_ventas2_idioma=$_POST['email_ventas2_idioma'];
		$texto_email=$_POST['texto_email'];	

		$link7 = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($db_name_general, $link7);
		
		$query="UPDATE rfreenet_config_email SET email_tecnico1='".$email_tecnico1."', email_tecnico1_on='".$email_tecnico1_on."', email_tecnico1_idioma='".$email_tecnico1_idioma."', email_tecnico2='".$email_tecnico2."', email_tecnico2_on='".$email_tecnico2_on."', email_tecnico2_idioma='".$email_tecnico2_idioma."', email_ventas1='".$email_ventas1."', email_ventas1_on='".$email_ventas1_on."', email_ventas1_idioma='".$email_ventas1_idioma."', email_ventas2='".$email_ventas2."', email_ventas2_on='".$email_ventas2_on."', email_ventas2_idioma='".$email_ventas2_idioma."', email_texto='".$texto_email."'";
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
			<div class="rounded-big-box" style="width:95%">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
							<td colspan="9"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general61']?></span>
							</td>
							<td style="width:5%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:10%"></td>
							<td align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general63']?></span>
							</td>
							<td style="width:5%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%;height:5px">
							<td colspan="9"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:7%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 1:</span>
							</td>
							<td style="width:25%" align="center">
								<input type="text" name="email_tecnico1" id="email_tecnico1" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:5%" align="center">
								<input type="checkbox" name="email_tecnico1_on" id="email_tecnico1_on" class="texto_valores"/>
							</td>
							<td style="width:10%"></td>
							<td style="width:7%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 1:</span>
							</td>														
							<td style="width:25%" align="center">
								<input type="text" name="email_ventas1" id="email_ventas1" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:5%" align="center">
								<input type="checkbox" name="email_ventas1_on" id="email_ventas1_on" class="texto_valores"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%;height:5px">
							<td colspan="9"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:7%" align="center"></td>
							<td style="width:25%" align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
								<select id="email_tecnico1_idioma" name="email_tecnico1_idioma" style="width:100px;text-align:center">
									<?php
										include "inc/funciones_indice.inc"; 
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%"></td>
							<td style="width:7%"></td>														
							<td align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
								<select id="email_ventas1_idioma" name="email_ventas1_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="9"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:7%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 2:</span>
							</td>
							<td style="width:25%" align="center">
								<input type="text" name="email_tecnico2" id="email_tecnico2" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:5%" align="center">
								<input type="checkbox" name="email_tecnico2_on" id="email_tecnico2_on" class="texto_valores"/>
							</td>
							<td style="width:10%"></td>
							<td style="width:7%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general64']?> 2:</span>
							</td>														
							<td style="width:25%" align="center">
								<input type="text" name="email_ventas2" id="email_ventas2" style="width:150px;text-align:center" class="texto_valores" maxlength="40"/>
							</td>
							<td style="width:5%" align="center">
								<input type="checkbox" name="email_ventas2_on" id="email_ventas2_on" class="texto_valores"/>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%;height:5px">
							<td colspan="9"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td style="width:7%" align="center"></td>
							<td style="width:25%" align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
								<select id="email_tecnico2_idioma" name="email_tecnico2_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:10%"></td>
							<td style="width:7%"></td>														
							<td style="width:25%" align="center" colspan="2">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
								<select id="email_ventas2_idioma" name="email_ventas2_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="9"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"></td>
							<td colspan="7" align="left">
								<span class="texto_parametros">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general65']?>:</span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:2%"></td>
							<td colspan="7" align="center">
								<textarea name="texto_email" id="texto_email" style="width: 95%" rows="5" cols="18" class="texto_valores" onkeydown="vCheckTALength()" ></textarea>
							</td>
							<td style="width:5%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="9"><br/></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<table border="0" style="width:100%">
		<tr style="width:100%">
			<td colspan="5"><br/></td>
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
	vCargar_Params_Email_Admin();
</script>
</body>
</html>