<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr style="width:100%" id="celda_tabla">
			<td  align="center">
<?php
	if ($iVersiones == 0)
	{
?>				
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general190'].' '.$id_gateway?></span>
<?php
	}
	else
	{
?>
				<span class="texto_titulo_tooltip"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general52'].' '.$idiomas[$_SESSION['opcion_idioma']]['general20']?></span>
<?php
	}
?>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%" id="celda_tabla_params">
			<td align="center">
				<div id="a_tabbar" style="width:95%; height:410px;">
					<div id='params_gw_1' >
<?php
	if ($iVersiones == 0)
	{
?>	
						<form action="configuracion_gw_imagen.html.php" method="post" name="config_gw_form">
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr style="height:10px">
								<td colspan="4"></td>
							</tr>
							<tr>						
								<td style="width:27%"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general98']?></span></td>
								<td style="width:42%" align="center">	
									<table border="0" width="98%" cellpadding="0" cellspacing="0">
									<tr><td align="center">
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
									</tr>		
									</table>				
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
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param37']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param4']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param5']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general326']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:20%" align="center">
												<input type="text" name="SUS" id="SUS" style="width:65px;text-align:center" disabled="disabled" value="<?php echo $id_gateway?>" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="NGW" id="NGW" style="width:180px;text-align:center" class="texto_valores" maxlength="20"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:20%" align="center">
												<input type="text" name="KEY" id="KEY" style="width:30px;text-align:center" class="texto_valores" maxlength="2"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:20%" align="center">
												<select name="HMR" id="HMR" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>					
<?php
	}
	else
	{
?>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr>						
								<td colspan="4"><br></br></td>
							</tr>
							<tr>						
								<td style="width:45%"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general98']?></span></td>
								<td style="width:5%">							
								</td>
								<td style="width:45%" align="right"></td>
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
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param4']?></span>
											</td>
											<td style="width:1%"></td>
											<td style="width:10%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param107']?></span>
											</td>
											<td style="width:1%"></td>
											<td style="width:10%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param106']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:10%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param5']?></span>
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
											<td style="width:1%"></td>
											<td style="width:10%" align="center">
												<select name="VHW" id="VHW" style="width:50px;text-align:center" class="texto_valores" onchange="OnVersionChange(0)">
												<?php
												echo Rellenar_VersionesHW_GW();
												?>
												</select>
											</td>
											<td style="width:1%"></td>
											<td style="width:10%" align="center">
												<select name="VSW" id="VSW" style="width:50px;text-align:center" class="texto_valores" onchange="OnVersionChange(1)">
												<?php
												echo Rellenar_VersionesSW_GW();
												?>
												</select>
											</td>
											<td style="width:1%"></td>
											<td style="width:10%" align="center">
												<input type="text" name="KEY" id="KEY" style="width:30px;text-align:center" class="texto_valores" maxlength="2"/>
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
	}
?>						
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general99']?></span></td></tr>
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
											<td style="width:45%" align="center">
												<span class="texto_parametros">DHCP</span>
											</td>
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param6']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<select name="DHP" id="DHP" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<input type="text" name="IPP" id="IPP" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param7']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param8']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<input type="text" name="MSK" id="MSK" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:45%" align="center">
												<input type="text" name="PDE" id="PDE" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
							</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general100']?></span></td></tr>
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
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param9']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param10']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param67']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="TPP" id="TPP" style="width:50px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
												<input type="text" name="ITC" id="ITC" style="width:50px;text-align:center" class="texto_valores" maxlength="3"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:30%" align="center">
<?php
	if ($iHabUTC == 1)
	{
?>													
												<input type="text" name="ITP" id="ITP" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
<?php
	}
	else
	{
?>
												<input type="text" name="ITP" id="ITP" style="width:50px;text-align:center;background-color: #999999" class="texto_valores" maxlength="5" disabled="disabled"/>
<?php												
	}
?>													
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_2' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general101']?></span></td></tr>
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
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param11']?></span>
											</td>
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param66']?></span>
											</td>
											<td style="width:10%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
												<select name="HPS" id="HPS" style="width:50px;text-align:center" class="texto_valores"/>
												
											</td>
											<td style="width:10%"></td>
											<td style="width:35%" align="center">
<?php
		if ($iHabModbusTCP == 1)
		{
?>													
												<select name="MTP" id="MTP" style="width:50px;text-align:center" class="texto_valores"/>
<?php
		}
		else
		{
?>	
												<select name="MTP" id="MTP" style="width:50px;text-align:center;background-color: #999999" class="texto_valores" disabled="disabled"/>												
<?php												
		}
?>												
											</td>
											<td style="width:10%"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones">TCP/UDP</span></td></tr>
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
											<td style="width:16%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param12']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param13']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param14']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:16%" align="center">
												<select name="TCH" id="TCH" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="IPX" id="IPX" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="IPY" id="IPY" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:25%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param15']?></span>
											</td>
											<td style="width:25%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param16']?></span>
											</td>
											<td style="width:25%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param17']?></span>
											</td>
											<td style="width:25%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param18']?></span>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:25%" align="center">
												<input type="text" name="PGU" id="PGU" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td style="width:25%" align="center">
												<input type="text" name="PRY" id="PRY" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td style="width:25%" align="center">
												<input type="text" name="PGT" id="PGT" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
											<td style="width:25%" align="center">
												<input type="text" name="PRX" id="PRX" style="width:65px;text-align:center" class="texto_valores" maxlength="5"/>
											</td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left" colspan="6"><span class="texto_secciones">GSM/GPRS</span></td></tr>
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
											<td style="width:16%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param19']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param20']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param21']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:16%" align="center">
												<select name="GSH" id="GSH" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="GSX" id="GSX" style="width:100px;text-align:center" class="texto_valores" maxlength="11"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="GSY" id="GSY" style="width:100px;text-align:center" class="texto_valores" maxlength="11"/>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:16%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param22']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param23']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param24']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:16%" align="center">
												<select name="GPH" id="GPH" style="width:50px;text-align:center" class="texto_valores"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="IPW" id="IPW" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:38%" align="center">
												<input type="text" name="IPZ" id="IPZ" style="width:130px;text-align:center" class="texto_valores" maxlength="15"/>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_3' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param25']?> 1</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:18%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>	
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="width:100%">				
											<td style="width:18%" colspan="6" align="center">
												<input type="text" name="SN1" id="SN1" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="T1M" id="T1M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="P1X" id="P1X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P1X_unit" class="texto_valores"></span>
											</td>
											<td style="width:38%" align="center" rowspan="3">
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
															<input type="checkbox" name="MAXS1T" id="MAXS1T" style="width:20px;text-align:center" onclick="OnClickMAXS1()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXS1O1" id="MAXS1O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXS1O2" id="MAXS1O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXS1O3" id="MAXS1O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINS1T" id="MINS1T" style="width:20px;text-align:center" onclick="OnClickMINS1()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINS1O1" id="MINS1O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINS1O2" id="MINS1O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINS1O3" id="MINS1O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:20%" align="center" colspan="6">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>																																																				
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
										</tr>
										<tr style="width:100%">	
											<td style="width:20%" align="center" colspan="6"> 
												<select name="TS1" id="TS1" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(1)"/>
											</td>											
											<td style="width:20%" align="center">
												<input type="text" name="T1S" id="T1S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="P1N" id="P1N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P1N_unit" class="texto_valores"></span>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente1" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset1" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad1" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>	
											<td colspan="3" align="center">											
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M1X" id="M1X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M1N" id="M1N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U1D" id="U1D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>	
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH1" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>												
											</td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH1" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
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
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param25']?> 2</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:18%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>	
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:18%" colspan="6" align="center">
												<input type="text" name="SN2" id="SN2" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="T2M" id="T2M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="P2X" id="P2X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P2X_unit" class="texto_valores"></span>
											</td>
											<td style="width:38%" align="center" rowspan="3">
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
															<input type="checkbox" name="MAXS2T" id="MAXS2T" style="width:20px;text-align:center" onclick="OnClickMAXS2()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXS2O1" id="MAXS2O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXS2O2" id="MAXS2O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXS2O3" id="MAXS2O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINS2T" id="MINS2T" style="width:20px;text-align:center" onclick="OnClickMINS2()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINS2O1" id="MINS2O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINS2O2" id="MINS2O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINS2O3" id="MINS2O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:20%" align="center"  colspan="6">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>									
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:38%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:20%" align="center"  colspan="6">
												<select name="TS2" id="TS2" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(2)"/>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="T2S" id="T2S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>											
											<td style="width:20%" align="center">
												<input type="text" name="P2N" id="P2N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P2N_unit" class="texto_valores"></span>
											</td>											
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente2" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset2" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad2" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>		
											<td colspan="3" align="center">
										</tr>
										<tr style="width:100%;height:10px">
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M2X" id="M2X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M2N" id="M2N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U2D" id="U2D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>							
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH2" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH2" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="9"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_4' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param25']?> 3</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:18%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>	
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:38%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param29']?></span>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:18%" colspan="6" align="center">
												<input type="text" name="SN3" id="SN3" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="T3M" id="T3M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="P3X" id="P3X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P3X_unit" class="texto_valores"></span>
											</td>
											<td style="width:38%" align="center" rowspan="3">
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
															<input type="checkbox" name="MAXS3T" id="MAXS3T" style="width:20px;text-align:center" onclick="OnClickMAXS3()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param30']?></span>
														</td>
														<td>
															<input type="checkbox" name="MAXS3O1" id="MAXS3O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td>														
															<input type="checkbox" name="MAXS3O2" id="MAXS3O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder">
															<input type="checkbox" name="MAXS3O3" id="MAXS3O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
													<tr>
														<td class="left_tborder bottom_tborder">
															<input type="checkbox" name="MINS3T" id="MINS3T" style="width:20px;text-align:center" onclick="OnClickMINS3()"/>
															<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param31']?></span>
														</td>
														<td class="bottom_tborder">
															<input type="checkbox" name="MINS3O1" id="MINS3O1" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="bottom_tborder">														
															<input type="checkbox" name="MINS3O2" id="MINS3O2" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
														<td class="right_tborder bottom_tborder">
															<input type="checkbox" name="MINS3O3" id="MINS3O3" style="width:20px;text-align:center" disabled="disabled"/>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr style="width:100%">
											<td style="width:20%" align="center"  colspan="6">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>										
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:38%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:20%" align="center"  colspan="6">
												<select name="TS3" id="TS3" style="width:150px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(3)"/>
											</td>				
											<td style="width:20%" align="center">
												<input type="text" name="T3S" id="T3S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:20%" align="center">
												<input type="text" name="P3N" id="P3N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P3N_unit" class="texto_valores"></span>
											</td>
											<td style="width:38%"></td>
										</tr>
										<tr style="width:100%">
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente3" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset3" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>	
											<td style="width:8%" align="center" id="unidad3" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>	
											<td colspan="3"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M3X" id="M3X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M3N" id="M3N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U3D" id="U3D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td colspan="2" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH3" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:20%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH3" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:38%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="9"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_5' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 4</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN4" id="SN4" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS4" id="TS4" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(4)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T4M" id="T4M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P4X" id="P4X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P4X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH4" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente4" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset4" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad4" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH4" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M4X" id="M4X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M4N" id="M4N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U4D" id="U4D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T4S" id="T4S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P4N" id="P4N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P4N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
							</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 5</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN5" id="SN5" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS5" id="TS5" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(5)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T5M" id="T5M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P5X" id="P5X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P5X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH5" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente5" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset5" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad5" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH5" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M5X" id="M5X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M5N" id="M5N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U5D" id="U5D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T5S" id="T5S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P5N" id="P5N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P5N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
							</div>
					</div>
					<div id='params_gw_6' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 6</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN6" id="SN6" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS6" id="TS6" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(6)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T6M" id="T6M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P6X" id="P6X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P6X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH6" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente6" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset6" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad6" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH6" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M6X" id="M6X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M6N" id="M6N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U6D" id="U6D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T6S" id="T6S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P6N" id="P6N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P6N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 7</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN7" id="SN7" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS7" id="TS7" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(7)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T7M" id="T7M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P7X" id="P7X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P7X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH7" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente7" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset7" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad7" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH7" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M7X" id="M7X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M7N" id="M7N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U7D" id="U7D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T7S" id="T7S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P7N" id="P7N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P7N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>
					<div id='params_gw_7' >
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 8</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN8" id="SN8" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS8" id="TS8" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(8)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T8M" id="T8M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P8X" id="P8X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P8X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH8" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente8" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset8" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad8" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH8" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M8X" id="M8X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M8N" id="M8N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U8D" id="U8D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T8S" id="T8S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P8N" id="P8N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P8N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
						<table border="0" width="98%" cellpadding="0" cellspacing="0">
							<tr><td><br/></td></tr>
							<tr><td align="left"><span class="texto_secciones"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general102']?> 9</span></td></tr>
						</table>
						<div class="rounded2-big-box">
							    <div class="top2-left-corner"><div class="top2-left-inside">&bull;</div></div>
							    <div class="bottom2-left-corner"><div class="bottom2-left-inside">&bull;</div></div>
							    <div class="top2-right-corner"><div class="top2-right-inside">&bull;</div></div>
							    <div class="bottom2-right-corner"><div class="bottom2-right-inside">&bull;</div></div>
								<div class="box2-contents">
									<table border="0" width="98%" cellpadding="0" cellspacing="0" >
										<tr style="width:100%">
											<td style="width:30%" align="center" colspan="2" >
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
											</td>
											<td style="width:30%" colspan="6" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param26']?></span>
											</td>			
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param27']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param28']?></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%">			
											<td style="width:30%" align="center" colspan="2" >
												<input type="text" name="SN9" id="SN9" style="width:120px;text-align:center;" class="texto_valores" maxlength="10"/>
											</td>	
											<td style="width:30%" align="center"  colspan="6">
												<select name="TS9" id="TS9" style="width:170px;text-align:center" class="texto_valores" onchange="vActualizar_Unidades(9)"/>
											</td>		
											<td style="width:18%" align="center">
												<input type="text" name="T9M" id="T9M" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P9X" id="P9X" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P9X_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
										<tr style="width:100%;height:10px">
											<td colspan="15"></td>
										</tr>
										<tr style="width:100%">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param34']?></span>
												<select id="EH9" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="pendiente9" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_pendiente']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="offset9" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['event_offset']?></span>
											</td>	
											<td style="width:2%"></td>
											<td style="width:8%" align="center" id="unidad9" class="escondido">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general142']?></span>
											</td>			
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param32']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param33']?></span>
											</td>
											<td style="width:2%"></td>	
											
										</tr>
										<tr style="width:100%;height:10px">
											<td align="right">
												<span style=align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param35']?></span>
												<select id="SH9" style="margin:0px 0 0px 0;text-align:center" class="texto_valores">
													<option>OFF</option>
													<option>ON</option>
												</select>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M9X" id="M9X" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<input type="text" name="M9N" id="M9N" style="width:30px;text-align:center" class="texto_valores escondido" maxlength="5"/>
											</td>					
											<td style="width:2%"></td>
											<td style="width:8%" align="center">
												<select name="U9D" id="U9D" style="width:60px;text-align:center" class="texto_valores escondido" maxlength="2"/>
											</td>				
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="T9S" id="T9S" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general136']?></span>
											</td>
											<td style="width:2%"></td>
											<td style="width:18%" align="center">
												<input type="text" name="P9N" id="P9N" style="width:50px;text-align:center" class="texto_valores" maxlength="5"/>
												<span id="P9N_unit" class="texto_valores"></span>
											</td>
											<td style="width:2%"></td>
										</tr>
									</table>
								</div>
						</div>
					</div>	
					<script>
						tabbar = new dhtmlXTabBar("a_tabbar", "top");
						tabbar.setSkin('dark_blue');
						tabbar.setImagePath("codebase/imgs/");
						AnchoTabAux=document.getElementById('a_tabbar').offsetWidth/10;
						tabbar.addTab("a1", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general104']?>", 0.8*AnchoTabAux);
						tabbar.addTab("a2", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general105']?>", 1.6*AnchoTabAux);
						tabbar.addTab("a3", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general106']?> I", 1.8*AnchoTabAux);
						tabbar.addTab("a4", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general106']?> II", 1.8*AnchoTabAux);
						tabbar.addTab("a5", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general107']?> I", 1.2*AnchoTabAux);
						tabbar.addTab("a6", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general107']?> II", 1.2*AnchoTabAux);
						tabbar.addTab("a7", "<?php echo $idiomas[$_SESSION['opcion_idioma']]['general107']?> III", 1.4*AnchoTabAux);
						tabbar.setContent("a1", "params_gw_1");
						tabbar.setContent("a2", "params_gw_2");
						tabbar.setContent("a3", "params_gw_3");
						tabbar.setContent("a4", "params_gw_4");
						tabbar.setContent("a5", "params_gw_5");
						tabbar.setContent("a6", "params_gw_6");
						tabbar.setContent("a7", "params_gw_7");
						tabbar.setTabActive("a1");
					</script>
				</div>
			</td>
		</tr>
	</table>