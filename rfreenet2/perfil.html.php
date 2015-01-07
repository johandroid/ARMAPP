<?php session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_indice.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vActualizar_user()
		{
			if (confirm(iObtener_Cadena_AJAX('config_text7')+"\r\n"+iObtener_Cadena_AJAX('general0')))
			{
				if (document.getElementById("nombre_pw1").value == document.getElementById("nombre_pw2").value)
				{
					xmlHttpuser = GetXmlHttpObject();
					url = "usuario_modifica_pw.php?&usuario_pw=" + document.getElementById("nombre_pw1").value;
					xmlHttpuser.onreadystatechange=function()
					{
						if (xmlHttpuser.readyState==4)
						{
							alert(xmlHttpuser.responseText);
						}
					}
					xmlHttpuser.open("GET",url,true);
					xmlHttpuser.send(null);
				}
				else
				{
					alert(iObtener_Cadena_AJAX('error_user7'));
				}
			}
		}
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general239']?></span>
		</td>
	</tr>
	<tr>
		<td align="center"><br></br></td>
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
							<td style="width:15%"></td>
							<td style="width:70%" align="center">
								<span class="texto_parametros"><?php echo $_SESSION['usuario']?></span>
							</td>
							<td style="width:15%"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:15%"></td>
							<td style="width:70%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general238'].' '.Mostrar_Nivel_Privilegios($_SESSION['perfil']);?></span>
							</td>
							<td style="width:15%"></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:15%" class="left_tborder"><br/></td>
							<td style="width:70%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general33']?></span>
							</td>
							<td style="width:15%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:15%" class="left_tborder"><br/></td>
							<td style="width:70%" align="center">
								<input type="password" id="nombre_pw1" style="width:150px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:15%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:15%" class="left_tborder"><br/></td>
							<td style="width:70%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general34']?></span>
							</td>
							<td style="width:15%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:15%" class="left_tborder"><br/></td>
							<td style="width:70%" align="center">
								<input type="password" id="nombre_pw2" style="width:150px;text-align:center" class="texto_valores"/>
							</td>
							<td style="width:15%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder"><br/></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td align="center"><br></br></td>
	</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center"></td>			
			<td style="width:10%"><br/></td>
			<td style="width:20%" align="center"></td>
			<td style="width:20%" align="center">
				<input type="button" name="Actualizar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="vActualizar_user();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
</body>
</html>