<?php
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';
include 'inc/funciones_indice.inc';

$instalacion = $_GET["instalacion_id"];
$gw_id = $_GET["objeto_id"];

$num_filas_tabla=10;
$ancho_1 = '3%';
$ancho_2 = '4%';
$ancho_3 = '4%';
$ancho_4 = '19%';
$ancho_5 = '17%';
$ancho_6 = '16%';
$ancho_7 = '19%';
$ancho_8 = '19%';
$alto='40px';

$anchodispositivo='140px';
$anchosensor='130px';
$anchoevento='115px';

$contenido_devices_in = RellenarListaDispositivosEntradaTelemando($instalacion, $gw_id);
$contenido_devices_out = RellenarListaDispositivosSalidaTelemando($instalacion, $gw_id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_telemando.js?time=<?php echo(filemtime("js/funciones_telemando.js"));?>"></script>
	<script type="text/javascript">
		var caVGWHW;
		var caVGWSW;
		var caGWTIPO;
		function vLeerTM()
		{
			var caComando;
			var url;	
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_telemando;?>))
			{
				$('#imagen_espera').attr("class", 'mostrado');
				for (iCont=0;iCont<10;iCont++)
				{
					caComando = "Q<?php echo $gw_id;?>0"+iCont;		
					url = "enviar_comando_offline.php?gw_id=<?php echo $gw_id;?>&nodo_ip=000&comando="+caComando+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
					xmlHttpgrReadNode= GetXmlHttpObject();
					xmlHttpgrReadNode.open("GET",url,false);
					xmlHttpgrReadNode.send(null);
					$('#imagen_espera').attr("class", 'escondido');					
				}
				alert(iObtener_Cadena_AJAX('general361'));
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_gw81'));
			}
		}
		function vGuardarTM(sGWID)
		{
			var sCadenaParams;
			var iContador;
			var url;
			var sHabs;
			if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_telemando;?>))
			{
				$('#imagen_espera_mod').attr("class", 'mostrado');
				var rn= Math.floor(Math.random()*10000);
				sHabs='';
				for(iContador=1;iContador<11;iContador++)
				{
					if ((document.getElementById("on"+iContador).checked == true) || (document.getElementById("off"+iContador).checked == true))
					{
						if ((document.getElementById("devin"+iContador).selectedIndex >= 0)
							&& (document.getElementById("in"+iContador).selectedIndex >= 0)
							&& (document.getElementById("evento"+iContador).selectedIndex >= 0)
							&& (document.getElementById("out"+iContador).selectedIndex >= 0)
							&& (document.getElementById("devout"+iContador).selectedIndex >= 0))
						{
							sCadenaParams = 'G'+sGWID+'IDT'+('0000'+rn).slice(-4)+'0'+(iContador-1);
						    sCadenaParams += document.getElementById("devin"+iContador).options[document.getElementById("devin"+iContador).selectedIndex].value;
						    sCadenaParams += document.getElementById("evento"+iContador).options[document.getElementById("evento"+iContador).selectedIndex].value;
						    sCadenaParams += "O"+document.getElementById("out"+iContador).options[document.getElementById("out"+iContador).selectedIndex].value;
						    if (document.getElementById("on"+iContador).checked == true)
						    {
						    	sCadenaParams += "1";
						    }
						    else if (document.getElementById("off"+iContador).checked == true)
						    {
						    	sCadenaParams += "0";
						    }
						    sCadenaParams += document.getElementById("devout"+iContador).options[document.getElementById("devout"+iContador).selectedIndex].value;
						    url = "enviar_comando_offline.php?gw_id="+sGWID+"&nodo_ip=000&comando="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
							xmlHttpgrRead= GetXmlHttpObject();
							xmlHttpgrRead.open("GET",url,false);
							xmlHttpgrRead.send(null);
					   	}
					   	else
						{
							alert('Fallo de configuración en TM0'+iContador);
							break;
						}
						sHabs+="1";
					}
					else
					{
						sHabs+="0";
					}
					rn++;
				}
				sCadenaParams = 'F'+sGWID+'IDT'+('0000'+rn+1).slice(-4)+sHabs;
				url = "enviar_comando_offline.php?gw_id="+sGWID+"&nodo_ip=000&comando="+sCadenaParams+"&cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
				xmlHttpgrRead= GetXmlHttpObject();
				xmlHttpgrRead.open("GET",url,false);
				xmlHttpgrRead.send(null);
				$('#imagen_espera_mod').attr("class", 'escondido');
				alert(iObtener_Cadena_AJAX('general360'));
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_gw81'));
			}
		}
	</script>
</head>
<body>
	<div id='divtelemando'>
	<table border="1" cellpadding="0" cellspacing="0" width="100%" id="tabula_datos">
		<tr>
			<td align="center" width="<?php echo $ancho_1;?>" class="RFNETBold"></td>
			<td align="center" colspan="2" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general23'];?></td>
			<td align="center" colspan="2" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general373'];?></td>
			<td align="center" width="<?php echo $ancho_6;?>" rowspan="2" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general31'];?></td>
			<td align="center" colspan="2" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24'];?></td>
		</tr>
		<tr>
			<td align="center" width=<?php echo $ancho_1;?>" class="RFNETBold">ID</td>
			<td align="center" width="<?php echo $ancho_2;?>" class="RFNETBold">ON</td>
			<td align="center" width="<?php echo $ancho_3;?>" class="RFNETBold">OFF</td>
			<td align="center" width="<?php echo $ancho_4;?>" class="RFNETBold">GW / <?php echo $idiomas[$_SESSION['opcion_idioma']]['general21'];?></td>
			<td align="center" width="<?php echo $ancho_5;?>" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general373'];?></td>
			<td align="center" width="<?php echo $ancho_7;?>" class="RFNETBold">GW / <?php echo $idiomas[$_SESSION['opcion_idioma']]['general21'];?></td>
			<td align="center" width="<?php echo $ancho_8;?>" class="RFNETBold"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general24'];?></td>
		</tr>
<?php
	for ($i=1;$i<($num_filas_tabla+1);$i++)
	{
		if ((($i)%2) == 0)
		{
			$tipofila = "tipo_fila_1";
		}
		else
		{
			$tipofila = "tipo_fila_2";
		}
?>
		<tr class="<?php echo $tipofila;?>" style="height:<?php echo $alto;?>">
			<td align="center" class="RFNETBold"><?php echo $i;?></td>
			<td align="center">
				<input type="checkbox" name="on<?php echo $i;?>" id="on<?php echo $i;?>" class="texto_valores" onchange="onTickEstado(this.checked,'off',<?php echo $i;?>)"/>
			</td>
			<td align="center">
				<input type="checkbox" name="off<?php echo $i;?>" id="off<?php echo $i;?>" class="texto_valores" onchange="onTickEstado(this.checked,'on',<?php echo $i;?>)"/>
			</td>
			<td align="center">
				<select id="devin<?php echo $i;?>" name="devin<?php echo $i;?>" style="width:<?php echo $anchodispositivo;?>;text-align:center" onchange="onDevInChange(<?php echo $i;?>,'<?php echo $gw_id;?>')">
<?php
				echo $contenido_devices_in;
?>
				</select>
			</td>
			<td align="center">
				<select id="in<?php echo $i;?>" name="in<?php echo $i;?>" style="width:<?php echo $anchosensor;?>;text-align:center" onchange="onInChange(<?php echo $i;?>,'<?php echo $gw_id;?>')"></select>
			</td>
			<td align="center">
				<select id="evento<?php echo $i;?>" name="evento<?php echo $i;?>" style="width:<?php echo $anchoevento;?>;text-align:center"></select>
			</td>
			<td align="center">
				<select id="devout<?php echo $i;?>" name="devout<?php echo $i;?>" style="width:<?php echo $anchodispositivo;?>;text-align:center" onchange="onDevOutChange(<?php echo $i;?>,'<?php echo $gw_id;?>')">
<?php
					echo $contenido_devices_out;
?>
				</select>
			</td>
			<td align="center">
				<select id="out<?php echo $i;?>" name="out<?php echo $i;?>" style="width:<?php echo $anchosensor;?>;text-align:center"></select>
			</td>
		</tr>
<?php		
	}
?>
	<table width="100%" border="0">
		<tr>
			<td style="height:25px" colspan="5"></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td style="width:35%" align="center">
				<input type="button" onclick="vLeerTM()" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general195']?>" class="boton_fino_medio" id="boton_leerTM"/>
				<img id="imagen_espera_leer" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:10%"></td>
			<td style="width:35%" align="center">
				<input type="button" onclick="vGuardarTM('<?php echo $gw_id;?>')" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general197']?>" class="boton_fino_medio" id="boton_guardarTM"/>
				<img id="imagen_espera_mod" src="images/wait_circle.gif" class="escondido"/>
			</td>
			<td style="width:10%"></td>
		</tr>
	</table>
	</div>
	<script>
		vCargar_Versiones_GW_DB("<?php echo $gw_id;?>");
		if ((caGWTIPO == <?php include 'inc/datos_db.inc';echo $tipo_gw;?>) && (caVGWSW >= <?php include 'inc/datos_db.inc';echo $version_telemando;?>))
		{
			vLeerTMDB("<?php echo $gw_id;?>");
		}
		else
		{
			$('#divtelemando').empty();
			alert(iObtener_Cadena_AJAX('error_gw81'));
		}
	</script>
</body>
</html>
