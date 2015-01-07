<div id="tab_digital" style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" style=width:100%;height:150px;">					
		<tr>
<?php
		
		if ($row['gw_show_sensor8'] == "1")
		{
			if ($row['gw_nombre_s8'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 1</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s8']?></td>
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
		<td rowspan="6" style="width:4%"></td>
<?php				
		if ($row['gw_show_sensor21'] == "1")
		{
			if ($row['gw_nombre_s21'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s21']?></td>
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
		if ($row['gw_show_sensor8'] == "1")
		{
			if ($row['gw_tipo_sensor8'] != "0")
			{
				switch ($row['gw_lasttipo_sensor8'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor8']), $row['gw_tipo_sensor8'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor8']), $row['gw_tipo_sensor8'], 0, 0, 0, 1, "12")?></td>
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
		if ($row['gw_show_sensor21'] == "1")
		{
			if ($row['gw_tipo_sensor21'] != "0")
			{
				switch ($row['gw_lasttipo_sensor21'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor21']), $row['gw_tipo_sensor21'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor21']), $row['gw_tipo_sensor21'], 0, 0, 0, 1, "12")?></td>
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
		
		if ($row['gw_show_sensor9'] == "1")
		{
			if ($row['gw_nombre_s9'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 2</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s9']?></td>
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
			
<?php				
		if ($row['gw_show_sensor22'] == "1")
		{
			if ($row['gw_nombre_s22'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s22']?></td>
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
		if ($row['gw_show_sensor9'] == "1")
		{	
			if ($row['gw_tipo_sensor9'] != "0")
			{
				switch ($row['gw_lasttipo_sensor9'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor9']), $row['gw_tipo_sensor9'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor9']), $row['gw_tipo_sensor9'], 0, 0, 0, 1, "12")?></td>
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
		if ($row['gw_show_sensor22'] == "1")
		{	
			if ($row['gw_tipo_sensor22'] != "0")
			{
				switch ($row['gw_lasttipo_sensor22'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor22']), $row['gw_tipo_sensor22'], 0, 0, 0, 1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor22']), $row['gw_tipo_sensor22'], 0, 0, 0, 1, "12")?></td>
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
		if ($row['gw_show_sensor20'] == "1")
		{
			if ($row['gw_nombre_s20'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 3</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s20']?></td>
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
<?php
		if ($row['gw_show_sensor23'] == "1")
		{
			if ($row['gw_nombre_s23'] == "")
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</td>
<?php 				
			}
			else 
			{
?>								
				<td class="etiqueta_tooltip left_tborder" style="width:48%"><?php echo $row['gw_nombre_s23']?></td>
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
		if ($row['gw_show_sensor20'] == "1")
		{	
			if ($row['gw_tipo_sensor20'] != "0")
			{
				switch ($row['gw_lasttipo_sensor20'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor20']), $row['gw_tipo_sensor20'], 0, 0, 0 ,1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor20']), $row['gw_tipo_sensor20'], 0, 0, 0, 1, "12")?></td>
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
		if ($row['gw_show_sensor23'] == "1")
		{	
			if ($row['gw_tipo_sensor23'] != "0")
			{
				switch ($row['gw_lasttipo_sensor23'])
				{
					case 'U':
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip_umbral left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor23']), $row['gw_tipo_sensor23'], 0, 0, 0 ,1, "12")?></td>
<?php						
						break;

					default:
?>
						<td class="tipo_fila_tooltip etiqueta_valor_tooltip left_tborder bottom_tborder" align="right" style="width:48%"><?php echo sConvertir_Datos_GW(hexdec($row['gw_last_sensor23']), $row['gw_tipo_sensor23'], 0, 0, 0 , 1, "12")?></td>
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
	</table>
</div>	
