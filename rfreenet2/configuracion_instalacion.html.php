<?php session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_indice.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function vRellenar_Instalacion()
		{
			document.getElementById("nombre_inst").value=document.getElementById("inst_nombre").value;
			for(i=0;i<document.getElementById("zona_horaria").length;i++)
			{
				
				if(document.getElementById("zona_horaria").options[i].value == document.getElementById("inst_zona").value)
				{
					document.getElementById("zona_horaria").selectedIndex=i;
				}
			}
		}
		function vActualizar_Instalacion()
		{
			var url;
			if (document.getElementById("nombre_inst").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_instala1'));
			}
			else if (iComprobar_Nombre(document.getElementById("nombre_inst").value == -1))
			{
				alert(iObtener_Cadena_AJAX('error_instala2'));
			}
			else
			{
				if (confirm(iObtener_Cadena_AJAX('instala_text1')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					xmlHttpuser = GetXmlHttpObject();
					url = "instalacion_modifica.php?instalacion_id="+document.getElementById("inst_id").value+"&instalacion_nombre=" + document.getElementById("nombre_inst").value+ "&instalacion_zona_horaria=" + document.getElementById("zona_horaria").value+"&cliente_id="+top.document.getElementById("id_cliente").value;
					if(document.getElementById("nombre_inst").value==document.getElementById("inst_nombre").value)
					{
						url += "&cambio_nombre=0";
					}
					else
					{
						url += "&cambio_nombre=1";
					}
					xmlHttpuser.onreadystatechange=function()
					{
						if (xmlHttpuser.readyState==4)
						{
							alert(xmlHttpuser.responseText);
							OnVolverInst();
						}
					}
					xmlHttpuser.open("GET",url,true);
					xmlHttpuser.send(null);
				}
			}
		}
		function OnVolverInst()
		{
			window.parent.rellenar_div_principal(51,"");
			window.parent.rellenar_div_submenu(7,"");
			window.parent.rellenar_lista_instalaciones(top.document.getElementById("db_cliente").value);
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general98']?></span>
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
							<td style="width:90%" align="center" valign="top">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td style="width:25%"><br/></td>
										<td style="width:50%" align="center" class="bottom_tborder"></td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
										</td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder">
											<input type="text" id="nombre_inst" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general329']?></span>
										</td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="right_tborder">
											
											<select id="zona_horaria" style="width:280px;text-align:center" class="texto_valores">
											<?php
												echo Rellenar_Zonas_Horarias();
											?>
											</select>
											
										</td>
										<td style="width:25%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:25%" class="right_tborder"><br/></td>
										<td style="width:50%" align="center" class="bottom_tborder right_tborder"></td>
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
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center">
				<input type="button" name="Volver" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general49']?>" id="boton_add" onclick="OnVolverInst()" class="boton_fino_corto"/>
			</td>			
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center">
				<input type="button" name="Confirmar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general57']?>" id="boton_add" onclick="vActualizar_Instalacion();" class="boton_fino_largo"/>
				<input type="hidden" value="<?echo $_GET['instalacion_id']?>" id="inst_id"/>
				<input type="hidden" value="<?echo $_GET['instalacion_nombre']?>" id="inst_nombre"/>
				<input type="hidden" value="<?echo $_GET['instalacion_zona_horaria']?>" id="inst_zona"/>
			</td>
			<td style="width:5%"><br/></td>			
		</tr>
	</table>
<script type="text/javascript">	
	vRellenar_Instalacion();
</script>
</body>
</html>