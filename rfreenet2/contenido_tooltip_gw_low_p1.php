<div id="tab_analogico" style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:150px;">					
		<tr>
<?php
		
		if ($row['gw_show_sensor1'] == "1")
		{
			if ($row['gw_nombre_s1'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 1</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s1']?></td>
<?php										
			}				
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
<?php 				
		}
?>
		<td rowspan="8" style="width:4%"></td>
<?php 
		if ($row['gw_show_sensor5'] == "1")
		{
			if ($row['gw_nombre_s5'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s5']?></td>
<?php										
			}				
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
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
				switch ($row['gw_lasttipo_sensor1'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor1']), $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor1']), $row['gw_tipo_sensor1'], 0, $row['gw_id'], 0, 1, "12")?></td>
<?php								
						break;
				}				
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
<?php			
		}
		if ($row['gw_show_sensor5'] == "1")
		{	
			if ($row['gw_tipo_sensor5'] != "0")
			{
				switch ($row['gw_lasttipo_sensor5'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor5']), $row['gw_tipo_sensor5'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor5']), $row['gw_tipo_sensor5'], 0, 0, 0, 1, "12")?></td>
<?php								
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td style="width:48%"><br/></td>
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
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 2</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s2']?></td>
<?php										
			}					
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
<?php 				
		}
		
		if ($row['gw_show_sensor6'] == "1")
		{
			if ($row['gw_nombre_s6'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s6']?></td>
<?php										
			}			
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
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
				switch ($row['gw_lasttipo_sensor2'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor2']), $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor2']), $row['gw_tipo_sensor2'], 0, $row['gw_id'], 1, 1, "12")?></td>
<?php								
						break;
				}			
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
<?php			
		}
		if ($row['gw_show_sensor6'] == "1")
		{
			if ($row['gw_tipo_sensor6'] != "0")
			{
				switch ($row['gw_lasttipo_sensor6'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor6']), $row['gw_tipo_sensor6'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor6']), $row['gw_tipo_sensor6'], 0, 0, 0, 1, "12")?></td>
<?php								
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
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
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 3</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s3']?></td>
<?php										
			}				
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
<?php 				
		}

		if ($row['gw_show_sensor7'] == "1")
		{
			if ($row['gw_nombre_s7'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 7</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s7']?></td>
<?php										
			}					
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
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
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor3']), $row['gw_tipo_sensor3'],0, $row['gw_id'], 2, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor3']), $row['gw_tipo_sensor3'], 0, $row['gw_id'], 2, 1, "12")?></td>
<?php								
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
<?php			
		}
		if ($row['gw_show_sensor7'] == "1")
		{	
			if ($row['gw_tipo_sensor7'] != "0")
			{
				switch ($row['gw_lasttipo_sensor7'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor7']), $row['gw_tipo_sensor7'],0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor7']), $row['gw_tipo_sensor7'], 0, 0, 0, 1, "12")?></td>
<?php								
						break;
				}	
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
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
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s4']?></td>
<?php										
			}					
		}
		else
		{
?>			
			<td class="etiqueta_tooltip" style="width:48%"></td>
<?php 				
		}

?>		
		<td class="etiqueta_tooltip" style="width:48%"></td>
		</tr>
		<tr>
<?php			
		if ($row['gw_show_sensor4'] == "1")
		{	
			if ($row['gw_tipo_sensor4'] != "0")
			{
				switch ($row['gw_lasttipo_sensor4'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor4']), $row['gw_tipo_sensor4'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor4']), $row['gw_tipo_sensor4'], 0, 0, 0, 1, "12")?></td>
<?php								
						break;
				}
			}
			else
			{
?>			
			<td align="right" class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general147']?></td>
<?php			
			}
		}
		else
		{		
?>
			<td class="etiqueta_valor_tooltip" style="width:48%"><br/></td>
<?php			
		}
?>
		<td class="etiqueta_tooltip" style="width:48%"></td>
		</tr>
	</table>
</div>	
