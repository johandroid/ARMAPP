<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];
 

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_TCH, gw_GPH, gw_versionHW, gw_versionSW FROM cliente_params_gw WHERE instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);				   
//echo $query;																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
$result = mysql_query($query,$link);

if(!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
}
else
{
	if($row = mysql_fetch_array($result))
	{
		$gw_VHW = $row['gw_versionHW'];
		$gw_VSW = $row['gw_versionSW'];
		if ($row['gw_GPH'] == '1')
		{
			$medio_com = 2;
		}
		else if ($row['gw_TCH'] == '1') 
		{
			$medio_com = 1;
		}
		else 
		{
			$medio_com = 0;
		}
	
		mysql_free_result($result);
		$query = sprintf("SELECT gw_nombre,
							 gw_latitud,
							 gw_longitud,
							 gw_estado,
							 gw_bateria,
							 gw_alimentacion,
							 gw_cobertura,
							 gw_show_image,
							 gw_ip,
							 gw_port,
							 unix_timestamp(gw_ultima_rx) as gw_ultima_rx,
							 gw_tipo,
							 gw_id,
							 gw_tipo_sensor1,  gw_show_sensor1,  gw_last_sensor1,  gw_lasttipo_sensor1, gw_nombre_s1,
							 gw_tipo_sensor2,  gw_show_sensor2,  gw_last_sensor2,  gw_lasttipo_sensor2, gw_nombre_s2,
							 gw_tipo_sensor3,  gw_show_sensor3,  gw_last_sensor3,  gw_lasttipo_sensor3, gw_nombre_s3,
							 gw_tipo_sensor4,  gw_show_sensor4,  gw_last_sensor4,  gw_lasttipo_sensor4, gw_nombre_s4,
							 gw_tipo_sensor5,  gw_show_sensor5,  gw_last_sensor5,  gw_lasttipo_sensor5, gw_nombre_s5,
							 gw_tipo_sensor6,  gw_show_sensor6,  gw_last_sensor6,  gw_lasttipo_sensor6, gw_nombre_s6,
							 gw_tipo_sensor7,  gw_show_sensor7,  gw_last_sensor7,  gw_lasttipo_sensor7, gw_nombre_s7,
							 gw_tipo_sensor8,  gw_show_sensor8,  gw_last_sensor8,  gw_lasttipo_sensor8, gw_nombre_s8,
							 gw_tipo_sensor9,  gw_show_sensor9,  gw_last_sensor9,  gw_lasttipo_sensor9, gw_nombre_s9,
							 gw_tipo_sensor10, gw_show_sensor10, gw_last_sensor10, gw_lasttipo_sensor10, gw_nombre_s10,
							 gw_tipo_sensor11, gw_show_sensor11, gw_last_sensor11, gw_lasttipo_sensor11, gw_nombre_s11,
							 gw_tipo_sensor12, gw_show_sensor12, gw_last_sensor12, gw_lasttipo_sensor12, gw_nombre_s12,
							 gw_tipo_sensor13, gw_show_sensor13, gw_last_sensor13, gw_lasttipo_sensor13, gw_nombre_s13,
							 gw_tipo_sensor14, gw_show_sensor14, gw_last_sensor14, gw_lasttipo_sensor14, gw_nombre_s14,
							 gw_tipo_sensor15, gw_show_sensor15, gw_last_sensor15, gw_lasttipo_sensor15, gw_nombre_s15,
							 gw_tipo_sensor16, gw_show_sensor16, gw_last_sensor16, gw_lasttipo_sensor16, gw_nombre_s16,
							 gw_tipo_sensor17, gw_show_sensor17, gw_last_sensor17, gw_lasttipo_sensor17, gw_nombre_s17,
							 gw_tipo_sensor18, gw_show_sensor18, gw_last_sensor18, gw_lasttipo_sensor18, gw_nombre_s18,
							 gw_tipo_sensor19, gw_show_sensor19, gw_last_sensor19, gw_lasttipo_sensor19, gw_nombre_s19,
							 gw_tipo_sensor20, gw_show_sensor20, gw_last_sensor20, gw_lasttipo_sensor20, gw_nombre_s20,
							 gw_tipo_sensor21, gw_show_sensor21, gw_last_sensor21, gw_lasttipo_sensor21, gw_nombre_s21,
							 gw_tipo_sensor22, gw_show_sensor22, gw_last_sensor22, gw_lasttipo_sensor22, gw_nombre_s22,
							 gw_tipo_sensor23, gw_show_sensor23, gw_last_sensor23, gw_lasttipo_sensor23, gw_nombre_s23	  						 				 
					    FROM cliente_gateways 
					   WHERE instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);
			   
		//echo $query;																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
		$result = mysql_query($query,$link);
	
		if(!$result)
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
		}
		else
		{
			if($row = mysql_fetch_array($result))
			{
?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
				<head>
					<title></title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
					<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
					<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
					<script  src="codebase/dhtmlxcommon.js"></script>
					<script  src="codebase/dhtmlxtabbar.js"></script>
					<script type="text/javascript" src="js/funciones_ajax.js"></script>
					<script type="text/javascript" src="js/funciones_aux.js"></script>
					<script type="text/javascript" src="js/funciones_check.js"></script>
					<script type="text/javascript" src="js/funciones_gw.js"></script>
					<script type="text/javascript" src="js/funciones_medidas.js"></script>
					<script type="text/javascript" src="js/funciones_principal.js"></script>
					<script type="text/javascript" src="js/dhtmlxcontainer.js"></script>	
					<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
					<script type="text/javascript" src="js/jquery.dualListBox-1.3.min_kta.js"></script>
			
				</head>
				<body>
				<div id="tooltip_mapa" style="width:420px;height:260px;overflow:none">
				<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:100%">
				<tr>
					<td colspan="2" class="texto_titulo_tooltip" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$gw_id?></td>
					<td colspan="3" class="texto_titulo_tooltip" style="width:55%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general151']?></td>
				</tr>		
				<tr>
						<td colspan="5">
						<div id="imagen" style="float: left; width: 160px; height: 100%"> <!-- AMB 08/03/2012 Imagen y batería--> 
							<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:220px;">
								<tr>
									<td>
<?php
								if ($row['gw_show_image'] == "1")
								{			
										echo "<img src='descargar_imagen_gw.php?cliente_db=".$cliente_db."&gw_id=".$gw_id."' width='155px' height='150px' align='center' border='1'></img>";
								}
								else
								{
?>
										<img src="images/sin_imagen.jpg" width="155px" height="150px" style="border:1"></img>
<?php 		
								}
								$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
?>
									</td>
								</tr>
								<tr>
								<td class="etiqueta_tooltip"  align="center"><?php echo /*$row['gw_ultima_rx']*/sObtener_Fecha($cliente_db, $instalacion, $row['gw_ultima_rx'],$zona_horaria)?></td>
								</tr>
								<tr>
								<td class="etiqueta_tooltip "  align="center">
<?php
										$ancho_pow_gw=40;
										$alto_pow_gw=30;
										if ($row['gw_alimentacion'] == 0)
										{
											echo '<img src="images/baterias/pow_on.png" width="'.$ancho_pow_gw.'px" height="'.$alto_pow_gw.'px"></img>';
										}
										else
										{
											echo '<img src="images/baterias/pow_off.png" width="'.$ancho_pow_gw.'px" height="'.$alto_pow_gw.'px"></img>';
										}
										$ancho_bat_gw=60;
										$alto_bat_gw=30;
										$sNivelBatGW=sConvertir_Datos_GW(hexdec($row['gw_bateria']), 'BAT', 1, 0, 0, 0, $gw_VHW);
										if ($sNivelBatGW<=4.5)
										{
											echo '<img src="images/baterias/bateria_12.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										else if (($row["gw_tipo"] == $tipo_gw && $sNivelBatGW<=11) || ($row["gw_tipo"] != $tipo_gw && $sNivelBatGW<=4.6))
										{
											echo '<img src="images/baterias/bateria_25.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										else if (($row["gw_tipo"] == $tipo_gw && $sNivelBatGW<=11.5) || ($row["gw_tipo"] != $tipo_gw && $sNivelBatGW<=4.75))
										{
											echo '<img src="images/baterias/bateria_50.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										else if (($row["gw_tipo"] == $tipo_gw && $sNivelBatGW<=11.8) || ($row["gw_tipo"] != $tipo_gw && $sNivelBatGW<=4.9))
										{
											echo '<img src="images/baterias/bateria_75.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										else if (($row["gw_tipo"] == $tipo_gw && $sNivelBatGW<=12) || ($row["gw_tipo"] != $tipo_gw && $sNivelBatGW<=5))
										{
											echo '<img src="images/baterias/bateria_90.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										else
										{
											echo '<img src="images/baterias/bateria_100.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
										}
										$ancho_cob=40;
										$alto_cob=30;
										$sNivelCob=$row['gw_cobertura'];
										switch ($medio_com)
										{
											// GPRS
											case 2:
												if ($sNivelCob==0)
												{
													echo '<img src="images/cobertura/cobUnk.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else if ($sNivelCob==990)
												{
													echo '<img src="images/cobertura/cob00.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else if ($sNivelCob<=90)
												{
													echo '<img src="images/cobertura/cob20.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else if ($sNivelCob<=150)
												{
													echo '<img src="images/cobertura/cob40.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else if ($sNivelCob<=250)
												{
													echo '<img src="images/cobertura/cob60.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else if ($sNivelCob<=290)
												{
													echo '<img src="images/cobertura/cob80.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												else
												{
													echo '<img src="images/cobertura/cob100.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												}
												break;
												
											// ETHERNET
											case 1:
												echo '<img src="images/wired.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												break;
												
											// MAL CONFIGURADO
											default:
												echo '<img src="images/wiredBAD.png" width="'.$ancho_cob.'px" height="'.$alto_cob.'px"></img>';
												break;
										}
?>
								</td>
								</tr>
							</table>
						</div> 
						<div id="sensores" style="float: left; width: 200px; height: 100%" >
						<!-- AMB 08/03/2012 Sensores-->	
<?php 
						if($row["gw_tipo"] == $tipo_gw)			
						{
?>				
							<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:210px;">					
								<tr>
<?php
								
								if ($row['gw_show_sensor1'] == "1")
								{
									if ($row['gw_nombre_s1'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 1</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s1']?></td>
<?php										
									}
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php 				
								}
?>
									<td rowspan="11" style="width:5%"></td>
<?php 		
								if ($row['gw_show_sensor6'] == "1")
								{	
									if ($row['gw_nombre_s6'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s6']?></td>
<?php										
									}		
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php				
								}
?>		
								</tr>
								<tr>			
<?php			
								if ($row['gw_show_sensor1'] == "1")
								{
									if ($row['gw_tipo_sensor1'] != "0")
									{
?>				
										<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor1']?></td>-->
<?php 				
										switch ($row['gw_lasttipo_sensor1'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor1']), $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor1']), $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, $gw_VHW)?></td>
<?php								
												break;
										}				
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
								if ($row['gw_show_sensor6'] == "1")
								{
									if ($row['gw_tipo_sensor6'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor6']?></td>-->		
<?php						
										switch ($row['gw_lasttipo_sensor6'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor6']), $row['gw_tipo_sensor6'], 0, $row['gw_id'], 5, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor6']), $row['gw_tipo_sensor6'], 0, $row['gw_id'], 5, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
?>		
								</tr>
								<tr>
<?php 	
								if ($row['gw_show_sensor2'] == "1")
								{		
									if ($row['gw_nombre_s2'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 2</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s2']?></td>
<?php										
									}			
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php 				
								}
								
								if ($row['gw_show_sensor7'] == "1")
								{	
									if ($row['gw_nombre_s7'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 7</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s7']?></td>
<?php										
									}
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php				
								}
?>		
								</tr>
								<tr>
<?php			
								if ($row['gw_show_sensor2'] == "1")
								{	
									if ($row['gw_tipo_sensor2'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor2']?></td>-->
<?php			
										switch ($row['gw_lasttipo_sensor2'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor2']), $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor2']), $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, $gw_VHW)?></td>
<?php								
												break;
										}			
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
								if ($row['gw_show_sensor7'] == "1")
								{	
									if ($row['gw_tipo_sensor7'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor7']?></td>-->
<?php					
										switch ($row['gw_lasttipo_sensor7'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor7']), $row['gw_tipo_sensor7'], 0, $row['gw_id'], 6, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor7']), $row['gw_tipo_sensor7'], 0, $row['gw_id'], 6, 1, $gw_VHW)?></td>
<?php								
												break;
										}	
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
?>		
								</tr>
								<tr>
<?php 
								if ($row['gw_show_sensor3'] == "1")
								{			
									if ($row['gw_nombre_s3'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 3</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s3']?></td>
<?php										
									}				
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php 				
								}
						
								if ($row['gw_show_sensor8'] == "1")
								{	
									if ($row['gw_nombre_s8'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 8</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo  $row['gw_nombre_s8']?></td>
<?php										
									} 			
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php				
								}
?>		
								</tr>
								<tr>
<?php			
								if ($row['gw_show_sensor3'] == "1")
								{
									if ($row['gw_tipo_sensor3'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor3']?></td>-->
<?php						
										switch ($row['gw_lasttipo_sensor3'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor3']), $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor3']), $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
								if ($row['gw_show_sensor8'] == "1")
								{	
									if ($row['gw_tipo_sensor8'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor8']?></td>-->
<?php						
										switch ($row['gw_lasttipo_sensor8'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor8']), $row['gw_tipo_sensor8'], 0, $row['gw_id'], 7, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor8']), $row['gw_tipo_sensor8'], 0, $row['gw_id'], 7, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
?>		
								</tr>
								<tr>
							
<?php 
								if ($row['gw_show_sensor4'] == "1")
								{		
									if ($row['gw_nombre_s4'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s4']?></td>
<?php										
									}

								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php 				
								}
						
								if ($row['gw_show_sensor9'] == "1")
								{
									if ($row['gw_nombre_s9'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 9</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s9']?></td>
<?php										
									}			
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php				
								}
?>		
								</tr>
								<tr>
<?php			
								if ($row['gw_show_sensor4'] == "1")
								{	
									if ($row['gw_tipo_sensor4'] != "0")
									{
?>
									<!--<td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor4']?></td>-->
<?php						
										switch ($row['gw_lasttipo_sensor4'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor4']), $row['gw_tipo_sensor4'], 0, $row['gw_id'], 3, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor4']), $row['gw_tipo_sensor4'], 0, $row['gw_id'], 3, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
								if ($row['gw_show_sensor9'] == "1")
								{	
									if ($row['gw_tipo_sensor9'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor9']?></td>-->
<?php						
										switch ($row['gw_lasttipo_sensor9'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor9']), $row['gw_tipo_sensor9'], 0, $row['gw_id'], 8, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor9']), $row['gw_tipo_sensor9'], 0, $row['gw_id'], 8, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td class="etiqueta_valor_tooltip" style="width:50%"><br/></td>
<?php			
								}
?>		
								</tr>
								<tr>
		
<?php 
								if ($row['gw_show_sensor5'] == "1")
								{
									if ($row['gw_nombre_s5'] == "")
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</td>
<?php 				
									}
									else 
									{
?>								
										<td class="etiqueta_tooltip left_tborder" style="width:50%"><?php echo $row['gw_nombre_s5']?></td>
<?php										
									}				
								}
								else
								{
?>			
									<td class="etiqueta_tooltip" style="width:50%"></td>
<?php 				
								}
?>
								</tr>
								<tr>
<?php			
								if ($row['gw_show_sensor5'] == "1")
								{	
									if ($row['gw_tipo_sensor5'] != "0")
									{
?>
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="50%"><?php //echo $row['gw_last_sensor5']?></td>-->
<?php						
										switch ($row['gw_lasttipo_sensor5'])
										{
											case 'U':
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor5']), $row['gw_tipo_sensor5'], 0, $row['gw_id'], 4, 1, $gw_VHW)?></td>
<?php						
												break;
						
											default:
?>
												<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:50%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor5']), $row['gw_tipo_sensor5'], 0, $row['gw_id'], 4, 1, $gw_VHW)?></td>
<?php								
												break;
										}
									}
									else
									{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:50%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
									}
								}
								else
								{		
?>
									<td style="width:50%"><br/></td>
<?php			
								}
?>
								</tr>
							</table>
<?php 
						}
						else if($row["gw_tipo"] == 1)
						{
							if($num_pestana == 1)
							{
								include "contenido_tooltip_gw_low_p1.php";
							}
						  	else
						  	{
								include "contenido_tooltip_gw_low_p2.php";
							}
						}
						else if($row["gw_tipo"] == 2)
						{
?>		
							<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:210px;">
							<tr>
								<td rowspan="12" style="width:5%"></td>
<?php
							
							if ($row['gw_show_sensor1'] == "1")
							{
?>			
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general294']?> </td>
<?php 				
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php 				
							}
					
?>
								<td rowspan="6" style="width:5%"></td>
<?php 		
							
							if ($row['gw_show_sensor4'] == "1")
							{
?>	
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general297']?></td>
<?php 			
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php				
							}
?>		
							</tr>
							<tr>			
<?php			
							if ($row['gw_show_sensor1'] == "1")
							{
								if ($row['gw_tipo_sensor1'] != "0")
								{
?>				
									<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="25%"><?php //echo $row['gw_last_sensor1']?></td>-->
<?php 				
									switch ($row['gw_lasttipo_sensor1'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor1'], $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor1'], $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, $gw_VHW)?></td>
<?php								
											break;
									}				
								}
								else
								{
?>			
								<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
							if ($row['gw_show_sensor4'] == "1")
							{
								if ($row['gw_tipo_sensor4'] != "0")
								{
?>
								<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="25%"><?php //echo $row['gw_last_sensor6']?></td>-->		
<?php						
									switch ($row['gw_lasttipo_sensor4'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor4'], $row['gw_tipo_sensor4'], 0, $row['gw_id'], 3, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor4'], $row['gw_tipo_sensor4'], 0, $row['gw_id'], 3, 1, $gw_VHW)?></td>
<?php								
											break;
									}
								}
								else
								{
?>			
								<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
?>		
							</tr>
							<tr>
<?php 	
							if ($row['gw_show_sensor2'] == "1")
							{
?>			
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general295']?></td>
<?php 				
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php 				
							}
							
							if ($row['gw_show_sensor5'] == "1")
							{
?>	
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general262']?></td>
<?php 			
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php				
							}
?>		
							</tr>
							<tr>
<?php			
							if ($row['gw_show_sensor2'] == "1")
							{	
								if (($row['gw_tipo_sensor2'] != "0") && (($row['gw_tipo_sensor1'] != "0")) && (sConvertir_Datos_GW($row['gw_last_sensor1'], $row['gw_tipo_sensor1'], 0, 1, $gw_VHW)=="J. Cerrada"))
								{
?>
								<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="25%"><?php //echo $row['gw_last_sensor2']?></td>-->
<?php			
									switch ($row['gw_lasttipo_sensor2'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor2'], $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor2'], $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, $gw_VHW)?></td>
<?php								
											break;
									}			
								}
								else
								{
?>			
								<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{		
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
							if ($row['gw_show_sensor5'] == "1")
							{
								if ($row['gw_tipo_sensor5'] != "0")
								{
?>
								<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="25%"><?php //echo $row['gw_last_sensor7']?></td>-->
<?php					
									switch ($row['gw_lasttipo_sensor5'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor5'], $row['gw_tipo_sensor5'], 0, $row['gw_id'], 4, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor5'], $row['gw_tipo_sensor5'], 0, $row['gw_id'], 4, 1, $gw_VHW)?></td>
<?php								
											break;
									}	
								}
								else
								{
?>			
									<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{		
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
?>		
							</tr>
							<tr>
<?php 
							if ($row['gw_show_sensor3'] == "1")
							{
?>			
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general296']?></td>
<?php 				
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php 				
							}
					
							if ($row['gw_show_sensor6'] == "1")
							{
?>	
								<td class="etiqueta_tooltip left_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general263']?></td>
<?php 			
							}
							else
							{
?>			
								<td class="etiqueta_tooltip" style="width:25%"></td>
<?php				
							}
?>		
							</tr>
							<tr>
<?php			
							if ($row['gw_show_sensor3'] == "1")
							{	
								if ($row['gw_tipo_sensor3'] != "0")
								{
									switch ($row['gw_lasttipo_sensor3'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor3'], $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor3'], $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, $gw_VHW)?></td>
<?php								
											break;
									}
								}
								else
								{
?>			
								<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{		
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
							if ($row['gw_show_sensor6'] == "1")
							{	
								if ($row['gw_tipo_sensor6'] != "0")
								{
?>
								<!-- <td class="etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" width="25%"><?php //echo $row['gw_last_sensor8']?></td>-->
<?php						
									switch ($row['gw_lasttipo_sensor6'])
									{
										case 'U':
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor6'], $row['gw_tipo_sensor6'], 0, $row['gw_id'], 5, 1, $gw_VHW)?></td>
<?php						
											break;
					
										default:
?>
											<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:25%"><?php echo sConvertir_Datos_GW($row['gw_last_sensor6'], $row['gw_tipo_sensor6'], 0, $row['gw_id'], 5, 1, $gw_VHW)?></td>
<?php								
											break;
									}
								}
								else
								{
?>			
								<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:25%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
								}
							}
							else
							{		
?>
								<td class="etiqueta_valor_tooltip" style="width:25%"><br/></td>
<?php			
							}
?>		
							</tr>
		
							<tr>
								<!-- <td colspan="2" class="texto_titulo_tooltip"><br/></td>-->
								<td colspan="2" class="etiqueta_tooltip" align="center">
<?php 
							
							if ($row['gw_tipo_sensor1'] != "0" && (sConvertir_Datos_GW($row['gw_last_sensor1'], $row['gw_tipo_sensor1'],0,1,0,1)=="J. Cerrada" ))
							{
?>
								
								<input type="button" onclick="window.parent.vEnviar_Comando('<?php echo $gw_id?>','000','O<?php echo $gw_id?>51');" value="Desactivar Apertura"/>
<?php 
							}
?>
								</td>
							</tr>
						</table>
<?php 
				}
?>		
						</div>							
					</td>			
				</tr>
				<tr>
				<td colspan="2" class="texto_titulo_tooltip" align="center">
<?php 
				if ($_SESSION['perfil'] < 3)
				{
					if (($row["gw_tipo"] == $tipo_gw) && ($gw_VSW < $version_offline)) 
					{
?>
					<input type="button" onclick="window.parent.vEnviar_Comando('R<?php echo $gw_id?>', '<?php echo $gw_id?>', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general148']?>"/>
					<input type="button" onclick="window.parent.vEnviar_Comando('A<?php echo $gw_id?>', '<?php echo $gw_id?>', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general149']?>"/>
<?php 
					}
					else
				    {
?>
					<input type="button" onclick="window.parent.vEnviar_Comando_Offline('R<?php echo $gw_id?>', '<?php echo $gw_id?>', '000', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general148']?>"/>
					<input type="button" onclick="window.parent.vEnviar_Comando_Offline('A<?php echo $gw_id?>', '<?php echo $gw_id?>', '000', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general149']?>"/>
<?php 				
					}
				}
?>		
				</td>		
				<td colspan="3" class="etiqueta_tooltip" align="center">
<?php					
				if ($_SESSION['perfil'] < 2)
				{
?>					
					<input type="button" onclick="window.parent.OnConfiguracion(0,'<?php echo $gw_id?>',0,0);" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general14']?>"/>
<?php					
				}
?>				
					<input type="button" onclick="window.parent.OnDatosDatosGW('<?php echo $gw_id?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general150']?>"/>
				</td>
				</tr>
			</table>
			</div>
			</body>
			</html>
<?php
			}
		}
	} 		
}
mysql_free_result($result);
mysql_close($link);
?>