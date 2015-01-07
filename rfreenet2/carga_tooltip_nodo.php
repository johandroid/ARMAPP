<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$nodo_mac = $_GET["nodo_mac"];
$cliente_db = $_GET["cliente_db"];
$gw_id = $_GET["gw_id"];

mysql_select_db($cliente_db, $link);
$query = sprintf("SELECT cliente_nodos.gw_id, cliente_nodos.nodo_ip,cliente_nodos.nodo_nombre,nodo_latitud,
						 nodo_longitud,nodo_estado,nodo_bateria,
						 nodo_show_image,unix_timestamp(nodo_ultima_rx) as nodo_ultima_rx,nodo_tipo_s1,
						 nodo_habilitado_s1,nodo_nombre_s1,nodo_show_s1,
						 nodo_last_s1,nodo_lasttipo_s1,nodo_tipo_s2,
						 nodo_habilitado_s2,nodo_nombre_s2,nodo_show_s2,
						 nodo_last_s2,nodo_lasttipo_s2,nodo_tipo_s3,
						 nodo_habilitado_s3,nodo_nombre_s3,nodo_show_s3,
						 nodo_last_s3,nodo_lasttipo_s3,nodo_tipo_s4,
						 nodo_habilitado_s4,nodo_nombre_s4,nodo_show_s4,
						 nodo_last_s4,nodo_lasttipo_s4,nodo_tipo_s5,
						 nodo_habilitado_s5,nodo_nombre_s5,nodo_show_s5,
						 nodo_last_s5,nodo_lasttipo_s5,nodo_tipo_s6,
						 nodo_habilitado_s6,nodo_nombre_s6,nodo_show_s6,
						 nodo_last_s6,nodo_lasttipo_s6, nodo_TNO,gw_tipo,
						 nodo_aux_operacion1,nodo_aux_constante1,
						 nodo_aux_operacion2,nodo_aux_constante2,
						 nodo_aux_operacion3,nodo_aux_constante3,
						 nodo_aux_operacion4,nodo_aux_constante4,
						 nodo_aux_operacion5,nodo_aux_constante5,
						 nodo_aux_operacion6,nodo_aux_constante6,
						 if (gw_tipo='%s', cliente_params_gw.gw_versionHW, '10') as gw_vHW,
						 if (gw_tipo='%s', cliente_params_gw.gw_versionSW, '1001') as gw_vSW
				    FROM cliente_nodos
			  INNER JOIN cliente_params_nodo ON (cliente_nodos.gw_id = cliente_params_nodo.gw_id AND
			  									 cliente_nodos.instalacion_id = cliente_params_nodo.instalacion_id AND
			  									 cliente_nodos.nodo_ip = cliente_params_nodo.nodo_ip) 
		 LEFT OUTER JOIN cliente_gateways ON ( cliente_nodos.gw_id = cliente_gateways.gw_id )
		 LEFT OUTER JOIN cliente_params_gw ON ( cliente_nodos.gw_id = cliente_params_gw.gw_id )
				   WHERE cliente_nodos.nodo_mac='%s' AND cliente_gateways.gw_id='%s';", $tipo_gw, $tipo_gw, $nodo_mac, $gw_id);
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
		</head>
		<body>
		<div id="tooltip_mapa" style="width:370px;height:280px">
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:100%">
		<tr>
			<td colspan="2" class="texto_titulo_tooltip" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general21'].' '.$nodo_mac?></td>
			<td colspan="2" class="texto_titulo_tooltip" style="width:55%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general151']?></td>
		</tr>
		<tr>
			<td rowspan="9" style="width:50%">
<?php
		if ($row['nodo_show_image'] == "1")
		{			
				echo "<img src='descargar_imagen_nodo.php?cliente_db=".$cliente_db."&gw_id=".$gw_id."&nodo_mac=".$nodo_mac."' width='155px' height='150px' align='center' border='1'></img>";
		}
		else
		{
?>
				<img src="images/sin_imagen.jpg" width="155px" height="150px" style="border:1"></img>
<?php 		
		}
?>
		</td>
		<td rowspan="14" style="width:5%"></td>
<?php

		if ($row['nodo_show_s1'] == "1")
		{
			if ($row['nodo_nombre_s1'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 1</td>
<?php 		
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s1']?></td>
<?php 	
			}	
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}

?>
		</tr>
		<tr>
<?php			
		if ($row['nodo_show_s1'] == "1")
		{
			if ($row['nodo_tipo_s1'] != "0")
			{
				switch ($row['nodo_lasttipo_s1'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s1']), $row['nodo_tipo_s1'],0,$row['nodo_lasttipo_s1'],1,$row['nodo_aux_operacion1'],$row['nodo_aux_constante1'], $row['gw_id'], $row['nodo_ip'], 1)?></td>
<?php	
						break;
				
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s1']), $row['nodo_tipo_s1'],0,$row['nodo_lasttipo_s1'],1,$row['nodo_aux_operacion1'],$row['nodo_aux_constante1'], $row['gw_id'], $row['nodo_ip'], 1)?></td>
<?php						
						break;
				}	
			}
			else
			{
?>			
				<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{
?>
			<td class="etiqueta_valor_tooltip" style="width:45%"><br/></td>
<?php			
		}
?>		
		</tr>
		<tr>
<?php 	
		if ($row['nodo_show_s2'] == "1")
		{
			if ($row['nodo_nombre_s2'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 2</td>
<?php 				
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s2']?></td>
<?php 	
			}
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}

?>		
		</tr>
		<tr>
<?php			
		if ($row['nodo_show_s2'] == "1")
		{
			if ($row['nodo_tipo_s2'] != "0")
			{
				switch ($row['nodo_lasttipo_s2'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s2']), $row['nodo_tipo_s2'],0,$row['nodo_lasttipo_s2'],1,$row['nodo_aux_operacion2'],$row['nodo_aux_constante2'], $row['gw_id'], $row['nodo_ip'], 2)?></td>
<?php	
						break;
				
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s2']), $row['nodo_tipo_s2'],0,$row['nodo_lasttipo_s2'],1,$row['nodo_aux_operacion2'],$row['nodo_aux_constante2'], $row['gw_id'], $row['nodo_ip'], 2)?></td>
<?php						
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:45%"><br/></td>
<?php			
		}
?>		
		</tr>
		<tr>
<?php 
		if ($row['nodo_show_s3'] == "1")
		{
			if ($row['nodo_nombre_s3'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 3</td>
<?php 	
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s3']?></td>
<?php 	
			}
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}

?>		
		</tr>
		<tr>
<?php			
		if ($row['nodo_show_s3'] == "1")
		{	
			if ($row['nodo_tipo_s3'] != "0")
			{
				switch ($row['nodo_lasttipo_s3'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s3']), $row['nodo_tipo_s3'],0,$row['nodo_lasttipo_s3'],1,$row['nodo_aux_operacion3'],$row['nodo_aux_constante3'], $row['gw_id'], $row['nodo_ip'], 3)?></td>
<?php	
						break;
						
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s3']), $row['nodo_tipo_s3'],0,$row['nodo_lasttipo_s3'],1,$row['nodo_aux_operacion3'],$row['nodo_aux_constante3'], $row['gw_id'], $row['nodo_ip'], 3)?></td>
<?php						
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:45%"><br/></td>
<?php			
		}
?>		
		</tr>
		<tr>
<?php 
		if ($row['nodo_show_s4'] == "1")
		{
			if ($row['nodo_nombre_s4'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</td>
<?php 			
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s4']?></td>
<?php 	
			}	
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}
?>		
		</tr>
		<tr>
<?php			
		if ($row['nodo_show_s4'] == "1")
		{	
			if ($row['nodo_tipo_s4'] != "0")
			{
				switch ($row['nodo_lasttipo_s4'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s4']), $row['nodo_tipo_s4'],0,$row['nodo_lasttipo_s4'],1,$row['nodo_aux_operacion4'],$row['nodo_aux_constante4'], $row['gw_id'], $row['nodo_ip'], 4)?></td>
<?php	
						break;
				
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s4']), $row['nodo_tipo_s4'],0,$row['nodo_lasttipo_s4'],1,$row['nodo_aux_operacion4'],$row['nodo_aux_constante4'], $row['gw_id'], $row['nodo_ip'], 4)?></td>
<?php						
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:45%"><br/></td>
<?php			
		}
?>		
		</tr>
		<tr>
<?php 
		if ($row['nodo_show_s5'] == "1")
		{
			if ($row['nodo_nombre_s5'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</td>
<?php 				
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s5']?></td>
<?php 	
			}
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}

?>
		</tr>
		
		<tr>
		<td colspan="2" align=center" class="etiqueta_tooltip"><?php echo $row['nodo_nombre']?></td>
<?php			
		if ($row['nodo_show_s5'] == "1")
		{	
			if ($row['nodo_tipo_s5'] != "0")
			{
				switch ($row['nodo_lasttipo_s5'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s5']), $row['nodo_tipo_s5'],0,$row['nodo_lasttipo_s5'],1,$row['nodo_aux_operacion5'],$row['nodo_aux_constante5'], $row['gw_id'], $row['nodo_ip'], 5)?></td>
<?php	
						break;
						
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s5']), $row['nodo_tipo_s5'],0,$row['nodo_lasttipo_s5'],1,$row['nodo_aux_operacion5'],$row['nodo_aux_constante5'], $row['gw_id'], $row['nodo_ip'], 5)?></td>
<?php						
						break;
				}
			}
			else
			{
?>			
				<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td style="width:45%"><br/></td>
<?php			
		}
?>
		</tr>
		<tr>
			<td class="etiqueta_tooltip" colspan="2" align="center">
<?php 
			$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
			echo sObtener_Fecha($cliente_db, $instalacion, $row['nodo_ultima_rx'],$zona_horaria);
?>
		</td>
<?php 
		if ($row['nodo_show_s6'] == "1")
		{
			if ($row['nodo_nombre_s6'] == "")
			{
?>			
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</td>
<?php 				
			}
			else
			{
?>				
				<td class="etiqueta_tooltip left_tborder" style="width:45%"><?php echo $row['nodo_nombre_s6']?></td>
<?php 	
			}
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:45%"></td>
<?php 				
		}

?>
		</tr>
		<tr>
			<td colspan="2" rowspan="3" align="center" class="etiqueta_tooltip">
<?php
			$ancho_bat_nodo=90;
			$alto_bat_nodo=40;
			$sNivelBatNodo=sConvertir_Datos_Nodo(hexdec($row['nodo_bateria']), 'BAT',0,'D',0,0,1);
			if ($sNivelBatNodo<=3.2)
			{
				echo '<img src="images/baterias/bateria_12.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			}
			else if ($sNivelBatNodo<=3.3)
			{
				echo '<img src="images/baterias/bateria_25.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			}
			else if ($sNivelBatNodo<=3.6)
			{
				echo '<img src="images/baterias/bateria_50.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			}
			else if ($sNivelBatNodo <= 3.8)
			{
				echo '<img src="images/baterias/bateria_75.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			}
			else if ($sNivelBatNodo < 3.95)
			{
				echo '<img src="images/baterias/bateria_90.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			}
			else
			{
				echo '<img src="images/baterias/bateria_100.png" width="'.$ancho_bat_nodo.'px" height="'.$alto_bat_nodo.'px"></img>';
			} 
?>
			</td>
<?php			
		if ($row['nodo_show_s6'] == "1")
		{	
			if ($row['nodo_tipo_s6'] != "0")
			{
				switch ($row['nodo_lasttipo_s6'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s6']), $row['nodo_tipo_s6'],0,$row['nodo_lasttipo_s6'],1,$row['nodo_aux_operacion6'],$row['nodo_aux_constante6'], $row['gw_id'], $row['nodo_ip'], 6)?></td>
<?php	
						break;
				
					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:45%"><?php echo sConvertir_Datos_Nodo(hexdec($row['nodo_last_s6']), $row['nodo_tipo_s6'],0,$row['nodo_lasttipo_s6'],1,$row['nodo_aux_operacion6'],$row['nodo_aux_constante6'], $row['gw_id'], $row['nodo_ip'], 6)?></td>
<?php						
						break;
				}
			}
			else
			{
?>			
				<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:45%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td style="width:45%"><br/></td>
<?php			
		}
?>
		</tr>
		<tr>
			<td rowspan="2" colspan="2" align="right" class="etiqueta_tooltip">
<?php					
				if ($_SESSION['perfil'] < 2)
				{
?>				
					<input type="button" onclick="window.parent.OnConfiguracion(1,'<?php echo $gw_id?>','<?php echo $nodo_mac?>','<?php echo $row['nodo_ip']?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general14']?>"/>
<?php					
				}
?>					
			</td>
			<td style="width:45%"></td>
		</tr>
		<tr>
			<td style="width:45%"></td>
		</tr>
<?php			
		if ($_SESSION['perfil'] < 3)
		{
?>			
		<tr>
			<td colspan="2" align="center" class="etiqueta_tooltip">
				<input type="button" onclick="
<?php
				if (($row['gw_tipo'] == $tipo_gw ) && ($row['gw_vSW'] < $version_offline))
				{
?>					
					window.parent.vEnviar_Comando('R<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>');					
<?php
				}
				else
				{
?>
					window.parent.vEnviar_Comando_Offline('R<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>', '<?php echo $gw_id?>', '<?php echo $row['nodo_ip']?>', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');<?}?>" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general148']?>"/>
<?php 
				if($row['nodo_TNO'] == 3)
				{
					if (($row['gw_tipo'] == $tipo_gw ) && ($row['gw_vSW'] < $version_offline))
					{
?>					
						<input type="button" onclick="window.parent.vEnviar_Comando('I<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>');" value="Imagen"/>&nbsp;&nbsp;					
<?php
					}
					else
					{
?>
						<input type="button" onclick="window.parent.vEnviar_Comando_Offline('I<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>', '<?php echo $gw_id?>', '<?php echo $row['nodo_ip']?>', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="Imagen"/>&nbsp;&nbsp;
<?php
					}
				}
				if (($row['gw_tipo'] == $tipo_gw ) && ($row['gw_vSW'] < $version_offline))
				{
?>					
					<input type="button" onclick="window.parent.vEnviar_Comando('A<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general149']?>"/>
<?php
				}
				else
				{
?>
					<input type="button" onclick="window.parent.vEnviar_Comando_Offline('A<?php echo $gw_id?>N<?php echo $row['nodo_ip']?>', '<?php echo $gw_id?>', '<?php echo $row['nodo_ip']?>', '<?php echo $cliente_db?>', '<?php echo $instalacion?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general149']?>"/>
<?php
				}
?>
			</td>
			<td align="right" style="width:45%">
				<input type="button" onclick="window.parent.OnDatosDatosNodo('<?php echo $gw_id?>','<?php echo $nodo_mac?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general150']?>"/>
			</td>
		</tr>
<?php 
		}
	}
?>
		</table>
		</div>
		</body>
		</html>
<?php 		
}
mysql_free_result($result);
mysql_close($link);
?>
