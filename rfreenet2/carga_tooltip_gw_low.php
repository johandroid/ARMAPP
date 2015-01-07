<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_db.inc';

$instalacion = $_GET["instalacion_id"];
$gw_id = $_GET["gw_id"];
$cliente_db = $_SESSION["cliente_db"];
$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_nombre,
						 gw_latitud,
						 gw_longitud,
						 gw_estado,
						 gw_bateria,
						 gw_alimentacion,
						 gw_show_image,
						 gw_ip,
						 gw_port,
						 gw_ultima_rx,
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
	<div style="width:420px;height:250px;">
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:100%">
			<tr>
				<td colspan="2" class="texto_titulo_tooltip" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20'].' '.$gw_id?></td>
				<td colspan="3" class="texto_titulo_tooltip" style="width:55%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general151']?></td>
			</tr>		
			<tr>
				<td colspan="5" class="texto_titulo_tooltip">
					<div id="imagen" style="float: left; width: 160px; height: 100%"> 
						<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:200px;">
						<tr>
							<td >
<?php
						if ($row['gw_show_image'] == "1")
						{			
								echo "<img src='descargar_imagen_gw.php?cliente_db=".$cliente_db."&gw_id=".$gw_id."' width='155px' height='140px' align='center' border='1'></img>";
						}
						else
						{
								echo "<img src='images/sin_imagen.jpg' width='155px' height='140px' style='border:1'></img>";
						}
						
?>
							</td>
						</tr>
						<tr>
						<td class="etiqueta_tooltip"  align="center"><?php echo sObtener_Fecha_Desde_String($cliente_db, $instalacion, $row['gw_ultima_rx'],$zona_horaria)?></td>
						</tr>
						<tr>
						<td class="etiqueta_tooltip "  align="center">
<?php
								$ancho_pow_gw=40;
								$alto_pow_gw=32;
								if ($row['gw_alimentacion'] == 0)
								{
									echo '<img src="images/baterias/pow_on.png" width="'.$ancho_pow_gw.'px" height="'.$alto_pow_gw.'px"></img>';
								}
								else
								{
									echo '<img src="images/baterias/pow_off.png" width="'.$ancho_pow_gw.'px" height="'.$alto_pow_gw.'px"></img>';
								}
								$ancho_bat_gw=70;
								$alto_bat_gw=35;
								//$sNivelBatGW=$row['gw_bateria'];
								$sNivelBatGW=sConvertir_Datos_GW(hexdec($row['gw_bateria']), 'BAT', 1, $gw_id, 0, 1, "10");
																								
								if ($sNivelBatGW<4.2)
								{
									echo '<img src="images/baterias/bateria_12.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								}
								else if (($sNivelBatGW>=4.2) && ($sNivelBatGW<4.4))
								{
									echo '<img src="images/baterias/bateria_25.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								}
								else if (($sNivelBatGW>=4.4) && ($sNivelBatGW<4.6))
								{
									echo '<img src="images/baterias/bateria_50.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								}
								else if (($sNivelBatGW>=4.6) && ($sNivelBatGW<4.8))
								{
									echo '<img src="images/baterias/bateria_75.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								}
								else if (($sNivelBatGW>=4.8) && ($sNivelBatGW<4.9))
								{
									echo '<img src="images/baterias/bateria_90.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								}
								else
								{
									echo '<img src="images/baterias/bateria_100.png" width="'.$ancho_bat_gw.'px" height="'.$alto_bat_gw.'px"></img>';
								} 
?>
						</td>
						</tr>
						</table>
				</div> 				
				<div id="tabs" style="float: left; width: 240px; height: 200px;font-size:75%">
				<ul>
			        <li><a href="#tab-1"><span><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?></span></a></li>
			        <li><a href="#tab-2"><span><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?></span></a></li>
			    </ul>
				<div id="tab-1">
<?php 
				include "contenido_tooltip_gw_low_p1.php";
?>		
				</div>					
    			<div id="tab-2">
<?php 
				include "contenido_tooltip_gw_low_p2.php";
?>		    				
    			</div>
    			</div>				
			</td>			
			</tr>
			<tr>
			<td colspan="2" class="texto_titulo_tooltip" align="center">
<?php 
		if ($_SESSION['perfil'] < 3)
		{
			if($row["gw_tipo"] == 0)
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
					<input type="button" onclick="window.parent.OnConfiguracion(13,'<?php echo $gw_id?>',0,0);" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general14']?>"/>
<?php					
				}
?>					
					<input type="button" onclick="window.parent.OnDatosDatosGW('<?php echo $gw_id?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general150']?>"/>
			</td>
			</tr>
		</table>     
	
		<?php 	
		
	}
}
?>	
	</div>
<?php
mysql_free_result($result);
mysql_close($link); 		
?>