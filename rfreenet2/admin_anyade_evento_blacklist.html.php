<?php session_start(); //continuamos session o la creamos si no hay
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
		function vAdd_evento()
		{
			var url;
			if (document.getElementById("comboSuscriptoresBL").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_gw32'));
			}
			else if (document.getElementById("comboMACsBL").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_nodo18'));
			}
			else if (document.getElementById("comboEventosBL").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX('error_user1'));
			}
			else
			{
				xmlHttpuser = GetXmlHttpObject();
				url = "evento_blacklist_anyadir.php?blacklist_gateway=" + document.getElementById("comboSuscriptoresBL").value + "&blacklist_mac=" + document.getElementById("comboMACsBL").value + "&blacklist_evento=" + document.getElementById("comboEventosBL").options[document.getElementById("comboEventosBL").selectedIndex].id;
				xmlHttpuser.onreadystatechange=function()
				{
					if (xmlHttpuser.readyState==4)
					{
						alert(xmlHttpuser.responseText);
						OnVolverEventos();
					}
				}
				xmlHttpuser.open("GET",url,true);
				xmlHttpuser.send(null);
			}
		}
		function OnVolverEventos()
		{
			window.parent.rellenar_div_principal(63,"");
			window.parent.rellenar_div_submenu(53,"");
		}
		function vActualizarMACs()
		{
			var url;
			xmlHttpuser = GetXmlHttpObject();
			url = "carga_MACs_Suscriptor.php?gw_id=" + document.getElementById("comboSuscriptoresBL").value;
			xmlHttpuser.onreadystatechange=function()
			{
				if (xmlHttpuser.readyState==4)
				{
					document.getElementById("comboMACsBL").innerHTML = xmlHttpuser.responseText;
				}
			}
			xmlHttpuser.open("GET",url,true);
			xmlHttpuser.send(null);
		}
		function onEvento()
		{
			if (document.getElementById("comboEventosBL").selectedIndex > -1)
			{
				switch (document.getElementById("comboEventosBL").options[document.getElementById("comboEventosBL").selectedIndex].id)
				{
					case '000':
					case '001':
					case '002':
					case '003':
					case '004':
					case '005':
					case '016':
					case '600':
					case '601':
					case '602':
					case '603':
					case '604':
					case '605':
					case '606':
					case '607':
					case '608':
					case '625':
					case '626':
					case '627':
					case '628':
					case '629':
					case '630':
					case '631':
					case '632':
					case '633':
					case '650':
					case '651':
					case '652':
					case '653':
					case '654':
					case '655':
					case '656':
					case '657':
					case '658':
					case '675':
					case '676':
					case '677':
					case '678':
					case '679':
					case '680':
					case '681':
					case '682':
					case '683':
					case '700':
					case '701':
					case '702':
					case '703':
					case '704':
					case '705':
					case '706':
					case '707':
					case '708':
					case '805':
					case '806': 
						document.getElementById("comboMACsBL").selectedIndex = 0;
						document.getElementById("comboMACsBL").disabled="disabled";
						break;
	
					default:
						document.getElementById("comboMACsBL").disabled="";
						break;
				}
			}
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
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general29']?></span>
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
							<td colspan="3" class="bottom_tborder"></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<span class="texto_parametros" ><?php echo $idiomas[$_SESSION['opcion_idioma']]['general20']?></span>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<select name="suscriptores" id="comboSuscriptoresBL" style="width:80px;margin:0px 0 5px 0;" onchange="vActualizarMACs()">
							     	<?
							     	include 'inc/funciones_indice.inc';
									echo RellenarListaSuscriptores();
									?>
					            </select>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general30']?></span>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<select id="comboMACsBL"></select>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general31']?></span>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td style="width:5%" class="left_tborder"><br/></td>
							<td style="width:90%" align="center">
								<select name="eventosBL" id="comboEventosBL" style="width:200px;margin:0px 0 5px 0;" onchange="onEvento()">
							     	<?
									echo RellenarListaEventos(1);
									?>
					            </select>
							</td>
							<td style="width:5%" class="right_tborder"><br/></td>
						</tr>
						<tr style="width:100%">
							<td colspan="3" class="left_tborder right_tborder bottom_tborder"><br/></td>
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
				<input type="button" name="Volver" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general49']?>" id="boton_add" onclick="OnVolverEventos()" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>
			<td style="width:40%" align="center">
				<input type="button" name="Añadir" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general50']?>" id="boton_add" onclick="vAdd_evento();" class="boton_fino_corto"/>
			</td>
			<td style="width:5%"><br/></td>			
		</tr>
	</table>
<script type="text/javascript">
	if (document.getElementById("comboSuscriptoresBL").length > 0)
	{
		document.getElementById("comboSuscriptoresBL").selectedIndex=0;
	}	
	vActualizarMACs();
	onEvento();
</script>
</body>
</html>