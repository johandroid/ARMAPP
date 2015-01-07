<?php session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vReasignar_Disp()
		{
			var url;
			var instalacion_id_borrada;
			var instalacion_id_nueva;
			var cliente_db_borrada;
			var instalacion_nombre_nueva;
			if (document.getElementById("comboInstalaciones2").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_instala13'));
			}
			else
			{
				instalacion_nombre_nueva = document.getElementById("comboInstalaciones2").options[document.getElementById("comboInstalaciones2").selectedIndex].innerHTML;
				cliente_db_borrada = top.document.getElementById('db_cliente').value;
				instalacion_id_borrada = document.getElementById('inst_id').value;
				instalacion_id_nueva = document.getElementById("comboInstalaciones2").options[document.getElementById("comboInstalaciones2").selectedIndex].value;
				
				if (confirm(iObtener_Cadena_AJAX('instala_text6')+" '" + document.getElementById("comboInstalaciones2").options[document.getElementById("comboInstalaciones2").selectedIndex].innerHTML + "'?"))
				{
					var url = "instalacion_reasigna_dispositivos.php?instalacion_id="+instalacion_id_borrada+"&cliente_db="+cliente_db_borrada+"&instalacion_id_nueva="+instalacion_id_nueva+"&instalacion_nombre_nueva="+instalacion_nombre_nueva+"&cliente_id="+top.document.getElementById('id_cliente').value;
					var xmlHttppipr= GetXmlHttpObject();
					xmlHttppipr.onreadystatechange=function()
					{
						if (xmlHttppipr.readyState==4)
						{
							alert(xmlHttppipr.responseText);
							OnVolverInst();
						}						
					}
					xmlHttppipr.open("GET",url,true);
					xmlHttppipr.send(null);	
				}
			}
		}
		function OnVolverInst()
		{
			window.parent.rellenar_div_principal(51,"");
			window.parent.rellenar_div_submenu(7,"");
		}
	</script>
</head>

<body>
	<table border="0" width="100%">
	<tr>
		<td align="center"><br></br></td>
	</tr>
	<tr>
		<td align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general108'].' '.$_GET['instalacion_nombre']?></span>
		</td>
	</tr>
	<tr>
		<td align="center">
			<div class="rounded-big-box">
			    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
			    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
			    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
			    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
				<div class="box-contents">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr style="width:100%">
							<td style="width:5%"><br/></td>
							<td style="width:90%" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr>
										<td style="width:25%"><br/></td>
										<td style="width:50%" class="bottom_tborder"></td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder">
											<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general7']?></span>
										</td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr>
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder bottom_tborder">
											<select name="instalaciones2" id="comboInstalaciones2" style="width:200px;margin:0px 0 5px 0;">
											<?php
												include 'inc/funciones_indice.inc';
												echo RellenarListaInstalacionesCliente($_GET['cliente_id']);
											?>
								            </select>
								            <br/>
										</td>
										<td style="width:25%"><br/></td>
									</tr>
								</table>
							</td>
							<td style="width:5%"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3"><br/></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<table border="0" width="100%">
		<tr style="width:100%">
			<td style="width:10%"><br/></td>
			<td style="width:80%" align="center">
				<input type="button" name="Confirmar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general198']?>" id="boton_add" onclick="vReasignar_Disp();" class="boton_fino_largo"/>
				<input type="hidden" value="<?php echo $_GET['instalacion_id']?>" id="inst_id"/>
				<input type="hidden" value="<?php echo $_GET['cliente_id']?>" id="cli_id"/>
			</td>
			<td style="width:10%"><br/></td>			
		</tr>
	</table>
</body>
</html>