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
		function Actualizar_imagen_Nodo()
		{
			var url = "actualizar_imagen_nodo.php?gw_id="+document.getElementById('gw_id').value+'&cliente_db=<?php echo $_SESSION['cliente_db']?>&nodo_mac='+document.getElementById('object_id').value;
			//alert(url);
			xmlHttpgrRead= GetXmlHttpObject();
			xmlHttpgrRead.open("GET",url,false);
			xmlHttpgrRead.send(null);
			//alert(xmlHttpgrRead.responseText);
			if (xmlHttpgrRead.responseText=='ERROR')
			{
				alert(iObtener_Cadena_AJAX('error_server6')+" "+iObtener_Cadena_AJAX('general21'));
			}
			//window.location='configuracion_nodo_imagen.html.php?gw_id='+document.getElementById('gw_id').value+'&object_ip='+document.getElementById('object_ip').value+'&object_id='+document.getElementById('object_id').value+'&xml_params='+document.getElementById('xml_params').value;
			window.location='configuracion_nodo_imagen.html.php?gw_id='+document.getElementById('gw_id').value+'&object_ip='+document.getElementById('object_ip').value+'&object_id='+document.getElementById('object_id').value;
		}

		function Rellenar_Controles_Tooltip_Nodo(sParametrosNodo)
		{
			var sPrincipal;
			var sListaNombres;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;

			sPrincipal=parsear_xml(sParametrosNodo.responseText);
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
		function OnLeerTooltipNodo()
		{			
			var url = "nodo_lectura_tooltip.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&gw_id="+document.getElementById('gw_id').value+"&nodo_mac="+document.getElementById('object_id').value;
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
						Rellenar_Controles_Tooltip_Nodo(xmlHttpgrReadTT);
					}
				}
			}
			xmlHttpgrReadTT.send(null);			
		}
	</script>
</head>

<body onload="OnLeerTooltipNodo()">
<?php
	if ($_GET['object_ip'])
	{
		$id_gateway=$_GET['gw_id'];
		$gw_tipo=$_GET['gw_tipo'];
		$nodo_mac=$_GET['object_id'];
		$nodo_ip=$_GET['object_ip'];
		//$xml_params=$_GET['xml_params'];
	}
	else
	{
		$id_gateway=$_POST['gw_id'];
		$gw_tipo=$_POST['gw_tipo'];
		$nodo_mac=$_POST['object_id'];
		$nodo_ip=$_POST['object_ip'];
		//$xml_params=$_POST['xml_params'];
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
					$query="DELETE FROM cliente_aux WHERE gw_id='".$id_gateway."' AND nodo_mac='".$nodo_mac."'";;
					//echo $query;
					mysql_query($query) or die(mysql_error());
					$query="INSERT INTO cliente_aux VALUES ('','".$id_gateway."','".$nodo_mac."','','".$archivo."')";
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
		$query="UPDATE cliente_nodos SET nodo_show_image=".$show_im.",nodo_show_s1=".$show_s1.",nodo_show_s2=".$show_s2.",nodo_show_s3=".$show_s3.",nodo_show_s4=".$show_s4.",nodo_show_s5=".$show_s5.",nodo_show_s6=".$show_s6." WHERE gw_id='".$id_gateway."' AND nodo_mac='".$nodo_mac."'";
		//echo $query;
		mysql_query($query) or die(mysql_error());
		echo "<script>alert('".$idiomas[$_SESSION['opcion_idioma']]['general60']."');</script>";
		mysql_close($link);
	}
?>

	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center"><br/></td>
		</tr>
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general180'].' '.$idiomas[$_SESSION['opcion_idioma']]['general21'].' '.$nodo_mac?></span>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">
				<div id="a_tabbar" style="width:95%; height:370px;">
					<div id='params_gw_0' style="valign:center" >
						<form name="config_imagen_form1" action="configuracion_nodo_imagen.html.php" method="post">
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>					
								<td style="width:5%"></td>	
								<td style="width:45%"><br/></td>								
								<td style="width:45%" align="right">
									<!--<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $xml_params?>"/>-->
									<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>									
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
									<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $gw_tipo ?>"/>
									<input type="hidden" id="object_id" name="object_id" value="<?php echo $nodo_mac?>"/>
									<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $nodo_ip?>"/>
								</td>
								<td style="width:5%"></td>						
							</tr>
							<tr>
								<td colspan="4" align="center">
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
											</table>
										</div>
									</div>
									<input type="submit" name="Actualizar_Param" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" class="boton_fino_medio" id="boton_update"/>
								</td>
							</tr>
						</table>
						</form>
					</div>
					<div id='params_gw_1' >
						<form enctype="multipart/form-data" name="config_imagen_form" action="configuracion_nodo_imagen.html.php" method="post">
						<table border="0" width="100%">
							<tr style="width:100%"><td align="center" colspan="5"><br/></td></tr>
							<tr style="width:100%" id="celda_tabla_params">
								<td align="center" colspan="5">				
							 		<!--<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $xml_params?>"/>-->
									<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>									
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
									<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $gw_tipo ?>"/>
									<input type="hidden" id="object_id" name="object_id" value="<?php echo $nodo_mac?>"/>
									<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $nodo_ip?>"/>
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
												<img id='imagen_gw_antigua' src='descargar_imagen_nodo.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&gw_id=<?php echo $id_gateway?>&nodo_mac=<?php echo $nodo_mac?>' width='155px' height='150px' style='align:center;border:1'></img>
											</td>
											<td style="width:5%"></td>
											<td style="width:40%" align="center" id='celda_imagen'>
												<?php 
												if (($_POST['boton_preview']) && ($_FILES['archivo']['tmp_name']))
												{
												?>
												<img id='imagen_nodo' src='descargar_imagen_nodo_aux.php?cliente_db=<?php echo $_SESSION['cliente_db']?>&gw_id=<?php echo $id_gateway?>&nodo_mac=<?php echo $nodo_mac?>' width='155px' height='150px' style='align:center;border:1'></img>
												<?php 
												}
												else
												{
												?>	
												<img id='imagen_nodo' width='155px' height='150px' style='align:center' src='images/sin_imagen.jpg'></img>
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
									<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_Nodo()" class="boton_fino"/>
									<?php 
									}
									else
									{
									?>	
									<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="boton_upload" onclick="Actualizar_imagen_Nodo()" disabled="disabled" class="boton_fino"/>
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
	<form name="config_imagen_form2" action="configuracion_nodo.html.php" method="post">
	<table border="0" width="100%">	
		<tr style="width:100%">
			
			<td style="width:5%"></td>
			<td style="width:40%" align="center">
				<!--<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $xml_params?>"/>-->
				<input type="hidden" name="MAX_FILE_SIZE" value=10485760/>									
				<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
				<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $gw_tipo ?>"/>
				<input type="hidden" id="object_id" name="object_id" value="<?php echo $nodo_mac?>"/>
				<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $nodo_ip?>"/>
			</td>
			<td style="width:10%"></td>
			<td style="width:40%" align="center">
				<input type="submit" name="boton_config_basica_nodo" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general181']?>" class="boton_fino_muy_largo" onclick="config_imagen_form2.action='configuracion_nodo.html.php';return true;"/>
			</td>
			<td style="width:5%"></td>
		</tr>		
	</table>
	</form>
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
		 	//if ($_POST['xml_params'])
		 	//{
		 ?>
		 		//var xmlRXReadNode='<?php //echo $_POST['xml_params'];?>';
		 		//document.getElementById('xml_params').value=xmlRXReadNode;
		 <?php
		 	//}
		 ?> 	
</script>
</body>
</html>
