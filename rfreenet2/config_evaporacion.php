<?session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_db.inc'
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
	<script type="text/javascript" src="js/funciones_tooltip.js?time=<?php echo(filemtime("js/funciones_tooltip.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>	
<script>
		function vComprobarETCero(check_habilitado)
		{
			if(document.getElementById(check_habilitado).checked)
			{
				$('#imagen_espera_modDB').attr("class", 'mostrado');
				url = "comprueba_evaporacion.php?instalacion_id="+document.getElementById("instalacion_id").value+"&gw_id="+document.getElementById("gw_id"+check_habilitado.substring(6)).value;
				xmlHttpDB= GetXmlHttpObject();
				xmlHttpDB.open("POST",url,true);
				xmlHttpDB.onreadystatechange = function() 
				{
					if (xmlHttpDB.readyState==4)
					{
						$('#imagen_espera_modDB').attr("class", 'escondido');
						if(xmlHttpDB.responseText.length > 0)
						{
							alert(xmlHttpDB.responseText);
							document.getElementById(check_habilitado).checked = false;
						}
					}
				}
				xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xmlHttpDB.send(null);
			}
			return;		
		}
		function vActualizarTodo()
		{
			 var Formulario = document.getElementById("formulario_datos");
	         var longitudFormulario = Formulario.elements.length;
	         var cadenaFormulario = ""
	         var sepCampos
	         sepCampos = ""
	         for (var i=0; i <= Formulario.elements.length-1;i++) 
	         {
	         	if(Formulario.elements[i].type=='checkbox')
	         	{
	         		if(Formulario.elements[i].checked)
	         		{
	         			cadenaFormulario += sepCampos+Formulario.elements[i].name+'=on';
	         		}
	         		else
	         		{
	         			cadenaFormulario += sepCampos+Formulario.elements[i].name+'=off';
	         		}
	         	}
	          	else{
	         		cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);	         		
	          	}
	          	sepCampos="&";
			}
			$('#imagen_espera_modDB').attr("class", 'mostrado');
			url = "actualiza_evaporacion.php";
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange = function() 
			{
				if (xmlHttpDB.readyState==4)
				{
					$('#imagen_espera_modDB').attr("class", 'escondido');
					if(xmlHttpDB.responseText.length > 0)
					{
						alert(xmlHttpDB.responseText);
					}
					else
					{
						alert("Actualizado correctamente");
					}
				}
			}
			xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpDB.send(cadenaFormulario);
			return;			
		}
</script>
</head>

<body>
	<form action="actualiza_evaporacion.php" method="POST" id="formulario_datos">
		<div id="div_vista_general" align="center">
			<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general314'].' '.sObtener_Nombre_Instalación($_GET['instalacion_id'], $_SESSION['cliente_db'])?></span>
		</div>	
		<div id="div_vista_general" style="overflow:visible;" >
			<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general11']?></span>
			<div id="contenedor_sensores" class='xstooltip' style="position: absolute;"></div>
		</div>						
		<div id="carga_vista_gw">
			<? include "carga_et_potencial.php"; ?>
			
		</div>
		<table width="100%">	
			<tr>
				<td align="center" style="width:100%">
					<input type="hidden" value="<?=$_GET['instalacion_id'];?>" id="instalacion_id" name="instalacion_id">
					<input type="hidden" value="<?=$_SESSION['cliente_db'];?>" id="cliente_db" name="cliente_db">
					<img id="imagen_espera_modDB" src="images/wait_circle.gif" class="escondido"/>
					<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general51']?>" id="Boton_Actualizar" onClick="vActualizarTodo()" style="text-align:center;width:90px" class="boton_fino"/>
				</td>
			</tr>	
		</table>
	</form>					
</body>
</html>