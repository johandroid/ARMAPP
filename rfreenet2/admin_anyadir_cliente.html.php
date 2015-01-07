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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">		
		function vConfirmarCliente()
		{
			var url;
			if (document.getElementById("cliente_nombre").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client1'));
			}
			else if (iComprobarNombreCliente(document.getElementById("cliente_nombre").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client2')+". \r\n"+iObtener_Cadena_AJAX('error_client2b'));
			}
			else if (document.getElementById("cliente_direccion").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client3'));
			}
			else if (iComprobar_Nombre(document.getElementById("cliente_direccion").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client4'));
			}
			else if (document.getElementById("cliente_telefono").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client5'));
			}
			else if (iComprobar_Telefono(document.getElementById("cliente_telefono").value,15) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client6'));
			}
			else if (document.getElementById("cliente_localidad").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client7'));
			}
			else if (iComprobar_Nombre(document.getElementById("cliente_localidad").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client8'));
			}
			else if (document.getElementById("cliente_provincia").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client9'));
			}
			else if (iComprobar_Nombre(document.getElementById("cliente_provincia").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client10'));
			}
			else if (document.getElementById("cliente_contacto").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client11'));
			}
			else if (iComprobar_Nombre(document.getElementById("cliente_contacto").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client12'));
			}
			else if (document.getElementById("cliente_email").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client13'));
			}
			else if (iComprobar_Email(document.getElementById("cliente_email").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client14'));
			}
			else if (document.getElementById("nombre_user").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client15'));
			}
			else if (iComprobarNombreCliente(document.getElementById("nombre_user").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_user3')+". \r\n"+iObtener_Cadena_AJAX('error_client2b'));
			}
			else if (document.getElementById("usuario_email").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_client17'));
			}
			else if (iComprobar_Email(document.getElementById("usuario_email").value) != 0)
			{
				alert(iObtener_Cadena_AJAX('error_client18'));
			}
			else if (document.getElementById("nombre_pw1").value != document.getElementById("nombre_pw2").value)
			{
				alert(iObtener_Cadena_AJAX('error_client19'));
			}
			else if ((document.getElementById("cliente_email_comercial1").value!="") && (iComprobar_Email(document.getElementById("cliente_email_comercial1").value) != 0))
			{
				alert(iObtener_Cadena_AJAX('error_client20'));
			}
			else if ((document.getElementById("cliente_email_comercial2").value!="") && (iComprobar_Email(document.getElementById("cliente_email_comercial2").value) != 0))
			{
				alert(iObtener_Cadena_AJAX('error_client21'));
			}
			else if ((document.getElementById("cliente_email_comercial1").value=="") && (document.getElementById("email1_on").checked == true))
			{
				alert(iObtener_Cadena_AJAX('error_client22'));
			}
			else if ((document.getElementById("cliente_email_comercial2").value=="") && (document.getElementById("email2_on").checked == true))
			{
				alert(iObtener_Cadena_AJAX('error_client23'));
			}
			else
			{
				if (confirm(iObtener_Cadena_AJAX('client_text1')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					xmlHttpuser = GetXmlHttpObject();
					url="cliente_anyade.php?cliente_nombre="+document.getElementById("cliente_nombre").value;
					url+="&cliente_direccion="+document.getElementById("cliente_direccion").value;
					url+="&cliente_localidad="+document.getElementById("cliente_localidad").value;
					url+="&cliente_provincia="+document.getElementById("cliente_provincia").value;
					url+="&cliente_telefono="+document.getElementById("cliente_telefono").value.replace("+", "%2B");
					url+="&cliente_contacto="+document.getElementById("cliente_contacto").value;
					url+="&cliente_email="+document.getElementById("cliente_email").value;
					url+="&cliente_web="+document.getElementById("cliente_web").value;

					url+="&usuario_nombre=" + document.getElementById("nombre_user").value;
					url+="&usuario_perfil=1";
					url+="&usuario_pw=" + document.getElementById("nombre_pw1").value;
					url+="&usuario_email=" + document.getElementById('usuario_email').value;
					
					url+="&cliente_email_comercial1=" + document.getElementById('cliente_email_comercial1').value;
					url+="&cliente_email1_idioma=" + document.getElementById('email1_idioma').options[document.getElementById('email1_idioma').selectedIndex].id;
					url+="&cliente_email_comercial2=" + document.getElementById('cliente_email_comercial2').value;
					url+="&cliente_email2_idioma=" + document.getElementById('email2_idioma').options[document.getElementById('email2_idioma').selectedIndex].id;
					if (document.getElementById("email1_on").checked == true)
					{
						url+="&cliente_email1_on=1";	
					}
					else
					{
						url+="&cliente_email1_on=0";	
					}
					if (document.getElementById("email2_on").checked == true)
					{
						url+="&cliente_email2_on=1";	
					}
					else
					{
						url+="&cliente_email2_on=0";	
					}
					
					if (document.getElementById("006").checked == true)
					{
						url+="&cliente_evento_nodo_off=1";	
					}
					else
					{
						url+="&cliente_evento_nodo_off=0";	
					}
					if (document.getElementById("016").checked == true)
					{
						url+="&cliente_evento_gw_off=1";	
					}
					else
					{
						url+="&cliente_evento_gw_off=0";	
					}
					if (document.getElementById("020").checked == true)
					{
						url+="&cliente_evento_utc_off=1";	
					}
					else
					{
						url+="&cliente_evento_utc_off=0";	
					}
					if (document.getElementById("007").checked == true)
					{
						url+="&cliente_evento_nodo_bat=1";	
					}
					else
					{
						url+="&cliente_evento_nodo_bat=0";	
					}
					if (document.getElementById("008").checked == true)
					{
						url+="&cliente_evento_gw_bat=1";	
					}
					else
					{
						url+="&cliente_evento_gw_bat=0";	
					}
					if (document.getElementById("009").checked == true)
					{
						url+="&cliente_evento_nodo_cob=1";	
					}
					else
					{
						url+="&cliente_evento_nodo_cob=0";	
					}
					
					xmlHttpuser.onreadystatechange=function()
					{
						if (xmlHttpuser.readyState==4)
						{
							alert(xmlHttpuser.responseText);
							onVolverCliente();
						}
					}
					xmlHttpuser.open("GET",url,true);
					xmlHttpuser.send(null);
				}
			}
		}
		function onVolverCliente()
		{
			window.parent.rellenar_div_submenu(52,"");
			window.parent.cargar_clientes(52);
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general52'].' '.$idiomas[$_SESSION['opcion_idioma']]['general1']?></span>
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
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general39']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general330']?> 1</span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_nombre" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_telefono" style="width:150px;text-align:center" class="texto_valores" maxlength="15"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_email_comercial1" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<select id="email1_idioma" name="email1_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center">
								<input type="checkbox" name="email1_on" id="email1_on" class="texto_valores"/>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general40']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general41']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general330']?> 2</span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['idioma_text0']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general62']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>				
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_direccion" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_contacto" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" id="cliente_email_comercial2" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<select id="email2_idioma" name="email2_idioma" style="width:100px;text-align:center">
									<?php
										echo Rellenar_Combo_Idiomas();
									?>
								</select>
							</td>
							<td style="width:2%"></td>
							<td style="width:8%" align="center">
								<input type="checkbox" name="email2_on" id="email2_on" class="texto_valores"/>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general42']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top"> 
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general43']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:52%" align="center" colspan="5">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general331']?></span>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_localidad" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center">
								<input type="text" id="cliente_email" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:52%" align="center" rowspan="4" colspan="5">
								<table border="0" width="60%" cellpadding="0" cellspacing="0">
									<?php 
										$eventos = RellenarEventosNotificacion(); 
										for ($i=0;$i<count($eventos);$i++)
										{
									?>
									<tr>
										<td width="90%">
											<span class="texto_parametros" ><?php echo $eventos[$i][1]?></span>
										</td>
										<td width="10%">
											<input type="checkbox" id="<?php echo $eventos[$i][0]?>" name="evento_<?php echo $i?>" />
										</td>
									</tr> 
									<?php } ?>
								</table>
							</td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general44']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general45']?></span>
							</td>
							<td style="width:2%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_provincia" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center" valign="top">
								<input type="text" id="cliente_web" style="width:150px;text-align:center" class="texto_valores" maxlength="50"/>
							</td>
							<td style="width:2%"></td>
							<td style="width:2%"></td>
						</tr>
						<tr>
							<td style="width:2%"><br/></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"></td>
							<td style="width:20%" align="center"><br/></td>
							<td style="width:2%"><br/></td>
							<td style="width:2%"><br/></td>
						</tr>
						</table>
						<table border="0" width="100%" cellpadding="0" cellspacing="0" >
						<tr>
							<td style="width:5%"><br/></td>
							<td colspan="4" align="center" class="bottom_tborder">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general46']?></span>
							</td>
							<td style="width:5%"><br/></td>
						</tr>
						<tr>
							<td style="width:5%"><br/></td>
							<td colspan="2" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="nombre_user" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general43']?></span>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="usuario_email" style="width:150px;text-align:center" class="texto_valores" maxlength="100"/>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
								</table>
							</td>
							<td colspan="2" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general33']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<input type="password" id="nombre_pw1" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general34']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<input type="password" id="nombre_pw2" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
								</table>
							</td>
							<td style="width:5%"><br/></td>
						</tr>
						<tr>
							<td style="width:5%"><br/></td>
							<td colspan="4" align="center" class="bottom_tborder right_tborder left_tborder"></td>
							<td style="width:5%"><br/></td>
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
				<input type="button" name="Atrás" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general49']?>" id="boton_back" onclick="onVolverCliente();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>			
			<td style="width:40%" align="center">
				<input type="button" name="Aceptar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general53']?>" id="boton_upload" onclick="vConfirmarCliente();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
		</tr>
	</table>
</body>
</html>