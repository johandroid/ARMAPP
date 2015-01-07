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
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		function onChangeClientes()
		{
			document.getElementById('comboPerfil').length = 0;
			switch(document.getElementById('comboSubClientes').selectedIndex)
			{
				case 0:
					insertarOptionCombo('comboPerfil',"PSE0",iObtener_Cadena_AJAX('user_superadmin'));
					break;
					
				default:
		        	insertarOptionCombo('comboPerfil',"PSE1",iObtener_Cadena_AJAX('user_admin'));
		        	insertarOptionCombo('comboPerfil',"PSE2",iObtener_Cadena_AJAX('user_oper'));
		        	insertarOptionCombo('comboPerfil',"PSE3",iObtener_Cadena_AJAX('user_visit'));
					break;				
			}
			document.getElementById('comboPerfil').selectedIndex = 0;
		}
		function vSeleccionar_Cliente(sClienteCod)
		{
			for (var iIndice=0; iIndice < document.getElementById("comboSubClientes").length; iIndice++)
			{
				if (document.getElementById("comboSubClientes").options[iIndice].id == sClienteCod)
				{
					document.getElementById("comboSubClientes").selectedIndex=iIndice;
					return;
				}
			}
			document.getElementById("comboSubClientes").selectedIndex=-1;
			return;
		}
		function vRellenenar_Usuario()
		{
			document.getElementById("nombre_user").value=document.getElementById("user_nombre").value;
			vSeleccionar_Cliente(document.getElementById("user_cliente_id").value);
			onChangeClientes();
			switch (document.getElementById('comboSubClientes').selectedIndex)
			{
				case 0:
					document.getElementById("comboPerfil").selectedIndex=document.getElementById("user_perfil").value;
					break;
					
				default:
					document.getElementById("comboPerfil").selectedIndex=document.getElementById("user_perfil").value-1;
					break;				
			}	
			document.getElementById("usuario_email").value=document.getElementById("user_email").value;
		}
		function vActualizar_user()
		{
			var iPerfilAnyade;
			var url;
			if (document.getElementById("nombre_user").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_user2'));
			}
			else if (iComprobar_Nombre(document.getElementById('nombre_user').value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_user3'));
			}
			else if (document.getElementById("usuario_email").value=="")
			{
				alert(iObtener_Cadena_AJAX('error_user4'));
			}
			else if (iComprobar_Email(document.getElementById("usuario_email").value) == -1)
			{
				alert(iObtener_Cadena_AJAX('error_user5'));
			}
			else if (document.getElementById("comboPerfil").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_user1'));
			}
			else if (document.getElementById("comboSubClientes").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_user6'));
			}
			else if (document.getElementById("nombre_pw1").value != document.getElementById("nombre_pw2").value)
			{
				alert(iObtener_Cadena_AJAX('error_user7'));
			}
			else
			{
				if (confirm(iObtener_Cadena_AJAX('user_text1')+" \r\n"+iObtener_Cadena_AJAX('general0')))
				{
					switch (document.getElementById('comboSubClientes').selectedIndex)
					{
						case 0:
							iPerfilAnyade = document.getElementById("comboPerfil").selectedIndex;
							break;
							
						default:
							iPerfilAnyade = document.getElementById("comboPerfil").selectedIndex+1;
							break;				
					}
					
					xmlHttpuser = GetXmlHttpObject();
					url = "usuario_modifica.php?usuario_id="+document.getElementById("user_id").value+"&usuario_nombre=" + document.getElementById("nombre_user").value + "&usuario_perfil=" + iPerfilAnyade + "&usuario_pw=" + document.getElementById("nombre_pw1").value + "&usuario_email=" + document.getElementById("usuario_email").value + "&cliente_id=" + document.getElementById("comboSubClientes").options[document.getElementById("comboSubClientes").selectedIndex].id;
					xmlHttpuser.onreadystatechange=function()
					{
						if (xmlHttpuser.readyState==4)
						{
							alert(xmlHttpuser.responseText);
							OnVolverUsers();
						}
					}
					xmlHttpuser.open("GET",url,true);
					xmlHttpuser.send(null);
				}
			}
		}
		function OnVolverUsers()
		{
			window.parent.rellenar_div_principal(50,"");
			window.parent.rellenar_div_submenu(50,"");
			window.parent.cargar_clientes(50);
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general54'].' '.$idiomas[$_SESSION['opcion_idioma']]['general32']?></span>
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
							<td colspan="3" align="center" valign="top">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td colspan="3"></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general1']?></span>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%"><br/></td>
										<td style="width:90%" align="center">
											<select name="clientes" id="comboSubClientes" style="width:200px;margin:0px 0 5px 0;" onchange="onChangeClientes()">
										     	<?
										     	include 'inc/funciones_indice.inc';
												echo RellenarListaClientes(1);
												?>
								            </select>
										</td>
										<td style="width:5%"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3"><br/></td>
									</tr>
								</table>
							</td>
							<td style="width:5%"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%"><br/></td>
							<td style="width:40%" align="center" valign="top">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td colspan="3" class="bottom_tborder"></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="nombre_user" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general43']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="text" id="usuario_email" style="width:150px;text-align:center" class="texto_valores" maxlength="100"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general48']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<select id="comboPerfil">
											</select>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder bottom_tborder"><br/></td>
									</tr>
								</table>
							</td>
							<td style="width:10%"></td>
							<td style="width:40%" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" >
									<tr style="width:100%">
										<td colspan="3" class="bottom_tborder"></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general33']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="password" id="nombre_pw1" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general34']?></span>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td style="width:5%" class="left_tborder"><br/></td>
										<td style="width:90%" align="center">
											<input type="password" id="nombre_pw2" style="width:150px;text-align:center" class="texto_valores" maxlength="20"/>
										</td>
										<td style="width:5%" class="right_tborder"><br/></td>
									</tr>
									<tr style="width:100%">
										<td colspan="3" class="left_tborder right_tborder bottom_tborder"><br/></td>
									</tr>
								</table>
							</td>
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
				<input type="button" name="Volver" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general49']?>" id="boton_add" onclick="OnVolverUsers()" class="boton_fino_corto"/>
			</td>			
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center">
				<input type="button" name="Confirmar" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general57']?>" id="boton_add" onclick="vActualizar_user();" class="boton_fino_largo"/>
				<input type="hidden" value="<?echo $_GET['usuario_id']?>" id="user_id"/>
				<input type="hidden" value="<?echo $_GET['usuario_nombre']?>" id="user_nombre"/>
				<input type="hidden" value="<?echo $_GET['usuario_perfil']?>" id="user_perfil"/>
				<input type="hidden" value="<?echo $_GET['usuario_email']?>" id="user_email"/>
				<input type="hidden" value="<?echo $_GET['cliente_id']?>" id="user_cliente_id"/>
			</td>
			<td style="width:5%"><br/></td>			
		</tr>
	</table>
<script type="text/javascript">	
	if (document.getElementById("comboSubClientes").length > 0)
	{
		document.getElementById("comboSubClientes").selectedIndex=0;
	}
	document.getElementById("comboPerfil").selectedIndex=2;
	vRellenenar_Usuario();
</script>
</body>
</html>