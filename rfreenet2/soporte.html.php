<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_email.inc';
	include 'inc/funciones_indice.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vActualizar_soporte()
		{
			var iEnteroAux;
			if (document.getElementById('Nombre').value.length == 0)
			{
				alert(iObtener_Cadena_AJAX('error_soporte1'));
				return false;
			}
			else if (iComprobar_Nombre(document.getElementById('Nombre').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_soporte12'));
				return false;
			}
			if (document.getElementById('eMail').value.length == 0)
			{
				alert(iObtener_Cadena_AJAX('error_soporte3'));
				return false;
			}
			else if (iComprobar_Email(document.getElementById('eMail').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_soporte4'));
				return false;
			}
			if (document.getElementById('Asunto').value.length == 0)
			{
				alert(iObtener_Cadena_AJAX('error_soporte5'));
				return false;
			}
			else if (iComprobar_Nombre(document.getElementById('Asunto').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_soporte6'));
				return false;
			}
			if (document.getElementById('Texto_Peticion').value.length == 0)
			{
				alert(iObtener_Cadena_AJAX('error_soporte7'));
				return false;
			}
			else if (iComprobar_Consulta(document.getElementById('Texto_Peticion').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_soporte8'));
				return false;
			}
			return true;
		}
	</script>
		
</head>

<body>
	<?php
	if ($_POST['Enviar_Peticion'])
	{
		$usuario_mod=$_SESSION['usuario'];
		$nivel_privilegio=$_SESSION['perfil'];
		$id_cliente=$_SESSION['id_cliente'];
		
		$nombre_peticion=$_POST['Nombre'];
		$texto_peticion=$_POST['Texto_Peticion'];	
		$email_subject = $_POST['Asunto'];
		$email_response = $_POST['eMail'];
		
		if ($TLS == 1)
		{
			$cadena_seguridad = '-S smtp-use-starttls';
		}
		else
		{
			$cadena_seguridad = '';
		}
		
		$Cadena_Final=$idiomas[$_SESSION['opcion_idioma']]['general240']." ".$nombre_peticion." ".$idiomas[$_SESSION['opcion_idioma']]['general241']." ".$usuario_mod." ".$idiomas[$_SESSION['opcion_idioma']]['general204']." ".Mostrar_Nivel_Privilegios($nivel_privilegio)." ".$idiomas[$_SESSION['opcion_idioma']]['general202']." ".$id_cliente.".<br/>".$texto_peticion."<br/>".$idiomas[$_SESSION['opcion_idioma']]['general242']." ".$email_response;
		$cadena_mail = "sendemail -f ".$email_source." -t ".$email_target." -s ".$smtp_servidor.":".$smtp_port." -xu ".$smtp_user." -xp ".$smtp_pw." -u \"".$email_subject."\" -m \"".$header_email.$Cadena_Final.$footer_email."\" > /dev/null";
		//echo "<script>alert(\"".$cadena_mail."\");</script>";
		//echo $cadena_mail;
		system($cadena_mail);
		//mail('carmelo.garcia@balmart.es','Ole','tricotrin');
		echo "<script>alert('".utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general199'])."');</script>";
	}
?>
<form name="soporte_form" action="soporte.html.php" method="post">
	<table border="0" width="100%">
		<tr>
			<td style="width:10%"><br/></td>
			<td style="width:80%"><br/></td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"><br/></td>
			<td style="width:80%" align="center">
				<span><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['soporte_text1'])?></span>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"><br/></td>
			<td style="width:80%"><br/></td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"><br/></td>
			<td style="width:80%">
				<table border="0" width="100%">
					<tr style="width:100%">
						<td style="width:10%"><br/></td>
						<td style="width:40%">
							&nbsp;&nbsp;&nbsp;<span><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general38'])?></span>&nbsp;&nbsp;&nbsp;
						</td>
						<td style="width:40%">
							<input type="text" name="Nombre" id="Nombre" style="width:180px;text-align:center" class="texto_valores" maxlength="20"/>
						</td>
						<td style="width:10%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:10%"><br/></td>
						<td style="width:40%">
							&nbsp;&nbsp;&nbsp;<span><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general43'])?></span>&nbsp;&nbsp;&nbsp;
						</td>
						<td style="width:40%">
							<input type="text" name="eMail" id="eMail" style="width:180px;text-align:center" class="texto_valores" maxlength="50"/>
						</td>
						<td style="width:10%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:10%"><br/></td>
						<td style="width:40%">
							&nbsp;&nbsp;&nbsp;<span><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general13'])?></span>&nbsp;&nbsp;&nbsp;
						</td>
						<td style="width:40%">
							<input type="text" name="Asunto" id="Asunto" style="width:180px;text-align:center" class="texto_valores" maxlength="100"/>
						</td>
						<td style="width:10%"><br/></td>
					</tr>
				</table>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"><br/></td>
			<td style="width:80%"><br/></td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td style="width:80%">
				&nbsp;&nbsp;&nbsp;<span><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general18'])?></span>
			</td>
			<td style="width:10%"><br/></td>
		</tr>
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center"><textarea name="Texto_Peticion" id="Texto_Peticion" style="width: 95%;resize:none" rows="10" value='<?php echo $_POST['Texto_Peticion'];?>?>'></textarea></td>
			<td><br/></td>
		</tr>
		<tr style="width:100%">
			<td><br/></td>
			<td align="center">
				<table border="0" width="100%">
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%"><br/></td>
						<td style="width:40%"><br/></td>
						<td style="width:25%"><br/></td>
						<td style="width:5%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%" align="center"></td>
						<td style="width:40%"></td>
						<td style="width:25%" align="center">
							<input type="submit" name="Enviar_Peticion" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55']?>" class="boton_fino"  onclick="soporte_form.action='soporte.html.php';return vActualizar_soporte();"/>
						</td>
						<td style="width:5%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%"></td>
						<td style="width:40%"></td>
						<td style="width:25%"></td>
						<td style="width:5%"><br/></td>
					</tr>
				</table>
			</td>
			<td><br/></td>
		</tr>
	</table>
	</form>
</body>
</html>