<?php session_start();
include 'inc/idiomas.inc';

$id_cliente = $_GET['id_cliente'];

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
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>	
	<script type="text/javascript">
		function Actualizar_logo()
		{
			var url = "actualizar_logo_cliente.php?id_cliente=<?=$id_cliente?>";
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,false);
			xmlHttpgrRead.send(null);
			
			if (xmlHttpgrRead.responseText=='ERROR')
			{
				alert(iObtener_Cadena_AJAX('error_server6')+" "+iObtener_Cadena_AJAX('general298'));
			}
			window.location='configuracion_cliente_logo.php?id_cliente=<?=$id_cliente?>';
			top.document.getElementById("logo_personalizado").src = "descargar_logo.php?id_cliente=<?=$_SESSION["id_cliente"]?>&inicio=si";
		}
	</script>
</head>

<body>

<?php

	if ($_FILES['archivo']['tmp_name'])
	{
		include 'inc/datos_db.inc';			
		//$tipos = array("image/gif","image/jpeg","image/bmp","image/pjpeg");
		$maximo = 10485760; //10Mb
		if (is_uploaded_file($_FILES['archivo']['tmp_name'])) 
		{ // Se ha subido?
			if ($_FILES['archivo']['size'] <= $maximo) 
			{
				// Es correcto?
				$fp = fopen($_FILES['archivo']['tmp_name'], 'r'); //Abrimos la imagen
				$archivo = fread($fp, filesize($_FILES['archivo']['tmp_name'])); //Extraemos el contenido de la imagen
				$archivo = addslashes($archivo);
				fclose($fp); //Cerramos imagen
				
				$link = mysql_connect($db_host, $db_user,$db_pass);
				
				mysql_select_db($db_name_clientes, $link);
								
				$query="UPDATE clientes_datos SET cliente_logo_aux = '".$archivo."' WHERE cliente_id = '".$id_cliente."'";
				//echo $id_cliente;
				mysql_query($query) or die(mysql_error());
				//echo "<script>alert('Archivo subido correctamente');</script>";
				mysql_close($link);
			}
			else
			{
				 echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['error_server1']."');</script>";
			}
		}
		else 
		{
		  switch($_FILES['archivo']['error']) 
		  {
		    case 1:
		    	echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['error_server2']."');</script>";
		      break;
		    case 2:
		    	echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['error_server3']."');</script>";
		      break;
		    case 3:
		    	echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['error_server4']."');</script>";
		      break;
		    case 4:
		    	echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['error_server5']."');</script>";
		      break;
		  }
		}
	}	

?>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general14'].' '.$idiomas[$_SESSION['opcion_idioma']]['general298']?></span>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">

					<div id='params_logo' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><br/></td></tr>
						</table>
						<form enctype="multipart/form-data" name="config_imagen_form" action="configuracion_cliente_logo.php?id_cliente=<?=$id_cliente?>" method="post">
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:40%" align="center">
												<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>						
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general186']?></span>
											</td>
											<td style="width:10%"></td>
											<td style="width:40%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general187']?></span>
											</td>
											<td style="width:5%"></td>
										</tr>
										<tr>
											<td style="width:5%"></td>
											<td style="width:40%" align="center">
												<img id='imagen_logo_antigua' src='descargar_logo.php?id_cliente=<?=$id_cliente?>' width='222px' height='138px' style='align:center;border:1'></img>
											</td>
											<td style="width:5%"></td>
											<td style="width:40%" align="center" id='celda_imagen'>												
												<?php 
												if ($_FILES['archivo']['tmp_name'])
												{
												?>
												<img id='imagen_logo' src='descargar_logo_aux.php?id_cliente=<?=$id_cliente?>' width='222px' height='138px' style='align:center;border:1'></img>
												<?php 
												}
												else
												{
												?>	
												<img id='imagen_logo' width='222px' height='138px' style="align:center" src='images/sin_imagen.jpg'></img>
												<?php
												}
												?>
											</td>											
											<td style="width:5%"></td>
										</tr>
									</table>
									<table border="0" width="100%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:40%" align="center"></td>
											<td align="right" colspan="3">
												<input type="file" name="archivo" class="boton_fino_file_largo"/>
											</td>											
										</tr>
										<tr>
											<td style="width:5%"></td>
											<td style="width:40%" align="right"></td>
											<td style="width:10%" align="right"></td> 
											<td align="center">
												<input type="submit" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general185']?>" name="boton_preview" class="boton_fino"/>
											</td>
											<td style="width:5%" align="right"></td>
										</tr>
									</table>
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:35%" align="center"><br/></td>
											<td style="width:35%" align="center"></td>
											<td style="width:15%" align="center"></td>
											<td style="width:5%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:35%" align="center"><br/></td>
											<td style="width:35%" align="center"></td>
											<td style="width:15%" align="center">
												<?php 
												if ($_FILES['archivo']['tmp_name'])
												{
												?>
												<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_logo()" class="boton_fino"/>
												<?php 
												}
												else
												{
												?>	
												<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_logo()" disabled="disabled" class="boton_fino"/>
												<?php 
												}
												?>
											</td>
											<td style="width:5%"></td>
										</tr>
									</table>
								</div>
						</div>
						</form>
					</div>

			</td>
		</tr>
	</table>

</body>
</html>
