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
		function Actualizar_imagen_Gw()
		{
			var url = "actualizar_imagen_gw.php?gw_id="+document.getElementById('gw_id').value+'&cliente_db=<?php echo $_SESSION['cliente_db']?>';
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,false);
			xmlHttpgrRead.send(null);
			//alert(xmlHttpgrRead.responseText);
			if (xmlHttpgrRead.responseText=='ERROR')
			{
				alert(iObtener_Cadena_AJAX('error_server6')+" "+iObtener_Cadena_AJAX('general20'));
			}
			window.location='configuracion_gw_imagen.html.php?gw_id='+document.getElementById('gw_id').value;
		}

		function Rellenar_Controles_Tooltip_GW(sParametrosGW)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;

			sPrincipal=parsear_xml(sParametrosGW.responseText);
			if (sPrincipal != null)
			{
				sListaNombres=sPrincipal.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipal.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
				
					switch (sNombreParam.substring(0,2))
					{
						case "MI":
							if (sValorParam==1)
							{
								document.getElementById('show_image').checked=true;
							}
							else
							{
								document.getElementById('show_image').checked=false;	
							}
							break;
						case "MS":
							if (sValorParam==1)
							{
								document.getElementById('show_s'+sNombreParam.substring(2)).checked=true;
							}
							else
							{
								document.getElementById('show_s'+sNombreParam.substring(2)).checked=false;	
							}
							break;
							
						default:
							break;						
					}
				}
			}
		}

		var xmlHttpgrReadTT;
		function OnLeerTooltipGW()
		{			
			var url = "gw_lectura_tooltip.php?gw_id="+document.getElementById('gw_id').value+"&cliente_db=<?php echo $_SESSION['cliente_db']?>";
			xmlHttpgrReadTT= GetXmlHttpObject();
			xmlHttpgrReadTT.open("GET",url,true);

			xmlHttpgrReadTT.onreadystatechange=function()
			{
				if (xmlHttpgrReadTT.readyState==4)
				{
					if (xmlHttpgrReadTT.responseText=='ERROR')
					{
						alert(xmlHttpgrReadTT.responseText);
					}
					else
					{
						Rellenar_Controles_Tooltip_GW(xmlHttpgrReadTT);
					}
				}
			}
			xmlHttpgrReadTT.send(null);			
		}
	</script>
</head>

<body onload="OnLeerTooltipGW()">

<?php
	if ($_GET['gw_id'])
	{
		$id_gateway=$_GET['gw_id'];
	}
	else
	{
		$id_gateway=$_POST['gw_id'];
	}
	if ($_POST['boton_preview'])
	{
		if ($_FILES['archivo']['tmp_name'])
		{
			include 'inc/datos_db.inc';			
			//$tipos = array("image/gif","image/jpeg","image/bmp","image/pjpeg");
			$maximo = 10485760; //10Mb
			$maximo = 100000; //1Mb
			//$maximo = $_POST['MAX_FILE_SIZE'];
			if (is_uploaded_file($_FILES['archivo']['tmp_name'])) 
			{ // Se ha subido?
				//echo "<script>alert('Subiendo archivo de ".$_FILES['archivo']['size']." bytes');</script>";
				if ($_FILES['archivo']['size'] <= $maximo)
				{ // Es correcto?
					$fp = fopen($_FILES['archivo']['tmp_name'], 'r'); //Abrimos la imagen
					$archivo = fread($fp, filesize($_FILES['archivo']['tmp_name'])); //Extraemos el contenido de la imagen
					$archivo = addslashes($archivo);
					fclose($fp); //Cerramos imagen
					$link = mysql_connect($db_host, $db_user,$db_pass);
					mysql_select_db($_SESSION['cliente_db'], $link);
					$query="DELETE FROM cliente_aux WHERE gw_id='".$id_gateway."' AND nodo_mac='000000000000'";
					//echo $query;
					mysql_query($query) or die(mysql_error());
					$query="INSERT INTO cliente_aux VALUES ('','".$id_gateway."','000000000000','".$archivo."','')";
					//echo $query;
					mysql_query($query) or die(mysql_error());
					//echo "<script>alert('Archivo subido correctamente');</script>";
					mysql_close($link);
				}
				else
				{
					//echo "<script>alert('Archivo demasiado grande');</script>";
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
				default:
					echo "<script>alert('ERROR genérico');</script>";
					break;
			  }
			}
		}
	}
	else if ($_POST['Actualizar_Param'])
	{
		include 'inc/datos_db.inc';	
		$link = mysql_connect($db_host, $db_user,$db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
		if ($_POST['show_image'] == 'on')
		{
			$show_im=1;
		}
		else
		{
			$show_im=0;
		}
		if ($_POST['show_s1'] == 'on')
		{
			$show_s1=1;
		}
		else
		{
			$show_s1=0;
		}
		if ($_POST['show_s2'] == 'on')
		{
			$show_s2=1;
		}
		else
		{
			$show_s2=0;
		}
		if ($_POST['show_s3'] == 'on')
		{
			$show_s3=1;
		}
		else
		{
			$show_s3=0;
		}
		if ($_POST['show_s4'] == 'on')
		{
			$show_s4=1;
		}
		else
		{
			$show_s4=0;
		}
		if ($_POST['show_s5'] == 'on')
		{
			$show_s5=1;
		}
		else
		{
			$show_s5=0;
		}
		if ($_POST['show_s6'] == 'on')
		{
			$show_s6=1;
		}
		else
		{
			$show_s6=0;
		}
		if ($_POST['show_s7'] == 'on')
		{
			$show_s7=1;
		}
		else
		{
			$show_s7=0;
		}
		if ($_POST['show_s8'] == 'on')
		{
			$show_s8=1;
		}
		else
		{
			$show_s8=0;
		}
		if ($_POST['show_s9'] == 'on')
		{
			$show_s9=1;
		}
		else
		{
			$show_s9=0;
		}
		$query="UPDATE cliente_gateways SET gw_show_image=".$show_im.",gw_show_sensor1=".$show_s1.",gw_show_sensor2=".$show_s2.",gw_show_sensor3=".$show_s3.",gw_show_sensor4=".$show_s4.",gw_show_sensor5=".$show_s5.",gw_show_sensor6=".$show_s6.",gw_show_sensor7=".$show_s7.",gw_show_sensor8=".$show_s8.",gw_show_sensor9=".$show_s9." WHERE gw_id='".$id_gateway."'";
		//echo $query;
		mysql_query($query) or die(mysql_error());
		echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link);
	}
?>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general180'].' '.$idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$id_gateway?></span>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">
				<div id="a_tabbar" style="width:95%; height:390px;">
					<div id='params_gw_0'>
						<form name="config_imagen_form1" action="configuracion_gw_imagen.html.php" method="post">
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>					
								<td style="width:5%"></td>	
								<td style="width:45%"><br/></td>								
								<td style="width:45%" align="right">
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
								</td>
								<td style="width:5%"></td>						
							</tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_image" id="show_image" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general183']?></span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s1" id="show_s1" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 1</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s2" id="show_s2" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 2</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s3" id="show_s3" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 3</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s4" id="show_s4" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s5" id="show_s5" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s6" id="show_s6" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s7" id="show_s7" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 7</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s8" id="show_s8" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 8</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:15%"></td>
											<td style="width:35%" align="left">
												<input type="checkbox" name="show_s9" id="show_s9" style="width:20px;text-align:center"/>
												&nbsp;&nbsp;<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general182'].' '.$idiomas[$_SESSION['opcion_idioma']]['general102']?> 9</span>
											</td>
											<td style="width:35%"></td>
											<td style="width:15%"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>					
								<td align="center">
									<input type="submit" name="Actualizar_Param" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" class="boton_fino_medio" id="boton_update"/>
								</td>	
							</tr>
						</table>						
						</form>
					</div>
					<div id='params_gw_1' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><br/></td></tr>
						</table>
						<form enctype="multipart/form-data" name="config_imagen_form" action="configuracion_gw_imagen.html.php" method="post">
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
												<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
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
												<img id='imagen_gw_antigua' src='descargar_imagen_gw.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&gw_id=<?php echo $id_gateway?>' width='155px' height='150px' style='align:center;border:1'></img>
											</td>
											<td style="width:5%"></td>
											<td style="width:40%" align="center" id='celda_imagen'>
												<?php 
												if (($_POST['boton_preview']) && ($_FILES['archivo']['tmp_name']))
												{
												?>
												<img id='imagen_gw' src='descargar_imagen_gw_aux.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&gw_id=<?php echo $id_gateway?>' width='155px' height='150px' style='align:center;border:1'></img>
												<?php 
												}
												else
												{
												?>	
												<img id='imagen_gw' width='155px' height='150px' style="align:center" src='images/sin_imagen.jpg'></img>
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
												if (($_POST['boton_preview']) && ($_FILES['archivo']['tmp_name']))
												{
												?>
												<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_Gw()" class="boton_fino"/>
												<?php 
												}
												else
												{
												?>	
												<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_Gw()" disabled="disabled" class="boton_fino"/>
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
					<script>
						tabbar = new dhtmlXTabBar("a_tabbar", "top");
						tabbar.setSkin('dark_blue');
						tabbar.setImagePath("codebase/imgs/");
						AnchoTabAux=document.getElementById('a_tabbar').offsetWidth/6;
						tabbar.addTab("a0", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general184']?>", AnchoTabAux);
						tabbar.addTab("a1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general183']?>", AnchoTabAux);
						tabbar.setContent("a0", "params_gw_0");
						tabbar.setContent("a1", "params_gw_1");
						<?php 
							if (($_POST['boton_preview']) || ($_GET['gw_id']))
							{
						?>
								tabbar.setTabActive("a1");
						<?php 
							}
							else
							{
						?>
								tabbar.setTabActive("a0");
						<?php
							}
						?>
					</script>
				</div>
			</td>
		</tr>
	</table>
	<form name="config_imagen_form2" action="configuracion_gw.html.php" method="post">
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:5%"><br/></td>
			<td style="width:45%">	
				<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>			
			</td>
			<td style="width:45%" align="right">
				<input type="submit" name="boton_config_basica_gw" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general181']?>" class="boton_fino_muy_largo" onclick="config_imagen_form2.action='configuracion_gw.html.php';return true;"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
	</form>
</body>
</html>
