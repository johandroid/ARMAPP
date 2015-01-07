<?php session_start();
	include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
	<script  src="codebase/dhtmlxcommon.js"></script>
	<script  src="codebase/dhtmlxtabbar.js"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript">
		var xmlHttpgrReadNode;
		function Rellenar_ControlesAv_Nodo()
		{
			insertarOptionCombo("TNO","TNO0",iObtener_Cadena_AJAX('supply1'));
			insertarOptionCombo("TNO","TNO1",iObtener_Cadena_AJAX('supply2'));
			insertarOptionCombo("TNO","TNO2",iObtener_Cadena_AJAX('supply3'));
			insertarOptionCombo("TNO","TNO2",iObtener_Cadena_AJAX('supply4'));

			for (var i=1;i<10;i++)
			{
				insertarOptionCombo("IPH","IPH"+i,i);
			}

			for (var i=1;i<100;i++)
			{
				if (i<10)
				{
					insertarOptionCombo("IPL","IPL"+i,"0"+i);
				}
				else
				{
					insertarOptionCombo("IPL","IPL"+i,i);
				}
			}

			for (var i=1;i<14;i++)
			{
				insertarOptionCombo("TRX","TRX"+i,i+2);
			}

			for (var i=0;i<16;i++)
			{
				insertarOptionCombo("CAK","CAK"+i,i);
			}

			for (var i=0;i<16;i++)
			{
				insertarOptionCombo("CTX","CTX"+i,i);
			}
		}
		function OnLimpiarControlesAvNodo()
		{
			document.getElementById('NNO').value="";
			document.getElementById('TNO').selectedIndex=-1;
			document.getElementById('IPH').selectedIndex=-1;
			document.getElementById('IPL').selectedIndex=-1;
			document.getElementById('CAK').selectedIndex=-1;
			document.getElementById('CTX').selectedIndex=-1;
			document.getElementById('TTW').value="";
			document.getElementById('TQW').value="";
			document.getElementById('TRX').value="";
			document.getElementById('RET').value="";
			document.getElementById('RS1').value="";
			document.getElementById('TPR').value="";
		}
		function vParsearyRellenar_TramaAv(sParametrosNodeAv)
		{
			var sPrincipalNode;
			var sListaValores;
			var sNombreParam;
			var sValorParam;
			var iContador;
			var iSubContador;
			var sParcial;
			var sTotal;

			sPrincipalNode=parsear_xml(sParametrosNodeAv);
			if (sPrincipalNode != null)
			{
				sListaNombres=sPrincipalNode.childNodes[0].getElementsByTagName("nombre");
				sListaValores=sPrincipalNode.childNodes[0].getElementsByTagName("valor");
				for(iContador=0;iContador<sListaNombres.length;iContador++)
				{
					sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
					if (sListaValores[iContador].childNodes[0])
					{
						sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
					}
					else
					{
						sValorParam='';
					}
					if (sNombreParam.length==3)
					{
						switch (sNombreParam)
						{
							case 'CAK':
							case 'CTX':
							case 'TNO':
								document.getElementById(sNombreParam).selectedIndex=sValorParam;
								break;

							case 'IPH':
							case 'IPL':
								document.getElementById(sNombreParam).selectedIndex=sValorParam-1;
								break;

							case 'TRX':
								document.getElementById(sNombreParam).selectedIndex=sValorParam-3;
								break;

							case 'TTW':
							case 'TPR':
							case 'TQW':
							case 'NNO':
							case 'RET':
							case 'RS1':
								document.getElementById(sNombreParam).value=sValorParam;
								break;
							
							default:
								break;
						}
					}
				}
			}
		}
	</script>
</head>
<body>
<?php
	include 'inc/idiomas.inc';
	include 'inc/datos_email.inc';
	include 'inc/funciones_indice.inc';
	include 'inc/funciones_db.inc';
	if ($_POST['Enviar_Peticion'])
	{
		$usuario_mod=$_POST['usuario'];
		$nivel_privilegio=$_POST['perfil'];
		$id_cliente=$_POST['id_cliente'];

		$gw_id=$_POST['gw_id'];
		$nodo_mac=$_POST['object_id'];
		//$nodo_ip=$_POST['object_ip'];
		$texto_peticion=$_POST['Texto_Peticion'];
		$nombre_cliente = sObtener_Nombre_Cliente($id_cliente);
		//echo "<script>alert('Nombre=$nombre_cliente');</script>";
		
		$email_subject = utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general372'])." ".$nodo_mac.", ".$idiomas[$_SESSION['opcion_idioma']]['general20']." ".$gw_id." ".$idiomas[$_SESSION['opcion_idioma']]['general202']." ".$nombre_cliente." (".$id_cliente.")";
		//echo "<script>alert(\"".$email_subject."\");</script>";
		if ($TLS == 1)
		{
			$cadena_seguridad = '-S smtp-use-starttls';
		}
		//echo "<script>alert(\"".$cadena_seguridad."\");</script>";
		$Cadena_Final=$idiomas[$_SESSION['opcion_idioma']]['general201']." ".$nodo_mac.", gateway ".$gw_id." ".$idiomas[$_SESSION['opcion_idioma']]['general202']." ".$nombre_cliente." (".$id_cliente.") ".$idiomas[$_SESSION['opcion_idioma']]['general203']." ".$usuario_mod." ".$idiomas[$_SESSION['opcion_idioma']]['general204']." ".Mostrar_Nivel_Privilegios($nivel_privilegio)."<br/>".$texto_peticion;
		//echo "<script>alert(\"CADENA:".$Cadena_Final."\");</script>";
		$cadena_mail = "sendemail -f ".$email_source." -t ".$email_target." -s ".$smtp_servidor.":".$smtp_port." -xu ".$smtp_user." -xp ".$smtp_pw." -u \"".$email_subject."\" -m \"".$header_email.$Cadena_Final.$footer_email."\" > /dev/null";
		//echo "<script>alert(\"".$cadena_mail."\");</script>";
		//echo `.$cadena_mail.`;
		system($cadena_mail);
		//mail('carmelo.garcia@balmart.es','Ole','tricotrin');
		echo "<script>alert('".utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general199'])."');</script>";
	}
?>
<form name="config_av_form" action="configuracion_nodo_avanzada.html.php" method="post">
	<table border="0" width="100%">
		<tr>
			<td align="center" style="width:10%"></td>
			<td align="center" style="width:80%">
				<span><?echo $idiomas[$_SESSION['opcion_idioma']]['general200'].' '.$_POST['objeto_id']?></span>
			</td>
			<td align="center" style="width:10%"></td>
		</tr>
		<tr>
			<td align="center" style="width:10%"></td>
			<td align="center" style="width:80%">
				<div class="rounded-medium-box">
				    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
				    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
				    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
				    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
					<div class="box-contents">
						<table border="0">
							<tr>
								<td style="width:25%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general38']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param38']?></span></td>
								<td style="width:15%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param47'];?></span></td>
							</tr>
							<tr>
								<td style="width:25%" align="center"><input type="text" name="NNO" id="NNO" style="width:180px;" disabled="disabled"/></td>
								<td style="width:10%" align="center"><select id="TNO" style="margin:0px 0 5px 0;text-align:center" disabled="disabled"/></td>
								<td style="width:15%" align="center"><input type="text" name="TPR" id="TPR" style="width:80px;text-align:center" disabled="disabled"/></td>
							</tr>
						</table>
						<table border="0" width="100%">
							<tr>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param5']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param39']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param40']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param41']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param42']?></span></td>
							</tr>
							<tr>
								<td style="width:10%" align="center"><select name="IPH" id="IPH" disabled="disabled" style="text-align:center"/></td>
								<td style="width:10%" align="center"><select name="IPL" id="IPL" disabled="disabled" style="text-align:center"/></td>
								<td style="width:10%" align="center"><select name="CTX" id="CTX" disabled="disabled" style="text-align:center"/></td>
								<td style="width:10%" align="center"><select name="CAK" id="CAK" disabled="disabled" style="text-align:center"/></td>
								<td style="width:10%" align="center"><input type="text" name="TTW" id="TTW" style="width:80px;text-align:center" disabled="disabled"/></td>
							</tr>
						</table>
						<table border="0" width="100%">
							<tr>
								<td style="width:5%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param43']?></span></td>
								<td style="width:8%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param44']?></span></td>
								<td style="width:10%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param45']?></span></td>
								<td style="width:17%" align="center"><span style="align:left" class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['param46']?></span></td>
							</tr>
							<tr>
								<td style="width:5%" align="center"><input type="text" name="RS1" id="RS1" style="width:80px;text-align:center" disabled="disabled"/></td>
								<td style="width:8%" align="center"><select name="TRX" id="TRX" disabled="disabled" style="text-align:center"/></td>
								<td style="width:10%" align="center"><input type="text" name="RET" id="RET" style="width:80px;text-align:center" disabled="disabled"/></td>
								<td style="width:17%" align="center"><input type="text" name="TQW" id="TQW" style="width:80px;text-align:center" disabled="disabled"/></td>
							</tr>
						</table>
					</div>
				</div>
			</td>
			<td align="center" style="width:10%"></td>
		</tr>
		<tr>
			<td align="center" style="width:10%"></td>
			<td align="center" style="width:80%"></td>
			<td align="center" style="width:10%"></td>
		</tr>
	</table>
	    
	<table border="0" width="100%">
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center">
				<span style="align:center"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general205'];?></span>
			</td>
			<td><br/></td>
		</tr>
	</table>
	    
	<div class="rounded-big-box">
		    <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
		    <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
		    <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
		    <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
	<table border="0" width="100%">
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center"><textarea name="Texto_Peticion" id="Texto_Peticion" style="width: 95%" rows="5" value='<?php echo $_POST['Texto_Peticion'];?>?>'></textarea></td>
			<td><br/></td>
		</tr>
	</table>
	</div> 
	<table border="0" width="100%">
		<tr  style="width:100%">
			<td><br/></td>
			<td align="center">
				<table border="0" width="100%">
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%"><br/></td>
						<td style="width:40%"><br/></td>
						<td style="width:25%"><br/></td>
						<td style="width:5%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%" align="center">
								<input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $_SESSION['id_cliente']?>"/>
	         						<input type="hidden" id="perfil" name="perfil" value="<?php echo $_SESSION['perfil']?>"/>
        	 						<input type="hidden" id="usuario" name="usuario" value="<?php echo $_SESSION['usuario']?>"/>

								<input type="hidden" id="object_id" name="object_id" value="<?php echo $_POST['object_id']?>"/>
								<input type="hidden" id="object_ip" name="object_ip" value="<?php echo $_POST['object_ip']?>"/>
								<input type="hidden" id="gw_id" name="gw_id" value="<?php echo $_POST['gw_id']?>"/>				
								<input type="hidden" id="gw_tipo" name="gw_tipo" value="<?php echo $_POST['gw_tipo']?>"/>				
						 		<input type="hidden" id="xml_params" name="xml_params" value="<?php echo $_POST['xml_params'];?>"/>
								<input type="submit" name="boton_config_basica_nodo" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general181'];?>" class="boton_fino_muy_largo" onclick="config_av_form.action='configuracion_nodo.html.php';return true;"/>
						</td>
						<td style="width:40%"></td>
						<td style="width:25%" align="center">
							<input type="submit" name="Enviar_Peticion" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general55'];?>" class="boton_fino"/>
						</td>
						<td style="width:5%"><br/></td>
					</tr>
					<tr style="width:100%">
						<td style="width:5%"><br/></td>
						<td style="width:25%"></td>
						<td style="width:40%"></td>
						<td style="width:25%"></td>
						<td style="width:5%"><br/></td>
					</tr>
				</table>
			</td>
			<td><br/></td>
		</tr>
	</table>
	</form>
	<script>
		Rellenar_ControlesAv_Nodo();
		OnLimpiarControlesAvNodo();
		<?php 
		 	if ($_POST['xml_params'])
		 	{
		 ?>
		 		var xmlRXReadNode='<?php echo $_POST['xml_params'];?>';
		 		document.getElementById('xml_params').value=xmlRXReadNode;
		 		vParsearyRellenar_TramaAv(xmlRXReadNode);
		 <?php
		 	}
		 ?> 	
	</script>
</body>
</html>
