<?php session_start();
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
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function Actualizar_imagen_UTC()
		{
			var url = "actualizar_imagen_utc.php?disp_id="+document.getElementById('disp_id').value+'&cliente_db=<?php echo $_SESSION['cliente_db']?>';
			//alert(url);
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,false);
			xmlHttpgrRead.send(null);
			//alert(xmlHttpgrRead.responseText);
			if (xmlHttpgrRead.responseText=='ERROR')
			{
				alert(iObtener_Cadena_AJAX('error_server6')+" "+iObtener_Cadena_AJAX('general21'));
			}
			window.location='configuracion_utc_imagen.html.php?disp_id='+document.getElementById('disp_id').value;
		}

	</script>
</head>

<body>
<?php
	if ($_GET['disp_id'])
	{
		$id_disp=$_GET['disp_id'];
	}
	else
	{
		$id_disp=$_POST['disp_id'];
	}
	
	if ($_POST['boton_preview'])
	{	
		if ($_FILES['archivo']['tmp_name'])
		{	
			include 'inc/datos_db.inc';			
			//$tipos = array("image/gif","image/jpeg","image/bmp","image/pjpeg");
			$maximo = 10485760; //10Mb
			if (is_uploaded_file($_FILES['archivo']['tmp_name'])) 
			{ // Se ha subido?
				if ($_FILES['archivo']['size'] <= $maximo) 
				{ // Es correcto?	
					$fp = fopen($_FILES['archivo']['tmp_name'], 'r'); //Abrimos la imagen
					$archivo = fread($fp, filesize($_FILES['archivo']['tmp_name'])); //Extraemos el contenido de la imagen
					$archivo = addslashes($archivo);		
					fclose($fp); //Cerramos imagen
					$link = mysql_connect($db_host, $db_user,$db_pass);
					mysql_select_db($_SESSION['cliente_db'], $link);	
					$query="DELETE FROM cliente_aux WHERE gw_id='".$id_disp."'";;
					//echo $query;
					mysql_query($query) or die(mysql_error());
					$query="INSERT INTO cliente_aux VALUES ('','".$id_disp."','000000000000','".$archivo."','')";
					//echo $query;
					mysql_query($query) or die('2--'.mysql_error());
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
	}
	
?>

	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center"><br/></td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general180'].' '.$idiomas[$_SESSION['opcion_idioma']]['general21'].' '.$id_disp?></span>
			</td>
		</tr>
	</table>
	
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">
				<div class="rounded-big-box">
				    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
				    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
				    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
				    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
					<div class="box-contents">
						<form enctype="multipart/form-data" name="config_imagen_form" action="configuracion_utc_imagen.html.php" method="post">
						<table border="0" width="550px" cellpadding="0" cellspacing="0">
							<tr>					
								<td style="width:10%"></td>	
								<td style="width:25%"><br/></td>								
								<td style="width:35%" align="right">
									<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>									
									<input type="hidden" id="disp_id" name="disp_id" value="<?php echo $id_disp?>"/>
								</td>
								<td style="width:25%"></td>		
								<td style="width:10%"><br/></td>				
							</tr>
							<tr>
								<td colspan="5">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:40%" align="center">
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
												<img id='imagen_utc_antigua' src='descargar_imagen_utc.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&disp_id=<?php echo $id_disp?>' width='155px' height='150px' style='align:center;border:1'></img>
											</td>
											<td style="width:5%"></td>
											<td style="width:40%" align="center" id='celda_imagen'>
												<?php 
												if (($_POST['boton_preview']) && ($_FILES['archivo']['tmp_name']))
												{
												?>
												<img id='imagen_nodo' src='descargar_imagen_utc_aux.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&disp_id=<?php echo $id_disp?>' width='155px' height='150px' style='align:center;border:1'></img>
												<?php 
												}
												else
												{
												?>	
												<img id='imagen_utc' width='155px' height='150px' style='align:center' src='images/sin_imagen.jpg'></img>
												<?php
												}
												?>
											</td>											
											<td style="width:5%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:5%"></td>
											<td style="width:40%" align="center"><br/></td>
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
								</td>
							</tr>
							<tr style="width:100%"><td align="center" colspan="5"><br/></td></tr>
							<tr style="width:100%">
								<td style="width:10%"><br/></td>
								<td style="width:25%" align="center"></td>
								<td style="width:30%"><br/></td>
								<td style="width:25%" align="center">
									<?php 
									if (($_POST['boton_preview']) && ($_FILES['archivo']['tmp_name']))
									{
									?>
									<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_UTC()" class="boton_fino"/>
									<?php 
									}
									else
									{
									?>	
									<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_UTC()" disabled="disabled" class="boton_fino"/>
									<?php 
									}
									?>
								</td>
								<td style="width:10%"><br/></td>
							</tr>
						</table>
						</form>
					</div>					
				</div>
			</td>
		</tr>	
	</table>
	<form name="config_imagen_form2" action="configuracion_utc.html.php" method="get">
	<table border="0" width="100%">	
		<tr style="width:100%">
			
			<td style="width:5%"></td>
			<td style="width:40%" align="center">
				<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>									
				<input type="hidden" id="objeto_id" name="objeto_id" value="<?php echo $id_disp?>"/>
			</td>
			<td style="width:10%"></td>
			<td style="width:40%" align="center">
				<input type="submit" name="boton_config_basica_utc" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general181']?>" class="boton_fino_muy_largo" onclick="config_imagen_form2.action='configuracion_utc.html.php';return true;"/>
			</td>
			<td style="width:5%"></td>
		</tr>		
	</table>
	</form>
</script>
</body>
</html>
