	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general190'].' '.$id_gateway?></span>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">
				<div id="a_tabbar" style="width:95%; height:420px;">				
					<div id='params_gw_1' >						
						<form action="configuracion_gw_imagen_low.php" method="post" name="config_gw_form">
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>						
								<td colspan="4" style="height:30px"></td>
							</tr>
							<tr>						
								<td style="width:27%"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general98']?></span></td>
								<td style="width:42%" align="center">	
<?php
	if ($iVersiones == 0)
	{
?>									
									<table border="0" width="98%" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center">
											<table border="0" width="98%" cellpadding="0" cellspacing="0">
											<tr style="height:10px">
												<td style="width:5%"></td>
												<td style="width:45%" align="center">
													<span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param107'];?></span>
													<span class="texto_secciones" id="VHW"></span>			
												</td>
												<td style="width:45%" align="center">
													<span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param106'];?></span>
													<span class="texto_secciones" id="VSW"></span>
												</td>
												<td style="width:4%"></td>
											</tr>
											</table>
										</td>
									</tr>		
									</table>	
<?php
	}
?>
								</td>
								<td style="width:27%" align="right">									
									<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $id_gateway?>"/>
									<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $_POST['xml_params']?>"/>										
									<input type="submit" name="boton_config_imagen_gw" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general191']?>" class="boton_fino_medio" id="boton_imagen"/>	
								</td>
								<td style="width:4%"></td>						
							</tr>
						</table>
						</form>	
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param4']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param97']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general326']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="NGW" id="NGW" style="width:180px;text-align:center" class="texto_valores" maxlength="20"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="CTA" id="CTA" style="width:80px;text-align:center" class="texto_valores" maxlength="4"/> <span class="texto_parametros">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<select name="HMR" id="HMR" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
<?php
	if ($iVersiones == 1)
	{
?>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>						
								<td style="width:45%"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general75']?></span></td>
								<td style="width:55%"></td>
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
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param107']?></span>
											</td>
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param106']?></span>
											</td>
											<td style="width:10%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<select name="VHW" id="VHW" style="width:50px;text-align:center" class="texto_valores">
												<?php
												echo Rellenar_VersionesHW_GW_LOW();
												?>
												</select>
											</td>
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<select name="VSW" id="VSW" style="width:50px;text-align:center" class="texto_valores">
												<?php
												echo Rellenar_VersionesSW_GW_LOW();
												?>
												</select>
											</td>
											<td style="width:10%"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left"><span class="texto_secciones">TCP/UDP</span></td></tr>
						</table>
<?php
	}
	else
	{
?>						
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left"><span class="texto_secciones">TCP/UDP</span></td></tr>
						</table>
<?php
	}
?>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param13']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param14']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<input type="text" name="CIS" id="CIS" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<input type="text" name="CID" id="CID" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="height:20px"><td colspan="5"></td></tr>
									</table>
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param98']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param99']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<input type="text" name="CIP" id="CIP" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:47%" align="center">
												<input type="text" name="CIT" id="CIT" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
							</div>
					</div>
					<div id="analog_tabbar">
					</div>
					<div id="digital_tabbar">
					</div>
					<div id='params_gw_2' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S1</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0">
										<tr style="height:5px">
											<td style="width:5%"></td>
											<td style="width:2%"></td>
											<td style="width:5%"></td>
											<td style="width:2%"></td>	
											<td style="width:8%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center" colspan="5">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="5">
												<input type="text" name="SN0" id="SN0" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0T" id="A0T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A0T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0W" id="A0W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0M" id="A0M" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0N" id="A0N" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<select name="A0K" id="A0K" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('0')"/>
											</td>
											<td align="center">
												<select id="A0V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A0E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0U" id="A0U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A0U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A0L" id="A0L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A0L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_maximo']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_minimo']?></span>
											</td>	
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>																																	
											<td></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="4">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td align="center">
												<input type="text" name="M0X" id="M0X" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="M0N" id="M0N" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<select name="U0D" id="U0D" style="width:60px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>												
											<td></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH0" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4" rowspan="3">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA0" id="MAXA0" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA0','MAXA01','MAXA02','MAXA03')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA01" id="MAXA01" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA02" id="MAXA02" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA03" id="MAXA03" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA0" id="MINA0" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA0','MINA01','MINA02','MINA03')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA01" id="MINA01" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA02" id="MINA02" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA03" id="MINA03" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td colspan="4"></td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<select name="A0P" id="A0P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td colspan="4" align="center">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH0" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_3' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S2</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:5%"></td>
											<td style="width:2%"></td>
											<td style="width:5%"></td>
											<td style="width:2%"></td>	
											<td style="width:8%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>								
										<tr>
											<td align="center" colspan="5">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="5">
												<input type="text" name="SN1" id="SN1" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1T" id="A1T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A1T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1W" id="A1W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1M" id="A1M" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1N" id="A1N" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<select name="A1K" id="A1K" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('1')"/>
											</td>
											<td align="center">
												<select id="A1V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A1E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1U" id="A1U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A1U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A1L" id="A1L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A1L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_maximo']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_minimo']?></span>
											</td>	
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>																																	
											<td></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="4">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td align="center">
												<input type="text" name="M1X" id="M1X" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="M1N" id="M1N" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<select name="U1D" id="U1D" style="width:60px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>												
											<td></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH1" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4" rowspan="3">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA1" id="MAXA1" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA1','MAXA11','MAXA12','MAXA13')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA11" id="MAXA11" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA12" id="MAXA12" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA13" id="MAXA13" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA1" id="MINA1" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA1','MINA11','MINA12','MINA13')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA11" id="MINA11" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA12" id="MINA12" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA13" id="MINA13" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td colspan="4"></td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<select name="A1P" id="A1P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td colspan="4" align="center">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH1" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
									</table>
								</div>
						</div>
				</div>
					<div id='params_gw_4' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S3</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:5%"></td>
											<td style="width:2%"></td>
											<td style="width:5%"></td>
											<td style="width:2%"></td>	
											<td style="width:8%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center"  colspan="5">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="5">
												<input type="text" name="SN2" id="SN2" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2T" id="A2T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A2T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2W" id="A2W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2M" id="A2M" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2N" id="A2N" style="width:35px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td ></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td colspan="6" align="center">
												<select name="A2K" id="A2K" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('2')"/>
											</td>
											<td align="center">
												<select id="A2V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A2E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2U" id="A2U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A2U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A2L" id="A2L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A2L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="13"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_maximo']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_minimo']?></span>
											</td>	
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>																																	
											<td></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="4">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td align="center">
												<input type="text" name="M2X" id="M2X" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="M2N" id="M2N" style="width:30px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td></td>
											<td align="center">
												<select name="U2D" id="U2D" style="width:60px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>												
											<td></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH2" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4" rowspan="3">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA2" id="MAXA2" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA2','MAXA21','MAXA22','MAXA23')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA21" id="MAXA21" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA22" id="MAXA22" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA23" id="MAXA23" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA2" id="MINA2" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA2','MINA21','MINA22','MINA23')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA21" id="MINA21" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA22" id="MINA22" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA23" id="MINA23" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td colspan="4"></td>
										</tr>
										<tr style="height:10px">
											<td colspan="6" align="center">
												<select name="A2P" id="A2P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td colspan="4" align="center">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH2" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
									</table>
								</div>
						</div>
				</div>
					<div id='params_gw_5' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A1</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:22%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<input type="text" name="SN3" id="SN3" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3T" id="A3T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A3T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3W" id="A3W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3M" id="A3M" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3N" id="A3N" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<select name="A3K" id="A3K" style="width:160px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('3')"/>
											</td>
											<td></td>
											<td align="center">
												<select id="A3V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A3E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3U" id="A3U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A3U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A3L" id="A3L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A3L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center"></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH3" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA3" id="MAXA3" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA3','MAXA31','MAXA32','MAXA33')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA31" id="MAXA31" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA32" id="MAXA32" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA33" id="MAXA33" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA3" id="MINA3" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA3','MINA31','MINA32','MINA33')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA31" id="MINA31" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA32" id="MINA32" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA33" id="MINA33" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<select name="A3P" id="A3P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH3" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="6"></td>
										</tr>
									</table>
								</div>
						</div>
				</div>
					<div id='params_gw_6' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A2</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:22%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<input type="text" name="SN4" id="SN4" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4T" id="A4T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A4T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4W" id="A4W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4M" id="A4M" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4N" id="A4N" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<select name="A4K" id="A4K" style="width:160px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('4')"/>
											</td>
											<td></td>
											<td align="center">
												<select id="A4V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A4E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4U" id="A4U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A4U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A4L" id="A4L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A4L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center"></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH4" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA4" id="MAXA4" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA4','MAXA41','MAXA42','MAXA43')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA41" id="MAXA41" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA42" id="MAXA42" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA43" id="MAXA43" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA4" id="MINA4" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA4','MINA41','MINA42','MINA43')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA41" id="MINA41" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA42" id="MINA42" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA43" id="MINA43" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<select name="A4P" id="A4P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH4" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="6"></td>
										</tr>
									</table>
								</div>
						</div>
				</div>
					<div id='params_gw_7' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A3</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0">
										<tr style="height:5px">
											<td style="width:22%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<input type="text" name="SN5" id="SN5" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5T" id="A5T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A5T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5W" id="A5W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5M" id="A5M" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5N" id="A5N" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<select name="A5K" id="A5K" style="width:160px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('5')"/>
											</td>
											<td></td>
											<td align="center">
												<select id="A5V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A5E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5U" id="A5U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A5U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A5L" id="A5L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A5L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center"></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH5" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA5" id="MAXA5" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA5','MAXA51','MAXA52','MAXA53')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA51" id="MAXA51" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA52" id="MAXA52" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA53" id="MAXA53" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA5" id="MINA5" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA5','MINA51','MINA52','MINA53')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA51" id="MINA51" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA52" id="MINA52" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA53" id="MINA53" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<select name="A5P" id="A5P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH5" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="6"></td>
										</tr>
									</table>
								</div>
						</div>
				</div>
					<div id='params_gw_8' style='display:none;'>
							<table border="0" width="98%" cellpadding="0" cellspacing="0">
								<tr><td colspan="6" style="height:20px"></td></tr>
								<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A4</span></td></tr>
							</table>
							<div class="rounded2-big-box">
								    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
								    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
								    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
								    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
									<div class="box2-contents">
										<table border="0" width="98%" cellpadding="0" cellspacing="0">
										<tr style="height:5px">
											<td style="width:22%"></td>
											<td style="width:2%"></td>
											<td style="width:16%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
											<td style="width:2%"></td>
											<td style="width:18%"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param101']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param102']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param103']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<input type="text" name="SN6" id="SN6" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6T" id="A6T" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A6T_unit" class="texto_valores">mins</span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6W" id="A6W" style="width:35px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6M" id="A6M" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6N" id="A6N" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param51']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param53']?></span>
											</td>
										</tr>
										<tr>
											<td align="center">
												<select name="A6K" id="A6K" style="width:160px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowA('6')"/>
											</td>
											<td></td>
											<td align="center">
												<select id="A6V" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="A6E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6U" id="A6U" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A6U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="A6L" id="A6L" style="width:50px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="A6L_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center"></td>
											<td align="center" colspan="4"></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param100']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH6" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder">
															<input type="checkbox" name="MAXA6" id="MAXA6" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXA6','MAXA61','MAXA62','MAXA63')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXA61" id="MAXA61" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXA62" id="MAXA62" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXA63" id="MAXA63" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINA6" id="MINA6" style="width:20px;text-align:center" onclick="OnClickActuacion('MINA6','MINA61','MINA62','MINA63')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINA61" id="MINA61" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINA62" id="MINA62" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINA63" id="MINA63" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="6">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<select name="A6P" id="A6P" style="width:170px;text-align:center" class="texto_valores"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH6" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="6"></td>
										</tr>
									</table>
									</div>
							</div>
					</div>
					<div id='params_gw_9' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']?> 1</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:2%"></td>
											<td style="width:13%"></td>
											<td style="width:2%"></td>
											<td style="width:13%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr>
											<td></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td></td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td colspan="4"><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span></td>
													</tr>
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder bottom_tborder">
															<input type="checkbox" name="MAXD0" id="MAXD0" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXD0','MAXD01','MAXD02','MAXD03')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MAXD01" id="MAXD01" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MAXD02" id="MAXD02" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MAXD03" id="MAXD03" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td></td>
											<td align="center" colspan="3">
												<input type="text" name="SN7" id="SN7" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="D0T" id="D0T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D0T_unit" class="texto_valores">mins</span>												
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="D0U" id="D0U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D0U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr style="width:100%">
											<td></td>
											<td style="width:30%" align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH7" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
										</tr>
										<tr style="height:10px">
											<td></td>
											<td align="center" colspan="3">
												<select name="D0K" id="D0K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('0')"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH7" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="9"></td>
											<td align="center">
												<select id="D0C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td align="center">
												<select id="D0E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']?> 2</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="height:5px">
											<td style="width:2%"></td>
											<td style="width:13%"></td>
											<td style="width:2%"></td>
											<td style="width:13%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
											<td style="width:2%"></td>
											<td style="width:15%"></td>
										</tr>
										<tr>
											<td></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td></td>
											<td align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td colspan="4"><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span></td>
													</tr>
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder bottom_tborder">
															<input type="checkbox" name="MAXD1" id="MAXD1" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXD1','MAXD11','MAXD12','MAXD13')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MAXD11" id="MAXD11" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MAXD12" id="MAXD12" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MAXD13" id="MAXD13" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td></td>
											<td align="center" colspan="3">
												<input type="text" name="SN8" id="SN8" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="D1T" id="D1T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D1T_unit" class="texto_valores">mins</span>												
											</td>
											<td></td>
											<td align="center">
												<input type="text" name="D1U" id="D1U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D1U_unit" class="texto_valores"></span>
											</td>
											<td></td>
											
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
										</tr>
										<tr>
											<td></td>
											<td align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH8" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
										</tr>
										<tr style="height:10px">
											<td></td>
											<td align="center" colspan="3">
												<select name="D1K" id="D1K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('1')"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH8" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr style="height:10px">
											<td colspan="9"></td>
											<td align="center">
												<select id="D1C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td></td>
											<td align="center">
												<select id="D1E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_10' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 3</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:28%" align="center" colspan="3" rowspan="4">
												<table border="0" cellspacing="0">
													<tr>
														<td colspan="4"><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span></td>
													</tr>
													<tr>
														<td></td>
														<td align="center" class="left_tborder top_tborder">
															<span class="texto_parametros">1</span>
														</td>
														<td align="center" class="top_tborder">
															<span class="texto_parametros">2</span>
														</td>
														<td align="center" class="right_tborder top_tborder">
															<span class="texto_parametros">3</span>
														</td>
													</tr>
													<tr>
														<td class="left_tborder top_tborder bottom_tborder">
															<input type="checkbox" name="MAXD2" id="MAXD2" style="width:20px;text-align:center" onclick="OnClickActuacion('MAXD2','MAXD21','MAXD22','MAXD23')"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MAXD21" id="MAXD21" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MAXD22" id="MAXD22" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MAXD23" id="MAXD23" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center" colspan="3">
												<input type="text" name="SN9" id="SN9" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D2T" id="D2T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D2T_unit" class="texto_valores">mins</span>												
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D2U" id="D2U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D2U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="9"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center" colspan="3">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH9" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td style="width:2%"></td>
											<td style="width:30%" align="center" colspan="3">
												<select name="D2K" id="D2K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('9')"/>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH9" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
											</td>
											<td align="center" colspan="4">
											</td>
											<td style="width:2%"></td>
											<td align="center">
												<select id="D2C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td align="center">
												<select id="D2E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="9"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 4</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN10" id="SN10" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D3T" id="D3T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D3T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D3U" id="D3U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D3U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D3C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D3E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH10" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH10" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D3K" id="D3K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('3')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_11' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 5</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN11" id="SN11" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D4T" id="D4T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D4T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D4U" id="D4U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D4U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D4C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D4E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH11" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH11" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D4K" id="D4K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('4')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 6</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN12" id="SN12" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D5T" id="D5T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D5T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D5U" id="D5U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D5U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D5C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D5E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH12" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH12" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D5K" id="D5K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('5')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_12' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 7</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN13" id="SN13" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D6T" id="D6T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D6T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D6U" id="D6U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D6U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D6C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D6E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH13" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH13" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D6K" id="D6K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('6')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 8</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN14" id="SN14" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D7T" id="D7T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D7T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D7U" id="D7U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D7U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D7C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D7E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH14" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH14" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D7K" id="D7K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('7')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_13' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 9</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN15" id="SN15" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D8T" id="D8T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D8T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D8U" id="D8U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D8U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D8C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D8E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH15" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH15" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D8K" id="D8K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('8')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 10</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN16" id="SN16" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D9T" id="D9T" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D9T_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="D9U" id="D9U" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="D9U_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D9C" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="D9E" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH16" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH16" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="D9K" id="D9K" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('9')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_14' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 11</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN17" id="SN17" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DAT" id="DAT" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DAT_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DAU" id="DAU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DAU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DAC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DAE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH17" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH17" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DAK" id="DAK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('A')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 12</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN18" id="SN18" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DBT" id="DBT" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DBT_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DBU" id="DBU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DBU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DBC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DBE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center"></td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH18" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH18" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DBK" id="DBK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('B')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_15' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 1</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN19" id="SN19" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DCT" id="DCT" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DCT_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DCU" id="DCU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DCU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DCC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DCE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH19" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH19" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DCK" id="DCK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('C')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 2</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN20" id="SN20" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DDT" id="DDT" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DDT_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DDU" id="DDU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DDU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DDC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DDE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH20" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH20" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DDK" id="DDK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('D')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_16' style='display:none;'>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 3</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN21" id="SN21" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DET" id="DET" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DET_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DEU" id="DEU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DEU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DEC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DEE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH21" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH21" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DEK" id="DEK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('E')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td colspan="6" style="height:20px"></td></tr>
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> 4</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param96']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param95']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param105']?></span>
											</td>
										</tr>
										<tr>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="SN22" id="SN22" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DFT" id="DFT" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DFT_unit" class="texto_valores">mins</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<input type="text" name="DFU" id="DFU" style="width:35px;text-align:center" class="texto_valores" maxlength="6"/>
												<span id="DFU_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DFC" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:13%" align="center">
												<select id="DFE" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="10"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:32%"  colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH22" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
											<td align="center" colspan="4">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH22" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option id='0'>OFF</option>
													<option id='1'>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="2" align="center">
												<select name="DFK" id="DFK" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades_lowD('F')"/>
											</td>
											<td colspan="7"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
				</div>
				<script>
						
						tabbar = new dhtmlXTabBar("a_tabbar", "top");
						tabbar.setSkin('dark_blue');
						tabbar.setImagePath("codebase/imgs/");
						AnchoTabAux=document.getElementById('a_tabbar').offsetWidth/10;
						tabbar.addTab("a1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general104']?>", 2.5*AnchoTabAux);
						tabbar.addTab("a2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general292']?>", 3.5*AnchoTabAux);
						tabbar.addTab("a3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general293']?>", 3.5*AnchoTabAux);
						tabbar.setContent("a1", "params_gw_1");
						tabbar.setContent("a2", "analog_tabbar");
						tabbar.setContent("a3", "digital_tabbar");
						
						var tabbaranalog = tabbar.cells("a2").attachTabbar();
						var tabbardigital = tabbar.cells("a3").attachTabbar();
						
						tabbaranalog.setSkin('dark_blue');
						tabbaranalog.setImagePath("codebase/imgs/");
						tabbaranalog.addTab("analog1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S1", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S2", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> S3", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog4", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A1", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog5", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A2", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog6", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A3", 1.4*AnchoTabAux);
						tabbaranalog.addTab("analog7", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']?> A4", 1.4*AnchoTabAux);
						
						tabbaranalog.setContent("analog1", "params_gw_2");
						tabbaranalog.setContent("analog2", "params_gw_3");
						tabbaranalog.setContent("analog3", "params_gw_4");
						tabbaranalog.setContent("analog4", "params_gw_5");
						tabbaranalog.setContent("analog5", "params_gw_6");
						tabbaranalog.setContent("analog6", "params_gw_7");
						tabbaranalog.setContent("analog7", "params_gw_8");
						
						
						tabbardigital.setSkin('dark_blue');
						tabbardigital.setImagePath("codebase/imgs/");
						tabbardigital.addTab("digital1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general351']?> ", 3.2*AnchoTabAux);
						/* 
						tabbardigital.addTab("digital2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> II", 1.2AnchoTabAux);
						tabbardigital.addTab("digital3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> III", 1.2AnchoTabAux);
						tabbardigital.addTab("digital4", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> IV", 1.2AnchoTabAux);
						tabbardigital.addTab("digital5", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> V", 1.2AnchoTabAux);
						tabbardigital.addTab("digital6", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> VI", 1.2AnchoTabAux);*/
						tabbardigital.addTab("digital7", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> I", 3.2*AnchoTabAux);
						tabbardigital.addTab("digital8", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']?> II", 3.2*AnchoTabAux);
						
						tabbardigital.setContent("digital1", "params_gw_9");
						/*tabbardigital.setContent("digital2", "params_gw_10");
						tabbardigital.setContent("digital3", "params_gw_11");
						tabbardigital.setContent("digital4", "params_gw_12");
						tabbardigital.setContent("digital5", "params_gw_13");
						tabbardigital.setContent("digital6", "params_gw_14");*/
						tabbardigital.setContent("digital7", "params_gw_15");
						tabbardigital.setContent("digital8", "params_gw_16");
						
						tabbar.attachEvent("onSelect", function() {
							OnTabGroupChange(arguments);
					    	return true;
						});
						tabbar.setTabActive("a1");
						
				</script>
				<script>
							
				</script>
			</td>
		</tr>
	</table>