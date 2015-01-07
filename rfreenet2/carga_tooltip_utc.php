<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_medidas.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_db.inc';

function vGet_Datos($link, $NombreTabla, &$query2, &$result2, &$sig_tabla, $numEvento, $gw_id, $direccion)
{
	if (table_exists($NombreTabla, $link))
	{
		$query2 = sprintf("select analizador_nombre, evento_codigo, evento_valor_raw as valor, evento_tiposensor as tiposensor,modbus_operacion,modbus_operando FROM 
				rfreenet_general.rfreenet_modbus_conversion INNER JOIN (cliente_analizadores INNER JOIN (%s  as cliente_eventos)
		  	   	ON (cliente_eventos.nodo_mac=cliente_analizadores.analizador_id AND 
	   	    	cliente_eventos.evento_codigo>299 AND cliente_eventos.evento_codigo<400)) ON (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo AND 
	   	    	rfreenet_modbus_conversion.modbus_evento=cliente_eventos.evento_codigo) WHERE evento_codigo='%s' AND cliente_eventos.gw_id='%s' AND cliente_eventos.nodo_ip='%s' ORDER BY evento_fecha DESC LIMIT 1;",$NombreTabla,$numEvento,$gw_id,$direccion);
		//echo $query2;
		$result2 = mysql_query($query2);
		if(mysql_num_rows($result2)!=1)
		{
			$sig_tabla = 1;
		}
	}
}


$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$disp_id = $_GET["disp_id"];
$cliente_db = $_GET["cliente_db"];
 

mysql_select_db($cliente_db, $link);
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																					
$query = sprintf("SELECT analizador_id,analizador_nombre,analizador_latitud,analizador_longitud,analizador_estado,analizador_show_image,analizador_direccion,unix_timestamp(analizador_ultima_rx) as analizador_ultima_rx,analizador_vector_magnitudes,modbus_tipo,gw_id FROM cliente_analizadores inner join rfreenet_general.rfreenet_modbus ON cliente_analizadores.analizador_tipo=rfreenet_modbus.modbus_id WHERE instalacion_id='%s' AND analizador_id='%s';", $instalacion, $disp_id);
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
<?php
		if ($row['modbus_tipo'] == "1")
		{			
				echo "<div style='width:350px;height:225px'>";
		}
		else
		{
?>
		<div id="tooltip_mapa" style="width:290px;height:235px">
<?php 		
		}
?>
		<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:100%">
		<tr>
			<td  class="texto_titulo_tooltip" align="center" style="width:100%" colspan="2"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general255'].' '.$row['analizador_direccion']?></td>
		</tr>
		<tr>
			<td style="width:40%" align="center">
<?php
		if ($row['analizador_show_image'] == "1")
		{			
				echo "<img src='descargar_imagen_utc.php?cliente_db=".$cliente_db."&disp_id=".$disp_id."' width='155px' height='150px' align='center' border='1'></img>";
		}
		else
		{
?>
				<img src="images/sin_imagen.jpg" width="155px" height="150px" style="border:1"></img>
<?php 		
		}
?>
			</td style="width:60%">
			<td valign="top">
<?php
		if ($row['modbus_tipo'] == "1")
		{
?>		
				<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:100%">
					<tr>
						<td class="etiqueta_tooltip left_tborder" width="45%">
							<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type52']?>
						</td>
						<td>
							<br>
						</td>
						<td class="etiqueta_tooltip left_tborder" width="45%">
							pH
						</td>
					</tr>
					<tr>
<?php
						$mes1 = date(m);
						$anyo1 = date(Y);
						$mes2 = date(m,strtotime("-1 month"));
						$anyo2 = date(Y,strtotime("-1 month"));
						$mes3 = date(m,strtotime("-2 month"));
						$anyo3 = date(Y,strtotime("-2 month"));
						$cadena1=sprintf("%02u%04u",$mes1,$anyo1);		
						$cadena2=sprintf("%02u%04u",$mes1,$anyo1);		
						$cadena3=sprintf("%02u%04u",$mes1,$anyo1);		
						$NombreTabla = "cliente_eventos_".$cadena1;
						$sig_tabla = 0;
						vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '300',$row['gw_id'],$row['analizador_direccion']);
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena2;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '300',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena3;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '300',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
						}
						else
						{
							if($row2 = mysql_fetch_array($result2))
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' >".sConvertir_Datos_UTC(hexdec($row2['valor']), $row2['tiposensor'],0,$row2['modbus_operacion'],$row2['modbus_operando'],1)."</td>";
							}
							else 
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
							}
						}
						mysql_free_result($result2);
?>
						<td>
							<br>
						</td>
<?php
						
						$NombreTabla = "cliente_eventos_".$cadena1;
						$sig_tabla = 0;
						vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '301',$row['gw_id'],$row['analizador_direccion']);
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena2;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '301',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena3;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '301',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
						}
						else
						{
							if($row2 = mysql_fetch_array($result2))
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' >".sConvertir_Datos_UTC(hexdec($row2['valor']), $row2['tiposensor'],0,$row2['modbus_operacion'],$row2['modbus_operando'],1)."</td>";
							}
							else 
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
							}
						}
						mysql_free_result($result2);
?>
					</tr>
					<tr>
						<td class="etiqueta_tooltip left_tborder" width="45%">
							ORP
						</td>
						<td>
							<br>
						</td>
						<td class="etiqueta_tooltip left_tborder" width="45%">
							<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type2']?>
						</td>
					</tr>
					<tr>
<?php
						
						$NombreTabla = "cliente_eventos_".$cadena1;
						$sig_tabla = 0;
						vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '302',$row['gw_id'],$row['analizador_direccion']);
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena2;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '302',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena3;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '302',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
						}
						else
						{
							if($row2 = mysql_fetch_array($result2))
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' >".sConvertir_Datos_UTC(hexdec($row2['valor']), $row2['tiposensor'],0,$row2['modbus_operacion'],$row2['modbus_operando'],1)."</td>";
							}
							else 
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
							}
						}
						mysql_free_result($result2);
?>
						<td>
							<br>
						</td>
<?php
						
						$NombreTabla = "cliente_eventos_".$cadena1;
						$sig_tabla = 0;
						vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '303',$row['gw_id'],$row['analizador_direccion']);
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena2;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '303',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							$sig_tabla = 0;
							$NombreTabla = "cliente_eventos_".$cadena3;
							vGet_Datos($link, $NombreTabla, $query2, $result2, $sig_tabla, '303',$row['gw_id'],$row['analizador_direccion']);
						}
						if($sig_tabla == 1)
						{
							echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
						}
						else
						{
							if($row2 = mysql_fetch_array($result2))
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' >".sConvertir_Datos_UTC(hexdec($row2['valor']), $row2['tiposensor'],0,$row2['modbus_operacion'],$row2['modbus_operando'],1)."</td>";
							}
							else 
							{
								echo "<td class='tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder' align='right' style='width:45%'>NO</td>";
							}
						}
						mysql_free_result($result2);
?>
					</tr>
					<tr>
						<td colspan="3" class="etiqueta_valor_tooltip_umbral">
						</br>
						</td>
					</tr>
<?php
					$query2 = sprintf("select analizador_vector_errores, analizador_vector_alarmas, analizador_vector_warnings FROM cliente_analizadores WHERE gw_id='%s' AND analizador_direccion='%s' LIMIT 1;",$row['gw_id'],$row['analizador_direccion']);

					$result2 = mysql_query($query2);
					if($result2)
					{
						if($row2 = mysql_fetch_array($result2))
						{
							$errores = $row2[0];
							$alarmas = $row2[1];
							$warnings = $row2[2];
						}
						else 
						{
							$errores = 0;
							$alarmas = 0;
							$warnings = 0;
						}
					}
?>
					<tr>
						<td colspan="3" class="etiqueta_valor_tooltip_umbral">
							<?php 
							if ($_SESSION['perfil']< 3)
							{
								$posicion_error = strpos($errores, "1");
								if($posicion_error !== false)
									echo $idiomas[$_SESSION['opcion_idioma']]['general302'].": ".sObtener_Cadena_Tipo_Sensor_UTC("62",($posicion_error+1));
							}
							?>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="etiqueta_valor_tooltip_umbral">
							<?php 
							if ($_SESSION['perfil']< 3)
							{
								$posicion_alarm = strpos($alarmas, "1");
								if($posicion_alarm !== false)
									echo $idiomas[$_SESSION['opcion_idioma']]['general303'].": ".sObtener_Cadena_Tipo_Sensor_UTC("63",($posicion_alarm+1));
							}
							?>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="etiqueta_valor_tooltip_umbral">
							<?php 
							if ($_SESSION['perfil']< 3)
							{
								$posicion_warning = strpos($warnings, "1");
								if($posicion_warning !== false)
									echo $idiomas[$_SESSION['opcion_idioma']]['general304'].": ".sObtener_Cadena_Tipo_Sensor_UTC("64",($posicion_warning+1));
							}
							?>
						</td>
					</tr>
				</table>
<?php 		
		}
?>
			</td>
		</tr>
		<tr>
			<td  class="etiqueta_tooltip" align="center"><?php echo $row['analizador_nombre']?></td><td></td>
		</tr>
		<tr>
			<td  class="etiqueta_tooltip" align="center">
				<?php 
					$zona_horaria = sObtener_TimeZone_Instalacion($cliente_db, $instalacion);
					echo sObtener_Fecha($cliente_db, $instalacion, $row['analizador_ultima_rx'],$zona_horaria);
				?>
				
				</td><td></td>
		</tr>
		<tr>
		<td class="texto_titulo_tooltip" align="center">
			<input type="button" onclick="window.parent.OnDatosDatosUTC('<?php echo $disp_id?>');" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general150']?>"/>
		</td>
		<td>
<?php					
			if ($_SESSION['perfil'] < 2)
			{
?>			
				<input type="button" onclick="window.parent.OnConfiguracion(11,'<?php echo $disp_id?>','<?php echo $row['analizador_direccion']?>',0);" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general14']?>"/>
<?php					
			}
?>						
		</td>
		</tr>
<?php 	
		
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